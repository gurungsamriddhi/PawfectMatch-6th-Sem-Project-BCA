<?php
session_start();

require_once 'core/databaseconn.php';
require_once 'app/models/User.php';

if (isset($_GET['email']) && ($_GET['token'])) {
    $email = $_GET['email'];
    $token = $_GET['token'];
    
    $db=new Database();
    $conn= $db->connect();

    $userModel = new User($conn); // ✅ Object instantiation
    $verificationResult = $userModel->verifyUser($email, $token); // ✅ OOP method call

    if ($verificationResult === 1) {
        $_SESSION['verification_success'] = "Your Email has been verified! Please Log in.";
    } elseif ($verificationResult === 2) {
        $_SESSION['verification_success'] = "Your Email is already verified. Please log in.";
    } else {
        $_SESSION['verification_error'] = "Invalid or expired verification link.";
    }

    header("Location: index.php");
    exit();
}
