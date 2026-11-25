<?php
require_once("loginCheck.php");
require_once('Include/Head.php');
require_once('Include/Sidebar.php');
?>

<div class="dashboard">
    <div class="income-report-container">
        <div class="page-breadcrumb">
            <p>Financial Report / <span>Direct Income</span></p>
        </div>

        <div class="report-card">

            <div class="table-responsive">
                <table class="income-table" id="example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>UserId</th>
                            <th>Name</th>
                            <th>Direct Income</th>
                            <th>Package Price</th>
                            <th>Date</th>
                            <th>Income From</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 0;
                        $queryLevel = mysqli_query($con, "SELECT a.dateTime,a.directIncome,a.packagePrice,b.name,b.user_id,c.user_id AS childID,c.name AS childName FROM meddolic_user_sponsor_income a, meddolic_user_details b, meddolic_user_details c WHERE a.memberId=b.member_id AND a.childId=c.member_id AND a.memberId='$memberId'  ORDER BY a.dateTime DESC");
                        while ($valLevel = mysqli_fetch_assoc($queryLevel)) {
                            $count++; ?>
                            <tr>
                                <td><?= $count ?></td>
                                <td><?= $valLevel['user_id'] ?></td>
                                <td><?= $valLevel['name'] ?></td>
                                <td><span class="badge badge-success">
                                        $ <?= $valLevel['directIncome'] ?></span>
                                </td>
                                <td><span class="badge badge-success">
                                        $ <?= $valLevel['packagePrice'] ?></span></td>
                                <td><i class="fa fa-clock-o"></i>
                                    <?= date("d-m-Y H:i:s", strtotime($valLevel['dateTime'])); ?></td>
                                <td><strong><?= $valLevel['childName'] ?></strong> <br>
                                    <small>(<?= $valLevel['childID'] ?>)</small>
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