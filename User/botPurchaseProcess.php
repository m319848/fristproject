<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("loginCheck.php");
require_once("authIncomeFunction.php");
if (isset($_POST['purchaseNow'])) {
    $queryAccess = mysqli_query($con, "SELECT member_id,user_id FROM meddolic_user_details  WHERE user_id='$_SESSION[member_user_id]'");
    $valAccess = mysqli_fetch_assoc($queryAccess);
    if (!$valAccess) {
        echo "<script>
        alert('Invalid session. Please log in again.'); window.top.location.href='LoginAuth';
        </script>";
        exit;
    }
    $loginMemberId = $valAccess['member_id'];
    $user_id1 = $valAccess['user_id'];

    $d = date("Y-m-d H:i:s");
    $todayDate = date("Y-m-d");

    $queryNew = mysqli_query($con, "SELECT member_id FROM meddolic_user_details WHERE user_id='$user_id1' AND userType=2 AND acctStatus=1");
    if (!mysqli_num_rows($queryNew)) { ?>
        <script>
            alert("Invalid User Id!!!");
            window.top.location.href = "botPurchase";
        </script>
        <?php
        exit;
    }

    $queryGet = mysqli_query($con, "SELECT packageId,packagePrice FROM `meddolic_config_bot_package_type` WHERE packageStatus=1 AND packageId=1");
    $valGet = mysqli_fetch_assoc($queryGet);
    $packageId = $valGet['packageId'];
    $investAmount = $valGet['packagePrice'];



    $queryWallet = mysqli_query($con, "SELECT fundWallet FROM meddolic_user_details WHERE member_id='$loginMemberId'");
    $valWallet = mysqli_fetch_array($queryWallet);
    $currentWallet = $valWallet[0];
    if ($currentWallet <= 0) { ?>
        <script>
            alert("Insufficient Balance in Wallet to Purchase");
            window.top.location.href = "botPurchase";
        </script>
        <?php
        exit;
    }
    if ($currentWallet < $investAmount || 0 >= $investAmount) { ?>
        <script>
            alert("Insufficient Balance in Wallet to Purchase");
            window.top.location.href = "botPurchase";
        </script>
        <?php
        exit;
    }
    $queryDetail = mysqli_query($con, "SELECT a.member_id,a.sponser_id,a.topupFlag,b.activationDate AS spActDate,b.topupFlag AS sponserTop FROM meddolic_user_details a, meddolic_user_details b WHERE a.user_id='$user_id1' AND a.sponser_id=b.member_id");
    $valDetail = mysqli_fetch_assoc($queryDetail);
    $memberId = $valDetail['member_id'];
    $sponserId = $valDetail['sponser_id'];
    $topupFlag = $valDetail['topupFlag'];
    $spActDate = $valDetail['spActDate'];
    $sponserTop = $valDetail['sponserTop'];


    $queryBotPurchage = mysqli_query($con, "SELECT COUNT(1) AS botPurchage FROM meddolic_user_activation_details WHERE member_id='$memberId' AND packageId='$packageId' AND purchaseType=2");
    $valBotPurchase = mysqli_fetch_assoc($queryBotPurchage);
    $botPurchage = $valBotPurchase['botPurchage'];
    if ($botPurchage > 0) { ?>
        <script>
            alert("You have already purchased the bot package. Please wait for the current package to expire before purchasing again.");
            window.top.location.href = "botPurchase";
        </script>
        <?php
        exit;
    }


    //Activation & Update Code Starts//
    if ($topupFlag == 0) {
        mysqli_query($con, "UPDATE meddolic_user_details SET topupFlag=1,activationDate='$d' WHERE member_id='$memberId'");

        mysqli_query($con, "UPDATE meddolic_user_child_ids SET topup_status=1,topup_date='$d' WHERE child_id='$memberId'");
    }

    $orderId = "ORD" . rand(100000, 999999) . "MG" . $memberId;

    $queryIn = mysqli_query($con, "INSERT INTO meddolic_user_activation_details (`member_id`,`sponser_id`,`packageId`,`investPrice`,`date_time`,`purchaseType`,`activate_by`,`orderid`) VALUES ('$memberId','$sponserId',1,'$investAmount','$d',2,'$loginMemberId','$orderId')");
    $purchaseId = $con->insert_id;

    mysqli_query($con, "UPDATE meddolic_user_details SET fundWallet=fundWallet-'$investAmount'  WHERE member_id='$loginMemberId'");

    mysqli_query($con, "INSERT INTO meddolic_user_wallet_statement (`member_id`,`wallet_statement_id`,`deb_cr`, `amount`, `date_time`) VALUES ('$loginMemberId',8,1,'$investAmount','$d')");
    //Activation & Update Code Ends//

    //====================================================================================================================================  
    // Level Income Code Starts
    releaseLevelIncome($con, $memberId, $investAmount, $packageId, $d);
    // Level Income Code Ends

    //====================================================================================================================================

    //reward Income Code Starts
    releaseRewardIncome($con, $memberId, $d);
    //reward Income Code Ends

    //=====================================================================================================================================

    $queryRe = mysqli_query($con, "SELECT matchingIncome FROM meddolic_config_misc_setting");
    $valRe = mysqli_fetch_assoc($queryRe);
    $matchingIncome = $valRe['matchingIncome'];


    //Carry Update Code Starts//
    childEntry($con, $memberId, $d, $loginMemberId, $packageId, $investAmount);
    //Carry Update Code Ends//


    //SELF PAIR CHECK//
    checkPair($con, $memberId, $d, $matchingIncome, $todayDate, $packageId);

    function relayLoop($con, $memberId, $d, $matchingIncome, $todayDate, $packageId)
    {
        $query_main = mysqli_query($con, "SELECT a.placeholderId,b.topupFlag FROM meddolic_user_details a, meddolic_user_details b WHERE a.member_id='$memberId' AND a.placeholderId=b.member_id");
        $val_main = mysqli_fetch_array($query_main);
        $parentId = $val_main[0];
        $topupFlag = $val_main[1];

        while ($parentId) {
            if ($topupFlag == 1 || $topupFlag == 0) {
                checkPair($con, $parentId, $d, $matchingIncome, $todayDate, $packageId);
            }

            $queryMain = mysqli_query($con, "SELECT a.placeholderId,b.topupFlag FROM meddolic_user_details a, meddolic_user_details b WHERE a.member_id='$parentId' AND a.placeholderId = b.member_id");
            $valMain = mysqli_fetch_array($queryMain);
            $parentId = $valMain[0];
            $topupFlag = $valMain[1];
        }
    }

    relayLoop($con, $memberId, $d, $matchingIncome, $todayDate, $packageId);

    //Pair Check Send Code Ends//


    echo '
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
window.onload = function () {

    Swal.fire({
        title: "Congratulations!",
        text: "Bot Purchased Successfully!!!",
        icon: "success",
        confirmButtonText: "OK"
    }).then(function(result) {

        if (result.isConfirmed) {
            window.top.location.href = "botPurchase.php";
        }

    });

};
</script>
';

}
?>
<?php require_once("../close-connection.php"); ?>