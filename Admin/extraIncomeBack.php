<br><br><br>
<center>
	<h2>Processing your request!!!</h2>
	<h3>Please do not press back or refresh!!!</h3>
</center>
<?php
include("loginCheck.php");

if (isset($_POST['activeNow'])) {
	$user_id1 = $_POST['sponser_id'];
	$sender_member_id = $_POST['login_member_id'];
	$amount = $_POST['amount'];
	$d = date("Y-m-d H:i:s");

	$result = mysqli_query($con, "SELECT * from meddolic_user_details where user_id='$user_id1' AND userType=2 ");
	if (!mysqli_num_rows($result)) { ?>
		<script>
			alert("Invalid Member ID!!!");
			window.top.location.href = "extraIncome";
		</script>
		<?php
		exit;
	}

	$query1 = "SELECT member_id FROM meddolic_user_details WHERE user_id='$user_id1'";
	$result1 = mysqli_query($con, $query1);
	$val1 = mysqli_fetch_assoc($result1);
	$receiver_member_id = $val1['member_id'];


	mysqli_query($con, "UPDATE meddolic_user_details SET wallet=wallet+'$amount' WHERE member_id='$receiver_member_id'");

	mysqli_query($con, "INSERT INTO meddolic_user_spacial_income_history (`member_id`,`date_time`,`amount`) VALUES ('$receiver_member_id','$d',$amount)");
	?>
	<script>
		alert("Amount Transfer Successfully!!!");
		window.top.location.href = "extraIncome";
	</script>
<?php } ?>
<?php include("../close-connection.php"); ?>