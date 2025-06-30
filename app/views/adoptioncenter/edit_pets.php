<?php
include 'app/views/partials/sidebarcenter.php';
require_once 'core/databaseconn.php'; 

if (!isset($_GET['pet_id'])) {
    header('Location: index.php?page=adoptioncenter/managepets');
    exit;
}

$pet_id = intval($_GET['pet_id']);
$sql = "SELECT * FROM pets WHERE pet_id = $pet_id";
$result = mysqli_query($conn, $sql);
$pet = mysqli_fetch_assoc($result);

if (!$pet) {
    echo "Pet not found.";
    exit;
}

// Form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $type = $_POST['type'] ?? '';
    $breed = $_POST['breed'] ?? '';
    $age = $_POST['age'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $status = $_POST['status'] ?? '';
    $description = $_POST['description'] ?? '';
    $image_path = $pet['image_path'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $fileName = basename($_FILES['image']['name']);
        $uniqueName = uniqid() . '_' . $fileName;
        $target = "public/assets/images/" . $uniqueName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $image_path = $target;
        }
    }

    $update = "UPDATE pets SET 
                name = ?, type = ?, breed = ?, age = ?, gender = ?, status = ?, description = ?, image_path = ?
               WHERE pet_id = ?";
    $stmt = $conn->prepare($update);
    $stmt->bind_param("ssssssssi", $name, $type, $breed, $age, $gender, $status, $description, $image_path, $pet_id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Pet updated successfully.";
        header('Location: index.php?page=adoptioncenter/managepets');
        exit;
    } else {
        echo "Error updating pet: " . $stmt->error;
    }
}
?>

<div class="container my-5" style="max-width:700px;">
  <h3 class="mb-4 text-success fw-bold"><i class="fas fa-edit me-2"></i>Edit Pet</h3>
  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label class="form-label fw-semibold">Pet Name</label>
      <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($pet['name']) ?>">
    </div>

    <div class="mb-3">
      <label class="form-label fw-semibold">Type</label>
      <select name="type" class="form-select" required>
        <?php foreach (['dog', 'cat', 'rabbit', 'other'] as $type): ?>
          <option value="<?= $type ?>" <?= $pet['type'] === $type ? 'selected' : '' ?>><?= ucfirst($type) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label fw-semibold">Breed</label>
      <input type="text" name="breed" class="form-control" value="<?= htmlspecialchars($pet['breed']) ?>">
    </div>

    <div class="mb-3">
      <label class="form-label fw-semibold">Age</label>
      <input type="text" name="age" class="form-control" value="<?= htmlspecialchars($pet['age']) ?>">
    </div>

    <div class="mb-3">
      <label class="form-label fw-semibold">Gender</label>
      <select name="gender" class="form-select" required>
        <?php foreach (['male', 'female'] as $gender): ?>
          <option value="<?= $gender ?>" <?= $pet['gender'] === $gender ? 'selected' : '' ?>><?= ucfirst($gender) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label fw-semibold">Status</label>
      <select name="status" class="form-select" required>
        <?php foreach (['available', 'adopted'] as $status): ?>
          <option value="<?= $status ?>" <?= $pet['status'] === $status ? 'selected' : '' ?>><?= ucfirst($status) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label fw-semibold">Current Image</label><br>
      <img src="<?= htmlspecialchars($pet['image_path']) ?>" style="width:100px;height:100px;object-fit:cover;" alt="Pet Image">
    </div>

    <div class="mb-3">
      <label class="form-label fw-semibold">Upload New Image (optional)</label>
      <input type="file" name="image" class="form-control" accept="image/*">
    </div>

    <div class="mb-3">
      <label class="form-label fw-semibold">Description</label>
      <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($pet['description']) ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Update Pet</button>
    <a href="index.php?page=adoptioncenter/managepets" class="btn btn-secondary ms-2">Cancel</a>
  </form>
</div>
