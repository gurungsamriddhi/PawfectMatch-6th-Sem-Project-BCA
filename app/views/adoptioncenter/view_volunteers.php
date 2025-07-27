<?php include 'app/views/adoptioncenter/centerpartials/sidebarcenter.php'; ?>
<?php
// echo '<pre>';
// print_r($volunteers);
// echo '</pre>';
?>

<!-- Main Content -->
<div class="body-wrapper w-100">
    <!-- Header -->
    <header class="app-header bg-dark text-white py-3 px-4">
        <div class="d-flex justify-content-between align-items-volunteer">
            <h5 class="mb-0">Volunteers Assigned</h5>
            <div class="d-flex align-items-volunteer gap-3">
                <i class="fas fa-bell"></i>
                <i class="fas fa-volunteer-circle"></i>
            </div>
        </div>
    </header>
    <!-- Content -->
    <div class="container-fluid py-4">
        <div class="top-actions">
            <!-- <a href="index.php?page=admin/add_volunteerform" class="add-btn"><i class="fa-solid fa-plus"></i> Add Adoption volunteer</a> -->
            <!-- <div class="filter-group">
                <label for="typeFilter"><i class="fa-solid fa-folder-open"></i> Filter by volunteername:</label>
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
        <table class="table view-table" id="volunteerTable">
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
                <?php foreach ($volunteers as $volunteer): ?>
                    <tr>
                        <td><?= htmlspecialchars($volunteer['name']) ?></td>
                        <td><?= htmlspecialchars($volunteer['email']) ?></td>
                        <td><?= htmlspecialchars($volunteer['contact_number']) ?></td>
                        <td><?= htmlspecialchars($volunteer['area']) ?></td>
                        <td><?= htmlspecialchars($volunteer['availability_days']) ?></td>


                        <td>
                            <?php if ($volunteer['status'] === 'assigned'): ?>
                                <span class="status-badge status-active">Assigned</span>

                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($volunteer['applied_at']) ?></td>
                        <td>
                            <?php if (!empty($volunteer['assigned_center'])): ?>
                                <?= htmlspecialchars($volunteer['assigned_center']) ?>

                            <?php endif; ?>
                        </td>

                        <td>

                            <div class="action-buttons">
                                <!-- View -->
                                <button type="button"
                                    class="btn btn-sm btn-outline-primary view-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#viewvolunteerModal"
                                    data-requestid="<?= $volunteer['volunteer_id'] ?>">
                                    <i class="fa-solid fa-eye"></i> View
                                </button>





                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
    </div>

    <!--view modal-->
    <div class="modal fade" id="viewvolunteerModal" tabindex="-1" aria-labelledby="viewLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
               
                <div class="modal-body" id="viewvolunteerBody">
                    <!-- Content filled via AJAX -->
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


</div>


<?php include 'app/views/adoptioncenter/centerpartials/center_footer.php'; ?>
<script src="public/assets/js/viewvolunteer.js"></script>