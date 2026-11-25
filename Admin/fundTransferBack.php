<br><br><br>
<center>
	<h2>Processing your request!!!</h2>
	<h3>Please do not press back or refresh!!!</h3>
</center>
<?php
include("loginCheck.php");

if (isset($_POST['fundTransfer'])) {
	$user_id1 = $_POST['sponser_id'];
	$sender_member_id = $_POST['login_member_id'];
	$amount = $_POST['amount'];
	$walletType = $_POST['walletType'];
	$d = date("Y-m-d H:i:s");
	$entry_date = date("Y-m-d");

	$result = mysqli_query($con, "SELECT * from meddolic_user_details where user_id='$user_id1' AND userType=2 ");
	if (!mysqli_num_rows($result)) { ?>
		<script>
			alert("Invalid Member ID!!!");
			window.top.location.href = "fundTransfer";
		</script>
	<?php
		exit;
	}

	$query1 = "SELECT member_id FROM meddolic_user_details WHERE user_id='$user_id1'";
	$result1 = mysqli_query($con, $query1);
	$val1 = mysqli_fetch_assoc($result1);
	$receiver_member_id = $val1['member_id'];

	$transferCharge = 0;

	mysqli_query($con, "UPDATE meddolic_user_details SET fundWallet=fundWallet+'$amount' where member_id='$receiver_member_id'");

	mysqli_query($con, "INSERT INTO meddolic_user_fund_transfer_history(`sender_member_id`, `receiver_member_id`,`amount`,`depositAmount`,`date_time`,`walletType`) VALUES ('$sender_member_id','$receiver_member_id','$amount','$amount','$d','$walletType')");

	mysqli_query($con, "INSERT INTO meddolic_user_wallet_statement (`member_id`,`wallet_statement_id` ,`deb_cr`, `amount`, `date_time`,`trn_id`) VALUES ('$receiver_member_id',6,2,'$amount','$d','$sender_member_id')"); ?>
	<script>
		alert("Fund Transfer Successfully!!!");
		window.top.location.href = "fundTransfer";
	</script>
<?php } ?>
<?php include("../close-connection.php"); ?>