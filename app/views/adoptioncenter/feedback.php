<?php include 'app/views/partials/sidebarcenter.php'; ?>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar column -->
    <div class="col-md-2 p-0"></div>

    <!-- Main content -->
    <div class="col-md-10 py-4 body-wrapper">
      <div class="card p-4">
        <div class="mb-3">
          <h3 class="fw-bold m-0">
            <i class="fas fa-comments me-2 text-info"></i>Feedback
          </h3>
          <p class="text-muted mb-0" style="font-size: 0.9rem;">Messages sent to this center</p>
        </div>

        <div class="table-responsive">
          <table class="table table-hover table-bordered align-middle">
            <thead class="table-info">
              <tr>
                <th>#</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <!-- Static example rows -->
              <tr>
                <td>1</td>
                <td>Jane Doe</td>
                <td>jane@example.com</td>
                <td>This adoption process is very smooth and efficient.</td>
                <td>2025-06-20</td>
                <td><span class="badge bg-warning">Unread</span></td>
                <td>
                  <button class="btn btn-primary btn-sm me-1">View</button>
                  <button class="btn btn-success btn-sm">Mark as Read</button>
                </td>
              </tr>
              <tr>
                <td>2</td>
                <td>John Smith</td>
                <td>john@example.com</td>
                <td>Thank you for your support! Great experience.</td>
                <td>2025-06-18</td>
                <td><span class="badge bg-success">Read</span></td>
                <td>
                  <button class="btn btn-primary btn-sm me-1">View</button>
                  <button class="btn btn-secondary btn-sm" disabled>Mark as Read</button>
                </td>
              </tr>
              <!-- Add more static rows here -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
