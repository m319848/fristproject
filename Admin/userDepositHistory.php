<!DOCTYPE html>
<html lang="en">
<?php include('include/head.php');
include("loginCheck.php");
include('include/header.php');
include('include/menu.php'); ?>
<div id="main-content">
  <div class="container-fluid">
    <div class="row clearfix">
      <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
          <div class="header">
            <h2>Deposit History of User</h2>
          </div>
          <div class="body">
            <div class="table-responsive">
              <table class="table table-hover js-basic-example dataTable table-custom mb-0">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>UserId</th>
                    <th>Name</th>
                    <th>Total Deposit</th>
                    <th>Date</th>
                    <th>Status</th>
                  </tr>
                </thead>
               <tbody>
                  <?php
                  $count = 0;
                  $queryFund = mysqli_query($con, "
                   SELECT a.packagePrice AS total_amount,a.paymentStatus,a.addDate,b.user_id, b.name
                   FROM meddolic_user_invest_purchase_details a, meddolic_user_details b
                   WHERE a.loginMemberId = b.member_id
                   ORDER BY a.addDate DESC");
                  while ($valFund = mysqli_fetch_array($queryFund)) {
                    $count++; ?>
                    <tr>
                      <td><?= $count; ?></td>
                      <td><?= $valFund['user_id']; ?></td>
                      <td><?= $valFund['name']; ?></td>
                      <td><?= number_format($valFund['total_amount'], 2); ?></td>
                    <td><?= date("d-m-Y H:i:d", strtotime($valFund['addDate']))?></td>
                      <td> <?php 
                      if ($valFund['paymentStatus'] =='finished' ){
                         echo '<span class="badge badge-success">FINISHED
                      </span>';
                      }
                      elseif ($valFund['paymentStatus'] =='canceled') {
 echo '<span class="badge badge-danger">CANCELED
                      </span>';
                      }
                       elseif ($valFund['paymentStatus'] =='waiting') {
 echo '<span class="badge badge-primary">WAITING
                      </span>';
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
    </div>
  </div>
</div>
<?php include('include/footer.php'); ?>
<script>
  var d = document.getElementById("transfer");
  d.className += " active";
  var d = document.getElementById("fundRequest");
  d.className += " active";
</script>
</body>

</html>