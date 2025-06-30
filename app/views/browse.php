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
      // You can add adoption logic here
      alert('Proceeding to adoption process for pet ID: ' + petId);
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
    
    // Build modal content with all pet information
    let html = `
      <div class="text-center mb-3">
        <div class="position-relative d-inline-block">
          <img src="${pet.image_path || 'public/assets/images/pets.png'}" alt="${pet.name}" style="width: 100%; max-width: 500px; height: 280px; object-fit: cover; border-radius: 12px; border: 2px solid #e2e9e8; box-shadow: 0 6px 20px rgba(0,0,0,0.08);">
          <div class="position-absolute top-0 end-0 m-2">
            <span class="${availabilityClass} fs-6 px-2 py-1">${pet.status}</span>
          </div>
        </div>
      </div>
      
      <div class="text-center mb-3">
        <h3 class="fw-bold mb-1" style="color: #3b5d50; font-size: 1.5rem;">${pet.name}</h3>
        <p class="text-muted mb-0" style="font-size: 1rem;">${pet.breed} ${pet.type || 'Pet'}</p>
      </div>
      
      <div class="row g-2 mb-3">
        <div class="col-6">
          <div class="bg-light rounded-2 p-2 text-center h-100" style="border: 1px solid #e9ecef;">
            <div class="text-primary mb-1" style="font-size: 0.9rem;"><i class="fas fa-birthday-cake"></i></div>
            <div class="fw-semibold" style="font-size: 0.9rem;">${pet.age} year${pet.age>1?'s':''} old</div>
          </div>
        </div>
        <div class="col-6">
          <div class="bg-light rounded-2 p-2 text-center h-100" style="border: 1px solid #e9ecef;">
            <div class="text-primary mb-1" style="font-size: 0.9rem;"><i class="fas fa-venus-mars"></i></div>
            <div class="fw-semibold" style="font-size: 0.9rem;">${pet.gender}</div>
          </div>
        </div>
        <div class="col-6">
          <div class="bg-light rounded-2 p-2 text-center h-100" style="border: 1px solid #e9ecef;">
            <div class="text-primary mb-1" style="font-size: 0.9rem;"><i class="fas fa-ruler-combined"></i></div>
            <div class="fw-semibold" style="font-size: 0.9rem;">${pet.size}</div>
          </div>
        </div>
        <div class="col-6">
          <div class="bg-light rounded-2 p-2 text-center h-100" style="border: 1px solid #e9ecef;">
            <div class="text-primary mb-1" style="font-size: 0.9rem;"><i class="fas fa-weight-hanging"></i></div>
            <div class="fw-semibold" style="font-size: 0.9rem;">${pet.weight || 'Unknown'} kg</div>
          </div>
        </div>
        <div class="col-12">
          <div class="bg-light rounded-2 p-2" style="border: 1px solid #e9ecef;">
            <div class="text-primary mb-1" style="font-size: 0.9rem;"><i class="fas fa-palette me-1"></i><strong>Color</strong></div>
            <div class="fw-semibold" style="font-size: 0.9rem;">${pet.color || 'Unknown'}</div>
          </div>
        </div>
      </div>
      
      <div class="mb-3">
        <h6 class="fw-bold mb-2" style="color: #3b5d50; font-size: 1rem;"><i class="fas fa-heartbeat me-1"></i>Health Status</h6>
        <div class="bg-light rounded-2 p-2" style="border-left: 3px solid #3b5d50; border: 1px solid #e9ecef;">
          <span class="badge bg-${healthColor} me-2">${pet.health_status}</span>
          ${pet.health_notes ? `<p class="mb-0 mt-2" style="line-height: 1.5; font-size: 0.9rem;">${pet.health_notes}</p>` : ''}
        </div>
      </div>
      
      ${pet.characteristics ? `
      <div class="mb-3">
        <h6 class="fw-bold mb-2" style="color: #3b5d50; font-size: 1rem;"><i class="fas fa-check-circle me-1"></i>Characteristics</h6>
        <div class="bg-light rounded-2 p-2" style="border-left: 3px solid #3b5d50; border: 1px solid #e9ecef;">
          <p class="mb-0" style="line-height: 1.5; font-size: 0.9rem;">${formatCharacteristics(pet.characteristics)}</p>
        </div>
      </div>
      ` : ''}
      
      <div class="mb-3">
        <h6 class="fw-bold mb-2" style="color: #3b5d50; font-size: 1rem;"><i class="fas fa-info-circle me-1"></i>About ${pet.name}</h6>
        <div class="bg-light rounded-2 p-2" style="border-left: 3px solid #3b5d50; border: 1px solid #e9ecef;">
          <p class="mb-0" style="line-height: 1.5; font-size: 0.9rem;">${pet.description}</p>
        </div>
      </div>
      
      <div class="mb-3">
        <h6 class="fw-bold mb-2" style="color: #3b5d50; font-size: 1rem;"><i class="fas fa-building me-1"></i>Adoption Center</h6>
        <div class="bg-light rounded-2 p-2" style="border-left: 3px solid #3b5d50; border: 1px solid #e9ecef;">
          <p class="mb-1 fw-semibold">${pet.adoption_center}</p>
          <p class="mb-1"><i class="fas fa-map-marker-alt me-1"></i>${pet.center_address}</p>
          <p class="mb-1"><i class="fas fa-phone me-1"></i>${pet.contact_phone}</p>
          <p class="mb-0"><i class="fas fa-envelope me-1"></i>${pet.contact_email}</p>
          ${pet.center_website ? `<p class="mb-0 mt-2"><i class="fas fa-globe me-1"></i><a href="${pet.center_website}" target="_blank">${pet.center_website}</a></p>` : ''}
        </div>
      </div>
      
      <div class="d-flex gap-2">
        <button type="button" class="btn btn-success flex-fill py-2 fw-semibold" onclick="handleProtectedAction('adopt', ${pet.pet_id})" style="border-radius: 8px; font-size: 0.9rem;">
          <i class="fas fa-heart me-1"></i>Adopt Me
        </button>
        <button type="button" class="btn btn-outline-secondary flex-fill py-2 fw-semibold" data-bs-dismiss="modal" style="border-radius: 8px; font-size: 0.9rem;">
          <i class="fas fa-times me-1"></i>Close
        </button>
      </div>
    `;
    document.getElementById('petQuickViewBody').innerHTML = html;
    // Show modal
    let modal = new bootstrap.Modal(document.getElementById('petQuickViewModal'));
    modal.show();
  }
});
</script>
<?php include 'app/views/partials/footer.php'; ?>

<!-- Pet Quick View Modal -->
<div class="modal fade" id="petQuickViewModal" tabindex="-1" aria-labelledby="petQuickViewLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
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

	
	