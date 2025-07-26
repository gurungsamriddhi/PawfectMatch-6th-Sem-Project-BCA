<?php include 'app/views/partials/header.php'; ?>
<div class="d-flex" style="min-height: 100vh; background: #f5f7fa;">
  <?php include 'app/views/partials/sidebaruser.php'; ?>
  <div class="flex-grow-1 p-0">
    <div class="container-fluid">
      <!-- Header Section -->
      <div class="d-flex justify-content-between align-items-center mb-3 p-3">
        <div>
          <h2 class="fw-bold mb-1" style="color: #2c5530; font-size: 2rem;">
            <i class="fas fa-heart me-2" style="color: #e74c3c;"></i>Saved Pets
          </h2>
          <p class="text-muted mb-0">Your favorite pets waiting for adoption</p>
        </div>
        <div class="text-end">
          <span class="badge bg-primary fs-6 px-3 py-2">
            <i class="fas fa-paw me-1"></i><?= count($savedPets) ?> Saved
          </span>
        </div>
      </div>

      <!-- Main Content -->
      <div class="row justify-content-center">
        <div class="col-12">
          <div class="card shadow-lg border-0 mb-5" style="border-radius: 20px; background: #fff; margin: 0 15px;">
            <div class="card-header bg-gradient text-white text-center py-3" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); border-radius: 20px 20px 0 0; border: none;">
              <div class="d-flex align-items-center justify-content-center">
                <i class="fas fa-heart me-3" style="font-size: 1.5rem;"></i>
                <h4 class="mb-0 fw-bold">My Wishlist</h4>
                <i class="fas fa-heart ms-3" style="font-size: 1.5rem;"></i>
              </div>
            </div>
            
            <div class="card-body p-4">
              <?php if (!empty($savedPets)): ?>
                <div class="row g-4" id="savedPetsContainer">
                  <?php foreach ($savedPets as $pet): ?>
                    <div class="col-lg-4 col-md-6 mb-4" id="pet-card-<?= $pet['pet_id'] ?>">
                      <div class="pet-card-modern h-100 d-flex flex-column">
                        <!-- Pet Image with Heart Icon -->
                        <div class="pet-card-img-wrap position-relative">
                          <img src="<?= htmlspecialchars($pet['image_path'] ?? 'public/assets/images/pets.png') ?>" 
                               class="pet-card-img" alt="<?= htmlspecialchars($pet['name']) ?>">
                          <div class="position-absolute top-0 end-0 m-2">
                            <span class="bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                              <i class="fas fa-heart text-danger" style="font-size: 1.1rem;"></i>
                            </span>
                          </div>
                        </div>
                        <div class="pet-card-content flex-fill d-flex flex-column justify-content-between p-3">
                          <div>
                            <h5 class="fw-bold mb-2" style="color: #2c5530; font-size: 1.2rem; letter-spacing: 0.5px;">
                              <?= htmlspecialchars($pet['name']) ?>
                            </h5>
                            <div class="d-flex flex-wrap mb-2 gap-2 align-items-center">
                              <span class="pet-meta"><i class="fas fa-dog me-1 text-primary"></i><?= htmlspecialchars($pet['type']) ?></span>
                              <span class="pet-meta"><i class="fas fa-venus-mars me-1 text-warning"></i><?= htmlspecialchars($pet['gender']) ?></span>
                            </div>
                            <div class="d-flex flex-wrap mb-2 gap-2 align-items-center">
                              <span class="pet-meta"><i class="fas fa-dna me-1 text-info"></i><?= htmlspecialchars($pet['breed']) ?></span>
                              <span class="pet-meta"><i class="fas fa-birthday-cake me-1 text-success"></i><?= htmlspecialchars($pet['age']) ?> years</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                              <span class="pet-meta"><i class="fas fa-map-marker-alt me-1 text-danger"></i><?= htmlspecialchars($pet['adoption_center']) ?></span>
                            </div>
                          </div>
                          <div class="d-flex gap-2 mt-3">
                            <button class="btn btn-adopt flex-fill" onclick="showAdoptionModal(<?= $pet['pet_id'] ?>, '<?= htmlspecialchars($pet['name']) ?>')">
                              Adopt Me
                            </button>
                            <a href="index.php?page=browse" class="btn btn-view flex-fill">
                              View
                            </a>
                            <button class="btn btn-remove flex-fill" onclick="showRemoveConfirmation(<?= $pet['pet_id'] ?>, '<?= htmlspecialchars($pet['name']) ?>')">
                              Remove
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              <?php else: ?>
                <div class="text-center py-5">
                  <div class="empty-state">
                    <div class="mb-4">
                      <i class="fas fa-heart-broken" style="font-size: 4rem; color: #e74c3c; opacity: 0.6;"></i>
                    </div>
                    <h4 class="fw-bold mb-3" style="color: #2c5530;">No saved pets yet</h4>
                    <p class="text-muted mb-4" style="font-size: 1.1rem;">Start browsing pets and add them to your wishlist to see them here!</p>
                    <a href="index.php?page=browse" class="btn btn-primary btn-lg px-4" style="border-radius: 25px; font-weight: 500;">
                      <i class="fas fa-search me-2"></i>Browse Pets
                    </a>
                  </div>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
