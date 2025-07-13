<?php include 'app/views/partials/header.php'; ?>
<main>

		<!-- Start Hero Section -->
			<div class="hero">
				<div class="container">
					<div class="row justify-content-between">
						<div class="col-lg-5">
							<div class="intro-excerpt">
								<h1>Adopt Now</h1>
							</div>
						</div>
						<div class="col-lg-7">
							
						</div>
					</div>
				</div>
			</div>
		<!-- End Hero Section -->

		<!-- Search, Filter, Sort Bar -->
		<div class="bg-white py-3 border-bottom mb-4">
			<div class="container">
				<form id="petFilterForm" class="row g-2 align-items-center">
					<div class="col-12 col-md-3 mb-2 mb-md-0">
						<input type="text" class="form-control" id="searchInput" placeholder="Search by name, breed, or description...">
					</div>
					<div class="col-6 col-md-2">
						<select class="form-select" id="typeFilter">
							<option value="">All Types</option>
							<option value="Dog">Dog</option>
							<option value="Cat">Cat</option>
							<option value="Bird">Bird</option>
							<option value="Rabbit">Rabbit</option>
							<option value="Hamster">Hamster</option>
							<option value="Fish">Fish</option>
							<option value="Other">Other</option>
						</select>
					</div>
					<div class="col-6 col-md-2">
						<select class="form-select" id="genderFilter">
							<option value="">Any Gender</option>
							<option value="Male">Male</option>
							<option value="Female">Female</option>
						</select>
					</div>
					<div class="col-6 col-md-2">
						<select class="form-select" id="sizeFilter">
							<option value="">Any Size</option>
							<option value="Small">Small</option>
							<option value="Medium">Medium</option>
							<option value="Large">Large</option>
							<option value="Extra Large">Extra Large</option>
						</select>
					</div>
					<div class="col-6 col-md-2">
						<select class="form-select" id="healthFilter">
							<option value="">Any Health</option>
							<option value="Excellent">Excellent</option>
							<option value="Good">Good</option>
							<option value="Fair">Fair</option>
							<option value="Poor">Poor</option>
						</select>
					</div>
					<div class="col-6 col-md-1">
						<select class="form-select" id="sortFilter">
							<option value="recent">Recent</option>
							<option value="youngest">Youngest</option>
							<option value="oldest">Oldest</option>
							<option value="alpha">A-Z</option>
						</select>
					</div>
				</form>
			</div>
		</div>

		<!-- Pet Cards Grid -->
		<div class="untree_co-section pet-section before-footer-section">
		    <div class="container">
		      	<div class="row" id="petGrid">
		      		<!-- Pet cards will be rendered here by JS -->
		      	</div>
		    </div>
		</div>
</main>

<script>
// Get pets data from PHP
const pets = <?php echo $petsJson ?? '[]'; ?>;

// Favorites (localStorage)
function getFavorites() {
  return JSON.parse(localStorage.getItem('petFavorites') || '[]');
}
function setFavorites(favs) {
  localStorage.setItem('petFavorites', JSON.stringify(favs));
}
function toggleFavorite(id) {
  let favs = getFavorites();
  if (favs.includes(id)) {
    favs = favs.filter(f => f !== id);
  } else {
    favs.push(id);
  }
  setFavorites(favs);
  renderPets();
}

// Pass login status from PHP to JS
window.isLoggedIn = <?= isset($_SESSION['user']) ? 'true' : 'false' ?>;

// Intercept Favorite/Wishlist and Adopt Me actions
function handleProtectedAction(action, petId) {
  if (!window.isLoggedIn) {
    // Hide any existing modals first
    const existingModals = document.querySelectorAll('.modal.show');
    existingModals.forEach(modal => {
      const modalInstance = bootstrap.Modal.getInstance(modal);
      if (modalInstance) {
        modalInstance.hide();
      }
    });
    
    // Show login/register modal after a short delay to ensure proper stacking
    setTimeout(() => {
      let modal = new bootstrap.Modal(document.getElementById('loginRequiredModal'));
      modal.show();
      // Set up buttons
      document.getElementById('goToLoginBtn').onclick = function() {
        modal.hide();
        new bootstrap.Modal(document.getElementById('loginModal')).show();
      };
      document.getElementById('goToRegisterBtn').onclick = function() {
        modal.hide();
        new bootstrap.Modal(document.getElementById('registerModal')).show();
      };
    }, 150);
    return false;
  } else {
    // User is logged in, proceed
    if (action === 'favorite') {
      toggleFavorite(petId);
    } else if (action === 'adopt') {
      // Show adoption form modal
      document.getElementById('adoptPetId').value = petId;
      let modal = new bootstrap.Modal(document.getElementById('adoptionRequestModal'));
      modal.show();
    }
    return true;
  }
}

