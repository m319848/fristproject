<?php
    include("../../conection.php");
    $newStatus=$_POST['newStatus'];
    $query=mysqli_query($con,"UPDATE meddolic_config_news_list SET newStatus='$newStatus'");
    if($query){
        echo "1";
        return true;
    } else {
        return false;
    }
?>