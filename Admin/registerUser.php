<!DOCTYPE html>
<html lang="en">
<?php include('include/head.php');
      include("loginCheck.php");
      include('include/header.php');
      include('include/menu.php'); ?>
<?php 
  $queryPackage=mysqli_query($con,"SELECT minInvest FROM meddolic_config_misc_setting");
  $valPackage = mysqli_fetch_assoc($queryPackage);
  $minInvest=$valPackage['minInvest']; ?>
<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">                        
                    <h2><a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Register User</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item"> Member </li>
                        <li class="breadcrumb-item active"> Register User</li>
                    </ul>
                </div>            
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-md-6">
                <div class="card">
                    <div class="header">
                        <h2>Register User</h2>
                    </div>
                    <div class="body">
                        <form method="POST" action="registerUserProcess" onsubmit="return confirm('Are you sure?')" >
                            <fieldset>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Sponser's User ID *</label>
                                            <input type="text" name="sponser_id" id="sponser_id" class="form-control" placeholder="e.g. john12345" onblur="sponser_valid(this.value)" required autofocus>
                                            <input type="hidden" name="loginMemberId" id="loginMemberId" class="form-control" readonly value="<?=$member_id?>">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Sponser Address *</label>
                                            <input type="text" name="sponser_name" id="sponser_name" class="form-control" placeholder="Sponser Address"  disabled >
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Leg Position *</label>
                                            <select class="form-control" name="legPosition" required>
                                                <option value="">- Select Side -</option>
                                                <option value="2">Left Leg</option>
                                                <option value="3">Right Leg</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Name *</label>
                                            <input type="text" class="form-control" name="name" placeholder="Enter Name " id="name" required >
                                        </div>
                                   </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Email Id *</label>
                                            <input type="email" class="form-control" name="emailId" placeholder="Enter Email Id" id="emailId" required >
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Wallet Address *</label>
                                            <input type="text" class="form-control" name="walletAddress" placeholder="Enter Wallet Address " id="walletAddress" required >
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Registration Fee *</label>
                                            <input type="text" id="investAmount" name="investAmount" class="form-control" placeholder="Enter Invest Amount" required onkeypress="return onlynum(event)" value="<?=$minInvest?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" name="registerNow" class="btn btn-primary action-button float-left" value="Register Now" >Register Now</button>
                            </fieldset>
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
var d = document.getElementById("registerUser");
    d.className += " active";
</script>
</body>
</html> 