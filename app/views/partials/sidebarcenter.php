  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard - PawfectMatch</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="public/assets/css/adoptioncenter.css" />
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
            <li class="nav-small-cap">Home</li>
            <li class="sidebar-item selected">
              <a href="index.php?page=adoptioncenter/center_dashboard" class="sidebar-link active">
                <i class="fas fa-home me-2"></i> Dashboard
              </a>
            </li>

            <li class="sidebar-item">
              <a href="index.php?page=adoptioncenter/adoptioncenter_profile" class="sidebar-link">
                <i class="fas fa-user me-2"></i> My Profile
              </a>
            </li>

            <li class="sidebar-item">
              <a href="index.php?page=adoptioncenter/managepets" class="sidebar-link">
                <i class="fas fa-paw me-2"></i> Manage Pets
              </a>
            </li>

            <li class="sidebar-item">
              <a href="index.php?page=adoptioncenter/add_pets" class="sidebar-link">
                <i class="fa-solid fa-plus me-2"></i> Add New Pet
              </a>
            </li>


            <li class="sidebar-item">
              <a href="#" class="sidebar-link"><i class="fa-solid fa-paw me-2"></i>All Pets</a>
            </li>
          </ul>
          </li>
          <li class="sidebar-item">
            <a href="#" class="sidebar-link" data-bs-toggle="modal" data-bs-target="#logoutModal">
              <i class="fas fa-sign-out-alt me-2"></i> Logout</a>
          </li>
          </ul>
        </nav>
      </aside>