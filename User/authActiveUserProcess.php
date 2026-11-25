<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("loginCheck.php");
require_once("authIncomeFunction.php");
$dayofweek = date('w');
if (isset($_POST['upgradeNow'])) {

    $queryAccess = mysqli_query($con, "SELECT member_id,user_id FROM meddolic_user_details  WHERE user_id='{$_SESSION['member_user_id']}'");
    $valAccess = mysqli_fetch_assoc($queryAccess);
    if (!$valAccess) {
        echo "<script>
        alert('Invalid session. Please log in again.'); window.top.location.href='LoginAuth';
        </script>";
        exit;
    }
    $user_id1 = $valAccess['user_id'];
    $loginMemberId = $valAccess['member_id'];
    $investAmount = $_POST['investAmount'];
    $d = date("Y-m-d H:i:s");
    $todayDate = date("Y-m-d");
    $mininvestAmount = 50;
    $dayofweek = date('w');

    if ($mininvestAmount > $investAmount) { ?>
<script>
alert("Minimum investment amount is $<?= $mininvestAmount ?>. Please invest at least $<?= $mininvestAmount ?>.");
window.top.location.href = "authActiveUser";
</script>
<?php
        exit;
    }
    if ($investAmount % 50 != 0) { ?>
<script>
alert("Please enter an investment amount in multiples of $50 (e.g., $50, $100, $150, $200...).");
window.top.location.href = "authActiveUser";
</script>
<?php
        exit;
    }

    $queryNew = mysqli_query($con, "SELECT member_id FROM meddolic_user_details WHERE user_id='$user_id1' AND userType=2 AND acctStatus=1");
    if (!mysqli_num_rows($queryNew)) { ?>
<script>
alert("Invalid User Id!!!");
window.top.location.href = "authActiveUser";
</script>
<?php
        exit;
    }


    // $queryRetopUP = mysqli_query($con, "SELECT investPrice FROM meddolic_user_activation_details WHERE member_id='$loginMemberId' ORDER BY investPrice DESC LIMIT 1");
    // $valActivation = mysqli_fetch_assoc($queryRetopUP);
    // $lastinvestAmount = $valActivation['investPrice'] ?? 0;
    // if ($investAmount < $lastinvestAmount) { ?>
//
<script>
//         alert("Please invest an amount equal to or greater than your maximum previous investment.");
//         window.top.location.href = "authActiveUser";
//     
</script>
// <?php
    //     exit;
    // }

    $queryWallet = mysqli_query($con, "SELECT fundWallet FROM meddolic_user_details WHERE member_id='$loginMemberId'");
    $valWallet = mysqli_fetch_array($queryWallet);
    $currentWallet = $valWallet[0];
    if ($currentWallet <= 0) { ?>
<script>
alert("Insufficient Balance in Wallet to Purchase");
window.top.location.href = "authActiveUser";
</script>
<?php
        exit;
    }
    if ($currentWallet < $investAmount || 0 >= $investAmount) { ?>
<script>
alert("Insufficient Balance in Wallet to Purchase");
window.top.location.href = "authActiveUser";
</script>
<?php
        exit;
    }
    $queryDetail = mysqli_query($con, "SELECT a.member_id,a.sponser_id,a.topupFlag,a.rewardRank,b.activationDate AS spActDate,b.topupFlag AS sponserTop FROM meddolic_user_details a, meddolic_user_details b WHERE a.user_id='$user_id1' AND a.sponser_id=b.member_id");
    $valDetail = mysqli_fetch_assoc($queryDetail);
    $memberId = $valDetail['member_id'];
    $sponserId = $valDetail['sponser_id'];
    $topupFlag = $valDetail['topupFlag'];
    $spActDate = $valDetail['spActDate'];
    $sponserTop = $valDetail['sponserTop'];
    $rewardRank = $valDetail['rewardRank'];
    $nextRank = $rewardRank + 1;


    // Activation & Update Code Starts//
    if ($topupFlag == 0) {
        mysqli_query($con, "UPDATE meddolic_user_details SET topupFlag=1,activationDate='$d',activationAmount='$investAmount' WHERE member_id='$memberId'");
        mysqli_query($con, "UPDATE meddolic_user_child_ids SET topup_status=1,topup_date='$d' WHERE child_id='$memberId'");
        //direct income code start
        referralIncome($con, $sponserId, $memberId, $investAmount, $sponserTop, $d);
        //direct income code end

    }

    $queryIn = mysqli_query($con, "INSERT INTO meddolic_user_activation_details (`member_id`,`sponser_id`,`investPrice`,`date_time`,`purchaseType`,`activate_by`) VALUES ('$memberId','$sponserId','$investAmount','$d',1,'$loginMemberId')");
    $purchaseId = $con->insert_id;

    mysqli_query($con, "UPDATE meddolic_user_details SET fundWallet=fundWallet-'$investAmount' WHERE member_id='$loginMemberId'");
    mysqli_query($con, "INSERT INTO meddolic_user_wallet_statement (`member_id`,`wallet_statement_id`,`deb_cr`,`amount`,`date_time`)VALUES('$loginMemberId',8,1,'$investAmount','$d')");
    //Activation & Update Code Ends//
    if ($dayofweek == 5) {
        $dueDate = date('Y-m-d H:i:s', strtotime($d . '+ 3 Day'));
    } elseif ($dayofweek == 6) {
        $dueDate = date('Y-m-d H:i:s', strtotime($d . '+ 2 Day'));
    } else {
        $dueDate = date('Y-m-d H:i:s', strtotime($d . '+ 1 Day'));
    }
    //  $dueDate = date('Y-m-d H:i:s', strtotime($d . ' +10  minutes'));

    $queryIn = mysqli_query($con, "INSERT INTO meddolic_user_cashback_income_summary(`member_id`,`packagePrice`,`date_time`, `dueDate`,`status`) VALUES ('$memberId','$investAmount','$d','$dueDate',1)");
    //cashback income code end

    //booster income code start
    boosterIncome($con, $sponserId);
    //booter income code start

    //reward income code start
    if ($nextRank <= 11) {
        $queryCo = mysqli_query($con, "SELECT rewardId,rewardIncome,powerLeg,otherLeg FROM   meddolic_config_reward_income WHERE rewardId='$nextRank'");
        $valCo = mysqli_fetch_assoc($queryCo);
        $newRewardId = $valCo['rewardId'];
        $rewardIncome = $valCo['rewardIncome'];
        $oneLeg = $valCo['powerLeg'];
        $otherLeg = $valCo['otherLeg'];
        releaseRewardIncome($con, $memberId, $newRewardId, $rewardIncome, $oneLeg, $otherLeg, $d);
    }
    relayRewardLoop($con, $memberId, $d);

    //reward income code end 


    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
window.onload = function () {

            Swal.fire({
        title: "Congratulations!",
        text: "Package Purchased Successfully!!!",
        icon: "success",
        confirmButtonText: "OK"
    }).then(function(result) {

                if (result.isConfirmed) {
            window.top.location.href = "authActiveUser.php";
        }

            });

        };
</script>';

}
?>
<?php require_once("../close-connection.php"); ?>