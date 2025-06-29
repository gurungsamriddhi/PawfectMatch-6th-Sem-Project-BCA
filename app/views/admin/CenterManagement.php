<?php include 'app/views/partials/sidebar.php'; ?>
<!-- Main Content -->
<div class="body-wrapper w-100">
  <!-- Header -->
  <header class="app-header bg-dark text-white py-3 px-4">
    <div class="d-flex justify-content-between align-items-center">
      <h5 class="mb-0">All Adoption Centers</h5>
      <div class="d-flex align-items-center gap-3">
        <i class="fas fa-bell"></i>
        <i class="fas fa-user-circle"></i>
      </div>
    </div>
  </header>
  <!-- Content -->
  <div class="container-fluid py-4">
    <div class="top-actions">
      <a href="index.php?page=admin/add_centerform" class="add-btn"><i class="fa-solid fa-plus"></i> Add Adoption Center</a>
      <div class="filter-group">
        <label for="typeFilter"><i class="fa-solid fa-folder-open"></i> Filter by Location:</label>
        <select class="filter" id="typeFilter" onchange="filterByType(this)">
          <option value="All">All</option>
          <option value="Pokhara">Pokhara</option>
          <option value="Kathmandu">Kathmandu</option>
          <option value="Chitwan">Chitwan</option>
          <option value="Tanahun">Tanahun</option>
        </select>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table view-table" id="centerTable">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Status</th>
            <th>user_type</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($centers as $center): ?>
            <tr>
              <td><?= htmlspecialchars($center['name']) ?></td>
              <td><?= htmlspecialchars($center['email']) ?></td>
              <td>
                <?php if ($center['status'] === 'active'): ?>
                  <span class="status-badge status-active">Active</span>
                <?php else: ?>
                  <span class="status-badge status-inactive"><?= htmlspecialchars(ucfirst($center['status'])) ?></span>
                <?php endif; ?>
              </td>
              <td><?= htmlspecialchars($center['user_type']) ?></td>
              <td>
                <div class="action-buttons">

                  <button type="button"
                    class="view-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#viewCenterModal"
                    data-userid="<?= $center['user_id'] ?>">
                    <i class="fa-solid fa-eye"></i> View
                  </button>

                  <!-- Edit Button -->
                  <button type="button"
                    class="edit-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#editCenterModal"
                    data-userid="<?= $center['user_id'] ?>">
                    <i class="fa-solid fa-pen"></i> Edit
                  </button>

                  <!-- Reset Password Button -->
                  <button type="button"
                    class="reset-btn"
                    data-userid="<?= $center['user_id'] ?>">
                    <i class="fa-solid fa-key"></i> Reset Password
                  </button>

                  <!-- Delete Button -->
                  <button type="button"
                    class="delete-btn"
                    data-userid="<?= $center['user_id'] ?>">
                    <i class="fa-solid fa-trash"></i> Delete
                  </button>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
    </div>

<!--view modal-->
<div class="modal fade" id="viewCenterModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Adoption Center Details</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
      <div class="modal-body">
        <!-- Content filled via AJAX -->
        
      </div>
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
  </div>
<?php include 'app/views/partials/admin_footer.php'; ?>

