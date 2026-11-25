<?php
//Wallet Add & Statement Add Code Starts//
function incomeEntry($con, $memberId, $trnId, $incomeAmount, $statementId, $d)
{
  mysqli_query($con, "INSERT INTO meddolic_user_wallet_statement (`member_id`,`wallet_statement_id`,`deb_cr`,`amount`,`date_time`,`trn_id`) VALUES ('$memberId','$statementId',2,'$incomeAmount','$d','$trnId')");
  mysqli_query($con, "UPDATE meddolic_user_details SET wallet=wallet+'$incomeAmount' WHERE member_id='$memberId'");
}
//Wallet Add & Statement Add Code Ends//

//Capping limit code start working code start

function userAllIncomeGet($con, $memberId)
{
  $queryCurrent = mysqli_query($con, "SELECT SUM(investPrice) FROM meddolic_user_activation_details WHERE member_id='$memberId'");
  $valCurrent = mysqli_fetch_array($queryCurrent);
  $investmentAmount = $valCurrent[0];
  $queryBooster = mysqli_query($con, "SELECT * FROM meddolic_user_activation_details WHERE member_id='$memberId' AND purchaseType=2 ORDER BY id ASC LIMIT 1");
  $rowCount = mysqli_num_rows($queryBooster);
  if ($rowCount > 0) {
    //Booster package hai to capping limit 1.5 times hoga
    $cappingLimit = $investmentAmount * 1.5;
  } else {
    //Booster package nahi hai to capping limit 3 times hoga
    $cappingLimit = $investmentAmount * 3;
  }
  $queryAll = mysqli_query($con, "SELECT
    (SELECT SUM(incomeAmount) FROM meddolic_user_cashback_income_details WHERE member_id='$memberId' AND status=1) AS roiIncome,
       (SELECT SUM(levelIncome) FROM meddolic_user_level_income WHERE memberId='$memberId' AND releaseStatus=1 ) AS levelRoi,
       (SELECT SUM(directIncome) FROM meddolic_user_sponsor_income WHERE memberId='$memberId' AND releaseStatus=1 ) AS directIncome,
        (SELECT SUM(rewardIncome) FROM meddolic_user_reward_details WHERE memberId='$memberId') AS rewardIncome");
  $valAll = mysqli_fetch_assoc($queryAll);
  $roiIncome = $valAll['roiIncome'];
  $levelRoi = $valAll['levelRoi'];
  $directIncome = $valAll['directIncome'];
  $rewardIncome = $valAll['rewardIncome'];
  $totalGet = $roiIncome + $levelRoi + $directIncome + $rewardIncome;
  $newObj = new stdClass;
  $newObj->totalGet = $totalGet;
  $newObj->cappingLimit = $cappingLimit;
  return $newObj;
}
//Capping limit code start working code start

//=========================================================================================
function referralIncome($con, $sponserId, $memberId, $packagePrice, $sponsertoup, $d)
{
  if ($sponsertoup == 1) {
    $queryConfig = mysqli_query($con, "SELECT directPercent FROM  meddolic_config_misc_setting ");
    $valConfig = mysqli_fetch_assoc($queryConfig);
    $directPercent = $valConfig['directPercent'];
    $incomeAmount = $packagePrice * $directPercent / 100;
    //capping  code start
    $userIncomeGet = userAllIncomeGet($con, $sponserId);
    $totalGet = $userIncomeGet->totalGet;
    $cappingLimit = $userIncomeGet->cappingLimit;
    $totalFinal = $totalGet + $incomeAmount;
    if ($totalFinal >= $cappingLimit) {
      $directIncome = $cappingLimit - $totalGet;
    } else {
      $directIncome = $incomeAmount;
    }
    //capping code end
    if ($directIncome > 0) {
      $queryIn = mysqli_query($con, "INSERT INTO meddolic_user_sponsor_income (`memberId`,`childId`,`directIncome`,`packagePrice`,`directPercent`,`dateTime`,`releaseStatus`) VALUES ('$sponserId','$memberId','$directIncome','$packagePrice','$directPercent','$d',1)");
      $refIncomeId = $con->insert_id;
      incomeEntry($con, $sponserId, $refIncomeId, $directIncome, 3, $d);
    }
  }
}

//=========================================================================================

//Level income start
function releaseLevelIncome($con, $mainId, $packagePrice, $d)
{
  $queryNew = mysqli_query($con, "SELECT a.member_id,a.level FROM meddolic_user_child_ids a, meddolic_user_details b WHERE a.child_id='$mainId'  AND a.member_id=b.member_id AND b.topupFlag=1 AND b.acctStatus=1 AND userType=2 ORDER BY a.level ASC");
  while ($valNew = mysqli_fetch_assoc($queryNew)) {
    $parentId = $valNew['member_id'];
    $level = $valNew['level'];
    if ($level < 20) {
      $queryConfig = mysqli_query($con, "SELECT levelPercent,directNeed FROM meddolic_config_level_income WHERE level='$level'");
      $valConfig = mysqli_fetch_assoc($queryConfig);
      $levelPercent = $valConfig['levelPercent'];
      $directNeed = $valConfig['directNeed'];
      $queryDirect = mysqli_query($con, "SELECT COUNT(*) FROM meddolic_user_details WHERE sponser_id='$parentId'");
      $valDirect = mysqli_fetch_array($queryDirect);
      if ($directNeed <= $valDirect[0]) {
        $incomeAmount = $packagePrice * $levelPercent / 100;
        $userIncomeGet = userAllIncomeGet($con, $parentId);
        $totalGet = $userIncomeGet->totalGet;
        $cappingLimit = $userIncomeGet->cappingLimit;
        $totalFinal = $totalGet + $incomeAmount;
        if ($totalFinal >= $cappingLimit) {
          $levelIncome = $cappingLimit - $totalGet;
        } else {
          $levelIncome = $incomeAmount;
        }
        if ($levelIncome > 0) {
          $queryIn = mysqli_query($con, "INSERT INTO meddolic_user_level_income (`memberId`,`childId`,`level`,`levelIncome`,`childRoi`,`levelPercent`,`dateTime`) VALUES ('$parentId','$mainId','$level',' $levelIncome','$packagePrice','$levelPercent','$d')");
          $levelInId = $con->insert_id;
          incomeEntry($con, $parentId, $levelInId, $levelIncome, 16, $d);
        }
      }
    }
  }
}
//Level income code end 
// =========================================================================================== 
//booster  package code start
function boosterIncome($con, $parentId)
{
  $queryActive = mysqli_query($con, "SELECT activationDate,activationAmount FROM meddolic_user_details  WHERE member_id ='$parentId' AND topupFlag = 1 AND acctStatus=1");
  $valactDate = mysqli_fetch_assoc($queryActive);
  $activationDate = $valactDate['activationDate'];
  $activationAmount = $valactDate['activationAmount'];
  $dueActivation = date('Y-m-d H:i:s', strtotime($activationDate . ' +15 Days'));
  $queryDirect = mysqli_query($con, "SELECT COUNT(*) FROM meddolic_user_details  WHERE sponser_id ='$parentId' AND activationAmount='$activationAmount' AND activationDate <= '$dueActivation'");
  $valDirect = mysqli_fetch_array($queryDirect);
  if ($valDirect[0] == 5) {
    $boosterAmount = 2 * $activationAmount;
    mysqli_query($con, "UPDATE meddolic_user_activation_details SET investPrice = '$boosterAmount',purchaseType = 2 WHERE member_id='$parentId'  ORDER BY id ASC LIMIT 1");
    mysqli_query($con, "UPDATE meddolic_user_cashback_income_summary SET packagePrice = '$boosterAmount', packageStatus= 2 WHERE member_id='$parentId'  ORDER BY summary_id ASC LIMIT 1");
  }
}
//booster package code end
// ============================================================================================================

//reward income code start
function releaseRewardIncome($con, $parentId, $rewardId, $rewardIncome, $oneLeg, $otherLeg, $d)
{
  $items = array();
  $totalBus = 0;
  $queryBusss = mysqli_query($con, "SELECT member_id FROM meddolic_user_details WHERE sponser_id='$parentId' ORDER BY activationDate ASC");
  while ($valDirect = mysqli_fetch_assoc($queryBusss)) {
    $directId = $valDirect['member_id'];
    $queryOwn = mysqli_query($con, "SELECT SUM(investPrice) FROM meddolic_user_activation_details WHERE member_id='$directId'");
    $valOwn = mysqli_fetch_array($queryOwn);
    $queryBus = mysqli_query($con, "SELECT SUM(investPrice) FROM meddolic_user_activation_details WHERE  member_id IN ( SELECT child_id FROM meddolic_user_child_ids WHERE member_id='$directId' AND topup_status=1)");
    $valBus = mysqli_fetch_array($queryBus);
    $netBus = $valBus[0] + $valOwn[0];
    $totalBus += $netBus;
    $items[] = $netBus;
  }
  rsort($items);
  $firstLeg = $items[0] ?? 0;
  $restLeg = $totalBus - $firstLeg;
  $queryDebit = mysqli_query($con, "SELECT SUM(oneLeg),SUM(otherLeg) FROM meddolic_user_reward_summary WHERE memberId='$parentId'");
  $valDebit = mysqli_fetch_array($queryDebit);
  $oneDebit = $valDebit[0];
  $restDebit = $valDebit[1];
  $netOneLeg = $firstLeg - $oneDebit;
  $netRest = $restLeg - $restDebit;

  if ($netOneLeg >= $oneLeg && $netRest >= $otherLeg) {
    mysqli_query($con, "UPDATE meddolic_user_reward_summary SET rewardStatus = 2 WHERE memberId='$parentId'");
    //  $dueDate = date('Y-m-d H:i:s', strtotime(datetime: $d . '+10 minutes'));
    $dueDate = date('Y-m-d H:i:s', strtotime($d . '+1 day'));
    $queryLd = mysqli_query($con, "INSERT INTO meddolic_user_reward_summary (`memberId`,`rewardId`,`rewardIncome`,`oneLeg`,`otherLeg`,`dateTime`,`dueDate`,`rewardStatus`) VALUES ('$parentId','$rewardId','$rewardIncome','$oneLeg','$otherLeg','$d','$dueDate',1)");
    $rewardInId = $con->insert_id;
    mysqli_query($con, "UPDATE meddolic_user_details SET rewardRank = rewardRank +1 WHERE member_id='$parentId'");
    $nextRank = $rewardId + 1;

    if ($nextRank <= 11) {
      $queryCo = mysqli_query($con, "SELECT rewardId,rewardIncome,powerLeg,otherLeg FROM   meddolic_config_reward_income WHERE rewardId='$nextRank'");
      $valCo = mysqli_fetch_assoc($queryCo);
      $newRewardId = $valCo['rewardId'];
      $rewardIncome = $valCo['rewardIncome'];
      $oneLeg = $valCo['powerLeg'];
      $otherLeg = $valCo['otherLeg'];
      releaseRewardIncome($con, $parentId, $newRewardId, $rewardIncome, $oneLeg, $otherLeg, $d);
    }
  }
}

function relayRewardLoop($con, $memberId, $d)
{
  $queryReward = mysqli_query($con, "SELECT a.member_id,b.rewardRank FROM meddolic_user_child_ids a, meddolic_user_details b WHERE a.child_id='$memberId' AND a.member_id=b.member_id");
  while ($valReward = mysqli_fetch_assoc($queryReward)) {
    $parentId = $valReward['member_id'];
    $currentReward = $valReward['rewardRank'];
    $nextReward = $currentReward + 1;
    if ($nextReward <= 11) {
      $queryConfig = mysqli_query($con, "SELECT rewardId,rewardIncome,powerLeg,otherLeg  FROM meddolic_config_reward_income WHERE  rewardId='$nextReward'");
      $valConfig = mysqli_fetch_assoc($queryConfig);
      $rewardId = $valConfig['rewardId'];
      $rewardIncome = $valConfig['rewardIncome'];
      $oneLeg = $valConfig['powerLeg'];
      $otherLeg = $valConfig['otherLeg'];
      releaseRewardIncome($con, $parentId, $rewardId, $rewardIncome, $oneLeg, $otherLeg, $d);
    }
  }
}