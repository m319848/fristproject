<?php
   include("../../conection.php");
    $withdrawId = $_POST['withdrawId'];
    $d=date('Y-m-d H:i:s');
    $query=mysqli_query($con,"UPDATE meddolic_user_wallet_withdrawal_crypto SET released=1,payment_date='$d' WHERE id='$withdrawId'");
    if($query){
        echo "1";
        return true;
    } else {
        return false;
    }
?>