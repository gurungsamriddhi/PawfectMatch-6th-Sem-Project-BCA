<?php
require_once __DIR__ . '/../../core/databaseconn.php';
require_once __DIR__ . '/../models/Volunteer.php';

class VolunteerController
{
    private $volunteerModel;

    public function __construct()
    {
        $db = new Database();
        $conn = $db->connect();
        $this->volunteerModel = new Volunteer($conn);
    }

    public function apply()
    {

        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit();
        }


        $user_id = $_SESSION['user']['id'];
        $area = $_POST['area'] ?? '';
        $availability_days = $_POST['availability_days'] ?? [];
        $remarks = trim($_POST['remarks'] ?? '');
        $contact_number = trim($_POST['contact_number'] ?? '');

        $errors = [];


        $allowed_areas = ['pet care', 'training', 'fundraising', 'other'];
        if (!in_array($area, $allowed_areas)) {
            $errors['area'] = "Please select a valid area of interest.";
        }
        if (empty($availability_days)) {
            $errors['availability_days'] = "Please select at least one availability day.";
        }
        if (empty($contact_number)) {
            $errors['contact_number'] = "Contact number is required.";
        } 
        elseif (!preg_match('/^9\d{9}$/', $contact_number)) {
            $errors['contact_number'] = "Please enter a valid 10-digit Nepali number starting with 9.";
        }

        // 4. If errors, redirect back with errors & old data
        if (!empty($errors)) {
            $_SESSION['volunteer_errors'] = $errors;
            $_SESSION['volunteer_old'] = $_POST; // preserve old input
            header('Location: index.php?page=volunteer');
            exit();
        }



        $availability_days_str = implode(',', $availability_days);

        // Delegate to model for DB insert
        $success = $this->volunteerModel->addVolunteerRequest($user_id, $contact_number, $area, $availability_days_str, $remarks);

        if ($success) {
          $_SESSION['volunteer_success'] = "Your volunteer application has been submitted successfully. 
          Please allow 2 to 3 working days for review. 
          If approved, an adoption center will be assigned to you, and the details will be sent to your this email.";
        } else {
            $_SESSION['volunteer_errors']['general'] = ["Failed to submit your application. Please try again."];
            $_SESSION['volunteer_old'] = $_POST;
        }

        header('Location: index.php?page=volunteer');
        exit();
    }
}
?>
