<?php
require_once __DIR__ . '/../models/Pet.php';
require_once __DIR__ . '/../models/Center.php'; 
require_once __DIR__ . '/../../core/databaseconn.php';

class CenterController
{
    private $petModel;

    public function __construct()
    {
        $db = new Database();
        $conn = $db->connect();
        $this->petModel = new Pet($conn);
    }

    private function loadCenterView($filename)
    {
        include __DIR__ . '/../views/adoptioncenter/' . $filename;
    }

    public function showLoginForm()
    {
        $this->loadCenterView('center_login.php');
    }

    public function showDashboard()
    {
        $this->loadCenterView('center_dashboard.php');
    }

    public function showprofile()
    {
        $this->loadCenterView('adoptioncenter_profile.php');
    }

    public function showaddpetform()
    {
        $this->loadCenterView('add_pets.php');
    }

    public function managepetsform()
    {
        $pets = $this->petModel->getAllPets();
        include __DIR__ . '/../views/adoptioncenter/managepets.php';
    }
 public function savePets()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: index.php?page=adoptioncenter/add_pets');
        exit;
    }

    // Debug info
    echo "<pre>DEBUG - POST Data:\n";
    print_r($_POST);
    echo "\nDEBUG - FILES Data:\n";
    print_r($_FILES);

    // Collect form data
    $name = trim($_POST['petName'] ?? '');
    $type = strtolower(trim($_POST['petType'] ?? ''));
    $breed = trim($_POST['breed'] ?? '');
    $age = floatval($_POST['age'] ?? 0);
    $gender = strtolower(trim($_POST['gender'] ?? ''));
    $dateArrival = $_POST['dateArrival'] ?? null;
    $size = trim($_POST['size'] ?? '');
    $weight = floatval($_POST['weight'] ?? 0);
    $color = trim($_POST['color'] ?? '');
    $healthStatus = trim($_POST['healthStatus'] ?? '');
    $description = trim($_POST['description'] ?? '');
    
    // Optional: Use session or fallback to NULL
    $posted_by = $_SESSION['user_id'] ?? null;
    echo "\nDEBUG - Posted By User ID: ";
    var_dump($posted_by);

    // Validation
    $errors = [];
    if (empty($name)) $errors[] = "Pet name is required.";
    if (!in_array($type, ['dog','cat','bird','rabbit','hamster','fish','other'])) $errors[] = "Invalid pet type.";
    if (!in_array($gender, ['male', 'female'])) $errors[] = "Invalid gender.";
    if ($age < 0) $errors[] = "Invalid age.";
    if (empty($size)) $errors[] = "Size is required.";
    if ($weight <= 0) $errors[] = "Weight must be positive.";
    if (empty($color)) $errors[] = "Color is required.";
    if (empty($healthStatus)) $errors[] = "Health status is required.";
    if (empty($description)) $errors[] = "Description is required.";

    if (!empty($errors)) {
        echo "\nValidation Errors:\n";
        print_r($errors);
        $_SESSION['errors'] = $errors;
        header('Location: index.php?page=adoptioncenter/add_pets');
        exit;
    }

    // Handle image upload
    $imagePath = null;
    if (isset($_FILES['photos']) && $_FILES['photos']['error'][0] == 0) {
        $uploadDir = 'uploads/pets/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        $tmpName = $_FILES['photos']['tmp_name'][0];
        $ext = pathinfo($_FILES['photos']['name'][0], PATHINFO_EXTENSION);
        $newFileName = uniqid() . '.' . $ext;
        $destination = $uploadDir . $newFileName;

        if (move_uploaded_file($tmpName, $destination)) {
            $imagePath = $destination;
        }
    }

    // Prepare final pet data
    $petData = [
        'name' => $name,
        'type' => $type,
        'breed' => $breed,
        'age' => $age,
        'gender' => $gender,
        'health_status' => $healthStatus,
        'image_path' => $imagePath,
        'posted_by' => $posted_by, // may be NULL
        'description' => $description,
    ];

    echo "\nPrepared Pet Data:\n";
    print_r($petData);

    // Save pet
    if ($this->petModel->insertPet($petData)) {
        $_SESSION['success'] = "Pet added successfully.";
        header('Location: index.php?page=adoptioncenter/managepets');
        exit;
    } else {
        $_SESSION['errors'] = ["❌ Failed to save pet."];
        header('Location: index.php?page=adoptioncenter/add_pets');
        exit;
    }
}




    public function deletepet()
    {
        $pet_id = $_GET['pet_id'] ?? null;

        if ($pet_id && $this->petModel->deletePet($pet_id)) {
            $_SESSION['success'] = "Pet deleted successfully.";
        } else {
            $_SESSION['error'] = "Failed to delete pet.";
        }

        header("Location: index.php?page=adoptioncenter/managepets");
        exit;
    }

    public function adoption_request()
    {
        $this->loadCenterView('adoption_request.php');
    }

    public function approveRequest()
    {
        $db = new Database();
        $conn = $db->connect();
        $requestModel = new Request($conn);

        $id = $_GET['id'] ?? null;
        if ($id && $requestModel->updateStatus($id, 'Approved')) {
            $_SESSION['success'] = "Request approved.";
        } else {
            $_SESSION['error'] = "Approval failed.";
        }
        header("Location: index.php?page=adoptioncenter/adoption_request");
        exit;
    }

    public function rejectRequest()
    {
        $db = new Database();
        $conn = $db->connect();
        $requestModel = new Request($conn);

        $id = $_GET['id'] ?? null;
        if ($id && $requestModel->updateStatus($id, 'Rejected')) {
            $_SESSION['success'] = "Request rejected.";
        } else {
            $_SESSION['error'] = "Rejection failed.";
        }
        header("Location: index.php?page=adoptioncenter/adoption_request");
        exit;
    }

    public function feedback()
    {
        $this->loadCenterView('feedback.php');
    }
}
