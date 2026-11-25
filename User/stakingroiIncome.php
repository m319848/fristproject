<?php
require_once("loginCheck.php");
require_once('Include/Head.php');
require_once('Include/Sidebar.php');
?>

<div class="dashboard">
    <div class="income-report-container">
        <div class="page-breadcrumb">
            <p>Financial Report / <span>Daily Staking Bonus</span></p>
        </div>

        <div class="report-card">

            <div class="table-responsive">
                <table class="income-table" id="example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>UserId</th>
                            <th>Name</th>
                            <th>Invest Amount</th>
                            <th>Cashback Received</th>
                            <th>Release Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        function roiReceived($con, $memberId, $summaryId)
                        {
                            $query = mysqli_query($con, "SELECT sum(incomeAmount) from meddolic_user_cashback_income_details WHERE summary_id='$summaryId' AND status=1");
                            $val1 = mysqli_fetch_array($query);
                            $total = $val1[0];
                            if ($total != "") {
                                echo "<span class='badge badge-success'><i class='fa fa-usd'></i> " . $total . "</span>";
                            } else {
                                echo "<span class='badge badge-danger'><i class='fa fa-usd'></i> 0.00</span>";
                            }
                        }
                        $count = 0;
                        $queryInvest = mysqli_query($con, "SELECT a.summary_id,a.member_id,a.packagePrice,a.date_Time,a.dueDate,a.status,b.user_id,b.name FROM meddolic_user_cashback_income_summary a, meddolic_user_details b WHERE a.member_id='$memberId' AND a.member_id=b.member_id AND a.packageStatus=1 AND a.status IN (1,2) ORDER BY a.date_Time DESC");
                        while ($valInvest = mysqli_fetch_assoc($queryInvest)) {
                            $count++; ?>
                            <tr>
                                <td>
                                    <?= $count ?>
                                </td>
                                <td>
                                    <?= $valInvest['user_id'] ?>
                                </td>
                                <td>
                                    <?= $valInvest['name'] ?>
                                </td>
                                <td><span class="badge badge-success"><i class="fa fa-usd"></i>
                                        <?= $valInvest['packagePrice'] ?>
                                    </span></td>

                                <td>
                                    <?= roiReceived($con, $memberId, $valInvest['summary_id']) ?>
                                </td>
                                <td><i class="fa fa-clock-o"></i>
                                    <?= date("d-m-Y H:i:s", strtotime($valInvest['dueDate'])); ?>
                                </td>
                                <td>
                                    <?php if ($valInvest['status'] == 1)
                                        echo "<span class='badge badge-primary'>RUNNING</span>";
                                    else if ($valInvest['status'] == 2)
                                        echo "<span class='badge badge-primary'>RUNNING</span>";
                                    else if ($valInvest['status'] == 3)
                                        echo "<span class='badge badge-success'>COMPLETED</span>"; ?>
                                </td>
                                <td><a href="roiIncomeDetails?summary_id=<?= $valInvest['summary_id'] ?>"
                                        class="btn submit-purple-btn btn-sm"><i class="fa fa-eye"></i> More </a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>


        </div>
    </div>
</div>



<?php require_once("Include/Footer.php"); ?>