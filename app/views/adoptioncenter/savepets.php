<!-- <?php include 'app/views/partials/sidebarcenter.php'; ?>
<?php
include '../../../core/databaseconn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input to prevent SQL injection
    $name = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
    $type = mysqli_real_escape_string($conn, $_POST['type'] ?? '');
    $breed = mysqli_real_escape_string($conn, $_POST['breed'] ?? '');
    $age = intval($_POST['age'] ?? 0);
    $gender = mysqli_real_escape_string($conn, $_POST['gender'] ?? '');
    $status = mysqli_real_escape_string($conn, $_POST['status'] ?? '');
    $description = mysqli_real_escape_string($conn, $_POST['description'] ?? '');

    // Check if image uploaded without errors
    if (!isset($_FILES['image']) || $_FILES['image']['error'] != 0) {
        echo "Please upload an image.";
        exit;
    }

    $imageTmp = $_FILES['image']['tmp_name'];
    $imageName = basename($_FILES['image']['name']);
    $uploadDir = "uploads/";

    // Create uploads folder if not exists
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Validate image type (only allow jpg, png, gif)
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $mimeType = mime_content_type($imageTmp);
    if (!in_array($mimeType, $allowedTypes)) {
        echo "Only JPG, PNG, and GIF images are allowed.";
        exit;
    }

    // Generate unique filename to prevent overwriting
    $uniqueImageName = uniqid() . '-' . $imageName;
    $targetFile = $uploadDir . $uniqueImageName;

    if (move_uploaded_file($imageTmp, $targetFile)) {
        // Insert into DB
        $sql = "INSERT INTO pets (name, type, breed, age, gender, status, description, image_path)
                VALUES ('$name', '$type', '$breed', $age, '$gender', '$status', '$description', '$uniqueImageName')";

        if (mysqli_query($conn, $sql)) {
            header("Location: managepets.php");
            exit();
        } else {
            echo "Database Error: " . mysqli_error($conn);
        }
    } else {
        echo "Image upload failed.";
    }
}
?> -->
