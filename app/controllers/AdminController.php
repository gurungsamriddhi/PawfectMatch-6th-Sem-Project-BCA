<?php
require_once __DIR__ . '/../../core/databaseconn.php';
require_once __DIR__ . '/../models/Admin.php';
require_once __DIR__ . '/../models/AdoptionCenter.php';
require_once __DIR__ . '/../models/Pet.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Contact.php';
require_once __DIR__ . '/../models/Volunteer.php';
require_once __DIR__ . '/../models/Adoption.php';
require_once __DIR__ . '/../../mail/sendMail.php';

class AdminController
{
    private $adminModel;
    private $petModel;
    private $userModel;
    private $contactModel;
    private $adoptionCenterModel;
    private $volunteerModel;
    private $AdoptionModel;

    public function __construct()
    {
        //create connection once
        $db = new Database();
        $conn = $db->connect();

        //inject the same connection to both models
        $this->adminModel = new Admin($conn);
        $this->petModel = new Pet($conn);
        $this->userModel = new User($conn);
        $this->contactModel = new Contact($conn);
        $this->adoptionCenterModel = new AdoptionCenter($conn);
        $this->volunteerModel = new Volunteer($conn);
        $this->AdoptionModel = new Adoption($conn);
    }

    private function loadAdminView($filename, $data = [])
    {
        extract($data);
        //to use this function again and again instead writing each time the path
        include __DIR__ . '/../views/admin/' . $filename;
    }

    public function showadminloginform()
    {
        //open admin's login form
        $this->loadAdminView('admin_login.php');
    }

    public function verify_adminLogin()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $errors = [];

