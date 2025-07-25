<?php
class Volunteer
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function addVolunteerRequest(
        $user_id,
        $contact_number,
        $area,
        $availability_days_str,
        $remarks,
        $address_line1,
        $address_line2,
        $province,
        $city,
        $postal_code
    ) {
        // Assign to variables to ensure pass-by-reference
        $remarks_val = ($remarks !== '') ? $remarks : null;
        $address_line2_val = ($address_line2 !== '') ? $address_line2 : null;

        $stmt = $this->conn->prepare("
        INSERT INTO volunteers 
        (user_id, contact_number, area, availability_days, remarks,
         address_line1, address_line2, province, city, postal_code, status, applied_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW())
    ");

        if (!$stmt) {
            return false;
        }

        // Bind values safely
        $stmt->bind_param(
            "isssssssss",  // i = int, s = string
            $user_id,
            $contact_number,
            $area,
            $availability_days_str,
            $remarks_val,
            $address_line1,
            $address_line2_val,
            $province,
            $city,
            $postal_code
        );

        // Execute and return inserted ID or false
        if ($stmt->execute()) {
            return $this->conn->insert_id;
        } else {
            return false;
        }
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
