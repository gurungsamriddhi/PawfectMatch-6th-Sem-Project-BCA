<?php
require_once __DIR__ . '/../models/Pet.php';

class CenterController
{
    private $petModel;

    public function __construct()
    {
        $this->petModel = new Pet();
    }

    private function loadCenterView($filename, $data = [])
    {
        extract($data);
        include __DIR__ . '/../views/adoptioncenter/' . $filename;
    }

    public function showLoginForm()
    {
        // If already logged in, redirect to dashboard
        // if (isset($_SESSION['adoptioncenter'])) {
        //     header("Location: index.php?page=adoptioncenter/center_dashboard");
        //     exit();
        // }

        // Otherwise, show login form
        $this->loadCenterView('center_login.php');
    }

    public function showDashboard()
    {
        // // Check if logged in
        // if (!isset($_SESSION['adoptioncenter'])) {
        //     header("Location: index.php?page=adoptioncenter/center_login");
        //     exit();
        // }

        // Optional: remove the debug message
        // echo "Dashboard loaded"; exit;

        $this->loadCenterView('center_dashboard.php');
    }

    public function showprofile(){
        $this->loadCenterView('adoptioncenter_profile.php');
    }

    public function showaddpetform(){
        $this->loadCenterView('add_pets.php');
    }

    public function addPet()
    {
        if (!isset($_SESSION['adoptioncenter'])) {
            header("Location: index.php?page=adoptioncenter/center_login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?page=adoptioncenter/add_pets");
            exit();
        }

        // Validate required fields
        $required_fields = ['petName', 'petType', 'breed', 'gender', 'age', 'dateArrival', 'size', 'weight', 'color', 'healthStatus', 'description', 'adoptionCenter', 'contactPhone', 'contactEmail', 'centerAddress'];
        $errors = [];
        $data = [];

        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                $errors[$field] = ucfirst(str_replace(['pet', 'Name', 'Type'], ['', ' Name', ' Type'], $field)) . " is required.";
            } else {
                $data[$field] = trim($_POST[$field]);
            }
        }

        // Handle characteristics
        $characteristics = $_POST['characteristics'] ?? [];
        $data['characteristics'] = !empty($characteristics) ? implode(',', $characteristics) : '';

        // Handle optional fields
        $data['healthNotes'] = $_POST['healthNotes'] ?? '';
        $data['centerWebsite'] = $_POST['centerWebsite'] ?? '';
        $data['imagePath'] = 'public/assets/images/pets.png'; // Default image path
        $data['postedBy'] = $_SESSION['adoptioncenter']['id'];

        // Handle file upload
        if (isset($_FILES['photos']) && !empty($_FILES['photos']['name'][0])) {
            $uploadDir = 'public/assets/images/pets/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $uploadedFiles = [];
            foreach ($_FILES['photos']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['photos']['error'][$key] === UPLOAD_ERR_OK) {
                    $fileName = uniqid() . '_' . $_FILES['photos']['name'][$key];
                    $filePath = $uploadDir . $fileName;
                    
                    if (move_uploaded_file($tmp_name, $filePath)) {
                        $uploadedFiles[] = $filePath;
                    }
                }
            }
            
            if (!empty($uploadedFiles)) {
                $data['imagePath'] = $uploadedFiles[0]; // Use first image as main image
            }
        }

        if (!empty($errors)) {
            $_SESSION['addpet_errors'] = $errors;
            $_SESSION['addpet_old'] = $data;
            header('Location: index.php?page=adoptioncenter/add_pets');
            exit();
        }

        // Add pet to database
        $success = $this->petModel->addPet($data);

        if ($success) {
            $_SESSION['success_message'] = 'Pet added successfully!';
            header('Location: index.php?page=adoptioncenter/managepets');
        } else {
            $_SESSION['addpet_errors'] = ['general' => 'Failed to add pet. Please try again.'];
            $_SESSION['addpet_old'] = $data;
            header('Location: index.php?page=adoptioncenter/add_pets');
        }
        exit();
    }

    public function managepetsform(){
        if (!isset($_SESSION['adoptioncenter'])) {
            header("Location: index.php?page=adoptioncenter/center_login");
            exit();
        }
        
        // Get pets for this specific adoption center
        $centerId = $_SESSION['adoptioncenter']['id'];
        $pets = $this->petModel->getPetsByCenter($centerId);
        $this->loadCenterView('managepets.php', ['pets' => $pets]);
    }

    public function getPetById()
    {
        if (!isset($_SESSION['adoptioncenter'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit();
        }

        $petId = $_GET['id'] ?? null;
        if (!$petId) {
            http_response_code(400);
            echo json_encode(['error' => 'Pet ID is required']);
            exit();
        }

        $pet = $this->petModel->getPetById($petId);
        if (!$pet) {
            http_response_code(404);
            echo json_encode(['error' => 'Pet not found']);
            exit();
        }

        // Check if the pet belongs to this center
        if ($pet['posted_by'] != $_SESSION['adoptioncenter']['id']) {
            http_response_code(403);
            echo json_encode(['error' => 'Access denied']);
            exit();
        }

        header('Content-Type: application/json');
        echo json_encode($pet);
    }

    public function updatePet()
    {
        if (!isset($_SESSION['adoptioncenter'])) {
            header("Location: index.php?page=adoptioncenter/center_login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?page=adoptioncenter/managepets");
            exit();
        }

        $petId = $_POST['pet_id'] ?? null;
        if (!$petId) {
            $_SESSION['error_message'] = 'Pet ID is required.';
            header('Location: index.php?page=adoptioncenter/managepets');
            exit();
        }

        // Check if pet belongs to this center
        $pet = $this->petModel->getPetById($petId);
        if (!$pet || $pet['posted_by'] != $_SESSION['adoptioncenter']['id']) {
            $_SESSION['error_message'] = 'Access denied.';
            header('Location: index.php?page=adoptioncenter/managepets');
            exit();
        }

        // Validate required fields
        $required_fields = ['petName', 'petType', 'breed', 'gender', 'age', 'dateArrival', 'size', 'weight', 'color', 'healthStatus', 'description', 'adoptionCenter', 'contactPhone', 'contactEmail', 'centerAddress'];
        $errors = [];
        $data = [];

        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                $errors[$field] = ucfirst(str_replace(['pet', 'Name', 'Type'], ['', ' Name', ' Type'], $field)) . " is required.";
            } else {
                $data[$field] = trim($_POST[$field]);
            }
        }

        // Handle characteristics
        $characteristics = $_POST['characteristics'] ?? [];
        $data['characteristics'] = !empty($characteristics) ? implode(',', $characteristics) : '';

        // Handle optional fields
        $data['healthNotes'] = $_POST['healthNotes'] ?? '';
        $data['centerWebsite'] = $_POST['centerWebsite'] ?? '';
        $data['imagePath'] = $_POST['current_image'] ?? 'public/assets/images/pets.png';

        // Handle file upload
        if (isset($_FILES['photos']) && !empty($_FILES['photos']['name'][0])) {
            $uploadDir = 'public/assets/images/pets/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $uploadedFiles = [];
            foreach ($_FILES['photos']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['photos']['error'][$key] === UPLOAD_ERR_OK) {
                    $fileName = uniqid() . '_' . $_FILES['photos']['name'][$key];
                    $filePath = $uploadDir . $fileName;
                    
                    if (move_uploaded_file($tmp_name, $filePath)) {
                        $uploadedFiles[] = $filePath;
                    }
                }
            }
            
            if (!empty($uploadedFiles)) {
                $data['imagePath'] = $uploadedFiles[0]; // Use first image as main image
            }
        }

        if (!empty($errors)) {
            $_SESSION['editpet_errors'] = $errors;
            header('Location: index.php?page=adoptioncenter/managepets');
            exit();
        }

        // Update pet in database
        $success = $this->petModel->updatePet($petId, $data);

        if ($success) {
            $_SESSION['success_message'] = 'Pet updated successfully!';
        } else {
            $_SESSION['error_message'] = 'Failed to update pet. Please try again.';
        }
        
        header('Location: index.php?page=adoptioncenter/managepets');
        exit();
    }

    public function deletePet()
    {
        if (!isset($_SESSION['adoptioncenter'])) {
            header("Location: index.php?page=adoptioncenter/center_login");
            exit();
        }

        $petId = $_POST['pet_id'] ?? null;
        if (!$petId) {
            $_SESSION['error_message'] = 'Pet ID is required.';
            header('Location: index.php?page=adoptioncenter/managepets');
            exit();
        }

        // Check if pet belongs to this center
        $pet = $this->petModel->getPetById($petId);
        if (!$pet || $pet['posted_by'] != $_SESSION['adoptioncenter']['id']) {
            $_SESSION['error_message'] = 'Access denied.';
            header('Location: index.php?page=adoptioncenter/managepets');
            exit();
        }

        $success = $this->petModel->deletePet($petId);

        if ($success) {
            $_SESSION['success_message'] = 'Pet deleted successfully!';
        } else {
            $_SESSION['error_message'] = 'Failed to delete pet. Please try again.';
        }
        
        header('Location: index.php?page=adoptioncenter/managepets');
        exit();
    }
}
