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
$otpCode = rand(11111, 99999);
unset($_SESSION['walletWidOtp']);
$_SESSION['walletWidOtp'] = md5($otpCode);
$_SESSION['otpGeneratedTime'] = time();
$queryMail = mysqli_query($con, "SELECT email_id ,name FROM meddolic_user_details WHERE user_id='$userId' AND userType=2");
$valMail = mysqli_fetch_assoc($queryMail);
$emailId = $valMail['email_id'];
$name = $valMail['name'];

require_once "../PHPMailer/PHPMailer.php";
require_once "../PHPMailer/SMTP.php";
require_once "../PHPMailer/Exception.php";
require_once "../PHPMailer/OAuthCredential.php";

$mailSubject = " Withdraw Verification OTP";

// Plain text version
$plainMsg = "Dear " . htmlspecialchars($name) . ",

Your Withdraw Update Verification OTP Code is: " . htmlspecialchars($otpCode) . "

If you did not request this, please contact our support team.

Best regards,
Turbo Ex Bot
";

// HTML version
$newMsg = '
<html>
<head>
    <title>Turbo Ex Bot Verification</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; background-color: #f4f4f4; color: #222; }
        .container { background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.07); max-width: 400px; margin: 30px auto; }
        .otp { color: #3c63e2; font-size: 1.3em; letter-spacing: 2px; }
        .footer { margin-top: 20px; color: #555; font-size: 13px; }
    </style>
</head>
<body>
    <div class="container">
        <p>Dear <strong>' . htmlspecialchars($name) . '</strong>,</p>
        <p>Your Withdraw Verification OTP Code is:</p>
        <p class="otp"><strong>' . htmlspecialchars($otpCode) . '</strong></p>
        <p>If you did not request this, please contact our support team.</p>
        <div class="footer"><strong>Turbo Ex Bot</strong></div>
    </div>
</body>
</html>
';

$mail = new PHPMailer();
$mail->isSMTP();
// $mail->SMTPDebug = 4; // Uncomment for debugging
$mail->Host = smtpServer;
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

// Email Settings
$mail->isHTML(true);
$mail->setFrom(EmailCode, mailerName);
$mail->addReplyTo('support@yourdomain.com', 'Turbo Ex Bot Support'); // Use your real support email
$mail->addAddress($emailId);
$mail->Subject = $mailSubject;
$mail->Body = $newMsg;
$mail->AltBody = $plainMsg;
$mail->addCustomHeader('X-Mailer', 'PHP/' . phpversion());

$mail->send();

echo "true";
return true;
?>