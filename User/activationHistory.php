<?php
require_once("loginCheck.php");
require_once('Include/Head.php');
require_once('Include/Sidebar.php');
?>

<div class="dashboard">
    <div class="income-report-container">
        <div class="page-breadcrumb">
            <p>Purchase/ <span> Purchase History</span></p>
        </div>
        <div class="report-card">

            <div class="table-responsive">
                <table class="income-table" id="example">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>User Id</th>
                            <th>Name</th>
                            <th>Package Amount</th>
                            <th>Package Type</th>
                            <th>Date of Activation</th>
                            <th>Purchase By</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 0;
                        $queryActive = mysqli_query($con, "SELECT a.investPrice,a.purchaseType ,a.date_time,a.purchaseType,b.user_id,b.name,c.user_id AS activerId,c.name AS activerName FROM meddolic_user_activation_details a, meddolic_user_details b, meddolic_user_details c WHERE (a.member_id='$memberId' OR a.member_id='$memberId') AND a.member_id=b.member_id AND a.member_id=c.member_id ORDER BY a.date_time DESC");
                        while ($valActive = mysqli_fetch_assoc($queryActive)) {
                            $count++; ?>
                            <tr>
                                <td>
                                    <?= $count ?>
                                </td>
                                <td>
                                    <?= $valActive['user_id'] ?>
                                </td>
                                <td>
                                    <?= $valActive['name'] ?>
                                </td>
                                <td>
                                    $ <?= $valActive['investPrice'] ?>
                                </td>
                                <td>
                                    <?php if ($valActive['purchaseType'] == 1)
                                        echo "<span class='badge badge-warning'>Activation Package</span>";
                                    else if ($valActive['purchaseType'] == 2)
                                        echo "<span class='badge badge-success'>Booster Package</span>";
                                     ?>
                                </td>
                                <td><i class="fa fa-clock-o"></i>
                                    <?= date("d-m-Y H:i:s", strtotime($valActive['date_time'])); ?>
                                </td>
                            
                                <td>
                                    <?= $valActive['activerName'] . " (User ID:" . $valActive['activerId'] . ")"; ?>
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