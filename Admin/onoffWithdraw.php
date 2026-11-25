<!DOCTYPE html>
<html lang="en">
<?php include('include/head.php');
include("loginCheck.php");
include('include/header.php');
include('include/menu.php'); ?>
<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">
                    <h2><a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>ON OFF Withdraw</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item"> Setting </a></li>
                        <li class="breadcrumb-item active">ON OFF Withdraw</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>ON OFF Withdraw</h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-hover js-basic-example dataTable table-custom mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Withdraw ON/OFF</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $queryConfig = mysqli_query($con, "SELECT * from meddolic_config_misc_setting");
                                    $valConfig = mysqli_fetch_assoc($queryConfig);
                                    ?>
                                    <tr>
                                        <td>1</td>
                                        <td>User Withdraw ON OFF</td>
                                        <td>
                                            <?php if ($valConfig['withdrawStatus'] == 0) { ?>
                                                <button class="btn btn-success" onclick="updateWithdrawStatus(1)">ON</button>
                                            <?php } else { ?>
                                                <button class="btn btn-danger" onclick="updateWithdrawStatus(0)">OFF</button>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                </tbody>

                                <script>
                                    function updateWithdrawStatus(status) {
                                        var xhr = new XMLHttpRequest();
                                        xhr.open("POST", "updateWithdrawStatus.php", true);
                                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                        xhr.onreadystatechange = function() {
                                            if (xhr.readyState == 4 && xhr.status == 200) {
                                                alert(xhr.responseText);
                                                location.reload();
                                            }
                                        };
                                        xhr.send("status=" + status);
                                    }
                                </script>

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
    var d = document.getElementById("onoffWithdraw");
    d.className += " active";
</script>
</body>

</html>