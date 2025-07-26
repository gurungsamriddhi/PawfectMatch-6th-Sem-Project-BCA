
<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../../core/databaseconn.php';
class UserController
{
    private $userModel;

    public function __construct()
    { 
        $db=new Database();
        $conn=$db->connect();
        $this->userModel = new User($conn); // inject once
    }

    public function Login()
    {

        $email = strtolower(trim($_POST['email'] ?? ''));
        $password = $_POST['password'] ?? '';
        $errors = [];

        //email formal validation
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format.";
        }
        if (empty($password)) {
            $errors['password'] = "Password is required.";
        }

        if (empty($errors)) {
            
            $user = $this->userModel->findByEmail($email);
            if (!$user || !password_Verify($password, $user['password'])) {
                $errors['login'] = "Invalid email or password.";
            } else if ($user['is_verified'] == 0) {
                $errors['login'] = "Please verify your email first.";
            }
            else if ($user['status'] !== 'active') {
                $errors['login'] = "Your account is not active. Please check your email or contact support.";
            }
        }

        //if there are errors store them in session and return to the index.php page
        if (!empty($errors)) {
            $_SESSION['login_errors'] = $errors;
            $_SESSION['keep_login_modal_open'] = true;
            //redirects back to the same page
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }
        $_SESSION['user'] = [
            'id' => $user['user_id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'type' => $user['user_type']
        ];
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }


