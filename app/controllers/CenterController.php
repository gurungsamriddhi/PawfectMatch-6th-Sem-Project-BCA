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
        $db = new Database();
        $conn = $db->connect();
        $this->petModel = new Pet($conn);
    }

    // private function loadCenterView($filename, $data = [])
    // {
    //     extract($data);
    //     include __DIR__ . '/../views/adoptioncenter/' . $filename;
    // }

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

    $db = new Database();
    $conn = $db->connect();

    $stats = [
        'total_Pets' => 0,
        'total_Adoptions' => 0,
        'total_Donations' => 0,
        'total_Volunteers' => 0,
        'pending_Requests' => 0,
    ];

    // Total pets listed
    $stmt = $conn->prepare("SELECT COUNT(*) FROM pets WHERE posted_by = ?");
    if (!$stmt) {
        die("Prepare failed (pets): (" . $conn->errno . ") " . $conn->error);
    }
    $stmt->bind_param('i', $center_id);
    $stmt->execute();
    $stmt->bind_result($totalPets);
    $stmt->fetch();
    $stats['total_Pets'] = $totalPets;
    $stmt->close();

   // Total adoptions completed (based on pet status = 'Adopted')
$stmt = $conn->prepare("SELECT COUNT(*) FROM pets WHERE posted_by = ? AND status = 'Adopted'");
if (!$stmt) {
    die("Prepare failed (adoptions): (" . $conn->errno . ") " . $conn->error);
}
$stmt->bind_param('i', $center_id);
$stmt->execute();
$stmt->bind_result($totalAdoptions);
$stmt->fetch();
$stats['total_Adoptions'] = $totalAdoptions;
$stmt->close();


    // Total donations
    // $stmt = $conn->prepare("SELECT COALESCE(SUM(amount),0) FROM donations WHERE center_id = ?");
    // if (!$stmt) {
    //     die("Prepare failed (donations): (" . $conn->errno . ") " . $conn->error);
    // }
    // $stmt->bind_param('i', $center_id);
    // $stmt->execute();
    // $stmt->bind_result($totalDonations);
    // $stmt->fetch();
    // $stats['total_Donations'] = $totalDonations;
    // $stmt->close();

    // Total volunteers
    // $stmt = $conn->prepare("SELECT COUNT(*) FROM volunteers WHERE center_id = ?");
    // if (!$stmt) {
    //     die("Prepare failed (volunteers): (" . $conn->errno . ") " . $conn->error);
    // }
    // $stmt->bind_param('i', $center_id);
    // $stmt->execute();
    // $stmt->bind_result($totalVolunteers);
    // $stmt->fetch();
    // $stats['total_Volunteers'] = $totalVolunteers;
    // $stmt->close();

    // Pending adoption requests
    // $stmt = $conn->prepare("SELECT COUNT(*) FROM adoption_requests r JOIN pets p ON r.pet_id = p.pet_id WHERE p.posted_by = ? AND r.status = 'Pending'");
    // if (!$stmt) {
    //     die("Prepare failed (pending requests): (" . $conn->errno . ") " . $conn->error);
    // }
    // $stmt->bind_param('i', $center_id);
    // $stmt->execute();
    // $stmt->bind_result($pendingRequests);
    // $stmt->fetch();
    // $stats['pending_Requests'] = $pendingRequests;
    // $stmt->close();

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
        // Load DB connection
        require_once __DIR__ . '/../../core/databaseconn.php';
        $db = new Database();
        $conn = $db->connect();

        $name = $_SESSION['center_name'] ?? 'Adoption Center';

        // Attempt to prepare statement
        $stmt = $conn->prepare("INSERT INTO adoption_centers (user_id, name) VALUES (?, ?)");
        if (!$stmt) {
            die("Database error while inserting: " . $conn->error);
        }

        $stmt->bind_param("is", $center_id, $name);
        $stmt->execute();
        $stmt->close();

        // Re-fetch profile
        $centerDetails = $this->centerModel->findByUserId($center_id);
    }

    $center = $centerDetails;

    include __DIR__ . '/../views/adoptioncenter/adoptioncenter_profile.php';
}


public function change_password()
{
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["change_password"])) {
        require_once __DIR__ . '/../../core/databaseconn.php';
        $db = new Database();
        $conn = $db->connect();

        $user_id = $_SESSION['center_id'] ?? null;

        if (!$user_id) {
            $_SESSION['error'] = "User not logged in.";
            header("Location: index.php?page=adoptioncenter/adoptioncenter_profile");
            exit();
        }

        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

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

        // Prepare and execute SELECT
        $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
        if (!$stmt) {
            $_SESSION['error'] = "Database error: failed to prepare statement.";
            header("Location: index.php?page=adoptioncenter/adoptioncenter_profile");
            exit();
        }
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (!$user || !password_verify($old_password, $user['password'])) {
            $_SESSION['error'] = "Old password is incorrect.";
            header("Location: index.php?page=adoptioncenter/adoptioncenter_profile");
            exit();
        }

        // Prepare and execute UPDATE
        $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
        if (!$updateStmt) {
            $_SESSION['error'] = "Database error: failed to prepare update statement.";
            header("Location: index.php?page=adoptioncenter/adoptioncenter_profile");
            exit();
        }
        $updateStmt->bind_param("si", $new_hashed_password, $user_id);
        $updateStmt->execute();

        session_unset();
        session_destroy();
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

    // Use new method to get pets posted by this adoption center
    $pets = $this->petModel->getPetsByUserId($center_id);

    include __DIR__ . '/../views/adoptioncenter/managepets.php';
}