.pet-card-modern {
  background: #f8f9fa;
  border-radius: 18px;
  box-shadow: 0 2px 12px rgba(60,60,60,0.07);
  overflow: hidden;
  display: flex;
  flex-direction: column;
  min-height: 420px;
  transition: box-shadow 0.2s, transform 0.2s;
}
.pet-card-modern:hover {
  box-shadow: 0 8px 32px rgba(60,60,60,0.13);
  transform: translateY(-4px) scale(1.02);
}
.pet-card-img-wrap {
  background: #fff;
  border-bottom: 1px solid #e9ecef;
  padding: 0;
}
.pet-card-img {
  width: 100%;
  height: 180px;
  object-fit: cover;
  border-radius: 18px 18px 0 0;
  display: block;
}
.pet-card-content {
  flex: 1 1 auto;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  background: none;
}
.pet-meta {
  font-size: 0.97rem;
  color: #495057;
  background: #f1f3f4;
  border-radius: 12px;
  padding: 2px 10px 2px 7px;
  margin-right: 4px;
  display: flex;
  align-items: center;
  gap: 2px;
}
.btn-adopt {
  background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
  color: #fff;
  border: none;
  border-radius: 30px;
  font-weight: 700;
  font-size: 0.85rem;
  padding: 12px 20px;
  transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
  box-shadow: 0 6px 20px rgba(40, 167, 69, 0.25);
  position: relative;
  overflow: hidden;
  text-transform: uppercase;
  letter-spacing: 1px;
  min-width: 120px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}
.btn-adopt:hover {
  background: linear-gradient(135deg, #20c997 0%, #28a745 100%);
  color: #fff;
  transform: translateY(-3px) scale(1.02);
  box-shadow: 0 12px 30px rgba(40, 167, 69, 0.35);
}
.btn-adopt:active {
  transform: translateY(-1px) scale(1.01);
  box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
}
.btn-adopt::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
  transition: left 0.6s ease-in-out;
}
.btn-adopt:hover::before {
  left: 100%;
}

.btn-view {
  background: #fff;
  color: #495057;
  border: 2px solid #e9ecef;
  border-radius: 30px;
  font-weight: 600;
  font-size: 0.85rem;
  padding: 12px 20px;
  transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
  text-transform: uppercase;
  letter-spacing: 0.8px;
  min-width: 100px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}
.btn-view:hover {
  background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
  color: #fff;
  transform: translateY(-3px) scale(1.02);
  box-shadow: 0 10px 25px rgba(108, 117, 125, 0.25);
  border-color: #6c757d;
}
.btn-view:active {
  transform: translateY(-1px) scale(1.01);
  box-shadow: 0 6px 20px rgba(108, 117, 125, 0.2);
}

.btn-remove {
  background: #fff;
  color: #dc3545;
  border: 2px solid #f8d7da;
  border-radius: 30px;
  font-weight: 600;
  font-size: 0.85rem;
  padding: 12px 20px;
  transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
  box-shadow: 0 4px 15px rgba(220, 53, 69, 0.1);
  text-transform: uppercase;
  letter-spacing: 0.8px;
  position: relative;
  overflow: hidden;
  min-width: 110px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}
.btn-remove:hover {
  background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
  color: #fff;
  transform: translateY(-3px) scale(1.02);
  box-shadow: 0 10px 25px rgba(220, 53, 69, 0.25);
  border-color: #dc3545;
}
.btn-remove:active {
  transform: translateY(-1px) scale(1.01);
  box-shadow: 0 6px 20px rgba(220, 53, 69, 0.2);
}
.btn-remove::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
  transition: left 0.6s ease-in-out;
}
.btn-remove:hover::before {
  left: 100%;
}
@media (max-width: 991px) {
  .pet-card-modern { min-height: 440px; }
}
@media (max-width: 767px) {
  .pet-card-modern { min-height: 0; }
  .pet-card-img { height: 150px; }
}
</style>

<script>
let petToRemove = null;

