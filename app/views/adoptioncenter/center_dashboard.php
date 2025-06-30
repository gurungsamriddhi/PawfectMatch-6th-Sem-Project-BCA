<?php include 'app/views/partials/sidebarcenter.php'; ?>
<style>
  .summary-icon {
    font-size: 2.8rem !important;
    opacity: 0.85 !important;
  }

  .summary-card {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
  }
</style>

<!-- Main Content -->
<div class="body-wrapper w-100">
  <!-- Header -->
  <header class="app-header bg-dark text-white py-3 px-4">
    <div class="d-flex justify-content-between align-items-center">
      <h4 class="mb-0 fw-bold"><i class="fas fa-chart-pie me-2 text-primary"></i>Adoption Summary</h4>
      <div class="d-flex align-items-center gap-3">
        <a href="index.php?page=adoptioncenter/adoption_request" class="text-decoration-none me-3">
          <i class="fas fa-bell fs-5 text-white"></i>
        </a>
        <a href="index.php?page=adoptioncenter/adoptioncenter_profile" class="text-decoration-none">
          <i class="fas fa-user-circle fs-5 text-white"></i>
        </a>
      </div>
    </div>
  </header>

  <!-- Content -->
  <div class="row g-4 p-4">
    <div class="col-md-3 col-sm-6 d-flex">
      <div class="card summary-card border-primary shadow-sm p-3 w-100">
        <div class="d-flex align-items-center">
          <i class="fas fa-dog text-primary summary-icon me-3"></i>
          <div>
            <h5 class="mb-1">45</h5>
            <small class="text-muted">Pets Available</small>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 d-flex">
      <div class="card summary-card border-success shadow-sm p-3 w-100">
        <div class="d-flex align-items-center">
          <i class="fas fa-heart text-success summary-icon me-3"></i>
          <div>
            <h5 class="mb-1">30</h5>
            <small class="text-muted">Pets Adopted</small>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 d-flex">
      <div class="card summary-card border-warning shadow-sm p-3 w-100">
        <div class="d-flex align-items-center">
          <i class="fas fa-hourglass-half text-warning summary-icon me-3"></i>
          <div>
            <h5 class="mb-1">8</h5>
            <small class="text-muted">Pending Requests</small>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 d-flex">
      <div class="card summary-card border-danger shadow-sm p-3 w-100">
        <div class="d-flex align-items-center">
          <i class="fas fa-times-circle text-danger summary-icon me-3"></i>
          <div>
            <h5 class="mb-1">3</h5>
            <small class="text-muted">Rejected Requests</small>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 d-flex">
      <div class="card summary-card border-info shadow-sm p-3 w-100">
        <div class="d-flex align-items-center">
          <i class="fas fa-calendar-alt text-info summary-icon me-3"></i>
          <div>
            <h5 class="mb-1">5</h5>
            <small class="text-muted">New Requests</small>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 d-flex">
      <div class="card summary-card border-secondary shadow-sm p-3 w-100">
        <div class="d-flex align-items-center">
          <i class="fas fa-paw text-secondary summary-icon me-3"></i>
          <div>
            <h5 class="mb-1">Labrador</h5>
            <small class="text-muted">Most Popular Breed</small>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 d-flex">
      <div class="card summary-card border-success shadow-sm p-3 w-100">
        <div class="d-flex align-items-center">
          <i class="fas fa-clock text-success summary-icon me-3"></i>
          <div>
            <h5 class="mb-1">12 Days</h5>
            <small class="text-muted">Average Adoption Time</small>
          </div>
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
          <a href="index.php?page=home" class="btn btn-danger">Logout</a>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
