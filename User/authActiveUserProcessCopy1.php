<?php
declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '0'); // log errors server-side; never expose DB/RPC details
require_once __DIR__ . '/loginCheck.php';
require_once __DIR__ . '/authIncomeFunction.php';
require_once dirname(__DIR__) . '/private/crypto-config.php';

// loginCheck.php must create $con (mysqli) and session member_user_id.
header('Content-Type: application/json; charset=utf-8');

function jsonOut(bool $ok, string $message, array $extra = []): never {
    echo json_encode(array_merge(['success' => $ok, 'message' => $message], $extra));
    exit;
}
function rpc(string $method, array $params = []): array {
    $ch = curl_init(BSC_RPC_URL);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS => json_encode(['jsonrpc'=>'2.0','id'=>1,'method'=>$method,'params'=>$params]),
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_TIMEOUT => 25,
    ]);
    $raw = curl_exec($ch);
    if ($raw === false) { curl_close($ch); throw new RuntimeException('Blockchain RPC unavailable'); }
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    $data = json_decode($raw, true);
    if ($status !== 200 || !is_array($data) || isset($data['error']) || !array_key_exists('result', $data)) {
        throw new RuntimeException('Blockchain RPC returned an invalid response');
    }
    return $data['result'];
}
function hexToDecString(string $hex): string {
    $hex = strtolower(preg_replace('/^0x/', '', $hex));
    if ($hex === '') return '0';
    $dec = '0';
    foreach (str_split($hex) as $char) {
        $n = hexdec($char);
        $carry = $n;
        $out = '';
        for ($i = strlen($dec) - 1; $i >= 0; $i--) {
            $v = ((int)$dec[$i]) * 16 + $carry;
            $out = (string)($v % 10) . $out;
            $carry = intdiv($v, 10);
        }
        while ($carry > 0) { $out = (string)($carry % 10) . $out; $carry = intdiv($carry, 10); }
        $dec = ltrim($out, '0') ?: '0';
    }
    return $dec;
}
function wordAddress(string $topic): string {
    return '0x' . strtolower(substr(preg_replace('/^0x/', '', $topic), -40));
}
function wholeUsdtAmount(string $rawHex): string {
    // BSC USDT contract configured above has 18 decimals.
    $raw = hexToDecString($rawHex);
    $raw = str_pad($raw, 19, '0', STR_PAD_LEFT);
    $whole = substr($raw, 0, -18);
    $fraction = substr($raw, -18);
    if (trim($fraction, '0') !== '') throw new RuntimeException('Only whole USDT amounts are supported by this activation form');
    return ltrim($whole, '0') ?: '0';
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SESSION['member_user_id'])) {
    jsonOut(false, 'Invalid request or session expired. Please log in again.');
}
$txHash = strtolower(trim($_POST['txHash'] ?? ''));
$wallet = strtolower(trim($_POST['walletAddress'] ?? ''));
if (!preg_match('/^0x[a-f0-9]{64}$/', $txHash) || !preg_match('/^0x[a-f0-9]{40}$/', $wallet)) {
    jsonOut(false, 'Invalid transaction hash or wallet address.');
}
if (!preg_match('/^0x[a-fA-F0-9]{40}$/', USDT_VAULT_ADDRESS)) {
    jsonOut(false, 'Admin setup incomplete: deploy the vault and set its address.');
}