public function verify_CenterLogin()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $errors = [];

        // Basic validation
        if (empty($email)) {
            $errors['email'] = "Email is required.";
        }

        if (empty($password)) {
            $errors['password'] = "Password is required.";
        }

        // If validation failed
        if (!empty($errors)) {
            $_SESSION['centerlogin_errors'] = $errors;
            header("Location: index.php?page=adoptioncenter/center_login");
            exit;
        }

        // Fetch center by email from users table where user_type = adoption_center
        $center = $this->centerModel->findByEmail($email);

        if ($center) {
            // Use password_verify to check hashed password
            if (password_verify($password, $center['password'])) {
                // Correct password, set session
                $_SESSION['center_id'] = $center['user_id'];   // note user_id key
                $_SESSION['center_name'] = $center['name'];

                header("Location: index.php?page=adoptioncenter/center_dashboard");
                exit;
            } else {
                $errors['center_login'] = "Invalid password.";
            }
        } else {
            $errors['center_login'] = "Center not found.";
        }

        // Login failed, redirect back with errors
        $_SESSION['centerlogin_errors'] = $errors;
        header("Location: index.php?page=adoptioncenter/center_login");
        exit;
    }
}
public function update_profile()
{
    if (!isset($_SESSION['center_id'])) {
        header("Location: index.php?page=login");
        exit;
    }

    $user_id = $_SESSION['center_id'];  // This is user_id from users table

    // Get center details using user_id → to get correct center_id
    $centerDetails = $this->centerModel->findByUserId($user_id);

    if (!$centerDetails || !isset($centerDetails['center_id'])) {
        $_SESSION['error'] = "Center not found for user ID $user_id.";
        header("Location: index.php?page=adoptioncenter/adoptioncenter_profile");
        exit;
    }

    $center_id = $centerDetails['center_id']; 

    // Collect form data
    $name = $_POST['name'] ?? '';
    $established_date = $_POST['established_date'] ?? '';
    $location = $_POST['location'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $number_of_employees = intval($_POST['number_of_employees'] ?? 0);
    $operating_hours = $_POST['operating_hours'] ?? '';
    $description = $_POST['description'] ?? '';
    $logo_path = null;

    // Handle file upload
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

    // Attempt to update
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
    // Ensure center is logged in
    if (!isset($_SESSION['center_id'])) {
        $_SESSION['errors'] = ["You must be logged in as an adoption center to add pets."];
        header("Location: index.php?page=adoptioncenter/center_login");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: index.php?page=adoptioncenter/add_pets');
        exit;
    }

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

    $posted_by = $_SESSION['center_id'];

    // Get adoption center name from DB
    $centerDetails = $this->centerModel->findByUserId($posted_by);
    $adoptionCenterName = $centerDetails['name'] ?? null;

    // Validation
    $errors = [];
    if (empty($name)) $errors[] = "Pet name is required.";
    if (!in_array($type, ['dog', 'cat', 'bird', 'rabbit', 'hamster', 'fish', 'other'])) $errors[] = "Invalid pet type.";
    if (!in_array($gender, ['male', 'female'])) $errors[] = "Invalid gender.";
    if ($age < 0) $errors[] = "Invalid age.";
    if (empty($size)) $errors[] = "Size is required.";
    if ($weight <= 0) $errors[] = "Weight must be positive.";
    if (empty($color)) $errors[] = "Color is required.";
    if (empty($healthStatus)) $errors[] = "Health status is required.";
    if (empty($description)) $errors[] = "Description is required.";

    if (!empty($errors)) {
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

    // Final pet data for insert
    $petData = [
        'name' => $name,
        'type' => $type,
        'breed' => $breed,
        'age' => $age,
        'gender' => $gender,
        'health_status' => $healthStatus,
        'image_path' => $imagePath,
        'posted_by' => $posted_by,
        'adoption_center_name' => $adoptionCenterName,
        'description' => $description,
    ];

    // Save pet
    if ($this->petModel->insertPet($petData)) {
        $_SESSION['success'] = "✅ Pet added successfully.";
        header('Location: index.php?page=adoptioncenter/managepets');
        exit;
    } else {
        $_SESSION['errors'] = ["❌ Failed to save pet."];
        header('Location: index.php?page=adoptioncenter/add_pets');
        exit;
    }
}
public function updatePet()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $petModel = new Pet($this->conn);

        $pet_id        = $_POST['pet_id'] ?? null;
        $name          = $_POST['name'] ?? '';
        $type          = $_POST['type'] ?? '';
        $breed         = $_POST['breed'] ?? '';
        $age           = $_POST['age'] ?? '';
        $gender        = $_POST['gender'] ?? '';
        $health_status = $_POST['health_status'] ?? '';
        $date_arrival  = $_POST['date_arrival'] ?? '';
        $status        = $_POST['status'] ?? '';
        $description   = $_POST['description'] ?? '';

        // Basic validation
        if ($pet_id && $name && $type && $breed && $age !== '' && $gender && $health_status && $date_arrival && $status && $description) {
            $success = $petModel->updatePet($pet_id, $name, $type, $breed, $age, $gender, $health_status, $date_arrival, $status, $description);

            if ($success) {
                header("Location: index.php?page=adoptioncenter/managepets&msg=updated");
                exit;
            } else {
                echo "Failed to update pet.";
            }
        } else {
            echo "All fields are required.";
        }
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
