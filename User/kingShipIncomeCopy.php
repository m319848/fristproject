<?php
require_once("loginCheck.php");
require_once('Include/Head.php');
require_once('Include/Sidebar.php');
?>

<div class="dashboard">
    <div class="income-report-container">
        <div class="page-breadcrumb">
            <p>Financial Report / <span>KingShip Income</span></p>
        </div>

        <div class="report-card">

            <div class="table-responsive">
                <table class="income-table" id="example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>UserId</th>
                            <th>Name</th>
                            <th>Power Leg</th>
                            <th>Weaker Leg</th>
                            <th>Achive Date</th>
                            <th>Income Get</th>
                            <th>Status</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $count = 0;
                        $queryInvest = mysqli_query($con, "SELECT a.summaryId,a.otherLeg,a.oneLeg,a.memberId,a.rewardIncome,a.dateTime,a.rewardStatus,b.user_id,b.name FROM meddolic_user_reward_summary a, meddolic_user_details b WHERE a.memberId='$memberId' AND a.memberId=b.member_id  ORDER BY a.dateTime DESC");
                        while ($valInvest = mysqli_fetch_assoc($queryInvest)) {
                            $count++; ?>
                            <tr>
                                <td><?= $count ?></td>
                                <td><?= $valInvest['user_id'] ?></td>
                                <td><?= $valInvest['name'] ?></td>
                                <td><span class="badge badge-success"><i class="fa fa-usd"></i>
                                        <?= $valInvest['oneLeg'] ?>
                                    </span></td>
                                <td><span class="badge badge-success"><i class="fa fa-usd"></i>
                                        <?= $valInvest['otherLeg'] ?>
                                    </span></td>

                                <td><i class="fa fa-clock-o"></i> <?= $valInvest['dateTime'] ?></td>
                                <td><span class="badge badge-success"><i class="fa fa-usd"></i>
                                        <?= $valInvest['rewardIncome'] ?></span></td>
                                <td><?php if ($valInvest['rewardStatus'] == 1)
                                    echo "<span class='badge badge-info'>ACHIVED</span>";
                                else if ($valInvest['rewardStatus'] == 0)
                                    echo "<span class='badge badge-success'>CALM</span>";
                                else if ($valInvest['rewardStatus'] == 2)
                                    echo "<span class='badge badge-success'>COMPLETED</span>"; ?>
                                </td>

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>


        </div>
    </div>
</div>



<?php require_once("Include/Footer.php"); ?>