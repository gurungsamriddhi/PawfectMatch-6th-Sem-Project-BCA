<?php include 'app/views/partials/header.php'; ?>
<div class="d-flex" style="min-height: 100vh; background: linear-gradient(120deg, #f6f8fd, #e3efff);">
  <?php include 'app/views/partials/sidebaruser.php'; ?>
  <div class="flex-grow-1 p-4" style="background: #E2E9E8;">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="fw-bold" style="color:#436C5D;">Profile</h3>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-7">
        <div class="card shadow-sm mb-4">
          <div class="card-header bg-primary text-white" style="background:#436C5D !important;">Edit Profile</div>
          <div class="card-body">
            <?php if (!empty($profile_success)): ?>
              <div class="alert alert-success"> <?= htmlspecialchars($profile_success) ?> </div>
            <?php endif; ?>
            <?php if (!empty($profile_error)): ?>
              <div class="alert alert-danger"> <?= htmlspecialchars($profile_error) ?> </div>
            <?php endif; ?>
            <form method="POST" action="index.php?page=update_profile" autocomplete="off">
              <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" required>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
              </div>
              <hr>
              <h6 class="fw-bold mb-3" style="color:#436C5D;">Change Password</h6>
              <div class="mb-3">
                <label for="current_password" class="form-label">Current Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Enter current password" required>
              </div>
              <div class="mb-3">
                <label for="new_password" class="form-label">New Password</label>
                <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Leave blank to keep current password">
              </div>
              <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm New Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm new password">
              </div>
              <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="showPasswords" onclick="toggleProfilePasswords()">
                <label for="showPasswords" class="form-check-label">Show Passwords</label>
              </div>
              <button type="submit" class="btn btn-primary w-100" style="background:#436C5D; border:none;">Update Profile</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
function toggleProfilePasswords() {
  const ids = ["current_password", "new_password", "confirm_password"];
  ids.forEach(id => {
    const el = document.getElementById(id);
    if (el) el.type = el.type === "password" ? "text" : "password";
  });
}
</script>
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