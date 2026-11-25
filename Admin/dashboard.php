<!DOCTYPE html>
<html lang="en">
<?php include('include/head.php');
include("loginCheck.php");
include('include/header.php');
include('include/menu.php'); ?>
<?php
$todayDate = date('Y-m-d');
$d = date('Y-m-d H:i:s');

$queryUser = mysqli_query($con, "SELECT COUNT(1) FROM meddolic_user_details WHERE userType=2");
$valUser = mysqli_fetch_array($queryUser);
$totalUser = $valUser[0];

$queryActive = mysqli_query($con, "SELECT COUNT(1) FROM meddolic_user_details WHERE userType=2 AND topupFlag=1");
$valActive = mysqli_fetch_array($queryActive);
$activeUser = $valActive[0];

$queryOutstanding = mysqli_query($con, "SELECT SUM(wallet),SUM(fundWallet) FROM meddolic_user_details");
$valOutstanding = mysqli_fetch_array($queryOutstanding);
$workingWallet = $valOutstanding[0];
$fundWallet = $valOutstanding[1];

$queryInActiveMember = mysqli_query($con, "SELECT COUNT(1) FROM meddolic_user_details WHERE topupFlag=0 AND userType=2");
$valInActiveMember = mysqli_fetch_array($queryInActiveMember);
$inactiveUser = $valInActiveMember[0];

$queryBusiness = mysqli_query($con, "SELECT SUM(investPrice) FROM meddolic_user_activation_details");
$valUser = mysqli_fetch_array($queryBusiness);
$totalBusiness = $valUser[0];


$queryTodayBusiness = mysqli_query($con, "SELECT sum(investPrice) FROM meddolic_user_activation_details WHERE CAST(date_time AS date)='$todayDate'");
$valTodayBusiness = mysqli_fetch_array($queryTodayBusiness);
$todayBusiness = $valTodayBusiness[0];

$queryDeposit = mysqli_query($con, "SELECT SUM(packagePrice) FROM meddolic_user_invest_purchase_details WHERE paymentStatus='finished'");
$valUser = mysqli_fetch_array($queryDeposit);
$totalDeposit = $valUser[0];


$queryToday = mysqli_query($con, "SELECT COUNT(1) FROM meddolic_user_details WHERE CAST(date_time AS date)='$todayDate' AND topupFlag=1 AND userType=2");
$valToday = mysqli_fetch_array($queryToday);
$todayActive = $valToday[0];


$queryWithdraw = mysqli_query($con, "SELECT SUM(amount) FROM meddolic_user_wallet_withdrawal WHERE (released=1 OR released=0 OR status='FINISHED')");
$valWithdraw = mysqli_fetch_array($queryWithdraw);
$totalWithdraw = $valWithdraw[0];

$queryPendingWithdraw = mysqli_query($con, "SELECT sum(amount) FROM meddolic_user_wallet_withdrawal WHERE released=0");
$valPendingWithdraw = mysqli_fetch_array($queryPendingWithdraw);
$totalPendingWithdraw = $valPendingWithdraw[0];

