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
                            class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>Spacial
                        Extra Income</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item">Member</a></li>
                        <li class="breadcrumb-item active">Extra Income</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-md-6">
                <div class="card">
                    <div class="header">
                        <h2>Extra Income</h2>
                    </div>
                    <div class="body">
                        <form method="POST" action="extraIncomeBack">
                            <fieldset>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>User ID *</label>
                                            <input type="text" name="sponser_id" id="sponser_id" class="form-control"
                                                placeholder="e.g. john12345" onblur="sponser_valid(this.value)" required
                                                autofocus>
                                            <input type="hidden" name="login_member_id" value="<?= $member_id ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label> Name *</label>
                                            <input type="text" name="sponser_name" id="sponser_name"
                                                class="form-control" placeholder="e.g. John Doe" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label> Amount *</label>
                                            <input type="text" name="amount" id="amount" class="form-control"
                                                placeholder="0.00" required>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" name="activeNow" class="btn btn-primary action-button float-left"
                                    value="Transfer Now">Transfer
                                    Now</button>
                                <button type="button" name="previous"
                                    class="btn btn-danger action-button-previous float-left ml-3" value="Reset"
                                    onclick="location.reload()">Reset</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Extra Income History</h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-hover js-basic-example dataTable table-custom mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>UserId</th>
                                        <th>Name</th>
                                        <th>Transfer Amount</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 0;
                                    $queryFund = mysqli_query($con, "SELECT a.*,b.user_id,b.name from meddolic_user_spacial_income_history a, meddolic_user_details b WHERE a.member_id=b.member_id ORDER BY a.date_time DESC");
                                    while ($valFund = mysqli_fetch_array($queryFund)) {
                                        $count++; ?>
                                        <tr>
                                            <td><?= $count; ?></td>
                                            <td><?= $valFund['user_id']; ?></td>
                                            <td><?= $valFund['name']; ?></td>
                                            <td><?= $valFund['amount']; ?></td>
                                            <td><i class="fa fa-clock-o"></i> <?= $valFund['date_time']; ?></td>
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
    var d = document.getElementById("Members");
    d.className += " active";
    var d = document.getElementById("extraIncome");
    d.className += " active";
</script>
</body>

</html>