
<?php
require_once __DIR__ . '/../../core/databaseconn.php';
require_once __DIR__ . '/../../mail/sendMail.php';

class User
{
    public static function findByEmail($email)
    {
        $db = new Database();
        $conn = $db->connect(); //php syntax to call the function using object of a class

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();  // return user data or null
    }

    public static function create($name, $email, $password, $user_type)
    {
        $db = new Database();
        $conn = $db->connect();

        $verify_token = bin2hex(random_bytes(16));
        $is_verified = 0;
        $status = 'pending';

        $stmt = $conn->prepare("INSERT INTO users (name, email, password,verify_token,is_verified, user_type,status) VALUES (?, ?, ?,?,?, ?,?)");
        $stmt->bind_param('ssssiss', $name, $email, $password, $verify_token, $is_verified, $user_type, $status);

        if ($stmt->execute()) {
            sendVerificationEmail($email, $name, $verify_token);
            return true;
        }

        return false;
    }

    public static function verifyUser($email, $token)
    {
        $db = new Database();
        $conn = $db->connect();
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND verify_token = ? AND is_verified = 0");
        $stmt->bind_param('ss', $email, $token);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        if ($user) {
            if ($user['is_verified'] == 0) {
                $update = $conn->prepare("UPDATE users SET is_verified = 1, status = 'active', verify_token = NULL WHERE email = ?");
                $update->bind_param('s', $email);
                $update->execute();
                return 1; // Successfully verified
            } else {
                return 2; // Already verified
            }
        }
        return 0; // Invalid token or user not found
    }
}
