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
	$d = date("Y-m-d H:i:s");

	$result = mysqli_query($con, "SELECT * from meddolic_user_details where user_id='$user_id1' AND userType=2 ");
	if (!mysqli_num_rows($result)) { ?>
		<script>
			alert("Invalid Member ID!!!");
			window.top.location.href = "spacialActivation";
		</script>
		<?php
		exit;
	}

	$query1 = "SELECT member_id FROM meddolic_user_details WHERE user_id='$user_id1'";
	$result1 = mysqli_query($con, $query1);
	$val1 = mysqli_fetch_assoc($result1);
	$receiver_member_id = $val1['member_id'];


	$queryOld = mysqli_query($con, "SELECT COUNT(1) FROM meddolic_user_details WHERE member_id='$receiver_member_id' AND topupFlag=1");
	$valOld = mysqli_fetch_array($queryOld);
	if ($valOld[0] >= 1) { ?>
		<script>
			alert("Already Activated!!!");
			window.top.location.href = "spacialActivation";
		</script>
		<?php
		exit;
	}

	mysqli_query($con, "UPDATE meddolic_user_details SET activationDate='$d',topupFlag=1,roiSatusFlag=1 WHERE member_id='$receiver_member_id'");

	mysqli_query($con, "INSERT INTO meddolic_user_spacial_activation_history (`member_id`,`date_time`) VALUES ('$receiver_member_id','$d')");

	?>
	<script>
		alert("Spacial Activation Successfully!!!");
		window.top.location.href = "spacialActivation";
	</script>
<?php } ?>
<?php include("../close-connection.php"); ?>