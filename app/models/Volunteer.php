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
    
    public function getAllRequests()
    {
        $stmt = $this->conn->prepare("
        SELECT v.*, u.name, u.email 
        FROM volunteers v 
        JOIN users u ON v.user_id = u.user_id 
        ORDER BY v.applied_at DESC
    ");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
