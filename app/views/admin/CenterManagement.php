


  <?php include 'app/views/partials/sidebar.php'; ?>
    <!-- Main Content -->
    <div class="body-wrapper w-100">
      <!-- Header -->
      <header class="app-header bg-dark text-white py-3 px-4">
        <div class="d-flex justify-content-between align-items-center">
          <h5 class="mb-0">All Adoption Centers</h5>
          <div class="d-flex align-items-center gap-3">
            <i class="fas fa-bell"></i>
            <i class="fas fa-user-circle"></i>
          </div>
        </div>
      </header>
      <!-- Content -->
      <div class="container-fluid py-4">
        <div class="top-actions">
          <a href="index.php?page=admin/add_centerform" class="add-pet-btn"><i class="fa-solid fa-plus"></i> Add Adoption Center</a>
          <div class="filter-group">
            <label for="typeFilter"><i class="fa-solid fa-folder-open"></i> Filter by Location:</label>
            <select class="filter" id="typeFilter" onchange="filterByType(this)">
              <option value="All">All</option>
              <option value="Pokhara">Pokhara</option>
              <option value="Kathmandu">Kathmandu</option>
              <option value="Chitwan">Chitwan</option>
              <option value="Tanahun">Tanahun</option>
            </select>
          </div>
        </div>
        <div class="table-responsive mt-5">
          <table class="table pet-table" id="animalTable">
            <thead>
              <tr>
                <th>user_id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Password</th>
                <th>is_verified</th>
                <th>user_type</th>
                <th>Registered_at</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr data-type="Pokhara">
                <td>1</td>
                <td>Himalayan Trust</td>
                <td>email.com</td>
                <td>vhejfhuwf</td>
                <td>1</td>
                <td>user_type</td>
                <td>29 june 2025</td>
                <td>
                  <div class="action-buttons">
                    <button class="edit-btn" data-bs-toggle="modal" data-bs-target="#editPetModal"><i class="fa-solid fa-pen"></i> Edit</button>
                    <button class="delete-btn"><i class="fa-solid fa-trash"></i> Delete</button>
                  </div>
                </td>
              </tr>
              <tr data-type="Tanahun">
                <td>1</td>
                <td>Himalayan Trust</td>
                <td>email.com</td>
                <td>vhejfhuwf</td>
                <td>1</td>
                <td>user_type</td>
                <td>29 june 2025</td>
                <td>
                  <div class="action-buttons">
                    <button class="edit-btn" data-bs-toggle="modal" data-bs-target="#editPetModal"><i class="fa-solid fa-pen"></i> Edit</button>
                    <button class="delete-btn"><i class="fa-solid fa-trash"></i> Delete</button>
                  </div>
                </td>
              </tr>
              <tr data-type="Tanahun">
                <td>1</td>
                <td>Himalayan Trust</td>
                <td>email.com</td>
                <td>vhejfhuwf</td>
                <td>1</td>
                <td>user_type</td>
                <td>29 june 2025</td>
                <td>
                  <div class="action-buttons">
                    <button class="edit-btn" data-bs-toggle="modal" data-bs-target="#editPetModal"><i class="fa-solid fa-pen"></i> Edit</button>
                    <button class="delete-btn"><i class="fa-solid fa-trash"></i> Delete</button>
                  </div>
                </td>
              </tr>
              <!-- Add more rows as needed -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- Edit Pet Modal -->
  <div class="modal fade" id="editPetModal" tabindex="-1" aria-labelledby="editPetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <form id="editPetForm">
          <div class="modal-header">
            <h5 class="modal-title" id="editPetModalLabel"><i class="fa-solid fa-pen-to-square me-2"></i>Edit Pet Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Pet Name *</label>
                <input type="text" class="form-control" id="editPetName" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Type *</label>
                <select class="form-select" id="editPetType" required>
                  <option value="Dog">Dog</option>
                  <option value="Cat">Cat</option>
                  <option value="Bird">Bird</option>
                  <option value="Rabbit">Rabbit</option>
                  <option value="Hamster">Hamster</option>
                  <option value="Fish">Fish</option>
                  <option value="Other">Other</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Breed *</label>
                <input type="text" class="form-control" id="editBreed" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Gender *</label>
                <select class="form-select" id="editGender" required>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Age (in years) *</label>
                <input type="number" class="form-control" id="editAge" min="0" step="0.1" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Date of Arrival *</label>
                <input type="date" class="form-control" id="editDateArrival" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Size *</label>
                <select class="form-select" id="editSize" required>
                  <option value="Small">Small</option>
                  <option value="Medium">Medium</option>
                  <option value="Large">Large</option>
                  <option value="Extra Large">Extra Large</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Weight (kg) *</label>
                <input type="number" class="form-control" id="editWeight" min="0" step="0.1" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Color *</label>
                <input type="text" class="form-control" id="editColor" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Health Status *</label>
                <select class="form-select" id="editHealthStatus" required>
                  <option value="Excellent">Excellent</option>
                  <option value="Good">Good</option>
                  <option value="Fair">Fair</option>
                  <option value="Poor">Poor</option>
                </select>
              </div>
              <div class="col-12">
                <label class="form-label">Description *</label>
                <textarea class="form-control" id="editDescription" rows="2" required></textarea>
              </div>
              <div class="col-12">
                <label class="form-label">Adoption Center Name *</label>
                <input type="text" class="form-control" id="editAdoptionCenter" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Contact Person Name *</label>
                <input type="text" class="form-control" id="editContactName" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Contact Phone *</label>
                <input type="tel" class="form-control" id="editContactPhone" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Contact Email *</label>
                <input type="email" class="form-control" id="editContactEmail" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Center Address *</label>
                <input type="text" class="form-control" id="editCenterAddress" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Center Website (Optional)</label>
                <input type="url" class="form-control" id="editCenterWebsite">
              </div>
              <div class="col-12">
                <label class="form-label">Adoption Process Notes</label>
                <textarea class="form-control" id="editAdoptionNotes" rows="2"></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save me-2"></i>Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Logout Confirmation Modal -->
  <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header border-0">
          <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to log out?
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <a href="http://localhost/PawfectMatch/index.php?page=home" class="btn btn-danger">Logout</a>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
</body>
</html>
