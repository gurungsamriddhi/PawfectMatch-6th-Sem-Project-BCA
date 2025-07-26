<?php include 'app/views/adoptioncenter/centerpartials/sidebarcenter.php'; ?>
<?php

include '../../../core/databaseconn.php';

// Check if pet_id is provided
if (!isset($_GET['pet_id'])) {
    header('Location: managepets.php');
    exit;
}

$pet_id = intval($_GET['pet_id']);

// Get pet to delete image file
$sql = "SELECT image_path FROM pets WHERE pet_id = $pet_id";
$result = mysqli_query($conn, $sql);

if (!$result) {
    $_SESSION['error'] = "Database error: " . mysqli_error($conn);
    header('Location: managepets.php');
    exit;
}

$pet = mysqli_fetch_assoc($result);

if (!$pet) {
    $_SESSION['error'] = "Pet not found.";
    header('Location: managepets.php');
    exit;
}

// Delete pet record from DB
$delete_sql = "DELETE FROM pets WHERE pet_id = $pet_id";
if (mysqli_query($conn, $delete_sql)) {
    // Delete image file if exists
    $image_file = 'uploads/' . $pet['image_path'];
    if (!empty($pet['image_path']) && file_exists($image_file)) {
        unlink($image_file);
    }
    $_SESSION['success'] = "Pet deleted successfully.";
    header('Location: managepets.php');
    exit;
} else {
    $_SESSION['error'] = "Error deleting pet: " . mysqli_error($conn);
    header('Location: managepets.php');
    exit;
}
?>
