<?php
class Pet
{
    private $conn;
    private $table = "pets";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllPets()
    {
        $query = "SELECT * FROM pets WHERE status = 'available' ORDER BY created_at DESC";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getRecentAvailablePets($limit = 3)
    {
        $query = "SELECT * FROM pets WHERE status = 'available' ORDER BY created_at DESC LIMIT ?";
        $stmt = $this->conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param("i", $limit);
            $stmt->execute();
            $result = $stmt->get_result();
            $pets = [];
            while ($row = $result->fetch_assoc()) {
                $pets[] = $row;
            }
            $stmt->close();
            return $pets;
        }
        return [];
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

    public function getAllPetsForAdmin()
    {
        $query = "SELECT p.*, u.name as posted_by_name FROM pets p 
                  LEFT JOIN users u ON p.posted_by = u.user_id 
                  ORDER BY p.created_at DESC";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
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

    public function addPet($data)
    {

        $query = "INSERT INTO pets (
            name, type, breed, gender, age, date_arrival, weight, size, color,
            health_status, characteristics, description, health_notes, adoption_center,
            contact_phone, contact_email, center_address, center_website, image_path, status, posted_by
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            return false;
        }

        // Extract and sanitize all fields
        $petName = $data['petName'] ?? '';
        $petType = $data['petType'] ?? '';
        $breed = $data['breed'] ?? '';
        $gender = $data['gender'] ?? '';
        $age = isset($data['age']) ? floatval($data['age']) : 0.0;
        $dateArrival = $data['dateArrival'] ?? '';
        $weight = isset($data['weight']) ? floatval($data['weight']) : 0.0;
        $size = $data['size'] ?? '';
        $color = $data['color'] ?? '';
        $healthStatus = $data['healthStatus'] ?? '';
        $characteristics = $data['characteristics'] ?? '';
        $description = $data['description'] ?? '';
        $healthNotes = $data['healthNotes'] ?? '';
        $adoptionCenter = $data['adoptionCenter'] ?? '';
        $contactPhone = $data['contactPhone'] ?? '';
        $contactEmail = $data['contactEmail'] ?? '';
        $centerAddress = $data['centerAddress'] ?? '';
        $centerWebsite = $data['centerWebsite'] ?? '';
        $imagePath = $data['imagePath'] ?? 'public/assets/images/pets.png';
        $status = $data['status'] ?? 'available';
        $postedBy = isset($data['postedBy']) ? intval($data['postedBy']) : 0;

        // Bind parameters: 21 total, types: ssssdsdsssssssssssssi
        $stmt->bind_param(
            "ssssdsdsssssssssssssi",
            $petName,
            $petType,
            $breed,
            $gender,
            $age,
            $dateArrival,
            $weight,
            $size,
            $color,
            $healthStatus,
            $characteristics,
            $description,
            $healthNotes,
            $adoptionCenter,
            $contactPhone,
            $contactEmail,
            $centerAddress,
            $centerWebsite,
            $imagePath,
            $status,
            $postedBy
        );

        return $stmt->execute();
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

    // // ✅ Update a pet record
    // public function updatePet($pet_id, $data)
    // {
    //     $sql = "UPDATE {$this->table} SET
    //         name = ?, type = ?, breed = ?, gender = ?, age = ?, date_arrival = ?, size = ?, weight = ?,
    //         color = ?, health_status = ?, characteristics = ?, description = ?, health_notes = ?,
    //         adoption_center = ?, contact_phone = ?, contact_email = ?, center_address = ?, center_website = ?,
    //         status = ?
    //         WHERE pet_id = ?";

    //     $stmt = $this->conn->prepare($sql);
    //     if (!$stmt) {
    //         error_log("Update Prepare failed: " . $this->conn->error);
    //         return false;
    //     }

    //     $stmt->bind_param(
    //         "ssssdssdsssssssssssi",
    //         $data['name'],
    //         $data['type'],
    //         $data['breed'],
    //         $data['gender'],
    //         $data['age'],
    //         $data['date_arrival'],
    //         $data['size'],
    //         $data['weight'],
    //         $data['color'],
    //         $data['health_status'],
    //         $data['characteristics'],
    //         $data['description'],
    //         $data['health_notes'],
    //         $data['adoption_center'],
    //         $data['contact_phone'],
    //         $data['contact_email'],
    //         $data['center_address'],
    //         $data['center_website'],
    //         $data['status'],
    //         $pet_id
    //     );

    //     $result = $stmt->execute();
    //     if (!$result) {
    //         error_log("Update Execute failed: " . $stmt->error);
    //     }

    //     $stmt->close();
    //     return $result;
    // }
    public function updatePet($id, $data)
    {

        $query = "UPDATE pets SET name=?, type=?, breed=?, gender=?, age=?, date_arrival=?, 
                                   size=?, weight=?, color=?, health_status=?, characteristics=?, 
                                   description=?, health_notes=?, adoption_center=?, contact_phone=?, 
                                   contact_email=?, center_address=?, center_website=?, image_path=?, status=? 
                  WHERE pet_id=?";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            return false;
        }

        // Ensure all required data is present with default values
        $petName = $data['petName'] ?? '';
        $petType = $data['petType'] ?? '';
        $breed = $data['breed'] ?? '';
        $gender = $data['gender'] ?? '';
        $age = $data['age'] ?? 0;
        $dateArrival = $data['dateArrival'] ?? '';
        $size = $data['size'] ?? '';
        $weight = $data['weight'] ?? 0;
        $color = $data['color'] ?? '';
        $healthStatus = $data['healthStatus'] ?? '';
        $characteristics = $data['characteristics'] ?? '';
        $description = $data['description'] ?? '';
        $healthNotes = $data['healthNotes'] ?? '';
        $adoptionCenter = $data['adoptionCenter'] ?? '';
        $contactPhone = $data['contactPhone'] ?? '';
        $contactEmail = $data['contactEmail'] ?? '';
        $centerAddress = $data['centerAddress'] ?? '';
        $centerWebsite = $data['centerWebsite'] ?? '';
        $imagePath = $data['imagePath'] ?? 'public/assets/images/pets.png';
        $status = $data['status'] ?? 'available';

        $stmt->bind_param(
            "ssssdssssssssssssssi",
            $petName,
            $petType,
            $breed,
            $gender,
            $age,
            $dateArrival,
            $size,
            $weight,
            $color,
            $healthStatus,
            $characteristics,
            $description,
            $healthNotes,
            $adoptionCenter,
            $contactPhone,
            $contactEmail,
            $centerAddress,
            $centerWebsite,
            $imagePath,
            $status,
            $id
        );

        return $stmt->execute();
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

    public function searchPets($search, $filters = [])
    {

        $query = "SELECT * FROM pets WHERE status = 'available'";
        $params = [];
        $types = "";

        // Search functionality
        if (!empty($search)) {
            $query .= " AND (name LIKE ? OR breed LIKE ? OR description LIKE ?)";
            $searchTerm = "%$search%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $types .= "sss";
        }

        // Filters
        if (!empty($filters['type'])) {
            $query .= " AND type = ?";
            $params[] = $filters['type'];
            $types .= "s";
        }

        if (!empty($filters['gender'])) {
            $query .= " AND gender = ?";
            $params[] = $filters['gender'];
            $types .= "s";
        }

        if (!empty($filters['size'])) {
            $query .= " AND size = ?";
            $params[] = $filters['size'];
            $types .= "s";
        }

        if (!empty($filters['health_status'])) {
            $query .= " AND health_status = ?";
            $params[] = $filters['health_status'];
            $types .= "s";
        }

        // Sorting
        $query .= " ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($query);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getCharacteristicsArray($characteristics)
    {
        if (empty($characteristics)) return [];
        return explode(',', $characteristics);
    }

    public function formatCharacteristics($characteristics)
    {
        if (empty($characteristics)) return '';

        $chars = $this->getCharacteristicsArray($characteristics);
        $formatted = [];

        $labels = [
            'vaccinated' => 'Vaccinated',
            'neutered' => 'Neutered/Spayed',
            'houseTrained' => 'House Trained',
            'goodWithKids' => 'Good with Kids',
            'goodWithDogs' => 'Good with Dogs',
            'goodWithCats' => 'Good with Cats',
            'specialNeeds' => 'Special Needs',
            'microchipped' => 'Microchipped'
        ];

        foreach ($chars as $char) {
            if (isset($labels[$char])) {
                $formatted[] = $labels[$char];
            }
        }

        return implode(', ', $formatted);
    }

    public function getHealthStatusColor($status)
    {
        switch ($status) {
            case 'Excellent':
                return 'success';
            case 'Good':
                return 'info';
            case 'Fair':
                return 'warning';
            case 'Poor':
                return 'danger';
            default:
                return 'secondary';
        }
    }

    public function getAvailabilityBadge($status)
    {
        switch ($status) {
            case 'available':
                return 'badge bg-success';
            case 'pending':
                return 'badge bg-warning text-dark';
            case 'adopted':
                return 'badge bg-secondary';
            default:
                return 'badge bg-info';
        }
    }

    public function getPetsByCenter($centerId)
    {

        $query = "SELECT * FROM pets WHERE posted_by = ? ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $centerId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getSavedByUser($userId) {
        $sql = "SELECT p.pet_id, p.name, p.type, p.breed, p.image_path, p.status, p.age, p.gender, p.adoption_center
                FROM wishlist w
                JOIN pets p ON w.pet_id = p.pet_id
                WHERE w.user_id = ?
                ORDER BY w.added_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $pets = [];
        while ($row = $result->fetch_assoc()) {
            $pets[] = $row;
        }
        return $pets;
    }

    public function addToWishlist($userId, $petId) {
        $sql = "INSERT INTO wishlist (user_id, pet_id) VALUES (?, ?) ON DUPLICATE KEY UPDATE added_at = CURRENT_TIMESTAMP";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ii', $userId, $petId);
        return $stmt->execute();
    }

    public function removeFromWishlist($userId, $petId) {
        $sql = "DELETE FROM wishlist WHERE user_id = ? AND pet_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ii', $userId, $petId);
        return $stmt->execute();
    }

    public function isInWishlist($userId, $petId) {
        $sql = "SELECT COUNT(*) as count FROM wishlist WHERE user_id = ? AND pet_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ii', $userId, $petId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'] > 0;
    }
}
