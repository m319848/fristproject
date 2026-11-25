<?php
require_once("loginCheck.php");
require_once('Include/Head.php');
require_once('Include/Sidebar.php');
?>

<div class="dashboard">
    <div class="income-report-container">
        <div class="page-breadcrumb">
            <p>Financial Report / <span>Trade Performance Income</span></p>
        </div>

        <div class="report-card">

            <div class="table-responsive">
                <table class="income-table" id="example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Level</th>
                            <th>Level Income</th>
                            <th>Level Percent</th>
                            <th>Income Date</th>
                            <th>Child Name</th>
                            <th>Child ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 0;
                        $queryLevel = mysqli_query($con, "SELECT b.name,b.user_id,a.dateTime,a.levelIncome,a.level,a.levelPercent,c.user_id AS childID,c.name AS childName FROM meddolic_user_trade_level_income a, meddolic_user_details b, meddolic_user_details c WHERE a.memberId=b.member_id AND a.childId=c.member_id AND a.memberId='$memberId' order by a.dateTime DESC");
                        while ($valLevel = mysqli_fetch_assoc($queryLevel)) {
                            $count++; ?>
                            <tr>
                                <td><?= $count ?></td>
                                <td><?= $valLevel['user_id'] ?></td>
                                <td><?= $valLevel['name'] ?></td>
                                <td>Level <?= $valLevel['level'] ?></td>
                                <td><span class="badge badge-success"> $
                                        <?= $valLevel['levelIncome'] ?></span></td>
                                <td><span class="badge badge-success"><?= $valLevel['levelPercent'] ?>
                                        %</span></td>
                                <td><i class="fa fa-clock-o"></i> <?= $valLevel['dateTime'] ?></td>
                                <td><?= $valLevel['childName'] ?></td>
                                <td><?= $valLevel['childID'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>


        </div>
    </div>
</div>



<?php require_once("Include/Footer.php"); ?>