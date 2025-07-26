<?php

require_once __DIR__ . '/../models/Donation.php';
require_once __DIR__ . '/../../core/databaseconn.php';

class DonationController
{
   
    private $donationModel;

    public function __construct()
    {
        //create connection once
        $db = new Database();
        $conn = $db->connect();
        
        $this->donationModel = new Donation($conn);
    }

    // Show donation form
    public function donateForm()
    {
        include 'app/views/donate.php';
    }

    // Handle form submission
    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /donate");
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $amount = floatval($_POST['amount'] ?? 0);
        $message = trim($_POST['message'] ?? null);

        if (!$name || !$email || !filter_var($email, FILTER_VALIDATE_EMAIL) || $amount < 50) {
            $_SESSION['error'] = "Please fill all fields correctly and minimum amount is Rs 50.";
            header("Location: /donate");
            exit;
        }

        $user_id = $_SESSION['user']['id'] ?? null;

        $saved = $this->donationModel->saveDonation($user_id, $name, $email, $amount, $message);

        if ($saved) {
            // Send thank you email
            $this->sendThankYouEmail($email, $name, $amount);

            $_SESSION['success'] = "Thank you for your donation! A confirmation email has been sent.";
        } else {
            $_SESSION['error'] = "Failed to save donation. Please try again.";
        }

        header("Location: /donate");
        exit;
    }

    private function sendThankYouEmail($toEmail, $toName, $amount)
    {
        $subject = "Thank you for your donation to Pawfect Match!";
        $message = "
            Dear $toName,<br><br>
            Thank you for your generous donation of Rs $amount to Pawfect Match.<br>
            Your contribution will help us provide food, shelter, and care for homeless animals.<br><br>
            With gratitude,<br>
            The Pawfect Match Team
        ";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: no-reply@pawfectmatch.com" . "\r\n";

        mail($toEmail, $subject, $message, $headers);
    }
}
