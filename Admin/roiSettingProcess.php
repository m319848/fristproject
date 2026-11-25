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
if (isset($_POST['miscUpdate'])) {
    $roiPercent = $_POST['roiPercent'];
    $miscId = $_POST['miscId'];
    $d = date('Y-m-d H:i:s');

    $queryIn = mysqli_query($con, "UPDATE meddolic_config_misc_setting SET coinrate='$roiPercent' WHERE id='$miscId'");
    if ($queryIn) { ?>
        <script>
            alert('Coin Rate Updated Successfully');
            window.top.location.href = "roiSetting";
        </script>
        <?php
        exit;
    } else { ?>
        <script>
            alert('Coin Rate Not Updated...Try Again');
            window.top.location.href = "roiSetting";
        </script>
        <?php
        exit;
    }
} ?>
<?php include("../close-connection.php"); ?>