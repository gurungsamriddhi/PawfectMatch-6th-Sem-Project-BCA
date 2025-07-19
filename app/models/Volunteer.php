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
}
