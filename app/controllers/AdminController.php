<?php


require_once __DIR__ . '/../models/Admin.php';

class AdminController
{
    private function loadAdminView($filename)
    {
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
            $user = Admin::findByEmail($email);
            if (!$user || $user['user_type']!=='admin' || !password_Verify($password, $user['password'])) {
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
        $this->loadAdminView('admin_dashboard.php');
    }

     public function showaddpetform()
    {
        if (!isset($_SESSION['admin'])) {
            header("Location: index.php?page=admin/admin_login");
           exit();
        }
        $this->loadAdminView('addpet.php');
    }

     public function ManageAdoption()
    {
        if (!isset($_SESSION['admin'])) {
            header("Location: index.php?page=admin/admin_login");
           exit();
        }
        $this->loadAdminView('adoptionManagement.php');
    }

     public function ManagePets()
    {
        if (!isset($_SESSION['admin'])) {
            header("Location: index.php?page=admin/admin_login");
           exit();
        }
        $this->loadAdminView('PetManagement.php');
    }
}