try {
    // Verify the chain's canonical transaction receipt, not browser-supplied amount.
    $receipt = rpc('eth_getTransactionReceipt', [$txHash]);
    if (!$receipt || strtolower($receipt['status'] ?? '') !== '0x1') {
        jsonOut(false, 'Transaction is not successful or is not mined yet.');
    }
    if (strtolower($receipt['to'] ?? '') !== strtolower(USDT_VAULT_ADDRESS)) {
        jsonOut(false, 'Transaction was not sent to the configured deposit contract.');
    }
    $tx = rpc('eth_getTransactionByHash', [$txHash]);
    if (!$tx || strtolower($tx['from'] ?? '') !== $wallet) {
        jsonOut(false, 'Connected wallet does not match transaction sender.');
    }

    $head = hexdec(rpc('eth_blockNumber'));
    $block = hexdec($receipt['blockNumber']);
    if (($head - $block + 1) < BSC_CONFIRMATIONS_REQUIRED) {
        jsonOut(false, 'Deposit found. Waiting for blockchain confirmations; please retry shortly.', [
            'confirmations' => max(0, $head - $block + 1)
        ]);
    }

    // ERC-20 Transfer(address,address,uint256) topic.
    $transferTopic = '0xddf252ad1be2c89b69c2b068fc378daa952ba7f163c4a11628f55a4df523b3ef';
    $token = strtolower(BSC_USDT_ADDRESS);
    $vault = strtolower(USDT_VAULT_ADDRESS);
    $amount = null;

    foreach (($receipt['logs'] ?? []) as $log) {
        $topics = $log['topics'] ?? [];
        if (strtolower($log['address'] ?? '') !== $token || count($topics) < 3) continue;
        if (strtolower($topics[0]) !== $transferTopic) continue;
        $from = wordAddress($topics[1]);
        $to = wordAddress($topics[2]);
        if ($from === $wallet && $to === $vault) {
            $amount = wholeUsdtAmount($log['data']);
            break;
        }
    }
    if ($amount === null || (int)$amount < ACTIVATION_MIN_USDT ||
        ((int)$amount % ACTIVATION_STEP_USDT) !== 0) {
        jsonOut(false, 'No matching USDT deposit found, or amount does not meet activation rules.');
    }

    // Resolve the logged-in member from the session only; never accept member_id from POST.
    $userId = (string)$_SESSION['member_user_id'];
    $stmt = $con->prepare("SELECT member_id, user_id, sponser_id, topupFlag, rewardRank
                           FROM meddolic_user_details
                           WHERE user_id=? AND userType=2 AND acctStatus=1 LIMIT 1");
    $stmt->bind_param('s', $userId);
    $stmt->execute();
    $member = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if (!$member) jsonOut(false, 'Invalid or inactive account.');

    $memberId = (int)$member['member_id'];
    $sponsorId = (int)$member['sponser_id'];
    $topupFlag = (int)$member['topupFlag'];
    $rewardRank = (int)$member['rewardRank'];
    $nextRank = $rewardRank + 1;

    // Read sponsor activation flags as in the existing process.
    $stmt = $con->prepare("SELECT topupFlag FROM meddolic_user_details WHERE member_id=? LIMIT 1");
    $stmt->bind_param('i', $sponsorId);
    $stmt->execute();
    $sponsor = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    $sponsorTop = (int)($sponsor['topupFlag'] ?? 0);

    // DB transaction + unique tx_hash prevents replay/double activation.
    $con->begin_transaction();

    $stmt = $con->prepare("INSERT INTO meddolic_crypto_deposits
        (member_id,wallet_address,tx_hash,token_address,contract_address,amount_usdt,block_number,created_at)
        VALUES (?,?,?,?,?,?,?,NOW())");
    $blockNumber = (string)$block;
    $stmt->bind_param('isssssi', $memberId, $wallet, $txHash, $token, $vault, $amount, $block);
    $stmt->execute(); // duplicate tx hash throws and rolls back
    $stmt->close();

    $now = date('Y-m-d H:i:s');
    if ($topupFlag === 0) {
        $stmt = $con->prepare("UPDATE meddolic_user_details SET topupFlag=1, activationDate=?, activationAmount=? WHERE member_id=?");
        $stmt->bind_param('ssi', $now, $amount, $memberId);
        $stmt->execute(); $stmt->close();

        $stmt = $con->prepare("UPDATE meddolic_user_child_ids SET topup_status=1, topup_date=? WHERE child_id=?");
        $stmt->bind_param('si', $now, $memberId);
        $stmt->execute(); $stmt->close();

        referralIncome($con, $sponsorId, $memberId, $amount, $sponsorTop, $now);
    }

    $purchaseType = 1;
    $activateBy = $memberId; // crypto self-purchase; adjust if your schema/business rule differs
    $stmt = $con->prepare("INSERT INTO meddolic_user_activation_details
        (member_id,sponser_id,investPrice,date_time,purchaseType,activate_by)
        VALUES (?,?,?,?,?,?)");
    $stmt->bind_param('iissii', $memberId, $sponsorId, $amount, $now, $purchaseType, $activateBy);
    $stmt->execute(); $stmt->close();

    $dueDate = date('Y-m-d H:i:s', strtotime($now . ' +1 day'));
    $weekday = (int)date('w');
    if ($weekday === 5) $dueDate = date('Y-m-d H:i:s', strtotime($now . ' +3 day'));
    elseif ($weekday === 6) $dueDate = date('Y-m-d H:i:s', strtotime($now . ' +2 day'));

    $status = 1;
    $stmt = $con->prepare("INSERT INTO meddolic_user_cashback_income_summary
        (member_id,packagePrice,date_time,dueDate,status) VALUES (?,?,?,?,?)");
    $stmt->bind_param('isssi', $memberId, $amount, $now, $dueDate, $status);
    $stmt->execute(); $stmt->close();

    boosterIncome($con, $sponsorId);

    if ($nextRank <= 11) {
        $stmt = $con->prepare("SELECT rewardId,rewardIncome,powerLeg,otherLeg
                               FROM meddolic_config_reward_income WHERE rewardId=? LIMIT 1");
        $stmt->bind_param('i', $nextRank);
        $stmt->execute();
        $reward = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if ($reward) {
            releaseRewardIncome($con, $memberId, $reward['rewardId'], $reward['rewardIncome'],
                                $reward['powerLeg'], $reward['otherLeg'], $now);
        }
    }
    relayRewardLoop($con, $memberId, $now);

    $con->commit();
    jsonOut(true, 'USDT deposit verified and account activated.', [
        'amount' => $amount,
        'txHash' => $txHash,
        'explorer' => 'https://bscscan.com/tx/' . $txHash
    ]);
} catch (mysqli_sql_exception $e) {
    if (isset($con) && $con instanceof mysqli) $con->rollback();
    if ((int)$e->getCode() === 1062) jsonOut(false, 'This transaction has already been used.');
    error_log('Crypto activation DB error: ' . $e->getMessage());
    jsonOut(false, 'Database processing failed. Contact support with your transaction hash.');
} catch (Throwable $e) {
    if (isset($con) && $con instanceof mysqli) $con->rollback();
    error_log('Crypto activation error: ' . $e->getMessage());
    jsonOut(false, $e->getMessage());
}
