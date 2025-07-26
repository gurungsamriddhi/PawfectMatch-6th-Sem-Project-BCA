<div class="d-flex flex-column flex-shrink-0 p-3 text-white" style="width: 260px; min-height: 100vh; background: #436C5D;">
  <div class="text-center mb-4">
    <div style="background: #E2E9E8; border-radius: 50%; width: 100px; height: 100px; margin: 0 auto; box-shadow: 0 2px 8px rgba(0,0,0,0.08); display: flex; align-items: center; justify-content: center;">
      <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['user']['name']) ?>&background=E2E9E8&color=436C5D&size=96" alt="avatar" class="rounded-circle" width="80" height="80" style="object-fit:cover;">
    </div>
    <div style="height: 8px;"></div>
    <h4 class="mb-0 mt-2" style="color:#fff; font-weight:700; letter-spacing:1px;"> <?= htmlspecialchars($_SESSION['user']['name']) ?> </h4>
    <div style="height: 2px; width: 40px; background: #F9BF29; margin: 8px auto 8px auto; border-radius: 2px;"></div>
    <small class="text-light" style="font-size: 1rem; opacity:0.85;">User</small>
  </div>
  <ul class="nav nav-pills flex-column mb-auto gap-2">
    <li class="nav-item"><a href="index.php?page=user_dashboard" class="nav-link text-white" style="border-radius:8px;"><i class="fas fa-home me-2"></i>Dashboard</a></li>
    <li><a href="index.php?page=user_profile" class="nav-link text-white" style="border-radius:8px;"><i class="fas fa-user-edit me-2"></i>Profile</a></li>
    <li><a href="index.php?page=user_saved_pets" class="nav-link text-white" style="border-radius:8px;"><i class="fas fa-heart me-2"></i>Saved Pets</a></li>
    <li><a href="index.php?page=user_adoption_requests" class="nav-link text-white" style="border-radius:8px;"><i class="fas fa-paw me-2"></i>Adoption Requests</a></li>
    <li><a href="index.php?page=user_donations" class="nav-link text-white" style="border-radius:8px;"><i class="fas fa-hand-holding-usd me-2"></i>Donations</a></li>
    <li><a href="index.php?page=user_messages" class="nav-link text-white" style="border-radius:8px;"><i class="fas fa-envelope me-2"></i>Messages</a></li>
    <li><a href="index.php?page=user_volunteer_status" class="nav-link text-white" style="border-radius:8px;"><i class="fas fa-hands-helping me-2"></i>Volunteer Status</a></li>
    <li><a href="#" class="nav-link text-white" style="border-radius:8px;" data-bs-toggle="modal" data-bs-target="#logoutModal"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
  </ul>
  <style>
    .nav-pills .nav-link.active, .nav-pills .nav-link:hover {
      background: #F9BF29 !important;
      color: #333 !important;
    }
  </style>
</div>
<!-- Logout Confirmation Modal (copied from admin panel) -->
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
        <a href="index.php?page=logout" class="btn btn-danger">Logout</a>
      </div>
    </div>
  </div>
</div> 