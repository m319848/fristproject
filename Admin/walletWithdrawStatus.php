<!DOCTYPE html>
<html lang="en">
<?php include('include/head.php');
include("loginCheck.php");
include('include/header.php');
include('include/menu.php'); ?>
<?php
$user_id1 = "";
$withdrawStatus = "";
$show_date = date("d-m-Y");
$show_date1 = date("d-m-Y");
$cal_date = date("Y-m-d");
$cal_date1 = date("Y-m-d");

if (isset($_GET['user_id']) && $_GET['user_id'] !== '') {
    $user_id1 = mysqli_real_escape_string($con, $_GET['user_id']);

    $query = "SELECT COUNT(*) FROM meddolic_user_details WHERE user_id='$user_id1'";
    $result = mysqli_query($con, $query);
    $val = mysqli_fetch_array($result);

    if ($val[0] == 0) {
        ?>
<script>
alert("Invalid User Id");
</script>
<?php
        $user_id1 = $_SESSION['admin_user_id'];
    }
}

/*
 * IMPORTANT:
 * Use isset() because withdrawStatus = 0 is a valid value.
 */
if (isset($_GET['withdrawStatus']) && $_GET['withdrawStatus'] !== '') {
    $withdrawStatus = (int) $_GET['withdrawStatus'];
}

if (isset($_GET['from_date']) && $_GET['from_date'] !== '') {
    $show_date = $_GET['from_date'];
    $cal_date = date("Y-m-d", strtotime($show_date));
}

if (isset($_GET['to_date']) && $_GET['to_date'] !== '') {
    $show_date1 = $_GET['to_date'];
    $cal_date1 = date("Y-m-d", strtotime($show_date1));
}
?>


