<br><br><br>
<center>
	<h2>Processing your request!!!</h2>
	<h3>Please do not press back or refresh!!!</h3>
</center>

<?php
include("loginCheck.php");

if (isset($_POST['fundTransfer'])) {
	$queryAccess = mysqli_query($con, "  SELECT member_id,wallet,fundWallet  FROM meddolic_user_details WHERE user_id='{$_SESSION['member_user_id']}' ");
	$valAccess = mysqli_fetch_array($queryAccess);
	if (!$valAccess) {
		?>
		<script>
			alert("Invalid session. Please login again!");
			window.top.location.href = "LoginAuth";
		</script>
		<?php
		exit;
	}

	$loginMemberId = $valAccess['member_id'];
	$currentIncomeWallet = $valAccess['wallet'];
	$currentFundWallet = $valAccess['fundWallet'];
	$user_id1 = $_POST['sponser_id'];
	$amount = mysqli_real_escape_string($con, $_POST['amount']);
	$trnPassword = mysqli_real_escape_string($con, $_POST['trnPassword']);
	$transferType = $_POST['transferType'];

	$d = date("Y-m-d H:i:s");

	if ($amount <= 0) {
		?>
		<script>
			alert("Invalid Amount Enter!");
			window.top.location.href = "mainToFund";
		</script>
		<?php
		exit;
	}

	if (empty($transferType)) {
		?>
		<script>
			alert("Please Select Transfer Type!");
			window.top.location.href = "mainToFund";
		</script>
		<?php
		exit;
	}

	$queryCheck = mysqli_query($con, " SELECT COUNT(1)  FROM meddolic_user_details  WHERE member_id='$loginMemberId' AND trnPassword='$trnPassword' ");
	$valCheck = mysqli_fetch_array($queryCheck);
	if ($valCheck[0] == 0) {
		?>
		<script>
			alert("Incorrect Transaction Password!");
			window.top.location.href = "mainToFund";
		</script>
		<?php
		exit;
	}

	if ($transferType == "income_to_fund") {
		if ($currentIncomeWallet < $amount) {
			?>
			<script>
				alert("Insufficient Balance in Income Wallet!");
				window.top.location.href = "mainToFund";
			</script>
			<?php
			exit;
		}

		mysqli_query($con, "  UPDATE meddolic_user_details  SET  wallet = wallet - '$amount', fundWallet = fundWallet + '$amount' WHERE member_id='$loginMemberId' ");
		$remark = "Income To Fund";
	} elseif ($transferType == "trade_to_income") {
		// if ($currentTradeWallet < $amount) {
		// 	?>
		// 	<script>
		// 		alert("Insufficient Balance in Trade Wallet!");
		// 		window.top.location.href = "mainToFund";
		// 	</script>
		// 	<?php
		// 	exit;
		// }
		// mysqli_query($con, " UPDATE meddolic_user_details SET  tradeWallet = tradeWallet - '$amount', fundWallet = fundWallet + '$amount'
        //     WHERE member_id='$loginMemberId' ");
		// $remark = "Trade To Fund";
	} else {
		?>
		<script>
			alert("Invalid Transfer Type!");
			window.top.location.href = "mainToFund";
		</script>
		<?php
		exit;
	}

	mysqli_query($con, " INSERT INTO meddolic_user_income_wallet_transfer ( memberId,  transferAmount, depositAmount,  transferDate, incomeWallet,  fundWallet, remark ) VALUES ( '$loginMemberId',
            '$amount',
            '$amount',
            '$d',
            '$currentIncomeWallet',
            '$currentFundWallet',
            '$remark'
        )
    ");

	$trfId = $con->insert_id;

	// =========================
	// WALLET STATEMENT
	// =========================
	mysqli_query($con, "
        INSERT INTO meddolic_user_wallet_statement
        (
            member_id,
            wallet_statement_id,
            deb_cr,
            amount,
            date_time,
            trn_id
        )
        VALUES
        (
            '$loginMemberId',
            9,
            1,
            '$amount',
            '$d',
            '$trfId'
        )
    ");
	?>

	<script>
		alert("Fund Transfer Successfully!");
		window.top.location.href = "mainToFund";
	</script>

<?php } ?>

<?php include("../close-connection.php"); ?>