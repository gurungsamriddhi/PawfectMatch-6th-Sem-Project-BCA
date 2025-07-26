<?php if (!empty($user)): ?>
    <div class="modal-header">
        <h5 class="modal-title">User Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
        <p><strong>Name:</strong> <?= htmlspecialchars($user['name'] ?? '') ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email'] ?? '') ?></p>

        <?php if (!empty($user['volunteer_id'])): ?>
            <hr>
            <h6>Volunteer Information</h6>
            <p><strong>Contact Number:</strong> <?= htmlspecialchars($user['contact_number'] ?? '') ?></p>
            <p><strong>Area of Interest:</strong> <?= htmlspecialchars($user['area'] ?? '') ?></p>
            <p><strong>Availability Days:</strong> <?= htmlspecialchars($user['availability_days'] ?? '') ?></p>
            <p><strong>Status:</strong> <?= htmlspecialchars($user['volunteer_status'] ?? '') ?></p>
            <p><strong>Applied On:</strong> <?= htmlspecialchars($user['applied_at'] ?? '') ?></p>

            <?php if (!empty($user['assigned_center_name'])): ?>
                <p><strong>Assigned Center:</strong> <?= htmlspecialchars($user['assigned_center_name']) ?></p>
            <?php endif; ?>

            <hr>
            <h6>Volunteer Address</h6>
            <p><strong>Address Line 1:</strong> <?= htmlspecialchars($user['address_line1'] ?? '') ?></p>
            <p><strong>Address Line 2:</strong> <?= htmlspecialchars($user['address_line2'] ?? '') ?></p>
            <p><strong>City:</strong> <?= htmlspecialchars($user['city'] ?? '') ?></p>
            <p><strong>Province:</strong> <?= htmlspecialchars($user['province'] ?? '') ?></p>
            <p><strong>Postal Code:</strong> <?= htmlspecialchars($user['postal_code'] ?? '') ?></p>
        <?php endif; ?>
    </div>
    <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
<?php else: ?>
    <div class="modal-body">
        <p>User data not found.</p>
    </div>
<?php endif; ?>
