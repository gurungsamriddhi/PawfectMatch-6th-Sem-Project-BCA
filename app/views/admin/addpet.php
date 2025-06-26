<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Add New Pet - PawfectMatch</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="/PawfectMatch/public/assets/css/dashboard.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

  <!-- Bootstrap JS Bundle (includes Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    .form-section {
      background: var(--card-bg);
      border-radius: 12px;
      padding: 25px;
      margin-bottom: 25px;
      box-shadow: var(--shadow);
    }

    .section-header {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
      padding-bottom: 15px;
      border-bottom: 2px solid var(--light-bg);
    }

    .section-header i {
      font-size: 24px;
      color: var(--primary-color);
      margin-right: 12px;
    }

    .section-header h4 {
      color: var(--primary-color);
      margin: 0;
      font-weight: 600;
    }

    .form-label {
      font-weight: 500;
      color: var(--text-dark);
      margin-bottom: 8px;
    }

    .form-control, .form-select {
      border: 2px solid #e9ecef;
      border-radius: 8px;
      padding: 12px 15px;
      font-size: 14px;
      transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 0.2rem rgba(67, 108, 93, 0.25);
    }

    .file-upload-area {
      border: 2px dashed #dee2e6;
      border-radius: 12px;
      padding: 40px 20px;
      text-align: center;
      background: #f8f9fa;
      transition: all 0.3s ease;
      cursor: pointer;
    }

    .file-upload-area:hover {
      border-color: var(--primary-color);
      background: #f0f9f0;
    }

    .file-upload-area.dragover {
      border-color: var(--primary-color);
      background: #e8f5e8;
    }

    .upload-icon {
      font-size: 48px;
      color: var(--primary-color);
      margin-bottom: 15px;
    }

    .upload-text {
      color: #6c757d;
      font-size: 16px;
      margin-bottom: 10px;
    }

    .upload-hint {
      color: #adb5bd;
      font-size: 14px;
    }

    .preview-container {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      margin-top: 20px;
    }

    .preview-item {
      position: relative;
      width: 120px;
      height: 120px;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .preview-item img, .preview-item video {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .remove-preview {
      position: absolute;
      top: 5px;
      right: 5px;
      background: rgba(220, 53, 69, 0.9);
      color: white;
      border: none;
      border-radius: 50%;
      width: 25px;
      height: 25px;
      font-size: 12px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .btn-primary {
      background: var(--primary-color);
      border: none;
      border-radius: 8px;
      padding: 12px 30px;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .btn-primary:hover {
      background: #3b5d50;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(67, 108, 93, 0.3);
    }

    .btn-secondary {
      background: #6c757d;
      border: none;
      border-radius: 8px;
      padding: 12px 30px;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .btn-danger {
      background: #dc3545;
      border: none;
      border-radius: 8px;
      padding: 12px 30px;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .btn-danger:hover {
      background: #c82333;
      transform: translateY(-2px);
    }

    .action-buttons {
      display: flex;
      gap: 15px;
      justify-content: center;
      margin-top: 30px;
      padding-top: 30px;
      border-top: 2px solid var(--light-bg);
    }

    .form-row {
      display: flex;
      gap: 20px;
      margin-bottom: 20px;
    }

    .form-col {
      flex: 1;
    }

    .health-status-indicator {
      display: inline-block;
      width: 12px;
      height: 12px;
      border-radius: 50%;
      margin-right: 8px;
    }

    .health-excellent { background: #28a745; }
    .health-good { background: #17a2b8; }
    .health-fair { background: #ffc107; }
    .health-poor { background: #dc3545; }

    .characteristics-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 15px;
      margin-top: 15px;
    }

    .characteristic-item {
      display: flex;
      align-items: center;
      padding: 10px;
      background: #f8f9fa;
      border-radius: 6px;
      border: 1px solid #e9ecef;
    }

    .characteristic-item input[type="checkbox"] {
      margin-right: 10px;
    }

    @media (max-width: 768px) {
      .form-row {
        flex-direction: column;
        gap: 0;
      }
      
      .action-buttons {
        flex-direction: column;
      }
      
      .characteristics-grid {
        grid-template-columns: 1fr;
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
          <li class="sidebar-item has-submenu">
            <a href="#" class="sidebar-link has-arrow active" data-toggle="submenu"><i class="fas fa-paw me-2"></i> Pet Management</a>
            <ul class="first-level list-unstyled ps-3">
              <li class="sidebar-item"><a href="animalManagement.php" class="sidebar-link"><i class="fa-solid fa-clipboard-list me-2"></i>All Pets</a></li>
              <li class="sidebar-item"><a href="addpet.php" class="sidebar-link active"><i class="fa-solid fa-plus me-2"></i>Add New Pet</a></li>
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
          <h5 class="mb-0">Add New Pet</h5>
          <div class="d-flex align-items-center gap-3">
            <i class="fas fa-bell"></i>
            <i class="fas fa-user-circle"></i>
          </div>
        </div>
      </header>

      <!-- Content -->
      <div class="container-fluid py-4">
        <form id="addPetForm" enctype="multipart/form-data">
          <!-- Basic Info Section -->
          <div class="form-section">
            <div class="section-header">
              <i class="fas fa-info-circle"></i>
              <h4>Basic Information</h4>
            </div>
            
            <div class="form-row">
              <div class="form-col">
                <label for="petName" class="form-label">Pet Name *</label>
                <input type="text" class="form-control" id="petName" name="petName" required>
              </div>
              <div class="form-col">
                <label for="petType" class="form-label">Type *</label>
                <select class="form-select" id="petType" name="petType" required>
                  <option value="">Select Pet Type</option>
                  <option value="Dog">Dog</option>
                  <option value="Cat">Cat</option>
                  <option value="Bird">Bird</option>
                  <option value="Rabbit">Rabbit</option>
                  <option value="Hamster">Hamster</option>
                  <option value="Fish">Fish</option>
                  <option value="Other">Other</option>
                </select>
              </div>
            </div>

            <div class="form-row">
              <div class="form-col">
                <label for="breed" class="form-label">Breed *</label>
                <input type="text" class="form-control" id="breed" name="breed" required>
              </div>
              <div class="form-col">
                <label for="gender" class="form-label">Gender *</label>
                <select class="form-select" id="gender" name="gender" required>
                  <option value="">Select Gender</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>
            </div>

            <div class="form-row">
              <div class="form-col">
                <label for="age" class="form-label">Age (in years) *</label>
                <input type="number" class="form-control" id="age" name="age" min="0" step="0.1" required>
              </div>
              <div class="form-col">
                <label for="dateArrival" class="form-label">Date of Arrival *</label>
                <input type="date" class="form-control" id="dateArrival" name="dateArrival" required>
              </div>
            </div>
          </div>

          <!-- Media Section -->
          <div class="form-section">
            <div class="section-header">
              <i class="fas fa-images"></i>
              <h4>Media</h4>
            </div>
            
            <div class="mb-4">
              <label class="form-label">Upload Photos *</label>
              <div class="file-upload-area" id="photoUploadArea">
                <div class="upload-icon">
                  <i class="fas fa-camera"></i>
                </div>
                <div class="upload-text">Click to upload photos or drag and drop</div>
                <div class="upload-hint">Supports: JPG, PNG, GIF (Max 5MB each)</div>
                <input type="file" id="photos" name="photos[]" multiple accept="image/*" style="display: none;">
              </div>
              <div class="preview-container" id="photoPreview"></div>
            </div>

            <div class="mb-4">
              <label class="form-label">Upload Video (Optional)</label>
              <div class="file-upload-area" id="videoUploadArea">
                <div class="upload-icon">
                  <i class="fas fa-video"></i>
                </div>
                <div class="upload-text">Click to upload video or drag and drop</div>
                <div class="upload-hint">Supports: MP4, AVI, MOV (Max 50MB)</div>
                <input type="file" id="video" name="video" accept="video/*" style="display: none;">
              </div>
              <div class="preview-container" id="videoPreview"></div>
            </div>
          </div>

          <!-- Physical Details Section -->
          <div class="form-section">
            <div class="section-header">
              <i class="fas fa-ruler-combined"></i>
              <h4>Physical Details</h4>
            </div>
            
            <div class="form-row">
              <div class="form-col">
                <label for="size" class="form-label">Size *</label>
                <select class="form-select" id="size" name="size" required>
                  <option value="">Select Size</option>
                  <option value="Small">Small</option>
                  <option value="Medium">Medium</option>
                  <option value="Large">Large</option>
                  <option value="Extra Large">Extra Large</option>
                </select>
              </div>
              <div class="form-col">
                <label for="weight" class="form-label">Weight (kg) *</label>
                <input type="number" class="form-control" id="weight" name="weight" min="0" step="0.1" required>
              </div>
            </div>

            <div class="form-row">
              <div class="form-col">
                <label for="color" class="form-label">Color *</label>
                <input type="text" class="form-control" id="color" name="color" required>
              </div>
              <div class="form-col">
                <label for="healthStatus" class="form-label">Health Status *</label>
                <select class="form-select" id="healthStatus" name="healthStatus" required>
                  <option value="">Select Health Status</option>
                  <option value="Excellent"><span class="health-status-indicator health-excellent"></span>Excellent</option>
                  <option value="Good"><span class="health-status-indicator health-good"></span>Good</option>
                  <option value="Fair"><span class="health-status-indicator health-fair"></span>Fair</option>
                  <option value="Poor"><span class="health-status-indicator health-poor"></span>Poor</option>
                </select>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Characteristics</label>
              <div class="characteristics-grid">
                <div class="characteristic-item">
                  <input type="checkbox" id="vaccinated" name="characteristics[]" value="vaccinated">
                  <label for="vaccinated">Vaccinated</label>
                </div>
                <div class="characteristic-item">
                  <input type="checkbox" id="neutered" name="characteristics[]" value="neutered">
                  <label for="neutered">Neutered/Spayed</label>
                </div>
                <div class="characteristic-item">
                  <input type="checkbox" id="houseTrained" name="characteristics[]" value="houseTrained">
                  <label for="houseTrained">House Trained</label>
                </div>
                <div class="characteristic-item">
                  <input type="checkbox" id="goodWithKids" name="characteristics[]" value="goodWithKids">
                  <label for="goodWithKids">Good with Kids</label>
                </div>
                <div class="characteristic-item">
                  <input type="checkbox" id="goodWithDogs" name="characteristics[]" value="goodWithDogs">
                  <label for="goodWithDogs">Good with Dogs</label>
                </div>
                <div class="characteristic-item">
                  <input type="checkbox" id="goodWithCats" name="characteristics[]" value="goodWithCats">
                  <label for="goodWithCats">Good with Cats</label>
                </div>
                <div class="characteristic-item">
                  <input type="checkbox" id="specialNeeds" name="characteristics[]" value="specialNeeds">
                  <label for="specialNeeds">Special Needs</label>
                </div>
                <div class="characteristic-item">
                  <input type="checkbox" id="microchipped" name="characteristics[]" value="microchipped">
                  <label for="microchipped">Microchipped</label>
                </div>
              </div>
            </div>
          </div>

          <!-- Description Section -->
          <div class="form-section">
            <div class="section-header">
              <i class="fas fa-file-alt"></i>
              <h4>Description & Health Information</h4>
            </div>
            
            <div class="mb-3">
              <label for="description" class="form-label">Pet Description *</label>
              <textarea class="form-control" id="description" name="description" rows="4" placeholder="Describe the pet's personality, behavior, and any special traits..." required></textarea>
            </div>

            <div class="mb-3">
              <label for="healthNotes" class="form-label">Health Notes</label>
              <textarea class="form-control" id="healthNotes" name="healthNotes" rows="3" placeholder="Any medical conditions, medications, or special care requirements..."></textarea>
            </div>

            <div class="mb-3">
              <label for="specialRequirements" class="form-label">Special Requirements</label>
              <textarea class="form-control" id="specialRequirements" name="specialRequirements" rows="2" placeholder="Any special dietary needs, exercise requirements, or other care instructions..."></textarea>
            </div>
          </div>

          <!-- Adoption Info Section -->
          <div class="form-section">
            <div class="section-header">
              <i class="fas fa-user-friends"></i>
              <h4>Adoption Information</h4>
            </div>
            
            <div class="form-row">
              <div class="form-col">
                <label for="adoptionCenter" class="form-label">Adoption Center Name *</label>
                <input type="text" class="form-control" id="adoptionCenter" name="adoptionCenter" placeholder="e.g., Happy Paws Rescue Center" required>
              </div>
              <div class="form-col">
                <label for="contactName" class="form-label">Contact Person Name *</label>
                <input type="text" class="form-control" id="contactName" name="contactName" required>
              </div>
            </div>

            <div class="form-row">
              <div class="form-col">
                <label for="contactPhone" class="form-label">Contact Phone *</label>
                <input type="tel" class="form-control" id="contactPhone" name="contactPhone" required>
              </div>
              <div class="form-col">
                <label for="contactEmail" class="form-label">Contact Email *</label>
                <input type="email" class="form-control" id="contactEmail" name="contactEmail" required>
              </div>
            </div>

            <div class="form-row">
              <div class="form-col">
                <label for="centerAddress" class="form-label">Center Address *</label>
                <input type="text" class="form-control" id="centerAddress" name="centerAddress" placeholder="Full address of the adoption center" required>
              </div>
              <div class="form-col">
                <label for="centerWebsite" class="form-label">Center Website (Optional)</label>
                <input type="url" class="form-control" id="centerWebsite" name="centerWebsite" placeholder="https://www.example.com">
              </div>
            </div>

            <div class="mb-3">
              <label for="adoptionNotes" class="form-label">Adoption Process Notes</label>
              <textarea class="form-control" id="adoptionNotes" name="adoptionNotes" rows="3" placeholder="Any specific adoption requirements, process details, or special instructions for potential adopters..."></textarea>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="action-buttons">
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save me-2"></i>Save Pet
            </button>
            <button type="button" class="btn btn-secondary" onclick="resetForm()">
              <i class="fas fa-undo me-2"></i>Reset Form
            </button>
            <button type="button" class="btn btn-danger" onclick="deletePet()">
              <i class="fas fa-trash me-2"></i>Delete Pet
            </button>
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

      // File upload functionality
      setupFileUpload('photoUploadArea', 'photos', 'photoPreview', true);
      setupFileUpload('videoUploadArea', 'video', 'videoPreview', false);
    });

    function setupFileUpload(uploadAreaId, inputId, previewId, isMultiple) {
      const uploadArea = document.getElementById(uploadAreaId);
      const fileInput = document.getElementById(inputId);
      const previewContainer = document.getElementById(previewId);

      // Click to upload
      uploadArea.addEventListener('click', () => fileInput.click());

      // Drag and drop
      uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('dragover');
      });

      uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('dragover');
      });

      uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        const files = e.dataTransfer.files;
        if (isMultiple) {
          handleFiles(files, previewContainer);
        } else {
          handleSingleFile(files[0], previewContainer);
        }
      });

      // File input change
      fileInput.addEventListener('change', (e) => {
        if (isMultiple) {
          handleFiles(e.target.files, previewContainer);
        } else {
          handleSingleFile(e.target.files[0], previewContainer);
        }
      });
    }

    function handleFiles(files, previewContainer) {
      previewContainer.innerHTML = '';
      Array.from(files).forEach(file => {
        if (file.type.startsWith('image/')) {
          createImagePreview(file, previewContainer);
        } else if (file.type.startsWith('video/')) {
          createVideoPreview(file, previewContainer);
        }
      });
    }

    function handleSingleFile(file, previewContainer) {
      previewContainer.innerHTML = '';
      if (file) {
        if (file.type.startsWith('image/')) {
          createImagePreview(file, previewContainer);
        } else if (file.type.startsWith('video/')) {
          createVideoPreview(file, previewContainer);
        }
      }
    }

    function createImagePreview(file, container) {
      const reader = new FileReader();
      reader.onload = (e) => {
        const previewItem = document.createElement('div');
        previewItem.className = 'preview-item';
        previewItem.innerHTML = `
          <img src="${e.target.result}" alt="Preview">
          <button type="button" class="remove-preview" onclick="removePreview(this)">
            <i class="fas fa-times"></i>
          </button>
        `;
        container.appendChild(previewItem);
      };
      reader.readAsDataURL(file);
    }

    function createVideoPreview(file, container) {
      const reader = new FileReader();
      reader.onload = (e) => {
        const previewItem = document.createElement('div');
        previewItem.className = 'preview-item';
        previewItem.innerHTML = `
          <video controls>
            <source src="${e.target.result}" type="${file.type}">
          </video>
          <button type="button" class="remove-preview" onclick="removePreview(this)">
            <i class="fas fa-times"></i>
          </button>
        `;
        container.appendChild(previewItem);
      };
      reader.readAsDataURL(file);
    }

    function removePreview(button) {
      button.closest('.preview-item').remove();
    }

    function resetForm() {
      if (confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
        document.getElementById('addPetForm').reset();
        document.getElementById('photoPreview').innerHTML = '';
        document.getElementById('videoPreview').innerHTML = '';
      }
    }

    function deletePet() {
      if (confirm('Are you sure you want to delete this pet? This action cannot be undone.')) {
        // Add delete functionality here
        alert('Pet deleted successfully!');
      }
    }

    // Form submission
    document.getElementById('addPetForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      // Basic validation
      const requiredFields = ['petName', 'petType', 'breed', 'gender', 'age', 'dateArrival', 'size', 'weight', 'color', 'healthStatus', 'description', 'adoptionCenter', 'contactName', 'contactPhone', 'contactEmail', 'centerAddress'];
      let isValid = true;
      
      requiredFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (!field.value.trim()) {
          field.classList.add('is-invalid');
          isValid = false;
        } else {
          field.classList.remove('is-invalid');
        }
      });

      if (!isValid) {
        alert('Please fill in all required fields.');
        return;
      }

      // Here you would typically send the form data to the server
      // For now, we'll just show a success message
      alert('Pet added successfully!');
      
      // Optionally reset the form
      // resetForm();
    });
  </script>
</body>
</html>
