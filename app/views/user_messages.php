<?php include 'app/views/partials/header.php'; ?>
<div class="d-flex" style="min-height: 100vh; background: linear-gradient(120deg, #f6f8fd, #e3efff);">
  <?php include 'app/views/partials/sidebaruser.php'; ?>
  <div class="flex-grow-1 p-4" style="background: #E2E9E8;">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="fw-bold" style="color:#436C5D;">Messages</h3>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="card shadow-sm mb-4">
          <div class="card-header bg-dark text-white">Admin Messages</div>
          <div class="card-body">
            <?php if (!empty($messages)): ?>
              <ul class="list-group">
                <?php foreach ($messages as $msg): ?>
                  <li class="list-group-item">
                    <?= htmlspecialchars($msg['content']) ?>
                    <span class="badge bg-info ms-2"><?= htmlspecialchars($msg['date']) ?></span>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php else: ?>
              <p>No messages from admin.</p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Logout Confirmation Modal (copied from admin panel) -->
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
        <a href="index.php?page=logout" class="btn btn-danger">Logout</a>
      </div>
    </div>
  </div>
</div> 