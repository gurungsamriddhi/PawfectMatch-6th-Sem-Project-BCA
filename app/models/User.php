
<?php
require_once __DIR__ . '/../../core/databaseconn.php';
require_once __DIR__ . '/../../mail/sendMail.php';

class User
{
    public static function findByEmail($email)
    {
        $db = new Database();
        $conn = $db->connect();//php syntax to call the function using object of a class

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();  // return user data or null
    }

    public static function create($name, $email, $password, $user_type)
    {   $db= new Database();
        $conn = $db->connect();

        $verify_token =bin2hex(random_bytes(16));
        $is_verified=0;

        $stmt = $conn->prepare("INSERT INTO users (name, email, password,verify_token,is_verified, user_type) VALUES (?, ?, ?,?,?, ?)");
        $stmt->bind_param('ssssis', $name, $email, $password, $verify_token, $is_verified, $user_type);

        if($stmt->execute()){
            sendVerificationEmail($email,$name,$verify_token);
            return true;
        }

              return false;
    }
}
