<?php
class Volunteer
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn; 
    }

    public function addVolunteerRequest($user_id, $contact_number, $area, $availability_days_str, $remarks)
    {
        $sql = "INSERT INTO volunteers (user_id, contact_number, area, availability_days, remarks) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$user_id, $contact_number, $area, $availability_days_str, $remarks]);
    }

    public function getStatusByUser($userId) {
        $sql = "SELECT status FROM volunteers WHERE user_id = ? ORDER BY applied_at DESC LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row ? $row['status'] : 'Not Applied';
    }
}
