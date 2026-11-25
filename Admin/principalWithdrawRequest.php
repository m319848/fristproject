<!DOCTYPE html>
<html lang="en">
<?php include("loginCheck.php"); ?>
<?php include('include/head.php');
include('include/menu.php');
include('include/header.php'); ?>
<?php
$user_id1 = "";
if ($_GET) {
    if ($_GET['user_id']) {
        $user_id1 = $_GET['user_id'];
        $query = "SELECT count(*) from meddolic_user_details WHERE user_id='$user_id1'";
        $result = mysqli_query($con, $query);
        $val = mysqli_fetch_array($result);
        if ($val[0] == 0) { ?>
            <script>
                alert("Invalid User Id");
            </script>
                        <?php
                        $user_id1 = $_SESSION['admin_user_id'];
        }
    }
    if ($_GET['withdrawStatus']) {
        $withdrawStatus = $_GET['withdrawStatus'];
    }
    if ($_GET['from_date']) {
        $show_date = $_GET['from_date'];
        $cal_date = date("Y-m-d", strtotime($show_date));
    }
    if ($_GET['to_date']) {
        $show_date1 = $_GET['to_date'];
        $cal_date1 = date("Y-m-d", strtotime($show_date1));
    }
} else {
    $show_date = date("d-m-Y");
    $show_date1 = date("d-m-Y");
    $cal_date = date("Y-m-d");
    $cal_date1 = date("Y-m-d");
} ?>
<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">
                    <h2><a href="javascript:void(0);" onclick="window.history.back();"
                            class="btn btn-xs btn-link btn-toggle-fullwidth"><i
                                class="fa fa-arrow-left"></i></a>Principal Withdraw History</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item">Principal Withdraw </li>
                        <li class="breadcrumb-item active">Principal Withdraw History</li>
                    </ul>
                </div>
            </div>
        </div>


        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Principal Withdraw History</h2>
                        <span id="errorMsg"></span> </br>
                        <span id="account"></span></br>
                        <span id="getBalance"></span><br>
                        <input type="hidden" id="walletKey" name="walletKey">
                        <input type="hidden" id="currentTrxBalance">
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-hover js-basic-example dataTable table-custom mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>UserId</th>
                                        <th>Name </th>
                                        <th>Date</th>
                                        <th>Withdraw Amount</th>
                                        <th>OrderId</th>
                                        <th>Currency Type</th>
                                        <th>Wallet Address</th>
                                        <th>Withdraw Status</th>
                                        <th>Remark</th>
                                        <th>Action Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 0;
                                    $queryWithdraw = mysqli_query($con, "SELECT a.*,b.name,b.user_id,c.walletAddress,d.currencyName FROM meddolic_user_principal_invest_withdraw a, meddolic_user_details b, meddolic_user_wallet_address_details c, meddolic_config_currency_list d WHERE a.memberId=b.member_id AND a.walletId=c.payment_id AND c.currency_id=d.currency_id ORDER BY a.withdrawalDate DESC");

                                    while ($valWithdraw = mysqli_fetch_assoc($queryWithdraw)) {
                                        $count++; ?>
                                        <tr>
                                            <td><?= $count ?></td>
                                            <td><?= $valWithdraw['user_id'] ?></td>
                                            <td><?= $valWithdraw['name'] ?></td>
                                            <td class="text-left"><?= $valWithdraw['dateTime'] ?></td>
                                            <td class="text-danger font-weight-bold"><i class="fa fa-usd"></i>
                                                <?= $valWithdraw['amount'] ?></td>
                                            <td><?= $valWithdraw['orderId'] ?></td>
                                            <td><?= $valWithdraw['currencyName'] ?></td>
                                            <td><?= $valWithdraw['walletAddress'] ?></td>
                                            <td><?php if ($valWithdraw['released'] == 0)
                                                echo "Processing";
                                            else if ($valWithdraw['released'] == 1)
                                                echo "Released";
                                            else if ($valWithdraw['released'] == 2)
                                                echo "Rejected"; ?>
                                            </td>
                                            <td><?= $valWithdraw['remarks'] ?></td>
                                            <td><?= $valWithdraw['paymentDate'] ?></td>
                                            <td><?php if ($valWithdraw['released'] == 0) { ?>
                                                    <a href="principalWithdrawRequestAccept?WalletId=<?= $valWithdraw['id'] ?>"
                                                        class="btn btn-primary btn-xs"
                                                        onclick="return confirm('Are You Sure to Accept?');"><span>Accept</span></a>&nbsp;<a
                                                        href="principalWithdrawRequestCancel<?= $valWithdraw['id'] ?>"
                                                        class="btn btn-danger btn-xs" onclick=" "> Reject </a> <?php } ?>
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
<div class="modal fade" id="withdrawRquestCancel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="cancelDash">
                <!-- Content goes in here -->
            </div>
        </div>
    </div>
</div>
<?php include('include/footer.php'); ?>

<script>
    $('#withdrawRquestCancel').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('whatever') // Extract info from data-* attributes
        var modal = $(this);
        var id = recipient;
        $.ajax({
            type: "POST",
            url: "ajaxCalls/pricipalWithdrawCancelAjax",
            data: { id: id },
            cache: false,
            success: function (data) {
                console.log(data);
                modal.find('.cancelDash').html(data);
            },
            error: function (err) {
                console.log(err);
            }
        });
    })
    var d = document.getElementById("Withdraw");
    d.className += " active";
    var d = document.getElementById("principalWithdrawRequest");
    d.className += " active";
</script>


</body>

</html>