<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">
                    <h2><a href="javascript:void(0);" onclick="window.history.back();"
                            class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>
                        Withdraw History</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item"> Withdraw </li>
                        <li class="breadcrumb-item active"> Withdraw History</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card">
                    <div class="body">
                        <form>
                            <div class="form-row">
                                <div class="col-2">
                                    <input class="form-control" type="text" placeholder="Enter User ID" name="user_id"
                                        value="<?= $user_id1 ?>">
                                </div>
                                <div class="col-2">
                                    <select class="form-control" name="withdrawStatus">
                                        <option value=""> Select One </option>
                                        <option value="0" <?php if ($withdrawStatus == 0)
                                            echo 'selected'; ?>> Pending
                                        </option>
                                        <option value="1" <?php if ($withdrawStatus == 1)
                                            echo 'selected'; ?>> Offline Released
                                        </option>
                                        <option value="3" <?php if ($withdrawStatus == 3)
                                            echo 'selected'; ?>> Online Released
                                        </option>
                                        <option value="2" <?php if ($withdrawStatus == 2)
                                            echo 'selected'; ?>> Rejected
                                        </option>

                                    </select>
                                </div>
                                <div class="col-2">
                                    <input type="text" name="from_date" id="from_date" class="form-control"
                                        placeholder="e.g. From Date" required value="<?= $show_date ?>" readonly>
                                </div>
                                <div class="col-2">
                                    <input type="text" name="to_date" id="to_date" class="form-control"
                                        placeholder="e.g. To Date" required value="<?= $show_date1 ?>" readonly>
                                </div>
                                <div class="col-2">
                                    <input class="btn btn-primary" type="submit" value="Search">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Withdraw History</h2>
                        <span id="errorMsg"></span> </br>
                        <span id="account"></span></br>
                        <span id="getBalance"></span><br>
                        <input type="hidden" id="walletKey" name="walletKey">
                        <input type="hidden" id="currentTrxBalance">
                    </div>
                    <div class="body">

                        <!-- ===== Bulk Action Bar ===== -->
                        <div class="form-inline mb-3">
                            <select id="bulkStatus" class="form-control mr-2">
                                <option value="">-- Select Action --</option>
                                <option value="3">Release (Online)</option>
                                <option value="1">Release (Manual)</option>
                                <option value="2">Reject</option>
                            </select>
                            <input type="text" id="bulkRemark" class="form-control mr-2" placeholder="Remark"
                                style="width:250px;">
                            <button type="button" id="bulkSubmitBtn" class="btn btn-success">Apply to
                                Selected</button>
                            <span id="bulkSelectedCount" class="ml-3 text-muted"></span>
                        </div>
                        <!-- ===== /Bulk Action Bar ===== -->

                        <div class="table-responsive">
                            <table id="memberTable" class="table table-hover table-custom mb-0">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAll"></th>
                                        <th>#</th>
                                        <th>UserId</th>
                                        <th>Name </th>
                                        <th>Date</th>
                                        <th>Gross Amount</th>
                                        <th>Charge </th>
                                        <th>Net Amount </th>
                                        <th>OrderId</th>
                                        <th>Currency Type</th>
                                        <th>Wallet Address</th>
                                        <th>Trn Hash</th>
                                        <th>Withdraw Status</th>
                                        <th>Remark</th>
                                        <th>Action Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query_in = "SELECT member_id from meddolic_user_details where user_id='$user_id1'";
                                    $result = mysqli_query($con, $query_in);
                                    $val1 = mysqli_fetch_array($result);
                                    $member_id1 = $val1[0];

                                    $query = "";

                                    // User filter
                                    if ($user_id1 != "") {
                                        $query .= " AND a.member_id='$member_id1'";
                                    }

                                    if ($withdrawStatus !== '') {
                                        $withdrawStatus = (int) $withdrawStatus;

                                        if ($withdrawStatus == 0) {
                                            // Pending
                                            $query .= " AND a.released = 0";

                                        } elseif ($withdrawStatus == 1) {
                                            // Released
                                            $query .= " AND (a.released = 1 )";

                                        } elseif ($withdrawStatus == 2) {
                                            // Rejected
                                            $query .= " AND a.released = 2";
                                        } elseif ($withdrawStatus == 3) {
                                            // Online Released
                                            $query .= " AND (a.released = 3 OR a.status = 'FINISHED')";
                                        }
                                    }

                                    $count = 0;

                                    $queryWithdraw = mysqli_query(
                                        $con,
                                        "SELECT 
        a.*,
        b.name,
        b.user_id
     FROM meddolic_user_wallet_withdrawal a
     INNER JOIN meddolic_user_details b 
        ON a.member_id = b.member_id
     WHERE CAST(a.date_time AS DATE) BETWEEN '$cal_date' AND '$cal_date1'
     $query
     ORDER BY a.date_time DESC"
                                    );

                                    while ($valWithdraw = mysqli_fetch_array($queryWithdraw)) {
                                        $walletAdd = mysqli_query($con, "SELECT a.walletAddress,b.currencyName FROM meddolic_user_wallet_address_details a, meddolic_config_currency_list b WHERE a.member_id='" . $valWithdraw['member_id'] . "' AND a.currency_id=b.currency_id AND a.status=1 ");
                                        $valWallet = mysqli_fetch_array($walletAdd);
                                        $valWithdraw['walletAddress'] = $valWallet['walletAddress'];
                                        $valWithdraw['currencyName'] = $valWallet['currencyName'];

                                        $count++;

                                        ?>
                                    <tr>
                                        <td>
                                            <?php if ($valWithdraw['released'] == 0) { ?>
                                            <input type="checkbox" class="rowCheckbox"
                                                value="<?= $valWithdraw['id'] ?>">
                                            <?php } ?>
                                        </td>
                                        <td><?= $count ?></td>
                                        <td><?= $valWithdraw['user_id'] ?></td>
                                        <td><?= $valWithdraw['name'] ?></td>
                                        <td class="text-left"><?= $valWithdraw['date_time'] ?></td>
                                        <td class="text-danger font-weight-bold"><i class="fa fa-in"></i>
                                            <?= $valWithdraw['amount'] ?>
                                        </td>
                                        <td class="text-primary font-weight-bold"><i class="fa fa-in"></i>
                                            <?= $valWithdraw['withdrawCharge'] ?>
                                        </td>
                                        <td class="text-success font-weight-bold"><i class="fa fa-in"></i>
                                            <?= $valWithdraw['netAmount'] ?>
                                        </td>
                                        <td><?= $valWithdraw['orderid'] ?></td>
                                        <td>
                                            <?= $valWithdraw['currencyName']; ?>
                                        </td>

                                        <td>
                                            <?= $valWithdraw['walletAddress']; ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($valWithdraw['trnHash'])) { ?>
                                            <a href="#"><?= $valWithdraw['trnHash'] ?></a>
                                            <?php } else { ?>
                                            N/A
                                            <?php } ?>
                                        <td><?php if ($valWithdraw['released'] == 0)
                                                echo "Pending";
                                            else if ($valWithdraw['released'] == 1)
                                                echo " <span class='badge badge-success'>Offline Released <span>";
                                            elseif ($valWithdraw['released'] == 2) {
                                                echo "<span class='badge badge-warning'>Rejected </span>";
                                            } else if ($valWithdraw['released'] == 3 || $valWithdraw['status'] == 'FINISHED') {
                                                echo "<span class='badge badge-success'>Online Released</span>"; } ?>
                                        </td>
                                        <td><?= $valWithdraw['remarks'] ?></td>
                                        <td><?= $valWithdraw['payment_date'] ?></td>
                                        <td><?php if ($valWithdraw['released'] == 0) { ?><a
                                                data-id="<?= $valWithdraw['id'] ?>" data-toggle="modal"
                                                data-target="#cryptoRemark" data-whatever="<?= $valWithdraw['id'] ?>"
                                                href="javascript:void(0)" class="btn btn-primary btn-xs"> Add
                                            </a><?php } ?></td>
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
<div class="modal fade" id="cryptoRemark" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="cryptoRemarkDash">
                <!-- Content goes in here -->
            </div>
        </div>
    </div>
