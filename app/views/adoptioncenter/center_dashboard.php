

<?php include 'app/views/partials/sidebarcenter.php'; ?>
    <!-- Main Content -->
    <div class="body-wrapper w-100">
      <!-- Header -->
      <header class="app-header bg-dark text-white py-3 px-4">
        <div class="d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Welcome, Admin</h5>
          <div class="d-flex align-items-center gap-3">
            <i class="fas fa-bell"></i>
            <i class="fas fa-user-circle"></i>
          </div>
        </div>
      </header>

      <!-- Content -->
      <div class="container-fluid py-4">
        <div class="row g-4">
          <div class="col-md-4">
            <div class="card shadow-sm p-3 text-center">
              <h5>Total Pets Listed</h5>
              <h2>35</h2>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card shadow-sm p-3 text-center">
              <h5>Pets Adopted</h5>
              <h2>12</h2>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card shadow-sm p-3 text-center">
              <h5>Pending Requests</h5>
              <h2>6</h2>
            </div>
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
</body>
</html>
