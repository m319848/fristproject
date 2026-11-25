<?php
require_once("loginCheck.php");
require_once('Include/Head.php');
require_once('Include/Sidebar.php');
?>

<div class="dashboard">
    <div class="income-report-container">
        <div class="page-breadcrumb">
            <p>Financial Report / <span>KingShip Profit</span></p>
        </div>

        <div class="report-card">

            <div class="table-responsive">
                <table class="income-table" id="example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>UserId</th>
                            <th>Name</th>
                            <!-- <th>Rank Name</th> -->
                            <!-- <th>Daily Income</th> -->
                            <th>Achive Date</th>
                            <th>Income Get</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        function rankReceived($con, $memberId, $summaryId)
                        {
                            $querySum = mysqli_query($con, "SELECT SUM(rewardIncome) FROM meddolic_user_reward_detail WHERE member_id='$memberId' AND summaryI_id='$summaryId' AND status=1 ");
                            $valSum = mysqli_fetch_array($querySum);
                            $totalGet = $valSum[0];
                            if ($totalGet != '') {
                                echo "<span class='badge badge-success'>$ " . $totalGet . "</span>";
                            } else {
                                echo "<span class='badge badge-danger'>$ 0.00</span>";
                            }
                        }
                        $count = 0;
                        $queryInvest = mysqli_query($con, "SELECT a.summaryId,a.memberId,a.dateTime,a.rewardStatus,b.user_id,b.name FROM meddolic_user_reward_summary a, meddolic_user_details b WHERE a.memberId='$memberId' AND a.memberId=b.member_id  ORDER BY a.dateTime DESC");
                        while ($valInvest = mysqli_fetch_assoc($queryInvest)) {
                            $count++; ?>
                            <tr>
                                <td><?= $count ?></td>
                                <td><?= $valInvest['user_id'] ?></td>
                                <td><?= $valInvest['name'] ?></td>
                                <!-- <td><?= $valInvest['rewardName'] ?></td> -->
                                <!-- <td><span class="badge badge-success">SUI <?= $valInvest['rewardSalary'] ?></span></td> -->
                                <td><i class="fa fa-clock-o"></i> <?= $valInvest['dateTime'] ?></td>
                                <td><?= rankReceived($con, $memberId, $valInvest['summaryId']) ?></td>
                                <td><?php if ($valInvest['rewardStatus'] == 1)
                                    echo "<span class='badge badge-info'>ACHIVED</span>";
                                else if ($valInvest['rewardStatus'] == 0)
                                    echo "<span class='badge badge-success'>CALM</span>";
                                else if ($valInvest['rewardStatus'] == 2)
                                    echo "<span class='badge badge-success'>COMPLETED</span>"; ?>
                                </td>
                                <td><a href="royaltyBonusDetails?summaryId=<?= $valInvest['summaryId'] ?>"
                                        class="submit-purple-btn btn-xs"><i class="fa fa-eye"></i> More </a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>


        </div>
    </div>
</div>



<?php require_once("Include/Footer.php"); ?>