// Render pets
function renderPets() {
  const grid = document.getElementById('petGrid');
  if (!grid) {
    console.error('Pet grid element not found');
    return;
  }
  
  // Show loading state
  grid.innerHTML = '<div class="col-12 pet-loading"><i class="fas fa-spinner fa-spin"></i><p>Loading pets...</p></div>';
  
  // Simulate loading delay for better UX
  setTimeout(() => {
    const favs = getFavorites();
    let filtered = [...pets];
    
    // Search
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
      const search = searchInput.value.toLowerCase();
      if (search) {
        filtered = filtered.filter(p =>
          p.name.toLowerCase().includes(search) ||
          p.breed.toLowerCase().includes(search) ||
          p.description.toLowerCase().includes(search)
        );
      }
    }
    
    // Filters
    const typeFilter = document.getElementById('typeFilter');
    if (typeFilter && typeFilter.value) {
      filtered = filtered.filter(p => p.type === typeFilter.value);
    }
    
    const genderFilter = document.getElementById('genderFilter');
    if (genderFilter && genderFilter.value) {
      filtered = filtered.filter(p => p.gender === genderFilter.value);
    }
    
    const sizeFilter = document.getElementById('sizeFilter');
    if (sizeFilter && sizeFilter.value) {
      filtered = filtered.filter(p => p.size === sizeFilter.value);
    }
    
    const healthFilter = document.getElementById('healthFilter');
    if (healthFilter && healthFilter.value) {
      filtered = filtered.filter(p => p.health_status === healthFilter.value);
    }
    
    // Sort
    const sortFilter = document.getElementById('sortFilter');
    if (sortFilter) {
      const sort = sortFilter.value;
      if (sort === 'recent') filtered.sort((a,b) => new Date(b.created_at)-new Date(a.created_at));
      if (sort === 'youngest') filtered.sort((a,b) => +a.age - +b.age);
      if (sort === 'oldest') filtered.sort((a,b) => +b.age - +a.age);
      if (sort === 'alpha') filtered.sort((a,b) => a.name.localeCompare(b.name));
    }
    
    // Render
    grid.innerHTML = '';
    if (filtered.length === 0) {
      grid.innerHTML = '<div class="col-12 text-center text-muted py-5"><i class="fas fa-search fa-2x mb-3"></i><p>No pets found matching your criteria.</p></div>';
      return;
    }
    
    filtered.forEach(pet => {
      const isFav = favs.includes(pet.pet_id);
      const healthColor = getHealthStatusColor(pet.health_status);
      const availabilityBadge = getAvailabilityBadge(pet.status);
      
      grid.innerHTML += `
        <div class="col-12 col-md-6 col-lg-4 d-flex">
          <div class="pet-card flex-fill">
            <div class="pet-fav ${isFav ? 'favorited' : ''}" onclick="handleProtectedAction('favorite', ${pet.pet_id})">
              <i class="fa${isFav ? 's' : 'r'} fa-heart"></i>
            </div>
            <div class="position-relative">
              <img src="${pet.image_path || 'public/assets/images/pets.png'}" class="pet-card-img" alt="${pet.name}" onerror="this.src='public/assets/images/pets.png'">
              <span class="${availabilityBadge} position-absolute top-0 end-0 m-2">${pet.status}</span>
            </div>
            <div class="pet-card-title">${pet.name}</div>
            <div class="pet-card-meta">${pet.breed} • ${pet.gender} • ${pet.age} yr${pet.age>1?'s':''}</div>
            <div class="pet-card-location"><i class="fa-solid fa-location-dot me-1"></i> ${pet.adoption_center}</div>
            <div class="pet-card-details">
              <span class="badge bg-${healthColor} me-1">${pet.health_status}</span>
              <span class="badge bg-info">${pet.size}</span>
            </div>
            <div class="pet-card-desc">${pet.description.substring(0, 100)}${pet.description.length > 100 ? '...' : ''}</div>
            <div class="pet-card-btns">
              <a href="#" class="pet-card-btn adopt" onclick="return handleProtectedAction('adopt', ${pet.pet_id})">Adopt Me</a>
              <a href="#" class="pet-card-btn details" data-pet-id="${pet.pet_id}">View Details</a>
            </div>
          </div>
        </div>
      `;
    });
  }, 300); // Small delay for better UX
}

function getHealthStatusColor(status) {
  switch (status) {
    case 'Excellent': return 'success';
    case 'Good': return 'info';
    case 'Fair': return 'warning';
    case 'Poor': return 'danger';
    default: return 'secondary';
  }
}

