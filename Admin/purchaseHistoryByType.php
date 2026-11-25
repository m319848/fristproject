<!DOCTYPE html>
<html lang="en">
<?php include('include/head.php');
include("loginCheck.php");
include('include/header.php');
include('include/menu.php'); ?>
<?php
$user_id1 = "";
if ($_GET) {
  if ($_GET['user_id']) {
    $user_id1 = $_GET['user_id'];
    $query = "select count(*) from meddolic_user_details where user_id='$user_id1'";
    $result = mysqli_query($con, $query);
    $val = mysqli_fetch_array($result);
    if ($val[0] == 0) { ?>
      <script>
        alert("Invalid User Id");
      </script>
<?php
      $user_id1 = $mainId;
    }
  }
  if ($_GET['from_date']) {
    $show_date = $_GET['from_date'];
    $cal_date = date("Y-m-d", strtotime($show_date));
  }
  if ($_GET['to_date']) {
    $show_date1 = $_GET['to_date'];
    $cal_date1 = date("Y-m-d", strtotime($show_date1));
  }
} else {
  $show_date = date("d-m-Y");
  $show_date1 = date("d-m-Y");
  $cal_date = date("Y-m-d");
  $cal_date1 = date("Y-m-d");
}
?>
<div id="main-content">
  <div class="container-fluid">
    <div class="row clearfix">
      <div class="col-md-12">
        <div class="card">
          <div class="body">
            <form>
              <div class="row">
                <div class="col-lg-3 col-md-11">
                  <div class="input-group date">
                    <input class="form-control" type="text" placeholder="Enter User ID" name="user_id" value="<?= $user_id1 ?>">
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary" type="button"><i class="fa fa-user"></i></button>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-md-12">
                  <div class="input-group mb-3">
                    <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="from_date" id="from_date" placeholder="e.g. From Date" required value="<?= $show_date; ?>" readonly>
                  </div>
                </div>
                <div class="col-lg-3 col-md-12">
                  <div class="input-group mb-3">
                    <input name="to_date" id="to_date" data-provide="datepicker" data-date-autoclose="true" class="form-control" placeholder="e.g. To Date" required="" value="<?= $show_date1; ?>" readonly>
                  </div>
                </div>
                <div class="col-lg-3 col-md-12">
                  <div class="input-group mb-3">
                    <input class="btn btn-primary" type="submit" value="Search">
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
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
                    <th>Package name</th>
                    <th>Invest Amount</th>
                    <th>Invest Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $count = 0;
                  $queryFund = mysqli_query($con, "SELECT a.*,b.user_id,b.name from meddolic_user_activation_details a, meddolic_user_details b WHERE CAST(a.dateTime AS DATE) BETWEEN '$cal_date' AND '$cal_date1' AND a.memberId=b.member_id" . $query . "  ORDER BY a.dateTime ASC");
                  while ($valFund = mysqli_fetch_array($queryFund)) {
                    $count++;
                    $purchaseType = $valFund['purchaseType'];

                    if ($purchaseType == 1) {
                      $planName = "Plan A";
                    } elseif ($purchaseType == 2) {
                      $planName = "Plan B";
                    } else {
                      $planName = "Unknown Plan";
                    } ?>
                    <tr>
                      <td><?= $count; ?></td>
                      <td><?= $valFund['user_id']; ?></td>
                      <td><?= $valFund['name']; ?></td>
                      <td><?= $planName; ?></td>
                      <td> <?= $valFund['investAmount'] ?></td>
                      <td> <?= $valFund['dateTime'] ?></td>
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