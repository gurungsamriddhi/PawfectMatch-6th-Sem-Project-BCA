<?php
require_once __DIR__ . '/../models/Pet.php';

class CenterController
{
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
    public function update_profile()
{
    $center_id = $_SESSION['adoptioncenter']['center_id'] ?? null;

    if (!$center_id) {
        $_SESSION['error'] = "Unauthorized access.";
        header("Location: index.php?page=adoptioncenter/adoptioncenter_profile");
        exit;
    }

    // Extract POST data
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $description = $_POST['description'] ?? '';
    $logo_path = null;

    // Handle file upload
    if (!empty($_FILES['logo']['name'])) {
        $upload_dir = 'public/uploads/logos/';
        $filename = uniqid() . '_' . basename($_FILES['logo']['name']);
        $target_path = $upload_dir . $filename;

        if (move_uploaded_file($_FILES['logo']['tmp_name'], $target_path)) {
            $logo_path = $target_path;
        } else {
            $_SESSION['error'] = "Failed to upload logo.";
            header("Location: index.php?page=adoptioncenter/adoptioncenter_profile");
            exit;
        }
    }

    // Call model to update
    $success = $centerModel->updateProfile($center_id, $name, $email, $phone, $address, $description, $logo_path);

    if ($success) {
        $_SESSION['success'] = "Profile updated successfully.";
    } else {
        $_SESSION['error'] = "Failed to update profile.";
    }

    header("Location: index.php?page=adoptioncenter/adoptioncenter_profile");
    exit;
}


    public function showaddpetform()
    {
        $this->loadCenterView('add_pets.php');
    }

    public function managepetsform()
    {
        $db = new Database();
        $conn = $db->connect();
        $petModel = new Pet($conn);

        $pets = $petModel->getAllPets();
        include __DIR__ . '/../views/adoptioncenter/managepets.php';
    }

    public function savePet()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db = new Database();
            $conn = $db->connect();
            $petModel = new Pet($conn);

            $name = trim($_POST['name']);
            $type = trim($_POST['type']);
            $breed = trim($_POST['breed']);
            $age = trim($_POST['age']);
            $gender = trim($_POST['gender']);
            $status = trim($_POST['status']);
            $description = trim($_POST['description']);

            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $targetDir = 'public/assets/images/';
                $fileName = basename($_FILES['image']['name']);
                $uniqueFileName = uniqid() . '_' . $fileName;
                $targetFilePath = $targetDir . $uniqueFileName;

                $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

                if (!in_array($fileType, $allowedTypes)) {
                    $_SESSION['error'] = "Only JPG, JPEG, PNG, and GIF files are allowed.";
                    header('Location: index.php?page=adoptioncenter/add_pets');
                    exit;
                }

                if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                    $_SESSION['error'] = "Failed to upload image.";
                    header('Location: index.php?page=adoptioncenter/add_pets');
                    exit;
                }
            } else {
                $_SESSION['error'] = "Please upload an image.";
                header('Location: index.php?page=adoptioncenter/add_pets');
                exit;
            }

            // ⛔ Removed center_id — not needed
            $inserted = $petModel->addPet($name, $type, $breed, $age, $gender, $status, $description, $targetFilePath);

            if ($inserted) {
                $_SESSION['success'] = "Pet added successfully!";
                header('Location: index.php?page=adoptioncenter/managepets');
                exit;
            } else {
                $_SESSION['error'] = "Failed to add pet. Please try again.";
                header('Location: index.php?page=adoptioncenter/add_pets');
                exit;
            }
        } else {
            header('Location: index.php?page=adoptioncenter/add_pets');
            exit;
        }
    }

    public function editpets()
    {
        $db = new Database();
        $conn = $db->connect();
        $petModel = new Pet($conn);

        $pet_id = $_GET['pet_id'] ?? null;
        if (!$pet_id) {
            $_SESSION['error'] = "Pet ID missing.";
            header('Location: index.php?page=adoptioncenter/managepets');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $type = trim($_POST['type'] ?? '');
            $breed = trim($_POST['breed'] ?? '');
            $age = trim($_POST['age'] ?? '');
            $gender = trim($_POST['gender'] ?? '');
            $status = trim($_POST['status'] ?? '');
            $description = trim($_POST['description'] ?? '');

            $errors = [];

            if ($name === '') $errors[] = "Name is required.";
            if (!in_array($type, ['dog', 'cat', 'rabbit', 'other'])) $errors[] = "Invalid type.";
            if (!is_numeric($age) || intval($age) < 0) $errors[] = "Age must be a valid number.";
            if (!in_array($gender, ['male', 'female'])) $errors[] = "Invalid gender.";
            if (!in_array($status, ['available', 'adopted'])) $errors[] = "Invalid status.";

            $pet = $petModel->getPetById($pet_id);
            $image_path = $pet['image_path'] ?? '';

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($_FILES['image']['type'], $allowed_types)) {
                    $errors[] = "Only JPG, PNG, GIF allowed.";
                } else {
                    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $newFileName = 'uploads/' . uniqid() . '.' . $ext;
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $newFileName)) {
                        $image_path = $newFileName;
                    } else {
                        $errors[] = "Failed to upload image.";
                    }
                }
            }

            if (empty($errors)) {
                $updated = $petModel->updatePet(
    $pet_id,
    $name,
    $type,
    $breed,
    $age,
    $gender,
    $status,
    $description,
    $image_path
);


                if ($updated) {
                    $_SESSION['success'] = "Pet updated successfully.";
                    header('Location: index.php?page=adoptioncenter/managepets');
                    exit;
                } else {
                    $errors[] = "Failed to update pet.";
                }
            }

            include __DIR__ . '/../views/adoptioncenter/edit_pets.php';
        } else {
            $pet = $petModel->getPetById($pet_id);
            if (!$pet) {
                $_SESSION['error'] = "Pet not found.";
                header('Location: index.php?page=adoptioncenter/managepets');
                exit;
            }
            $errors = [];
            include __DIR__ . '/../views/adoptioncenter/edit_pets.php';
        }
    }

    public function deletepet()
    {
        $db = new Database();
        $conn = $db->connect();
        $petModel = new Pet($conn);

        $pet_id = $_GET['pet_id'] ?? null;

        if ($pet_id && $petModel->deletePetById($pet_id)) {
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
    public function feedback()
    {
        $this->loadCenterView('feedback.php');
    }
}