    public function Register()
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
        if (empty($email) || !filter_Var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format.";
        }
        if (empty($password) || !preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password)) {
            $errors['password'] = "Password must be minimum 8 characters, include uppercase, lowercase, number and special character.";
        }
        // ✅ Check if email already exists
         $user = $this->userModel->findByEmail($email);
        if (empty($errors) && $user) { //calling the method findByEmail on the class User itself, not on an instance/object.
            $errors['email'] = 'This email is already registered.';
        }

        if ($password !== $confirmPassword) {
            $errors['confirm_password'] = "Passwords do not match.";
        }
        if (!empty($errors)) {
            $_SESSION['register_errors'] = $errors;
            $_SESSION['old'] = ['name' => $name, 'email' => $email];
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $user_type = 'user';

        $created = $this->userModel->create($name,$email,$hashedPassword,$user_type);


        if ($created) {
            $_SESSION['success_message'] = 'Registration successful! Check your email.';
            $_SESSION['keep_register_modal_open'] = true;
        } else {
            $_SESSION['register_errors'] = ['email' => 'Email already exists or registration failed.'];
            $_SESSION['old'] = ['name' => $name, 'email' => $email];
            $_SESSION['keep_register_modal_open'] = true;
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    public function dashboard() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit();
        }
        $userId = $_SESSION['user']['id'];
        $db = new Database();
        $conn = $db->connect();
        // Models
        require_once __DIR__ . '/../models/Adoption.php';
        require_once __DIR__ . '/../models/Pet.php';
        require_once __DIR__ . '/../models/Donation.php';
        require_once __DIR__ . '/../models/Volunteer.php';
        require_once __DIR__ . '/../models/Contact.php';
        $adoptionRequests = Adoption::getRequestsByUser($userId);
        $petModel = new Pet($conn);
        $savedPets = $petModel->getSavedByUser($userId);
        $donationModel = new Donation($conn);
        $donations = $donationModel->getByUser($userId);
        $donationTotal = $donationModel->getTotalByUser($userId);
        $volunteerModel = new Volunteer($conn);
        $volunteerStatus = $volunteerModel->getStatusByUser($userId);
        $contactModel = new Contact($conn);
        $messages = $contactModel->getMessagesByUser($userId);
        $user = $this->userModel->findByEmail($_SESSION['user']['email']);
        include 'app/views/user_dashboard.php';
    }
   
    public function user_profile() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit();
        }
        $user = $this->userModel->findByEmail($_SESSION['user']['email']);
        include 'app/views/user_profile.php';
    }

    public function update_profile() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit();
        }
        $user = $this->userModel->findByEmail($_SESSION['user']['email']);
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        $profile_error = '';
        $profile_success = '';
        // Require current password for any change
        if (!$current_password || !password_verify($current_password, $user['password'])) {
            $profile_error = 'Current password is incorrect.';
            include 'app/views/user_profile.php';
            return;
        }
        // Validate new password if provided
        if ($new_password || $confirm_password) {
            if ($new_password !== $confirm_password) {
                $profile_error = 'New passwords do not match.';
                include 'app/views/user_profile.php';
                return;
            }
            if ($new_password && !preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $new_password)) {
                $profile_error = 'Password must be at least 8 characters, include uppercase, lowercase, number, and special character.';
                include 'app/views/user_profile.php';
                return;
            }
        }
        // Check if email is changing and not already taken
        if ($email !== $user['email']) {
            $existing = $this->userModel->findByEmail($email);
            if ($existing && $existing['user_id'] != $user['user_id']) {
                $profile_error = 'This email is already registered.';
                include 'app/views/user_profile.php';
                return;
            }
        }
        // Update name/email
        $db = new Database();
        $conn = $db->connect();
        $stmt = $conn->prepare("UPDATE users SET name=?, email=? WHERE user_id=?");
        $stmt->bind_param('ssi', $name, $email, $user['user_id']);
        $stmt->execute();
        // Update password if provided
        if ($new_password) {
            $hashed = password_hash($new_password, PASSWORD_DEFAULT);
            $this->userModel->updatePassword($user['user_id'], $hashed);
        }
        // Update session if email or name changed
        $_SESSION['user']['name'] = $name;
        $_SESSION['user']['email'] = $email;
        $profile_success = 'Profile updated successfully!';
        $user = $this->userModel->findByEmail($email);
        include 'app/views/user_profile.php';
    }

    public function user_saved_pets() {
        if (!isset($_SESSION['user'])) { header('Location: index.php?page=login'); exit(); }
        $db = new Database(); $conn = $db->connect();
        require_once __DIR__ . '/../models/Pet.php';
        $petModel = new Pet($conn);
        $savedPets = $petModel->getSavedByUser($_SESSION['user']['id']);
        include 'app/views/user_saved_pets.php';
    }
    public function user_adoption_requests() {
        if (!isset($_SESSION['user'])) { header('Location: index.php?page=login'); exit(); }
        require_once __DIR__ . '/../models/Adoption.php';
        $adoptionRequests = Adoption::getRequestsByUser($_SESSION['user']['id']);
        include 'app/views/user_adoption_requests.php';
    }
    public function user_donations() {
        if (!isset($_SESSION['user'])) { header('Location: index.php?page=login'); exit(); }
        require_once __DIR__ . '/../models/Donation.php';
        $db = new Database(); $conn = $db->connect();
        $donationModel = new Donation($conn);
        $donations = $donationModel->getByUser($_SESSION['user']['id']);
        include 'app/views/user_donations.php';
    }
    public function user_messages() {
        if (!isset($_SESSION['user'])) { header('Location: index.php?page=login'); exit(); }
        require_once __DIR__ . '/../models/Contact.php';
        $db = new Database(); $conn = $db->connect();
        $contactModel = new Contact($conn);
        $messages = $contactModel->getMessagesByUser($_SESSION['user']['id']);
        include 'app/views/user_messages.php';
    }
    public function user_volunteer_status() {
        if (!isset($_SESSION['user'])) { header('Location: index.php?page=login'); exit(); }
        require_once __DIR__ . '/../models/Volunteer.php';
        $db = new Database(); $conn = $db->connect();
        $volunteerModel = new Volunteer($conn);
        $volunteerStatus = $volunteerModel->getStatusByUser($_SESSION['user']['id']);
        include 'app/views/user_volunteer_status.php';
    }
}
?>