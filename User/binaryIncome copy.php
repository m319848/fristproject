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
                    <th>#</th>
                    <th>UserId</th>
                    <th>Name</th>
                    <th>Binary Get</th>
                    <th> Binary Income</th>
                    <th> Binary Percent</th>
                    <th> Date</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                  $query = mysqli_query($con, "SELECT matchingPercent from  meddolic_config_misc_setting");
                  $val1 = mysqli_fetch_array($query);
                  $binaryPercent = $val1['matchingPercent'];

                  function binaryReceived($con, $memberId, $summaryId)
                  {
                    $query = mysqli_query($con, "SELECT sum(incomeAmount) from  meddolic_user_matching_income_details WHERE summary_id='$summaryId' AND status=1");
                    $val1 = mysqli_fetch_array($query);
                    $total = $val1[0];
                    if ($total != "") {
                      echo "<span class='badge badge-success'>$  " . $total . "</span>";
                    } else {
                      echo "<span class='badge badge-danger'>$  0.00</span>";
                    }
                  }
                  $count = 0;

                  $queryInvest = mysqli_query($con, "SELECT a.summary_id,a.member_id,a.incomeAmount,a.date_Time,a.status,b.user_id,b.name FROM meddolic_user_matching_income_summary a, meddolic_user_details b WHERE a.member_id='$memberId' AND a.member_id=b.member_id ORDER BY a.date_Time DESC");
                  while ($valInvest = mysqli_fetch_assoc($queryInvest)) {
                    $count++; ?>
                    <tr>
                      <td><?= $count ?></td>
                      <td><?= $valInvest['user_id'] ?></td>
                      <td><?= $valInvest['name'] ?></td>
                      <td>$ <?= $valInvest['incomeAmount'] ?></td>
                      <td><?= binaryReceived($con, $memberId, $valInvest['summary_id']) ?></td>
                      <td> <?= $binaryPercent ?> %</td>
                      <td><i class="fa fa-clock-o"></i> <?= date("d-m-Y H:i:s", strtotime($valInvest['date_Time'])); ?>
                      </td>
                      <td>

                        <?php if ($valInvest['status'] == 1)
                          echo "<span class='badge badge-primary'>RUNNING</span>";
                        else if ($valInvest['status'] == 0)
                          echo "<span class='badge badge-success'>COMPLETED</span>";
                        else if ($valInvest['status'] == 2)
                          echo "<span class='badge badge-success'>COMPLETED</span>"; ?>
                      </td>
                      <td><a href="binaryIncomeDetails?summary_id=<?= $valInvest['summary_id'] ?>"
                          class="btn btn-success btn-xs"><i class="fa fa-eye"></i> More </a></td>
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