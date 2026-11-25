<?php
include("../conection.php");
// require('../PHPMailer/EncrptyModel.php');
$d = date("Y-m-d");
if ($_POST) {
    $username = mysqli_real_escape_string($con, $_POST['userid']);
    $password = mysqli_real_escape_string($con, $_POST['pass']);

    //      $emailOtp= md5($_POST['emailOtp']);
    // $actualOtp= $_SESSION['loginOTP'];
    // if($actualOtp<>$emailOtp){ 
    //     unset($_SESSION['loginOTP']); ?>
    //
    <script>
        //         alert("Invalid OTP Enter");
        //         window.top.location.href='index';
        //     </script>
    // <?php
    //     exit;
    // }

    // $passObj= new passEncrypt();
    // $encPass= $passObj -> twoPassEncrypt($password);
    $query = "SELECT * FROM meddolic_user_details WHERE user_id='$username' AND password='$password' AND userType=2";
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
        $_SESSION['user_id'] = $val['member_id'];
        $_SESSION['member_user_id'] = $_POST['userid'];
        $_SESSION['member_password'] = $password;
        ?>
            <script>window.top.location.href = 'Dashboard';</script> <?php
    }
    die();
} ?>
<?php include("../close-connection.php"); ?>