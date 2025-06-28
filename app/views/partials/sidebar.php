<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard - PawfectMatch</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="/PawfectMatch/public/assets/css/dashboard.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
<link rel="stylesheet" href="/PawfectMatch/public/assets/css/addpet.css" />
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
      <nav class="sidebar-nav flex-grow-1 overflow-y-auto">
        <ul class="list-unstyled px-2">
          <li class="sidebar-item">
            <a href="index.php?page=admin/admin_dashboard" class="sidebar-link"><i class="fas fa-home me-2"></i> Dashboard</a>
          </li>
          <li class="sidebar-item has-submenu">
            <a href="#" class="sidebar-link has-arrow active" data-toggle="submenu"><i class="fas fa-paw me-2"></i> Pet Management</a>
            <ul class="first-level list-unstyled ps-3">
              <li class="sidebar-item"><a href="index.php?page=admin/PetManagement" class="sidebar-link"><i class="fa-solid fa-clipboard-list me-2"></i>All Pets</a></li>
              <li class="sidebar-item"><a href="index.php?page=admin/addpet" class="sidebar-link active"><i class="fa-solid fa-plus me-2"></i>Add New Pet</a></li>
            </ul>
          </li>
          <li class="sidebar-item has-submenu">
            <a href="#" class="sidebar-link has-arrow" data-toggle="submenu"><i class="fa-solid fa-user me-2"></i> User Management</a>
            <ul class="first-level list-unstyled ps-3">
              <li class="sidebar-item"><a href="index.php?page=admin/userManagement" class="sidebar-link"><i class="fa-solid fa-user me-2"></i>Users</a></li>
              <li class="sidebar-item"><a href="index.php?page=admin/adoptionManagement" class="sidebar-link"><i class="fa-solid fa-house-chimney me-2"></i>Adoption Centers</a></li>
              <li class="sidebar-item"><a href="#" class="sidebar-link"><i class="fa-solid fa-plus me-2"></i>Add Adoption Center</a></li>
            </ul>
          </li>
          <li class="sidebar-item">
            <a href="#" class="sidebar-link"><i class="fas fa-envelope-open-text me-2"></i>Message Requests</a>
          </li>
          <li class="sidebar-item">
            <a href="#" class="sidebar-link"><i class="fas fa-handshake me-2"></i>Volunteer Requests</a>
          </li>
          <li class="sidebar-item">
            <a href="#" class="sidebar-link"><i class="fas fa-comment-dots me-2"></i>View Feedback</a>
          </li>
          <li class="sidebar-item">
            <a href="donation.php" class="sidebar-link"><i class="fas fa-donate me-2"></i>Donation</a>
          </li>
          <li class="sidebar-item">
            <a href="#" class="sidebar-link" data-bs-toggle="modal" data-bs-target="#logoutModal">
              <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
          </li>
        </ul>
      </nav>
    </aside>
