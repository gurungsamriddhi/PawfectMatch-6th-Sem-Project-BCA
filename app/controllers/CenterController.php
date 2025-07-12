<?php
require_once __DIR__ . '/../models/Pet.php';
require_once __DIR__ . '/../models/Center.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../../core/databaseconn.php';

class CenterController
{
    private $conn;
    private $petModel;
    private $centerModel;
    private $userModel;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
        $this->petModel = new Pet($this->conn); 
        $this->centerModel = new Center(); 
        $this->userModel = new User();
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
        if (!isset($_SESSION['center_id'])) {
            header("Location: index.php?page=adoptioncenter/center_login");
            exit;
        }

        $center_id = $_SESSION['center_id'];
        $conn = $this->conn;

        $stats = [
            'total_Pets' => 0,
            'total_Adoptions' => 0,
            'total_Donations' => 0,
            'total_Volunteers' => 0,
            'pending_Requests' => 0,
        ];

        // Total pets listed
        $stmt = $conn->prepare("SELECT COUNT(*) FROM pets WHERE posted_by = ?");
        $stmt->bind_param('i', $center_id);
        $stmt->execute();
        $stmt->bind_result($totalPets);
        $stmt->fetch();
        $stats['total_Pets'] = $totalPets;
        $stmt->close();

        // Total adoptions completed (based on pet status = 'adopted', case-insensitive)
        $stmt = $conn->prepare("SELECT COUNT(*) FROM pets WHERE posted_by = ? AND LOWER(status) = 'adopted'");
        $stmt->bind_param('i', $center_id);
        $stmt->execute();
        $stmt->bind_result($totalAdoptions);
        $stmt->fetch();
        $stats['total_Adoptions'] = $totalAdoptions;
        $stmt->close();

