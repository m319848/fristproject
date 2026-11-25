<?php
require_once("loginCheck.php");
require_once('Include/Head.php');
require_once('Include/Sidebar.php');
?>

<div class="dashboard">
  <div class="income-report-container">
    <div class="page-breadcrumb">
      <p>Team Network / <span>Left Team</span></p>
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
              <!--<th>Phone</th>-->
              <th>Register Date</th>
              <th>Active Status</th>
              <th>Active Date</th>
              <th>Total Invest</th>
            </tr>
          </thead>
          <tbody>
            <?php
            function totalInvest($con, $memberId)
            {
              $queryInvest = mysqli_query($con, "SELECT SUM(investPrice) FROM meddolic_user_activation_details WHERE member_id='$memberId'");
              $valInvest = mysqli_fetch_array($queryInvest);
              if ($valInvest[0] != "") {
                return $valInvest[0];
              } else {
                echo "0.00";
              }
            }
            $count = 0;
            $queryDirect = mysqli_query($con, "SELECT a.member_id,a.user_id,a.name,a.email_id,a.phone,a.date_time,a.topupFlag,a.activationDate FROM meddolic_user_details a,meddolic_user_matrix_team b WHERE b.memberId='$memberId' AND a.member_id=b.childId AND b.legPosition=2 ORDER BY b.dateTime DESC");
            while ($valDirect = mysqli_fetch_assoc($queryDirect)) {
              $count++; ?>
              <tr>
                <td><?= $count ?></td>
                <td><?= $valDirect['user_id'] ?></td>
                <td><?= $valDirect['name'] ?></td>
                <td><?= $valDirect['email_id'] ?></td>
                <!--<td><?= $valDirect['phone'] ?></td>-->
                <td><i class="fa fa-clock-o"></i> <?= date("d-m-Y H:i:s", strtotime($valDirect['date_time'])); ?></td>
                <td>

                  <?php if ($valDirect['topupFlag'] == 1)
                    echo "<span class='badge badge-success'>Active</span>";
                  else
                    echo "<span class='badge badge-danger'>In-Active</span>"; ?>
                </td>
                <td><?= $valDirect['activationDate'] ?></td>
                <td><span class="badge badge-success"> <?= totalInvest($con, $valDirect['member_id']) ?></span></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>


    </div>
  </div>
</div>



<?php require_once("Include/Footer.php"); ?>