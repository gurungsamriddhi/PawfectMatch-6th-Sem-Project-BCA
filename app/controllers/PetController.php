<?php
require_once __DIR__ . '/../../core/databaseconn.php';
require_once 'app/models/Pet.php';

class PetController {
    private $petModel;

    public function __construct() {
        $db= new Database();
        $conn=$db->connect();
        $this->petModel = new Pet($conn);
    }

    public function browse() {
        // Get pets from database
        $pets = $this->petModel->getAllPets();
        
        // Convert to JSON for JavaScript
        $petsJson = json_encode($pets);
        
        include 'app/views/browse.php';
    }

    public function showpetdetails(){
        include 'app/views/petdetails.php';
    }

    public function getPetDetails($id) {
        $pet = $this->petModel->getPetById($id);
        if ($pet) {
            header('Content-Type: application/json');
            echo json_encode($pet);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Pet not found']);
        }
    }

    public function searchPets() {
        $search = $_GET['search'] ?? '';
        $filters = [
            'type' => $_GET['type'] ?? '',
            'gender' => $_GET['gender'] ?? '',
            'size' => $_GET['size'] ?? '',
            'health_status' => $_GET['health_status'] ?? ''
        ];
        
        $pets = $this->petModel->searchPets($search, $filters);
        
        header('Content-Type: application/json');
        echo json_encode($pets);
    }
}
