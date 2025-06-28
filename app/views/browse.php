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
					<div class="col-12 col-md-4 mb-2 mb-md-0">
						<input type="text" class="form-control" id="searchInput" placeholder="Search by name or keyword...">
					</div>
					<div class="col-6 col-md-2">
						<select class="form-select" id="speciesFilter">
							<option value="">All Species</option>
							<option value="Dog">Dog</option>
							<option value="Cat">Cat</option>
							<option value="Rabbit">Rabbit</option>
							<option value="Bird">Bird</option>
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
						<select class="form-select" id="locationFilter">
							<option value="">All Locations</option>
							<option value="Kathmandu">Kathmandu</option>
							<option value="Lalitpur">Pokhara</option>
							<option value="Bhaktapur">Hetauda</option>
						</select>
					</div>
					<div class="col-6 col-md-2">
						<select class="form-select" id="sortFilter">
							<option value="recent">Recently Added</option>
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
// Sample pet data for demo
const pets = [
  {
    id: 1,
    name: 'Milo',
    age: '2',
    breed: 'Labrador',
    species: 'Dog',
    gender: 'Male',
    location: 'Kathmandu',
    description: 'Very friendly, playful and house-trained.',
    image: 'public/assets/images/pet-1.jpg',
    added: '2024-06-01',
    availability: 'Available'
  },
  {
    id: 2,
    name: 'Luna',
    age: '1',
    breed: 'Siamese',
    species: 'Cat',
    gender: 'Female',
    location: 'Hetauda',
    description: 'Sweet and cuddly.',
    image: 'public/assets/images/pet-2.png',
    added: '2024-06-03',
    availability: 'Available'
  },
  {
    id: 3,
    name: 'Coco',
    age: '3',
    breed: 'Labrador',
    species: 'Dog',
    gender: 'Female',
    location: 'Kathmandu',
    description: 'Loves to play fetch and is great with kids.',
    image: 'public/assets/images/pet-3.jpg',
    added: '2024-06-02',
    availability: 'Pending'
  },
  {
    id: 4,
    name: 'Bunny',
    age: '1',
    breed: 'Angora',
    species: 'Rabbit',
    gender: 'Male',
    location: 'Pokhara',
    description: 'Fluffy and gentle rabbit.',
    image: 'public/assets/images/pets.png',
    added: '2024-05-30',
    availability: 'Available'
  },
  {
    id: 5,
    name: 'Polly',
    age: '4',
    breed: 'Parrot',
    species: 'Bird',
    gender: 'Female',
    location: 'Kathmandu',
    description: 'Talkative and colorful parrot.',
    image: 'public/assets/images/pet-3.jpg',
    added: '2024-05-28',
    availability: 'Adopted'
  }
];

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
    // Show login/register modal
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
  const favs = getFavorites();
  let filtered = [...pets];
  // Search
  const search = document.getElementById('searchInput').value.toLowerCase();
  if (search) {
    filtered = filtered.filter(p =>
      p.name.toLowerCase().includes(search) ||
      p.breed.toLowerCase().includes(search) ||
      p.description.toLowerCase().includes(search)
    );
  }
  // Filters
  const species = document.getElementById('speciesFilter').value;
  if (species) filtered = filtered.filter(p => p.species === species);
  const gender = document.getElementById('genderFilter').value;
  if (gender) filtered = filtered.filter(p => p.gender === gender);
  const location = document.getElementById('locationFilter').value;
  if (location) filtered = filtered.filter(p => p.location === location);
  // Sort
  const sort = document.getElementById('sortFilter').value;
  if (sort === 'recent') filtered.sort((a,b) => new Date(b.added)-new Date(a.added));
  if (sort === 'youngest') filtered.sort((a,b) => +a.age - +b.age);
  if (sort === 'oldest') filtered.sort((a,b) => +b.age - +a.age);
  if (sort === 'alpha') filtered.sort((a,b) => a.name.localeCompare(b.name));
  // Render
  grid.innerHTML = '';
  if (filtered.length === 0) {
    grid.innerHTML = '<div class="col-12 text-center text-muted py-5">No pets found matching your criteria.</div>';
    return;
  }
  filtered.forEach(pet => {
    const isFav = favs.includes(pet.id);
    grid.innerHTML += `
      <div class="col-12 col-md-6 col-lg-4 d-flex">
        <div class="pet-card flex-fill">
          <div class="pet-fav ${isFav ? 'favorited' : ''}" onclick="handleProtectedAction('favorite', ${pet.id})">
            <i class="fa${isFav ? 's' : 'r'} fa-heart"></i>
          </div>
          <img src="${pet.image}" class="pet-card-img" alt="${pet.name}">
          <div class="pet-card-title">${pet.name}</div>
          <div class="pet-card-meta">${pet.breed} • ${pet.gender} • ${pet.age} yr${pet.age>1?'s':''}</div>
          <div class="pet-card-location"><i class="fa-solid fa-location-dot me-1"></i> ${pet.location}</div>
          <div class="pet-card-desc">${pet.description}</div>
          <div class="pet-card-btns">
            <a href="#" class="pet-card-btn adopt" onclick="return handleProtectedAction('adopt', ${pet.id})">Adopt Me</a>
            <a href="#" class="pet-card-btn details">View Details</a>
          </div>
        </div>
      </div>
    `;
  });
}
// Event listeners
['searchInput','speciesFilter','genderFilter','locationFilter','sortFilter'].forEach(id => {
  document.getElementById(id).addEventListener('input', renderPets);
  document.getElementById(id).addEventListener('change', renderPets);
});
document.addEventListener('DOMContentLoaded', renderPets);

