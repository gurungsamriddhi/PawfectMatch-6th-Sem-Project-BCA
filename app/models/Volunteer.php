<?php
class Volunteer
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }
     public function findVolunteerById($volunteer_id)
    {
        $query = "
        SELECT 
            u.user_id, u.name, u.email,
            v.volunteer_id, v.area, v.availability_days, v.status AS volunteer_status,
            v.contact_number, v.remarks,
            v.address_line1, v.address_line2, v.city, v.province, v.postal_code,
            v.assigned_center_id, v.applied_at,
            ac.name AS assigned_center_name
        FROM users u
        LEFT JOIN volunteers v ON u.user_id = v.user_id
        LEFT JOIN adoption_centers ac ON v.assigned_center_id = ac.center_id
        WHERE v.volunteer_id = ?
    ";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("i", $volunteer_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            return $result->fetch_assoc(); // All data in one associative array
        } else {
            return false;
        }
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

    public function assignVolunteerToCenter($volunteer_id, $center_id)
    {
        $stmt = $this->conn->prepare("UPDATE volunteers SET status = 'assigned', assigned_center_id = ? WHERE volunteer_id = ?");
        $stmt->bind_param("ii", $center_id, $volunteer_id);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }
}
