<?php include 'app/views/partials/sidebar.php'; ?>
<!-- Main Content -->
<div class="body-wrapper w-100">
  <!-- Header -->
  <header class="app-header bg-dark text-white py-3 px-4">
    <div class="d-flex justify-content-between align-items-center">
      <h5 class="mb-0">All Users</h5>
      <div class="d-flex align-items-center gap-3">
        <i class="fas fa-bell"></i>
        <i class="fas fa-user-circle"></i>
      </div>
    </div>
  </header>
  <!-- Content -->
  <div class="container-fluid py-4">
    <div class="top-actions">
      <a href="index.php?page=admin/addpet" class="add-pet-btn"><i class="fa-solid fa-plus"></i> Add Pet</a>
      <div class="filter-group">
        <label for="typeFilter"><i class="fa-solid fa-folder-open"></i> Filter by Type:</label>
        <select class="filter" id="typeFilter" onchange="filterByType(this)">
          <option value="All">All</option>
          <option value="Dog">Dog</option>
          <option value="Cat">Cat</option>
          <option value="Rabbit">Rabbit</option>
          <option value="Bird">Bird</option>
        </select>
      </div>
    </div>
    <div class="table-responsive mt-5">
      <table class="table pet-table" id="animalTable">
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
          <tr data-type="Dog">
            <td>Charlie</td>
            <td>Dog</td>
            <td>Labrador</td>
            <td>2</td>
            <td>Male</td>
            <td><span class="status-badge status-available">Available</span></td>
            <td>Admin</td>
            <td>Happy Paws Center</td>
            <td>Very friendly, playful and house-trained.</td>
            <td>Vaccinated</td>
            <td>
              <div class="action-buttons">
                <button class="edit-btn" data-bs-toggle="modal" data-bs-target="#editPetModal"><i class="fa-solid fa-pen"></i> Edit</button>
                <button class="delete-btn"><i class="fa-solid fa-trash"></i> Delete</button>
              </div>
            </td>
          </tr>
          <tr data-type="Dog">
            <td>Coco</td>
            <td>Dog</td>
            <td>Labrador</td>
            <td>3</td>
            <td>Female</td>
            <td><span class="status-badge status-available">Available</span></td>
            <td>Admin</td>
            <td>Happy Paws Center</td>
            <td>Very friendly</td>
            <td>Not Vaccinated</td>
            <td>
              <div class="action-buttons">
                <button class="edit-btn" data-bs-toggle="modal" data-bs-target="#editPetModal"><i class="fa-solid fa-pen"></i> Edit</button>
                <button class="delete-btn"><i class="fa-solid fa-trash"></i> Delete</button>
              </div>
            </td>
          </tr>
          <tr data-type="Cat">
            <td>Luna</td>
            <td>Cat</td>
            <td>Siamese</td>
            <td>1</td>
            <td>Female</td>
            <td><span class="status-badge status-adopted">Adopted</span></td>
            <td>Rejina</td>
            <td>Feline Friends Shelter</td>
            <td>Sweet and cuddly.</td>
            <td>Vaccinated</td>
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
<?php include 'app/views/partials/admin_footer.php'; ?>

<script>
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
  // Edit Pet Modal Logic (UI only)
  const editBtns = document.querySelectorAll('.edit-btn');
  const editPetForm = document.getElementById('editPetForm');
  let currentEditRow = null;
  editBtns.forEach(btn => {
    btn.addEventListener('click', function(e) {
      const row = btn.closest('tr');
      currentEditRow = row;
      document.getElementById('editPetName').value = row.children[0].textContent;
      document.getElementById('editPetType').value = row.children[1].textContent;
      document.getElementById('editBreed').value = row.children[2].textContent;
      document.getElementById('editAge').value = row.children[3].textContent;
      document.getElementById('editGender').value = row.children[4].textContent;
      document.getElementById('editDescription').value = row.children[8].textContent;
      document.getElementById('editAdoptionCenter').value = row.children[7].textContent;
      // The rest can be filled similarly if you store them in the table or as data-attributes
      document.getElementById('editDateArrival').value = '';
      document.getElementById('editSize').value = '';
      document.getElementById('editWeight').value = '';
      document.getElementById('editColor').value = '';
      document.getElementById('editHealthStatus').value = '';
      document.getElementById('editContactName').value = '';
      document.getElementById('editContactPhone').value = '';
      document.getElementById('editContactEmail').value = '';
      document.getElementById('editCenterAddress').value = '';
      document.getElementById('editCenterWebsite').value = '';
      document.getElementById('editAdoptionNotes').value = '';
    });
  });
  editPetForm.addEventListener('submit', function(e) {
    e.preventDefault();
    if (currentEditRow) {
      currentEditRow.children[0].textContent = document.getElementById('editPetName').value;
      currentEditRow.children[1].textContent = document.getElementById('editPetType').value;
      currentEditRow.children[2].textContent = document.getElementById('editBreed').value;
      currentEditRow.children[3].textContent = document.getElementById('editAge').value;
      currentEditRow.children[4].textContent = document.getElementById('editGender').value;
      currentEditRow.children[8].textContent = document.getElementById('editDescription').value;
      currentEditRow.children[7].textContent = document.getElementById('editAdoptionCenter').value;
      // The rest can be updated similarly if you store them in the table
    }
    var modal = bootstrap.Modal.getInstance(document.getElementById('editPetModal'));
    modal.hide();
  });
</script>
</body>

</html>