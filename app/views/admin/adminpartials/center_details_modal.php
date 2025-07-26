<?php if ($center): ?>
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Name</label>
      <input type="text" class="form-control" value="<?= htmlspecialchars($center['name']??'') ?>" disabled>
    </div>
    <div class="col-md-6">
      <label class="form-label">Email</label>
      <input type="text" class="form-control" value="<?= htmlspecialchars($center['email']??'') ?>" disabled>
    </div>
    <div class="col-md-6">
      <label class="form-label">Phone</label>
      <input type="text" class="form-control" value="<?= htmlspecialchars($center['phone']??'') ?>" disabled>
    </div>
    <div class="col-md-6">
      <label class="form-label">Established Date</label>
      <input type="text" class="form-control" value="<?= htmlspecialchars($center['established_date']??'') ?>" disabled>
    </div>
    <div class="col-md-12">
      <label class="form-label">Location</label>
      <input type="text" class="form-control" value="<?= htmlspecialchars($center['location']??'') ?>" disabled>
    </div>
     <div class="col-md-12">
      <label class="form-label">Number of Employees</label>
      <input type="text" class="form-control" value="<?= htmlspecialchars($center['number_of_employees']??'') ?>" disabled>
    </div>
    <div class="col-md-12">
      <label class="form-label">Description</label>
      <textarea class="form-control" rows="3" disabled><?= htmlspecialchars($center['description']??'') ?></textarea>
    </div>
     <div class="col-md-12">
      <label class="form-label">Operating hours</label>
      <input type="text" class="form-control" value="<?= htmlspecialchars($center['operating_hours']??'') ?>" disabled>
    </div>
  </div>
<?php else: ?>
  <p class="text-danger">No adoption center data found.</p>
<?php endif; ?>
