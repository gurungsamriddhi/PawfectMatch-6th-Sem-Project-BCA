<?php include 'app/views/adoptioncenter/centerpartials/sidebarcenter.php'; ?>
<!-- Main Content -->
<div class="body-wrapper w-100">
  <!-- Header -->
  <header class="app-header bg-dark text-white py-3 px-4">
    <div class="d-flex justify-content-between align-items-center">
      <h5 class="mb-0">All Pets</h5>
      <div class="d-flex align-items-center gap-3">
        <i class="fas fa-bell"></i>
        <i class="fas fa-user-circle"></i>
      </div>
    </div>
  </header>

  <!-- Content -->
  <div class="container-fluid py-4">
    <?php if (isset($_SESSION['success'])): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= htmlspecialchars($_SESSION['success']) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= htmlspecialchars($_SESSION['error']) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['errors']) && is_array($_SESSION['errors'])): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <ul class="mb-0">
      <?php foreach ($_SESSION['errors'] as $err): ?>
        <li><?= htmlspecialchars($err) ?></li>
      <?php endforeach; ?>
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php unset($_SESSION['errors']); ?>
<?php endif; ?>


    <div class="top-actions">
      <a href="index.php?page=adoptioncenter/add_pets" class="add-btn">
        <i class="fa-solid fa-plus"></i> Add Pet
      </a>
      <div class="filter-group">
        <label for="typeFilter"><i class="fa-solid fa-folder-open"></i> Filter by Type:</label>
        <select class="filter" id="typeFilter" onchange="filterByType(this)">
          <option value="All">All</option>
          <option value="Dog">Dog</option>
          <option value="Cat">Cat</option>
          <option value="Rabbit">Rabbit</option>
          <option value="Bird">Bird</option>
        </select>
      </div>
    </div>

    <div class="table-responsive mt-5">
      <table class="table view-table" id="animalTable">
        <thead>
          <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Breed</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Status</th>
            <th>Posted By</th>
            <th>Description</th>
            <th>Health</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($pets)): ?>
            <?php foreach ($pets as $pet): ?>
              <tr data-type="<?= htmlspecialchars($pet['type']) ?>">
                <td><?= htmlspecialchars($pet['name']) ?></td>
                <td><?= htmlspecialchars($pet['type']) ?></td>
                <td><?= htmlspecialchars($pet['breed']) ?></td>
                <td><?= htmlspecialchars($pet['age']) ?></td>
                <td><?= htmlspecialchars($pet['gender']) ?></td>
                <td><?= htmlspecialchars($pet['status']) ?></td>
                <td><?= htmlspecialchars($_SESSION['center_name'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($pet['description']) ?></td>
                <td><?= htmlspecialchars($pet['health_status']) ?></td>
                <td>
                  <div class="action-buttons">
                    <a href="#" 
                       class="edit-btn btn btn-sm btn-primary"
                       data-bs-toggle="tooltip" title="Edit Pet"
                       data-petid="<?= $pet['pet_id'] ?>"
                       data-name="<?= htmlspecialchars($pet['name']) ?>"
                       data-type="<?= htmlspecialchars($pet['type']) ?>"
                       data-breed="<?= htmlspecialchars($pet['breed']) ?>"
                       data-age="<?= htmlspecialchars($pet['age']) ?>"
                       data-gender="<?= htmlspecialchars($pet['gender']) ?>"
                       data-status="<?= htmlspecialchars($pet['status']) ?>"
                       data-description="<?= htmlspecialchars($pet['description']) ?>"
                       data-health_status="<?= htmlspecialchars($pet['health_status']) ?>"
                       data-date_arrival="<?= htmlspecialchars($pet['date_arrival']) ?>">
                      <i class="fa-solid fa-pen"></i> Edit
                    </a>

                    <!-- Delete Button -->
<button 
  class="btn btn-sm btn-danger delete-btn" 
  data-id="<?= $pet['pet_id'] ?>" 
  data-bs-toggle="modal" 
  data-bs-target="#deleteModal"
  data-bs-petname="<?= htmlspecialchars($pet['name']) ?>"
  title="Delete Pet">
  <i class="fa-solid fa-trash"></i> Delete
</button>

                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="11" class="text-center">No pets found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Edit Pet Modal -->
<div class="modal fade" id="editPetModal" tabindex="-1" aria-labelledby="editPetModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form id="editPetForm" method="POST" action="index.php?page=adoptioncenter/updatePet">
        <input type="hidden" id="editPetId" name="pet_id" />
        <div class="modal-header">
          <h5 class="modal-title" id="editPetModalLabel">Edit Pet Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="editPetName" class="form-label">Pet Name *</label>
              <input type="text" class="form-control" id="editPetName" name="name" required>
            </div>
            <div class="col-md-6">
              <label for="editPetType" class="form-label">Type *</label>
              <select class="form-select" id="editPetType" name="type" required>
                <option value="Dog">Dog</option>
                <option value="Cat">Cat</option>
                <option value="Bird">Bird</option>
                <option value="Rabbit">Rabbit</option>
                <option value="Hamster">Hamster</option>
                <option value="Fish">Fish</option>
                <option value="Other">Other</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="editBreed" class="form-label">Breed *</label>
              <input type="text" class="form-control" id="editBreed" name="breed" required>
            </div>
            <div class="col-md-6">
              <label for="editAge" class="form-label">Age (in years) *</label>
              <input type="number" class="form-control" id="editAge" name="age" min="0" step="0.1" required>
            </div>
            <div class="col-md-6">
              <label for="editGender" class="form-label">Gender *</label>
              <select class="form-select" id="editGender" name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="editHealthStatus" class="form-label">Health Status *</label>
              <select class="form-select" id="editHealthStatus" name="health_status" required>
                <option value="Excellent">Excellent</option>
                <option value="Good">Good</option>
                <option value="Fair">Fair</option>
                <option value="Poor">Poor</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="editDateArrival" class="form-label">Date of Arrival *</label>
              <input type="date" class="form-control" id="editDateArrival" name="date_arrival" required>
            </div>
            <div class="col-md-6">
              <label for="editStatus" class="form-label">Status *</label>
              <select class="form-select" id="editStatus" name="status" required>
                <option value="available">Available</option>
                <option value="adopted">Adopted</option>
                <option value="pending">Pending</option>
              </select>
            </div>
            <div class="col-12">
              <label for="editDescription" class="form-label">Description *</label>
              <textarea class="form-control" id="editDescription" name="description" rows="3" required></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-secondary text-white">
        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete <strong id="petNamePlaceholder"></strong>?
      </div>
      <div class="modal-footer">
        <form method="GET" action="index.php">
          <input type="hidden" name="page" value="adoptioncenter/deletepet">
          <input type="hidden" name="id" id="deletePetId">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Yes, Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const editBtns = document.querySelectorAll('.edit-btn');

  editBtns.forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.preventDefault();

      document.getElementById('editPetId').value = btn.dataset.petid ?? '';
      document.getElementById('editPetName').value = btn.dataset.name ?? '';
      document.getElementById('editPetType').value = btn.dataset.type ?? '';
      document.getElementById('editBreed').value = btn.dataset.breed ?? '';
      document.getElementById('editAge').value = btn.dataset.age ?? '';
      document.getElementById('editGender').value = btn.dataset.gender ?? '';
      document.getElementById('editHealthStatus').value = btn.dataset.health_status ?? '';
      document.getElementById('editDateArrival').value = btn.dataset.date_arrival ?? '';
      document.getElementById('editStatus').value = btn.dataset.status ?? '';
      document.getElementById('editDescription').value = btn.dataset.description ?? '';

      const modal = new bootstrap.Modal(document.getElementById('editPetModal'));
      modal.show();
    });
  });
});
const deleteModal = document.getElementById('deleteModal');

  deleteModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const petId = button.getAttribute('data-id');
    const petName = button.getAttribute('data-bs-petname');

    const petIdInput = document.getElementById('deletePetId');
    const petNamePlaceholder = document.getElementById('petNamePlaceholder');

    petIdInput.value = petId;
    petNamePlaceholder.textContent = petName;
  });

// Filter by type
function filterByType(select) {
  var type = select.value.toLowerCase();
  var rows = document.querySelectorAll('#animalTable tbody tr');
  rows.forEach(function(row) {
    var rowType = row.getAttribute('data-type').toLowerCase();
    row.style.display = (type === 'all' || rowType === type) ? '' : 'none';
  });
}
</script>
