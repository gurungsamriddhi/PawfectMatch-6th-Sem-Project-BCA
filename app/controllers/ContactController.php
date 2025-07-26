<?php
require_once __DIR__ . '/../../mail/sendMail.php';
require_once __DIR__ . '/../models/Contact.php';
//use this contact controller to handle user side logic
class ContactController
{
    private $mailer;
    private $contactModel;

    public function __construct()
    {
        $db = new Database();
        $conn = $db->connect();
        $this->contactModel = new Contact($conn);
        $this->mailer = new Mailer();
    }

    public function showContactForm()
    {
        // Extract flash data
        $errors = $_SESSION['contact_errors'] ?? [];
        $old = $_SESSION['contact_old'] ?? [];
        $success = $_SESSION['contact_success'] ?? '';

        unset($_SESSION['contact_errors'], $_SESSION['contact_old'], $_SESSION['contact_success']);

        // Pre-fill name/email if logged in
        if (empty($old) && isset($_SESSION['user'])) {
            $old['fname'] = $_SESSION['user']['name'];
            $old['email'] = $_SESSION['user']['email'];
        }

        // Make variables available to view
        $data = [
            'errors' => $errors,
            'old' => $old,
            'success' => $success
        ];

        include __DIR__ . '/../views/contactus.php';
    }

    public function contactsubmit()
    {
        $userId = null;

        if (isset($_SESSION['user'])) {
            $fname = $_SESSION['user']['name'];
            $email = $_SESSION['user']['email'];
            $userId = $_SESSION['user']['id'];
        } else {
            $fname = trim($_POST['fname'] ?? '');
            $email = trim($_POST['email'] ?? '');
        }

        $message = trim($_POST['message'] ?? '');

        // Validation
        $errors = [];

        if (empty($fname)) {
            $errors['fname'] = 'Full name is required.';
        } elseif (strlen($fname) < 2) {
            $errors['fname'] = 'Full name must be at least 2 characters.';
        }

        if (empty($email)) {
            $errors['email'] = 'Email is required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format.';
        }

        if (empty($message)) {
            $errors['message'] = 'Message is required.';
        } elseif (strlen($message) < 10) {
            $errors['message'] = 'Message must be at least 10 characters.';
        }

        // If validation fails
        if (!empty($errors)) {
            $_SESSION['contact_errors'] = $errors;
            $_SESSION['contact_old'] = [
                'fname' => htmlspecialchars($fname),
                'email' => htmlspecialchars($email),
                'message' => htmlspecialchars($message)
            ];
            header('Location: index.php?page=contactcontroller/showcontactform');
            exit;
        }

        // Save to database
        $this->contactModel->saveMessage( $fname, $email, $message,$userId);

        // Send email
        $adminEmail = 'pawfectmatch27@gmail.com';
        $subject = "New Contact Form Message from $fname";
        $body = "
            <p><strong>Name:</strong> " . htmlspecialchars($fname) . "</p>
            <p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>
            <p><strong>Message:</strong><br>" . nl2br(htmlspecialchars($message)) . "</p>
        ";

        $sendResult = $this->mailer->sendMail($adminEmail, $subject, $body, 'Site Admin');

        if ($sendResult !== true) {
            $_SESSION['contact_errors'] = ['mail' => 'Failed to send your message. Please try again later.'];
            $_SESSION['contact_old'] = [
                'fname' => htmlspecialchars($fname),
                'email' => htmlspecialchars($email),
                'message' => htmlspecialchars($message)
            ];
        } else {
            $_SESSION['contact_success'] = 'Thank you for contacting us! We will get back to you soon.';
        }

        // Redirect to avoid form resubmission
        header('Location: index.php?page=contactcontroller/showcontactform');
        exit;
    }
}
