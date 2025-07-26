<?php include 'app/views/partials/header.php'; ?>
<div class="d-flex" style="min-height: 100vh; background: linear-gradient(135deg, #f5f7fa 0%, #e2e9e8 100%);">
  <?php include 'app/views/partials/sidebaruser.php'; ?>
  <div class="flex-grow-1 p-4">
    <!-- Welcome Section -->
    <div class="welcome-section mb-4">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h2 class="fw-bold mb-1" style="color: white; font-size: 2.2rem;">Welcome back, <?= htmlspecialchars($_SESSION['user']['name']) ?>! <i class="fas fa-paw" style="color: white; margin-left: 8px;"></i></h2>
          <p class="mb-0" style="font-size: 1.1rem; color: #e2e8f0;">Here's what's happening with your pet adoption journey</p>
        </div>
        <div class="text-end">
          <div class="badge bg-primary px-3 py-2" style="font-size: 0.9rem; background: #3b5d50 !important;">
            <i class="fas fa-calendar-alt me-1"></i><?= date('l, F j, Y') ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
      <div class="col-lg-3 col-md-6">
        <div class="stat-card">
          <div class="stat-icon" style="background: #436C5D;">
            <i class="fas fa-paw"></i>
          </div>
          <div class="stat-content">
            <h3 class="stat-number"><?= count($adoptionRequests ?? []) ?></h3>
            <p class="stat-label">Adoption Requests</p>
            <div class="stat-progress">
              <div class="progress" style="height: 4px;">
                <div class="progress-bar" style="width: <?= min(100, (count($adoptionRequests ?? []) / 5) * 100) ?>%; background: #436C5D;"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="stat-card">
          <div class="stat-icon" style="background: #436C5D;">
            <i class="fas fa-heart"></i>
          </div>
          <div class="stat-content">
            <h3 class="stat-number"><?= count($savedPets ?? []) ?></h3>
            <p class="stat-label">Saved Pets</p>
            <div class="stat-progress">
              <div class="progress" style="height: 4px;">
                <div class="progress-bar" style="width: <?= min(100, (count($savedPets ?? []) / 10) * 100) ?>%; background: #436C5D;"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="stat-card">
          <div class="stat-icon" style="background: #436C5D;">
            <i class="fas fa-hand-holding-usd"></i>
          </div>
          <div class="stat-content">
            <h3 class="stat-number">₹<?= number_format($donationTotal ?? 0) ?></h3>
            <p class="stat-label">Total Donations</p>
            <div class="stat-progress">
              <div class="progress" style="height: 4px;">
                <div class="progress-bar" style="width: <?= min(100, (($donationTotal ?? 0) / 10000) * 100) ?>%; background: #436C5D;"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="stat-card">
          <div class="stat-icon" style="background: #436C5D;">
            <i class="fas fa-hands-helping"></i>
          </div>
          <div class="stat-content">
            <h3 class="stat-number"><?= $volunteerStatus === 'assigned' ? 'Active' : ($volunteerStatus === 'pending' ? 'Pending' : '0') ?></h3>
            <p class="stat-label">Volunteer Status</p>
            <div class="stat-progress">
              <div class="progress" style="height: 4px;">
                <div class="progress-bar" style="width: <?= $volunteerStatus === 'assigned' ? 100 : ($volunteerStatus === 'pending' ? 50 : 0) ?>%; background: #436C5D;"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-4 mb-5">
      <div class="col-12">
        <div class="quick-actions-card">
          <h4 class="card-title mb-3">
            <i class="fas fa-bolt me-2"></i>Quick Actions
          </h4>
          <div class="row g-3">
            <div class="col-md-3 col-6">
              <a href="index.php?page=browse" class="quick-action-btn">
                <i class="fas fa-search"></i>
                <span>Browse Pets</span>
              </a>
            </div>
            <div class="col-md-3 col-6">
              <a href="index.php?page=user_adoption_requests" class="quick-action-btn">
                <i class="fas fa-file-alt"></i>
                <span>My Requests</span>
              </a>
            </div>
            <div class="col-md-3 col-6">
              <a href="index.php?page=user_saved_pets" class="quick-action-btn">
                <i class="fas fa-heart"></i>
                <span>Saved Pets</span>
              </a>
            </div>
            <div class="col-md-3 col-6">
              <a href="index.php?page=donate" class="quick-action-btn">
                <i class="fas fa-gift"></i>
                <span>Donate</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content Cards -->
    <div class="row g-4">
      <!-- Recent Adoption Requests -->
      <div class="col-lg-6">
        <div class="content-card">
          <div class="card-header-custom">
            <h5 class="mb-0">
              <i class="fas fa-paw me-2"></i>Recent Adoption Requests
            </h5>
            <a href="index.php?page=user_adoption_requests" class="btn btn-sm btn-outline-primary">View All</a>
          </div>
          <div class="card-body-custom">
            <?php if (!empty($adoptionRequests)): ?>
              <div class="request-list">
                <?php foreach (array_slice($adoptionRequests, 0, 3) as $req): ?>
                  <div class="request-item">
                    <div class="request-info">
                      <h6 class="mb-1"><?= htmlspecialchars($req['pet_name']) ?></h6>
                      <small class="text-muted">
                        <i class="fas fa-calendar me-1"></i><?= date('M j, Y', strtotime($req['date'])) ?>
                      </small>
                    </div>
                    <div class="request-status">
                      <?php 
                        $status = strtolower($req['status']);
                        $statusClass = $status === 'pending' ? 'warning' : ($status === 'approved' ? 'success' : 'secondary');
                        $statusText = $status === 'rejected' ? 'Cancelled' : ucfirst($status);
                      ?>
                      <span class="badge bg-<?= $statusClass ?>"><?= $statusText ?></span>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php else: ?>
              <div class="empty-state">
                <i class="fas fa-file-alt fa-2x text-muted mb-2"></i>
                <p class="text-muted mb-2">No adoption requests yet</p>
                <a href="index.php?page=browse" class="btn btn-primary btn-sm">
                  <i class="fas fa-search me-1"></i>Browse Pets
                </a>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Saved Pets -->
      <div class="col-lg-6">
        <div class="content-card">
          <div class="card-header-custom">
            <h5 class="mb-0">
              <i class="fas fa-heart me-2"></i>Saved Pets
            </h5>
            <a href="index.php?page=user_saved_pets" class="btn btn-sm btn-outline-danger">View All</a>
          </div>
          <div class="card-body-custom">
            <?php if (!empty($savedPets)): ?>
              <div class="pet-list">
                <?php foreach (array_slice($savedPets, 0, 3) as $pet): ?>
                  <div class="pet-item">
                    <img src="<?= htmlspecialchars($pet['image_path'] ?? 'public/assets/images/pets.png') ?>" 
                         alt="<?= htmlspecialchars($pet['name']) ?>" class="pet-image">
                    <div class="pet-info">
                      <h6 class="mb-1"><?= htmlspecialchars($pet['name']) ?></h6>
                      <small class="text-muted"><?= htmlspecialchars($pet['breed']) ?></small>
                    </div>
                    <a href="index.php?page=petdetails&id=<?= urlencode($pet['pet_id']) ?>" 
                       class="btn btn-sm btn-outline-primary">
                      <i class="fas fa-eye"></i>
                    </a>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php else: ?>
              <div class="empty-state">
                <i class="fas fa-heart-broken fa-2x text-muted mb-2"></i>
                <p class="text-muted mb-2">No saved pets yet</p>
                <a href="index.php?page=browse" class="btn btn-primary btn-sm">
                  <i class="fas fa-search me-1"></i>Browse Pets
                </a>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Recent Donations -->
      <div class="col-lg-6">
        <div class="content-card">
          <div class="card-header-custom">
            <h5 class="mb-0">
              <i class="fas fa-hand-holding-usd me-2"></i>Recent Donations
            </h5>
            <a href="index.php?page=user_donations" class="btn btn-sm btn-outline-success">View All</a>
          </div>
          <div class="card-body-custom">
            <?php if (!empty($donations)): ?>
              <div class="donation-list">
                <?php foreach (array_slice($donations, 0, 3) as $don): ?>
                  <div class="donation-item">
                    <div class="donation-info">
                      <h6 class="mb-1">₹<?= number_format($don['amount']) ?></h6>
                      <small class="text-muted"><?= htmlspecialchars($don['purpose']) ?></small>
                    </div>
                    <div class="donation-date">
                      <small class="text-muted">
                        <i class="fas fa-calendar me-1"></i><?= date('M j, Y', strtotime($don['date'])) ?>
                      </small>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php else: ?>
              <div class="empty-state">
                <i class="fas fa-hand-holding-usd fa-2x text-muted mb-2"></i>
                <p class="text-muted mb-2">No donations yet</p>
                <a href="index.php?page=donate" class="btn btn-success btn-sm">
                  <i class="fas fa-gift me-1"></i>Make a Donation
                </a>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Profile & Settings -->
      <div class="col-lg-6">
        <div class="content-card">
          <div class="card-header-custom">
            <h5 class="mb-0">
              <i class="fas fa-user-cog me-2"></i>Profile & Settings
            </h5>
          </div>
          <div class="card-body-custom">
            <div class="profile-info mb-3">
              <div class="profile-avatar">
                <i class="fas fa-user"></i>
              </div>
              <div class="profile-details">
                <h6 class="mb-1"><?= htmlspecialchars($_SESSION['user']['name']) ?></h6>
                <small class="text-muted"><?= htmlspecialchars($_SESSION['user']['email']) ?></small>
              </div>
            </div>
            <div class="profile-actions">
              <a href="index.php?page=user_profile" class="btn btn-outline-primary btn-sm me-2">
                <i class="fas fa-edit me-1"></i>Edit Profile
              </a>
              <a href="index.php?page=user_volunteer_status" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-hands-helping me-1"></i>Volunteer Status
              </a>
            </div>
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
        <a href="index.php?page=logout" class="btn btn-danger">Logout</a>
      </div>
    </div>
  </div>
