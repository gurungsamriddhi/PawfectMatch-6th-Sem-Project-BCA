<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Animal Management - PawfectMatch</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="/PawfectMatch/public/assets/css/dashboard.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <style>
    .top-actions {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 24px;
    }
    .add-pet-btn {
      background: var(--primary-color);
      color: #fff;
      border: none;
      border-radius: 8px;
      padding: 12px 28px;
      font-size: 17px;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 10px;
      transition: all 0.2s;
      box-shadow: 0 2px 8px rgba(67, 108, 93, 0.10);
      text-decoration: none;
    }
    .add-pet-btn:hover {
      background: #3b5d50;
      color: #fff;
      transform: translateY(-2px);
      text-decoration: none;
    }
    .filter-group {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .filter-group label {
      font-weight: 500;
      color: var(--primary-color);
      font-size: 16px;
    }
    .filter-group select {
      border-radius: 6px;
      padding: 8px 12px;
      border: 1px solid #ccc;
      font-size: 15px;
    }
    .pet-table {
      background: #fff;
      border-radius: 18px;
      box-shadow: var(--shadow);
      overflow: hidden;
      margin-bottom: 0;
    }
    .pet-table th, .pet-table td {
      vertical-align: middle;
      font-size: 15px;
      padding: 18px 14px;
      border: none;
    }
    .pet-table th {
      background: var(--primary-color);
      color: #fff;
      text-transform: uppercase;
      font-size: 13px;
      letter-spacing: 0.5px;
      border: none;
      font-weight: 700;
    }
    .pet-table tr {
      transition: background 0.15s;
    }
    .pet-table tbody tr:hover {
      background: #ececec;
    }
    .pet-table td {
      background: #fff;
      font-weight: 500;
    }
    .status-badge {
      display: inline-block;
      padding: 4px 14px;
      border-radius: 20px;
      font-size: 13px;
      font-weight: 600;
      letter-spacing: 0.5px;
    }
    .status-available {
      background: #e6f7ea;
      color: #22a722;
      border: 1px solid #b6e2c6;
    }
    .status-adopted {
      background: #ffeaea;
      color: #e53935;
      border: 1px solid #f7bdbd;
    }
    .status-reserved {
      background: #fffbe6;
      color: #f9bf29;
      border: 1px solid #f7e6b6;
    }
    .action-buttons {
      display: flex;
      flex-direction: column;
      gap: 10px;
      align-items: flex-start;
      padding-right: 10px;
    }
    .edit-btn {
      background: #2563eb;
      color: #fff;
      border: none;
      border-radius: 6px;
      padding: 7px 18px;
      font-size: 15px;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 6px;
      transition: background 0.2s;
      box-shadow: 0 2px 8px rgba(37,99,235,0.08);
      margin-bottom: 4px;
      width: 100%;
    }
    .edit-btn:last-child {
      margin-bottom: 0;
    }
    .edit-btn:hover {
      background: #1746a2;
      color: #fff;
    }
    .delete-btn {
      background: #e53935;
      color: #fff;
      border: none;
      border-radius: 6px;
      padding: 7px 18px;
      font-size: 15px;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 6px;
      transition: background 0.2s;
      box-shadow: 0 2px 8px rgba(229,57,53,0.08);
      width: 100%;
    }
    .delete-btn:hover {
      background: #b71c1c;
      color: #fff;
    }
    .table-responsive {
      overflow-x: unset !important;
    }
    @media (max-width: 768px) {
      .top-actions {
        flex-direction: column;
        gap: 16px;
        align-items: stretch;
      }
      .pet-table th, .pet-table td {
        font-size: 13px;
        padding: 10px 6px;
      }
      .action-buttons {
        width: 100%;
        padding-right: 0;
      }
      .edit-btn, .delete-btn {
        width: 100%;
      }
    }
  </style>
</head>
<body>
  <div class="page-wrapper d-flex">
    <!-- Sidebar -->
    <aside class="left-sidebar d-flex flex-column">
      <div class="brand-logo text-center py-3 sticky-top" style="z-index: 2;">
        <h2 class="m-0">PawfectMatch</h2>
      </div>
      <nav class="sidebar-nav flex-grow-1 overflow-y-auto">
        <ul class="list-unstyled px-2">
          <li class="sidebar-item">
            <a href="admin_dashboard.php" class="sidebar-link"><i class="fas fa-home me-2"></i> Dashboard</a>
          </li>
          <li class="sidebar-item has-submenu open">
            <a href="#" class="sidebar-link has-arrow active" data-toggle="submenu"><i class="fas fa-paw me-2"></i> Pet Management</a>
            <ul class="first-level list-unstyled ps-3" style="display:block;">
              <li class="sidebar-item"><a href="animalManagement.php" class="sidebar-link active"><i class="fa-solid fa-clipboard-list me-2"></i>All Pets</a></li>
              <li class="sidebar-item"><a href="addpet.php" class="sidebar-link"><i class="fa-solid fa-plus me-2"></i>Add New Pet</a></li>
            </ul>
          </li>
          <li class="sidebar-item has-submenu">
            <a href="#" class="sidebar-link has-arrow" data-toggle="submenu"><i class="fa-solid fa-user me-2"></i> User Management</a>
            <ul class="first-level list-unstyled ps-3">
              <li class="sidebar-item"><a href="userManagement.php" class="sidebar-link"><i class="fa-solid fa-user me-2"></i>Add User</a></li>
              <li class="sidebar-item"><a href="#" class="sidebar-link"><i class="fa-solid fa-house-chimney me-2"></i>Adoption Centers</a></li>
              <li class="sidebar-item"><a href="#" class="sidebar-link"><i class="fa-solid fa-plus me-2"></i>Add Adoption Center</a></li>
            </ul>
          </li>
          <li class="sidebar-item">
            <a href="#" class="sidebar-link"><i class="fas fa-envelope-open-text me-2"></i>Message Requests</a>
          </li>
          <li class="sidebar-item">
            <a href="#" class="sidebar-link"><i class="fas fa-handshake me-2"></i>Volunteer Requests</a>
          </li>
          <li class="sidebar-item">
            <a href="#" class="sidebar-link"><i class="fas fa-comment-dots me-2"></i>View Feedback</a>
          </li>
          <li class="sidebar-item">
            <a href="donation.php" class="sidebar-link"><i class="fas fa-donate me-2"></i>Donation</a>
          </li>
          <li class="sidebar-item">
            <a href="#" class="sidebar-link" data-bs-toggle="modal" data-bs-target="#logoutModal">
              <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
          </li>
        </ul>
      </nav>
    </aside>
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
        <div class="top-actions">
          <a href="addpet.php" class="add-pet-btn"><i class="fa-solid fa-plus"></i> Add Pet</a>
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
        <div class="table-responsive">
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
  <script>
    // Sidebar submenu toggle logic
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('.sidebar-link.has-arrow').forEach(function(link) {
        link.addEventListener('click', function(e) {
          // Only toggle if the arrow itself is clicked
          e.preventDefault();
          var parent = link.closest('.sidebar-item');
          parent.classList.toggle('open');
        });
      });
      // Prevent closing submenus when clicking submenu items
      document.querySelectorAll('.first-level .sidebar-link').forEach(function(link) {
        link.addEventListener('click', function(e) {
          // Do nothing: keep submenu open
          var parent = link.closest('.sidebar-item');
          parent.classList.add('open');
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
