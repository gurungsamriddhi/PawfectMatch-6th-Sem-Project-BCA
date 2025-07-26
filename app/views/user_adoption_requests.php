<?php include 'app/views/partials/header.php'; ?>
<div class="d-flex" style="min-height: 100vh; background: linear-gradient(120deg, #f6f8fd, #e3efff);">
  <?php include 'app/views/partials/sidebaruser.php'; ?>
  <div class="flex-grow-1 p-4" style="background: #E2E9E8;">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="fw-bold" style="color:#436C5D;">Adoption Requests</h3>
      <span class="badge" style="background:#F9BF29; color:#333; font-size:1rem;">Welcome, <?= htmlspecialchars($_SESSION['user']['name']) ?></span>
    </div>

    <div class="card shadow-lg border-0 mb-5" style="border-radius: 20px; background: #fff; margin: 0 15px;">
      <div class="card-header bg-gradient text-white text-center py-3" style="background: linear-gradient(135deg, #436C5D 0%, #3b5d50 100%); border-radius: 20px 20px 0 0; border: none;">
        <div class="d-flex align-items-center justify-content-center">
          <i class="fas fa-file-signature me-2"></i>
          <h5 class="mb-0 fw-bold">My Adoption Requests</h5>
        </div>
      </div>
      <div class="card-body p-4">
        <?php if (!empty($adoptionRequests)): ?>
          <div class="row g-4">
            <?php foreach ($adoptionRequests as $request): ?>
              <div class="col-12">
                <div class="adoption-card">
                  <img class="adoption-thumb" src="<?= htmlspecialchars($request['image_path'] ?? 'public/assets/images/pets.png') ?>" alt="<?= htmlspecialchars($request['pet_name']) ?>">
                  <div class="adoption-details">
                    <div class="adoption-name">
                      <?= htmlspecialchars($request['pet_name']) ?>
                      <?php 
                        $status = strtolower($request['status']);
                        $statusText = $request['status'];
                        $statusClass = 'status-' . $status;
                        
                        // Check if this request was cancelled by the user
                        $cancelledRequests = $_SESSION['cancelled_requests'] ?? [];
                        if ($status === 'rejected' && in_array($request['request_id'], $cancelledRequests)) {
                          $statusText = 'Cancelled';
                          $statusClass = 'status-cancelled';
                        }
                      ?>
                      <span class="status-badge <?= $statusClass ?>"><?= htmlspecialchars($statusText) ?></span>
                    </div>
                    <div class="adoption-phone"><i class="fa fa-calendar-alt me-1"></i>Requested: <?= htmlspecialchars($request['date']) ?></div>
                    <div class="adoption-date"><i class="fa fa-dog me-1"></i><?= htmlspecialchars($request['pet_type'] ?? 'Pet') ?> - <?= htmlspecialchars($request['breed'] ?? 'Unknown') ?></div>
                    <div style="font-size:1rem; color:#3b5d50; margin-top:2px;"><i class="fa fa-building me-1"></i><?= htmlspecialchars($request['center_name'] ?? 'Adoption Center') ?></div>
                  </div>
                  <div class="adoption-actions ms-auto">
                    <button class="view-btn btn btn-sm" data-bs-toggle="modal" data-bs-target="#viewAdoptionModal" onclick='showAdoptionDetails(<?= json_encode($request, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)'><i class="fa fa-eye me-1"></i>View</button>
                    <?php if (strtolower($request['status']) === 'pending'): ?>
                      <button class="cancel-btn btn btn-sm" onclick="showCancelConfirmation(<?= $request['request_id'] ?>, '<?= htmlspecialchars($request['pet_name']) ?>', '<?= htmlspecialchars($request['pet_type'] ?? 'Pet') ?>', '<?= htmlspecialchars($request['breed'] ?? 'Unknown') ?>', '<?= htmlspecialchars($request['date']) ?>')"><i class="fa fa-times me-1"></i>Cancel</button>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <div class="text-center py-5">
            <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
            <h5 class="text-muted mb-2">No Adoption Requests</h5>
            <p class="text-muted mb-3">You haven't made any adoption requests yet.</p>
            <a href="index.php?page=browse" class="btn btn-primary">
              <i class="fas fa-search me-1"></i>Browse Pets
            </a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- View Modal -->
