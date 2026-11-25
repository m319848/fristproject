<?php
error_reporting(E_ALL ^ E_NOTICE);
include("loginCheck.php");

if (isset($_POST['ids']) && is_array($_POST['ids']) && isset($_POST['withdrawStatus'])) {

    $ids = $_POST['ids'];
    $withdrawStatus = (int) $_POST['withdrawStatus'];
    $remarks = mysqli_real_escape_string($con, $_POST['remarks']);
    $d = date('Y-m-d H:i:s');

    $successCount = 0;
    $failCount = 0;
    $messages = [];

    foreach ($ids as $id) {
        $id = (int) $id; // sanitize

        $queryRow = mysqli_query($con, "SELECT member_id, amount, netAmount, walletAddress,withdrwalIn FROM meddolic_user_wallet_withdrawal WHERE id='$id' AND released=0");
        $row = mysqli_fetch_assoc($queryRow);

        if (!$row) {
            $failCount++;
            $messages[] = "ID $id: Not found or already processed";
            continue;
        }

        $memberId = $row['member_id'];

        mysqli_query($con, "UPDATE meddolic_user_wallet_withdrawal SET remarks='$remarks', payment_date='$d', released='$withdrawStatus' WHERE id='$id'");

        if ($withdrawStatus == 2) {
            // Reject -> refund wallet
            $amount = $row['amount'];
            $withdrwalIn = $row['withdrwalIn'];
            if ($withdrwalIn == 2) {
                mysqli_query($con, "UPDATE meddolic_user_details SET wallet=wallet+'$amount' WHERE member_id='$memberId'");
            } else {
                mysqli_query($con, "UPDATE meddolic_user_details SET roiWallet=roiWallet+'$amount' WHERE member_id='$memberId'");
            }
            mysqli_query($con, "INSERT INTO meddolic_user_wallet_statement (`member_id`,`wallet_statement_id`,`deb_cr`,`amount`,`date_time`,`trn_id`) VALUES ('$memberId',11,1,'$amount','$d','$id')");
            $successCount++;

        } else if ($withdrawStatus == 3) {
            // Online Release -> payout API
            $amount = floatval($row['netAmount']);
            $WalletAddress = $row['walletAddress'];

            if ($amount <= 0 || empty($WalletAddress)) {
                mysqli_query($con, "UPDATE meddolic_user_wallet_withdrawal SET remarks='', payment_date=NULL, released=0 WHERE id='$id'");
                $failCount++;
                $messages[] = "ID $id: Invalid amount or wallet address";
                continue;
            }

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://gateway.faradpay.com/api/payout',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode([
                    "withdrawals" => [
                        [
                            "address" => $WalletAddress,
                            "currency" => "USDTBSC",
                            "amount" => $amount,
                            "ipnCallbackUrl" => "https://fundx.live/withdrawlFaradpayAPIAdmin.php"
                        ]
                    ]
                ]),
                CURLOPT_HTTPHEADER => array(
                    'x-api-key: 1',
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $data = json_decode($response, true);

            file_put_contents("withdrawal_data.txt", print_r($data, true) . PHP_EOL, FILE_APPEND);

            if (isset($data['status']) && $data['status'] === 'error') {
                mysqli_query($con, "UPDATE meddolic_user_wallet_withdrawal SET remarks='', payment_date=NULL, released=0 WHERE id='$id'");
                $failCount++;
                $messages[] = "ID $id: " . ($data['message'] ?? 'API error');
                continue;
            }

            $withdrawal = $data['data']['withdrawals'][0];
            $Trnxid = $withdrawal['id'];
            $status = $withdrawal['status'];

            mysqli_query($con, "UPDATE meddolic_user_wallet_withdrawal SET trnxId='$Trnxid', status='$status' WHERE id='$id'");
            $successCount++;

        } else {
            // Manual release (1)
            $successCount++;
        }
    }

    echo "$successCount successful, $failCount failed." . (count($messages) ? "\n" . implode("\n", $messages) : "");
}
?>
<?php include("../close-connection.php"); ?>