<?php
require_once("loginCheck.php");
require_once('Include/Head.php');
require_once('Include/Sidebar.php');
?>

<div class="dashboard">
  <div class="income-report-container">
    <div class="page-breadcrumb">
      <p>Financial Report / <span>Binary Income</span></p>
    </div>

    <div class="report-card">

      <div class="table-responsive">
        <table class="income-table" id="example">
          <thead>
            <tr>
              <th>#</th>
              <th>UserId</th>
              <th>Name</th>
              <th>Left Business</th>
              <th>Right Business</th>
              <th>Binary Income</th>
              <th>Date</th>
              <th>Status</th>
            </tr>
          </thead>

          <tbody>
            <?php
            $count = 0;

            $queryInvest = mysqli_query($con, "
              SELECT 
                a.memberId,
                a.leftId,
                a.rightId,
                a.matchingIncome,
                a.dateTime,
                a.status,

                b.user_id,
                b.name,

                l.investPrice AS leftBusiness,
                r.investPrice AS rightBusiness

              FROM meddolic_user_matching_income a

              LEFT JOIN meddolic_user_details b 
                ON a.memberId = b.member_id

              LEFT JOIN meddolic_user_activation_details l 
                ON a.leftId = l.member_id

              LEFT JOIN meddolic_user_activation_details r 
                ON a.rightId = r.member_id

              WHERE a.memberId = '$memberId'

              ORDER BY a.dateTime DESC
            ");

            while ($valInvest = mysqli_fetch_assoc($queryInvest)) {

              $count++;

              $leftBusiness = $valInvest['leftBusiness'] ?? 0;
              $rightBusiness = $valInvest['rightBusiness'] ?? 0;
              ?>

              <tr>
                <td><?= $count ?></td>

                <td><?= $valInvest['user_id'] ?></td>

                <td><?= $valInvest['name'] ?></td>

                <td>
                  <span class="badge badge-primary">
                    $ <?= number_format($leftBusiness, 2) ?>
                  </span>
                </td>

                <td>
                  <span class="badge badge-info">
                    $ <?= number_format($rightBusiness, 2) ?>
                  </span>
                </td>

                <td>
                  $ <?= number_format($valInvest['matchingIncome'], 2) ?>
                </td>

                <td>
                  <i class="fa fa-clock-o"></i>
                  <?= date("d-m-Y H:i:s", strtotime($valInvest['dateTime'])); ?>
                </td>

                <td>
                  <?php
                  if ($valInvest['status'] == 1) {
                    echo "<span class='badge badge-success'>COMPLETED</span>";
                  } else if ($valInvest['status'] == 2) {
                    echo "<span class='badge badge-warning'>PENDING</span>";
                  } else {
                    echo "<span class='badge badge-danger'>FAILED</span>";
                  }
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