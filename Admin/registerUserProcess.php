<?php 
require_once("loginCheck.php");
require_once('../User/authIncomeFunction.php');
require_once('../PHPMailer/EncrptyModel.php');
if(isset($_POST['registerNow'])){
    $sponser_id=mysqli_real_escape_string($con,$_POST['sponser_id']);
    $name=mysqli_real_escape_string($con,$_POST['name']);
    $emailId=mysqli_real_escape_string($con,$_POST['email$emailId']);
    $legPosition=mysqli_real_escape_string($con,$_POST['legPosition']);
    $walletAddress=mysqli_real_escape_string($con,$_POST['walletAddress']);
    $investAmount=mysqli_real_escape_string($con,$_POST['investAmount']);    
    $loginMemberId=mysqli_real_escape_string($con,$_POST['loginMemberId']);    
    $d=date("Y-m-d H:i:s");
    $todayDate=date('Y-m-d', strtotime($d));
    $sessionHour=date('H', strtotime($d));
    if($sessionHour>=0 && $sessionHour<12){
        $hourCount=1;
    }else if($sessionHour>=12 && $sessionHour<24){
        $hourCount=2;
    }

    $querySponser=mysqli_query($con,"SELECT member_id FROM meddolic_user_details WHERE user_id='$sponser_id' AND acctStatus=1");
    if(!mysqli_num_rows($querySponser)){  ?>
        <script>
            alert("Invalid / In-Active Sponser Id!!!");
            window.top.location.href="registerUser";
        </script>
        <?php
        exit;
    }
    //Joining Code Starts//
    $querySponser=mysqli_query($con,"SELECT member_id FROM meddolic_user_details WHERE user_id='$sponser_id'");
    $valSponser=mysqli_fetch_array($querySponser);
    $sponserId=$valSponser[0];

    $placeholderId=$sponser_id;
    $query=mysqli_query($con,"SELECT member_id FROM meddolic_user_details WHERE user_id='$placeholderId'");
    $val=mysqli_fetch_array($query);
    $placeholderId=$val[0];

    $query="SELECT member_id FROM meddolic_user_details WHERE placeholderId='$placeholderId' AND legPosition='$legPosition'";
    $result=mysqli_query($con,$query);
    $val1=mysqli_fetch_array($result);
    while($val1[0]){
        $placeholderId=$val1[0];
        $query="SELECT member_id FROM meddolic_user_details WHERE placeholderId='$placeholderId' AND legPosition='$legPosition'";
        $result=mysqli_query($con,$query);
        $val1=mysqli_fetch_array($result);
    }
    $placeholderMemberId=$placeholderId;

    function trnPassword( $length = 6 ) {
        $chars = "0123456789";
        $password = substr( str_shuffle( $chars ), 0, $length );
        return $password;
    }
    
    $trnPassword=trnPassword (6);
    $passObj= new passEncrypt();
    $encTrnPass= $passObj -> twoPassEncrypt($trnPassword);

    $queryInsert=mysqli_query($con,"INSERT INTO meddolic_user_details (`name`,`email_id`,`trnPassword`,`sponser_id`,`placeholderId`,`legPosition`,`topupFlag`,`date_time`,`walletAddress`,`activationDate`) VALUES ('$name','$emailId','$encTrnPass','$sponserId','$placeholderMemberId','$legPosition',1,'$d','$walletAddress','$d')");
    $memberId = $con->insert_id;

    function userIdSet($con,$memberId,$d){
        $userId="EU".rand(111,999).rand(111,999);
        $queryExist=mysqli_query($con,"SELECT COUNT(1) FROM meddolic_user_details WHERE user_id='$userId'");
        $valExist=mysqli_fetch_array($queryExist);
        if($valExist[0]==0){
            mysqli_query($con,"UPDATE meddolic_user_details SET user_id='$userId' WHERE member_id='$memberId'");
        }else{
            userIdSet($con,$memberId,$d);
        }
    }
    userIdSet($con,$memberId,$d);
    $_SESSION['new_user_id'] = $memberId;
    //Joining Code Ends//

    //Child ID Code Start//
    $queryChild=mysqli_query($con,"SELECT placeholderId,legPosition,date_time from meddolic_user_details where member_id='$memberId'");
    $valChild=mysqli_fetch_array($queryChild);
    $parentId=$valChild[0];
    $leg_position=$valChild[1];
    $dateTime=$valChild[2];
    $level=1;
    while($parentId){
        mysqli_query($con,"INSERT INTO meddolic_user_child_ids (`member_id`,`child_id`,`legPosition`,`level`,`date_time`,`topup_status`,`topup_date`) VALUES ('$parentId','$memberId','$leg_position','$level','$dateTime',1,'$dateTime')");

        $queryUser=mysqli_query($con,"SELECT placeholderId,legPosition FROM meddolic_user_details where member_id='$parentId'");
        $valUser=mysqli_fetch_array($queryUser);
        $parentId=$valUser[0];
        $leg_position = $valUser[1];
        $level++;
    }
    //Child ID Code End//

    //Child ID Code Start//
    $queryChild=mysqli_query($con,"SELECT sponser_id,date_time FROM meddolic_user_details WHERE member_id='$memberId'");
    $valChild=mysqli_fetch_array($queryChild);
    $parent_id=$valChild[0];
    $date_time=$valChild[1];
    $level=1;
    while($parent_id){
        mysqli_query($con,"INSERT INTO meddolic_user_level_team (`memberId`,`childId`,`level`,`joinDate`,`topupDate`,`topupStatus`) VALUES ('$parent_id','$memberId','$level','$date_time','$date_time',1)");

        $queryUser=mysqli_query($con,"SELECT sponser_id FROM meddolic_user_details WHERE member_id='$parent_id'");
        $valUser=mysqli_fetch_array($queryUser);
        $parent_id=$valUser[0];
        $level++;
    }
    //Child ID Code End//

    $queryPackage=mysqli_query($con,"SELECT minInvest,matchingIncome,matchingPercent,cappingLimit,welcomeBonus FROM meddolic_config_misc_setting");
    $valPackage = mysqli_fetch_assoc($queryPackage);
    $packagePrice=$valPackage['minInvest'];
    $matchingIncome=$valPackage['matchingIncome'];
    $matchingPercent=$valPackage['matchingPercent'];
    $cappingLimit=$valPackage['cappingLimit'];
    $welcomeBonus=$valPackage['welcomeBonus'];

    mysqli_query($con,"UPDATE meddolic_user_details SET welcomeWallet='$packagePrice',welcomeStatus=1 WHERE member_id='$memberId'");

    //Invest Amount History Code Start
    $queryPartner=mysqli_query($con,"INSERT INTO meddolic_user_activation_details (`memberId`,`sponserId`,`investAmount`,`dateTime`,`loginMemberId`) VALUES ('$memberId','$sponserId','$packagePrice','$d','$loginMemberId')");
    $purchaseId=$con->insert_id;
    //Invest Amount History Code End

    //Direct Count Code Start
    $direct3Count=0;
    $incomeId=1;
    $queryDr=mysqli_query($con,"SELECT COUNT(1) FROM meddolic_user_details WHERE sponser_id='$sponserId' AND topupFlag=1");
    $valDr=mysqli_fetch_array($queryDr);
    if($valDr[0]==3){
        $direct3Count=1;
        mysqli_query($con,"UPDATE meddolic_user_details SET directCount=1 WHERE member_id='$memberId'");
        $incomeId=2;

        $queryLeg=mysqli_query($con,"SELECT legPosition FROM meddolic_user_child_ids WHERE child_id='$memberId' AND member_id='$sponserId'");
        $valLeg=mysqli_fetch_assoc($queryLeg);
        $legPosition=$valLeg['legPosition'];

        mysqli_query($con,"INSERT INTO meddolic_user_matching_carry (`memberId`,`childId`,`legPosition`,`packagePrice`,`activeBy`,`dateTime`,`topupDate`) VALUES ('$sponserId','$memberId','$legPosition','$packagePrice','$loginMemberId','$d','$d')");
    }
    //Direct Count Code End

    //Referral Income Code Start
    releaseDirectIncome($con,$sponserId,$memberId,$packagePrice,$incomeId,$purchaseId,$d);
    //Referral Income Code End

    //Level Income Code Start
    if($direct3Count==0){
        releaseLevelIncome($con,$memberId,$packagePrice,$purchaseId,$d);

        //Binary Carry Entry Code Start
        childEntry($con,$memberId,$d,$loginMemberId,$packagePrice);
        //Binary Carry Entry Code End
    }
    //Level Income Code End
    
    //Pair Check Send Code Start//
    checkPair($con,$memberId,$d,$matchingIncome,$matchingPercent,$cappingLimit,$todayDate,$sessionHour,$hourCount);
    relayLoop($con,$memberId,$d,$matchingIncome,$matchingPercent,$cappingLimit,$todayDate,$sessionHour,$hourCount);
    //Pair Check Send Code End//

    //Reward Check Code Start
    relayRewardRoyaltyLoop($con,$memberId,$d);
    //Reward Check Code End ?>
<script>
    window.top.location.href="registerUserSuccess";
</script>
<?php } ?>
<?php include("../close-connection.php"); ?>