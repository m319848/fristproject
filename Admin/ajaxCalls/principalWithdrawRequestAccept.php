
<br><br><br>
<center>
<h2>Processing your request!!!</h2>
<h3>Please do not press back or refresh!!!</h3>
</center>
<?php 
 include("loginCheck.php");
 
$payoutId=$_GET['WalletId']; 
$d=date('Y-m-d H:i:s');
$remarks="Principal Withdrawal Request Accepted";

$queryPayout=mysqli_query($con,"SELECT memberId,amount,released FROM meddolic_user_principal_invest_withdraw WHERE id='$payoutId'");
$valPayout=mysqli_fetch_assoc($queryPayout);
$memberId=$valPayout['memberId'];
$amount=$valPayout['amount'];
$released=$valPayout['released'];

if($released==1){ ?>
	<script>
		alert("This Request already Rejected");
		window.top.location.href="principalWithdrawRequest";
	</script>
	<?php 
	exit;
}
mysqli_query($con,"UPDATE meddolic_user_principal_invest_withdraw SET released=1,approvedDate='$d',remarks='$remarks' WHERE id='$payoutId'");

mysqli_query($con,"UPDATE meddolic_user_cashback_income_summary SET investStatus=2 WHERE memberId='$memberId' AND investStatus=1"); ?>
<script>
	alert("Withdrawal Request Approved Successful..");
	window.top.location.href="principalWithdrawRequest";
</script>
<?php include("../close-connection.php"); ?>