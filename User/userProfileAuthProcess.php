<?php
include("loginCheck.php");
// require('../PHPMailer/EncrptyModel.php');
if (isset($_POST['profileUpdate'])) {
    $queryAccess = mysqli_query($con, "SELECT member_id,topupFlag FROM meddolic_user_details 
    WHERE user_id='{$_SESSION['member_user_id']}'");
    $valAccess = mysqli_fetch_array($queryAccess);
    if (!$valAccess) {
        echo "<script>alert('Invalid session. Please log in again.'); window.top.location.href='LoginAuth';</script>";
        exit;
    }
    $memberId = $valAccess['member_id'];
    $topupFlag = $valAccess['topupFlag'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $emailId = $_POST['emailId'];
    $countryId = $_POST['countryId'];

    // if ($topupFlag == 1) {
    //     ?>
    //
    <script>
        //         alert("Profile update is not allowed after activation!");
        //         window.top.location.href = "userProfile";
        //     </script>
    // <?php
    //     exit;
    // }

    // $otp = md5($_POST['profileEmailOTP']);
    // $actualOtp = $_SESSION['profileOTP'];

    // $otpExpiry = $_SESSION['profileOTP_expiry'] ?? 0;
    // unset($_SESSION['profileOTP']);
    // unset($_SESSION['profileOTP_expiry']);

    // if (time() > $otpExpiry) {
    //     echo "<script>alert('OTP has expired!'); window.top.location.href = 'Profile';</script>";
    //     exit;
    // }


    // if ($otp != $actualOtp) { ?>
    //
    <script>
        //         alert("Incorrect OTP!!!");
        //         window.top.location.href = "Profile";
        //     </script>
    //
    <?php
    //     exit;
    // }


    $d = date("Y-m-d H:i:s");
    mysqli_query($con, "UPDATE meddolic_user_details SET name='$name',email_id='$emailId',phone='$phone',countryId='$countryId' WHERE member_id='$memberId'"); ?>
    <script>
        alert("Profile Updated Successfully!!!");
        window.top.location.href = "Profile";
    </script>
<?php }

if (isset($_POST['updateBank'])) {
    $memberId = $_POST['memberId'];
    $bankName = $_POST['bankName'];
    $ifsc = $_POST['ifsc'];
    $account_number = $_POST['account_number'];
    $branchName = $_POST['branchName'];

    $otp = md5($_POST['emailOtp']);
    $actualOtp = $_SESSION['bankOtp'];

    $otpExpiry = $_SESSION['bankOtp_expiry'] ?? 0;
    unset($_SESSION['bankOtp']);
    unset($_SESSION['bankOtp_expiry']);

    if (time() > $otpExpiry) {
        echo "<script>alert('OTP has expired!'); window.top.location.href = 'Profile';</script>";
        exit;
    }


    if ($otp != $actualOtp) { ?>
        <script>
            alert("Incorrect OTP!!!");
            window.top.location.href = "profile";
        </script>
        <?php
        exit;
    }

    $d = date("Y-m-d H:i:s");
    $todayDate = date("Y-m-d");

    $queryIn = mysqli_query($con, "UPDATE meddolic_user_details SET bankName=ucase('$bankName'),ifsc=ucase('$ifsc'),branchName=ucase('$branchName'),account_no='$account_number' WHERE member_id='$memberId'");
    if ($queryIn) {
        ?>
        <script>
            alert('Bank Details Updated Successfully');
            window.top.location.href = "Dashboard";
        </script>
        <?php
        exit;
    } else { ?>
        <script>
            alert('Bank Details Not Updated...Try Again');
            window.top.location.href = "Dashboard";
        </script>
        <?php
        exit;
    }
}
if (isset($_POST['addWalletAddress'])) {
    $queryAccess = mysqli_query($con, "SELECT member_id FROM meddolic_user_details 
    WHERE user_id='{$_SESSION['member_user_id']}'");
    $valAccess = mysqli_fetch_array($queryAccess);
    if (!$valAccess) {
        echo "<script>alert('Invalid session. Please log in again.'); window.top.location.href='LoginAuth';</script>";
        exit;
    }
    $memberId = $valAccess['member_id'];
    $currencyId = $_POST['currencyId'];
    $trnPassword = $_POST['trnPassword'];
    $walletAddress = $_POST['walletAddress'];
    $d = date("Y-m-d H:i:s");
    $queryCheck = mysqli_query($con, "SELECT COUNT(1) FROM meddolic_user_details where trnPassword='$trnPassword'");
    $valCheck = mysqli_fetch_array($queryCheck);
    if ($valCheck[0] == 0) {
        ?>

        <script>
            alert("Incorrect Transaction Password!!!");
            history.go(-1);

        </script>
        <?php
        exit;
    }

    // $emailOtp = ($_POST['emailOtp']);
    // $actualOtp = $_SESSION['addressVerifyOTP'];


    // unset($_SESSION['addressVerifyOTP']);
    // if ($actualOtp <> $emailOtp) {
    //     ?>

    //     <script>
    //         alert("Invalid OTP Enter");
    //         window.top.location.href = 'addWalletAddress';
    //     </script>
    //     <?php
    //     exit;
    // }

    $queryWalletCheck = mysqli_query($con, "
    SELECT COUNT(1) 
    FROM meddolic_user_wallet_address_details 
    WHERE walletAddress='$walletAddress'
");

    $valWalletCheck = mysqli_fetch_array($queryWalletCheck);

    if ($valWalletCheck[0] > 0) {
        ?>
        <script>
            alert('This Wallet Address is already added!');
            window.top.location.href = "addWalletAddress";
        </script>
        <?php
        exit;
    }


    $queryIn = mysqli_query($con, "INSERT INTO meddolic_user_wallet_address_details (`currency_id`,`member_id`,`walletAddress`,`addDate`) VALUES ('$currencyId','$memberId','$walletAddress','$d')");
    if ($queryIn) { ?>
        <script>
            alert('Wallet Address Added Successfully');
            window.top.location.href = "addWalletAddress";
        </script>
        <?php
        exit;
    } else { ?>
        <script>
            alert('Wallet Address Not Added...Try Again');
            window.top.location.href = "addWalletAddress";
        </script>
        <?php
        exit;
    }
}

if (isset($_POST['changeLogin'])) {
    $queryAccess = mysqli_query($con, "SELECT member_id FROM meddolic_user_details 
    WHERE user_id='{$_SESSION['member_user_id']}'");
    $valAccess = mysqli_fetch_array($queryAccess);
    if (!$valAccess) {
        echo "<script>alert('Invalid session. Please log in again.'); window.top.location.href='LoginAuth';</script>";
        exit;
    }
    $memberId = $valAccess['member_id'];
    $password = $_POST['password'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
    $d = date("Y-m-d H:i:s");

    if ($password2 != $password1) { ?>
        <script>
            alert("New Login passwords do not match!!!");
            window.top.location.href = 'Profile';
        </script>
        <?php
        exit;
    }
    // $newCalObj = new passEncrypt;
    // $encPass = $newCalObj->twoPassEncrypt($password);
    $result = mysqli_query($con, "SELECT count(*) FROM meddolic_user_details WHERE member_id='$memberId' AND password='$password'");
    $val = mysqli_fetch_array($result);
    if ($val[0] == 0) { ?>
        <script>
            alert("Incorrect Current Login password!!!");
            window.top.location.href = 'Profile';
        </script>
        <?php
        exit;
    }
    // $newCalObj = new passEncrypt;
    // $newEncPass = $newCalObj->twoPassEncrypt($password1);
    $result1 = mysqli_query($con, "UPDATE meddolic_user_details SET password='$password1' WHERE member_id='$memberId'");
    if ($result1) {
        unset($_SESSION['user_member_id']);
        unset($_SESSION['member_user_id']);
        unset($_SESSION['member_password']); ?>
        <script>
            alert("Login Password Updated Successfully!!!\nNow please login again with new password. ");
            window.top.location.href = 'Profile';
        </script>
        <?php
    }
}
if (isset($_POST['changeTrn'])) {
    $queryAccess = mysqli_query($con, "SELECT member_id FROM meddolic_user_details 
    WHERE user_id='{$_SESSION['member_user_id']}'");
    $valAccess = mysqli_fetch_array($queryAccess);
    if (!$valAccess) {
        echo "<script>alert('Invalid session. Please log in again.'); window.top.location.href='LoginAuth';</script>";
        exit;
    }
    $memberId = $valAccess['member_id'];
    $password = $_POST['trnPassword'];
    $password1 = $_POST['trnPassword1'];
    $password2 = $_POST['trnPassword2'];
    $d = date("Y-m-d H:i:s");
    if ($password2 != $password1) { ?>
        <script>
            alert("New Transaction passwords and Confirm Transaction Password do not match!!!");
            window.top.location.href = 'Profile';
        </script>
        <?php
        exit;
    }
    // $newCalObj1= new passEncrypt;
    // $encTrnPass= $newCalObj1 -> twoPassEncrypt($password);
    $result = mysqli_query($con, "SELECT COUNT(*) FROM meddolic_user_details WHERE member_id='$memberId' AND trnPassword='$password'");
    $val = mysqli_fetch_array($result);
    if ($val[0] == 0) { ?>
        <script>
            alert("Incorrect Current Transaction password!!!");
            window.top.location.href = 'Profile';
        </script>
        <?php
        exit;
    }
    // $newCalObj1 = new passEncrypt;
    // $newencTrnPass = $newCalObj1->twoPassEncrypt($password1);
    $result1 = mysqli_query($con, "UPDATE meddolic_user_details SET trnPassword='$password1' WHERE member_id='$memberId'");
    if ($result1) { ?>
        <script>
            alert("Transaction Password Updated Successfully!!!");
            window.top.location.href = 'Profile';
        </script>
        <?php
    }
} ?>
<?php include("../close-connection.php"); ?>