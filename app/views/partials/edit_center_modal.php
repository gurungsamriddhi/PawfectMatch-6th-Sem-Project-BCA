<!-- Error message container (AJAX will fill this) -->
<div id="edit-error-msg"></div>

<form  id="editCenterForm">
  <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">

  <div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Status</label>
    <select class="form-control" name="status" required>
      <option value="active" <?= $user['status'] === 'active' ? 'selected' : '' ?>>Active</option>
      <option value="inactive" <?= $user['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
    </select>
  </div>

  <div class="text-end">
    <button type="submit" class="btn btn-primary">Update</button>
  </div>
</form>
