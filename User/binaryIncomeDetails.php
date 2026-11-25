<?php
require_once("loginCheck.php");
require_once('Include/Head.php');
require_once('Include/Menu.php');
require_once('Include/Header.php'); ?>

<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">


        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Financial Report /</span> Binary Income
        </h4>
        <div class="container-fluid">

            <div class="table-panel">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered table-custom table-hover ">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>User Id</th>
                                        <th>Name</th>
                                        <th>Amount</th>
                                        <th>Release Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 0;
                                    $queryDeal = mysqli_query($con, "SELECT DISTINCT a.incomeAmount,a.date_time,b.user_id,b.name FROM  meddolic_user_matching_income_details a, meddolic_user_details b WHERE a.summary_id='$_GET[summary_id]' AND a.member_id=b.member_id ORDER BY a.date_time ASC");
                                    while ($valDeal = mysqli_fetch_assoc($queryDeal)) {
                                        $count++; ?>
                                        <tr>
                                            <td><?= $count ?></td>
                                            <td><?= $valDeal['user_id'] ?></td>
                                            <td><?= $valDeal['name'] ?></td>
                                            <td><span class="badge badge-success"> $ <?= $valDeal['incomeAmount'] ?></span>
                                            </td>
                                            <td><i class="fa fa-clock-o"></i>
                                                <?= date("d-m-Y H:i:s", strtotime($valDeal['date_time'])); ?>
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
<?php require_once('Include/Footer.php'); ?>