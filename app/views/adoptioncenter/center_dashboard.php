<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Adoption Center Dashboard - PawfectMatch</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="/PawfectMatch/public/assets/css/dashboard.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

  <!-- Bootstrap JS Bundle (includes Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
  <div class="page-wrapper d-flex">
    <!-- Sidebar -->
    <aside class="left-sidebar d-flex flex-column">
      <div class="brand-logo text-center py-3 sticky-top" style="z-index: 2;">
        <h2 class="m-0">PawfectMatch</h2>
      </div>

      <!-- Scrollable Sidebar Nav -->
      <nav class="sidebar-nav flex-grow-1 overflow-y-auto">
        <ul class="list-unstyled px-2">
          <li class="sidebar-item selected">
            <a href="#" class="sidebar-link active"><i class="fas fa-home me-2"></i> Dashboard</a>
          </li>
          <li class="sidebar-item">
            <a href="#" class="sidebar-link"><i class="fas fa-user me-2"></i> My Profile</a>
          </li>
          <li class="sidebar-item has-submenu">
        <a href="#" class="sidebar-link has-arrow" data-toggle="submenu"><i class="fas fa-paw me-2"></i> Pet Management</a>
        <ul class="first-level list-unstyled ps-3">
          <li class="sidebar-item"><a href="#" class="sidebar-link"><i class="fa-solid fa-clipboard-list me-2"></i>All Pets</a></li>
          <li class="sidebar-item"><a href="#" class="sidebar-link"><i class="fa-solid fa-plus me-2"></i>Add New Pet</a></li>
        </ul>
      </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link"><i class="fas fa-envelope-open-text me-2"></i>Message Requests</a>
              </li>
          <li class="sidebar-item">
            <a href="#" class="sidebar-link" data-bs-toggle="modal" data-bs-target="#logoutModal">
              <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
          </li>
        </ul>
      </nav>
    </aside>
    <script>
// Sidebar submenu toggle logic
  document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.sidebar-link.has-arrow').forEach(function(link) {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        var parent = link.closest('.sidebar-item');
        parent.classList.toggle('open');
      });
    });
  });
</script> 

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
          <a href="http://localhost/PawfectMatch/index.php?page=home" class="btn btn-danger">Logout</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