// Enhance event delegation for quick view modal 'Adopt Me' button
document.addEventListener('click', function(e) {
  // Quick view modal Adopt Me button
  if (e.target.closest && e.target.closest('#petQuickViewBody .btn-success')) {
    e.preventDefault();
    // Get pet id from modal (find by name)
    const petName = document.querySelector('#petQuickViewBody h3.fw-bold')?.textContent;
    const pet = pets.find(p => p.name === petName);
    if (!pet) return;
    handleProtectedAction('adopt', pet.id);
  }
});

// Add event delegation for View Details buttons

document.addEventListener('click', function(e) {
  if (e.target.classList.contains('details')) {
    e.preventDefault();
    // Find the pet card
    let card = e.target.closest('.pet-card');
    if (!card) return;
    // Find the pet name in the card
    let name = card.querySelector('.pet-card-title').textContent;
    // Find the pet in the data
    let pet = pets.find(p => p.name === name);
    if (!pet) return;
    
    // Get availability badge class
    let availabilityClass = '';
    switch(pet.availability) {
      case 'Available': availabilityClass = 'badge bg-success'; break;
      case 'Pending': availabilityClass = 'badge bg-warning text-dark'; break;
      case 'Adopted': availabilityClass = 'badge bg-secondary'; break;
      default: availabilityClass = 'badge bg-info';
    }
    
    // Build modal content
    let html = `
      <div class="text-center mb-3">
        <div class="position-relative d-inline-block">
          <img src="${pet.image}" alt="${pet.name}" style="width: 100%; max-width: 500px; height: 280px; object-fit: cover; border-radius: 12px; border: 2px solid #e2e9e8; box-shadow: 0 6px 20px rgba(0,0,0,0.08);">
          <div class="position-absolute top-0 end-0 m-2">
            <span class="${availabilityClass} fs-6 px-2 py-1">${pet.availability}</span>
          </div>
        </div>
      </div>
      
      <div class="text-center mb-3">
        <h3 class="fw-bold mb-1" style="color: #3b5d50; font-size: 1.5rem;">${pet.name}</h3>
        <p class="text-muted mb-0" style="font-size: 1rem;">${pet.breed} ${pet.species}</p>
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
        <div class="col-12">
          <div class="bg-light rounded-2 p-2" style="border: 1px solid #e9ecef;">
            <div class="text-primary mb-1" style="font-size: 0.9rem;"><i class="fas fa-map-marker-alt me-1"></i><strong>Location</strong></div>
            <div class="fw-semibold" style="font-size: 0.9rem;">${pet.location}</div>
          </div>
        </div>
      </div>
      
      <div class="mb-3">
        <h6 class="fw-bold mb-2" style="color: #3b5d50; font-size: 1rem;"><i class="fas fa-info-circle me-1"></i>About ${pet.name}</h6>
        <div class="bg-light rounded-2 p-2" style="border-left: 3px solid #3b5d50; border: 1px solid #e9ecef;">
          <p class="mb-0" style="line-height: 1.5; font-size: 0.9rem;">${pet.description}</p>
        </div>
      </div>
      
      <div class="d-flex gap-2">
        <button type="button" class="btn btn-success flex-fill py-2 fw-semibold" style="border-radius: 8px; font-size: 0.9rem;">
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
  <div class="modal-dialog modal-dialog-centered">
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

	