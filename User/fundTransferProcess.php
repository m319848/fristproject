<br><br><br>
<center>
	<h2>Processing your request!!!</h2>
	<h3>Please do not press back or refresh!!!</h3>
</center>
<?php
include("loginCheck.php");
require_once("authIncomeFunction.php");
if (isset($_POST['fundTransfer'])) {
	$queryAccess = mysqli_query($con, "SELECT member_id FROM meddolic_user_details 
    WHERE user_id='{$_SESSION['member_user_id']}'");
	$valAccess = mysqli_fetch_array($queryAccess);
	if (!$valAccess) {
		echo "<script>alert('Invalid session. Please log in again.'); window.top.location.href='LoginAuth';</script>";
		exit;
	}
	$loginMemberId = $valAccess['member_id'];
	$user_id1 = $_POST['sponser_id'];
	$amount = $_POST['amount'];
	// $minTransfer=$_POST['minTransfer'];
	// $maxTransfer=$_POST['maxTransfer'];
	$d = date("Y-m-d H:i:s");
	$entry_date = date("Y-m-d");
	// $emailOtp=md5($_POST['emailOtp']);
	// $actualOtp=$_SESSION['transferOTP'];
	// if($actualOtp<>$emailOtp){ 
	// 	unset($_SESSION['transferOTP']); ?>
	//
	<script>
		// 		alert("Invalid OTP Enter");
		// 		window.top.location.href='fundTransfer';
		// 	
	</script>
	// <?php
	// 	exit;
	// }
	if ($amount == 0 || $amount < 0) { ?>
		<script>
			alert("Invalid Entry Amount!!!");
			window.top.location.href = "fundTransfer";
		</script>
		<?php
		exit;
	}

	if ($amount % 10 != 0) { ?>
		<script>
			alert("Invalid Entry Amount! The amount must be a multiple of 10.");
			window.top.location.href = "fundTransfer";
		</script>
		<?php
		exit;
	}

	// if($amount<$minTransfer){ ?>
	//
	<script>
		//     	alert("Minimun Fund Transfer Limit $ <?= $minTransfer ?>");
		//     	window.top.location.href="fundTransfer";
		//   
	</script>
	// <?php
	//   exit;
	// }
	// if($amount>$maxTransfer){ ?>
	//
	<script>
		//     	alert("Maximum Fund Transfer Limit $ <?= $maxTransfer ?>");
		//     	window.top.location.href="fundTransfer";
		//   
	</script>
	// <?php
	//   exit;
	// }	


	//check capping compleate
	$userIncomeGet = userAllIncomeGet($con, $loginMemberId);
	$totalGet = $userIncomeGet->totalGet;
	$cappingLimit = $userIncomeGet->cappingLimit;
	$remainingLimit = $cappingLimit - $totalGet;

	//check capping compleate

	if ($remainingLimit == 0) { ?>
		<script>
			alert("Your capping limit has been reached. Please re-top up to continue withdrawing.");
			window.top.location.href = 'fundTransfer';
		</script>
		<?php
		exit;
	}
	//non working capping code
	$queryNonWorking = mysqli_query($con, "SELECT COUNT(*) FROM meddolic_user_child_ids WHERE member_id='$loginMemberId' AND topup_status=1");
	$ValNON = mysqli_fetch_array($queryNonWorking);
	if ($ValNON[0] == 0) {
		$queryCurrent = mysqli_query($con, "SELECT SUM(investPrice) FROM meddolic_user_activation_details WHERE member_id='$loginMemberId'");
		$valCurrent = mysqli_fetch_array($queryCurrent);
		$investmentAmount = $valCurrent[0];
		$cappingLimit = $investmentAmount * 2;

		$queryAll = mysqli_query($con, "SELECT SUM(incomeAmount) AS roiIncome  FROM meddolic_user_cashback_income_details WHERE member_id='$loginMemberId' AND status=1");
		$valAll = mysqli_fetch_assoc($queryAll);
		$totalGet = $valAll['roiIncome'];
		$remainingLimit = $cappingLimit - $totalGet;

		if ($remainingLimit <= 0) { ?>
			<script>
				alert("Your non working capping limit has been reached. Please re-top up to continue withdrawing.");
				window.top.location.href = 'fundTransfer';
			</script>
			<?php
			exit;

		}
	}


	$result = mysqli_query($con, "SELECT * FROM meddolic_user_details WHERE user_id='$user_id1' AND userType=2");
	if (!mysqli_num_rows($result)) { ?>
		<script>
			alert("Invalid Member Details!!!");
			window.top.location.href = "fundTransfer";
		</script>
		<?php
		exit;
	}
	+-
		$resultFund = mysqli_query($con, "SELECT fundWallet FROM meddolic_user_details WHERE member_id='$loginMemberId' and fundWallet>='$amount'");
	if (!mysqli_num_rows($resultFund)) { ?>
		<script>
			alert("Insufficient Balance in Wallet to Transfer!!!");
			window.top.location.href = "fundTransfer";
		</script>
		<?php
		exit;
	}

	$query1 = "SELECT member_id,phone FROM meddolic_user_details WHERE user_id='$user_id1'";
	$result1 = mysqli_query($con, $query1);
	$val1 = mysqli_fetch_assoc($result1);
	$receiver_member_id = $val1['member_id'];
	$receiverPhone = $val1['phone'];

	$querySender = mysqli_query($con, "SELECT user_id FROM meddolic_user_details WHERE member_id='$loginMemberId'");
	$valSender = mysqli_fetch_assoc($querySender);
	$senderUserId = $valSender['member_id'];

	if ($loginMemberId == $receiver_member_id) { ?>
		<script>
			alert("You Can't Transfer Fund to Yourself!!!");
			window.top.location.href = "fundTransfer";
		</script>
		<?php
		exit;
	}

	$queryCharge = mysqli_query($con, "SELECT p2pCharge FROM meddolic_config_misc_setting");
	$valCharge = mysqli_fetch_assoc($queryCharge);
	$p2pCharge = $valCharge['p2pCharge'];

	$Charge = $amount * $p2pCharge / 100;
	$netAmount = $amount - $Charge;
	mysqli_query($con, "UPDATE meddolic_user_details SET fundWallet=fundWallet+'$netAmount' WHERE member_id='$receiver_member_id'");
	mysqli_query($con, "UPDATE meddolic_user_details SET fundWallet=fundWallet-'$amount' WHERE member_id='$loginMemberId'");
	mysqli_query($con, "INSERT INTO meddolic_user_fund_transfer_history (`sender_member_id`,`receiver_member_id`,`amount`,`charge`,`netAmount`,`date_time`) VALUES ('$loginMemberId','$receiver_member_id','$amount','$Charge','$netAmount','$d')");
	mysqli_query($con, "INSERT INTO meddolic_user_wallet_statement (`member_id`,`wallet_statement_id`,`deb_cr`, `amount`,`date_time`,`trn_id`) VALUES ('$loginMemberId',5,1,'$amount','$d','$receiver_member_id')");
	mysqli_query($con, "INSERT INTO meddolic_user_wallet_statement (`member_id`,`wallet_statement_id`,`deb_cr`, `amount`,`date_time`,`trn_id`) VALUES ('$receiver_member_id',6,2,'$amount','$d','$loginMemberId')"); ?>
	<script>
		alert("Fund Transfer Successfully!!!");
		window.top.location.href = "fundTransfer";
	</script>
<?php } ?>
<?php include("../close-connection.php"); ?>