<?php include 'sidebar.php'; ?>
<link rel="stylesheet" href="/animal_adoption/pawfectmatch/public/assets/css/adoptioncenter.css" />
<?php
include '../../../core/databaseconn.php'; // make sure this file exists and defines $conn

if (!isset($_GET['pet_id'])) {
    header('Location: managepets.php');
    exit;
}

$pet_id = intval($_GET['pet_id']);

// Fetch pet data
$sql = "SELECT * FROM pets WHERE pet_id = $pet_id";
$result = mysqli_query($conn, $sql);
$pet = mysqli_fetch_assoc($result);

if (!$pet) {
    echo "Pet not found.";
    exit;
}

// Handle form submission to update pet
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $type = $_POST['type'] ?? '';
    $breed = $_POST['breed'] ?? '';
    $age = intval($_POST['age'] ?? 0);
    $gender = $_POST['gender'] ?? '';
    $status = $_POST['status'] ?? '';
    $description = $_POST['description'] ?? '';

    // Handle image upload if new image selected
    $image_path = $pet['image_path'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        $target = "uploads/" . basename($image);
        if (move_uploaded_file($tmp, $target)) {
            $image_path = $image;
        }
    }

    // Update query
    $update_sql = "UPDATE pets SET 
                    name = '$name', 
                    type = '$type', 
                    breed = '$breed', 
                    age = $age, 
                    gender = '$gender', 
                    status = '$status', 
                    description = '$description', 
                    image_path = '$image_path' 
                    WHERE pet_id = $pet_id";

    if (mysqli_query($conn, $update_sql)) {
        header('Location: managepets.php');
        exit;
    } else {
        echo "Error updating pet: " . mysqli_error($conn);
    }
}
?>

<!-- HTML form to edit pet -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container my-5" style="max-width:700px;">
  <h3 class="mb-4">Edit Pet</h3>
  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label class="form-label">Pet Name</label>
      <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($pet['name']) ?>">
    </div>

    <div class="mb-3">
      <label class="form-label">Type</label>
      <select name="type" class="form-select" required>
        <?php 
          $types = ['dog', 'cat', 'rabbit', 'other'];
          foreach ($types as $t) {
              $selected = ($pet['type'] === $t) ? 'selected' : '';
              echo "<option value='$t' $selected>" . ucfirst($t) . "</option>";
          }
        ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Breed</label>
      <input type="text" name="breed" class="form-control" value="<?= htmlspecialchars($pet['breed']) ?>">
    </div>

    <div class="mb-3">
      <label class="form-label">Age (years)</label>
      <input type="number" name="age" class="form-control" value="<?= htmlspecialchars($pet['age']) ?>">
    </div>

    <div class="mb-3">
      <label class="form-label">Gender</label>
      <select name="gender" class="form-select" required>
        <?php
          $genders = ['male', 'female'];
          foreach ($genders as $g) {
              $selected = ($pet['gender'] === $g) ? 'selected' : '';
              echo "<option value='$g' $selected>" . ucfirst($g) . "</option>";
          }
        ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Status</label>
      <select name="status" class="form-select" required>
        <?php
          $statuses = ['available', 'adopted'];
          foreach ($statuses as $s) {
              $selected = ($pet['status'] === $s) ? 'selected' : '';
              echo "<option value='$s' $selected>" . ucfirst($s) . "</option>";
          }
        ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Current Image</label><br>
      <img src="uploads/<?= htmlspecialchars($pet['image_path']) ?>" alt="Pet Image" style="width:100px; height:100px; object-fit:cover;">
    </div>

    <div class="mb-3">
      <label class="form-label">Upload New Image (optional)</label>
      <input type="file" name="image" class="form-control" accept="image/*">
    </div>

    <div class="mb-3">
      <label class="form-label">Description</label>
      <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($pet['description']) ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Update Pet</button>
    <a href="managepets.php" class="btn btn-secondary ms-2">Cancel</a>
  </form>
</div>
