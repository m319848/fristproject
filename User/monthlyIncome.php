<?php
require_once("loginCheck.php");
require_once('Include/Head.php');
require_once('Include/Sidebar.php');
?>

<div class="dashboard">
    <div class="income-report-container">
        <div class="page-breadcrumb">
            <p>Financial Report / <span>Binary Income</span></p>
        </div>

        <div class="report-card">

            <div class="table-responsive">
                <table class="income-table" id="example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>UserId</th>
                            <th>Name</th>
                            <th>Monthly Income</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 0;
                        $queryLevel = mysqli_query($con, "SELECT a.dateTime,a.monthlyIncome,a.rewardStatus,b.name,b.user_id FROM meddolic_user_monthly_income a, meddolic_user_details b WHERE a.memberId=b.member_id AND  a.memberId='$memberId'  ORDER BY a.dateTime DESC");
                        while ($valLevel = mysqli_fetch_assoc($queryLevel)) {
                            $count++; ?>
                            <tr>
                                <td>
                                    <?= $count ?>
                                </td>
                                <td>
                                    <?= $valLevel['user_id'] ?>
                                </td>
                                <td>
                                    <?= $valLevel['name'] ?>
                                </td>

                                <td>
                                    <span class="badge badge-success">
                                        <i class="fa fa-usd"></i> <?= $valLevel['monthlyIncome'] ?></span>

                                </td>
                                <td><i class="fa-regular fa-clock"></i>
                                    <?= date("d-m-Y H:i:s", strtotime($valLevel['dateTime'])) ?>
                                </td>
                                <td>
                                    <?php if ($valLevel['rewardStatus'] == 0) {
                                        echo '<span class="badge badge-warning">Pending</span>';
                                    } elseif ($valLevel['rewardStatus'] == 1) {
                                        echo '<span class="badge badge-success">Released</span>';
                                    } else {
                                        echo '<span class="badge badge-danger">Rejected</span>';
                                    }

                                    ?>
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