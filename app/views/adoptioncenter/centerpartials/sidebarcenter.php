  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Adoption Center Dashboard - PawfectMatch</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/assets/css/admin.css" />
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
            <!-- <li class="nav-small-cap">Home</li> -->
            <li class="sidebar-item selected">
              <a href="index.php?page=adoptioncenter/center_dashboard" class="sidebar-link">
                <i class="fas fa-home me-2"></i> Dashboard
              </a>
            </li>

            <li class="sidebar-item">
              <a href="index.php?page=adoptioncenter/adoptioncenter_profile" class="sidebar-link">
                <i class="fas fa-user me-2"></i> My Profile
              </a>
            </li>

            <li class="sidebar-item">
              <a class="sidebar-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#petManagementMenu" role="button" aria-expanded="false" aria-controls="petManagementMenu">
                <span><i class="fas fa-paw me-2"></i> Pet Management</span>
                <i class="fas fa-chevron-down"></i>
              </a>
              <ul class="collapse list-unstyled ps-4" id="petManagementMenu">
                <li>
                  <a href="index.php?page=adoptioncenter/add_pets" class="sidebar-link">
                    <i class="fa-solid fa-plus me-2"></i> Add Pet
                  </a>
                </li>
                <li>
                  <a href="index.php?page=adoptioncenter/managepets" class="sidebar-link">
                    <i class="fa-solid fa-list me-2"></i> Manage Pets
                  </a>
                </li>
              </ul>
            </li>



            <li class="sidebar-item">
              <a href="index.php?page=adoptioncenter/adoption_request" class="sidebar-link">
                <i class="fas fa-inbox me-2"></i> Adoption Requests
              </a>
            </li>

            <li class="sidebar-item">
              <a href="index.php?page=adoptioncenter/feedback" class="sidebar-link">
                <i class="fas fa-comments me-2"></i> Feedback
              </a>
            </li>


            </li>
            <li class="sidebar-item">
              <a href="#" class="sidebar-link" data-bs-toggle="modal" data-bs-target="#logoutModal">
                <i class="fas fa-sign-out-alt me-2"></i> Logout</a>
            </li>
          </ul>
        </nav>
      </aside>
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
              <a href="index.php?page=adoptioncenter/center_login" class="btn btn-danger">Logout</a>
            </div>
          </div>
        </div>
      </div>