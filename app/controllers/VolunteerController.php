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
        $address_line1 = trim($_POST['address_line1'] ?? '');
        $address_line2 = trim($_POST['address_line2'] ?? '');
        $province = $_POST['province'] ?? '';
        $city = $_POST['city'] ?? '';
        $postal_code = trim($_POST['postal_code'] ?? '');

        $errors = [];



        if (empty($contact_number)) {
            $errors['contact_number'] = "Contact number is required.";
        } elseif (!preg_match('/^9\d{9}$/', $contact_number)) {
            $errors['contact_number'] = "Please enter a valid 10-digit Nepali number starting with 9.";
        }


        //Area of Interest Validation
        $allowed_areas = ['pet care', 'training', 'fundraising', 'other'];
        if (empty($area)) {
            $errors['area'] = "Please select an area of interest.";
        } elseif (!in_array($area, $allowed_areas)) {
            $errors['area'] = "Invalid area of interest selected.";
        }

        if (empty($availability)) {
            $volunteer_errors['availability_days'] = 'Please select at least one availability option.';
        } else {
            // Optional: validate values are in allowed set
            $allowed = ['Weekends', 'Weekdays', 'Mon-Wed', 'Thu-Fri', 'Evenings', 'Flexible'];
            foreach ($availability as $val) {
                if (!in_array($val, $allowed)) {
                    $volunteer_errors['availability_days'] = 'Invalid availability day selected.';
                    break;
                }
            }
        }


        // Address Validation
        if (empty($address_line1)) {
            $errors['address_line1'] = "Address Line 1 is required.";
        } elseif (strlen($address_line1) > 255) {
            $errors['address_line1'] = "Address Line 1 cannot exceed 255 characters.";
        }
        //if address line is given(optional)
        if (!empty($address_line2) && strlen($address_line2) > 255) {
            $errors['address_line2'] = "Address Line 2 cannot exceed 255 characters.";
        }


        if (empty($province)) {
            $errors['province'] = "Please select a province.";
        }

        if (empty($city)) {
            $errors['city'] = "Please select a city.";
        }

        //Postal Code Validation
        if (empty($postal_code)) {
            $errors['postal_code'] = "Postal code is required.";
        } elseif (!preg_match('/^[0-9]{5}$/', $postal_code)) {
            $errors['postal_code'] = "Please enter a valid 5-digit postal code.";
        }

        //Remarks Validation (optional field)
        if (!empty($remarks) && strlen($remarks) > 500) {
            $errors['remarks'] = "Remarks cannot exceed 500 characters.";
        }
        //If errors, redirect back with errors & old data
        if (!empty($errors)) {
            $_SESSION['volunteer_errors'] = $errors;
            $_SESSION['volunteer_old'] = $_POST; // preserve old input
            header('Location: index.php?page=volunteer');
            exit();
        }
        
        // ✅ NOW CHECK EXISTING VOLUNTEER APPLICATION
        $existing = $this->volunteerModel->findVolunteerByUserId($user_id);
        if ($existing) {
            if ($existing['status'] === 'assigned') {
                $_SESSION['volunteer_errors']['alreadyassigned'] = "You have already been assigned as a volunteer. Please check your email.";
                header("Location: index.php?page=volunteer");
                exit;
            } elseif ($existing['status'] === 'pending') {
                $_SESSION['volunteer_errors']['pending'] = "Your application is still pending. Please wait 2–3 days before resubmitting.";
                header("Location: index.php?page=volunteer");
                exit;
            }
        }

        $availability_days_str = implode(',', $availability_days);

        // Delegate to model for DB insert
        $success = $this->volunteerModel->addVolunteerRequest(
            $user_id,
            $contact_number,
            $area,
            $availability_days_str,
            $remarks,
            $address_line1,
            $address_line2,
            $province,
            $city,
            $postal_code
        );

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
