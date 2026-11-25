<?php

ob_start();

error_reporting(E_ALL ^ E_NOTICE);
include("loginCheck.php");

$user_id1 = $_POST['user_id'];
$member_id1 = $_POST['member_id1'];
$wallet_address = mysqli_real_escape_string($con, $_POST['wallet_address']);

// Check if wallet address already exists for this user
$check = mysqli_query($con, "SELECT member_id FROM meddolic_user_wallet_address_details WHERE member_id='$member_id1'");

if (mysqli_num_rows($check) > 0) {

    // ================= UPDATE =================
    $update = mysqli_query($con, "UPDATE meddolic_user_wallet_address_details 
                                  SET walletAddress='$wallet_address' 
                                  WHERE member_id='$member_id1'");

    if ($update) {
        ?>
        <script>
            alert("Wallet Address Updated Successfully.");
            window.top.location.href = 'viewMemberDetails?user_id=<?= $user_id1 ?>';
        </script>
        <?php
    } else {
        ?>
        <script>
            alert("Wallet Address Not Updated. Please Try Again!");
            window.top.location.href = 'viewMemberDetails?user_id=<?= $user_id1 ?>';
        </script>
        <?php
    }

} else {

    // ================= INSERT =================
    $insert = mysqli_query($con, "INSERT INTO meddolic_user_wallet_address_details (member_id, walletAddress)
                                  VALUES('$member_id1','$wallet_address')");

    if ($insert) {
        ?>
        <script>
            alert("Wallet Address Added Successfully.");
            window.top.location.href = 'viewMemberDetails?user_id=<?= $user_id1 ?>';
        </script>
        <?php
    } else {
        ?>
        <script>
            alert("Wallet Address Not Added. Please Try Again!");
            window.top.location.href = 'viewMemberDetails?user_id=<?= $user_id1 ?>';
        </script>
        <?php
    }
}
?>