<div class="modal fade" id="viewAdoptionModal" tabindex="-1" aria-labelledby="viewAdoptionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content" style="border-radius:20px; background:#fff; box-shadow:0 8px 32px rgba(60,120,80,0.10); padding:0;">
      <div class="modal-header align-items-center justify-content-between" style="border-bottom:1.5px solid #e2e9e8; background:#f8fafc; border-radius:20px 20px 0 0; padding: 18px 24px; display: flex; flex-direction: row;">
        <h5 class="modal-title fw-bold" id="viewAdoptionModalLabel" style="color:#3b5d50; font-size:1.35rem;">Adoption Request Details</h5>
        <div class="d-flex align-items-center gap-2">
          <span id="modalStatusBadge"></span>
          <button type="button" class="btn-close ms-2" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(34%) sepia(13%) saturate(1047%) hue-rotate(87deg) brightness(92%) contrast(88%);"></button>
        </div>
      </div>
      <div class="modal-body" id="adoptionDetailsBody" style="padding:24px;">
        <!-- Details will be injected by JS -->
      </div>
      <div class="modal-footer d-flex justify-content-end gap-3 flex-wrap" style="background:#f8fafc; border-radius:0 0 20px 20px; border-top:1.5px solid #e2e9e8;">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="rounded-pill px-4" id="modalCancelBtn" style="font-weight:600; min-width:120px; background:#dc3545; color:#fff; border:none; font-size:1.1rem; display:none;"><i class="fa fa-times me-1"></i>Cancel Request</button>
      </div>
    </div>
  </div>
</div>

<!-- Cancel Confirmation Modal -->
<div class="modal fade" id="cancelConfirmationModal" tabindex="-1" aria-labelledby="cancelConfirmationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:20px; background:#fff; box-shadow:0 8px 32px rgba(60,120,80,0.10); padding:0;">
      <div class="modal-header align-items-center justify-content-between" style="border-bottom:1.5px solid #e2e9e8; background:#f8fafc; border-radius:20px 20px 0 0; padding: 18px 24px;">
        <h5 class="modal-title fw-bold" id="cancelConfirmationModalLabel" style="color:#dc3545; font-size:1.35rem;">
          <i class="fa fa-exclamation-triangle me-2"></i>Cancel Adoption Request
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center" style="padding:24px;">
        <div class="mb-4">
          <i class="fa fa-question-circle fa-3x text-warning mb-3"></i>
          <h6 class="fw-bold mb-3">Are you sure you want to cancel this adoption request?</h6>
          <p class="text-muted mb-0">This action cannot be undone. Once cancelled, you will need to submit a new request if you want to adopt this pet.</p>
        </div>
        <div id="cancelPetInfo" class="alert alert-info" style="background: #e6f0fa; border: 1px solid #b3d9ff; color: #2563eb; border-radius: 12px;">
          <!-- Pet info will be inserted here -->
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-center gap-3" style="background:#f8fafc; border-radius:0 0 20px 20px; border-top:1.5px solid #e2e9e8;">
        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">No, Keep Request</button>
        <button type="button" class="btn btn-danger px-4" id="confirmCancelBtn">
          <i class="fa fa-times me-1"></i>Yes, Cancel Request
        </button>
      </div>
    </div>
  </div>
</div>

