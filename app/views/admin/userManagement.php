<?php include 'app/views/partials/sidebar.php'; ?>
<!-- Main Content -->
<div class="body-wrapper w-100">
  <!-- Header -->
  <header class="app-header bg-dark text-white py-3 px-4">
    <div class="d-flex justify-content-between align-items-user">
      <h5 class="mb-0">All Users</h5>
      <div class="d-flex align-items-user gap-3">
        <i class="fas fa-bell"></i>
        <i class="fas fa-user-circle"></i>
      </div>
    </div>
  </header>
  <!-- Content -->
  <div class="container-fluid py-4">
    <div class="top-actions">

      <div class="filter-group">
        <label for="typeFilter"><i class="fa-solid fa-folder-open"></i> Filter by username:</label>
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
      <table class="table view-table" id="userTable">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Status</th>
            <th>User Type</th>
            <th>Is Verified</th>
            <th>Registered At</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($users as $user): ?>
            <tr>
              <td><?= htmlspecialchars($user['name']) ?></td>
              <td><?= htmlspecialchars($user['email']) ?></td>
              <td>
                <?php if ($user['status'] === 'active'): ?>
                  <span class="status-badge status-active">Active</span>
                <?php elseif ($user['status'] === 'inactive'): ?>
                  <span class="status-badge status-inactive">Inactive</span>
                <?php elseif ($user['status'] === 'suspended'): ?>
                  <span class="status-badge status-suspended">Suspended</span>
                <?php elseif ($user['status'] === 'pending'): ?>
                  <span class="status-badge status-pending">Pending</span>
                <?php elseif ($user['status'] === 'deleted'): ?>
                  <span class="status-badge status-deleted">Deleted</span>
                <?php endif; ?>
              </td>
              <td><?= htmlspecialchars($user['user_type']) ?></td>

              <td>
                <?php if ($user['is_verified'] === 1): ?>
                  <span class="status-badge status-active">Verified</span>
                <?php else: ?>
                  <span class="status-badge status-inactive">Not Verified</span>
                <?php endif; ?>

              </td>
              <td><?= htmlspecialchars($user['registered_at']) ?></td>
              <td>
                <div class="action-buttons">
                  <button type="button"
                    class=" view-btn "
                    data-action="view"
                    data-bs-toggle="modal"
                    data-bs-target="#viewuserModal"
                    data-userid="<?= $user['user_id'] ?>">
                    <i class="fa-solid fa-eye"></i> View
                  </button>

                  <!--Edit Button
                  <button type="button"
                    class="edit-btn  "
                    data-action="edit"
                    data-bs-toggle="modal"
                    data-bs-target="#edituserModal"
                    data-userid=<= $user['user_id'] ?>">
                    <i class="fa-solid fa-pen"></i> Edit
                  </button>-->

                  <!-- Suspend Button -->
                  <button type="button"
                    class=" suspend-btn "
                    data-action="suspend"
                    data-userid="<?= $user['user_id'] ?>">
                    <i class="fa-solid fa-exclamation"></i> Suspend
                  </button>

                  <!-- Delete Button -->
                  <button type="button"
                    class=" delete-btn "
                    data-action="delete"
                    data-userid="<?= $user['user_id'] ?>">
                    <i class="fa-solid fa-trash"></i> Delete
                  </button>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
    </div>

    <!--view modal-->
    <div class="modal fade" id="viewuserModal" tabindex="-1" aria-labelledby="viewLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">User Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <!-- Content filled via AJAX -->

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
            Are you sure you want to delete this user? This action cannot be undone.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn " data-bs-dismiss="modal">Cancel</button>
            <button type="button" id="confirmDeleteBtn" class="btn btn-secondary">Delete</button>
          </div>
        </div>
      </div>
    </div>


    <?php include 'app/views/partials/admin_footer.php'; ?>