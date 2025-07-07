<?php include 'app/views/partials/sidebarcenter.php'; ?>
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
    <div class="top-actions">
      <a href="index.php?page=adoptioncenter/add_pets" class="add-btn"><i class="fa-solid fa-plus"></i> Add Pet</a>
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
            <th>Adoption Center</th>
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
      <td><?= htmlspecialchars($pet['adoption_center_name'] ?? 'N/A') ?></td>
      <td><?= htmlspecialchars($pet['posted_by_name'] ?? $pet['posted_by'] ?? 'N/A') ?></td>
      <td><?= htmlspecialchars($pet['description']) ?></td>
      <td><?= htmlspecialchars($pet['health_status']) ?></td>
      <td>
        <div class="action-buttons">
          <a href="#" 
             class="edit-btn btn btn-sm btn-primary"
             data-name="<?= htmlspecialchars($pet['name']) ?>"
             data-type="<?= htmlspecialchars($pet['type']) ?>"
             data-breed="<?= htmlspecialchars($pet['breed']) ?>"
             data-age="<?= htmlspecialchars($pet['age']) ?>"
             data-gender="<?= htmlspecialchars($pet['gender']) ?>"
             data-status="<?= htmlspecialchars($pet['status']) ?>"
             data-description="<?= htmlspecialchars($pet['description']) ?>"
             data-health="<?= htmlspecialchars($pet['health_status']) ?>"
             data-adoptioncenter="<?= htmlspecialchars($pet['adoption_center_name'] ?? '') ?>"
             data-postedby="<?= htmlspecialchars($pet['posted_by_name'] ?? '') ?>"
          >
            <i class="fa-solid fa-pen"></i> Edit
          </a>
          <button class="btn btn-sm btn-danger delete-btn" data-id="<?= $pet['pet_id'] ?>">
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
      <form id="editPetForm">
        <div class="modal-header">
          <h5 class="modal-title" id="editPetModalLabel"><i class="fa-solid fa-pen-to-square me-2"></i>Edit Pet Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <!-- All form inputs as you had -->
            <!-- Keeping your existing form inputs here as-is -->
            <div class="col-md-6">
              <label class="form-label">Pet Name *</label>
              <input type="text" class="form-control" id="editPetName" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Type *</label>
              <select class="form-select" id="editPetType" required>
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
              <label class="form-label">Breed *</label>
              <input type="text" class="form-control" id="editBreed" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Gender *</label>
              <select class="form-select" id="editGender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Age (in years) *</label>
              <input type="number" class="form-control" id="editAge" min="0" step="0.1" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Date of Arrival *</label>
              <input type="date" class="form-control" id="editDateArrival" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Size *</label>
              <select class="form-select" id="editSize" required>
                <option value="Small">Small</option>
                <option value="Medium">Medium</option>
                <option value="Large">Large</option>
                <option value="Extra Large">Extra Large</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Weight (kg) *</label>
              <input type="number" class="form-control" id="editWeight" min="0" step="0.1" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Color *</label>
              <input type="text" class="form-control" id="editColor" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Health Status *</label>
              <select class="form-select" id="editHealthStatus" required>
                <option value="Excellent">Excellent</option>
                <option value="Good">Good</option>
                <option value="Fair">Fair</option>
                <option value="Poor">Poor</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label">Description *</label>
              <textarea class="form-control" id="editDescription" rows="2" required></textarea>
            </div>
            <div class="col-12">
              <label class="form-label">Adoption Center Name *</label>
              <input type="text" class="form-control" id="editAdoptionCenter" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Contact Person Name *</label>
              <input type="text" class="form-control" id="editContactName" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Contact Phone *</label>
              <input type="tel" class="form-control" id="editContactPhone" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Contact Email *</label>
              <input type="email" class="form-control" id="editContactEmail" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Center Address *</label>
              <input type="text" class="form-control" id="editCenterAddress" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Center Website (Optional)</label>
              <input type="url" class="form-control" id="editCenterWebsite">
            </div>
            <div class="col-12">
              <label class="form-label">Adoption Process Notes</label>
              <textarea class="form-control" id="editAdoptionNotes" rows="2"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save me-2"></i>Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this pet?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Delete</a>
      </div>
    </div>
  </div>
</div>

