
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

if($released==2){ ?>
	<script>
		alert("This Request already Rejected");
		window.top.location.href="principalWithdrawRequest";
	</script>
	<?php 
	exit;
}
mysqli_query($con,"UPDATE meddolic_user_principal_invest_withdraw SET released=1,approvedDate='$d',remarks='$remarks' WHERE id='$payoutId'");

mysqli_query($con,"UPDATE meddolic_user_cashback_income_summary SET status=3 WHERE member_id='$memberId' AND status=1"); 
mysqli_query($con,"UPDATE meddolic_user_cashback_income_details SET status=3 WHERE member_id='$memberId' AND status=1"); 
mysqli_query($con,"UPDATE meddolic_user_level_income SET releaseStatus=3 WHERE memberId='$memberId' AND releaseStatus=1"); 
mysqli_query($con,"UPDATE meddolic_user_sponsor_income SET releaseStatus=2 WHERE memberId='$memberId' AND releaseStatus=1"); 
mysqli_query($con,"UPDATE meddolic_user_reward_income SET rewardStatus=4 WHERE memberId='$memberId' AND rewardStatus=1"); 


mysqli_query($con,"UPDATE meddolic_user_details SET topupFlag=0 WHERE member_id='$memberId' ");?>
<script>
	alert("Principal Withdrawal Request Approved..");
	window.top.location.href="principalWithdrawRequest";
</script>
<?php include("../close-connection.php"); ?>