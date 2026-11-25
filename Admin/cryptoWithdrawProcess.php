<?php
error_reporting(E_ALL ^ E_NOTICE);
include("loginCheck.php");
if (isset($_POST['addRemark'])) {
    $memberId = $_POST['memberId'];
    $id = $_POST['id'];
    $mainStatus = $_POST['mainStatus'];
    $fromDate = $_POST['fromDate'];
    $toDate = $_POST['toDate'];
    $userId = $_POST['userId'];
    $withdrawStatus = $_POST['withdrawStatus'];
    $remarks = $_POST['remarks'];
    $d = date('Y-m-d H:i:s');

    $queryUpdate = mysqli_query($con, "UPDATE meddolic_user_wallet_withdrawal SET remarks='$remarks',payment_date='$d',released='$withdrawStatus' WHERE id='$id'");

    if ($withdrawStatus == 2) {
        $queryAmount = mysqli_query($con, "SELECT amount,withdrwalIn FROM meddolic_user_wallet_withdrawal WHERE id='$id'");
        $valAmount = mysqli_fetch_assoc($queryAmount);
        $amount = $valAmount['amount'];
        $withdrwalIn = $valAmount['withdrwalIn'];
        if ($withdrwalIn == 2) {
            mysqli_query($con, "UPDATE meddolic_user_details SET wallet=wallet+'$amount' WHERE member_id='$memberId'");
        } else {
            mysqli_query($con, "UPDATE meddolic_user_details SET roiWallet=roiWallet+'$amount' WHERE member_id='$memberId'");
        }
        mysqli_query($con, "INSERT INTO meddolic_user_wallet_statement (`member_id`,`wallet_statement_id`,`deb_cr`,`amount`,`date_time`,`trn_id`) VALUES ('$memberId',11,1,'$amount','$d','$id')");
    } else if ($withdrawStatus == 3) {

        $queryAmount = mysqli_query($con, "SELECT netAmount FROM meddolic_user_wallet_withdrawal WHERE id='$id'");
        $valAmount = mysqli_fetch_assoc($queryAmount);
        $amount = floatval($valAmount['netAmount']);
        if ($amount <= 0) {
            echo "<script>
                alert('Invalid amount: $amount');
                window.top.location.href = 'walletWithdrawStatus';
                </script>";
        }
        $queryAddress = mysqli_query($con, "SELECT walletAddress FROM meddolic_user_wallet_withdrawal WHERE member_id='$memberId' AND id='$id'");
        $valAddress = mysqli_fetch_assoc($queryAddress);
        $WalletAddress = $valAddress['walletAddress'];

        // if (empty($WalletAddress) || strlen($WalletAddress) !== 42 || strpos($WalletAddress, '0x') !== 0) {
        //     echo "<script>alert('Invalid wallet address: $WalletAddress');
        //         window.top.location.href = 'walletWithdrawStatus';
        //         </script>";
        // }

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
            CURLOPT_POSTFIELDS => '{
                "withdrawals": [
                    {
                        "address": "' . $WalletAddress . '",
                        "currency": "USDTBSC",
                        "amount": ' . $amount . ',
                        "ipnCallbackUrl": "https://fundx.live/withdrawlFaradpayAPIAdmin.php"
                    }
                ]
            }',
            CURLOPT_HTTPHEADER => array(
                'x-api-key: YOUR_API_KEY_HERE',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($response, true);

        file_put_contents(
            "withdrawal_data.txt",
            print_r($data, true) . PHP_EOL,
            FILE_APPEND
        );
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";

        $withdrawal = $data['data']['withdrawals'][0];
        $Trnxid = $withdrawal['id'];
        $status = $withdrawal['status'];
        $message = $data['message'] ?? '';

        if (isset($data['status']) && $data['status'] === 'error') {
            $queryUpdate1 = mysqli_query($con, "UPDATE meddolic_user_wallet_withdrawal SET remarks='',payment_date=NULL,released=0 WHERE id='$id' ");
            if ($queryUpdate1) { ?>
                    <script>
                        alert("<?php echo addslashes($message); ?>");
                        window.top.location.href = 'walletWithdrawStatus';
                    </script>

                    <?php

                    exit;
            }
        }
        mysqli_query($con, "UPDATE  meddolic_user_wallet_withdrawal SET trnxId='$Trnxid',status='$status' WHERE id='$id'");


    }
    if ($queryUpdate) { ?>
        <script>
            alert("Action Taken Successfully!!!");
            window.top.location.href =
                'walletWithdrawStatus?user_id=<?= $userId ?>&withdrawStatus=<?= $withdrawStatus ?>&from_date=<?= $fromDate ?>&to_date=<?= $toDate ?>';
        </script>
    <?php } else { ?>
        <script>
            alert("Action Taken Successfully!!!");
            window.top.location.href =
                'walletWithdrawStatus?user_id=<?= $userId ?>&withdrawStatus=<?= $withdrawStatus ?>&from_date=<?= $fromDate ?>&to_date=<?= $toDate ?>';
        </script>
    <?php }
} ?>
<?php include("../close-connection.php"); ?>