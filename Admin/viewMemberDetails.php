<!DOCTYPE html>
<html lang="en">
<?php include('include/head.php');
include("loginCheck.php");
include('include/header.php');
include('include/menu.php'); ?>
<?php
$user_id1 = $_GET['user_id'];
$query = "SELECT * from meddolic_user_details where user_id='$user_id1'";
$result = mysqli_query($con, $query);
$val1 = mysqli_fetch_array($result);
$member_id1 = $val1['member_id'];
$mt5Id = $val1['mt5Id'];
$name = $val1['name'];
$user_id = $val1['user_id'];
$phone = $val1['phone'];
$date_time = $val1['date_time'];
$email_id = $val1['email_id'];
$bank = $val1['bankName'];
$branch = $val1['branchName'];
$account_number = $val1['account_no'];
// $account_name = $val1['account_name'];
$ifsc = $val1['ifsc'];
// $date_time_bank_update = $val1['date_time_bank_update'];
// $pan_card = $val1['pan_card'];
// $aadhar_card = $val1['aadhar_card'];
$sponser_id = $val1['sponser_id'];
$password = $val1['password'];
$trnPassword = $val1['trnPassword'];
// $kycId = $val1['kycId'];
// $pin_code = $val1['pin_code'];


$result = mysqli_query($con, "SELECT * from meddolic_user_details where member_id='$sponser_id'");
$val = mysqli_fetch_array($result);
$sponser_name = $val['name'];
$sponser_user_id = $val['user_id'];

$result = mysqli_query($con, "SELECT * from meddolic_user_wallet_address_details where member_id='$member_id1'");
$val = mysqli_fetch_array($result);
$walletAddress = $val['walletAddress'];

// if ($kycId != "") {
//     $queryKyc = mysqli_query($con, "SELECT * FROM meddolic_user_kyc_details WHERE kycId='$kycId' AND member_id='$member_id'");
//     $valKyc = mysqli_fetch_assoc($queryKyc);
// } ?>
<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">
                    <h2><a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> View Member</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item"> Members </a></li>
                        <li class="breadcrumb-item active"> View Member</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="body">
                        <h6>Basic Information</h6>
                        <form method="POST" action="updatePersonalDetails" onsubmit="return confirm('Are you sure?')">
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">User Id * :</label>
                                        <input class="form-control" value="<?= $user_id ?>" disabled>
                                        <input type="hidden" name="user_id" value="<?= $user_id1 ?>">
                                        <input type="hidden" name="member_id1" value="<?= $member_id1 ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Name * :</label>
                                        <input type="text" class="form-control" value="<?= $name ?>" required name="name">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Phone * :</label>
                                        <input type="number" class="form-control" value="<?= $phone ?>" required name="phone" onkeypress="return onlynum(event)" maxlength="10" onblur="phone_valid(this.value)" id="phone">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Email ID * :</label>
                                        <input class="form-control" value="<?= $email_id ?>" name="email_id" placeholder="Enter EmailID">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Sponser Id * :</label>
                                        <input class="form-control" disabled="" value="<?= $sponser_name ?> (<?= $sponser_user_id ?>)" placeholder="Enter Sponser Id">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Date of Joining * :</label>
                                        <input class="form-control" disabled value="<?= $date_time ?>" name="date_time">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Login Password * :</label>
                                        <input class="form-control" type="text" name="password" required value="<?= $password ?>" placeholder="Enter Login Password">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Transaction Password * :</label>
                                        <input class="form-control" type="text" name="trnPassword" required value="<?= $trnPassword ?>" placeholder="Enter Login Password">

                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button> &nbsp;&nbsp;
                            <button class="btn btn-danger" onclick="location.reload()">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="body">
                        <h6>Wallet Address Update</h6>
                        <form method="POST" action="updateWalletAddress" onsubmit="return confirm('Are you sure?')">
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Wallet Address * :</label>
                                        <input type="text" class="form-control" value="<?= $walletAddress ?>" required
                                            name="wallet_address" placeholder="Enter Wallet Address">
                                        <input type="hidden" name="user_id" value="<?= $user_id1 ?>">
                                        <input type="hidden" name="member_id1" value="<?= $member_id1 ?>">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button> &nbsp;&nbsp;
                            <button class="btn btn-danger" onclick="location.reload()">Cancel</button>
                        </form>
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
    var d = document.getElementById("viewMember");
    d.className += " active";
</script>
</body>

</html>