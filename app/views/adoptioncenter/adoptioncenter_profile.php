<?php include 'app/views/adoptioncenter/centerpartials/sidebarcenter.php'; ?>
<!-- Main Content -->
<div class="body-wrapper w-100">
  <!-- Header -->
  <header class="app-header bg-dark text-white py-3 px-4">
    <div class="d-flex justify-content-between align-items-center">
      <h5 class="text-center w-100 m-0">My Profile</h5>
    </div>
  </header>

  <div class="container my-5">
    <?php if (!empty($_SESSION['success'])): ?>
      <div class="alert alert-success text-center fw-semibold">
        <?= htmlspecialchars($_SESSION['success']) ?>
      </div>
      <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
      <div class="alert alert-danger text-center fw-semibold">
        <?= htmlspecialchars($_SESSION['error']) ?>
      </div>
      <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="card shadow rounded-4 p-5" style="max-width: 600px; margin: auto; background-color: white;">
      <!-- Profile Section -->
      <div class="text-center mb-4">
        <h4 class="fw-bold mb-1"><?= htmlspecialchars($center['name'] ?? 'Adoption Center') ?></h4>
      </div>

      <!-- Logo centered -->
      <div class="text-center mb-4">
        <div class="rounded-circle overflow-hidden border border-success mx-auto mb-3"
             style="width: 150px; height: 150px; background: #e9ecef;">
          <img id="logoPreview"
               src="<?= !empty($center['logo_path']) ? htmlspecialchars($center['logo_path']) : 'public/assets/images/Pawfectmatch-about.png' ?>"
               alt="Current Logo"
               class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        <label for="logoUpload" class="btn btn-outline-success rounded-pill px-4">
          <i class="fas fa-upload me-2"></i> Upload New Logo
        </label>
        <input id="logoUpload" type="file" name="logo" accept="image/*" class="d-none" onchange="previewLogo(event)">
      </div>

      <form action="index.php?page=adoptioncenter/update_profile" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="centerName" class="form-label fw-semibold">
            <i class="fas fa-building me-2 text-success"></i>Center Name
          </label>
          <input type="text" id="centerName" name="name" class="form-control rounded-pill"
                 value="<?= htmlspecialchars($center['name'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
          <label for="establishedDate" class="form-label fw-semibold">
            <i class="fas fa-calendar-alt me-2 text-success"></i>Established Date
          </label>
          <input type="date" id="establishedDate" name="established_date" class="form-control rounded-pill"
                 value="<?= htmlspecialchars($center['established_date'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
          <label for="location" class="form-label fw-semibold">
            <i class="fas fa-map-marker-alt me-2 text-success"></i>Location
          </label>
          <input type="text" id="location" name="location" class="form-control rounded-pill"
                 value="<?= htmlspecialchars($center['location'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
          <label for="phone" class="form-label fw-semibold">
            <i class="fas fa-phone me-2 text-success"></i>Contact Number
          </label>
          <input type="text" id="phone" name="phone" class="form-control rounded-pill"
                 value="<?= htmlspecialchars($center['phone'] ?? '') ?>">
        </div>

        <div class="mb-3">
          <label for="employees" class="form-label fw-semibold">
            <i class="fas fa-users me-2 text-success"></i>Number of Employees
          </label>
          <input type="number" id="employees" name="number_of_employees" class="form-control rounded-pill"
                 value="<?= htmlspecialchars($center['number_of_employees'] ?? '') ?>" min="0" step="1">
        </div>

        <div class="mb-3">
          <label for="operatingHours" class="form-label fw-semibold">
            <i class="fas fa-clock me-2 text-success"></i>Operating Hours
          </label>
          <input type="text" id="operatingHours" name="operating_hours" class="form-control rounded-pill"
                 value="<?= htmlspecialchars($center['operating_hours'] ?? '') ?>" placeholder="e.g., Mon-Fri 9am - 6pm">
        </div>

        <div class="mb-3">
          <label for="description" class="form-label fw-semibold">
            <i class="fas fa-info-circle me-2 text-success"></i>About Us
          </label>
          <textarea id="description" name="description" rows="4" class="form-control rounded-3"><?= htmlspecialchars($center['description'] ?? '') ?></textarea>
        </div>

        <div class="d-flex justify-content-between mt-4">
          <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
            <i class="fas fa-key me-2"></i>Change Password
          </button>

          <button type="submit" name="update_profile" class="btn btn-primary">
            <i class="fas fa-save me-2"></i>Update Profile
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow rounded-4 p-3">

      <!-- Modal Header -->
      <div class="text-center mt-3">
        <h4 class="fw-bold text-success mb-1"><i class="fas fa-lock me-2"></i>Change Password</h4>
        <p class="text-muted small mb-0">Update your account password securely</p>
      </div>
      <!-- Modal Body -->
      <form action="index.php?page=adoptioncenter/change_password" method="POST" class="px-4 pt-3">

        <!-- Old Password -->
        <div class="mb-3">
          <label for="oldPassword" class="form-label fw-semibold">Old Password</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-key"></i></span>
            <input type="password" class="form-control" name="old_password" id="oldPassword" required>
          </div>
        </div>

        <!-- New Password -->
        <div class="mb-3">
          <label for="newPassword" class="form-label fw-semibold">New Password</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" class="form-control" name="new_password" id="newPassword" required>
          </div>
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
          <label for="confirmPassword" class="form-label fw-semibold">Confirm Password</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" class="form-control" name="confirm_password" id="confirmPassword" required>
          </div>
        </div>

        <!-- Show Password Checkbox -->
        <div class="form-check mb-3">
          <input type="checkbox" class="form-check-input" id="showChangePassword">
          <label class="form-check-label" for="showChangePassword">Show Passwords</label>
        </div>

        <!-- Submit Button -->
        <div class="mb-3">
          <button type="submit" name="change_password" class="btn btn-success w-100 fw-semibold">
            <i class="fas fa-save me-2"></i>Change Password
          </button>
        </div>
      </form>

      <!-- Modal Close Button -->
      <div class="text-center pb-3">
        <button type="button" class="btn btn-link text-muted" data-bs-dismiss="modal">Cancel</button>
      </div>

    </div>
  </div>
</div>




<script>
  function previewLogo(event) {
    const [file] = event.target.files;
    if (file) {
      const preview = document.getElementById('logoPreview');
      preview.src = URL.createObjectURL(file);
    }
  }
   document.getElementById('showChangePassword').addEventListener('change', function () {
    const fields = ['oldPassword', 'newPassword', 'confirmPassword'];
    fields.forEach(id => {
      const input = document.getElementById(id);
      input.type = this.checked ? 'text' : 'password';
    });
  });
  document.querySelector('form[action*="change_password"]').addEventListener('submit', function (e) {
  const newPassword = document.getElementById('newPassword').value;
  const confirmPassword = document.getElementById('confirmPassword').value;

  const strongRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

  if (!strongRegex.test(newPassword)) {
    alert("New password must be at least 8 characters long and include an uppercase letter, a number, and a special character.");
    e.preventDefault();
  } else if (newPassword !== confirmPassword) {
    alert("New and Confirm Password do not match.");
    e.preventDefault();
  }
});
</script>
