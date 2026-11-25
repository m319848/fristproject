<!DOCTYPE html>
<html lang="en">

<?php
include('include/head.php');
include("loginCheck.php");
include('include/header.php');
include('include/menu.php');
?>

<div id="main-content">
    <div class="container-fluid">

        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">
                    <h2>
                        <a href="javascript:void(0);" onclick="window.history.back();"
                            class="btn btn-xs btn-link btn-toggle-fullwidth">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                        Reward Release
                    </h2>

                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard"><i class="icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Member</li>
                        <li class="breadcrumb-item active">Reward Release</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">

                    <div class="header">
                        <h2>Pending Reward List</h2>
                    </div>

                    <div class="body">
                        <div class="table-responsive">

                            <table class="table table-hover js-basic-example dataTable table-custom mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User ID</th>
                                        <th>Reward</th>
                                        <th>Income</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php
                                    $count = 0;

                                    $queryReward = mysqli_query($con, "
    SELECT 
        a.*,
        b.user_id,
        b.name
    FROM meddolic_user_reward_income a
    INNER JOIN meddolic_user_details b 
        ON a.memberId = b.member_id
    ORDER BY a.summaryId DESC
");

                                    while ($valReward = mysqli_fetch_array($queryReward)) {

                                        $count++;
                                        ?>

                                        <tr>

                                            <td><?= $count ?></td>

                                            <td>
                                                <?= $valReward['user_id']; ?>
                                                <br>
                                                <small><?= $valReward['name']; ?></small>
                                            </td>

                                            <td>
                                                <span class="badge badge-primary">
                                                    <?= $valReward['rewardGift']; ?>
                                                </span>
                                            </td>

                                            <td>
                                                <span class="badge badge-success">
                                                    $<?= number_format($valReward['rewardIncome'], 2); ?>
                                                </span>
                                            </td>

                                            <td>
                                                <i class="fa fa-clock-o"></i>
                                                <?= $valReward['dateTime']; ?>
                                            </td>

                                            <td>
                                                <?php
                                                if ($valReward['rewardStatus'] == 1) {
                                                    echo '<span class="badge badge-warning">Pending</span>';
                                                } elseif ($valReward['rewardStatus'] == 2) {
                                                    echo '<span class="badge badge-success">Released</span>';
                                                } else {
                                                    echo '<span class="badge badge-danger">Closed</span>';
                                                }
                                                ?>
                                            </td>

                                            <td>

                                                <?php if ($valReward['rewardStatus'] == 1) { ?>

                                                    <a href="?release=<?= $valReward['summaryId']; ?>"
                                                        class="btn btn-success btn-sm"
                                                        onclick="return confirm('Are you sure want to release this reward?')">

                                                        Release
                                                    </a>

                                                <?php } else { ?>

                                                    <span class="badge badge-secondary">
                                                        Completed
                                                    </span>

                                                <?php } ?>

                                            </td>

                                        </tr>

                                    <?php } ?>

                                </tbody>

                            </table>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<?php

if (isset($_GET['release'])) {

    $summaryId = $_GET['release'];

    $queryUpdate = mysqli_query($con, "
        UPDATE meddolic_user_reward_income 
        SET rewardStatus='2' 
        WHERE summaryId='$summaryId'
    ");

    if ($queryUpdate) {

        echo "
        <script>
            alert('Reward Released Successfully');
            window.location.href='rewardRelease';
        </script>
        ";

    } else {

        echo "
        <script>
            alert('Something Went Wrong');
        </script>
        ";
    }
}

?>

<?php include('include/footer.php'); ?>

<script>
    var d = document.getElementById("income");
    d.className += " active";

    var d = document.getElementById("rewardRelease");
    d.className += " active";
</script>

</body>

</html>