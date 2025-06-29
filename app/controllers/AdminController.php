<?php


require_once __DIR__ . '/../models/Admin.php';

class AdminController
{
    private $adminModel;

    public function __construct()
    {
        $this->adminModel = new Admin(); // inject once
    }

    private function loadAdminView($filename, $data = [])
    {
        extract($data);
        include __DIR__ . '/../views/admin/' . $filename; //to use this function again and again instead writing each time the path
    }

    public function showadminloginform()
    {
        $this->loadAdminView('admin_login.php'); //open admin's login form
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

        if (empty($errors)) {
            $user = $this->adminModel->findByEmail($email);
            if (!$user || $user['user_type'] !== 'admin' || !password_verify($password, $user['password'])) {
                $errors['adminlogin'] = "Invalid email or password.";
            }
        }

        //if there are errors store them in session and return to the index.php page
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
        if (!isset($_SESSION['admin'])) {
            header("Location: index.php?page=admin/admin_login");
            exit();
        }
        $stats = $this->adminModel->getDashboardStats();
        $this->loadAdminView('admin_dashboard.php', ['stats' => $stats]);
    }

    public function showaddpetform()
    {
        if (!isset($_SESSION['admin'])) {
            header("Location: index.php?page=admin/admin_login");
            exit();
        }
        $this->loadAdminView('addpet.php');
    }


    public function ManagePets()
    {
        if (!isset($_SESSION['admin'])) {
            header("Location: index.php?page=admin/admin_login");
            exit();
        }
        $this->loadAdminView('PetManagement.php');
    }
    public function ManageUsers()
    {
        if (!isset($_SESSION['admin'])) {
            header("Location: index.php?page=admin/admin_login");
            exit();
        }
        $this->loadAdminView('UserManagement.php');
    }

    public function showaddcenterform()
    {
        if (!isset($_SESSION['admin'])) {
            header("Location: index.php?page=admin/admin_login");
            exit();
        }
        $this->loadAdminView('add_centerform.php');
    }

    public function addAdoptionCenter()
    {
        if (!isset($_SESSION['admin'])) {
            header("Location: index.php?page=admin/admin_login");
            exit();
        }

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
        $user = $this->adminModel->findByEmail($email);
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
        if (!isset($_SESSION['admin'])) {
            header("Location: index.php?page=admin/admin_login");
            exit();
        }
        $centers = $this->adminModel->getAllAdoptionCenterUsers();

        $this->loadAdminView('CenterManagement.php', ['centers' => $centers]);
    }


    public function fetch_center_details()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_POST['user_id'] ?? null;

            if ($user_id) {
                $center = $this->adminModel->getAdoptionCenterDetailsByUserId($user_id);
                if (!$center) {
                    echo "No data for this center";
                    exit;
                }
                include 'app/views/partials/center_details_modal.php';
            } else {
                echo "<p class='text-danger'>No details found.</p>";
            }
        }
    }
}
