<?php
class Pet {
    private $conn;
    private $table = "pets";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Insert a new pet record (no adoption_center_name column)
    public function insertPet($data) {
        $sql = "INSERT INTO {$this->table} 
            (name, type, breed, age, gender, health_status, image_path, status, posted_by, description) 
            VALUES (?, ?, ?, ?, ?, ?, ?, 'available', ?, ?)";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            echo "Prepare failed: (" . $this->conn->errno . ") " . $this->conn->error;
            return false;
        }

        $posted_by = $data['posted_by'] ?? null;

        $stmt->bind_param(
            "sssisssis",
            $data['name'],
            $data['type'],
            $data['breed'],
            $data['age'],
            $data['gender'],
            $data['health_status'],
            $data['image_path'],
            $posted_by,
            $data['description']
        );

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            return false;
        }

        $stmt->close();
        return true;
    }

    // Get all pets with posted_by user info (alias fixed)
    public function getAllPets() {
    $sql = "SELECT pets.*,
                   poster.name AS posted_by_name,
                   center.name AS adoption_center_name
            FROM pets
            LEFT JOIN users AS poster ON pets.posted_by = poster.user_id
            LEFT JOIN users AS center ON pets.adoption_center_id = center.user_id";
    
    $result = $this->conn->query($sql);
    $pets = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pets[] = $row;
        }
    }
    return $pets;
}

public function updatePet($pet_id, $name, $type, $breed, $age, $gender, $health_status, $date_arrival, $status, $description)
{
    $sql = "UPDATE pets 
            SET name = ?, type = ?, breed = ?, age = ?, gender = ?, health_status = ?, date_arrival = ?, status = ?, description = ? 
            WHERE pet_id = ?";
    
    $stmt = $this->conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sssisssssi", $name, $type, $breed, $age, $gender, $health_status, $date_arrival, $status, $description, $pet_id);
        return $stmt->execute();
    }

    return false;
}

    // Delete a pet record by ID
    public function deletePet($pet_id) {
        $sql = "DELETE FROM {$this->table} WHERE pet_id = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            echo "Prepare failed: (" . $this->conn->errno . ") " . $this->conn->error;
            return false;
        }

        $stmt->bind_param("i", $pet_id);

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            return false;
        }

        $stmt->close();
        return true;
    }
}
?>
