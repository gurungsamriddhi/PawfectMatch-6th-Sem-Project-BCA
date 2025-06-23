
<?php
require_once __DIR__ . '/../models/User.php';
class UserController
{
    public function Login()
    {
        session_start();

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $errors = [];

        //email formal validation
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format.";
        }
        if(empty($password)){
            $errors['password']= "Password is required.";
        }
        
        if(empty($errors)){
            $user=user::findByEmail($email);
            if(!$user || !password_Verify($password,$user['password'])){
                $errors['login']="Invalid email or password.";
            }
        }

        //if there are errors store them in session and return to the index.php page
        if(!empty($errors)){
            $_SESSION['login_errors']=$errors;
            $_SESSION['old_login']=['email'=>$email];
            $_SESSION['keep_login_modal_open']=true;
            header('Location: index.php');
            exit();
        }
        $_SESSION['user']=[
                  'id'=>$user['user_id'],
                  'name'=>$user['name'],
                  'email'=>$user['email'],
                  'type'=>$user['user_type']
        ];
        header('Location:index.php');
        exit();
    }


    public function Register()
    {
        session_start();

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
        if (empty($errors) && User::findByEmail($email)) { //calling the method findByEmail on the class User itself, not on an instance/object.
            $errors['email'] = 'This email is already registered.';
        }

        if ($password !== $confirmPassword) {
            $errors['confirm_password'] = "Passwords do not match.";
        }
        if (!empty($errors)) {
            $_SESSION['register_errors'] = $errors;
            $_SESSION['old'] = ['name' => $name, 'email' => $email];
            header('location:index.php');
            exit();
        }
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $user_type = 'user';

        $created = User::create($name, $email, $hashedPassword, $user_type);


        if ($created) {
            $_SESSION['success_message'] = 'Registration successful! Please Log in.';
            $_SESSION['keep_register_modal_open'] = true;
        } else {
            $_SESSION['register_errors'] = ['email' => 'Email already exists or registration failed.'];
            $_SESSION['old'] = ['name' => $name, 'email' => $email];
            $_SESSION['keep_register_modal_open'] = true;
        }
        header('Location:index.php');
        exit();
    }
}
?>