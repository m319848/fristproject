<?php
require_once("loginCheck.php");
require_once('Include/Head.php');
require_once('Include/Sidebar.php');
?>

<div class="dashboard">
    <div class="income-report-container">
        <div class="page-breadcrumb">
            <p>Financial Report / <span>Level Income</span></p>
        </div>

        <div class="report-card">

            <div class="table-responsive">
                <table class="income-table" id="example">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>User Id</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Release Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 0;
                        $queryDeal = mysqli_query($con, "SELECT a.rewardIncome,a.dateTime,b.user_id,b.name FROM meddolic_user_reward_details a, meddolic_user_details b WHERE a.summaryId='$_GET[summary_id]' AND a.memberId=b.member_id ORDER BY a.dateTime ASC");
                        while ($valDeal = mysqli_fetch_assoc($queryDeal)) {
                            $count++; ?>
                            <tr>
                                <td><?= $count ?></td>
                                <td><?= $valDeal['user_id'] ?></td>
                                <td><?= $valDeal['name'] ?></td>
                                <td><span class="badge badge-success">$ <?= $valDeal['rewardIncome'] ?></span></td>
                                <td><i class="fa fa-clock-o"></i>
                                    <?= date("d-m-Y H:i:s", strtotime($valDeal['dateTime'])); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>


        </div>
    </div>
</div>



<?php require_once("Include/Footer.php"); ?>