
<br><br><br>
<center>
<h2>Processing your request!!!</h2>
<h3>Please do not press back or refresh!!!</h3>
</center>
<?php 

ob_start();
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set("Asia/Kolkata"); 
include("loginCheck.php");
if(isset($_POST['miscUpdate'])){
    $tokenName=$_POST['tokenName'];
    $tokenRate=$_POST['tokenRate'];
    $miscId=$_POST['miscId'];
    $d=date('Y-m-d H:i:s');
    
    $queryIn=mysqli_query($con,"UPDATE meddolic_config_token_rate SET tokenRate='$tokenRate' WHERE tokenId='$miscId'");
    if($queryIn){ ?>
        <script>
            alert('Token Rate Updated Successfully');
            window.top.location.href="miscSetting";
        </script>
        <?php
        exit;
    }else{ ?>
        <script>
            alert('Token Rate Not Updated...Try Again');
            window.top.location.href="miscSetting";
        </script>
        <?php
        exit;
    } } ?>
<?php include("../close-connection.php"); ?>