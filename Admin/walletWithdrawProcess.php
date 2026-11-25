<?php  
include("loginCheck.php");
$sys_date=date("Y-m-d H:i:s");

// echo '<pre>';
// print_r($_REQUEST);

$user_wallet=$_REQUEST['wallet_address'];
$user_id=$_REQUEST['member_id'];
$record_no=$_REQUEST['record_no'];
$user_trx_array=$_REQUEST['user_usdt'];
$hashcode=$_REQUEST['hashcode'];
$total_usdt=$_REQUEST['total_usdt'];


$wallet_array=explode("%",$user_wallet);
$member_array=explode("%",$user_id);
$rec_array=explode("A",$record_no);
$income_array=explode("A",$user_trx_array);
$total_usdt=0;
$arrlength = count($wallet_array);
for($x = 0; $x < $arrlength; $x++) {
   $wallet_address= $wallet_array[$x];
   $member_user_id= $member_array[$x];
   $income_amt= $income_array[$x]/1e8;
   $record_id= $rec_array[$x];
   $total_usdt=$total_usdt+$income_amt;
   $ss=mysqli_query($con,"UPDATE meddolic_user_wallet_withdrawal_crypto SET released=1,trnHash='$hashcode',payment_date='$sys_date' WHERE id='$record_id'");
}
$pstr=mysqli_query($con,"INSERT INTO meddolic_user_withdraw_paymenttrns(hash_code,sdate,total_amt,status,checked)values('$hashcode','$sys_date','$total_usdt',0,0)"); ?>
<script>
   alert('Payment Done Successfully!!!');
   window.top.location.href='walletWithdrawStatus';
</script>