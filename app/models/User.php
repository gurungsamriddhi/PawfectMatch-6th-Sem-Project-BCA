
<?php
require_once __DIR__ . '/../../core/databaseconn.php';
require_once __DIR__ . '/../../mail/sendMail.php';


class User
{
    protected $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }
    public function findByUserId($user_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE user_id = ?");

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error); // helpful debug
        }

        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }
    public function updateProfile($user_id, $name, $email, $phone, $address, $description, $logo_path)
    {
        $sql = "UPDATE users SET name = ?, email = ?, phone = ?, address = ?, description = ?" .
            ($logo_path ? ", logo_path = ?" : "") .
            " WHERE id = ?";

        if ($logo_path) {
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssssssi", $name, $email, $phone, $address, $description, $logo_path, $user_id);
        } else {
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sssssi", $name, $email, $phone, $address, $description, $user_id);
        }

        return $stmt->execute();
    }

    public function findByEmail($email)
    {

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();  // return user data or null
    }

    public function create($name, $email, $password, $user_type)
    {

        $verify_token = bin2hex(random_bytes(16));
        $is_verified = 0;
        $status = 'pending';

        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password,verify_token,is_verified, user_type,status) VALUES (?, ?, ?,?,?, ?,?)");
        $stmt->bind_param('ssssiss', $name, $email, $password, $verify_token, $is_verified, $user_type, $status);

        if ($stmt->execute()) {
            $mailer = new Mailer();
            $result = $mailer->sendVerificationEmail($email, $name, $verify_token);
            if ($result === true) {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }


    public function verifyUser($email, $token)
    {

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ? AND verify_token = ? AND is_verified = 0");
        $stmt->bind_param('ss', $email, $token);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        if ($user) {
            if ($user['is_verified'] == 0) {
                $update = $this->conn->prepare("UPDATE users SET is_verified = 1, status = 'active', verify_token = NULL WHERE email = ?");
                $update->bind_param('s', $email);
                $update->execute();
                return 1; // Successfully verified
            } else {
                return 2; // Already verified
            }
        }
        return 0; // Invalid token or user not found
    }

    //used to change the adoptioncenter password can be used further for user too
    public function updatePassword($userId, $hashedPassword)
    {
        $stmt = $this->conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
        $stmt->bind_param("si", $hashedPassword, $userId);
        return $stmt->execute();
    }


    public function getAllAdoptionCenterUsers()
    {
        $stmt = $this->conn->prepare("SELECT user_id, name, user_type, email, status FROM users WHERE user_type = 'adoption_center'");
        $stmt->execute();

        $result = $stmt->get_result();  // works only if mysqlnd is installed
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function getAllUsers()
    {
        $stmt = $this->conn->prepare("SELECT user_id, name, user_type, email, status,is_verified,registered_at FROM users WHERE user_type = 'user'");
        $stmt->execute();

        $result = $stmt->get_result();  // works only if mysqlnd is installed
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
