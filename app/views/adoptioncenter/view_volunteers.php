<?php include 'app/views/adoptioncenter/centerpartials/sidebarcenter.php'; ?>
<!-- Main Content -->
<div class="body-wrapper w-100">
    <!-- Header -->
    <header class="app-header bg-dark text-white py-3 px-4">
        <div class="d-flex justify-content-between align-items-request">
            <h5 class="mb-0">Volunteers Assigned</h5>
            <div class="d-flex align-items-request gap-3">
                <i class="fas fa-bell"></i>
                <i class="fas fa-request-circle"></i>
            </div>
        </div>
    </header>
    <!-- Content -->
    <div class="container-fluid py-4">
        <div class="top-actions">
            <!-- <a href="index.php?page=admin/add_requestform" class="add-btn"><i class="fa-solid fa-plus"></i> Add Adoption request</a> -->
            <!-- <div class="filter-group">
                <label for="typeFilter"><i class="fa-solid fa-folder-open"></i> Filter by requestname:</label>
                <select class="filter" id="typeFilter" onchange="filterByType(this)">
                    <option value="All">All</option>
                    <option value="Pokhara">Pokhara</option>
                    <option value="Kathmandu">Kathmandu</option>
                    <option value="Chitwan">Chitwan</option>
                    <option value="Tanahun">Tanahun</option>
                </select> -->
        </div>
    </div>
    <div class="table-responsive">
        <table class="table view-table" id="requestTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact Number</th>
                    <th>Area of Interest</th>
                    <th>Availability Days</th>
                    <th>Status</th>
                    <th>Applied Date</th>
                    <th>Assigned Center</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requests as $request): ?>
                    <tr>
                        <td><?= htmlspecialchars($request['name']) ?></td>
                        <td><?= htmlspecialchars($request['email']) ?></td>
                        <td><?= htmlspecialchars($request['contact_number']) ?></td>
                        <td><?= htmlspecialchars($request['area']) ?></td>
                        <td><?= htmlspecialchars($request['availability_days']) ?></td>


                        <td>
                            <?php if ($request['status'] === 'assigned'): ?>
                                <span class="status-badge status-active">Assigned</span>

                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($request['applied_at']) ?></td>
                        <td>
                            <?php if (!empty($request['assigned_center'])): ?>
                                <?= htmlspecialchars($request['assigned_center']) ?>

                            <?php endif; ?>
                        </td>

                        <td>

                            <div class="action-buttons">
                                <!-- View -->
                                <button type="button"
                                    class="btn btn-sm btn-outline-primary view-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#viewrequestModal"
                                    data-requestid="<?= $request['volunteer_id'] ?>">
                                    <i class="fa-solid fa-eye"></i> View
                                </button>





                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
    </div>

    <!--view modal-->
    <div class="modal fade" id="viewrequestModal" tabindex="-1" aria-labelledby="viewLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-requested modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-body" id="viewRequestBody">
                    <!-- Content filled via AJAX -->

                </div>
            </div>
        </div>
    </div>


</div>




<?php include 'app/views/adoptioncenter/centerpartials/center_footer.php'; ?>
<script src="public/assets/js/volunteerrequest_management.js"></script>