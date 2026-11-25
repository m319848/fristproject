
<br><br><br>
<center>
<h2>Processing your request!!!</h2>
<h3>Please do not press back or refresh!!!</h3>
</center>
<?php 
include("loginCheck.php");
if(isset($_POST['cancelWithdraw'])){
	$payout_id=$_POST['id']; 
	$remarks=$_POST['remarks'];
	$d=date('Y-m-d H:i:s');

	$queryPayout=mysqli_query($con,"SELECT * FROM meddolic_user_principal_invest_withdraw WHERE id='$payout_id'");
	$valPayout=mysqli_fetch_assoc($queryPayout);
	$member_id=$valPayout['memberId'];
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
	mysqli_query($con,"UPDATE meddolic_user_principal_invest_withdraw SET released=2,approvedDate='$d',remarks='$remarks' WHERE id='$payout_id'"); ?>
	<script>
		alert("Principal Withdrawal Request Rejected..");
		window.top.location.href="principalWithdrawRequest";
	</script>
	<?php } ?>


<?php include("../close-connection.php"); ?>