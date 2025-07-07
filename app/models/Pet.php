<?php
class Pet {
    private $conn;
    private $table = "pets";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Insert a new pet record
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

    // Get all pets with optional adoption center info
    public function getAllPets() {
        $sql = "SELECT pets.*, ac.name AS adoption_center_name
                FROM {$this->table} pets
                LEFT JOIN adoption_centers ac ON pets.posted_by = ac.user_id
                ORDER BY pets.pet_id DESC";

        $result = $this->conn->query($sql);
        if (!$result) {
            echo "Query failed: (" . $this->conn->errno . ") " . $this->conn->error;
            return [];
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // ✅ Delete a pet record by ID
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
