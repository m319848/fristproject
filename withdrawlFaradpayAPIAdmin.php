<?php
require_once("conection.php");
ini_set('log_errors', 1);
ini_set('error_log', 'www1.log');
$d = date('Y-m-d H:i:s');
$request_json = file_get_contents('php://input');
$data = json_decode($request_json, true);

// file_put_contents(
//     "payout_data.txt",
//     print_r($data, true) . PHP_EOL,
//     FILE_APPEND
// );
if ($data === null) {
    file_put_contents("log_error.txt", "JSON decode failed: " . json_last_error_msg() . "\n", FILE_APPEND);
    exit("Invalid JSON");
}

$id = $data['id'];
$address = $data['address'];
$txHash = $data['txHash'];
$status = $data['status'];
$amount = $data['amount'];

if ($data['status'] == 'failed') {
    $qry = mysqli_query($con, "SELECT member_id FROM meddolic_user_wallet_withdrawal  WHERE trnxId='$id'");
    $val = mysqli_fetch_assoc($qry);
    $mem_id = $val['member_id'];

}
$query = "UPDATE meddolic_user_wallet_withdrawal  SET  status = '$status' ,trnHash='$txHash',payment_date='$d' WHERE trnxId = '$id'";

mysqli_query($con, $query);

// Optional: Check for success
if (mysqli_affected_rows($con) > 0) {
    echo "Updated successfully.";
} else {
    echo "No update made or error.";
}