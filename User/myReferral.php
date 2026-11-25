<?php
require_once("loginCheck.php");
require_once('Include/Head.php');
require_once('Include/Sidebar.php');
?>

<div class="dashboard">
    <div class="income-report-container">
        <div class="page-breadcrumb">
            <p>Team Network / <span>My Referral</span></p>
        </div>

        <div class="report-card">

            <div class="table-responsive">
                <table class="income-table" id="example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>UserId</th>
                            <th>Name</th>
                            <th>EmailId</th>
                            <th>Phone</th>
                            <th>Register Date</th>
                            <th>Active Status</th>
                            <th>Active Date</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $count = 0;

                        $queryDirect = mysqli_query($con, "
SELECT member_id,user_id,name,email_id,phone,date_time,topupFlag,activationDate
FROM meddolic_user_details
WHERE sponser_id='$memberId'
ORDER BY date_time DESC
");

                        while ($valDirect = mysqli_fetch_assoc($queryDirect)) {
                            $count++;
                            ?>
                            <tr>
                                <td><?= $count ?></td>

                                <td><?= htmlspecialchars($valDirect['user_id'], ENT_QUOTES, 'UTF-8'); ?></td>

                                <td><?= htmlspecialchars($valDirect['name'], ENT_QUOTES, 'UTF-8'); ?></td>

                                <td><?= htmlspecialchars($valDirect['email_id'], ENT_QUOTES, 'UTF-8'); ?></td>

                                <td><?= htmlspecialchars($valDirect['phone'], ENT_QUOTES, 'UTF-8'); ?></td>

                                <td>
                                    <i class="fa fa-clock-o"></i>
                                    <?= htmlspecialchars(date("d-m-Y H:i:s", strtotime($valDirect['date_time'])), ENT_QUOTES, 'UTF-8'); ?>
                                </td>

                                <td>
                                    <?php
                                    if ($valDirect['topupFlag'] == 1)
                                        echo "<span class='badge badge-success'>Active</span>";
                                    else
                                        echo "<span class='badge badge-danger'>In-Active</span>";
                                    ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($valDirect['activationDate'], ENT_QUOTES, 'UTF-8'); ?>
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