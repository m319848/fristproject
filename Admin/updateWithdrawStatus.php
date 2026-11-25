<?php
include("../conection.php"); // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = mysqli_real_escape_string($con, $_POST['status']);
    
    $queryUpdate = "UPDATE meddolic_config_misc_setting SET withdrawStatus='$status'";
    
    if (mysqli_query($con, $queryUpdate)) {
        echo "Withdrawal status updated successfully!";
    } else {
        echo "Error updating status: " . mysqli_error($con);
    }
}
?>
