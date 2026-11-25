<!DOCTYPE html>
<html lang="en">
<?php include('include/head.php');
      include("loginCheck.php");
      include('include/header.php');
      include('include/menu.php'); ?>
<?php  
    $user_id1="";
    if($_GET){
      if($_GET['user_id']){
        $user_id1=$_GET['user_id'];
        $query="select count(*) from meddolic_user_details where user_id='$user_id1'";
        $result=mysqli_query($con,$query);
        $val=mysqli_fetch_array($result);
        if($val[0]==0) { ?>
          <script>
            alert("Invalid User Id");
            </script>
          <?php
          $user_id1=$mainId;
        }
      }
      if($_GET['from_date']){
        $show_date=$_GET['from_date'];
        $cal_date = date("Y-m-d", strtotime($show_date));
      }   
      if($_GET['to_date'] ){
        $show_date1=$_GET['to_date'];
        $cal_date1 = date("Y-m-d", strtotime($show_date1));
      }
    } else{
      $show_date=date("d-m-Y"); 
      $show_date1=date("d-m-Y");
      $cal_date=date("Y-m-d"); 
      $cal_date1=date("Y-m-d");
    }
?>
<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">                        
                    <h2><a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Withdraw History</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item"> Withdraw </li>
                        <li class="breadcrumb-item active"> Withdraw History</li>
                    </ul>
                </div>            
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card">
                    <div class="body">
                        <form>
                            <div class="row">
                                <div class="col-lg-3 col-md-12">
                                    <div class="input-group date">
                                        <input class="form-control" type="text" placeholder="Enter User ID" name="user_id" value="<?= $user_id1?>" >
                                        <div class="input-group-append">                      
                                            <button class="btn btn-outline-secondary" type="button"><i class="fa fa-user"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="input-group mb-3">
                                        <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="from_date" id="from_date" placeholder="e.g. From Date" required value="<?= $show_date; ?>" readonly >
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="input-group mb-3">
                                        <input name="to_date" id="to_date" data-provide="datepicker" data-date-autoclose="true" class="form-control" placeholder="e.g. To Date" required="" value="<?= $show_date1; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="input-group mb-3">
                                        <input class="btn btn-primary" type="submit" value="Search" >
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Withdraw History</h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-hover js-basic-example dataTable table-custom mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>UserId</th>
                                        <th>Wallet Address</th>
                                        <th>Gross Amount</th>
                                        <th>Charge</th>
                                        <th>Net Amount</th>
                                        <th>Date</th>
                                        <th>Trn Hash</th>
                                        <th>Release Date</th>
                                        <th>Withdraw Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                            <?php
                                $queryIn=mysqli_query($con,"SELECT member_id FROM meddolic_user_details WHERE user_id='$user_id1'");
                                $valIn=mysqli_fetch_assoc($queryIn);
                                $member_id1=$valIn[0];

                                $query="";
                                if($user_id1!="") {
                                  $query= $query." AND a.member_id='$member_id1'";  
                                }
                                if($withdrawStatus!="") {
                                  $query= $query." AND a.released='$withdrawStatus'";  
                                }
                                $count=0;
                                $queryWithdraw=mysqli_query($con,"SELECT a.*,b.name,b.user_id FROM meddolic_user_wallet_withdrawal_crypto a, meddolic_user_details b WHERE CAST(a.date_time AS date) BETWEEN '$cal_date' AND '$cal_date1' AND a.member_id=b.member_id ".$query." ORDER BY a.date_time DESC");
                                while($valWithdraw=mysqli_fetch_assoc($queryWithdraw)){
                                  $count++; ?>
                                <tr>
                                    <td><?= $count?></td>
                                    <td><?= $valWithdraw['user_id']?></td>
                                    <td><?= $valWithdraw['walletAddress']?></td>
                                    <td><span class="badge badge-success font-weight-bold"><i class="fa fa-usd"></i> <?= $valWithdraw['amount']?></span></td>
                                    <td><span class="badge badge-success font-weight-bold"><i class="fa fa-usd"></i> <?= $valWithdraw['withdrawCharge']?></span></td>
                                    <td><span class="badge badge-danger font-weight-bold"><i class="fa fa-usd"></i> <?= $valWithdraw['netAmount']?></span></td>
                                    <td class="text-left"><i class="fa fa-clock-o"></i> <?= $valWithdraw['date_time']?></td>
                                    <td><?= $valWithdraw['trnHash']?></td>
                                    <td class="text-left"><i class="fa fa-clock-o"></i> <?= $valWithdraw['payment_date']?></td>
                                    <td><?php if($valWithdraw['released']==0) echo "<span class='badge badge-warning font-weight-bold'>PROCESSING</span>";else if($valWithdraw['released']==1) echo "<span class='badge badge-success font-weight-bold'>PAID</span>";?></td>
                                    <td><?php if($valWithdraw['released']==0){ ?><a onclick="releaseManualBNBt(<?=$valWithdraw['id']?>)" href="javascript:void(0)" class="btn btn-primary btn-sm"> Release Manual</a><?php } ?></td>
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
function releaseManualBNBt(withdrawId){
    if(withdrawId!=""){
        if(confirm('Are you sure to Release this Payment?')){
            $.ajax({
                type: "POST",
                url: 'ajaxCalls/releaseManualBNBtAjax',
                data: { withdrawId:withdrawId },
                cache: false,
                success: function(data){
                    // alert(data);
                    if(data){
                        alert('Payment Release Successfully');
                        location.reload();
                    }
                }
            });
        }
    }
}
var d = document.getElementById("Withdraw");
    d.className += " active";
var d = document.getElementById("withdrawReleaseHistory");
    d.className += " active";
</script>
</body>
</html> 