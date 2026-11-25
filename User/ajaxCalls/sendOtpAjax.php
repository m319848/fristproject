<?php

use PHPMailer\PHPMailer\PHPMailer;

include("../../conection.php");
require_once "../../PHPMailer/PHPMailer.php";
require_once "../../PHPMailer/SMTP.php";
require_once "../../PHPMailer/Exception.php";
require_once "../../PHPMailer/OAuthCredential.php";

$memberId = $_POST['memberId'];

$queryMember = mysqli_query($con, "SELECT email_id,name FROM meddolic_user_details WHERE member_id = '$memberId'");

if (mysqli_num_rows($queryMember) > 0) {
    $valMember = mysqli_fetch_assoc($queryMember);
    $email = $valMember['email_id'];
    $name = $valMember['name'];
    $otp = rand(100000, 999999);

    // Send OTP 
    $mailSubject = "Fund X  Withdrawal OTP";
    $newMsg = "
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, Helvetica, sans-serif;
                    background-color: #f4f4f4;
                    color: #222222;
                }
                .container {
                    background-color: #ffffff;
                    padding: 20px;
                    margin: 0 auto;
                    width: 80%;
                    border-radius: 10px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }
                .highlight {
                    color: #ff0000;
                    font-family: 'Comic Sans MS', cursive;
                }
                .orange-text {
                    color: #FF8C00;
                }
                .footer {
                    margin-top: 20px;
                    font-family: Georgia, serif;
                    color: #555555;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <p>Dear <span class='highlight'><strong>$name</strong></span>,</p>
                
                <p>Thank you for using our platform. To complete your withdrawal process, please use the OTP provided below:</p><br>

                <p><strong>Withdrawal OTP:</strong> <span class='orange-text'><em>$otp</em></span></p><br>
                
                <p>Please do not share this code with anyone. If you did not initiate this transaction, please contact our support team immediately.</p>

                <br>
                <p>Best regards,</p>
                <p class='footer'><strong>Fund X  TEAM</strong></p>
            </div>
        </body>
        </html>
    ";
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
    $mail->addAddress($email); // enter email address whom you want to send
    $mail->Subject = ("$mailSubject");
    $mail->Body = $newMsg;
    $mail->send();

    // SET OTP IN SESSION
    $_SESSION['withdrawal_otp'] = $otp;

    echo "success";
    return;
}
