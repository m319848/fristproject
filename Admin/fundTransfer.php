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
                    <h2><a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Fund Transfer</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item"> Fund Manager </a></li>
                        <li class="breadcrumb-item active"> Fund Transfer</li>
                    </ul>
                </div>            
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-md-6">
                <div class="card">
                    <div class="header">
                        <h2>Fund Transfer</h2>
                    </div>
                    <div class="body">
                        <form method="POST" action="fundTransferBack" >
                            <fieldset>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>User ID *</label>
                                            <input type="text" name="sponser_id" id="sponser_id" class="form-control" placeholder="e.g. john12345" onblur="sponser_valid(this.value)" required autofocus>
                                            <input type="hidden" name="login_member_id" value="<?=$member_id?>" >
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label> Name *</label>
                                            <input type="text" name="sponser_name" id="sponser_name" class="form-control" placeholder="e.g. John Doe" disabled >
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Amount To Transfer *</label>
                                            <input type="number" id="amount" name="amount" class="form-control" placeholder="e.g. Transfer Amount" onkeypress="return onlynum(event)"  required >
                                            <input type="hidden" name="walletType" value="fundWallet">
                                        </div>
                                   </div>
                             
                                </div>
                                <button type="submit" name="fundTransfer" class="btn btn-primary action-button float-left" value="Transfer Now" > Transfer Now</button>
                                <button type="button" name="previous" class="btn btn-danger action-button-previous float-left ml-3" value="Reset" onclick="location.reload()">Reset</button>
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
                    <h2>Fund Transfer History</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table id="memberTable" class="table table-hover table-custom mb-0">
                            <thead>
    <tr>
        <th>#</th>
        <th>Sender Details</th>
        <th>Receive Details</th>
        <th>Transfer Amount</th>
        <th>Transfer Date</th>
    </tr>
</thead>

<tbody>
<?php
$count = 0;

$queryFund = mysqli_query($con, "
    SELECT 
        a.*,

        sender.user_id AS sender_user_id,
        sender.name AS sender_name,

        receiver.user_id AS receiver_user_id,
        receiver.name AS receiver_name

    FROM meddolic_user_fund_transfer_history a

    LEFT JOIN meddolic_user_details sender 
        ON a.sender_member_id = sender.member_id

    LEFT JOIN meddolic_user_details receiver 
        ON a.receiver_member_id = receiver.member_id

    ORDER BY a.date_time DESC
");

while ($valFund = mysqli_fetch_array($queryFund)) {
    $count++;
?>
    <tr>
        <td><?= $count; ?></td>

        <!-- Sender Details -->
        <td>
            <strong><?= htmlspecialchars($valFund['sender_user_id']); ?></strong><br>
            <?= htmlspecialchars($valFund['sender_name']); ?>
        </td>

        <!-- Receiver Details -->
        <td>
            <strong><?= htmlspecialchars($valFund['receiver_user_id']); ?></strong><br>
            <?= htmlspecialchars($valFund['receiver_name']); ?>
        </td>

        <!-- Amount -->
        <td>
            <?= number_format($valFund['amount'], 2); ?>
        </td>

        <!-- Date -->
        <td>
            <i class="fa fa-clock-o"></i>
            <?= $valFund['date_time']; ?>
        </td>
    </tr>
<?php
}
?>
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
var d = document.getElementById("Fund");
    d.className += " active";
var d = document.getElementById("fundTransfer");
    d.className += " active";
</script>
</body>
</html> 