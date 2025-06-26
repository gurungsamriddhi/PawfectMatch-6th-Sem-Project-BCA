<?php include 'sidebar.php'; ?>

<!-- CSS Links -->
<link rel="stylesheet" href="/animal_adoption/pawfectmatch/public/assets/css/adoptioncenter.css" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<!-- Main Content Area -->
<div class="body-wrapper">
  <div class="card shadow-sm p-4">
    <h3 class="mb-4 text-success fw-bold">
      <i class="fas fa-plus-circle me-2"></i>Add New Pet
    </h3>

    <form method="POST" action="savepets.php" enctype="multipart/form-data">
      <div class="row g-4">
        <div class="col-md-6">
          <label class="form-label fw-semibold">Pet Name</label>
          <input type="text" class="form-control shadow-sm" name="name" placeholder="e.g., Bella" required>
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold">Type</label>
          <select class="form-select shadow-sm" name="type" required>
            <option value="">Select Type</option>
            <option>Dog</option>
            <option>Cat</option>
            <option>Rabbit</option>
            <option>Other</option>
          </select>
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold">Breed</label>
          <input type="text" class="form-control shadow-sm" name="breed" placeholder="e.g., Labrador">
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold">Age</label>
          <input type="text" class="form-control shadow-sm" name="age" placeholder="e.g., 2 years">
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold">Gender</label>
          <select class="form-select shadow-sm" name="gender" required>
            <option value="">Select</option>
            <option>Male</option>
            <option>Female</option>
          </select>
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold">Status</label>
          <select class="form-select shadow-sm" name="status">
            <option>Available</option>
            <option>Adopted</option>
          </select>
        </div>

        <div class="col-12">
          <label class="form-label fw-semibold">Upload Image</label>
          <input type="file" class="form-control shadow-sm" name="image" accept="image/*" required>
        </div>

        <div class="col-12">
          <label class="form-label fw-semibold">Description</label>
          <textarea class="form-control shadow-sm" name="description" rows="3" placeholder="Short description about the pet..."></textarea>
        </div>

        <div class="col-12 text-end">
          <button type="submit" class="btn btn-success px-4">
            <i class="fas fa-save me-2"></i>Save Pet
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