        //email formal validation
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format.";
        }
        if (empty($password)) {
            $errors['password'] = "Password is required.";
        }

        // Proceed if no input errors
        if (empty($errors)) {
            $user = $this->adminModel->findByEmail($email);

            if (!$user) {
                $errors['adminlogin'] = "Invalid email or password.";
            } else if ($user['user_type'] !== 'admin') {
                $errors['adminlogin'] = "Access denied. Not an admin.";
            } else if (!password_verify($password, $user['password'])) {
                $errors['adminlogin'] = "Invalid email or password.";
            }
        }
        //redirect with errors if any
        if (!empty($errors)) {
            $_SESSION['adminlogin_errors'] = $errors;
            header('Location: index.php?page=admin/admin_login');
            exit();
        }
        $_SESSION['admin'] = [
            'id' => $user['user_id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'type' => $user['user_type']
        ];
        header('Location:index.php?page=admin/admin_dashboard');
        exit();
    }

    public function showdashboard()
    {
        $stats = $this->adminModel->getDashboardStats();
        $this->loadAdminView('admin_dashboard.php', ['stats' => $stats]);
    }

    public function showaddpetform()
    {
        $this->loadAdminView('addpet.php');
    }

    public function addPet()
    {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?page=admin/addpet");
            exit();
        }

        // Validate required fields
        $required_fields = ['petName', 'petType', 'breed', 'gender', 'age', 'dateArrival', 'size', 'weight', 'color', 'healthStatus', 'description', 'adoptionCenter', 'contactPhone', 'contactEmail', 'centerAddress'];
        $errors = [];
        $data = [];

        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                $errors[$field] = ucfirst(str_replace(['pet', 'Name', 'Type'], ['', ' Name', ' Type'], $field)) . " is required.";
            } else {
                $data[$field] = trim($_POST[$field]);
            }
        }

        // Handle characteristics
        $characteristics = $_POST['characteristics'] ?? [];
        $data['characteristics'] = !empty($characteristics) ? implode(',', $characteristics) : '';

        // Handle optional fields
        $data['healthNotes'] = $_POST['healthNotes'] ?? '';
        $data['centerWebsite'] = $_POST['centerWebsite'] ?? '';
        $data['imagePath'] = 'public/assets/images/pets.png'; // Default image path
        $data['postedBy'] = $_SESSION['admin']['id'] ?? 0;

        // Debug: Check session data
        if (!isset($_SESSION['admin']['id'])) {
            error_log("Admin session ID not set. Session data: " . print_r($_SESSION, true));
        }

        // Handle file upload
        if (isset($_FILES['photos']) && !empty($_FILES['photos']['name'][0])) {
            $uploadDir = 'public/assets/images/pets/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $uploadedFiles = [];
            foreach ($_FILES['photos']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['photos']['error'][$key] === UPLOAD_ERR_OK) {
                    $fileName = uniqid() . '_' . $_FILES['photos']['name'][$key];
                    $filePath = $uploadDir . $fileName;

                    if (move_uploaded_file($tmp_name, $filePath)) {
                        $uploadedFiles[] = $filePath;
                    }
                }
            }

            if (!empty($uploadedFiles)) {
                $data['imagePath'] = $uploadedFiles[0]; // Use first image as main image
            }
        }

        if (!empty($errors)) {
            $_SESSION['addpet_errors'] = $errors;
            $_SESSION['addpet_old'] = $data;
            header('Location: index.php?page=admin/addpet');
            exit();
        }

        // Add pet to database
        $success = $this->petModel->addPet($data);

        if ($success) {
            $_SESSION['success_message'] = 'Pet added successfully!';
            header('Location: index.php?page=admin/PetManagement');
        } else {
            $_SESSION['addpet_errors'] = ['general' => 'Failed to add pet. Please try again.'];
            $_SESSION['addpet_old'] = $data;
            header('Location: index.php?page=admin/addpet');
        }
        exit();
    }

    public function ManagePets()
    {


        // Get all pets for admin management
        $pets = $this->petModel->getAllPetsForAdmin();
        $this->loadAdminView('PetManagement.php', ['pets' => $pets]);
    }

    public function getPetById()
    {


        $petId = $_GET['id'] ?? null;
        if (!$petId) {
            http_response_code(400);
            echo json_encode(['error' => 'Pet ID is required']);
            exit();
        }

        $pet = $this->petModel->getPetById($petId);
        if (!$pet) {
            http_response_code(404);
            echo json_encode(['error' => 'Pet not found']);
            exit();
        }

        header('Content-Type: application/json');
        echo json_encode($pet);
    }

    public function updatePet()
    {


        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?page=admin/PetManagement");
            exit();
        }

        $petId = $_POST['pet_id'] ?? null;
        if (!$petId) {
            $_SESSION['error_message'] = 'Pet ID is required.';
            header('Location: index.php?page=admin/PetManagement');
            exit();
        }

        // Validate required fields
        $required_fields = ['petName', 'petType', 'breed', 'gender', 'age', 'dateArrival', 'size', 'weight', 'color', 'healthStatus', 'description', 'adoptionCenter', 'contactPhone', 'contactEmail', 'centerAddress'];
        $errors = [];
        $data = [];

        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                $errors[$field] = ucfirst(str_replace(['pet', 'Name', 'Type'], ['', ' Name', ' Type'], $field)) . " is required.";
            } else {
                $data[$field] = trim($_POST[$field]);
            }
        }

        // Handle characteristics
        $characteristics = $_POST['characteristics'] ?? [];
        $data['characteristics'] = !empty($characteristics) ? implode(',', $characteristics) : '';

        // Handle optional fields
        $data['healthNotes'] = $_POST['healthNotes'] ?? '';
        $data['centerWebsite'] = $_POST['centerWebsite'] ?? '';
        $data['imagePath'] = $_POST['current_image'] ?? 'public/assets/images/pets.png';

        // Handle file upload
        if (isset($_FILES['photos']) && !empty($_FILES['photos']['name'][0])) {
            $uploadDir = 'public/assets/images/pets/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $uploadedFiles = [];
            foreach ($_FILES['photos']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['photos']['error'][$key] === UPLOAD_ERR_OK) {
                    $fileName = uniqid() . '_' . $_FILES['photos']['name'][$key];
                    $filePath = $uploadDir . $fileName;

                    if (move_uploaded_file($tmp_name, $filePath)) {
                        $uploadedFiles[] = $filePath;
                    }
                }
            }

            if (!empty($uploadedFiles)) {
                $data['imagePath'] = $uploadedFiles[0]; // Use first image as main image
            }
        }

        if (!empty($errors)) {
            $_SESSION['editpet_errors'] = $errors;
            header('Location: index.php?page=admin/PetManagement');
            exit();
        }

        // Update pet in database
        $success = $this->petModel->updatePet($petId, $data);

        if ($success) {
            $_SESSION['success_message'] = 'Pet updated successfully!';
        } else {
            $_SESSION['error_message'] = 'Failed to update pet. Please try again.';
        }

        header('Location: index.php?page=admin/PetManagement');
        exit();
    }

    public function deletePet()
    {


        $petId = $_POST['pet_id'] ?? null;
        if (!$petId) {
            $_SESSION['error_message'] = 'Pet ID is required.';
            header('Location: index.php?page=admin/PetManagement');
            exit();
        }

        $success = $this->petModel->deletePet($petId);

        if ($success) {
            $_SESSION['success_message'] = 'Pet deleted successfully!';
        } else {
            $_SESSION['error_message'] = 'Failed to delete pet. Please try again.';
        }

        header('Location: index.php?page=admin/PetManagement');
        exit();
    }

    public function showaddcenterform()
    {

        $this->loadAdminView('add_centerform.php');
    }

    public function addAdoptionCenter()
    {


        $name = $_POST['name'] ?? ''; //if $_Post ['name'] exists then assign that value otherwise assign empty string.
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        $errors = [];
        //validate name's letters spaces ,atleast 2 characters
        if (empty($name) || !preg_match("/^[a-zA-Z\s]{2,}$/", $name)) {
            $errors['name'] = "Name must be at least 2 letters and contain only letter and spaces.";
        }

        //validate email 
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format.";
        }
        if (empty($password) || !preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password)) {
            $errors['password'] = "Password must be minimum 8 characters, include uppercase, lowercase, number and special character.";
        }
        //Check if email already exists
        $user = $this->userModel->findByEmail($email);
        if (empty($errors) && $user) { //calling the method findByEmail on the class User itself, not on an instance/object.
            $errors['email'] = 'This email is already registered.';
        }

        if ($password !== $confirmPassword) {
            $errors['confirm_password'] = "Passwords do not match.";
        }
        if (!empty($errors)) {
            $_SESSION['register_errors'] = $errors;
            $_SESSION['register_old'] = ['name' => $name, 'email' => $email];
            header('location:index.php?page=admin/add_centerform');
            exit();
        }
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $user_type = 'adoption_center';

        $created = $this->adminModel->createAdoptionCenter($name, $email, $hashedPassword, $user_type);


        if ($created) {
            $_SESSION['success_message'] = 'New Adoption Center has been registered.';
        } else {
            $_SESSION['register_errors'] = ['email' => 'Something went wrong while creating account.'];
            $_SESSION['register_old'] = ['name' => $name, 'email' => $email];
        }
        header('Location:index.php?page=admin/add_centerform');
        exit();
    }

    public function ManageCenters()
    {

        $centers = $this->adoptionCenterModel->getAllAdoptionCenterUsers();

        $this->loadAdminView('CenterManagement.php', ['centers' => $centers]);
    }

    public function ManageUsers()
    {

        $users = $this->userModel->getAllUsers();
        $this->loadAdminView('userManagement.php', ['users' => $users]);
    }

    public function user_view()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_POST['user_id'] ?? null;

            if ($user_id) {
                $user = $this->userModel->findUserById($user_id);

                if ($user) {
                    // Load the modal view and pass the $user data
                    include 'app/views/admin/adminpartials/user_view.php';
                    exit; // Important if returning modal via AJAX
                } else {
                    echo "User not found.";
                }
            } else {
                echo "Invalid user ID.";
            }
        } else {
            echo "Invalid request.";
        }
    }

    public function user_delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_POST['user_id'];

            if ($this->userModel->softDeleteUser($user_id)) {
                echo '<div class="alert alert-success">User deleted successfully</div>';
            } else {
                echo '<div class="alert alert-danger">Failed to delete user</div>';
            }
        }
    }
    // public function user_suspend()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $userId = $_POST['user_id'];
    //         $action = $_POST['action'];

    //         if ($action === 'suspend') {
    //             $status = 'suspended';
    //         } elseif ($action === 'unsuspend') {
    //             $status = 'active';
    //         } else {
    //             echo '<div class="alert alert-danger">Invalid action.</div>';
    //             return;
    //         }

    //         $result = $this->userModel->updateStatus($userId, $status);

    //         if ($result) {
    //             echo '<div class="alert alert-success">User status updated.</div>';
    //         } else {
    //             echo '<div class="alert alert-danger">Failed to update status.</div>';
    //         }
    //     }
    // }







    public function fetch_center_details()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_POST['user_id'] ?? null;

            if ($user_id) {
                $center = $this->adoptionCenterModel->getAdoptionCenterDetailsByUserId($user_id);
                if (!$center) {
                    echo "No data for this center";
                    exit;
                }
                include 'app/views/admin/adminpartials/center_details_modal.php';
            } else {
                echo "<p class='text-danger'>No details found.</p>";
            }
        }
    }

    public function fetch_edit_form()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_POST['user_id'] ?? null;
            if ($user_id) {
                $user = $this->adoptionCenterModel->getAdoptionCenterUserById($user_id);
                if ($user) {
                    include 'app/views/admin/adminpartials/edit_center_modal.php';
                    return;
                }
            }
            echo "<p class='text-danger'>No details found.</p>";
        }
    }

    public function update_center_user()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_POST['user_id'];
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $status = $_POST['status'];

            $errors = [];

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email format.";
            }

            if (empty($name) || !preg_match("/^[a-zA-Z\s]{2,}$/", $name)) {
                $errors[] = "Name must be at least 2 letters and contain only letters and spaces.";
            }

            if (!in_array($status, ['active', 'inactive'])) {
                $errors[] = "Invalid status.";
            }

            if (empty($errors)) {
                $this->adoptionCenterModel->updateCenterUser($user_id, $name, $email, $status);

                echo '<div class="alert alert-success">Update successful!</div>';
            } else {
                echo '<div class="alert alert-danger"><ul class="mb-0">';
                foreach ($errors as $error) {
                    echo '<li>' . htmlspecialchars($error) . '</li>';
                }
                echo '</ul></div>';
            }
        }
    }

    public function delete_center_user()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_POST['user_id'] ?? null;

            if ($user_id) {
                $deleted = $this->adoptionCenterModel->deleteCenterUser($user_id);
                if ($deleted) {
                    echo '<div class="alert alert-success">Center user deleted successfully.</div>';
                } else {
                    echo '<div class="alert alert-danger">Failed to delete center user.</div>';
                }
            } else {
                echo '<div class="alert alert-danger">Invalid request.</div>';
            }
        }
    }

    public function resetCenterPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
            $userId = $_POST['user_id'];
            $tempPassword = bin2hex(random_bytes(4)); // generate temp password
            $hashedPassword = password_hash($tempPassword, PASSWORD_DEFAULT);
            $updated = $this->userModel->updatePassword($userId, $hashedPassword);
            if (!$updated) {
                echo '<div class="alert alert-danger">Failed to update password.</div>';
                return;
            }

            $adoptioncenter = $this->adoptionCenterModel->getAdoptionCenterDetailsByUserId($userId);
            $mailer = new Mailer();
            $mailResult = $mailer->sendResetPasswordEmail($adoptioncenter['email'], $adoptioncenter['name'], $tempPassword);

            if ($mailResult === true) {
                echo '<div class="alert alert-success">Password reset and email sent successfully.</div>';
            } else {
                echo '<div class="alert alert-danger">Password reset but failed to send email.</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Invalid request.</div>';
        }
    }

    //show contact messages in admin dashboard
    public function showContactMessages()
    {
        $messages = $this->contactModel->getAllMessages();
        $this->loadAdminView('contact_messages.php', ['messages' => $messages]);
    }

    public function sendContactReply()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $to = trim($_POST['email']);
            $name = trim($_POST['name']);
            $reply = trim($_POST['reply']);
            $verified = $_POST['is_verified'] ?? 0;
            $messageId = $_POST['message_id'] ?? null;

            if (empty($reply) || strlen($reply) < 5) {
                echo '<div class="alert alert-danger">Reply must be at least 5 characters long.</div>';
                return;
            }

            if ($verified == 0) {
                echo '<div class="alert alert-warning">This email is not verified. Reply may not be delivered.</div>';
                return;
            }

            $subject = "Response to Your Query from Pawfect Match Admin";
            $body =  "<p>Dear <strong>$name</strong>,</p>
            <p>Thank you for reaching out to us. We’ve reviewed your message and here is our response:</p>
            <p style='margin-left:15px; color:#333;'><em>" . nl2br(htmlspecialchars($reply)) . "</em></p>
            <p>If you have any further questions, feel free to get back to us anytime.</p>
            <p>Warm regards,<br><strong>Pawfect Match Team</strong></p>";
            $mailer = new Mailer();
            $result = $mailer->sendMail($to, $subject, $body, $name);

            if ($result === true) {
                if ($messageId && $this->contactModel->markAsReplied($messageId, $reply)) {
                    echo '<div class="alert alert-success">Reply sent and saved successfully.</div>';
                } else {
                    echo '<div class="alert alert-warning">Email sent, but failed to save reply to database.</div>';
                }
            } else {
                echo '<div class="alert alert-danger">Failed to send email.</div>';
            }
        }
    }

    //Volunteer View Requests
    public function viewVolunteerRequests()
    {
        $requests = $this->volunteerModel->getAllRequests();
        $centers = $this->adoptionCenterModel->getAllCentersWithUserInfo();

        $this->loadAdminView('volunteer_management.php', ['requests' => $requests, 'centers' => $centers]);
    }




    //view all the adoption request for the pets added by the admin
    public function showAdoptionRequests()
    {

        $forms = $this->AdoptionModel->getAllForms();
        $this->loadAdminView('adoption_request.php', ['forms' => $forms]);
    }

    // public function adoptionRequestAction()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $requestId = (int) $_POST['request_id'];
    //         $action = $_POST['action']; // 'approve' or 'reject'

    //         $status = $action === 'approve' ? 'approved' : 'rejected';

    //         $this->loadModel('Adoption'); // make sure this is correct
    //         $requestDetails = $this->AdoptionModel->getAdoptionRequestById($requestId);

    //         if ($requestDetails) {
    //             // Update status in DB
    //             $this->AdoptionModel->updateAdoptionRequestStatus($requestId, $status);

    //             // Send email
    //             $subject = "Adoption Request " . ucfirst($status);
    //             $message = "Dear {$requestDetails['name']},<br>Your adoption request for <strong>{$requestDetails['pet_name']}</strong> has been <strong>$status</strong>.<br><br>Thank you!";

    //             $this->loadHelper('Mailer');
    //             $mailer = new Mailer();
    //             $mailer->sendMail($requestDetails['email'], $subject, $message);

    //             echo 'success';
    //         } else {
    //             echo 'not_found';
    //         }
    //     }
    // }
    public function volunteer_view()
    {
        $volunteer_id = $_POST['volunteer_id'] ?? null;  // use POST here

        if (!$volunteer_id || !is_numeric($volunteer_id)) {
            echo "Invalid user ID.";
            return;
        }

        $volunteer = $this->volunteerModel->findVolunteerById((int)$volunteer_id);

        if ($volunteer) {
            include 'app/views/admin/adminpartials/volunteer_view.php';
        } else {
            echo "No volunteer data found.";
        }
    }

    public function approve_and_assign_volunteer()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $volunteer_id = $_POST['volunteer_id'] ?? null;
            $center_id = $_POST['center_id'] ?? null;

            if (!$volunteer_id || !$center_id) {
                echo json_encode(['success' => false, 'message' => 'Missing required data.']);
                exit;
            }

            // Instead of calling getCenterIdByUserId, just check center exists with getAdoptionCenterDetailsByCenterId
            $centerExists = $this->adoptionCenterModel->getAdoptionCenterDetailsByCenterId($center_id);
            if (!$centerExists) {
                echo json_encode(['success' => false, 'message' => 'Invalid adoption center selected.']);
                exit;
            }

            // Step 2: Update volunteer with center_id (assigned_center_id)
            $success = $this->volunteerModel->approveAndAssignVolunteer($volunteer_id, $center_id);
            if (!$success) {
                echo json_encode(['success' => false, 'message' => 'Failed to assign volunteer.']);
                exit;
            }

            // Step 3: Get data for email
            $volunteer = $this->volunteerModel->findVolunteerById($volunteer_id);
            $center = $this->adoptionCenterModel->getAdoptionCenterDetailsByCenterId($center_id);

            if (!$volunteer || !$center) {
                echo json_encode(['success' => true, 'message' => 'Volunteer assigned, but failed to fetch email info.']);
                exit;
            }

            // Step 4: Send email
            $volunteerName = htmlspecialchars($volunteer['name'] ?? '');
            $volunteerEmail = $volunteer['email'] ?? ''; // Use raw here for sending mail
            $centerName = htmlspecialchars($center['name'] ?? '');
            $centerEmail = htmlspecialchars($center['user_email'] ?? '');
            $centerPhone = htmlspecialchars($center['phone'] ?? 'N/A');

            $subject = "Volunteer Assignment Notification - Pawfect Match";
            $body = "
    Dear {$volunteerName},<br><br>
    Congratulations! You have been assigned as a volunteer to the adoption center '<strong>{$centerName}</strong>'.<br><br>
    Please contact them for further details:<br>
    Email: {$centerEmail}<br>
    Phone: {$centerPhone}<br><br>
    Thank you for your support!<br><br>
    Regards,<br>
    Pawfect Match Team