        include __DIR__ . '/../views/adoptioncenter/center_dashboard.php';
    }

    public function showprofile()
    {
        if (!isset($_SESSION['center_id'])) {
            header("Location: index.php?page=adoptioncenter/center_login");
            exit;
        }

        $center_id = $_SESSION['center_id'];

        $centerDetails = $this->centerModel->findByUserId($center_id);

        if (!$centerDetails) {
            $conn = $this->conn;
            $name = $_SESSION['center_name'] ?? 'Adoption Center';

            $stmt = $conn->prepare("INSERT INTO adoption_centers (user_id, name) VALUES (?, ?)");
            $stmt->bind_param("is", $center_id, $name);
            $stmt->execute();
            $stmt->close();

            $centerDetails = $this->centerModel->findByUserId($center_id);
        }

        $center = $centerDetails;

        include __DIR__ . '/../views/adoptioncenter/adoptioncenter_profile.php';
    }

    public function change_password()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["change_password"])) {
            $conn = $this->conn;

            $user_id = $_SESSION['center_id'] ?? null;
            if (!$user_id) {
                $_SESSION['error'] = "User not logged in.";
                header("Location: index.php?page=adoptioncenter/adoptioncenter_profile");
                exit();
            }

            $old_password = $_POST['old_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
                $_SESSION['error'] = "All fields are required.";
                header("Location: index.php?page=adoptioncenter/adoptioncenter_profile");
                exit();
            }

            $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/";
            if (!preg_match($pattern, $new_password)) {
                $_SESSION['error'] = "New password must be at least 8 characters long and include an uppercase letter, number, and special character.";
                header("Location: index.php?page=adoptioncenter/adoptioncenter_profile");
                exit();
            }

            if ($new_password !== $confirm_password) {
                $_SESSION['error'] = "New passwords do not match.";
                header("Location: index.php?page=adoptioncenter/adoptioncenter_profile");
                exit();
            }

            $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $stmt->close();

            if (!$user || !password_verify($old_password, $user['password'])) {
                $_SESSION['error'] = "Old password is incorrect.";
                header("Location: index.php?page=adoptioncenter/adoptioncenter_profile");
                exit();
            }

            $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
            $updateStmt->bind_param("si", $new_hashed_password, $user_id);
            $updateStmt->execute();
            $updateStmt->close();

            session_unset();
            session_destroy();

            session_start(); // start session again to set success message
            $_SESSION['success'] = "Password changed successfully. Please log in again.";
            header("Location: index.php?page=adoptioncenter/center_login");
            exit();
        }
    }

    public function showaddpetform()
    {
        $this->loadCenterView('add_pets.php');
    }

    public function managepetsform()
    {
        if (!isset($_SESSION['center_id'])) {
            header("Location: index.php?page=adoptioncenter/center_login");
            exit;
        }

        $center_id = $_SESSION['center_id'];

        $pets = $this->petModel->getPetsByUserId($center_id);

        include __DIR__ . '/../views/adoptioncenter/managepets.php';
    }

    public function verify_CenterLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $errors = [];

            if (empty($email)) {
                $errors['email'] = "Email is required.";
            }
            if (empty($password)) {
                $errors['password'] = "Password is required.";
            }

            if (!empty($errors)) {
                $_SESSION['centerlogin_errors'] = $errors;
                header("Location: index.php?page=adoptioncenter/center_login");
                exit;
            }

            $center = $this->centerModel->findByEmail($email);

            if ($center && password_verify($password, $center['password'])) {
                $_SESSION['center_id'] = $center['user_id'];
                $_SESSION['center_name'] = $center['name'];
                $_SESSION['adoptioncenter'] = true;

                header("Location: index.php?page=adoptioncenter/center_dashboard");
                exit;
            } else {
                $errors['centerlogin'] = "Invalid email or password.";
                $_SESSION['centerlogin_errors'] = $errors;
                header("Location: index.php?page=adoptioncenter/center_login");
                exit;
            }
        }
    }

    public function update_profile()
    {
        if (!isset($_SESSION['center_id'])) {
            header("Location: index.php?page=login");
            exit;
        }

        $user_id = $_SESSION['center_id'];
        $centerDetails = $this->centerModel->findByUserId($user_id);

        if (!$centerDetails || !isset($centerDetails['center_id'])) {
            $_SESSION['error'] = "Center not found for user ID $user_id.";
            header("Location: index.php?page=adoptioncenter/adoptioncenter_profile");
            exit;
        }

        $center_id = $centerDetails['center_id'];

        $name = $_POST['name'] ?? '';
        $established_date = $_POST['established_date'] ?? '';
        $location = $_POST['location'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $number_of_employees = intval($_POST['number_of_employees'] ?? 0);
        $operating_hours = $_POST['operating_hours'] ?? '';
        $description = $_POST['description'] ?? '';
        $logo_path = null;

        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['logo']['tmp_name'];
            $fileName = $_FILES['logo']['name'];
            $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
            $newFileName = 'center_' . $center_id . '_' . time() . '.' . $fileExt;
            $uploadDir = 'public/uploads/logos/';
            $destPath = $uploadDir . $newFileName;

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $logo_path = $destPath;
            }
        }

        $success = $this->centerModel->updateProfile(
            $center_id,
            $name,
            $established_date,
            $location,
            $phone,
            $number_of_employees,
            $operating_hours,
            $description,
            $logo_path
        );

        if ($success) {
            $_SESSION['success'] = "✅ Profile updated successfully!";
        } else {
            $_SESSION['error'] = "❌ Update failed. Please check your inputs.";
        }

        header("Location: index.php?page=adoptioncenter/adoptioncenter_profile");
        exit;
    }

   public function savePets()
{
    // Check login session
    if (!isset($_SESSION['center_id'])) {
        $_SESSION['errors'] = ["You must be logged in as an adoption center to add pets."];
        header("Location: index.php?page=adoptioncenter/center_login");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $_SESSION['errors'] = ["Invalid request method."];
        header("Location: index.php?page=adoptioncenter/add_pets");
        exit;
    }

    $posted_by = $_SESSION['center_id']; // user_id of adoption_center
    $adoption_center_name = $_SESSION['center_name'] ?? 'Unknown Center';

    // Collect and sanitize form data
    $name = trim($_POST['petName'] ?? '');
    $type = trim($_POST['petType'] ?? '');
    $breed = trim($_POST['breed'] ?? '');
    $gender = $_POST['gender'] ?? '';
    $age = floatval($_POST['age'] ?? 0);
    $date_arrival = $_POST['date_arrival'] ?? date('Y-m-d'); // default today
    $size = $_POST['size'] ?? 'Medium'; // use form value or default
    $weight = floatval($_POST['weight'] ?? 0);
    $color = trim($_POST['color'] ?? '');
    $health_status = $_POST['healthStatus'] ?? 'Good'; // must be one of enum values: 'Excellent', 'Good', 'Fair', 'Poor'
$characteristics = $_POST['characteristics'] ?? '';
if (is_array($characteristics)) {
    $characteristics = implode(", ", $characteristics); // Join array values as a comma-separated string
}
$characteristics = trim($characteristics);
    $description = trim($_POST['description'] ?? '');
    $health_notes = trim($_POST['healthNotes'] ?? '');
    $contact_phone = trim($_POST['contactPhone'] ?? '');
    $contact_email = trim($_POST['contactEmail'] ?? '');
    $center_address = trim($_POST['centerAddress'] ?? '');
    $center_website = trim($_POST['centerWebsite'] ?? '');
    $status = 'available'; // default status

    // Validate gender: must be 'Male' or 'Female' exactly (enum)
    if (!in_array($gender, ['Male', 'Female'])) {
        $_SESSION['errors'] = ["Invalid gender selected."];
        header("Location: index.php?page=adoptioncenter/add_pets");
        exit;
    }

    // Validate health_status
    if (!in_array($health_status, ['Excellent', 'Good', 'Fair', 'Poor'])) {
        $health_status = 'Good'; // fallback default
    }

    // Handle image upload
    $image_path = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = basename($_FILES['image']['name']);
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Sanitize filename or generate unique
        $newFileName = uniqid('pet_', true) . '.' . $fileExtension;
        $destPath = $uploadDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $image_path = $destPath;
        } else {
            $_SESSION['errors'] = ["Failed to upload image."];
            header("Location: index.php?page=adoptioncenter/add_pets");
            exit;
        }
    }

    // Prepare data array for insertion
    $petData = [
        'name' => $name,
        'type' => $type,
        'breed' => $breed,
        'gender' => $gender,
        'age' => $age,
        'date_arrival' => $date_arrival,
        'size' => $size,
        'weight' => $weight,
        'color' => $color,
        'health_status' => $health_status,
        'characteristics' => $characteristics,
        'description' => $description,
        'health_notes' => $health_notes,
        'adoption_center' => $adoption_center_name,
        'contact_phone' => $contact_phone,
        'contact_email' => $contact_email,
        'center_address' => $center_address,
        'center_website' => $center_website,
        'image_path' => $image_path,
        'status' => $status,
        'posted_by' => $posted_by
    ];

    // Insert pet using model
    $petModel = new Pet($this->conn);
    $inserted = $petModel->insertPet($petData);

    if ($inserted) {
        $_SESSION['success'] = "Pet added successfully!";
        header("Location: index.php?page=adoptioncenter/managepets");
        exit;
    } else {
        $_SESSION['errors'] = ["Failed to add pet. Please try again."];
        header("Location: index.php?page=adoptioncenter/add_pets");
        exit;
    }
}

    public function updatePet()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pet_id = $_POST['pet_id'] ?? null;

        if (!$pet_id) {
            $_SESSION['error'] = "Pet ID missing.";
            header("Location: index.php?page=adoptioncenter/managepets");
            exit;
        }

        // Normalize ENUM values to match DB (case-sensitive)
        $gender = ucfirst(strtolower($_POST['gender'] ?? ''));
        
        // For status, capitalize first letter (e.g. 'Adopted')
        $raw_status = $_POST['status'] ?? 'Available';
        $status = ucfirst(strtolower($raw_status));

        $health_status = ucfirst(strtolower($_POST['health_status'] ?? ''));

        // Prepare the data array
        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'type' => trim($_POST['type'] ?? ''),
            'breed' => trim($_POST['breed'] ?? ''),
            'gender' => $gender,
            'age' => floatval($_POST['age'] ?? 0),
            'date_arrival' => $_POST['date_arrival'] ?? date('Y-m-d'),
            'size' => $_POST['size'] ?? 'Medium',
            'weight' => floatval($_POST['weight'] ?? 0),
            'color' => trim($_POST['color'] ?? ''),
            'health_status' => $health_status,
            'characteristics' => trim($_POST['characteristics'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'health_notes' => trim($_POST['health_notes'] ?? ''),
            'adoption_center' => $_SESSION['center_name'] ?? '',
            'contact_phone' => trim($_POST['contact_phone'] ?? ''),
            'contact_email' => trim($_POST['contact_email'] ?? ''),
            'center_address' => trim($_POST['center_address'] ?? ''),
            'center_website' => trim($_POST['center_website'] ?? ''),
            'status' => $status,
        ];


        // Call the model's update method
        $success = $this->petModel->updatePet($pet_id, $data);

        if ($success) {
            $_SESSION['success'] = "Pet updated successfully.";
            header("Location: index.php?page=adoptioncenter/managepets&msg=updated");
            exit;
        } else {
            $_SESSION['error'] = "Failed to update pet.";
            header("Location: index.php?page=adoptioncenter/managepets");
            exit;
        }
    }
}


    public function deletePet()
{
    if (!isset($_SESSION['center_id'])) {
        $_SESSION['error'] = "Unauthorized access.";
        header("Location: index.php?page=adoptioncenter/center_login");
        exit;
    }

    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        $_SESSION['error'] = "Invalid pet ID.";
        header("Location: index.php?page=adoptioncenter/managepets");
        exit;
    }

    $pet_id = intval($_GET['id']);

    $deleted = $this->petModel->deletePet($pet_id);

    if ($deleted) {
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
        $conn = $this->conn;
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
        $conn = $this->conn;
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
