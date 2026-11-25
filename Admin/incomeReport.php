<!DOCTYPE html>
<html lang="en">
<?php include('include/head.php');
include("loginCheck.php");
include('include/header.php');
include('include/menu.php'); ?>
<?php
$user_id1 = "";

if ($_GET) {
    if (!empty($_GET['user_id'])) {
        $user_id1 = trim($_GET['user_id']);
        $query = "SELECT count(*) FROM meddolic_user_details WHERE user_id='" . mysqli_real_escape_string($con, $user_id1) . "'";
        $result = mysqli_query($con, $query);
        $val = mysqli_fetch_array($result);
        if ($val[0] == 0) { ?>
            <script>
                alert("Invalid User Id");
            </script>
            <?php
            $user_id1 = "";
        }
    }
  if (!empty($_GET['from_date'])) {
    $show_date = trim($_GET['from_date']);
    $date = DateTime::createFromFormat('d-m-Y', $show_date);
    $cal_date = $date->format('Y-m-d');
}

if (!empty($_GET['to_date'])) {
    $show_date1 = trim($_GET['to_date']);
    $date = DateTime::createFromFormat('d-m-Y', $show_date1);
    $cal_date1 = $date->format('Y-m-d');
}
}

// Default: Today's Date
if (empty($show_date)) {
    $show_date = date("d-m-Y");
    $cal_date = date("Y-m-d");
}

if (empty($show_date1)) {
    $show_date1 = date("d-m-Y");
    $cal_date1 = date("Y-m-d");
}