function showRemoveConfirmation(petId, petName) {
  petToRemove = petId;
  document.getElementById('removePetName').textContent = petName;
  const modal = new bootstrap.Modal(document.getElementById('removeConfirmationModal'));
  modal.show();
}

function showAdoptionModal(petId, petName) {
  document.getElementById('adoptPetId').value = petId;
  document.getElementById('adoptionRequestLabel').innerHTML = `Adoption Request - ${petName}`;
  const modal = new bootstrap.Modal(document.getElementById('adoptionRequestModal'));
  modal.show();
}

async function removeFromWishlist() {
  if (!petToRemove) return;

  try {
    const response = await fetch('wishlist_handler.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `action=remove&pet_id=${petToRemove}`
    });
    
    const data = await response.json();
    if (data.success) {
      // Remove the card from the DOM with animation
      const cardElement = document.getElementById(`pet-card-${petToRemove}`);
      if (cardElement) {
        cardElement.style.transition = 'all 0.3s ease';
        cardElement.style.transform = 'scale(0.8)';
        cardElement.style.opacity = '0';
        setTimeout(() => {
          cardElement.remove();
        }, 300);
      }
      
      // Close the modal
      const modal = bootstrap.Modal.getInstance(document.getElementById('removeConfirmationModal'));
      modal.hide();
      
      // Show success message
      showToast('Pet removed from wishlist!', 'success');
      
      // Check if no more pets remain
      const remainingCards = document.querySelectorAll('#savedPetsContainer .col-lg-4');
      if (remainingCards.length === 0) {
        // Reload to show empty state
        setTimeout(() => {
          location.reload();
        }, 1000);
      }
    } else {
      showToast(data.message || 'Error removing pet', 'error');
    }
  } catch (error) {
    console.error('Error removing from wishlist:', error);
    showToast('Error removing pet from wishlist', 'error');
  }
  
  petToRemove = null;
}

function showToast(message, type = 'info') {
  // Create toast notification
  const toast = document.createElement('div');
  toast.className = `toast-notification toast-${type}`;
  toast.innerHTML = `
    <div class="toast-content">
      <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
      <span>${message}</span>
    </div>
  `;
  
  document.body.appendChild(toast);
  
  // Show toast
  setTimeout(() => toast.classList.add('show'), 100);
  
  // Remove toast after 3 seconds
  setTimeout(() => {
    toast.classList.remove('show');
    setTimeout(() => document.body.removeChild(toast), 300);
  }, 3000);
}

// Adoption form submit handler
document.addEventListener('DOMContentLoaded', function() {
  const adoptionForm = document.getElementById('adoptionRequestForm');
  if (adoptionForm) {
    adoptionForm.onsubmit = function(e) {
      e.preventDefault();
      const formData = new FormData(this);
      fetch('debug_db.php', {
        method: 'POST',
        body: formData,
        credentials: 'same-origin'
      })
      .then(async res => {
        let data;
        try {
          data = await res.json();
        } catch (e) {
          // If response is not JSON but status is 200, treat as success
          if (res.ok) {
            bootstrap.Modal.getInstance(document.getElementById('adoptionRequestModal')).hide();
            setTimeout(function() {
              let thankYouModal = new bootstrap.Modal(document.getElementById('thankYouModal'));
              thankYouModal.show();
            }, 500);
            return;
          } else {
            showErrorModal('An error occurred.');
            return;
          }
        }
        if (data && data.success) {
          bootstrap.Modal.getInstance(document.getElementById('adoptionRequestModal')).hide();
          setTimeout(function() {
            let thankYouModal = new bootstrap.Modal(document.getElementById('thankYouModal'));
            thankYouModal.show();
          }, 500);
        } else {
          showErrorModal((data && data.message) || 'Unknown error');
        }
      })
      .catch(() => {
        showErrorModal('An error occurred.');
      });
    };
  }
});

function showErrorModal(message) {
  document.getElementById('errorModalMessage').textContent = message;
  let errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
  errorModal.show();
}
</script>

