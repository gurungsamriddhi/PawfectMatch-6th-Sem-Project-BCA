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

    // Find adoption center by email (existing)
    public function findByEmail($email)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ? AND user_type = 'adoption_center'");
        if (!$stmt) {
            echo "Prepare failed: (" . $this->conn->errno . ") " . $this->conn->error;
            return null;
        }
        $stmt->bind_param('s', $email);
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            return null;
        }
        $result = $stmt->get_result();
        $center = $result->fetch_assoc();
        $stmt->close();
        return $center;
    }

    // Find adoption center details by user_id (needed for your controller)
    public function findByUserId($user_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM adoption_centers WHERE user_id = ? LIMIT 1");
        if (!$stmt) {
            echo "Prepare failed: (" . $this->conn->errno . ") " . $this->conn->error;
            return null;
        }
        $stmt->bind_param("i", $user_id);
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            return null;
        }
        $result = $stmt->get_result();
        $center = $result->fetch_assoc();
        $stmt->close();
        return $center;
    }

public function updateProfile($center_id, $name, $established_date, $location, $phone, $number_of_employees, $operating_hours, $description, $logo_path = null)
    {
        if ($logo_path === null) {
            $sql = "UPDATE adoption_centers SET 
                        name = ?, 
                        established_date = ?, 
                        location = ?, 
                        phone = ?, 
                        number_of_employees = ?, 
                        operating_hours = ?, 
                        description = ?, 
                        updated_at = NOW() 
                    WHERE center_id = ?";
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                echo "Prepare failed: (" . $this->conn->errno . ") " . $this->conn->error;
                return false;
            }
            $stmt->bind_param(
                "ssssissi",
                $name,
                $established_date,
                $location,
                $phone,
                $number_of_employees,
                $operating_hours,
                $description,
                $center_id
            );
        } else {
            $sql = "UPDATE adoption_centers SET 
                        name = ?, 
                        established_date = ?, 
                        location = ?, 
                        phone = ?, 
                        number_of_employees = ?, 
                        operating_hours = ?, 
                        description = ?, 
                        logo_path = ?, 
                        updated_at = NOW() 
                    WHERE center_id = ?";
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                echo "Prepare failed: (" . $this->conn->errno . ") " . $this->conn->error;
                return false;
            }
            $stmt->bind_param(
                "ssssisssi",
                $name,
                $established_date,
                $location,
                $phone,
                $number_of_employees,
                $operating_hours,
                $description,
                $logo_path,
                $center_id
            );
        }

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            return false;
        }
        $stmt->close();

        return true;
    }
}
?>
