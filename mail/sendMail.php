<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . ';/../PHPMailer/PHPMailer.php';
require_once __DIR__ . ';/../PHPMailer/SMTP.php';
require_once __DIR__ . '/../PHPMailer/Exception.php';

function sendVerificationEmail($toEmail, $name, $token)
{
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'pawfectmatch.pkr@gmail.com';
        $mail->Password = 'phoo gzdi byuv uvpr';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('pawfectmatch.pkr@gmail.com', 'Pawfect Match');
        $mail->addAddress($toEmail, $name);

        $verifyLink = "http://localhost/pawfectmatch/verify.php?email=$toEmail&token=$token";
        $mail->isHTML(true);
        $mail->Subject = 'Confirm your registration on PawfectMatch';
        $mail->Body = "Hi <strong>" . htmlspecialchars($name) . "</strong>,<br><br>
        Please click the link below to verify your email address:<br>
        <a href='$verifyLink'>$verifyLink</a><br><br>
        Thank you for registering with PawfectMatch!";
        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Failed to send verification link. Error: " . $e->getMessage();
    }
}
