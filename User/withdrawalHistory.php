<?php
require_once("loginCheck.php");
require_once('Include/Head.php');
require_once('Include/Sidebar.php');
?>

<div class="dashboard">
    <div class="income-report-container">
        <div class="page-breadcrumb">
            <p>Wallet withdrawal / <span>Withdrawal History</span></p>
        </div>

        <div class="report-card">

            <div class="table-responsive">
                <table class="income-table" id="example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>UserId</th>
                            <th>Name </th>
                            <th>Withdraw Amount</th>
                            <th>Charge</th>
                            <th>Net Amount</th>
                            <th>OrderId</th>
                            <th>Wallet Address</th>
                            <th>Date</th>
                            <th>Withdraw Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 0;
                        $queryWithdraw = mysqli_query($con, "SELECT
                            a.*,
                            b.user_id,
                            b.name,
                            c.walletAddress,
                            d.currencyName
                        FROM
                            meddolic_user_wallet_withdrawal a
                        LEFT JOIN
                            meddolic_user_details b ON a.member_id = b.member_id
                        LEFT JOIN
                            meddolic_user_wallet_address_details c ON a.paymentId = c.payment_id
                        LEFT JOIN
                            meddolic_config_currency_list d ON c.currency_id = d.currency_id
                        WHERE
                            a.member_id = '$memberId'
                        ORDER BY
                            a.date_time DESC;
                        ");
                        while ($valWithdraw = mysqli_fetch_assoc($queryWithdraw)) {
                            $count++; ?>
                            <tr>
                                <td><?= $count ?></td>

                                <td><?= htmlspecialchars($valWithdraw['user_id'], ENT_QUOTES, 'UTF-8'); ?></td>

                                <td><?= htmlspecialchars($valWithdraw['name'], ENT_QUOTES, 'UTF-8'); ?></td>

                                <td>
                                    <span class="badge badge-success">
                                        $
                                        <?= htmlspecialchars($valWithdraw['amount'], ENT_QUOTES, 'UTF-8'); ?>
                                    </span>
                                </td>

                                <td>
                                    <span class="badge badge-danger">
                                        $
                                        <?= htmlspecialchars($valWithdraw['withdrawCharge'], ENT_QUOTES, 'UTF-8'); ?>
                                    </span>
                                </td>

                                <td>
                                    <span class="badge badge-success">
                                        $
                                        <?= htmlspecialchars($valWithdraw['netAmount'], ENT_QUOTES, 'UTF-8'); ?>
                                    </span>
                                </td>

                                <td><?= htmlspecialchars($valWithdraw['orderid'], ENT_QUOTES, 'UTF-8'); ?></td>

                                <td><?= htmlspecialchars($valWithdraw['walletAddress'], ENT_QUOTES, 'UTF-8'); ?></td>

                                <td>
                                    <i class="fa fa-clock-o"></i>
                                    <?= htmlspecialchars(date("d-m-Y H:i:s", strtotime($valWithdraw['date_time'])), ENT_QUOTES, 'UTF-8'); ?>
                                </td>

                                <td>
                                    <?php
                                    if ($valWithdraw['released'] == 0)
                                        echo "<span class='badge badge-info'>PENDING</span>";
                                    else if ($valWithdraw['released'] == 1 OR $valWithdraw['status']=='FINISHED')
                                        echo "<span class='badge badge-success'>RELEASED</span>";
                                    else if ($valWithdraw['released'] == 2)
                                        echo "<span class='badge badge-danger'>REJECTED</span>";
                                    // else if ($valWithdraw['released'] == 3)
                                    //     echo "<span class='badge badge-warning'>PROCESSING</span>";
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>

                </table>
            </div>


        </div>
    </div>
</div>



<?php require_once("Include/Footer.php"); ?>