
<?php
class UserController {
    public function Login() {
        include 'app/views/login.php';
    }
    public function showRegisterForm() {
        include 'app/views/register.php'; // load the form
    }
}
?>