function getAvailabilityBadge(status) {
  switch (status) {
    case 'available': return 'badge bg-success';
    case 'pending': return 'badge bg-warning text-dark';
    case 'adopted': return 'badge bg-secondary';
    default: return 'badge bg-info';
  }
}

function formatCharacteristics(characteristics) {
  if (!characteristics) return '';
  
  const chars = characteristics.split(',');
  const labels = {
    'vaccinated': 'Vaccinated',
    'neutered': 'Neutered/Spayed',
    'houseTrained': 'House Trained',
    'goodWithKids': 'Good with Kids',
    'goodWithDogs': 'Good with Dogs',
    'goodWithCats': 'Good with Cats',
    'specialNeeds': 'Special Needs',
    'microchipped': 'Microchipped'
  };
  
  return chars.map(char => labels[char] || char).join(', ');
}

// Event listeners
['searchInput','typeFilter','genderFilter','sizeFilter','healthFilter','sortFilter'].forEach(id => {
  const element = document.getElementById(id);
  if (element) {
    element.addEventListener('input', renderPets);
    element.addEventListener('change', renderPets);
  }
});

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
  console.log('Browse page loaded, rendering pets...');
  renderPets();
  // Adoption form submit handler
  const adoptionForm = document.getElementById('adoptionRequestForm');
  if (adoptionForm) {
    adoptionForm.onsubmit = function(e) {
      e.preventDefault();
      const formData = new FormData(this);
      fetch('debug_db.php', {
        method: 'POST',
        body: formData,
        credentials: 'same-origin'
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          alert('Adoption request submitted!');
          bootstrap.Modal.getInstance(document.getElementById('adoptionRequestModal')).hide();
        } else {
          alert('Error: ' + (data.message || 'Unknown error'));
        }
      })
      .catch(() => alert('An error occurred.'));
    };
  }
});

// Add event delegation for View Details buttons
document.addEventListener('click', function(e) {
  if (e.target.classList.contains('details')) {
    e.preventDefault();
    const petId = e.target.getAttribute('data-pet-id');
    const pet = pets.find(p => p.pet_id == petId);
    if (!pet) return;
    
    // Get availability badge class
    let availabilityClass = getAvailabilityBadge(pet.status);
    let healthColor = getHealthStatusColor(pet.health_status);
    
    // Build improved modal content with image and summary
    let html = `
      <div class="pet-details-section mb-4">
        <div class="text-center mb-3">
          <div class="position-relative d-inline-block">
            <img src="${pet.image_path || 'public/assets/images/pets.png'}" alt="${pet.name}" style="width: 100%; max-width: 420px; height: 240px; object-fit: cover; border-radius: 12px; border: 2px solid #e2e9e8; box-shadow: 0 6px 20px rgba(0,0,0,0.08);">
            <div class="position-absolute top-0 end-0 m-2">
              <span class="${availabilityClass} fs-6 px-2 py-1">${pet.status}</span>
            </div>
          </div>
        </div>
        <div class="text-center mb-1">
          <h3 class="fw-bold mb-1" style="color: #3b5d50; font-size: 1.5rem;">${pet.name}</h3>
          <p class="text-muted mb-0" style="font-size: 1rem;">${pet.breed} • ${pet.gender} • ${pet.age} yr${pet.age>1?'s':''}</p>
        </div>
        <div class="pet-summary-meta mb-3 text-muted" style="font-size: 1.05rem;">
          <span><i class="fas fa-dog me-1"></i> ${pet.type || 'Pet'}</span>
          <span class="mx-2">•</span>
          <span><i class="fas fa-ruler-combined me-1"></i> ${pet.size || 'Unknown'}</span>
          <span class="mx-2">•</span>
          <span><i class="fas fa-weight-hanging me-1"></i> ${pet.weight || 'Unknown'} kg</span>
        </div>
        <div class="row g-3">
          <div class="col-md-6">
            <div class="info-block">
              <h6><i class="fas fa-palette me-1"></i> <strong>Color</strong></h6>
              <div>${pet.color || 'Unknown'}</div>
            </div>
            <div class="info-block">
              <h6><i class="fas fa-heartbeat me-1"></i> <strong>Health Status</strong></h6>
              <span class="badge bg-${healthColor}">${pet.health_status}</span>
              ${pet.health_notes ? `<div class='mt-2'>${pet.health_notes}</div>` : ''}
            </div>
            ${pet.characteristics ? `
            <div class="info-block">
              <h6><i class="fas fa-check-circle me-1"></i> <strong>Characteristics</strong></h6>
              <div>${formatCharacteristics(pet.characteristics)}</div>
            </div>
            ` : ''}
          </div>
          <div class="col-md-6">
            <div class="info-block">
              <h6><i class="fas fa-info-circle me-1"></i> <strong>About ${pet.name}</strong></h6>
              <div>${pet.description}</div>
            </div>
            <div class="info-block">
              <h6><i class="fas fa-building me-1"></i> <strong>Adoption Center</strong></h6>
              <div>
                <div><strong>${pet.adoption_center}</strong></div>
                <div><i class="fas fa-map-marker-alt me-1"></i>${pet.center_address}</div>
                <div><i class="fas fa-phone me-1"></i>${pet.contact_phone}</div>
                <div><i class="fas fa-envelope me-1"></i>${pet.contact_email}</div>
                ${pet.center_website ? `<div><i class='fas fa-globe me-1'></i><a href='${pet.center_website}' target='_blank'>${pet.center_website}</a></div>` : ''}
              </div>
            </div>
          </div>
        </div>
        <div class="d-flex gap-3 justify-content-center mt-4">
          <button type="button" class="btn btn-success btn-lg px-4" onclick="closePetModalAndAdopt(${pet.pet_id})">
            <i class="fas fa-heart me-1"></i>Adopt Me
          </button>
          <button type="button" class="btn btn-outline-secondary btn-lg px-4" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>Close
          </button>
        </div>
      </div>
    `;
    document.getElementById('petQuickViewBody').innerHTML = html;
    // Show modal
    let modal = new bootstrap.Modal(document.getElementById('petQuickViewModal'));
    modal.show();
  }
});

