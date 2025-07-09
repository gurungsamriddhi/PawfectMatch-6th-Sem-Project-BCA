<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/SMTP.php';
require_once __DIR__ . '/../PHPMailer/Exception.php';

class Mailer
{
    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->setupSMTP();
    }

    private function setupSMTP()
    {
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'pawfectmatch.pkr@gmail.com';
        $this->mail->Password = 'phoo gzdi byuv uvpr';  // Consider securing this!
        $this->mail->SMTPSecure = 'tls';
        $this->mail->Port = 587;
        $this->mail->setFrom('pawfectmatch.pkr@gmail.com', 'Pawfect Match');
        $this->mail->isHTML(true);
    }

    public function sendMail($toEmail, $subject, $body, $toName = '')
    {
        try {
            $this->mail->clearAddresses(); // Clear previous recipients
            if (!empty($toName)) {
                $this->mail->addAddress($toEmail, $toName);
            } else {
                $this->mail->addAddress($toEmail);
            }

            $this->mail->Subject = $subject;
            $this->mail->Body = $body;

            $this->mail->send();
            return true;
        } catch (Exception $e) {
            // You can log $e->getMessage() here for debugging
            return "Failed to send email. Error: " . $e->getMessage();
        }
    }

    public function sendVerificationEmail($toEmail, $name, $token)
    {
        $verifyLink = "http://localhost/pawfectmatch/verify.php?email=" . urlencode($toEmail) . "&token=" . urlencode($token);
        $subject = 'Confirm your registration on PawfectMatch';
        $body = "Hi <strong>" . htmlspecialchars($name) . "</strong>,<br><br>
                 Please click the link below to verify your email address:<br>
                 <a href='$verifyLink'>$verifyLink</a><br><br>
                 Thank you for registering with PawfectMatch!";

        return $this->sendMail($toEmail, $subject, $body, $name);
    }

    public function sendResetPasswordEmail($toEmail, $name, $tempPassword)
    {
        $subject = 'Your Temporary Password for Pawfect Match';
        $body = "Hi <strong>" . htmlspecialchars($name) . "</strong>,<br><br>
             Your password has been reset by the administrator.<br><br>
             <strong>Temporary Password:</strong> <code>$tempPassword</code><br><br>
             Please login using this password and change it immediately from your dashboard.<br><br>
             Regards,<br>
             <strong>Pawfect Match Team</strong>";

        return $this->sendMail($toEmail, $subject, $body, $name);
    }
}
