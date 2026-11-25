<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../conection.php");
require_once('../User/authIncomeFunction.php');
$d = date("Y-m-d H:i:s");
$todayDate = date("Y-m-d", strtotime($d));
ini_set('memory_limit', '-1');
$hour = date("H");
$currentDate = date('d');


//reward income code start
$queryR = mysqli_query($con, "SELECT memberId,summaryId,rewardIncome,rewardId,oneLeg,otherLeg,dueDate FROM meddolic_user_reward_summary  WHERE dueDate <='$d' AND  rewardStatus = 1 ORDER BY summaryId ASC");
while ($valPO = mysqli_fetch_assoc($queryR)) {
  $memberId = $valPO['memberId'];
  $summaryId = $valPO['summaryId'];
 $incomeAmount = $valPO['rewardIncome'];
  $rewardId = $valPO['rewardId'];
  $oneleg = $valPO['oneLeg'];
  $otherLeg = $valPO['otherLeg'];
  $duedate = $valPO['dueDate'];
 //capping start
  
 $userIncomeGet = userAllIncomeGet($con , $memberId);
        $totalGet = $userIncomeGet->totalGet;
        $cappingLimit = $userIncomeGet->cappingLimit;
        $totalFinal = $totalGet + $incomeAmount;
        if ($totalFinal >= $cappingLimit) {
         $rewardIncome = $cappingLimit - $totalGet;
        } else {
          $rewardIncome = $incomeAmount;
        }
 //capping end
 if( $rewardIncome > 0){
  $queryLv = mysqli_query($con, "INSERT INTO meddolic_user_reward_details (`memberId`,`summaryId`,`rewardId`,`oneLeg`,`otherLeg`,`rewardIncome`,`dateTime`) VALUES  ('$memberId','$summaryId','$rewardId','$oneleg','$otherLeg','$rewardIncome','$d')");
  incomeEntry($con, $memberId, $rewardInId, $rewardIncome, 18, $d);
 $nextDueDate = date('Y-m-d H:i:s', strtotime($dueDate . ' +5 minutes'));
//  $nextDueDate = date('Y-m-d H:i:s', strtotime($dueDate . ' +7 Days'));
  mysqli_query($con, "UPDATE meddolic_user_reward_summary SET dueDate= '$nextDueDate'  WHERE memberId='$memberId' AND summaryId='$summaryId'");
   
  // count row reward
  $queryPool = mysqli_query($con, "SELECT COUNT(1) FROM meddolic_user_reward_details WHERE memberId='$memberId' AND summaryId='$summaryId ' AND rewardId='$rewardId'");
  $valpoolCount = mysqli_fetch_array($queryPool); 
     if($valpoolCount[0] >=12){
     mysqli_query($con, "UPDATE meddolic_user_reward_summary SET rewardStatus=3  WHERE memberId='$memberId' AND summaryId='$summaryId' AND rewardId='$rewardId'");
  }
 }
}
//reward income code end
// monthly reward bouns code start
if ($currentDate == 1) {
  $queryMo = mysqli_query($con, "SELECT summaryId,memberId,monthlyIncome FROM meddolic_user_monthly_income  WHERE  rewardStatus= 0  ORDER BY summaryId ASC");
  while ($valMo = mysqli_fetch_assoc($queryMo)) {
    $summaryId = $valMo['summaryId'];
    $memberId = $valMo['memberId'];
    $monthlyIncome = $valMo['monthlyIncome'];

    //caping start
    $userIncomeGet = userAllIncomeGet($con, $memberId);
    $totalGet = $userIncomeGet->totalGet;
    $cappingLimit = $userIncomeGet->cappingLimit;
    $totalFinal = $totalGet + $$monthlyIncome;
    if ($totalFinal >= $cappingLimit) {
      $income = $cappingLimit - $totalGet;
      mysqli_query($con, "UPDATE meddolic_user_cashback_income_summary SET status=2  WHERE member_id='$memberId' ");
    } else {
      $income = $monthlyIncome;
    }
    incomeEntry($con, $memberId, $summaryId, $income, 15, $d);
    mysqli_query($con, "UPDATE meddolic_user_monthly_income SET rewardStatus= 1 WHERE memberId='$memberId'  AND summaryId='$summaryId '");

  }
  // monthly reward bouns code end
}

echo "E.O.F";
include("../../close-connection.php");