<?php
class Pet
{
    private $conn;
    private $table = "pets";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // ✅ Get pets posted by a specific user (used in adoption center view)
    public function getPetsByUserId($user_id)
    {
        $pets = [];
        $stmt = $this->conn->prepare("SELECT * FROM pets WHERE posted_by = ?");
        if ($stmt) {
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $pets[] = $row;
            }
            $stmt->close();
        }
        return $pets;
    }

    // ✅ NEW: Get all pets with center name for admin or public view
    public function getAllPetsWithUserNames()
    {
        $sql = "SELECT pets.*, users.name AS center_name
                FROM pets
                LEFT JOIN users ON pets.posted_by = users.id
                ORDER BY pets.created_at DESC";

        $result = $this->conn->query($sql);
        $pets = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $pets[] = $row;
            }
        }

        return $pets;
    }

    // ✅ Insert a new pet
    public function insertPet($data)
    {
        $sql = "INSERT INTO pets (
            name, type, breed, gender, age, date_arrival, size, weight, color,
            health_status, characteristics, description, health_notes,
            adoption_center, contact_phone, contact_email, center_address, center_website,
            image_path, status, posted_by
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param(
            "ssssdssdssssssssssssi",
            $data['name'],
            $data['type'],
            $data['breed'],
            $data['gender'],
            $data['age'],
            $data['date_arrival'],
            $data['size'],
            $data['weight'],
            $data['color'],
            $data['health_status'],
            $data['characteristics'],
            $data['description'],
            $data['health_notes'],
            $data['adoption_center'],
            $data['contact_phone'],
            $data['contact_email'],
            $data['center_address'],
            $data['center_website'],
            $data['image_path'],
            $data['status'],
            $data['posted_by']
        );

        $result = $stmt->execute();

        if (!$result) {
        return false;
        }

        $stmt->close();
        return $result;
    }

    // ✅ Get a single pet by ID
    public function getPetById($pet_id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE pet_id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("GetPetById Prepare failed: " . $this->conn->error);
            return null;
        }

        $stmt->bind_param("i", $pet_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $pet = $result->fetch_assoc();
        $stmt->close();

        return $pet ?: null;
    }

    // ✅ Update a pet record
    public function updatePet($pet_id, $data)
    {
        $sql = "UPDATE {$this->table} SET
            name = ?, type = ?, breed = ?, gender = ?, age = ?, date_arrival = ?, size = ?, weight = ?,
            color = ?, health_status = ?, characteristics = ?, description = ?, health_notes = ?,
            adoption_center = ?, contact_phone = ?, contact_email = ?, center_address = ?, center_website = ?,
            status = ?
            WHERE pet_id = ?";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Update Prepare failed: " . $this->conn->error);
            return false;
        }

        $stmt->bind_param(
            "ssssdssdsssssssssssi",
            $data['name'],
            $data['type'],
            $data['breed'],
            $data['gender'],
            $data['age'],
            $data['date_arrival'],
            $data['size'],
            $data['weight'],
            $data['color'],
            $data['health_status'],
            $data['characteristics'],
            $data['description'],
            $data['health_notes'],
            $data['adoption_center'],
            $data['contact_phone'],
            $data['contact_email'],
            $data['center_address'],
            $data['center_website'],
            $data['status'],
            $pet_id
        );

        $result = $stmt->execute();
        if (!$result) {
            error_log("Update Execute failed: " . $stmt->error);
        }

        $stmt->close();
        return $result;
    }

    // ✅ Delete pet
    public function deletePet($pet_id)
    {
        $sql = "DELETE FROM {$this->table} WHERE pet_id = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            error_log("Delete Prepare failed: " . $this->conn->error);
            return false;
        }

        $stmt->bind_param("i", $pet_id);
        $result = $stmt->execute();

        if (!$result) {
            error_log("Delete Execute failed: " . $stmt->error);
        }

        $stmt->close();
        return $result;
    }
}
?>
