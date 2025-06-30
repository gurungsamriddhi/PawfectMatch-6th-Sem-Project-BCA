<?php include 'app/views/partials/sidebar.php'; ?>
    <!-- Main Content -->
    <div class="body-wrapper w-100">
      <!-- Header -->
      <header class="app-header bg-dark text-white py-3 px-4">
        <div class="d-flex justify-content-between align-items-center">
          <h5 class="mb-0">All Pets</h5>
          <div class="d-flex align-items-center gap-3">
            <i class="fas fa-bell"></i>
            <i class="fas fa-user-circle"></i>
          </div>
        </div>
      </header>
      <!-- Content -->
      <div class="container-fluid py-4">
        <?php if (isset($_SESSION['success_message'])): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['success_message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
          <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['error_message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
          <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <div class="top-actions">
          <a href="index.php?page=admin/addpet" class="add-btn btn btn-success d-flex align-items-center gap-2" style="font-weight:600; font-size:1.1rem;">
            <i class="fa fa-plus"></i> Add Pet
          </a>
          <div class="filter-group">
            <label for="typeFilter"><i class="fa-solid fa-folder-open"></i> Filter by Type:</label>
            <select class="filter" id="typeFilter" onchange="filterByType(this)">
              <option value="All">All</option>
              <option value="Dog">Dog</option>
              <option value="Cat">Cat</option>
              <option value="Rabbit">Rabbit</option>
              <option value="Bird">Bird</option>
              <option value="Hamster">Hamster</option>
              <option value="Fish">Fish</option>
              <option value="Other">Other</option>
            </select>
          </div>
        </div>
        <div class="table-responsive mt-5">
          <table class="table view-table" id="animalTable">
            <thead>
              <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Breed</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Status</th>
                <th>Posted By</th>
                <th>Adoption Center</th>
                <th>Description</th>
                <th>Health</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($pets)): ?>
                <?php foreach ($pets as $pet): ?>
                  <tr data-type="<?php echo htmlspecialchars($pet['type']); ?>">
                    <td><?php echo htmlspecialchars($pet['name']); ?></td>
                    <td><?php echo htmlspecialchars($pet['type']); ?></td>
                    <td><?php echo htmlspecialchars($pet['breed']); ?></td>
                    <td><?php echo htmlspecialchars($pet['age']); ?></td>
                    <td><?php echo htmlspecialchars($pet['gender']); ?></td>
                    <td>
                      <span class="status-badge status-<?php echo strtolower($pet['status']); ?>">
                        <?php echo htmlspecialchars(ucfirst($pet['status'])); ?>
                      </span>
                    </td>
                    <td><?php echo htmlspecialchars($pet['posted_by_name'] ?? 'Unknown'); ?></td>
                    <td><?php echo htmlspecialchars($pet['adoption_center']); ?></td>
                    <td><?php echo htmlspecialchars(substr($pet['description'], 0, 50)) . (strlen($pet['description']) > 50 ? '...' : ''); ?></td>
                    <td><?php echo htmlspecialchars($pet['health_status']); ?></td>
                    <td>
                      <div class="action-buttons d-flex gap-2">
                        <button class="icon-btn edit" title="Edit" onclick="editPet(<?php echo $pet['pet_id']; ?>)" data-bs-toggle="modal" data-bs-target="#editPetModal">
                          <i class="fa fa-pen"></i>
                        </button>
                        <button class="icon-btn delete" title="Delete" onclick="deletePet(<?php echo $pet['pet_id']; ?>)">
                          <i class="fa fa-trash"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="11" class="text-center">No pets found.</td>
                </tr>
              <?php endif; ?>
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
          <a href="http://localhost/PawfectMatch/index.php?page=" class="btn btn-danger">Logout</a>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Sidebar submenu toggle logic
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('.sidebar-link.has-arrow').forEach(function(link) {
        link.addEventListener('click', function(e) {
          e.preventDefault();
          var parent = link.closest('.sidebar-item');
          parent.classList.toggle('open');
        });
      });
    });

    // Filter by type
    function filterByType(select) {
      var type = select.value;
      var rows = document.querySelectorAll('#animalTable tbody tr');
      rows.forEach(function(row) {
        if (type === 'All' || row.getAttribute('data-type') === type) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    }

    // Edit Pet Function
    function editPet(petId) {
      fetch(`index.php?page=admin/getPetById&id=${petId}`)
        .then(response => response.json())
        .then(pet => {
          if (pet.error) {
            alert('Error loading pet data: ' + pet.error);
            return;
          }
          
          // Populate the edit form
          document.getElementById('editPetName').value = pet.name;
          document.getElementById('editPetType').value = pet.type;
          document.getElementById('editBreed').value = pet.breed;
          document.getElementById('editAge').value = pet.age;
          document.getElementById('editGender').value = pet.gender;
          document.getElementById('editDateArrival').value = pet.date_arrival;
          document.getElementById('editSize').value = pet.size;
          document.getElementById('editWeight').value = pet.weight;
          document.getElementById('editColor').value = pet.color;
          document.getElementById('editHealthStatus').value = pet.health_status;
          document.getElementById('editDescription').value = pet.description;
          document.getElementById('editAdoptionCenter').value = pet.adoption_center;
          document.getElementById('editContactPhone').value = pet.contact_phone;
          document.getElementById('editContactEmail').value = pet.contact_email;
          document.getElementById('editCenterAddress').value = pet.center_address;
          document.getElementById('editCenterWebsite').value = pet.center_website || '';
          
          // Add hidden input for pet ID
          let hiddenInput = document.getElementById('editPetId');
          if (!hiddenInput) {
            hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.id = 'editPetId';
            hiddenInput.name = 'pet_id';
            document.getElementById('editPetForm').appendChild(hiddenInput);
          }
          hiddenInput.value = petId;
          
          // Add hidden input for current image
          let imageInput = document.getElementById('editCurrentImage');
          if (!imageInput) {
            imageInput = document.createElement('input');
            imageInput.type = 'hidden';
            imageInput.id = 'editCurrentImage';
            imageInput.name = 'current_image';
            document.getElementById('editPetForm').appendChild(imageInput);
          }
          imageInput.value = pet.image_path || 'public/assets/images/pets.png';
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Error loading pet data. Please try again.');
        });
    }

    // Delete Pet Function
    function deletePet(petId) {
      if (confirm('Are you sure you want to delete this pet? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'index.php?page=admin/deletePet';
        
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'pet_id';
        input.value = petId;
        
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
      }
    }

    // Update edit form action
    document.getElementById('editPetForm').action = 'index.php?page=admin/updatePet';
    document.getElementById('editPetForm').method = 'POST';
    document.getElementById('editPetForm').enctype = 'multipart/form-data';
  </script>
  <style>
    .action-buttons .icon-btn {
      width: 30px;
      height: 30px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      border: 2px solid #e0e0e0;
      background: #fff;
      box-shadow: 0 2px 8px rgba(0,0,0,0.04);
      font-size: 1rem;
      margin-right: 8px;
      transition: all 0.2s;
      cursor: pointer;
      outline: none;
      margin-top: -45px;
    }
    .action-buttons .icon-btn:last-child { margin-right: 0; }
    .action-buttons .icon-btn.edit {
      color: #1976d2;
      border-color: #1976d2;
    }
    .action-buttons .icon-btn.delete {
      color: #d32f2f;
      border-color: #d32f2f;
    }
    .action-buttons .icon-btn.edit:hover, .action-buttons .icon-btn.edit:focus {
      background: #1976d2;
      color: #fff;
      border-color: #1976d2;
    }
    .action-buttons .icon-btn.delete:hover, .action-buttons .icon-btn.delete:focus {
      background: #d32f2f;
      color: #fff;
      border-color: #d32f2f;
    }
  </style>
</body>
</html>
