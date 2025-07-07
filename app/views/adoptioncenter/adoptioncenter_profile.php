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
        <h4 class="fw-bold mb-1">Happy Paws Shelter</h4>
      </div>

      <!-- Logo centered -->
      <div class="text-center mb-4">
        <div class="rounded-circle overflow-hidden border border-success mx-auto mb-3" 
             style="width: 150px; height: 150px; background: #e9ecef;">
          <img id="logoPreview" src="public/assets/images/Pawfectmatch-about.png" alt="Current Logo" 
               class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        <label for="logoUpload" class="btn btn-outline-success rounded-pill px-4">
          <i class="fas fa-upload me-2"></i> Upload New Logo
        </label>
        <input id="logoUpload" type="file" name="logo" accept="image/*" class="d-none" onchange="previewLogo(event)">
      </div>

      <form method="POST" action="index.php?page=adoptioncenter/update_profile" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="centerName" class="form-label fw-semibold">
            <i class="fas fa-building me-2 text-success"></i>Center Name
          </label>
          <input type="text" id="centerName" name="name" class="form-control rounded-pill" value="Happy Paws Shelter" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label fw-semibold">
            <i class="fas fa-envelope me-2 text-success"></i>Email
          </label>
          <input type="email" id="email" name="email" class="form-control rounded-pill" value="happypaws@gmail.com" required>
        </div>
        <div class="mb-3">
          <label for="phone" class="form-label fw-semibold">
            <i class="fas fa-phone me-2 text-success"></i>Contact Number
          </label>
          <input type="text" id="phone" name="phone" class="form-control rounded-pill" value="+977 9800000000">
        </div>
        <div class="mb-3">
          <label for="address" class="form-label fw-semibold">
            <i class="fas fa-map-marker-alt me-2 text-success"></i>Address
          </label>
          <input type="text" id="address" name="address" class="form-control rounded-pill" value="Kathmandu, Nepal">
        </div>
        <div class="mb-3">
          <label for="description" class="form-label fw-semibold">
            <i class="fas fa-info-circle me-2 text-success"></i>About Us
          </label>
          <textarea id="description" name="description" rows="4" class="form-control rounded-3">We rescue and rehome stray animals.</textarea>
        </div>

        <div class="d-flex justify-content-between mt-4">
          <a href="index.php?page=change_password" class="btn btn-outline-secondary rounded-pill">
            <i class="fas fa-lock me-2"></i>Change Password
          </a>
          <button type="submit" class="btn btn-success rounded-pill">
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
