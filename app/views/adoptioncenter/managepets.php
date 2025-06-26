 <!--

// require_once __DIR__ . '/../../../core/databaseconn.php';

// $sql = "SELECT * FROM pets ORDER BY pet_id DESC";
// $result = mysqli_query($conn, $sql);

// if (!$result) {
//     die("Query failed: " . mysqli_error($conn));
// }
-->
<?php include 'app/views/partials/sidebarcenter.php'; ?>

<div class="body-wrapper">

  <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']); ?></div>
    <?php unset($_SESSION['success']); ?>
  <?php endif; ?>

  <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']); ?></div>
    <?php unset($_SESSION['error']); ?>
  <?php endif; ?>

  <div class="card">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="fw-bold m-0"><i class="fas fa-dog me-2 text-success"></i>Manage Pets</h3>
      <a href="add.php" class="btn btn-success shadow-sm">
        <i class="fas fa-plus me-1"></i>Add New Pet
      </a>
    </div>

    <div class="table-responsive">
      <table class="table table-hover table-bordered align-middle">
        <thead class="table-success">
          <tr>
            <th>#</th>
            <th>Photo</th>
            <th>Name</th>
            <th>Breed</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $count = 1;
          if (mysqli_num_rows($result) == 0) {
              echo '<tr><td colspan="8" class="text-center">No pets found.</td></tr>';
          } else {
              while ($row = mysqli_fetch_assoc($result)) {
                  $statusClass = strtolower($row['status']) === 'available' ? 'bg-success' : 'bg-secondary';
                  ?>
                  <tr>
                    <td><?= $count++; ?></td>
                    <td>
                      <img src="uploads/<?= htmlspecialchars($row['image_path']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" 
                          class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                    </td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['breed']) ?></td>
                    <td><?= htmlspecialchars($row['age']) ?></td>
                    <td><?= ucfirst(htmlspecialchars($row['gender'])) ?></td>
                    <td><span class="badge <?= $statusClass ?>"><?= ucfirst(htmlspecialchars($row['status'])) ?></span></td>
                    <td>
                      <a href="edit_pets.php?pet_id=<?= $row['pet_id'] ?>" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit me-1"></i>Edit
                      </a>
                      <a href="delete_pets.php?pet_id=<?= $row['pet_id'] ?>" 
                        class="btn btn-sm btn-danger" 
                        onclick="return confirm('Do you really want to delete this pet?');">
                        <i class="fas fa-trash-alt me-1"></i>Delete
                      </a>
                    </td>
                  </tr>
                  <?php
              }
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