$userFilterSql = "";
if (!empty($user_id1)) {
    $userFilterSql = " AND b.user_id = '" . mysqli_real_escape_string($con, $user_id1) . "' ";
}
?>
<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12">
                    <h2><a href="javascript:void(0);" onclick="window.history.back();"
                            class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>
                        Income Report</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item"> Income </li>
                        <li class="breadcrumb-item active"> Income Report</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- FILTERS -->
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card">
                    <div class="body">
                        <form method="get">
                            <div class="form-row align-items-center">
                                <div class="col-md-3 col-6">
                                    <label class="mb-1">User ID</label>
                                    <input class="form-control" type="text" placeholder="Enter User ID" name="user_id"
                                        value="<?= htmlspecialchars($user_id1) ?>">
                                </div>
                                <div class="col-md-3 col-6">
                                    <label class="mb-1">From Date</label>
                                    <input type="text" name="from_date" id="from_date" class="form-control"
                                        placeholder="From Date" value="<?= $show_date ?>" autocomplete="off" readonly>
                                </div>
                                <div class="col-md-3 col-6">
                                    <label class="mb-1">To Date</label>
                                    <input type="text" name="to_date" id="to_date" class="form-control"
                                        placeholder="To Date" value="<?= $show_date1 ?>" autocomplete="off" readonly>
                                </div>
                                <div class="col-md-3 col-6 mt-md-4">
                                    <input class="btn btn-primary btn-block" type="submit" value="Search">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- INCOME TABS -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Income Report </h2>
                    </div>
                    <div class="body">
                        <ul class="nav nav-tabs" role="tablist" id="incomeTabNav">
                            <li class="nav-item">
                                <button type="button" class="nav-link incomeNavLink-active" data-tab="referralTab">Referral Income</button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" data-tab="boosterTab">Booster Income</button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" data-tab="stakingTab">Daily Staking Income</button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" data-tab="rewardTab">Reward Income</button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" data-tab="levelTab">Level Income</button>
                            </li>
                        </ul>

                        <div class="incomeTabContent mt-3">

                            <!-- ===================== REFERRAL INCOME ===================== -->
                            <div class="incomeTabPane incomeTabPane-active" id="referralTab">
                                <div class="table-responsive">
                                    <table class="table table-hover table-custom mb-0 income-report-table" id="referralTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>UserId</th>
                                                <th>Name</th>
                                                <th>Referred User</th>
                                                <th>Package Price</th>
                                                <th>Percent</th>
                                                <th>Income Amount</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count = 0;
                                            $grandTotal = 0;

                                            $q = "SELECT b.user_id, b.name AS uname,
                                                        ch.user_id AS childUserId,
                                                        r.packagePrice, r.directPercent,
                                                        r.directIncome, r.dateTime
                                                  FROM meddolic_user_sponsor_income r
                                                  INNER JOIN meddolic_user_details b ON b.member_id = r.memberId
                                                  LEFT JOIN meddolic_user_details ch ON ch.member_id = r.childId
                                                  WHERE r.releaseStatus = 1
                                                    AND DATE(r.dateTime) BETWEEN '$cal_date' AND '$cal_date1'
                                                    $userFilterSql
                                                  ORDER BY r.dateTime DESC";

                                            $res = mysqli_query($con, $q);
                                            if ($res) {
                                                while ($row = mysqli_fetch_assoc($res)) {
                                                    $count++;
                                                    $grandTotal += $row['directIncome'];
                                                    ?>
                                                    <tr>
                                                        <td><?= $count ?></td>
                                                        <td><?= $row['user_id'] ?></td>
                                                        <td><?= $row['uname'] ?></td>
                                                        <td><?= $row['childUserId'] ?></td>
                                                        <td><?= number_format($row['packagePrice'], 2) ?></td>
                                                        <td><?= number_format($row['directPercent'], 2) ?>%</td>
                                                        <td><span
                                                                class="badge badge-success fa fa-usd"> <?= number_format($row['directIncome'], 2) ?></span>
                                                        </td>
                                                        <td><?= date("d-m-Y h:i A", strtotime($row['dateTime'])) ?></td>
                                                    </tr>
                                                <?php } }
                                          ?>
                                    </table>
                                </div>
                            </div>

                            <!-- ===================== BOOSTER INCOME ===================== -->
                            <div class="incomeTabPane" id="boosterTab">
                                <div class="table-responsive">
                                    <table class="table table-hover table-custom mb-0 income-report-table" id="boosterTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>UserId</th>
                                                <th>Name</th>
                                                <th>ROI %</th>
                                                <th>Income Amount</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count = 0;
                                            $grandTotal = 0;

                                            $q = "SELECT b.user_id, b.name AS uname,
                                                        c.roiPercent, c.incomeAmount, c.date_time
                                                  FROM meddolic_user_cashback_income_details c
                                                  INNER JOIN meddolic_user_details b ON b.member_id = c.member_id
                                                  WHERE c.status = 1 AND c.packageStatus = 2
                                                    AND DATE(c.date_time) BETWEEN '$cal_date' AND '$cal_date1'
                                                    $userFilterSql
                                                  ORDER BY c.date_time DESC";

                                            $res = mysqli_query($con, $q);
                                            if ($res) {
                                                while ($row = mysqli_fetch_assoc($res)) {
                                                    $count++;
                                                    $grandTotal += $row['incomeAmount'];
                                                    ?>
                                                    <tr>
                                                        <td><?= $count ?></td>
                                                        <td><?= $row['user_id'] ?></td>
                                                        <td><?= $row['uname'] ?></td>
                                                        <td><?= number_format($row['roiPercent'], 2) ?>%</td>
                                                        <td><span
                                                                class="badge badge-danger fa fa-usd"> <?= number_format($row['incomeAmount'], 2) ?></span>
                                                        </td>
                                                        <td><?= date("d-m-Y h:i A", strtotime($row['date_time'])) ?></td>
                                                    </tr>
                                                <?php } }
                                             ?>
                                    </table>
                                </div>
                            </div>

                            <!-- ===================== DAILY STAKING INCOME ===================== -->
                            <div class="incomeTabPane" id="stakingTab">
                                <div class="table-responsive">
                                    <table class="table table-hover table-custom mb-0 income-report-table" id="stakingTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>UserId</th>
                                                <th>Name</th>
                                                <th>ROI %</th>
                                                <th>Income Amount</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count = 0;
                                            $grandTotal = 0;

                                            $q = "SELECT b.user_id, b.name AS uname,
                                                        c.roiPercent, c.incomeAmount, c.date_time
                                                  FROM meddolic_user_cashback_income_details c
                                                  INNER JOIN meddolic_user_details b ON b.member_id = c.member_id
                                                  WHERE c.status = 1 AND c.packageStatus = 1
                                                    AND DATE(c.date_time) BETWEEN '$cal_date' AND '$cal_date1'
                                                    $userFilterSql
                                                  ORDER BY c.date_time DESC";

                                            $res = mysqli_query($con, $q);
                                            if ($res) {
                                                while ($row = mysqli_fetch_assoc($res)) {
                                                    $count++;
                                                    $grandTotal += $row['incomeAmount'];
                                                    ?>
                                                    <tr>
                                                        <td><?= $count ?></td>
                                                        <td><?= $row['user_id'] ?></td>
                                                        <td><?= $row['uname'] ?></td>
                                                        <td><?= number_format($row['roiPercent'], 2) ?>%</td>
                                                        <td><span
                                                                class="badge badge-danger fa fa-usd"> <?= number_format($row['incomeAmount'], 2) ?></span>
                                                        </td>
                                                        <td><?= date("d-m-Y h:i A", strtotime($row['date_time'])) ?></td>
                                                    </tr>
                                                <?php } }
                                            ?>
                                    </table>
                                </div>
                            </div>

                            <!-- ===================== REWARD INCOME ===================== -->
                            <div class="incomeTabPane" id="rewardTab">
                                <div class="table-responsive">
                                    <table class="table table-hover table-custom mb-0 income-report-table" id="rewardTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>UserId</th>
                                                <th>Name</th>
                                                <th>Reward Id</th>
                                                <th>One Leg</th>
                                                <th>Other Leg</th>
                                                <th>Income Amount</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count = 0;
                                            $grandTotal = 0;

                                            $q = "SELECT b.user_id, b.name AS uname,
                                                        rw.rewardId, rw.oneLeg, rw.otherLeg,
                                                        rw.rewardIncome, rw.dateTime
                                                  FROM meddolic_user_reward_details rw
                                                  INNER JOIN meddolic_user_details b ON b.member_id = rw.memberId
                                                  WHERE DATE(rw.dateTime) BETWEEN '$cal_date' AND '$cal_date1'
                                                    $userFilterSql
                                                  ORDER BY rw.dateTime DESC";

                                            $res = mysqli_query($con, $q);
                                            if ($res) {
                                                while ($row = mysqli_fetch_assoc($res)) {
                                                    $count++;
                                                    $grandTotal += $row['rewardIncome'];
                                                    ?>
                                                    <tr>
                                                        <td><?= $count ?></td>
                                                        <td><?= $row['user_id'] ?></td>
                                                        <td><?= $row['uname'] ?></td>
                                                        <td><?= $row['rewardId'] ?></td>
                                                        <td><?= number_format($row['oneLeg'], 2) ?></td>
                                                        <td><?= number_format($row['otherLeg'], 2) ?></td>
                                                        <td><span
                                                                class="badge badge-primary fa fa-usd"> <?= number_format($row['rewardIncome'], 2) ?></span>
                                                        </td>
                                                        <td><?= date("d-m-Y h:i A", strtotime($row['dateTime'])) ?></td>
                                                    </tr>
                                                <?php }  }
                                           ?>
                                    </table>
                                </div>
                            </div>

                            <!-- ===================== LEVEL INCOME ===================== -->
                            <div class="incomeTabPane" id="levelTab">
                                <div class="table-responsive">
                                    <table class="table table-hover table-custom mb-0 income-report-table" id="levelTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>UserId</th>
                                                <th>Name</th>
                                                <th>From User</th>
                                                <th>Level</th>
                                                <th>Level %</th>
                                                <th>Income Amount</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count = 0;
                                            $grandTotal = 0;

                                            $q = "SELECT b.user_id, b.name AS uname,
                                                        ch.user_id AS childUserId,
                                                        l.level, l.levelPercent,
                                                        l.levelIncome, l.dateTime
                                                  FROM meddolic_user_level_income l
                                                  INNER JOIN meddolic_user_details b ON b.member_id = l.memberId
                                                  LEFT JOIN meddolic_user_details ch ON ch.member_id = l.childId
                                                  WHERE l.releaseStatus = 1
                                                    AND DATE(l.dateTime) BETWEEN '$cal_date' AND '$cal_date1'
                                                    $userFilterSql
                                                  ORDER BY l.dateTime DESC";

                                            $res = mysqli_query($con, $q);
                                            if ($res) {
                                                while ($row = mysqli_fetch_assoc($res)) {
                                                    $count++;
                                                    $grandTotal += $row['levelIncome'];
                                                    ?>
                                                    <tr>
                                                        <td><?= $count ?></td>
                                                        <td><?= $row['user_id'] ?></td>
                                                        <td><?= $row['uname'] ?></td>
                                                        <td><?= $row['childUserId'] ?></td>
                                                        <td><?= $row['level'] ?></td>
                                                        <td><?= number_format($row['levelPercent'], 2) ?>%</td>
                                                        <td><span
                                                                class="badge badge-info fa fa-usd"> <?= number_format($row['levelIncome'], 2) ?></span>
                                                        </td>
                                                        <td><?= date("d-m-Y h:i A", strtotime($row['dateTime'])) ?></td>
                                                    </tr>
                                                <?php } }
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
    </div>
