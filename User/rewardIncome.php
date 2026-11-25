<?php
require_once("loginCheck.php");
require_once('Include/Head.php');
require_once('Include/Sidebar.php');
?>

<div class="dashboard">
    <div class="income-report-container">
        <div class="page-breadcrumb">
            <p>Financial Report / <span>Reward Income</span></p>
        </div>

        <div class="report-card">

            <div class="table-responsive">
                <table class="income-table" id="example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>UserId</th>
                            <th>Name</th>
                            <th>Reward Amount</th>
                            <th>Reward Received</th>
                            <th>Achive Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        function salaryReceived($con, $memberId, $summaryId)
                        {
                            $query = mysqli_query($con, "SELECT sum(rewardIncome) from meddolic_user_reward_details WHERE summaryId='$summaryId' AND memberId='$memberId'");
                            $val1 = mysqli_fetch_array($query);
                            $total = $val1[0];
                            if ($total != "") {
                                echo "<span class='badge badge-success'>$ " . $total . "</span>";
                            } else {
                                echo "<span class='badge badge-danger'>$ 0.00</span>";
                            }
                        }
                        $count = 0;
                        $queryInvest = mysqli_query($con, "SELECT a.summaryId,a.memberId,a.rewardIncome,a.dateTime,a.rewardStatus,b.user_id,b.name FROM meddolic_user_reward_summary a, meddolic_user_details b WHERE a.memberId='$memberId' AND a.memberId=b.member_id ORDER BY a.dateTime DESC");
                        while ($valInvest = mysqli_fetch_assoc($queryInvest)) {
                            $count++; ?>
                            <tr>
                                <td><?= htmlspecialchars($count, ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($valInvest['user_id'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($valInvest['name'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><span class="badge badge-success">$
                                        <?= htmlspecialchars($valInvest['rewardIncome'], ENT_QUOTES, 'UTF-8') ?></span></td>
                                <td>
                                    <?= htmlspecialchars(salaryReceived($con, $memberId, $valInvest['summaryId']), ENT_QUOTES, 'UTF-8') ?>
                                </td>
                                <td><i class="fa fa-clock-o"></i>
                                    <?= htmlspecialchars(date("d-m-Y H:i:s", strtotime($valInvest['dateTime'])), ENT_QUOTES, 'UTF-8') ?>
                                </td>
                                <td>
                                    <?php
                                    if ($valInvest['rewardStatus'] == 1)
                                        echo "<span class='badge badge-warning'>ACHIEVED</span>";
                                    else if ($valInvest['rewardStatus'] == 2)
                                        echo "<span class='badge badge-danger'>STOP</span>";
                                    else if ($valInvest['rewardStatus'] == 3)
                                        echo "<span class='badge badge-success'>COMPLETED</span>";
                                    ?>
                                </td>
                                <td>
                                    <a href="rewardIncomeDetails?summary_id=<?= urlencode($valInvest['summaryId']) ?>"
                                        class="btn submit-purple-btn btn-sm"><i class="fa fa-eye"></i> More </a>
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