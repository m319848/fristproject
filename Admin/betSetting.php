<!DOCTYPE html>
<html lang="en">

<?php
include('include/head.php');
include("loginCheck.php");
include('include/header.php');
include('include/menu.php');


// UPDATE TRADE TYPE
if (isset($_POST['updateTradeType'])) {

    $tradeType = mysqli_real_escape_string($con, $_POST['tradeType']);

    mysqli_query($con, "
        UPDATE meddolic_config_misc_setting
        SET tradeType='$tradeType'
    ");

    echo "
    <script>
        alert('Trade Type Updated Successfully');
        window.location.href='betSetting';
    </script>
    ";
}
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

                        Trade Setting
                    </h2>

                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard">
                                <i class="icon-home"></i>
                            </a>
                        </li>

                        <li class="breadcrumb-item">
                            Setting
                        </li>

                        <li class="breadcrumb-item active">
                            Trade Setting
                        </li>
                    </ul>

                </div>

            </div>
        </div>



        <div class="row clearfix">

            <div class="col-lg-12 col-md-12 col-sm-12">

                <div class="card">

                    <div class="header">
                        <h2>Trade Win/Loss Setting</h2>
                    </div>

                    <div class="body">

                        <div class="table-responsive">

                            <table class="table table-hover table-custom mb-0">

                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Current Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php

                                    $count = 0;

                                    $queryTrade = mysqli_query($con, "
                                        SELECT id,tradeType
                                        FROM meddolic_config_misc_setting
                                    ");

                                    while ($valTrade = mysqli_fetch_assoc($queryTrade)) {

                                        $count++;
                                        ?>

                                        <tr>

                                            <td><?= $count ?></td>

                                            <td>

                                                <?php
                                                if ($valTrade['tradeType'] == 1) {
                                                    echo '<span class="badge badge-success">WIN</span>';
                                                } else {
                                                    echo '<span class="badge badge-danger">LOSS</span>';
                                                }
                                                ?>

                                            </td>

                                            <td>

                                                <form method="POST">

                                                    <?php
                                                    if ($valTrade['tradeType'] == 1) {
                                                        ?>

                                                        <input type="hidden" name="tradeType" value="0">

                                                        <button type="submit" name="updateTradeType"
                                                            class="btn btn-danger btn-sm">
                                                            Set LOSS
                                                        </button>

                                                        <?php
                                                    } else {
                                                        ?>

                                                        <input type="hidden" name="tradeType" value="1">

                                                        <button type="submit" name="updateTradeType"
                                                            class="btn btn-success btn-sm">
                                                            Set WIN
                                                        </button>

                                                    <?php } ?>

                                                </form>

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

<?php include('include/footer.php'); ?>

<script>

    var d = document.getElementById("Setting");
    d.className += " active";
    var d = document.getElementById("betSetting");
    d.className += " active";

</script>

</body>

</html>