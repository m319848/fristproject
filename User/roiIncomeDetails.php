<?php
require_once("loginCheck.php");
require_once('Include/Head.php');
require_once('Include/Sidebar.php');
?>

<div class="dashboard">
    <div class="income-report-container">
        <div class="page-breadcrumb">
            <p>Financial Report / <span>Booster Package Income Details</span></p>
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
                            <!--<th>Income Day</th>-->
                            <th>Release Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 0;
                        $queryDeal = mysqli_query($con, "SELECT a.member_id,a.incomeAmount,a.date_time,b.user_id,b.name FROM meddolic_user_cashback_income_details a, meddolic_user_details b WHERE a.summary_id='$_GET[summary_id]' AND a.member_id=b.member_id AND a.status=1 ORDER BY a.date_time ASC");
                        while ($valDeal = mysqli_fetch_assoc($queryDeal)) {
                            $count++; ?>
                            <tr>
                                <td><?= $count ?></td>
                                <td><?= $valDeal['user_id'] ?></td>
                                <td><?= $valDeal['name'] ?></td>
                                <td><span class="badge badge-success"><i class="fa fa-usd"></i>
                                        <?= $valDeal['incomeAmount'] ?></span></td>
                                <!--<td><?= $count ?> Month</td>-->
                                <td><i class="fa fa-clock-o"></i>
                                    <?= date("d-m-Y H:i:s", strtotime($valDeal['date_time'])); ?>
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