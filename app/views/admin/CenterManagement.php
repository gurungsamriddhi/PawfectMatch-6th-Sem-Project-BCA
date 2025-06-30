<?php include 'app/views/partials/sidebar.php'; ?>
<!-- Main Content -->
<div class="body-wrapper w-100">
  <!-- Header -->
  <header class="app-header bg-dark text-white py-3 px-4">
    <div class="d-flex justify-content-between align-items-center">
      <h5 class="mb-0">All Adoption Centers</h5>
      <div class="d-flex align-items-center gap-3">
        <i class="fas fa-bell"></i>
        <i class="fas fa-center-circle"></i>
      </div>
    </div>
  </header>
  <!-- Content -->
  <div class="container-fluid py-4">
    <div class="top-actions">
      <a href="index.php?page=admin/add_centerform" class="add-btn"><i class="fa-solid fa-plus"></i> Add Adoption Center</a>
      <div class="filter-group">
        <label for="typeFilter"><i class="fa-solid fa-folder-open"></i> Filter by centername:</label>
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
            <th>center Type</th>
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
                <?php elseif ($center['status']==='inactive'): ?>
                  <span class="status-badge status-inactive">Inactive</span>
                    <?php elseif ($center['status']==='suspended'):?>
                    <span class ="status-badge status-suspended">Suspended</span>
                  <?php elseif ($center['status']==='deleted'):?>
                    <span class ="status-badge status-deleted">Deleted</span>
                <?php endif; ?>
              </td>
              <td><?= htmlspecialchars($center['user_type']) ?></td>
              <td>

                <div class="action-buttons">
                  <button type="button"
                    class=" view-btn "
                    data-action="view"
                    data-bs-toggle="modal"
                    data-bs-target="#viewCenterModal"
                    data-userid="<?= $center['user_id'] ?>">
                    <i class="fa-solid fa-eye"></i> View
                  </button>

                  <!-- Edit Button -->
                  <button type="button"
                    class="edit-btn  "
                    data-action="edit"
                    data-bs-toggle="modal"
                    data-bs-target="#editCenterModal"
                    data-userid="<?= $center['user_id'] ?>">
                    <i class="fa-solid fa-pen"></i> Edit
                  </button>

                  <!-- Reset Password Button -->
                  <button type="button"
                    class=" reset-btn "
                    data-action="reset"
                    data-userid="<?= $center['user_id'] ?>">
                    <i class="fa-solid fa-key"></i> Reset Password
                  </button>

                  <!-- Delete Button -->
                  <button type="button"
                    class=" delete-btn "
                    data-action="delete"
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
    <div class="modal fade" id="viewCenterModal" tabindex="-1" aria-labelledby="viewLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Adoption Center Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <!-- Content filled via AJAX -->

          </div>
        </div>
      </div>
    </div>

<!-- Edit Modal -->
<div class="modal fade" id="editCenterModal" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Edit Center center</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="editCenterContent">
        <div id="edit-error-msg"></div> 
        <!-- AJAX response will be loaded here -->
      </div>
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title">Confirm Delete</h5>
        <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this center? This action cannot be undone.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn " data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="confirmDeleteBtn" class="btn btn-secondary">Delete</button>
      </div>
    </div>
  </div>
</div>

    
  <?php include 'app/views/partials/admin_footer.php'; ?>