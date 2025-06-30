<?php include 'app/views/partials/sidebarcenter.php'; ?>

<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar column -->
    <div class="col-md-2 p-0"></div>

    <!-- Main content column -->
    <div class="col-md-10 py-4 body-wrapper">
      <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']); ?></div>
        <?php unset($_SESSION['success']); ?>
      <?php endif; ?>

      <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']); ?></div>
        <?php unset($_SESSION['error']); ?>
      <?php endif; ?>

      <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h3 class="fw-bold m-0"><i class="fas fa-envelope me-2 text-primary"></i>Adoption Requests</h3>
        </div>

        <div class="table-responsive">
          <table class="table table-hover table-bordered align-middle">
            <thead class="table-primary">
              <tr>
                <th>#</th>
                <th>Pet Name</th>
                <th>Requester Name</th>
                <th>Contact</th>
                <th>Request Date</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($requests)): ?>
                <?php $count = 1; foreach ($requests as $request): ?>
                  <tr>
                    <td><?= $count++; ?></td>
                    <td><?= htmlspecialchars($request['pet_name']) ?></td>
                    <td><?= htmlspecialchars($request['requester_name']) ?></td>
                    <td>
                      <?= htmlspecialchars($request['email']) ?><br>
                      <?= htmlspecialchars($request['phone']) ?>
                    </td>
                    <td><?= htmlspecialchars($request['request_date']) ?></td>
                    <td>
                      <span class="badge 
                        <?= $request['status'] === 'Pending' ? 'bg-warning' : 
                            ($request['status'] === 'Approved' ? 'bg-success' : 'bg-danger') ?>">
                        <?= htmlspecialchars($request['status']) ?>
                      </span>
                    </td>
                    <td>
                      <a href="index.php?page=adoptioncenter/approverequest&id=<?= $request['id'] ?>" class="btn btn-success btn-sm me-1">Approve</a>
                      <a href="index.php?page=adoptioncenter/rejectrequest&id=<?= $request['id'] ?>" class="btn btn-danger btn-sm">Reject</a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr><td colspan="7" class="text-center">No adoption requests found.</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