<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to log out?
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <a href="http://localhost/PawfectMatch/index.php?page=" class="btn btn-danger">Logout</a>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Sidebar submenu toggle logic
    document.querySelectorAll('.sidebar-link.has-arrow').forEach(function(link) {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        var parent = link.closest('.sidebar-item');
        parent.classList.toggle('open');
      });
    });

    document.querySelectorAll('.first-level .sidebar-link').forEach(function(link) {
      link.addEventListener('click', function(e) {
        var parent = link.closest('.sidebar-item');
        parent.classList.add('open');
      });
    });

    // Delete button logic
    document.querySelectorAll('.delete-btn').forEach(btn => {
      btn.addEventListener('click', function () {
        const petId = this.getAttribute('data-id');
        const deleteUrl = `index.php?page=adoptioncenter/deletepet&pet_id=${petId}`;
        document.getElementById('confirmDeleteBtn').setAttribute('href', deleteUrl);
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
      });
    });

    // Edit Pet Modal Logic (UI only)
    const editBtns = document.querySelectorAll('.edit-btn');
    const editPetForm = document.getElementById('editPetForm');
    let currentEditRow = null;

    editBtns.forEach(btn => {
      btn.addEventListener('click', function(e) {
        e.preventDefault();

        currentEditRow = btn.closest('tr');  // assign row being edited

        document.getElementById('editPetName').value = btn.dataset.name || '';
        document.getElementById('editPetType').value = btn.dataset.type || '';
        document.getElementById('editBreed').value = btn.dataset.breed || '';
        document.getElementById('editAge').value = btn.dataset.age || '';
        document.getElementById('editGender').value = btn.dataset.gender || '';
        document.getElementById('editDescription').value = btn.dataset.description || '';
        document.getElementById('editAdoptionCenter').value = btn.dataset.adoptioncenter || '';
        document.getElementById('editHealthStatus').value = btn.dataset.health || '';
        document.getElementById('editDateArrival').value = btn.dataset.datearrival || '';
        document.getElementById('editSize').value = btn.dataset.size || '';
        document.getElementById('editWeight').value = btn.dataset.weight || '';
        document.getElementById('editColor').value = btn.dataset.color || '';
        document.getElementById('editContactName').value = btn.dataset.contactname || '';
        document.getElementById('editContactPhone').value = btn.dataset.contactphone || '';
        document.getElementById('editContactEmail').value = btn.dataset.contactemail || '';
        document.getElementById('editCenterAddress').value = btn.dataset.centeraddress || '';
        document.getElementById('editCenterWebsite').value = btn.dataset.centerwebsite || '';
        document.getElementById('editAdoptionNotes').value = btn.dataset.adoptionnotes || '';

        const modal = new bootstrap.Modal(document.getElementById('editPetModal'));
        modal.show();
      });
    });

    editPetForm.addEventListener('submit', function(e) {
      e.preventDefault();
      if (currentEditRow) {
        currentEditRow.children[0].textContent = document.getElementById('editPetName').value.trim();
        currentEditRow.children[1].textContent = document.getElementById('editPetType').value.trim();
        currentEditRow.children[2].textContent = document.getElementById('editBreed').value.trim();
        currentEditRow.children[3].textContent = document.getElementById('editAge').value.trim();
        currentEditRow.children[4].textContent = document.getElementById('editGender').value.trim();
        currentEditRow.children[6].textContent = document.getElementById('editAdoptionCenter').value.trim();
        currentEditRow.children[7].textContent = ''; // posted_by, you may update accordingly
        currentEditRow.children[8].textContent = document.getElementById('editDescription').value.trim();
        currentEditRow.children[9].textContent = document.getElementById('editHealthStatus').value.trim();
      }
      var modal = bootstrap.Modal.getInstance(document.getElementById('editPetModal'));
      modal.hide();
    });

  });

  // Filter by type
 function filterByType(select) {
  var type = select.value.toLowerCase();  // convert selected value to lowercase
  var rows = document.querySelectorAll('#animalTable tbody tr');
  rows.forEach(function(row) {
    var rowType = row.getAttribute('data-type').toLowerCase();  // convert row data-type to lowercase
    if (type === 'all' || rowType === type) {
      row.style.display = '';
    } else {
      row.style.display = 'none';
    }
  });
}

</script>
</body>
</html>
