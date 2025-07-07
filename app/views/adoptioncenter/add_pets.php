
  <?php include 'app/views/partials/sidebarcenter.php'; ?>
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
<form id="addPetForm" action="index.php?page=adoptioncenter/savePets" method="POST" enctype="multipart/form-data">
          <div id="formMessage"></div>
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
<!-- Reset Confirmation Modal -->
<div class="modal fade" id="resetConfirmModal" tabindex="-1" aria-labelledby="resetConfirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Reset Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Do you really want to reset the form?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-warning" id="confirmResetBtn">Yes, Reset</button>
      </div>
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Would you like to delete this pet?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Yes, Delete</button>
      </div>
    </div>
  </div>
</div>

<!-- Form submission logic -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.sidebar-link.has-arrow').forEach(function (link) {
    link.addEventListener('click', function (e) {
      e.preventDefault();
      var parent = link.closest('.sidebar-item');
      parent.classList.toggle('open');
    });
  });

  setupFileUpload('photoUploadArea', 'photos', 'photoPreview', true);
  setupFileUpload('videoUploadArea', 'video', 'videoPreview', false);

  const form = document.getElementById('addPetForm');
  form.addEventListener('submit', function (e) {
    const requiredFields = [
      'petName', 'petType', 'breed', 'gender', 'age', 'dateArrival',
      'size', 'weight', 'color', 'healthStatus', 'description',
      'adoptionCenter', 'contactName', 'contactPhone', 'contactEmail', 'centerAddress'
    ];

    let isValid = true;
    requiredFields.forEach(id => {
      const el = document.getElementById(id);
      if (!el.value.trim()) {
        el.classList.add('is-invalid');
        isValid = false;
      } else {
        el.classList.remove('is-invalid');
      }
    });

    if (!isValid) {
      e.preventDefault(); // prevent form only if invalid
      showMessage('Please fill in all required fields.', 'danger');
      return;
    }

    // let the form submit normally if valid
  });
});

function setupFileUpload(uploadAreaId, inputId, previewId, isMultiple) {
  const uploadArea = document.getElementById(uploadAreaId);
  const fileInput = document.getElementById(inputId);
  const previewContainer = document.getElementById(previewId);

  uploadArea.addEventListener('click', () => fileInput.click());
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
    isMultiple ? handleFiles(files, previewContainer) : handleSingleFile(files[0], previewContainer);
  });
  fileInput.addEventListener('change', (e) => {
    isMultiple ? handleFiles(e.target.files, previewContainer) : handleSingleFile(e.target.files[0], previewContainer);
  });
}

function handleFiles(files, previewContainer) {
  previewContainer.innerHTML = '';
  Array.from(files).forEach(file => {
    if (file.type.startsWith('image/')) createImagePreview(file, previewContainer);
    else if (file.type.startsWith('video/')) createVideoPreview(file, previewContainer);
  });
}

function handleSingleFile(file, previewContainer) {
  previewContainer.innerHTML = '';
  if (file) {
    if (file.type.startsWith('image/')) createImagePreview(file, previewContainer);
    else if (file.type.startsWith('video/')) createVideoPreview(file, previewContainer);
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
      </button>`;
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
      <video controls><source src="${e.target.result}" type="${file.type}"></video>
      <button type="button" class="remove-preview" onclick="removePreview(this)">
        <i class="fas fa-times"></i>
      </button>`;
    container.appendChild(previewItem);
  };
  reader.readAsDataURL(file);
}

function removePreview(button) {
  button.closest('.preview-item').remove();
}

function showMessage(message, type = 'success') {
  const formMessage = document.getElementById('formMessage');
  if (!formMessage) return;
  formMessage.innerHTML = `
    <div class="alert alert-${type} alert-dismissible fade show" role="alert">
      ${message}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>`;
  setTimeout(() => {
    formMessage.innerHTML = '';
  }, 5000);
}

// Reset modal logic
function resetForm() {
  const modal = new bootstrap.Modal(document.getElementById('resetConfirmModal'));
  modal.show();
}

function deletePet() {
  const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
  modal.show();
}

document.getElementById('confirmResetBtn').addEventListener('click', function () {
  document.getElementById('addPetForm').reset();
  document.getElementById('photoPreview').innerHTML = '';
  document.getElementById('videoPreview').innerHTML = '';
  bootstrap.Modal.getInstance(document.getElementById('resetConfirmModal')).hide();
  showMessage('Form reset successfully.', 'info');
});

document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
  document.getElementById('addPetForm').reset();
  document.getElementById('photoPreview').innerHTML = '';
  document.getElementById('videoPreview').innerHTML = '';
  bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal')).hide();
  showMessage('Pet deleted successfully.', 'danger');
});
</script>



<script src="public/assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