</div>

<style>
/* Welcome Section */
.welcome-section {
  background: #436C5D;
  padding: 2rem;
  border-radius: 20px;
  color: white;
  box-shadow: 0 10px 30px rgba(67, 108, 93, 0.3);
}

.welcome-section h2 {
  color: white !important;
}

/* Stats Cards */
.stat-card {
  background: white;
  border-radius: 20px;
  padding: 1.5rem;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  border: none;
  display: flex;
  align-items: center;
  gap: 1rem;
}

.stat-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
}

.stat-icon {
  width: 60px;
  height: 60px;
  border-radius: 15px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 1.5rem;
}

.stat-content {
  flex: 1;
}

.stat-number {
  font-size: 2rem;
  font-weight: 700;
  color: #2d3748;
  margin: 0;
}

.stat-label {
  color: #718096;
  margin: 0.25rem 0;
  font-weight: 500;
}

/* Quick Actions */
.quick-actions-card {
  background: white;
  border-radius: 20px;
  padding: 1.5rem;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.card-title {
  color: #2d3748;
  font-weight: 600;
}

.quick-action-btn {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 1.5rem 1rem;
  background: #436C5D;
  color: white;
  text-decoration: none;
  border-radius: 15px;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  text-align: center;
}

.quick-action-btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 25px rgba(67, 108, 93, 0.3);
  color: white;
  background: #3b5d50;
}