?>
<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">
                    <h2><a href="javascript:void(0);" onclick="window.history.back();"
                            class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>
                        Dashboard</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-xs-12">
                <div class="form-group" align="center"
                    style="font-size: 16px;font-weight: 600;background-color: #fff;color: #000;">
                    <label>Referral URL</label>
                    <input id="referralCone" type="hidden" readonly
                        value="https://fundx.live/authUserRegister?affiliateCode=<?= $mainId ?>">
                    <a style="display: inline-block;margin-top: 1px;font-weight: bold;padding: 3px 8px;border-radius: 5px;"
                        href="javascript:void(0)" onclick="copyLink('referralCone')"
                        class="btn btn-sm btn-success waves-effect">
                        <i class="fa fa-copy"></i>
                        <span>Copy </span>
                    </a>
                    <a style="display: inline-block;margin-top: 1px;font-weight: bold;padding: 3px 8px;border-radius: 5px;"
                        target="_blank"
                        href="https://api.whatsapp.com/send?phone=&amp;text=https://fundx.live/authUserRegister?affiliateCode=<?= $mainId ?>"
                        class="btn btn-sm btn-danger waves-effect">
                        <i class="fa fa-whatsapp"></i>
                        <span>Whatsapp</span>
                    </a>

                    <a style="display: inline-block;margin-top: 1px;font-weight: bold;padding: 3px 8px;border-radius: 5px;"
                        target="_blank"
                        href="http://www.facebook.com/sharer/sharer.php?u=https://fundx.live/authUserRegister?affiliateCode=<?= $mainId ?>&amp;quote=text"
                        class="btn btn-sm btn-primary waves-effect">
                        <i class="fa fa-facebook-f"></i>
                        <span>Facebook</span>
                    </a>
                    <a style="display: inline-block;margin-top: 1px;font-weight: bold;padding: 3px 8px;border-radius: 5px;"
                        target="_blank"
                        href="https://telegram.me/share/url?url=https://fundx.live/authUserRegister?affiliateCode=<?= $mainId ?>&text=text"
                        class="btn btn-sm btn-success waves-effect">
                        <i class="fa fa-telegram"></i>
                        <span>Telegram</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-3 col-md-6">
                <a href="viewMember">
                    <div class="card top_counter currency_state ">
                        <div class="body">
                            <div class="icon text-primary"><i class="fa fa-users"></i> </div>
                            <div class="content">
                                <div class="text">Total Associate</div>
                                <h5 class="number"><?= isset($totalUser) ? $totalUser : '0'; ?></h5>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="activationHistory">
                    <div class="card top_counter currency_state">
                        <div class="body">
                            <div class="icon text-primary"><i class="fa fa-users"></i></div>
                            <div class="content">
                                <div class="text">Today Actiavtion</div>
                                <h5 class="number"> <?= isset($todayActive) ? $todayActive : '0'; ?></h5>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="viewActiveUser">
                    <div class="card top_counter currency_state">
                        <div class="body">
                            <div class="icon text-primary"><i class="fa fa-users"></i></div>
                            <div class="content">
                                <div class="text">Active User</div>
                                <h5 class="number">
                                    <?= isset($activeUser) ? $activeUser : '0'; ?>
                                </h5>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6">
                <a href="viewInActiveUser">
                    <div class="card top_counter currency_state">
                        <div class="body">
                            <div class="icon text-primary"><i class="fa fa-users"></i></div>
                            <div class="content">
                                <div class="text">InActive User</div>
                                <h5 class="number">
                                    <?= isset($inactiveUser) ? $inactiveUser : '0'; ?>
                                </h5>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6">
                <a href="walletWithdrawStatus">
                    <div class="card top_counter currency_state ">
                        <div class="body">
                            <div class="icon text-primary"><i class="fa fa-area-chart"></i> </div>
                            <div class="content">
                                <div class="text">Total Withdrawal </div>
                                <h5 class="number">$ <?= isset($totalWithdraw) ? $totalWithdraw : '0'; ?></h5>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="walletWithdrawStatus">
                    <div class="card top_counter currency_state ">
                        <div class="body">
                            <div class="icon text-primary"><i class="fa  fa-bar-chart"></i> </div>
                            <div class="content">
                                <div class="text">Total Pending Withdrawal </div>
                                <h5 class="number">$ <?= isset($totalPendingWithdraw) ? $totalPendingWithdraw : '0'; ?>
                                </h5>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
             <div class="col-lg-3 col-md-6">
                <a href="userDepositHistory">
                    <div class="card top_counter currency_state ">
                        <div class="body">
                            <div class="icon text-primary"><i class="fa  fa-usd"></i> </div>
                            <div class="content">
                                <div class="text">Total Deposit In Gateway </div>
                                <h5 class="number">$ <?= isset($totalDeposit) ? $totalDeposit : '0'; ?></h5>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="activationHistory">
                    <div class="card top_counter currency_state ">
                        <div class="body">
                            <div class="icon text-primary"><i class="fa  fa-usd"></i> </div>
                            <div class="content">
                                <div class="text">Total Business </div>
                                <h5 class="number">$ <?= isset($totalBusiness) ? $totalBusiness : '0'; ?></h5>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="activationHistory">
                    <div class="card top_counter currency_state ">
                        <div class="body">
                            <div class="icon text-primary"><i class="fa  fa-usd"></i> </div>
                            <div class="content">
                                <div class="text">Today Business </div>
                                <h5 class="number">$
                                    <?= isset($todayBusiness) ? $todayBusiness : '0'; ?>
                                </h5>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="walletOutstanding">
                    <div class="card top_counter currency_state ">
                        <div class="body">
                            <div class="icon text-primary"><i class="fa  fa-bar-chart"></i> </div>
                            <div class="content">
                                <div class="text">Purchase Wallet</div>
                                <h5 class="number">$ <?= isset($fundWallet) ? $fundWallet : '0'; ?></h5>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<?php include('include/footer.php'); ?>
<script>
    function copyLink(referralId) {
        var link = $("#" + referralId).val();
        var tempInput = document.createElement("input");
        tempInput.style = "position: absolute; left: -1000px; top: -1000px";
        tempInput.value = link;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        alert('Referral Link Copied Successfully');
    }
    var d = document.getElementById("dashboard");
    d.className += " active";
</script>
</body>

</html>