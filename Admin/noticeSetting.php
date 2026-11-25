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
                    <h2><a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Notice Setting</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item"> Setting </a></li>
                        <li class="breadcrumb-item active"> Notice Setting</li>
                    </ul>
                </div>            
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Notice Setting</h2>
                        <!-- <a class="btn btn-success" data-id="ThisID"  data-toggle="modal" data-target="#addNotice" href="javascript:void(0)" style="float:right;" ><i class="fa fa-plus"></i> Add Notice</a><br> -->
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-hover js-basic-example dataTable table-custom mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>                    
                                        <!-- <th>Notice Header</th> -->
                                        <th>Notice Message</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                    $count=0;
                                    $todayDate=date('Y-m-d');
                                    $queryNews=mysqli_query($con,"SELECT * FROM meddolic_config_news_list WHERE newsId=1");
                                    $valNews=mysqli_fetch_assoc($queryNews);
                                        $count++; ?>
                                    <tr>
                                        <form action="popUpSettingProcess" method="POST"> 
                                            <td><?= $count; ?></td>
                                            <td><textarea type="text" class="form-control" name="newsContent" required rows=3 cols=80><?= $valNews['news']?></textarea></td>
                                            <td><input type="submit" class="btn btn-success" name="noticeUpdate" value="Update"><?php if($valNews['newStatus']==0){ ?><a href="javascript:void();" class="btn btn-warning" onclick="updateNoticeStatus('1')">Show</a>&nbsp;<?php } else { ?><a href="javascript:void();" class="btn btn-danger" onclick="updateNoticeStatus('0')">Hide</a><?php } ?></td>
                                        </form>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
  if(isset($_POST['addNotice'])){
    $title=$_POST['title'];
    $news=$_POST['news'];
    $fromDate=date("Y-m-d", strtotime($_POST['fromDate']));
    $toDate=date("Y-m-d", strtotime($_POST['toDate']));
    date_default_timezone_set("Asia/Kolkata"); 
    $d=date("Y-m-d H:i:s");  
    $queryIn="INSERT INTO meddolic_config_news_list (`title`,`news`,`addDate`,`fromDate`,`toDate`,`status`) VALUES('$title','$news','$d','$fromDate','$toDate',1)";
    $resIn=mysqli_query($con,$queryIn);
    if($resIn){ ?>
      <script>
        alert('Notice Added Successfully!!!');
        window.top.location.href='noticeSetting';
      </script>
      <?php } else{ ?>
        <script>
          alert('Notice Not Added???? \n Plz Try after Sometime???...');
          window.top.location.href='noticeSetting';
      </script>
  <?php } } ?>
<div class="modal fade" id="addNotice">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Notice :  </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
      </div>
      <form method="POST" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
            <label class="control-label" for="title">Notice Header</label>
            <input class="form-control" type="text" name="title" placeholder="e.g John Adem" required >
          </div>
          <div class="form-group">
            <label class="control-label" for="news">Notice Message</label>
            <textarea class="form-control" type="text" name="news" placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in venenatis enim" required ></textarea>
          </div>
          <div class="form-group">
            <label class="control-label" for="news">From Date</label>
            <?php $showToDate=date('d-m-Y', strtotime(date('Y-m-d')));
                $fromDate=date('Y-m-d'); ?>
            <input data-provide="datepicker" data-date-autoclose="true" class="form-control" placeholder="e.g. From Date" disabled value="<?=$showToDate?>" >
            <input type="hidden" name="fromDate" value="<?=$fromDate?>">
          </div>
          <div class="form-group">
            <label class="control-label" for="news">To Date</label>
            <input name="toDate" id="to_date" data-provide="datepicker" data-date-autoclose="true" class="form-control" placeholder="e.g. To Date" required readonly>
          </div>
        </div>
        <div class="modal-footer">
          <input type="submit" name="addNotice" class="btn btn-success" value="Add Now">
          <input type="reset" class="btn btn-danger" value="Reset">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php include('include/footer.php'); ?>
<script>
function deleteNews(newsId){
  if(newsId!=""){
    if(confirm('Are you sure to Delete this Notice?')){
      $.ajax({
        type: "POST",
        url: 'ajaxCalls/deleteNewsAjax',
        data: { newsId:newsId },
        cache: false,
        success: function(data){
          // alert(data);
          if(data){
            alert('Notice Deleted Successfully');
            location.reload();
          }
        }
      });
    }
  }
}
function updateNoticeStatus(newStatus){
    $.ajax({
        type: "POST",
        url: 'ajaxCalls/updateNoticeStatusAjax',
        data: { newStatus:newStatus },
        cache: false,
        success: function(data){
            if(data){
                alert('Updated Successfully');
                location.reload();
            }
        }
    });
}
var d = document.getElementById("Setting");
    d.className += " active";
var d = document.getElementById("noticeSetting");
    d.className += " active";
</script>
</body>
</html> 