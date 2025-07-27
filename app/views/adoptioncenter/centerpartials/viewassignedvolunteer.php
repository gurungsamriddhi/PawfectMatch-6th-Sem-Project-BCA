<?php if (!empty($volunteer)): ?>
    <div class="modal-header">
        <h5 class="modal-title"> Assigned Volunteer Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">
        <!-- Basic volunteer Info -->
         
        <p><strong>Name:</strong> <?= htmlspecialchars($volunteer['name'] ?? 'N/A') ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($volunteer['email'] ?? 'N/A') ?></p>

        <?php if (!empty($volunteer['volunteer_id'])): ?>
            <hr>
            <h6 class="fw-semibold">Volunteer Information</h6>
            <p><strong>Contact Number:</strong> <?= htmlspecialchars($volunteer['contact_number'] ?? 'N/A') ?></p>
            <p><strong>Area of Interest:</strong> <?= htmlspecialchars($volunteer['area'] ?? 'N/A') ?></p>
            <p><strong>Availability Days:</strong> <?= htmlspecialchars($volunteer['availability_days'] ?? 'N/A') ?></p>
            <p><strong>Status:</strong> <?= htmlspecialchars($volunteer['volunteer_status'] ?? 'N/A') ?></p>
            <p><strong>Applied On:</strong> <?= htmlspecialchars($volunteer['applied_at'] ?? 'N/A') ?></p>

            <?php if (!empty($volunteer['assigned_center_name'])): ?>
                <p><strong>Assigned Center:</strong> <?= htmlspecialchars($volunteer['assigned_center_name']) ?></p>
            <?php endif; ?>

            <hr>
            <h6 class="fw-semibold">Volunteer Address</h6>
            <p><strong>Address Line 1:</strong> <?= htmlspecialchars($volunteer['address_line1'] ?? 'N/A') ?></p>
            <p><strong>Address Line 2:</strong> <?= htmlspecialchars($volunteer['address_line2'] ?? 'N/A') ?></p>
            <p><strong>City:</strong> <?= htmlspecialchars($volunteer['city'] ?? 'N/A') ?></p>
            <p><strong>Province:</strong> <?= htmlspecialchars($volunteer['province'] ?? 'N/A') ?></p>
            <p><strong>Postal Code:</strong> <?= htmlspecialchars($volunteer['postal_code'] ?? 'N/A') ?></p>
        <?php else: ?>
            <p class="text-muted">Volunteer data not available.</p>
        <?php endif; ?>
    </div>

    <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>

<?php else: ?>
    <div class="modal-body">
        <p class="text-danger">volunteer data not found.</p>
    </div>
<?php endif; ?>