</div>

<?php include('include/footer.php'); ?>

<style>
    #incomeTabNav .nav-link {
        cursor: pointer;
        background: none;
        border: 1px solid transparent;
        font: inherit;
    }
    #incomeTabNav .nav-link.incomeNavLink-active {
        border-bottom: 2px solid #2196f3;
        font-weight: 600;
    }
    .incomeTabContent .incomeTabPane { display: none; }
    .incomeTabContent .incomeTabPane.incomeTabPane-active { display: block; }
</style>

<script>
    $(function () {
        $('#from_date, #to_date').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true
        });

        // Map tab -> table id
        var tabTableMap = {
            'referralTab': 'referralTable',
            'boosterTab': 'boosterTable',
            'stakingTab': 'stakingTable',
            'rewardTab': 'rewardTable',
            'levelTab': 'levelTable'
        };

        function initTableIfNeeded(tabId) {
            var tableId = tabTableMap[tabId];
            if (!tableId) return;

            var $table = $('#' + tableId);
            if (!$table.length) return;

            // Already initialized -> do nothing (prevents duplicate rows)
            if ($.fn.DataTable && $.fn.DataTable.isDataTable('#' + tableId)) {
                return;
            }

            if ($.fn.DataTable) {
                $table.DataTable({
                    pageLength: 10,
                    lengthChange: true,
                    ordering: true
                });
            }
        }

        // Init the first (visible) tab's table on load
        initTableIfNeeded('referralTab');

        $('#incomeTabNav .nav-link').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            var target = $(this).data('tab');

            $('#incomeTabNav .nav-link').removeClass('incomeNavLink-active');
            $(this).addClass('incomeNavLink-active');

            $('.incomeTabContent .incomeTabPane').removeClass('incomeTabPane-active');
            $('#' + target).addClass('incomeTabPane-active');

            // Initialize the newly shown table's DataTable (only once)
            initTableIfNeeded(target);

            // Recalculate column widths now that the table is visible
            var tableId = tabTableMap[target];
            if (tableId && $.fn.DataTable && $.fn.DataTable.isDataTable('#' + tableId)) {
                $('#' + tableId).DataTable().columns.adjust().draw(false);
            }

            return false;
        });
    });

    var d = document.getElementById("Income");
    if (d) { d.className += " active"; }
    var d2 = document.getElementById("incomeReport");
    if (d2) { d2.className += " active"; }
</script>

</body>

</html>