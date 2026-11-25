<?php 
include("loginCheck.php");
if(isset($_POST['adminUpdate'])){
    $adminId=$_POST['adminId'];
    $user_id=$_POST['user_id'];
    $name=$_POST['name'];
    $phone=$_POST['phone'];
    $email_id=$_POST['email_id'];
    
    $result1=mysqli_query($con,"UPDATE meddolic_user_details SET user_id=ucase('$user_id'),name='$name',phone='$phone',email_id='$email_id' WHERE member_id='$adminId'");
    if($result1){ ?>
        <script>
        	alert("Admin Profile Updated Successfully");
    	    window.top.location.href='adminProfile';
        </script>
        <?php }else{ ?> 
        <script>
        	alert("Admin Profile Not-Updated..Try Again!!!");
    	    window.top.location.href='adminProfile';
        </script>	
    <?php } } ?>
<?php include("../close-connection.php"); ?>