<!-- Remove Confirmation Modal -->
<div class="modal fade" id="removeConfirmationModal" tabindex="-1" aria-labelledby="removeConfirmationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius: 15px; border: none;">
      <div class="modal-header border-0 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); border-radius: 15px 15px 0 0;">
        <h5 class="modal-title mb-0 text-white fw-bold" id="removeConfirmationModalLabel">
          <i class="fas fa-heart-broken me-2"></i>Confirm Removal
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center" style="padding: 2.5rem;">
        <div class="mb-4">
          <i class="fas fa-heart-broken fa-4x text-danger" style="opacity: 0.8;"></i>
        </div>
        <h5 class="mb-3 fw-bold" style="color: #2c5530;">Are you sure you want to remove <strong id="removePetName" style="color: #e74c3c;"></strong> from your saved list?</h5>
        <p class="text-muted">This action cannot be undone and you'll need to re-add the pet if you change your mind.</p>
      </div>
      <div class="modal-footer border-0 d-flex justify-content-center align-items-center pb-4">
        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal" style="border-radius: 25px; font-weight: 500;">
          <i class="fas fa-times me-1"></i>Cancel
        </button>
        <button type="button" class="btn btn-danger px-4" onclick="removeFromWishlist()" style="border-radius: 25px; font-weight: 500;">
          <i class="fas fa-heart-broken me-1"></i>Yes, Remove
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Adoption Request Modal -->
<div class="modal fade" id="adoptionRequestModal" tabindex="-1" aria-labelledby="adoptionRequestLabel" aria-hidden="true">
  <div class="modal-dialog custom-wide-modal">
    <form class="modal-content" id="adoptionRequestForm">
      <div class="modal-header">
        <h3 class="modal-title" id="adoptionRequestLabel">Adoption Request</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="pet_id" id="adoptPetId">
        <div class="row g-3">
          <div class="col-md-6">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" name="address" required>
          </div>
          <div class="col-md-6">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" name="phone" required>
          </div>
          <div class="col-md-6">
            <label for="reason" class="form-label">Reason for Adoption</label>
            <textarea class="form-control" name="reason" rows="2" required></textarea>
          </div>
          <div class="col-md-6">
            <label for="preferred_date" class="form-label">Preferred Date</label>
            <input type="date" class="form-control" name="preferred_date" required>
          </div>
          <div class="col-md-6">
            <label for="home_type" class="form-label">Home Type</label>
            <select class="form-select" name="home_type" required>
              <option value="">Select</option>
              <option value="Apartment">Apartment</option>
              <option value="House">House</option>
              <option value="Farm">Farm</option>
            </select>
          </div>
          <div class="col-md-6">
            <label for="has_other_pets" class="form-label">Do you have other pets?</label>
            <select class="form-select" name="has_other_pets" required>
              <option value="">Select</option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button type="submit" class="btn btn-primary" style="background: #3b5d50; border-color: #3b5d50; min-width: 200px;">Submit Request</button>
      </div>
    </form>
  </div>
</div>

<!-- Thank You Modal -->
<div class="modal fade" id="thankYouModal" tabindex="-1" aria-labelledby="thankYouLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius: 18px; background: #f6fff8; box-shadow: 0 8px 32px rgba(60,120,80,0.10);">
      <div class="modal-header border-0 d-flex align-items-center justify-content-between" style="background: #e6f9ed; border-radius: 18px 18px 0 0; padding: 1.2rem 1.5rem 1rem 1.5rem;">
        <h5 class="modal-title w-100 text-success fw-bold m-0" id="thankYouLabel" style="font-size: 1.6rem; letter-spacing: 1px;">Thank You!</h5>
        <button type="button" class="btn-close ms-2" style="position: static;" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center" style="font-family: 'Segoe UI', 'Arial', sans-serif;">
        <div class="mb-3" style="font-size:2.5rem; color:#7c4dff; line-height:1;">
          <span style="font-size:2.2rem; vertical-align:middle;">&#128062;</span>
          <span style="font-size:2.2rem; vertical-align:middle; margin-left:-0.5rem;">&#128062;</span>
        </div>
        <div class="mb-3 fs-5" style="color:#2d4739; font-weight: 500;">Thank you for your adoption request!<br>We appreciate your kindness and will contact you soon.</div>
        <button class="btn btn-success px-4 py-2 mt-2" style="border-radius: 24px; font-size: 1.1rem; min-width: 120px;" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title w-100 text-danger" id="errorModalLabel">Error</h5>
        <button type="button" class="btn-close position-absolute end-0 me-3 mt-2" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <div class="mb-3" style="font-size:2.5rem;"><i class="fas fa-exclamation-triangle"></i></div>
        <div class="mb-3 fs-5" id="errorModalMessage">An error occurred.</div>
        <button class="btn btn-danger px-4" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

<!-- Logout Confirmation Modal (copied from admin panel) -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0 d-flex justify-content-between align-items-center">
        <h5 class="modal-title mb-0" id="logoutModalLabel">Confirm Logout</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body d-flex justify-content-center align-items-center" style="height: 100px;">
        Are you sure you want to log out?
      </div>
      <div class="modal-footer border-0 d-flex justify-content-center align-items-center">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <a href="index.php?page=logout" class="btn btn-danger">Logout</a>
      </div>
    </div>
  </div>
</div>

 