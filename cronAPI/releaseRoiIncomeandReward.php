<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include("../conection.php");
require_once('../User/authIncomeFunction.php');
$d = date("Y-m-d H:i:s");
$todayDate = date("Y-m-d", strtotime($d));
ini_set('memory_limit', '-1');
$hour = date("H");
$currentDate = date('d');
$dayofweek = date('w');

// roi income code start
$queryNo = mysqli_query($con, "SELECT a.member_id,a.packagePrice,a.dueDate,a.summary_id,a.packageStatus FROM meddolic_user_cashback_income_summary a, meddolic_user_details b WHERE a.dueDate <='$d' AND a.member_id=b.member_id AND a.status = 1 AND b.topupFlag=1 AND b.acctStatus=1 ORDER BY a.summary_id ASC");
while ($valNo = mysqli_fetch_assoc($queryNo)) {

  $memberId = $valNo['member_id'];
  $packagePrice = $valNo['packagePrice'];
  $summary_id = $valNo['summary_id'];
  $dueDate = $valNo['dueDate'];
  $packageStatus = $valNo['packageStatus'];
  //recive income percent from package id
  $queryPackage = mysqli_query($con, "SELECT roiPercent FROM meddolic_config_misc_setting");
  $valPackage = mysqli_fetch_assoc($queryPackage);
  $dailyPercent = $valPackage['roiPercent'];
  // calculate roi
  $incomeAmount = ($packagePrice * $dailyPercent) / 100;

  //capping start nonworking 
  $checkTotalRoi = mysqli_query($con, "SELECT SUM(incomeAmount) as totalROI FROM meddolic_user_cashback_income_details WHERE member_id='$memberId'");
  $valTotal = mysqli_fetch_assoc($checkTotalRoi);
  $totalROI = $valTotal['totalROI'] ?? 0;

  $checkInvestment = mysqli_query($con, "SELECT SUM(investPrice) as totalInvestment FROM meddolic_user_activation_details WHERE member_id='$memberId'");
  $valInvestment = mysqli_fetch_assoc($checkInvestment);
  $totalInvestment = $valInvestment['totalInvestment'] ?? 0;
  $roiCap = $totalInvestment * 2;
  if ($totalROI == $roiCap) {
    mysqli_query($con, "UPDATE meddolic_user_cashback_income_summary SET status=0 WHERE summary_id='$summary_id' AND member_id='$memberId'");
    continue;
  }
  if ($totalROI + $dailyRoi > $roiCap) {
    $dailyRoi = $roiCap - $totalROI;
  }
  //capping End

  //capping working limit code start
  $userIncomeGet = userAllIncomeGet($con, $memberId);
  $totalGet = $userIncomeGet->totalGet;
  $cappingLimit = $userIncomeGet->cappingLimit;
  $totalFinal = $totalGet + $incomeAmount;
  if ($totalFinal >= $cappingLimit) {
    $dailyRoi = $cappingLimit - $totalGet;
    mysqli_query($con, "UPDATE meddolic_user_cashback_income_summary SET status=2  WHERE summary_id='$summary_id' AND member_id='$memberId' ");
  } else {
    $dailyRoi = $incomeAmount;
  }
  //capping code end
  $queryLv = mysqli_query($con, "INSERT INTO meddolic_user_cashback_income_details (`summary_id`,`member_id`,`incomeAmount`,`roiPercent`,`date_time`,`packageStatus`) VALUES ('$summary_id','$memberId','$dailyRoi','$dailyPercent','$d','$packageStatus')");
  $roiIncomeId = $con->insert_id;

  mysqli_query($con, "UPDATE meddolic_user_details SET roiWallet=roiWallet+'$dailyRoi' WHERE member_id='$memberId'");
  // incomeEntry($con, $memberId, $roiIncomeId, $dailyRoi, 17, $d);
//   $nextDueDate = date('Y-m-d H:i:s', strtotime($dueDate . ' +5 minutes'));

  if ($dayofweek == 5) {
    $nextDueDate = date('Y-m-d H:i:s', strtotime($dueDate . '+ 3 day'));
  } else {
    $nextDueDate = date('Y-m-d H:i:s', strtotime($dueDate . '+ 1 day'));
  }


  mysqli_query($con, "UPDATE meddolic_user_cashback_income_summary SET dueDate='$nextDueDate' WHERE member_id='$memberId'  AND summary_id='$summary_id '");
  //level income code start
  releaseLevelIncome($con, $memberId, $dailyRoi, $d);
  //level income code end
  //count day 
  $queryCount = mysqli_query($con, "SELECT COUNT(*) FROM meddolic_user_cashback_income_details WHERE member_id='$memberId'  AND summary_id= '$summary_id'");
  $ValCount = mysqli_fetch_array($queryCount);
  if ($ValCount[0] >= 200) {
    mysqli_query($con, "UPDATE meddolic_user_cashback_income_summary SET status= 0 WHERE member_id='$memberId'  AND summary_id='$summary_id '");
  }

}


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

  $userIncomeGet = userAllIncomeGet($con, $memberId);
  $totalGet = $userIncomeGet->totalGet;
  $cappingLimit = $userIncomeGet->cappingLimit;
  $totalFinal = $totalGet + $incomeAmount;
  if ($totalFinal >= $cappingLimit) {
    $rewardIncome = $cappingLimit - $totalGet;
  } else {
    $rewardIncome = $incomeAmount;
  }
  //capping end
  if ($rewardIncome > 0) {
    $queryLv = mysqli_query($con, "INSERT INTO meddolic_user_reward_details (`memberId`,`summaryId`,`rewardId`,`oneLeg`,`otherLeg`,`rewardIncome`,`dateTime`) VALUES  ('$memberId','$summaryId','$rewardId','$oneleg','$otherLeg','$rewardIncome','$d')");
    incomeEntry($con, $memberId, $rewardInId, $rewardIncome, 18, $d);
    //  $nextDueDate = date('Y-m-d H:i:s', strtotime($dueDate . ' +5 minutes'));
    $nextDueDate = date('Y-m-d H:i:s', strtotime($dueDate . ' +7 Days'));
    mysqli_query($con, "UPDATE meddolic_user_reward_summary SET dueDate= '$nextDueDate'  WHERE memberId='$memberId' AND summaryId='$summaryId'");

    // count row reward
    $queryPool = mysqli_query($con, "SELECT COUNT(1) FROM meddolic_user_reward_details WHERE memberId='$memberId' AND summaryId='$summaryId ' AND rewardId='$rewardId'");
    $valpoolCount = mysqli_fetch_array($queryPool);
    if ($valpoolCount[0] >= 12) {
      mysqli_query($con, "UPDATE meddolic_user_reward_summary SET rewardStatus=3  WHERE memberId='$memberId' AND summaryId='$summaryId' AND rewardId='$rewardId'");
    }
  }
}
//reward income code end

echo "E.O.F";
include("../../close-connection.php");