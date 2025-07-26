<?php
require_once __DIR__ . '/../../core/databaseconn.php';
class Donation {
    private $conn;
    public function __construct($conn) {
        $this->conn = $conn;
    }
    public function getByUser($userId) {
        $sql = "SELECT amount, message, donated_at as date FROM donations WHERE user_id = ? ORDER BY donated_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $donations = [];
        while ($row = $result->fetch_assoc()) {
            $donations[] = [
                'amount' => $row['amount'],
                'purpose' => $row['message'],
                'date' => $row['date']
            ];
        }
        return $donations;
    }
    public function getTotalByUser($userId) {
        $sql = "SELECT SUM(amount) as total FROM donations WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row ? $row['total'] : 0;
    }
} 