</div>
<?php include('include/footer.php'); ?>

<script>
$('#cryptoRemark').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('whatever') // Extract info from data-* attributes
    var modal = $(this);
    var id = recipient;
    var userId = '<?= $user_id1 ?>';
    var withdrawStatus = '<?= $withdrawStatus ?>';
    var fromDate = '<?= $show_date ?>';
    var toDate = '<?= $show_date1 ?>';
    $.ajax({
        type: "POST",
        url: "ajaxCalls/cryptoRemarkAjax",
        data: {
            id: id,
            withdrawStatus: withdrawStatus,
            fromDate: fromDate,
            toDate: toDate,
            userId: userId
        },
        cache: false,
        success: function(data) {
            console.log(data);
            modal.find('.cryptoRemarkDash').html(data);
        },
        error: function(err) {
            console.log(err);
        }
    });
})
var d = document.getElementById("Withdraw");
d.className += " active";
var d = document.getElementById("walletWithdrawStatus");
d.className += " active";

// ===== Bulk select / bulk action =====

// Select-all checkbox toggles all visible row checkboxes
$('#selectAll').on('change', function() {
    $('.rowCheckbox').prop('checked', $(this).is(':checked'));
    updateSelectedCount();
});

// Keep select-all in sync + show a live count when individual boxes change
$(document).on('change', '.rowCheckbox', function() {
    var total = $('.rowCheckbox').length;
    var checked = $('.rowCheckbox:checked').length;
    $('#selectAll').prop('checked', total > 0 && total === checked);
    updateSelectedCount();
});

function updateSelectedCount() {
    var checked = $('.rowCheckbox:checked').length;
    $('#bulkSelectedCount').text(checked > 0 ? checked + ' selected' : '');
}

$('#bulkSubmitBtn').on('click', function() {
    var ids = [];
    $('.rowCheckbox:checked').each(function() {
        ids.push($(this).val());
    });

    if (ids.length === 0) {
        alert('Please select at least one row');
        return;
    }

    var status = $('#bulkStatus').val();
    var remark = $('#bulkRemark').val();

    if (!status) {
        alert('Please select a status');
        return;
    }
    if (!remark) {
        alert('Remark is required');
        return;
    }

    if (!confirm('Apply this status to ' + ids.length + ' withdrawal(s)?')) {
        return;
    }

    var btn = $(this);
    btn.prop('disabled', true).text('Processing...');

    $.ajax({
        type: "POST",
        url: "cryptoWithdrawProcessAll",
        data: {
            ids: ids,
            withdrawStatus: status,
            remarks: remark
        },
        success: function(res) {
            alert(res);
            location.reload();
        },
        error: function(err) {
            console.log(err);
            alert('Something went wrong');
            btn.prop('disabled', false).text('Apply to Selected');
        }
    });
});
</script>


</body>

</html>