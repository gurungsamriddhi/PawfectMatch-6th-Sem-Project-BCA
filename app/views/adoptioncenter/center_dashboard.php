<?php include_once 'app/views/partials/sidebarcenter.php'; ?>
<!-- Main Content -->
<div class="body-wrapper w-100">
  <!-- Header -->
  <header class="app-header bg-dark text-white py-3 px-4">
    <div class="d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Welcome To Adoption Center</h5>
      <div class="d-flex align-items-center gap-3">
        <i class="fas fa-bell"></i>
        <i class="fas fa-user-circle"></i>
      </div>
    </div>
  </header>

  <!-- Content -->
  <div class="container-fluid py-4">
    <!-- Quick Stats Section -->
    <div class="row g-4 mb-4">
      <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="card stats-card text-center">
          <div class="card-body">
            <i class="fas fa-paw icon"></i>
            <div class="number"><?= htmlspecialchars($stats['total_Pets'] ?? 0) ?></div>
            <div class="label">Total Pets Listed</div>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="card stats-card text-center">
          <div class="card-body">
            <i class="fas fa-heart icon"></i>
            <div class="number"><?= htmlspecialchars($stats['total_Adoptions'] ?? 0) ?></div>
            <div class="label">Adoptions Completed</div>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="card stats-card text-center">
          <div class="card-body">
            <i class="fas fa-hand-holding-usd icon"></i>
            <div class="number"><?= htmlspecialchars($stats['total_Donations'] ?? 0) ?></div>
            <div class="label">Total Donations</div>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="card stats-card text-center">
          <div class="card-body">
            <i class="fas fa-users icon"></i>
            <div class="number"><?= htmlspecialchars($stats['total_Volunteers'] ?? 0) ?></div>
            <div class="label">Total Volunteers</div>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="card stats-card text-center">
          <div class="card-body">
            <i class="fas fa-clock icon"></i>
            <div class="number"><?= htmlspecialchars($stats['pending_Requests'] ?? 0) ?></div>
            <div class="label">Pending Requests</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="row mb-4">
      <div class="col-12">
        <div class="quick-actions">
          <h5 class="section-title"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
          <div class="d-flex flex-wrap">
            <a href="index.php?page=adoptioncenter/add_pets" class="action-btn">
              <i class="fas fa-plus"></i>Add New Pet
            </a>
            <a href="index.php?page=adoptioncenter/adoption_request" class="action-btn">
              <i class="fas fa-envelope"></i>View Messages
            </a>
            <a href="#" class="action-btn">
              <i class="fas fa-user-check"></i>Approve Volunteers
            </a>
            <a href="report.php" class="action-btn">
              <i class="fas fa-chart-bar"></i>View Reports
            </a>
            <a href="donation.php" class="action-btn">
              <i class="fas fa-donate"></i>Donation
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once 'app/views/partials/admin_footer.php'; ?>
