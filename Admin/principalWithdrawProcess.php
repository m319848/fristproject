<?php 
error_reporting(E_ALL ^ E_NOTICE);
 include("loginCheck.php");

if(isset($_POST['addRemark'])){
$d=date('Y-m-d H:i:s'); 
$id=$_POST['id'];

$member_id=$_POST['memberId'];
$from_date=$_POST['fromDate'];
$to_date=$_POST['toDate'];
$user_id=$_POST['userId'];
$withdrawStatus=$_POST['withdrawStatus'];
$remarks=$_POST['remarks'];

if($withdrawStatus==2){
    $result1=mysqli_query($con,"UPDATE meddolic_user_principal_invest_withdraw SET remarks='$remarks',paymentDate='$d',released='$withdrawStatus' WHERE id='$id'");
} else {
    $result1=mysqli_query($con,"UPDATE meddolic_user_principal_invest_withdraw SET remarks='$remarks',released='$withdrawStatus' WHERE id='$id'");
}
if($result1) { ?>
 <script>
    alert("Remarks Add successfully!!!");
    window.top.location.href='principalWithdrawHistory?user_id=<?= $user_id;?>&from_date=<?= $from_date;?>&to_date=<?= $to_date; ?>';
 </script>
 <?php } } ?>
<?php include("../close-connection.php"); ?>