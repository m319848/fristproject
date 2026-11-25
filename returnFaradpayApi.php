<?php
require_once("conection.php");
 $d = date("Y-m-d H:i:s");
// if (isset($_SERVER['HTTP_X_NOWPAYMENTS_SIG']) && !empty($_SERVER['HTTP_X_NOWPAYMENTS_SIG'])) {
// $recived_hmac = $_SERVER['HTTP_X_NOWPAYMENTS_SIG'];
$request_json = file_get_contents('php://input');
$request_data = json_decode($request_json, true);

// file_put_contents(
//     "deposite_data.txt",
//     print_r($request_data, true) . PHP_EOL,
//     FILE_APPEND
// );
ksort($request_data);
$sorted_request_json = json_encode($request_data);
$paymentId = $request_data['payment_id'];
$paymentStatus = $request_data['payment_status'];
$payAddress = $request_data['pay_address'];
$priceAmount = $request_data['price_amount'];
$priceCurrency = $request_data['price_currency'];
$payAmount = $request_data['pay_amount'];
$payCurrency = $request_data['pay_currency'];
$amountReceived = $request_data['amount_received'];
$returnOrderId = $request_data['order_id'];
$createdAt = $request_data['created_at'];
$updatedAt = $request_data['updated_at'];
$purchaseId = $request_data['purchase_id'];
$actually_paid = $request_data['actually_paid'];

mysqli_query($con, "UPDATE meddolic_user_invest_purchase_details SET paymentStatus='$paymentStatus',updateTime='$d' WHERE orderId='$returnOrderId' AND payAddress='$payAddress'");
if ($paymentStatus == 'expired') {
    mysqli_query($con, "UPDATE meddolic_user_invest_purchase_details SET nextPayOpen=1 WHERE orderId='$returnOrderId' AND payAddress='$payAddress'");
} else if ($paymentStatus == 'finished') {
    $queryTemp = mysqli_query($con, "SELECT tempId,memberId,loginMemberId,packagePrice,paymentStatus,actionTaken,orderId FROM meddolic_user_invest_purchase_details WHERE orderId='$returnOrderId' AND payAddress='$payAddress'");
    if ($valTemp = mysqli_fetch_assoc($queryTemp)) {
        $tempId = $valTemp['tempId'];
        $memberId = $valTemp['memberId'];
        $loginMemberId = $valTemp['loginMemberId'];
        $investmentAmount = $valTemp['packagePrice'];
        $paymentStatus = $valTemp['paymentStatus'];
        $actionTaken = $valTemp['actionTaken'];
        $orderId = $valTemp['orderId'];
        $d = date("Y-m-d H:i:s");
        $todayDate = date("Y-m-d");
        if ($actionTaken == 0 && $paymentStatus == "finished" && $payAmount <= $actually_paid) {
            mysqli_query($con, "UPDATE meddolic_user_invest_purchase_details SET actionTaken=1,nextPayOpen=1,amountReceived=$actually_paid,payAmount=$payAmount WHERE orderId='$orderId'");

            //Fund Add Code Starts//
            mysqli_query($con, "UPDATE meddolic_user_details SET fundWallet=fundWallet+'$actually_paid' WHERE member_id='$memberId'");

            mysqli_query($con, "INSERT INTO meddolic_user_wallet_statement (`member_id`,`wallet_statement_id`,`deb_cr`,`amount`,`date_time`,`trn_id`) VALUES ('$memberId',14,2,'$actually_paid','$d','$tempId')");
            //Fund Add Code Ends//
        }
    }
}
// } else {
//     $error_msg = 'No HMAC signature sent.';
// } ?>