<style>
.adoption-card {
  background: #fff;
  border-radius: 14px;
  box-shadow: 0 2px 12px rgba(67,108,93,0.08);
  padding: 18px 20px;
  margin-bottom: 20px;
  display: flex;
  align-items: center;
  gap: 20px;
  transition: box-shadow 0.18s, transform 0.18s;
  border: 1.5px solid #f3f4f6;
}
.adoption-card:hover {
  box-shadow: 0 6px 24px rgba(67,108,93,0.16);
  transform: translateY(-2px) scale(1.01);
}
.adoption-thumb {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid #e2e9e8;
  box-shadow: 0 1px 4px rgba(67,108,93,0.10);
}
.adoption-details {
  flex: 1 1 0;
  display: flex;
  flex-direction: column;
  gap: 4px;
  min-width: 0;
}
.adoption-name {
  font-weight: 700;
  font-size: 1.15rem;
  color: #2d4739;
  display: flex;
  align-items: center;
  gap: 10px;
}
.status-badge {
  font-size: 0.85em;
  font-weight: 600;
  border-radius: 12px;
  padding: 2px 12px;
  margin-left: 6px;
  background: #f5b71b;
  color: #333;
  letter-spacing: 0.5px;
}
.status-pending { background: #f5b71b; color: #333; }
.status-accepted { background: #28a745; color: #fff; }
.status-approved { background: #28a745; color: #fff; }
.status-rejected { background: #dc3545; color: #fff; }
.status-cancelled { background: #6c757d; color: #fff; }
.adoption-phone {
  font-size: 1rem;
  color: #3b5d50;
  font-weight: 500;
}
.adoption-date {
  font-size: 0.95rem;
  color: #6c757d;
  font-weight: 400;
}
.adoption-actions {
  display: flex;
  gap: 12px;
  flex-shrink: 0;
}
.adoption-actions button {
  min-width: 90px;
  font-weight: 600;
  border-radius: 20px;
  border: none;
  transition: box-shadow 0.15s, transform 0.15s, background 0.15s;
  box-shadow: 0 1px 4px rgba(67,108,93,0.08);
}
.adoption-actions button:active,
.adoption-actions button:focus {
  outline: none;
  box-shadow: 0 2px 8px rgba(67,108,93,0.13);
}
.adoption-actions .view-btn {
  background: #0d6efd;
  color: #fff;
}
.adoption-actions .view-btn:hover {
  background: #2563eb;
  transform: scale(1.04);
}
.adoption-actions .cancel-btn {
  background: #dc3545;
  color: #fff;
}
.adoption-actions .cancel-btn:hover {
  background: #b71c1c;
  transform: scale(1.04);
}
@media (max-width: 768px) {
  .adoption-card {
    flex-direction: column;
    align-items: flex-start;
    gap: 14px;
    padding: 16px 10px;
  }
  .adoption-actions {
    width: 100%;
    flex-wrap: wrap;
    gap: 8px;
  }
  .adoption-actions button {
    width: 100%;
    min-width: 0;
  }
}
</style>

<script>
let currentRequestId = null;
let cancelledRequests = new Set(); // Track cancelled requests

function showCancelConfirmation(requestId, petName, petType, breed, date) {
  currentRequestId = requestId;
  
  const petInfo = `
    <strong>Pet Name:</strong> ${petName}<br>
    <strong>Pet Type:</strong> ${petType}<br>
    <strong>Pet Breed:</strong> ${breed}<br>
    <strong>Request Date:</strong> ${date}
  `;
  document.getElementById('cancelPetInfo').innerHTML = petInfo;
  
  const modal = new bootstrap.Modal(document.getElementById('cancelConfirmationModal'));
  modal.show();
  document.getElementById('confirmCancelBtn').onclick = () => confirmAndCancel(requestId);
}

function showAdoptionDetails(request) {
  currentRequestId = request.request_id;
  
  // Status badge logic - check if this was cancelled by user
  let status = request.status || 'pending';
  let statusClass = 'bg-secondary';
  let statusText = 'Pending';
  
  if (status.toLowerCase() === 'approved' || status.toLowerCase() === 'accepted') { 
    statusClass = 'bg-success'; 
    statusText = 'Accepted'; 
  }
  else if (status.toLowerCase() === 'rejected') { 
    // Check if this was cancelled by user (we'll need to add a flag or check user_id)
    // For now, we'll treat all rejected as cancelled for user view
    statusClass = 'bg-secondary'; 
    statusText = 'Cancelled'; 
  }
  else { 
    statusClass = 'bg-warning text-dark'; 
    statusText = 'Pending'; 
  }
  document.getElementById('modalStatusBadge').innerHTML = `<span class='badge ${statusClass}' style='font-size:1em; padding:6px 18px; border-radius:14px; font-weight:600;'>${statusText}</span>`;

  // Show/hide cancel button based on status
  const cancelBtn = document.getElementById('modalCancelBtn');
  if (status.toLowerCase() === 'pending') {
    cancelBtn.style.display = 'inline-block';
    cancelBtn.onclick = () => showCancelConfirmation(request.request_id, request.pet_name, request.pet_type, request.breed, request.date);
  } else {
    cancelBtn.style.display = 'none';
  }

  let html = `
    <div class='row g-4 align-items-center mb-4 flex-wrap'>
      <div class='col-md-4 text-center mb-3 mb-md-0'>
        ${request.image_path ? `<img src='${request.image_path}' style='width:140px;height:140px;object-fit:cover;border-radius:50%;border:3px solid #e2e9e8;box-shadow:0 6px 24px rgba(67,108,93,0.18);margin-bottom:12px;'>` : '<span class=\"text-muted\">No image</span>'}
      </div>
      <div class='col-md-8'>
        <div class='mb-3 pb-2' style='border-bottom:1px solid #f3f4f6; margin-bottom:18px;'>
          <span class='fw-bold' style='color:#3b5d50;font-size:1.18rem;'><i class='fa fa-paw me-2'></i>Pet Information</span>
        </div>
        <div class='row g-2 mb-2'>
          <div class='col-5 text-end text-secondary fw-bold'><i class='fa fa-dog me-1'></i>Name:</div>
          <div class='col-7'><span style='color:#2563eb; font-size:1.08em; font-weight:600;'>${request.pet_name}</span></div>
          <div class='col-5 text-end text-secondary fw-bold'><i class='fa fa-tag me-1'></i>Type:</div>
          <div class='col-7'>${request.pet_type || 'Unknown'}</div>
          <div class='col-5 text-end text-secondary fw-bold'><i class='fa fa-dna me-1'></i>Breed:</div>
          <div class='col-7'>${request.breed || 'Unknown'}</div>
        </div>
      </div>
    </div>
    <div class='mb-4 pb-2' style='border-bottom:1px solid #f3f4f6;'>
      <span class='fw-bold' style='color:#3b5d50;font-size:1.18rem;'><i class='fa fa-building me-2'></i>Adoption Center</span>
    </div>
    <div class='row g-3 mb-4'>
      <div class='col-12 col-md-6 d-flex align-items-center'><span class='text-secondary fw-bold me-2'><i class='fa fa-building me-1'></i>Center:</span> <span style='color:#2563eb; font-weight:600;'>${request.center_name || 'Adoption Center'}</span></div>
      <div class='col-12 col-md-6 d-flex align-items-center'><span class='text-secondary fw-bold me-2'><i class='fa fa-map-marker-alt me-1'></i>Address:</span> <span style='color:#444;'>${request.center_address || 'Address not available'}</span></div>
    </div>
    <div class='mb-4 pb-2' style='border-bottom:1px solid #f3f4f6;'>
      <span class='fw-bold' style='color:#3b5d50;font-size:1.18rem;'><i class='fa fa-info-circle me-2'></i>Request Details</span>
    </div>
    <div class='row g-3 mb-4'>
      <div class='col-12 col-md-6 d-flex align-items-center'><span class='text-secondary fw-bold me-2'><i class='fa fa-calendar-alt me-1'></i>Request Date:</span> <span style='color:#6c757d; font-size:0.98em;'>${request.date}</span></div>
      <div class='col-12 col-md-6 d-flex align-items-center'><span class='text-secondary fw-bold me-2'><i class='fa fa-clock me-1'></i>Status:</span> <span class='badge ${statusClass}' style='font-size:1em; padding:4px 14px;'>${statusText}</span></div>
    </div>
    <div class='mb-4 pb-2' style='border-bottom:1px solid #f3f4f6;'>
      <span class='fw-bold' style='color:#3b5d50;font-size:1.18rem;'><i class='fa fa-info-circle me-2'></i>What Happens Next?</span>
    </div>
    <div class='row g-3'>
      <div class='col-12'>
        <div class='alert alert-info' style='background: #e6f0fa; border: 1px solid #b3d9ff; color: #2563eb; border-radius: 12px;'>
          <div class='d-flex align-items-start'>
            <i class='fa fa-info-circle me-2 mt-1' style='font-size: 1.1em;'></i>
            <div>
              <strong>Pending:</strong> Your request is being reviewed by the adoption center.<br>
              <strong>Accepted:</strong> Your request has been approved! The center will contact you soon.<br>
              <strong>Cancelled:</strong> You have cancelled this adoption request.<br>
              <strong>Rejected:</strong> Unfortunately, your request was not approved by the center.
            </div>
          </div>
        </div>
      </div>
    </div>
  `;
  document.getElementById('adoptionDetailsBody').innerHTML = html;
}

async function confirmAndCancel(requestId) {
  if (!requestId) {
    alert('Invalid request ID');
    return;
  }

  try {
    const response = await fetch('user_adoption_handler.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `action=cancel&request_id=${requestId}`
    });
    
    const data = await response.json();
    if (data.success) {
      // Close the confirmation modal
      const confirmModal = bootstrap.Modal.getInstance(document.getElementById('cancelConfirmationModal'));
      if (confirmModal) {
        confirmModal.hide();
      }
      
      // Close view modal if open
      const viewModal = bootstrap.Modal.getInstance(document.getElementById('viewAdoptionModal'));
      if (viewModal) {
        viewModal.hide();
      }
      
      // Show success message
      alert(data.message);
      
      // Reload page to show updated status
      location.reload();
    } else {
      alert('Error: ' + (data.message || 'Unknown error'));
    }
  } catch (error) {
    console.error('Error canceling adoption request:', error);
    alert('Error processing request. Please try again.');
  }
}
</script> 