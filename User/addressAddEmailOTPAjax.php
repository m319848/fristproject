<?php

use PHPMailer\PHPMailer\PHPMailer;

include("loginCheck.php");
$queryAccess = mysqli_query($con, "SELECT user_id FROM meddolic_user_details 
    WHERE user_id='{$_SESSION['member_user_id']}'");
$valAccess = mysqli_fetch_array($queryAccess);
if (!$valAccess) {
  echo "<script>alert('Invalid session. Please log in again.'); window.top.location.href='LoginAuth';</script>";
  exit;
}
$userId = $valAccess['user_id'];
$walletAddress = $_POST['walletAddress'];
$otpCode = rand(11111, 99999);
unset($_SESSION['addressVerifyOTP']);
$_SESSION['addressVerifyOTP'] = $otpCode;
$_SESSION['otpGeneratedTime'] = time();
$queryMail = mysqli_query($con, "SELECT email_id,name FROM meddolic_user_details WHERE user_id='$userId' AND userType=2");
$valMail = mysqli_fetch_assoc($queryMail);
$emailId = $valMail['email_id'];
$name = $valMail['name'];

require_once "../PHPMailer/PHPMailer.php";
require_once "../PHPMailer/SMTP.php";
require_once "../PHPMailer/Exception.php";
require_once "../PHPMailer/OAuthCredential.php";

$mailSubject = "Turbo Ex Bot | OTP Verification";
$newMsg = '
<html>
<head>
  <title>Turbo Ex Bot OTP Verification</title>
  <meta charset="UTF-8">
  <style>
    body { font-family: Arial, sans-serif; background: #f2f2f2; margin: 0; padding: 0; }
    .container { background: #fff; max-width: 480px; margin: 30px auto; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); padding: 32px 24px; }
    .header { color: #ff670a; font-size: 22px; font-weight: bold; margin-bottom: 18px; }
    .content { color: #222; font-size: 16px; }
    .otp-box { background: #f8f9fa; border-radius: 6px; padding: 16px 0; margin: 18px 0; text-align: center; font-size: 24px; letter-spacing: 2px; font-weight: bold; color: #2196f3; }
    .footer { color: #888; font-size: 13px; margin-top: 30px; border-top: 1px solid #eee; padding-top: 16px; }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">OTP Verification</div>
    <div class="content">
      <p>Dear ' . htmlspecialchars($name) . ',</p>
      <p>You have requested to add a wallet address to your Turbo Ex Bot profile. Please use the following One-Time Password (OTP) to verify your action:</p>
      <div class="otp-box">' . htmlspecialchars($otpCode) . '</div>
      <p>If you did not request this, please ignore this email or contact our support team immediately.</p>
      <p>Best regards,<br>
      <strong>Turbo Ex Bot Team</strong></p>
    </div>
    <div class="footer">
      This is an automated message. Please do not reply to this email.<br>
      &copy; ' . date('Y') . ' Turbo Ex Bot. All rights reserved.
    </div>
  </div>
</body>
</html>
';
$mail = new PHPMailer();
$mail->isSMTP();
// $mail->SMTPDebug = 4;  //Keep It commented this is used for debugging                          
$mail->Host = smtpServer; // smtp address of your email
$mail->SMTPAuth = true;
$mail->Username = EmailCode;
$mail->Password = addCode;
$mail->Port = smtpPort;
$mail->SMTPSecure = "tls";
$mail->smtpConnect([
  'ssl' => [
    'verify_peer' => false,
    'verify_peer_name' => false,
    'allow_self_signed' => true
  ]
]);

//Email Settings
$mail->isHTML(true);
$mail->setFrom(EmailCode, mailerName);
$mail->addAddress($emailId); // enter email address whom you want to send
$mail->Subject = ("$mailSubject");
$mail->Body = $newMsg;
if ($mail->send()) {
  echo "true";
  return true;
} else {
  echo "Mailer Error: " . $mail->ErrorInfo;
  return false;
}