.quick-action-btn i {
  font-size: 1.5rem;
  margin-bottom: 0.5rem;
}

.quick-action-btn span {
  font-weight: 500;
  font-size: 0.9rem;
}

/* Content Cards */
.content-card {
  background: white;
  border-radius: 20px;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  transition: transform 0.3s ease;
}

.content-card:hover {
  transform: translateY(-3px);
}

.card-header-custom {
  background: #436C5D;
  color: white;
  padding: 1.25rem 1.5rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.card-header-custom h5 {
  margin: 0;
  font-weight: 600;
}

.card-body-custom {
  padding: 1.5rem;
}

/* Request Items */
.request-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem 0;
  border-bottom: 1px solid #e2e8f0;
}

.request-item:last-child {
  border-bottom: none;
}

.request-info h6 {
  color: #2d3748;
  margin: 0;
}

/* Pet Items */
.pet-item {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 1rem 0;
  border-bottom: 1px solid #e2e8f0;
}

.pet-item:last-child {
  border-bottom: none;
}

.pet-image {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid #e2e8f0;
}

.pet-info h6 {
  color: #2d3748;
  margin: 0;
}

/* Donation Items */
.donation-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem 0;
  border-bottom: 1px solid #e2e8f0;
}

.donation-item:last-child {
  border-bottom: none;
}

.donation-info h6 {
  color: #2d3748;
  margin: 0;
}

/* Profile Section */
.profile-info {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.profile-avatar {
  width: 60px;
  height: 60px;
  background: #436C5D;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 1.5rem;
}

.profile-details h6 {
  color: #2d3748;
  margin: 0;
}

.profile-actions {
  display: flex;
  gap: 0.5rem;
  flex-wrap: wrap;
}

/* Empty States */
.empty-state {
  text-align: center;
  padding: 2rem 1rem;
}

.empty-state i {
  color: #a0aec0;
}

/* Responsive */
@media (max-width: 768px) {
  .welcome-section {
    padding: 1.5rem;
  }
  
  .welcome-section h2 {
    font-size: 1.8rem;
  }
  
  .stat-card {
    padding: 1rem;
  }
  
  .stat-number {
    font-size: 1.5rem;
  }
  
  .quick-action-btn {
    padding: 1rem 0.5rem;
  }
  
  .card-header-custom {
    flex-direction: column;
    gap: 0.5rem;
    text-align: center;
  }
}
</style> 