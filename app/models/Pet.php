<?php


class Pet {
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllPets()
    {
        $result = $this->conn->query("SELECT * FROM pets");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getPetById($pet_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM pets WHERE pet_id = ?");
        $stmt->bind_param("i", $pet_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function addPet($name, $type, $breed, $age, $gender, $status, $description, $imagePath)
    {
        $stmt = $this->conn->prepare("INSERT INTO pets (name, type, breed, age, gender, status, description, image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $name, $type, $breed, $age, $gender, $status, $description, $imagePath);
        return $stmt->execute();
    }

    public function updatePet($pet_id, $name, $type, $breed, $age, $gender, $status, $description, $imagePath)
    {
        $stmt = $this->conn->prepare("UPDATE pets SET name=?, type=?, breed=?, age=?, gender=?, status=?, description=?, image_path=? WHERE pet_id=?");
        $stmt->bind_param("ssssssssi", $name, $type, $breed, $age, $gender, $status, $description, $imagePath, $pet_id);
        return $stmt->execute();
    }

    public function deletePetById($pet_id)
    {
        $stmt = $this->conn->prepare("DELETE FROM pets WHERE pet_id = ?");
        $stmt->bind_param("i", $pet_id);
        return $stmt->execute();
    }
}
