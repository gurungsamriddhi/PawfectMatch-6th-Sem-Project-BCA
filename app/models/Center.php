<?php
require_once __DIR__ . '/../../core/databaseconn.php';
require_once __DIR__ . '/../../mail/sendMail.php';

class Center
{
    protected $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }
    //static function used to be able to call the function without using object used for select,fetching all data sql queries
    public function findByEmail($email)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ? AND user_type = 'adoption_center'");
        $stmt->bind_param('s', $email);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function updateProfile($center_id, $name, $email, $phone, $address, $description, $logo_path){
        
    }
}