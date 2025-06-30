<?php
require_once 'core/databaseconn.php';

class Pet {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllPets() {
        $conn = $this->db->connect();
        $query = "SELECT * FROM pets WHERE status = 'available' ORDER BY created_at DESC";
        $result = $conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllPetsForAdmin() {
        $conn = $this->db->connect();
        $query = "SELECT p.*, u.name as posted_by_name FROM pets p 
                  LEFT JOIN users u ON p.posted_by = u.user_id 
                  ORDER BY p.created_at DESC";
        $result = $conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getPetById($id) {
        $conn = $this->db->connect();
        $query = "SELECT * FROM pets WHERE pet_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function addPet($data) {
        $conn = $this->db->connect();
        $query = "INSERT INTO pets (
            name, type, breed, gender, age, date_arrival, weight, size, color,
            health_status, characteristics, description, health_notes, adoption_center,
            contact_phone, contact_email, center_address, center_website, image_path, status, posted_by
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($query);
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
            $petName, $petType, $breed, $gender, $age, $dateArrival, $weight, $size, $color,
            $healthStatus, $characteristics, $description, $healthNotes, $adoptionCenter,
            $contactPhone, $contactEmail, $centerAddress, $centerWebsite, $imagePath, $status, $postedBy
        );

        return $stmt->execute();
    }

    public function updatePet($id, $data) {
        $conn = $this->db->connect();
        $query = "UPDATE pets SET name=?, type=?, breed=?, gender=?, age=?, date_arrival=?, 
                                   size=?, weight=?, color=?, health_status=?, characteristics=?, 
                                   description=?, health_notes=?, adoption_center=?, contact_phone=?, 
                                   contact_email=?, center_address=?, center_website=?, image_path=?, status=? 
                  WHERE pet_id=?";
        
        $stmt = $conn->prepare($query);
        
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
        
        $stmt->bind_param("ssssdssssssssssssssi", 
            $petName, $petType, $breed, $gender, $age, $dateArrival, $size, $weight, 
            $color, $healthStatus, $characteristics, $description, $healthNotes, 
            $adoptionCenter, $contactPhone, $contactEmail, $centerAddress, 
            $centerWebsite, $imagePath, $status, $id
        );
        
        return $stmt->execute();
    }

    public function deletePet($id) {
        $conn = $this->db->connect();
        $query = "DELETE FROM pets WHERE pet_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function searchPets($search, $filters = []) {
        $conn = $this->db->connect();
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

        $stmt = $conn->prepare($query);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getCharacteristicsArray($characteristics) {
        if (empty($characteristics)) return [];
        return explode(',', $characteristics);
    }

    public function formatCharacteristics($characteristics) {
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

    public function getHealthStatusColor($status) {
        switch ($status) {
            case 'Excellent': return 'success';
            case 'Good': return 'info';
            case 'Fair': return 'warning';
            case 'Poor': return 'danger';
            default: return 'secondary';
        }
    }

    public function getAvailabilityBadge($status) {
        switch ($status) {
            case 'available': return 'badge bg-success';
            case 'pending': return 'badge bg-warning text-dark';
            case 'adopted': return 'badge bg-secondary';
            default: return 'badge bg-info';
        }
    }

    public function getPetsByCenter($centerId) {
        $conn = $this->db->connect();
        $query = "SELECT * FROM pets WHERE posted_by = ? ORDER BY created_at DESC";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $centerId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>
