<?php include 'app/views/partials/sidebarcenter.php'; ?>
<!-- Main Content -->
<div class="body-wrapper w-100">
  <!-- Header -->
  <header class="app-header bg-dark text-white py-3 px-4">
    <div class="d-flex justify-content-between align-items-center">
      <h5 class="text-center w-100 m-0">My Profile</h5>
    </div>
  </header>

  <div class="container my-5">
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

        <!-- Center Name -->
        <div class="mb-3">
          <label for="centerName" class="form-label fw-semibold">
            <i class="fas fa-building me-2 text-success"></i>Center Name
          </label>
          <input type="text" id="centerName" name="name" class="form-control rounded-pill"
                 value="<?= htmlspecialchars($center['name'] ?? '') ?>" required>
        </div>

        <!-- Established Date -->
        <div class="mb-3">
          <label for="establishedDate" class="form-label fw-semibold">
            <i class="fas fa-calendar-alt me-2 text-success"></i>Established Date
          </label>
          <input type="date" id="establishedDate" name="established_date" class="form-control rounded-pill"
                 value="<?= htmlspecialchars($center['established_date'] ?? '') ?>" required>
        </div>

        <!-- Location -->
        <div class="mb-3">
          <label for="location" class="form-label fw-semibold">
            <i class="fas fa-map-marker-alt me-2 text-success"></i>Location
          </label>
          <input type="text" id="location" name="location" class="form-control rounded-pill"
                 value="<?= htmlspecialchars($center['location'] ?? '') ?>" required>
        </div>

        <!-- Phone -->
        <div class="mb-3">
          <label for="phone" class="form-label fw-semibold">
            <i class="fas fa-phone me-2 text-success"></i>Contact Number
          </label>
          <input type="text" id="phone" name="phone" class="form-control rounded-pill"
                 value="<?= htmlspecialchars($center['phone'] ?? '') ?>">
        </div>

        <!-- Number of Employees -->
        <div class="mb-3">
          <label for="employees" class="form-label fw-semibold">
            <i class="fas fa-users me-2 text-success"></i>Number of Employees
          </label>
          <input type="number" id="employees" name="number_of_employees" class="form-control rounded-pill"
                 value="<?= htmlspecialchars($center['number_of_employees'] ?? '') ?>" min="0" step="1">
        </div>

        <!-- Operating Hours -->
        <div class="mb-3">
          <label for="operatingHours" class="form-label fw-semibold">
            <i class="fas fa-clock me-2 text-success"></i>Operating Hours
          </label>
          <input type="text" id="operatingHours" name="operating_hours" class="form-control rounded-pill"
                 value="<?= htmlspecialchars($center['operating_hours'] ?? '') ?>" placeholder="e.g., Mon-Fri 9am - 6pm">
        </div>

        <!-- Description / About Us -->
        <div class="mb-3">
          <label for="description" class="form-label fw-semibold">
            <i class="fas fa-info-circle me-2 text-success"></i>About Us
          </label>
          <textarea id="description" name="description" rows="4" class="form-control rounded-3"><?= htmlspecialchars($center['description'] ?? '') ?></textarea>
        </div>

        <div class="d-flex justify-content-between mt-4">
  <button type="submit" name="update_profile" class="btn btn-primary">
    <i class="fas fa-save me-2"></i>Update Profile
  </button>
</div>
      </form>
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
</script>