";

            $mailer = new Mailer();
            $mailResult = $mailer->sendMail($volunteerEmail, $subject, $body, $volunteerName);
            if ($mailResult === true) {
                echo json_encode(['success' => true, 'message' => 'Volunteer approved and assigned. Notification email sent.']);
            } else {
                error_log("Mail sending error: $mailResult");
                echo json_encode(['success' => true, 'message' => 'Volunteer assigned, but email sending failed: ' . $mailResult]);
            }
        } else {
            // Not a POST request
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
        }
    }

    public function reject_volunteer_request()
{
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $volunteer_id = $_POST['volunteer_id'] ?? null;

        if (!$volunteer_id) {
            echo json_encode(['success' => false, 'message' => 'Missing volunteer ID.']);
            exit;
        }

        // Step 1: Reject the volunteer request (update status in DB)
        $success = $this->volunteerModel->rejectVolunteerRequest($volunteer_id);
        if (!$success) {
            echo json_encode(['success' => false, 'message' => 'Failed to reject volunteer request.']);
            exit;
        }

        // Step 2: Fetch volunteer details for email
        $volunteer = $this->volunteerModel->findVolunteerById($volunteer_id);
        if (!$volunteer) {
            echo json_encode(['success' => true, 'message' => 'Volunteer rejected but could not find volunteer details for email.']);
            exit;
        }

        // Step 3: Send rejection email
        $volunteerName = htmlspecialchars($volunteer['name'] ?? '');
        $volunteerEmail = $volunteer['email'] ?? '';

        $subject = "Volunteer Request Rejected - Pawfect Match";
        $body = "
            Dear {$volunteerName},<br><br>
            We regret to inform you that your volunteer request has been rejected.<br><br>
            Thank you for your interest and support.<br><br>
            Regards,<br>
            Pawfect Match Team
        ";

        $mailer = new Mailer();
        $mailResult = $mailer->sendMail($volunteerEmail, $subject, $body, $volunteerName);

        if ($mailResult === true) {
            echo json_encode(['success' => true, 'message' => 'Volunteer request rejected and notification email sent.']);
        } else {
            echo json_encode(['success' => true, 'message' => 'Volunteer request rejected but email failed: ' . $mailResult]);
        }
    } else {
        // Invalid request method
        echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    }
}

        }