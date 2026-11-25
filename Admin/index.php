<!DOCTYPE html>
<html lang="en">

<head>
    <title>Fund X || Login || Admin</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="description" content="Fund X  || Login || Admin">
    <meta name="author" content="Fund X  || Login || Admin">

    <link rel="icon" href="../admin-assets/images/favicon.png" type="image/x-icon">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="../admin-assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../admin-assets/vendor/font-awesome/css/font-awesome.min.css">

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="../admin-assets/css/main.css">
    <link rel="stylesheet" href="../admin-assets/css/color_skins.css">
</head>
<?php $curTime = time(); ?>

<body class="theme-cyan">
    <!-- WRAPPER -->
    <div id="wrapper">
        <div class="vertical-align-wrap">
            <div class="vertical-align-middle auth-main">
                <div class="auth-box">
                    <div class="top" style=" display: flex; justify-content: center;">
                        <img src="../admin-assets/images/logo.png" alt="Fund X ">
                    </div>
                    <div class="card">
                        <div class="header">
                            <p class="lead">Administration Login to your account</p>
                        </div>
                        <div class="body">
                            <form class="form-auth-small" action="loginProcess" method="POST">
                                <div class="form-group">
                                    <label for="User ID" class="control-label sr-only">User ID</label>
                                    <input type="text" class="form-control mb-0" id="username" name="username"
                                        placeholder="User ID" required autofocus>
                                </div>
                                <div class="form-group">
                                    <label for="Password" class="control-label sr-only">Password</label>
                                    <input type="password" class="form-control mb-0" name="password" id="pass"
                                        placeholder="Password" required>
                                </div>
                                <div class="row">
                                    <div class="col-sm-7">
                                        <div class="form-group">
                                            <label for="bankname">Email Verification OTP *</label>
                                            <input placeholder="Verification OTP Code" name="emailOtp"
                                                required="required" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <button
                                                style="margin-top:33px;padding:6px 20px 10px 20px; white-space: nowrap ;"
                                                type="button" class="btn btn-info" id="emailBtn">
                                                <div class="v-btn__content"
                                                    onclick="CryptoSendEmailOTP('<?= $curTime ?>')">Send OTP <span
                                                        id="count" style="visibility:hidden;">00 S</span></div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block">LOGIN</button>
                                <div class="bottom">
                                    <span class="helper-text m-b-10"><i class="fa fa-long-arrow-left"></i> <a
                                            href="https://Fund X .in">Back to Website</a></span>
                                    <span>Don't have an account? <a href="../authUserRegister">Register</a></span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END WRAPPER -->
    <script src="adminCustom.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</body>

</html>