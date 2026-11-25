<?php
include("loginCheck.php");
// require('../PHPMailer/EncrptyModel.php');
require_once("authIncomeFunction.php");
if (isset($_POST['walletWithdraw'])) {
	$newToken = $_SESSION['withdrawTokenSet'];
	$goodFile = mysqli_real_escape_string($con, $_POST['goodFile']);
	if ($goodFile == $newToken) {
		$queryAccess = mysqli_query($con, "SELECT member_id,topupFlag FROM meddolic_user_details 
    WHERE user_id='{$_SESSION['member_user_id']}'");
		$valAccess = mysqli_fetch_array($queryAccess);
		if (!$valAccess) {
			echo "<script>alert('Invalid session. Please log in again.'); window.top.location.href='LoginAuth';</script>";
			exit;
		}
		$memberId = $valAccess['member_id'];
		$topupFlag = $valAccess['topupFlag'];
		$withdraw_amount = $_POST['withdrawAmount'];
		$withdrwalIn = $_POST['withdrwalIn'];
		$minimumPayout = $_POST['minimumWithdraw'];
		$paymentId = $_POST['paymentId'];
		$trnPassword = $_POST['trnPassword'];
		$walletAddress = $_POST['walletAddress'];
		$walletType = $_POST['walletType'];
		$d = date("Y-m-d H:i:s");
		$todayDate = date('Y-m-d');
		$todayDay = date('l'); // Get current day name
		$hour = (int) date('H');
		$dayofweek = date('w');
		$dayofweek = 1;

		if ($walletType == 1 && $dayofweek !== 1) {
			?>
<script>
alert("Withdrawal from roiWallet is allowed only on Mondays.");
window.top.location.href = 'walletWithdraw';
</script>
<?php
			exit;


		}


		if ($hour < 6 || $hour >= 18) {
			?>
<script>
alert("Withdrawal time is 6:00 AM to 6:00 PM only.");
window.top.location.href = 'walletWithdraw';
</script>
<?php
			exit;
		}

		if ($dayofweek == 6 || $dayofweek == 0) {
			?>
<script>
alert("Withdrawal is not allowed on Saturday and Sunday. Please try again on a working day (Monday to Friday).");
window.top.location.href = 'walletWithdraw';
</script>
<?php
			exit;
		}


		// 24 hour gap check: pichhla withdrawal 24 ghante pehle se purana hona chahiye
		$resultLast = mysqli_query($con, "SELECT date_time FROM meddolic_user_wallet_withdrawal 
    WHERE member_id='$memberId' 
    ORDER BY id DESC LIMIT 1");
		$valLast = mysqli_fetch_assoc($resultLast);

		if ($valLast) {
			$lastTime = strtotime($valLast['date_time']);
			$nextAllowed = $lastTime + (24 * 60 * 60);
			$now = time();

			if ($now < $nextAllowed) {
				$remainingSeconds = $nextAllowed - $now;
				$hours = floor($remainingSeconds / 3600);
				$minutes = floor(($remainingSeconds % 3600) / 60);
				?>
<script>
alert("Only one withdrawal is allowed every 24 hours. Please try again after <?= $hours; ?>h <?= $minutes; ?>m.");
window.top.location.href = 'walletWithdraw';
</script>
<?php
				exit;
			}
		}

		// Daily withdrawal limit check (max 100 per day)
		$dailyLimit = 100;

		$resultDaily = mysqli_query($con, "SELECT COALESCE(SUM(amount),0) AS todayTotal  FROM meddolic_user_wallet_withdrawal  WHERE member_id='$memberId'  AND CAST(withdrawal_date AS date)='$todayDate'");
		$valDaily = mysqli_fetch_assoc($resultDaily);
		$todayWithdrawn = (float) $valDaily['todayTotal'];

		if (($todayWithdrawn + (float) $withdraw_amount) > $dailyLimit) {
			$remainingToday = max(0, $dailyLimit - $todayWithdrawn);
			?>
<script>
alert("Daily withdrawal limit is $<?= $dailyLimit; ?>. You can withdraw only $<?= $remainingToday; ?> more today.");
window.top.location.href = 'walletWithdraw';
</script>
<?php
			exit;
		}

		// $otp = md5($_POST['WidralOtp']);
		// $sessionOtp = $_SESSION['walletWidOtp'];
		// // Remove it from session

		// if ($otp != $sessionOtp) {
		// 	 ?>
//
<script>
// 		alert("Incorrect OTP");
// 		history.go(-1);
// 	
</script>
// <?php
		// 	unset($_SESSION['walletWidOtp']);
		// 	exit;
		// }
		// if ($topupFlag == 0) { ?>
//
<script>
// 		alert("Your ID is inactive. Withdrawal is not allowed!");
// 		window.top.location.href = 'walletWithdraw';
// 	
</script>
// <?php
		// 	exit;
		// }


		// $resultTopUp = mysqli_query($con, "SELECT COUNT(*) FROM meddolic_user_activation_details WHERE member_id='$loginMemberId'");
		// $val1 = mysqli_fetch_array($resultTopUp);
		// if ($val1[0] <= 1) { ?>
//
<script>
// 		alert("Withdrawal is not available until you complete the required re-top-up.");
// 		window.top.location.href = "fundTransfer";
// 	
</script>

// <?php

		// 	exit;
		// }

		// 		//check capping compleate
// 		$userIncomeGet = userAllIncomeGet($con, $memberId);
// 		$totalGet = $userIncomeGet->totalGet;
// 		$cappingLimit = $userIncomeGet->cappingLimit;
// 		$remainingLimit = $cappingLimit - $totalGet;

		// 		//check capping compleate

		// 		if ($remainingLimit == 0) { ?>
//
<script>
// alert("Your capping limit has been reached. Please re-top up to continue withdrawing.");
// window.top.location.href = 'walletWithdraw';
// 
</script>
// <?php
		// 			exit;
// 		}
// 		//non working capping code
// 		$queryNonWorking = mysqli_query($con, "SELECT COUNT(*) FROM meddolic_user_child_ids WHERE member_id='$memberId' AND topup_status=1");
// 		$ValNON = mysqli_fetch_array($queryNonWorking);
// 		if ($ValNON[0] == 0) {
// 			$queryCurrent = mysqli_query($con, "SELECT SUM(investPrice) FROM meddolic_user_activation_details WHERE member_id='$memberId'");
// 			$valCurrent = mysqli_fetch_array($queryCurrent);
// 			$investmentAmount = $valCurrent[0];
// 			$cappingLimit = $investmentAmount * 2;

		// 			$queryAll = mysqli_query($con, "SELECT SUM(incomeAmount) AS roiIncome  FROM meddolic_user_cashback_income_details WHERE member_id='$memberId' AND status=1");
// 			$valAll = mysqli_fetch_assoc($queryAll);
// 			$totalGet = $valAll['roiIncome'];
// 			$remainingLimit = $cappingLimit - $totalGet;

		// 			if ($remainingLimit <= 0) { ?>
//
<script>
// alert("Your non working capping limit has been reached. Please re-top up to continue withdrawing.");
// window.top.location.href = 'walletWithdraw';
// 
</script>
// <?php
		// 				exit;

		// 			}


		// 		}











		// 		$queryWithdraw = mysqli_query($con, "SELECT minWithdraw,coinrate FROM meddolic_config_misc_setting");
// 		$valWithdraw = mysqli_fetch_assoc($queryWithdraw);
// 		$minimumWithdraw = $valWithdraw['minWithdraw'];
// 		$coinrate = $valWithdraw['coinrate'];

		// 		$withdraw_amount = $coin_amount / $coinrate;

		if ($withdraw_amount == 0 || $withdraw_amount < 0) { ?>
<script>
alert("Invalid Withdraw Amount!!!");
window.top.location.href = 'walletWithdraw';
</script>
<?php
			exit;
		}



		if ($withdraw_amount < $minimumWithdraw) { ?>
<script>
alert("The Minimum withdraw amount is $ <?= $minimumWithdraw; ?>");
history.go(-1);
</script>
<?php
			exit;
		}
		if ($withdraw_amount % 10 != 0) { ?>
<script>
alert("Invalid withdrawal amount! Please enter an amount that is a multiple of 10.");
window.top.location.href = 'walletWithdraw';
</script>
<?php
			exit;
		}

		$result = mysqli_query($con, "SELECT COUNT(1) FROM meddolic_user_wallet_withdrawal WHERE member_id='$memberId' AND CAST(withdrawal_date AS date)='$todayDate' ");
		$val = mysqli_fetch_array($result);
		// if ($val[0] >= 1) {
		// 	 ?>
//
<script>
// 		alert("You can submit only one withdrawal request per day. Please try again tomorrow.");
// 		window.top.location.href = 'walletWithdraw';
// 	
</script>
// <?php
		// 	exit;
		// }



		$queryOld = mysqli_query($con, "SELECT COUNT(1) FROM meddolic_user_wallet_withdrawal WHERE member_id='$memberId' AND (released=4 OR released=0)");
		$valOld = mysqli_fetch_array($queryOld);
		// if ($valOld[0] >= 1) { ?>
//
<script>
// 		alert("Your Previous Withdraw is in Process!!!");
// 		history.go(-1);
// 	
</script>
// <?php
		// 	exit;
		// }

		$queryCheck = mysqli_query($con, "SELECT COUNT(1) FROM meddolic_user_details WHERE member_id='$memberId' AND trnPassword='$trnPassword'");
		$valCheck = mysqli_fetch_array($queryCheck);
		if ($valCheck[0] == 0) { ?>
<script>
alert("Incorrect Transaction Password!!!");
window.top.location.href = 'walletWithdraw';
</script>
<?php
			exit;
		}


		$queryWallet = mysqli_query($con, "SELECT wallet,roiWallet FROM meddolic_user_details WHERE member_id='$memberId'");
		$valWallet = mysqli_fetch_assoc($queryWallet);
		$current_wallet = $valWallet['wallet'];
		$current_roiwallet = $valWallet['roiWallet'];

		if ($current_wallet < $withdraw_amount && $walletType == 2) { ?>
<script>
alert("Insufficient Balance in Your Wallet To Withdraw");
window.top.location.href = 'walletWithdraw';
</script>
<?php
			exit;
		}
		if ($current_roiwallet < $withdraw_amount && $walletType == 1) { ?>
<script>
alert("Insufficient Balance in Your roiWallet To Withdraw");
window.top.location.href = 'walletWithdraw';
</script>
<?php
			exit;
		}


		if ($withdrwalIn == 2) {

			$queryWallet = mysqli_query($con, "SELECT ifsc,account_no,bankName,branchName FROM meddolic_user_details WHERE member_id='$memberId'");
			$valWallet = mysqli_fetch_array($queryWallet);
			$ifsc = $valWallet['ifsc'];
			$account_number = $valWallet['account_no'];
			$bank = $valWallet['bankName'];
			$account_name = $valWallet['branchName'];
			if (empty($ifsc) || empty($account_number) || empty($bank) || empty($account_name)) { ?>
<script>
alert("Please fill in your bank details!");
window.top.location.href = 'walletWithdraw';
</script>
<?php
				exit;
			}
		} else {

			$queryWallet = mysqli_query($con, "SELECT walletAddress FROM meddolic_user_wallet_address_details WHERE payment_id='$paymentId' AND member_id='$memberId'");
			$valWallet = mysqli_fetch_array($queryWallet);
			$walletAddress = $valWallet['walletAddress'];
			if ($walletAddress == '') { ?>
<script>
alert("Please Fill Wallet Address!!!");
window.top.location.href = 'walletWithdraw';
</script>
<?php
				exit;
			}
		}

		$orderId = rand(11101, 99999) . $memberId . date('s') . date('h');
		$queryCharge = mysqli_query($con, "SELECT withdrawCharge FROM meddolic_config_misc_setting");
		$valCharge = mysqli_fetch_assoc($queryCharge);
		$withdrawCharge = $valCharge['withdrawCharge'];
		$Charge = $withdraw_amount * $withdrawCharge / 100;
		$netAmount = $withdraw_amount - $Charge;

		$queryIn = mysqli_query($con, "INSERT INTO meddolic_user_wallet_withdrawal (`member_id`,`withdrawal_date`,`date_time`,`amount`,`withdrawCharge`,`netAmount`, `walletAddress`,`orderid`,`paymentId`,`withdrwalIn`) VALUES ('$memberId','$todayDate','$d','$withdraw_amount','$Charge','$netAmount', '$walletAddress','$orderId','$paymentId','$walletType')");
		$lastWithdraw = $con->insert_id;
		if ($walletType == 2) {

			mysqli_query($con, "UPDATE meddolic_user_details SET wallet=wallet-'$withdraw_amount' WHERE member_id='$memberId'");
		} else {
			mysqli_query($con, "UPDATE meddolic_user_details SET roiWallet=roiWallet-'$withdraw_amount' WHERE member_id='$memberId'");
		}


		mysqli_query($con, "INSERT INTO meddolic_user_wallet_statement (`member_id`,`wallet_statement_id`,`deb_cr`,`amount`,`date_time`,`trn_id`) VALUES ('$memberId',10,1,'$withdraw_amount','$d','$lastWithdraw')"); ?>
<script>
alert("Wallet Withdraw Successfully");
window.top.location.href = "walletWithdraw";
</script>
<?php } else { ?>
<script>
alert('Your Session Expired.Please re Submit your Request Again');
window.top.location.href = 'walletWithdraw';
</script>
<?php }
} ?>
<?php include("../close-connection.php"); ?>