<?php
require_once("loginCheck.php");
require_once('Include/Head.php');
require_once('Include/Sidebar.php');

$limit = 10; // records per page

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
if ($page < 1)
    $page = 1;

$offset = ($page - 1) * $limit;

// Total records count
$totalQuery = mysqli_query($con, "SELECT COUNT(*) as total FROM meddolic_user_fund_request WHERE member_id = '$memberId'");
$totalData = mysqli_fetch_assoc($totalQuery);
$totalRecords = $totalData['total'];

$totalPages = ceil($totalRecords / $limit);
?>
<style>
.bento-grid {
    display: grid;
    grid-template-columns: repeat(1, 1fr);
    /* grid-auto-rows: minmax(100px, auto); */
    gap: 20px;
}
</style>
<div class="dashboard">
    <div class="ph" style="display:grid;">
        <h1 class="ph-title" style="font-size: 2.5rem;">Secure Funding</h1>
        <p class="ph-sub">Initiate capital transfers to your operational wallet.</p>
    </div>
    <div class="bento-grid">


        <div class="bento-tile tile-form">
            <h4 class="mb-4">New Deposit</h4>
            <form action="fundRequestonlineProcess" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="memberId" value="<?= $mId ?>">


                <label class="bento-label">User ID</label>
                <input type="text" name="user_id" class="bento-input" placeholder="e.g. john12345" readonly
                    value="<?= $userId ?>">
                <input type="hidden" name="loginMemberId" value="<?= $memberId ?>">


                <label class="bento-label">Name </label>
                <input type="text" name="name" class="bento-input" placeholder="e.g. John Doe" readonly
                    value="<?= $userName ?>">


                <label class="bento-label">Amount ($)</label>
                <input type="number" name="invetsAmount" id="invetsAmount" class="bento-input" placeholder="0.00"
                    step="0.01" required>


                <button type="submit" name="addFundNow" class="purchase-btn">CONFIRM REQUEST</button>
            </form>
        </div>
        <div class="bento-tile tile-history">
            <h4 class="mb-4">Live Ledger</h4>
            <div class="table-responsive">
                <table class="bento-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>UserId</th>
                            <th>Name</th>
                            <th>Add Amount</th>
                            <th>OrderId</th>
                            <th>Address</th>
                            <th>Pay Currency</th>
                            <th>Pay Amount</th>
                            <th>Date</th>
                            
                            <th>Pay Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 0;
                        $queryFund = mysqli_query($con, "SELECT a.tempId,a.packagePrice,a.addDate,a.orderId,a.priceAmount,a.amountReceived,a.paymentId,a.payCurrency,a.payAddress,a.paymentStatus,a.createdTime,b.user_id,b.name FROM meddolic_user_invest_purchase_details a, meddolic_user_details b WHERE (a.memberId='$userId' OR a.loginMemberId='$memberId') AND a.memberId=b.member_id ORDER BY a.addDate DESC");
                        while ($valFund = mysqli_fetch_assoc($queryFund)) {
                            $paymentStatus = $valFund['paymentStatus'];
                            $count++; ?>
                        <tr>
                            <td><?= $count ?></td>
                            <td><?= $valFund['user_id'] ?></td>
                            <td><?= $valFund['name'] ?></td>
                            <td><span class="badge badge-success"><i class="fa fa-usd"></i>
                                    <?= $valFund['packagePrice'] ?></span></td>
                            <td><?= $valFund['orderId'] ?></td>
                            <td><?= $valFund['payAddress'] ?></td>
                            <td><?= $valFund['payCurrency'] ?></td>
                            
                            <td><?= $valFund['amountReceived'] ?> <?= $valFund['payCurrency'] ?></td>
                            <td><?= $valFund['createdTime'] ?></td>
                            
                            <td><?php if ($paymentStatus == "finished")
                                    echo "<span class='badge badge-success'>FINISHED</span>";
                                else if ($paymentStatus == "confirming")
                                    echo "<span class='badge badge-primary'>CONFIRMING</span>";
                                else if ($paymentStatus == "refunded")
                                    echo "<span class='badge badge-danger'>REFUNDED</span>";
                                else if ($paymentStatus == "failed")
                                    echo "<span class='badge badge-danger'>FAILED</span>";
                                else if ($paymentStatus == "partially_paid")
                                    echo "<span class='badge badge-warning'>PARTIAL PAID</span>";
                                else if ($paymentStatus == "sending")
                                    echo "<span class='badge badge-warning'>SENDING</span>";
                                else if ($paymentStatus == "confirmed")
                                    echo "<span class='badge badge-success'>CONFIRMED</span>";
                                else if ($paymentStatus == "waiting")
                                    echo "<span class='badge badge-primary'>WAITING</span>";
                                else if ($paymentStatus == "expired")
                                    echo "<span class='badge badge-danger'>EXPIRED</span>";
                                else if ($paymentStatus == "canceled")
                                    echo "<span class='badge badge-danger'>CANCELED</span>" ?>
                            </td>
                          <td>
    <?php if ($paymentStatus == "waiting"|| $paymentStatus=="finished") { ?>
        <a href="https://gateway.faradpay.com/payment?paymentId=<?= $valFund['paymentId'] ?>&redirect_url=https://fundx.live/User/fundRequestonline.php%3Fstatus%3Dsuccess%26order%3DORD-1786012528-9798"
            class="btn btn-sm btn-info text-white" target="_blank">
            Check Status
        </a>
    <?php } ?>

    <?php if ($paymentStatus == "waiting") { ?>
        &nbsp;
        <a href="javascript:void(0);"
            onclick="cancelFundRequest('<?= $valFund['orderId'] ?>','<?= $valFund['tempId'] ?>')"
            class="badge badge-danger">
            Cancel
        </a>
    <?php } ?>
</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?>">« Prev</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=<?= $i ?>" class="<?= ($i == $page) ? 'active' : '' ?>">
                        <?= $i ?>
                    </a>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                    <a href="?page=<?= $page + 1 ?>">Next »</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
function loadGate(val) {
    const target = $("#gateInfo");
    if (!val) {
        target.html('<p class="small text-muted">Select protocol.</p>');
        return;
    }
    $.ajax({
        url: "ajaxCalls/fetchPaymentDetailsAjax.php",
        type: "POST",
        data: {
            paymentId: val
        },
        success: function(d) {
            target.html(d);
        }
    });
}


function cancelFundRequest(orderId, tempId) {

    if (!confirm("Are you sure you want to cancel this request?")) {

        return;
    }

    $.ajax({
        url: "ajaxCalls/cancelFundRequestAjax.php",
        type: "POST",
        data: {
            orderId: orderId,
            tempId: tempId
        },
        success: function(response) {
            alert(response);
            location.reload();
        },
        error: function() {
            alert("Something went wrong.");
        }
    });
}
</script>

<?php require_once("Include/Footer.php"); ?>