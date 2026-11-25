<?php
require_once("loginCheck.php");
require_once('Include/Head.php');
require_once('Include/Sidebar.php');
?>

<div class="dashboard">
    <div class="income-report-container">

        <div class="page-breadcrumb">
            <p>Team Network / <span>My Level Team</span></p>
        </div>

        <div class="report-card">
            <div class="table-responsive">

                <table class="income-table" id="example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Level Number.</th>
                            <th>Total Member</th>
                            <th>Total Business</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        function totalInvest($con, $memberId, $level)
                        {
                            $queryInvest = mysqli_query($con, "SELECT SUM(investPrice) FROM meddolic_user_activation_details WHERE member_id IN (SELECT child_id FROM meddolic_user_child_ids WHERE member_id='$memberId' AND level='$level')");
                            $valInvest = mysqli_fetch_array($queryInvest);
                            if ($valInvest[0] != "") {
                                return $valInvest[0];
                            } else {
                                echo "0.00";
                            }
                        }
                        for ($level = 1; $level <= 20; $level++) {
                            $queryMember = mysqli_query($con, "SELECT COUNT(1) FROM meddolic_user_child_ids WHERE member_id='$memberId' AND level='$level'");
                            $valMember = mysqli_fetch_array($queryMember); ?>
                            <tr>
                                <td><?= $level ?></td>
                                <td>Level <?= $level ?></td>
                                <td class="text-success"><i class="fa fa-user"></i>
                                    <?= isset($valMember[0]) ? $valMember[0] : '0'; ?></td>
                                <td><span class="badge badge-success">$
                                        <?= totalInvest($con, $memberId, $level) ?></span></td>
                                <td><a href="levelTeamDetails?LevelId=<?= $level ?>"
                                        class="btn submit-purple-btn btn-sm">More</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
        </div>

    </div>
</div>

<?php require_once("Include/Footer.php"); ?>

<script>
    $(document).ready(function () {

        // destroy old instance first
        if ($.fn.DataTable.isDataTable('#example')) {
            $('#example').DataTable().destroy();
        }

        $('#example').DataTable({
            responsive: true
        });

    });
</script>