function closePetModalAndAdopt(petId) {
  // Close the pet details modal first
  const petModal = bootstrap.Modal.getInstance(document.getElementById('petQuickViewModal'));
  if (petModal) petModal.hide();
  // Wait a bit longer for modal to close and backdrop to be removed
  setTimeout(() => {
    handleProtectedAction('adopt', petId);
  }, 500); // Increased delay to 500ms
}
</script>
<?php include 'app/views/partials/footer.php'; ?>

<!-- Pet Quick View Modal -->
<div class="modal fade" id="petQuickViewModal" tabindex="-1" aria-labelledby="petQuickViewLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered custom-pet-details-modal"> <!-- Added custom class for width -->
    <div class="modal-content">
      <div class="modal-header border-0 d-flex justify-content-between align-items-center">
        <h5 class="modal-title mb-0" id="petQuickViewLabel">Pet Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pt-0" id="petQuickViewBody">
        <!-- Pet details will be injected here by JS -->
      </div>
    </div>
  </div>
</div>

<!-- Login/Register Required Modal -->
<div class="modal fade" id="loginRequiredModal" tabindex="-1" aria-labelledby="loginRequiredLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title w-100" id="loginRequiredLabel">Login Required</h5>
        <button type="button" class="btn-close position-absolute end-0 me-3 mt-2" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <div class="login-required-icon mb-2"><i class="fas fa-lock"></i></div>
        <div class="login-required-message mb-4">You need to log in to proceed with adoption or add to your wishlist.</div>
        <div class="d-flex gap-3 justify-content-center">
          <button class="btn btn-success px-4" id="goToLoginBtn">Login</button>
          <button class="btn btn-warning px-4" id="goToRegisterBtn">Register</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Adoption Request Modal -->
<div class="modal fade" id="adoptionRequestModal" tabindex="-1" aria-labelledby="adoptionRequestLabel" aria-hidden="true">
  <div class="modal-dialog custom-wide-modal"> <!-- Use custom class for width -->
    <form class="modal-content" id="adoptionRequestForm">
      <div class="modal-header">
        <h3 class="modal-title" id="adoptionRequestLabel">Adoption Request</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="pet_id" id="adoptPetId">
        <div class="row g-3">
          <div class="col-md-6">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" name="address" required>
          </div>
          <div class="col-md-6">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" name="phone" required>
          </div>
          <div class="col-md-6">
            <label for="reason" class="form-label">Reason for Adoption</label>
            <textarea class="form-control" name="reason" rows="2" required></textarea>
          </div>
          <div class="col-md-6">
            <label for="preferred_date" class="form-label">Preferred Date</label>
            <input type="date" class="form-control" name="preferred_date" required>
          </div>
          <div class="col-md-6">
            <label for="home_type" class="form-label">Home Type</label>
            <select class="form-select" name="home_type" required>
              <option value="">Select</option>
              <option value="Apartment">Apartment</option>
              <option value="House">House</option>
              <option value="Farm">Farm</option>
            </select>
          </div>
          <div class="col-md-6">
            <label for="has_other_pets" class="form-label">Do you have other pets?</label>
            <select class="form-select" name="has_other_pets" required>
              <option value="">Select</option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button type="submit" class="btn btn-primary" style="background: #3b5d50; border-color: #3b5d50; min-width: 200px;">Submit Request</button>
      </div>
    </form>
  </div>
</div>

	
	