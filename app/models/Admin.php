<?php
require_once __DIR__ . '/../../core/databaseconn.php';
require_once __DIR__ . '/../../mail/sendMail.php';

class Admin
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
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ? AND user_type = 'admin'");
        $stmt->bind_param('s', $email);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function getDashboardStats()
    {
        $conn = $this->conn;
        $stats = [];

        $result = $conn->query("SELECT COUNT(*) AS total_Users FROM users WHERE user_type='user'");
        $row = $result->fetch_assoc();
        $stats['total_Users'] = $row['total_Users'];

        //total adoption centers
        $result = $conn->query("SELECT COUNT(*) AS total_Centers FROM users WHERE user_type='adoption_center'");
        $row = $result->fetch_assoc();
        $stats['total_Centers'] = $row['total_Centers'];

        //total pets listed
        $result = $conn->query("SELECT COUNT(*) AS total_Pets FROM pets");
        $row = $result->fetch_assoc();
        $stats['total_Pets'] = $row['total_Pets'];

        $result = $conn->query("SELECT COUNT(*) AS pending_Requests FROM adoption_requests WHERE request_status='pending'");
        $row = $result->fetch_assoc();
        $stats['pending_Requests'] = $row['pending_Requests'];

        $result = $conn->query("SELECT COUNT(*) AS total_Adoptions FROM adoption_requests WHERE request_status='approved'");
        $row = $result->fetch_assoc();
        $stats['total_Adoptions'] = $row['total_Adoptions'];

        $result = $conn->query("SELECT COUNT(*) AS total_Volunteers FROM volunteers WHERE status='assigned'");
        $row = $result->fetch_assoc();
        $stats['total_Volunteers'] = $row['total_Volunteers'];

        $result = $conn->query("SELECT SUM(amount) AS total_Donations FROM donations");
        $row = $result->fetch_assoc();
        $stats['total_Donations'] = $row['total_Donations'] ?? 0;

        return $stats;
    }
}
