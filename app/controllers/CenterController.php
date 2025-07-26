<?php
require_once __DIR__ . '/../models/Pet.php';
require_once __DIR__ . '/../models/Center.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Adoption.php';
require_once __DIR__ . '/../../core/databaseconn.php';

class CenterController
{
    private $conn;
    private $petModel;
    private $centerModel;
    private $userModel;
    private $adoptionModel;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
        $this->petModel = new Pet($this->conn);
        $this->centerModel = new Center();
        $this->userModel = new User();
        $this->adoptionModel = new Adoption($this->conn);
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

        // Total pets listed by this center
        $stmt = $conn->prepare("SELECT COUNT(*) FROM pets WHERE posted_by = ?");
        $stmt->bind_param('i', $center_id);
        $stmt->execute();
        $stmt->bind_result($stats['total_Pets']);
        $stmt->fetch();
        $stmt->close();

        // Total adoptions completed (based on pet status = 'adopted', case-insensitive)
        $stmt = $conn->prepare("SELECT COUNT(*) FROM pets WHERE posted_by = ? AND LOWER(status) = 'adopted'");
        $stmt->bind_param('i', $center_id);
        $stmt->execute();
        $stmt->bind_result($stats['total_Adoptions']);
        $stmt->fetch();
        $stmt->close();

        // Total donations (all donations to the platform)
        $stmt = $conn->prepare("SELECT COALESCE(SUM(amount), 0) FROM donations");
        $stmt->execute();
        $stmt->bind_result($stats['total_Donations']);
        $stmt->fetch();
        $stmt->close();

        // Total volunteers assigned to this center
        $stmt = $conn->prepare("SELECT COUNT(*) FROM volunteers WHERE assigned_center_id = ? AND status = 'assigned'");
        $stmt->bind_param('i', $center_id);
        $stmt->execute();
        $stmt->bind_result($stats['total_Volunteers']);
        $stmt->fetch();
        $stmt->close();

        // Pending adoption requests for pets posted by this center
        $stmt = $conn->prepare("
            SELECT COUNT(*) FROM adoption_requests ar 
            JOIN pets p ON ar.pet_id = p.pet_id 
            WHERE p.posted_by = ? AND ar.request_status = 'pending'
        ");
        $stmt->bind_param('i', $center_id);
        $stmt->execute();
        $stmt->bind_result($stats['pending_Requests']);
        $stmt->fetch();
        $stmt->close();

        // Debug: Log the stats to see what's being calculated
        error_log("Center Dashboard Stats for center_id $center_id: " . json_encode($stats));

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
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?page=adoptioncenter/add_pets");
            exit();
        }

        if (!isset($_SESSION['center_id'])) {
            header("Location: index.php?page=adoptioncenter/center_login");
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
        $data['postedBy'] = $_SESSION['center_id'] ?? 0;

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
        $petModel = new Pet($this->conn);
        $success = $petModel->addPet($data);

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
        if (!isset($_SESSION['center_id'])) {
            header("Location: index.php?page=adoptioncenter/center_login");
            exit;
        }

        $center_id = $_SESSION['center_id'];
        $requests = $this->adoptionModel->getFormsByCenter($center_id);
        
        // Pass the requests data to the view
        include __DIR__ . '/../views/adoptioncenter/adoption_request.php';
    }

    public function viewAssignedVolunteers()
    {
        $centerId = $_SESSION['center_id']; // from session after login

        // Load model
        $volunteerModel = new Volunteer($this->conn);

        // Get assigned volunteers
        $volunteers = $volunteerModel->getVolunteersByCenter($centerId);

        // Load view
       $this->loadCenterView('view_volunteers.php');
    }
   
    // public function approveRequest()
    // {
    //     $conn = $this->conn;
    //     $requestModel = new Request($conn);

    //     $id = $_GET['id'] ?? null;
    //     if ($id && $requestModel->updateStatus($id, 'Approved')) {
    //         $_SESSION['success'] = "Request approved.";
    //     } else {
    //         $_SESSION['error'] = "Approval failed.";
    //     }
    //     header("Location: index.php?page=adoptioncenter/adoption_request");
    //     exit;
    // }

    // public function rejectRequest()
    // {
    //     $conn = $this->conn;
    //     $requestModel = new Request($conn);

    //     $id = $_GET['id'] ?? null;
    //     if ($id && $requestModel->updateStatus($id, 'Rejected')) {
    //         $_SESSION['success'] = "Request rejected.";
    //     } else {
    //         $_SESSION['error'] = "Rejection failed.";
    //     }
    //     header("Location: index.php?page=adoptioncenter/adoption_request");
    //     exit;
    // }

    // public function feedback()
    // {
    //     $this->loadCenterView('feedback.php');
    // }
}
