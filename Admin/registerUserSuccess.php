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
                    <h2><a href="javascript:void(0);" onclick="window.history.back();"
                            class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>
                        Register User Details</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item"> Member </li>
                        <li class="breadcrumb-item active"> Register User Details</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="alert text-white bg-success" role="alert">
            <div class="iq-alert-text">Welcome To Fund X . Your Account Created Successfully</div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="ri-close-line"></i>
            </button>
        </div>
        <?php
        $result = mysqli_query($con, "SELECT user_id,sponser_id,walletAddress FROM meddolic_user_details WHERE member_id='$_SESSION[new_user_id]'");
        $val = mysqli_fetch_array($result);
        $user_id = $val['user_id'];
        $walletAddress = $val['walletAddress'];
        $sponser_id = $val['sponser_id'];

        $result = mysqli_query($con, "SELECT user_id FROM meddolic_user_details WHERE member_id='$sponser_id'");
        $val = mysqli_fetch_array($result);
        $sponser_user_id = $val['user_id']; ?>
        <div class="row clearfix">
            <div class="col-md-6">
                <div class="card">
                    <div class="header">
                        <h2>Register User Details</h2>
                    </div>
                    <div class="body">
                        <fieldset>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>UserId *</label>
                                        <input type="text" class="form-control" value="<?= $user_id ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Wallet Address *</label>
                                        <input type="text" class="form-control" value="<?= $walletAddress ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Sponser's User ID *</label>
                                        <input type="text" class="form-control" value="<?= $sponser_user_id ?>"
                                            disabled>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('include/footer.php'); ?>
<script>
    var d = document.getElementById("Members");
    d.className += " active";
    var d = document.getElementById("registerUser");
    d.className += " active";
</script>
</body>

</html>