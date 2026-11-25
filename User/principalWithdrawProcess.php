<?php
include("loginCheck.php");
if (isset($_POST['principalWithdraw'])) {
	$queryAccess = mysqli_query($con, "SELECT member_id FROM meddolic_user_details 
    WHERE user_id='{$_SESSION['member_user_id']}'");
	$valAccess = mysqli_fetch_array($queryAccess);
	if (!$valAccess) {
		echo "<script>alert('Invalid session. Please log in again.'); window.top.location.href='LoginAuth';</script>";
		exit;
	}
	$memberId = $valAccess['member_id'];
	$amount = $_POST['amount'];
	$paymentId = $_POST['paymentId'];

	$d = date("Y-m-d H:i:s");
	$todayDate = date('Y-m-d');




	$queryOld = mysqli_query($con, "SELECT COUNT(1) FROM meddolic_user_principal_invest_withdraw WHERE memberId='$memberId' AND (released=4 OR released=0)");
	$valOld = mysqli_fetch_array($queryOld);
	if ($valOld[0] >= 1) { ?>
		<script>
			alert("Your Previous Withdraw is in Process!!!");
			history.go(-1);
		</script>
		<?php
		exit;
	}



	$queryInvest = mysqli_query($con, "SELECT SUM(investPrice) FROM meddolic_user_activation_details WHERE member_id='$memberId' AND status=1");
	$valInvest = mysqli_fetch_array($queryInvest);
	$totalInvest = $valInvest[0];
	if ($totalInvest == "" || $totalInvest == 0) { ?>
		<script>
			alert("Invalid Request!!!");
			history.go(-1);
		</script>
		<?php
		exit;
	}

	// $newCalObj1= new passEncrypt;
	// $encTrnPass= $newCalObj1 -> twoPassEncrypt($trnPassword);
	// $queryCheck=mysqli_query($con,"SELECT COUNT(1) FROM meddolic_user_details where  trnPassword='$encTrnPass'");
	// $valCheck=mysqli_fetch_array($queryCheck);
	// if($valCheck[0]==0) { ?>
	//
	<script>
		//       alert("Incorrect Transaction Password!!!");
		// 	  history.go(-1);
		//     </script>
	// <?php
	//     exit;
	// }

	$orderId = rand(11101, 99999) . $memberId . date('s') . date('h');

	$queryIn = mysqli_query($con, "INSERT INTO meddolic_user_principal_invest_withdraw (`memberId`,`withdrawalDate`,`dateTime`,`amount`,`orderId`,`walletId`) VALUES ('$memberId','$todayDate','$d','$totalInvest','$orderId','$paymentId')");
	mysqli_query($con, "UPDATE meddolic_user_activation_details SET status=0 WHERE member_id='$memberId'");

	$lastWithdraw = $con->insert_id; ?>
	<script>
		alert("Pricipal Amount Withdraw Successfully");
		window.top.location.href = "principalWithdrawal";
	</script>
<?php } ?>
<?php include("../close-connection.php"); ?>