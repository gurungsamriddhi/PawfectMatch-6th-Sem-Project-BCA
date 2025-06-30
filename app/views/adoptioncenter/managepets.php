<?php include 'app/views/partials/sidebarcenter.php'; ?>

<!-- Include Bootstrap 5 CSS (only once in your layout ideally) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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
      <a href="index.php?page=adoptioncenter/add_pets" class="btn btn-success shadow-sm">
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
          <?php if (!empty($pets)): ?>
            <?php $count = 1; foreach ($pets as $pet): ?>
              <tr>
                <td><?= $count++; ?></td>
                <td>
                  <img src="<?= htmlspecialchars($pet['image_path']) ?>" alt="<?= htmlspecialchars($pet['name']) ?>"
                       class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                </td>
                <td><?= htmlspecialchars($pet['name']) ?></td>
                <td><?= htmlspecialchars($pet['breed']) ?></td>
                <td><?= htmlspecialchars($pet['age']) ?></td>
                <td><?= ucfirst(htmlspecialchars($pet['gender'])) ?></td>
                <td>
                  <span class="badge <?= strtolower($pet['status']) === 'available' ? 'bg-success' : 'bg-secondary' ?>">
                    <?= ucfirst(htmlspecialchars($pet['status'])) ?>
                  </span>
                </td>
                <td>
                  <a href="index.php?page=adoptioncenter/editpets&pet_id=<?= $pet['pet_id'] ?>" class="btn btn-sm btn-warning">
                    <i class="fas fa-edit me-1"></i>Edit
                  </a>
                  <button 
                    type="button"
                    class="btn btn-sm btn-danger btn-delete"
                    data-delete-url="index.php?page=adoptioncenter/deletepet&pet_id=<?= $pet['pet_id'] ?>"
                  >
                    <i class="fas fa-trash-alt me-1"></i>Delete
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="8" class="text-center">No pets found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- ✅ Delete Confirmation Modal (one instance only!) -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteConfirmLabel">Confirm Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Do you really want to delete this pet?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <a href="#" class="btn btn-danger" id="confirmDeleteBtn">Delete</a>
      </div>
    </div>
  </div>
</div>

<!-- ✅ Bootstrap 5 JS Bundle (include only once) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- ✅ Custom JavaScript to handle delete -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  const deleteButtons = document.querySelectorAll('.btn-delete');
  const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

  deleteButtons.forEach(button => {
    button.addEventListener('click', function () {
      const url = this.getAttribute('data-delete-url');
      confirmDeleteBtn.setAttribute('href', url);

      // Show Bootstrap modal
      const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
      deleteModal.show();
    });
  });
});
</script>
