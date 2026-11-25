

<!DOCTYPE html>
<html lang="en">
<?php include('include/head.php');
include("loginCheck.php");
include('include/header.php');
include('include/menu.php'); ?>

<div id="main-content">
   <div class="container-fluid">
      <div class="block-header">
         <div class="row">
            <div class="col-lg-5 col-md-8 col-sm-12">
               <h2><a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>Principal Withdraw History</h2>
               <ul class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard"><i class="icon-home"></i></a></li>
                  <li class="breadcrumb-item"> Withdraw </li>
                  <li class="breadcrumb-item active"> Withdraw History</li>
               </ul>
            </div>
         </div>
      </div>
      <div class="row clearfix">
         <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
               <div class="header">
                  <h2>Withdraw History</h2>
                  <span id="errorMsg"></span> </br>
                  <span id="account"></span></br>
                  <span id="getBalance"></span><br>
                  <input type="hidden" id="walletKey" name="walletKey">
                  <input type="hidden" id="currentTrxBalance">
               </div>
               <div class="body">
                  <div class="table-responsive">
                     <table class="table table-hover js-basic-example dataTable table-custom mb-0">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>UserId</th>
                              <th>Amount</th>
                              <th>OrderId</th>
                              <th>Action Date</th>
                              <th>Withdraw Status</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $count = 0;
                           $queryWithdraw = mysqli_query($con, "SELECT a.*,b.user_id FROM meddolic_user_principal_invest_withdraw a, meddolic_user_details b WHERE  a.memberId=b.member_id  ORDER BY a.dateTime DESC");
                           while ($valWithdraw = mysqli_fetch_assoc($queryWithdraw)) {
                              $count++; ?>
                              <tr>
                                 <td><?= $count ?></td>
                                 <td><?= $valWithdraw['user_id'] ?></td>
                                 <td><span class='badge badge-danger'><?= $valWithdraw['amount'] ?> </span></td>

                                 <td><?= $valWithdraw['orderId'] ?></td>

                                 <td><i class="fa fa-clock-o"></i> <?= date("d-m-Y H:i:s", strtotime($valWithdraw['approvedDate'])) ?></td>
                                 <td><?php if ($valWithdraw['released'] == 0) echo "<span class='badge badge-primary'>PROCESSING</span>";
                                       else if ($valWithdraw['released'] == 1) echo "<span class='badge badge-success'>RELEASED</span>";
                                       else if ($valWithdraw['released'] == 2) echo "<span class='badge badge-danger'>REJECTED</span>";
                                       else if ($valWithdraw['released'] == 3) echo "<span class='badge badge-danger'>PENDING</span>";
                                       else if ($valWithdraw['released'] == 4) echo "<span class='badge badge-warning'>PROCESSING</span>"; ?></td>
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
   var d = document.getElementById("onlinePaymentHistory");
   d.className += " active";
</script>


</body>

</html>