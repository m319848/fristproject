<?php
include("../conection.php");
// require('../PHPMailer/EncrptyModel.php');
$d = date("Y-m-d");
if ($_POST) {
    $msg = "";
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $device_info = mysqli_real_escape_string($con, $_SERVER['HTTP_USER_AGENT']);
    // $emailOtp = md5($_POST['emailOtp']);
    // $actualOtp = $_SESSION['loginOTP'];
    // if ($actualOtp <> $emailOtp) {
    //     unset($_SESSION['loginOTP']); ?>

    //
    <script>
        //         alert("Invalid OTP Enter");
        //         window.top.location.href = 'index';
        //     
    </script>
    // <?php
    //      exit;
    //  }

    // $passObj= new passEncrypt();
    // $encPass= $passObj -> twoPassEncrypt($password);
    $query = "SELECT * FROM meddolic_user_details WHERE user_id='$username' AND password='$password' AND userType=1";
    $sql = mysqli_query($con, $query); //execute a sql query
    $val = mysqli_fetch_array($sql);
    if (!$sql) {
        die('Query failed: ' . mysqli_error($con));
    }
    $count = mysqli_num_rows($sql); //count the no of rows returned
    if ($count == 0) { ?>
        <script>
            alert("Incorrect Userid or Password Login!!!\nPlease Try Again With Valid Id Password!!!");
            window.top.location.href = "index";
        </script>
        <?php
    } else if ($count == 1) {

        $login_time = date("Y-m-d H:i:s");
        $logged_user = $_POST['username'];

        // Login history table mein IP aur Device Info dono INSERT karein
        $history_query = "INSERT INTO meddolic_useradmin_login_history  (user_id, login_time, ip_address, device_info, status) 
                          VALUES ('$logged_user', '$login_time', '$ip_address', '$device_info', 'Success')";
        mysqli_query($con, $history_query);

        $_SESSION['admin_id'] = $val['member_id'];
        $_SESSION['admin_user_id'] = $_POST['username'];
        $_SESSION['admin_password'] = $password;
        ?>
            <script>
                window.top.location.href = 'dashboard';
            </script> <?php
    }
} ?>
<?php include("../close-connection.php"); ?>