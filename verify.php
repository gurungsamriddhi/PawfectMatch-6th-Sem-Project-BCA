<?php
session_start();
require_once 'core/databaseconn.php';
if (isset($_GET['email']) && ($_GET['token'])) {
    $email = $_GET['email'];
    $token = $_GET['token'];

    $db = new Database();
    $conn = $db->connect();

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND verify_token = ?");
    $stmt->bind_param('ss', $email, $token);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && $user['is_verified'] == 0) {
        $update = $conn->prepare("UPDATE users SET is_verified = 1 WHERE email = ?");
        $update->bind_param('s', $email);
        $update->execute();

        $_SESSION['verification_success'] = "Your Email has been verified! Please Log in.";
    }
     
    elseif ($user) {
       
        $_SESSION['verification_success'] = "Your Email is already verified! Please Log in.";
    } 
    
    else {
       
        $_SESSION['verification_error'] = "Missing verification data.";
    }
    header("Location: index.php");
    exit();

}
