<?php
require_once __DIR__ . '/../../core/databaseconn.php';
require_once __DIR__ . '/../../mail/sendMail.php';

class Admin
{
   public static function findByEmail($email)
{
    $db = new Database();
    $conn = $db->connect();

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND user_type = 'admin'");
    $stmt->bind_param('s', $email);
    $stmt->execute();

    return $stmt->get_result()->fetch_assoc();
}

}