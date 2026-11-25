<!DOCTYPE html>
<html lang="en">

<?php
include('include/head.php');
include('loginCheck.php');
include('include/header.php');
include('include/menu.php');
?>

<div id="main-content">
    <div class="container-fluid">

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">

                <div class="card">

                    <div class="header">
                        <h2>Fund Deduct History</h2>
                    </div>

                    <div class="body">

                        <div class="table-responsive">

                            <table class="table table-hover js-basic-example dataTable table-custom mb-0">

                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Sender Details</th>
                                        <th>Receiver Details</th>
                                        <th>Wallet</th>
                                        <th>Action</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>

                                <tbody>

                                <?php

                                /*
                                 * Get logged-in user's member ID
                                 */
                                $member_id1 = 0;

                                if (!empty($user_id1)) {

                                    $user_id_safe = mysqli_real_escape_string($con, $user_id1);

                                    $member_query = mysqli_query(
                                        $con,
                                        "SELECT member_id
                                         FROM meddolic_user_details
                                         WHERE user_id='$user_id_safe'
                                         LIMIT 1"
                                    );

                                    if ($member_query && mysqli_num_rows($member_query) > 0) {
                                        $member_data = mysqli_fetch_assoc($member_query);
                                        $member_id1 = intval($member_data['member_id']);
                                    }
                                }


                                /*
                                 * Build history query
                                 */
                                $conditions = [];


                                /*
                                 * Date From
                                 */
                                if (!empty($cal_date)) {

                                    $cal_date_safe = mysqli_real_escape_string($con, $cal_date);

                                    $conditions[] = "CAST(h.date_time AS DATE) >= '$cal_date_safe'";
                                }


                                /*
                                 * Date To
                                 */
                                if (!empty($cal_date1)) {

                                    $cal_date1_safe = mysqli_real_escape_string($con, $cal_date1);

                                    $conditions[] = "CAST(h.date_time AS DATE) <= '$cal_date1_safe'";
                                }


                                /*
                                 * Logged-in user filter
                                 */
                                if ($member_id1 > 0) {

                                    $conditions[] = "h.sender_member_id='$member_id1'";
                                }


                                /*
                                 * WHERE condition
                                 */
                                $where = "";

                                if (!empty($conditions)) {
                                    $where = "WHERE " . implode(" AND ", $conditions);
                                }


                                /*
                                 * Get history with sender/receiver details
                                 *
                                 * JOIN is used instead of calling
                                 * name() and user_id() functions
                                 * repeatedly for every row.
                                 */
                                $history_query = "
                                    SELECT
                                        h.*,

                                        sender.name AS sender_name,
                                        sender.user_id AS sender_user_id,

                                        receiver.name AS receiver_name,
                                        receiver.user_id AS receiver_user_id

                                    FROM meddolic_user_fund_deduct_history h

                                    LEFT JOIN meddolic_user_details sender
                                        ON sender.member_id = h.sender_member_id

                                    LEFT JOIN meddolic_user_details receiver
                                        ON receiver.member_id = h.receiver_member_id

                                    $where

                                    ORDER BY h.date_time DESC
                                ";


                                $result = mysqli_query($con, $history_query);

                                $count = 0;


                                if ($result && mysqli_num_rows($result) > 0) {

                                    while ($val1 = mysqli_fetch_assoc($result)) {

                                        $count++;

                                        /*
                                         * Wallet name
                                         */
                                        if ($val1['wallet_type'] == 'fundWallet') {
                                            $wallet_name = 'Fund Wallet';
                                            $wallet_badge = 'badge-primary';
                                        } elseif ($val1['wallet_type'] == 'wallet') {
                                            $wallet_name = 'Income Wallet';
                                            $wallet_badge = 'badge-info';
                                        } else {
                                            $wallet_name = ucfirst($val1['wallet_type']);
                                            $wallet_badge = 'badge-secondary';
                                        }


                                        /*
                                         * Action
                                         */
                                        if ($val1['action_type'] == 'add') {

                                            $action_text = 'Added';
                                            $action_class = 'badge-success';

                                        } else {

                                            $action_text = 'Deducted';
                                            $action_class = 'badge-danger';
                                        }

                                        ?>

                                        <tr>

                                            <!-- # -->
                                            <td>
                                                <?= $count ?>
                                            </td>


                                            <!-- Sender -->
                                            <td>
                                                <strong>
                                                    <?= htmlspecialchars($val1['sender_name'] ?? 'N/A') ?>
                                                </strong>
                                                <br>

                                                <small class="text-muted">
                                                    <?= htmlspecialchars($val1['sender_user_id'] ?? 'N/A') ?>
                                                </small>
                                            </td>


                                            <!-- Receiver -->
                                            <td>
                                                <strong>
                                                    <?= htmlspecialchars($val1['receiver_name'] ?? 'N/A') ?>
                                                </strong>
                                                <br>

                                                <small class="text-muted">
                                                    <?= htmlspecialchars($val1['receiver_user_id'] ?? 'N/A') ?>
                                                </small>
                                            </td>


                                            <!-- Wallet -->
                                            <td>
                                                <span class="badge <?= $wallet_badge ?>">
                                                    <?= htmlspecialchars($wallet_name) ?>
                                                </span>
                                            </td>


                                            <!-- Action -->
                                            <td>
                                                <span class="badge <?= $action_class ?>">
                                                    <?= $action_text ?>
                                                </span>
                                            </td>


                                            <!-- Amount -->
                                            <td>
                                                <i class="fa fa-usd"></i>
                                                <?= number_format((float)$val1['amount'], 2) ?>
                                            </td>


                                            <!-- Date -->
                                            <td>
                                                <i class="fa fa-clock-o"></i>
                                                <?= htmlspecialchars($val1['date_time']) ?>
                                            </td>

                                        </tr>

                                        <?php
                                    }
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
    var transferMenu = document.getElementById("transfer");

    if (transferMenu) {
        transferMenu.classList.add("active");
    }

    var fundDeductHistoryMenu = document.getElementById("fundDeductHistory");

    if (fundDeductHistoryMenu) {
        fundDeductHistoryMenu.classList.add("active");
    }
</script>


</body>
</html>
