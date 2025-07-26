<?php include 'app/views/adoptioncenter/centerpartials/sidebarcenter.php'; ?>
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
.status-rejected { background: #dc3545; color: #fff; }
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
.adoption-actions .accept-btn {
  background: #28a745;
  color: #fff;
}
.adoption-actions .accept-btn:hover {
  background: #218838;
  transform: scale(1.04);
}
.adoption-actions .reject-btn {
  background: #dc3545;
  color: #fff;
}
.adoption-actions .reject-btn:hover {
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
<div class="body-wrapper w-100">
  <header class="app-header bg-dark text-white py-3 px-4">
    <div class="d-flex justify-content-between align-items-center">
      <h5 class="mb-0"><i class="fas fa-file-signature me-2"></i>Adoption Requests</h5>
    </div>
  </header>
  <div class="container-fluid py-4">
    <h4 class="section-title mb-4" style="color: #436C5D;"><i class="fas fa-paw me-2"></i>All Adoption Requests</h4>
    <?php if (!empty($requests)): ?>
      <?php foreach ($requests as $i => $request): ?>
        <div class="adoption-card">
          <img class="adoption-thumb" src="<?= htmlspecialchars($request['image_path'] ?? 'public/assets/images/pets.png') ?>" alt="Pet">
          <div class="adoption-details">
            <div class="adoption-name">
              <?= htmlspecialchars($request['requester_name']) ?>
              <?php 
                $status = $request['request_status'] ?? 'pending';
                $statusClass = 'status-pending';
                $statusText = 'Pending';
                
                if (strtolower($status) === 'approved' || strtolower($status) === 'accepted') {
                    $statusClass = 'status-accepted';
                    $statusText = 'Accepted';
                } elseif (strtolower($status) === 'rejected') {
                    $statusClass = 'status-rejected';
                    $statusText = 'Rejected';
                }
              ?>
              <span class="status-badge <?= $statusClass ?>"><?= $statusText ?></span>
            </div>
            <div class="adoption-phone"><i class="fa fa-phone me-1"></i><?= htmlspecialchars($request['phone']) ?></div>
            <div class="adoption-date"><i class="fa fa-calendar-alt me-1"></i><?= htmlspecialchars($request['preferred_date'] ?? $request['request_date']) ?></div>
            <div style="font-size:1rem; color:#3b5d50; margin-top:2px;"><i class="fa fa-dog me-1"></i><?= htmlspecialchars($request['pet_name']) ?> <span style="color:#888;">(<?= htmlspecialchars($request['pet_type'] ?? 'Pet') ?>, <?= htmlspecialchars($request['breed'] ?? 'Unknown') ?>)</span></div>
          </div>
          <div class="adoption-actions ms-auto">
            <button class="view-btn btn btn-sm" data-bs-toggle="modal" data-bs-target="#viewAdoptionModal" onclick='showAdoptionDetails(<?= json_encode($request, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)'><i class="fa fa-eye me-1"></i>View</button>
            <?php 
              $status = $request['request_status'] ?? 'pending';
              $isPending = (strtolower($status) === 'pending' || empty($status) || $status === null);
            ?>
            <?php if ($isPending): ?>
              <button class="accept-btn btn btn-sm" onclick="handleAdoptionAction('approve', <?= $request['request_id'] ?? $request['id'] ?>)"><i class="fa fa-check me-1"></i>Accept</button>
              <button class="reject-btn btn btn-sm" onclick="handleAdoptionAction('reject', <?= $request['request_id'] ?? $request['id'] ?>)"><i class="fa fa-times me-1"></i>Reject</button>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="text-center text-muted">No adoption requests found.</div>
    <?php endif; ?>
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
        <div id="modalActionButtons" style="display: none;">
          <button class="rounded-pill px-4" id="modalAcceptBtn" style="font-weight:600; min-width:120px; background:#28a745; color:#fff; border:none; font-size:1.1rem;"><i class="fa fa-check me-1"></i>Accept</button>
          <button class="rounded-pill px-4" id="modalRejectBtn" style="font-weight:600; min-width:120px; background:#dc3545; color:#fff; border:none; font-size:1.1rem;"><i class="fa fa-times me-1"></i>Reject</button>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
let currentRequestId = null;

function showAdoptionDetails(request) {
  currentRequestId = request.request_id || request.id;
  
  // Status badge logic
  let status = request.request_status || request.status || 'pending';
  let statusClass = 'bg-secondary';
  let statusText = 'Pending';
  if (status.toLowerCase() === 'approved' || status.toLowerCase() === 'accepted') { 
    statusClass = 'bg-success'; 
    statusText = 'Accepted'; 
  }
  else if (status.toLowerCase() === 'rejected') { 
    statusClass = 'bg-danger'; 
    statusText = 'Rejected'; 
  }
  else { 
    statusClass = 'bg-warning text-dark'; 
    statusText = 'Pending'; 
  }
  document.getElementById('modalStatusBadge').innerHTML = `<span class='badge ${statusClass}' style='font-size:1em; padding:6px 18px; border-radius:14px; font-weight:600;'>${statusText}</span>`;
  
  // Show/hide action buttons based on status
  const actionButtons = document.getElementById('modalActionButtons');
  const isPending = (status.toLowerCase() === 'pending' || !status || status === '');
  if (isPending) {
    actionButtons.style.display = 'flex';
  } else {
    actionButtons.style.display = 'none';
  }

  let html = `
    <div class='row g-4 align-items-center mb-4 flex-wrap'>
      <div class='col-md-4 text-center mb-3 mb-md-0'>
        ${request.image_path ? `<img src='${request.image_path}' style='width:140px;height:140px;object-fit:cover;border-radius:50%;border:3px solid #e2e9e8;box-shadow:0 6px 24px rgba(67,108,93,0.18);margin-bottom:12px;'>` : '<span class=\"text-muted\">No image</span>'}
      </div>
      <div class='col-md-8'>
        <div class='mb-3 pb-2' style='border-bottom:1px solid #f3f4f6; margin-bottom:18px;'>
          <span class='fw-bold' style='color:#3b5d50;font-size:1.18rem;'><i class='fa fa-paw me-2'></i>Animal Info</span>
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
      <span class='fw-bold' style='color:#3b5d50;font-size:1.18rem;'><i class='fa fa-user me-2'></i>Adopter Info</span>
    </div>
    <div class='row g-3 mb-4'>
      <div class='col-12 col-md-6 d-flex align-items-center'><span class='text-secondary fw-bold me-2'><i class='fa fa-user-circle me-1'></i>Name:</span> <span style='color:#2563eb; font-weight:600;'>${request.requester_name}</span></div>
      <div class='col-12 col-md-6 d-flex align-items-center'><span class='text-secondary fw-bold me-2'><i class='fa fa-phone me-1'></i>Phone:</span> <a href='tel:${request.phone}' style='color:#3b5d50; text-decoration:underline;'>${request.phone}</a></div>
      <div class='col-12 col-md-6 d-flex align-items-center'><span class='text-secondary fw-bold me-2'><i class='fa fa-envelope me-1'></i>Email:</span> <a href='mailto:${request.email || request.requester_email}' style='color:#2563eb; text-decoration:underline;'>${request.email || request.requester_email}</a></div>
      <div class='col-12 col-md-6 d-flex align-items-center'><span class='text-secondary fw-bold me-2'><i class='fa fa-map-marker-alt me-1'></i>Address:</span> <span style='color:#444;'>${request.address ?? ''}</span></div>
    </div>
    <div class='mb-4 pb-2' style='border-bottom:1px solid #f3f4f6;'>
      <span class='fw-bold' style='color:#3b5d50;font-size:1.18rem;'><i class='fa fa-info-circle me-2'></i>Request Details</span>
    </div>
    <div class='row g-3 mb-2'>
      <div class='col-12 col-md-6 d-flex align-items-center'><span class='text-secondary fw-bold me-2'><i class='fa fa-calendar-alt me-1'></i>Request Date:</span> <span style='color:#6c757d; font-size:0.98em;'>${request.preferred_date || request.request_date}</span></div>
      <div class='col-12 col-md-6 d-flex align-items-center'><span class='text-secondary fw-bold me-2'><i class='fa fa-home me-1'></i>Home Type:</span> <span style='color:#444;'>${request.home_type ?? ''}</span></div>
      <div class='col-12 col-md-6 d-flex align-items-center'><span class='text-secondary fw-bold me-2'><i class='fa fa-paw me-1'></i>Other Pets?:</span> <span class='badge ${request.has_other_pets ? 'bg-success' : 'bg-secondary'}' style='font-size:1em; padding:4px 14px;'>${request.has_other_pets ? 'Yes' : 'No'}</span></div>
      <div class='col-12 col-md-6 d-flex align-items-center'><span class='text-secondary fw-bold me-2'><i class='fa fa-comment-dots me-1'></i>Reason:</span> <span class='badge bg-primary' style='font-size:1em; padding:4px 14px; background:#e6f0fa !important; color:#2563eb !important;'>${request.reason || 'Not specified'}</span></div>
    </div>
  `;
  document.getElementById('adoptionDetailsBody').innerHTML = html;
  
  // Set up modal button handlers
  document.getElementById('modalAcceptBtn').onclick = () => handleAdoptionAction('approve', currentRequestId);
  document.getElementById('modalRejectBtn').onclick = () => handleAdoptionAction('reject', currentRequestId);
}

async function handleAdoptionAction(action, requestId) {
  if (!requestId) {
    alert('Invalid request ID');
    return;
  }

  const confirmMessage = action === 'approve' ? 
    'Are you sure you want to approve this adoption request?' : 
    'Are you sure you want to reject this adoption request?';
  
  if (!confirm(confirmMessage)) {
    return;
  }

  try {
    const response = await fetch('adoption_handler.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `action=${action}&request_id=${requestId}`
    });
    
    const data = await response.json();
    if (data.success) {
      alert(data.message);
      // Close modal if open
      const modal = bootstrap.Modal.getInstance(document.getElementById('viewAdoptionModal'));
      if (modal) {
        modal.hide();
      }
      // Reload page to show updated status
      location.reload();
    } else {
      alert('Error: ' + (data.message || 'Unknown error'));
    }
  } catch (error) {
    console.error('Error handling adoption action:', error);
    alert('Error processing request. Please try again.');
  }
}
</script>
