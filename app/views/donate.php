<?php include 'app/views/partials/header.php'; ?>

<!-- Hero Section -->
<section class="text-white d-flex align-items-center" style="height: 70vh; background: linear-gradient(rgb(56, 94, 80), #436c5d); overflow: hidden;">
  <div class="container h-100">
    <div class="row align-items-center h-100">
      <!-- Left side: Text -->
      <div class="col-md-6 text-start">
        <h1 class="display-4 fw-bold mb-3">Join Us in Giving Hope to Homeless Animals</h1>
        <p class="lead mb-4">Every contribution provides food, shelter, and care for abandoned animals.</p>
        <a href="#donate-form" class="btn btn-lg btn-success px-5 py-2">Donate Now</a>
      </div>

      <!-- Right side: Image -->
      <div class="col-md-6 text-center">
        <img src="public/assets/images/donate.png" alt="Help Animals" class="img-fluid" style="max-height: 60vh; object-fit: contain;">
      </div>
    </div>
  </div>
</section>



<!-- Benefits Section -->
<section class="py-5 bg-light text-center">
  <div class="container">
    <h2 class="mb-5 fw-semibold">Your Donations Make This Possible</h2>
    <div class="row g-4 justify-content-center">
      <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm p-4">
          <i class="fa-solid fa-syringe fa-3x text-success mb-3"></i>
          <h4 class="fw-bold">Vaccinations</h4>
          <p class="text-muted">Protect animals from deadly diseases and give them a healthier life.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm p-4">
          <i class="fa-solid fa-house fa-3x text-success mb-3"></i>
          <h4 class="fw-bold">Safe Shelter</h4>
          <p class="text-muted">Offer a secure and caring environment for rescued animals to heal.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm p-4">
          <i class="fa-solid fa-bullhorn fa-3x text-success mb-3"></i>
          <h4 class="fw-bold">Community Awareness</h4>
          <p class="text-muted">Promote responsible pet ownership and adoption across communities.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Donation Form -->
<section id="donate-form" class="py-5 bg-white">
  <div class="container">
    <div class="card mx-auto shadow-lg border-0" style="max-width: 550px;">
      <div class="card-body p-5">
        <h2 class="text-center mb-4 fw-semibold">Donate to Pawfect Match </h2>
        
        <!-- Donation Frequency Selection -->
        <div class="mb-4 text-center">
          <label class="form-label fw-semibold mb-2">Donation Type</label>
          <div class="btn-group w-100" role="group">
            <input type="radio" class="btn-check" name="donationType" id="oneTime" autocomplete="off" checked>
            <label class="btn btn-outline-success" for="oneTime">One-Time</label>

            <input type="radio" class="btn-check" name="donationType" id="monthly" autocomplete="off">
            <label class="btn btn-outline-success" for="monthly">Monthly</label>

            <input type="radio" class="btn-check" name="donationType" id="annually" autocomplete="off">
            <label class="btn btn-outline-success" for="annually">Annually</label>
          </div>
        </div>

        <!-- Donation Form -->
        <form id="donationForm">
          <div class="mb-3">
            <label for="name" class="form-label">
              <i class="fa fa-user me-2 text-success"></i>Your Name
            </label>
            <input type="text" class="form-control" id="name" required>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">
              <i class="fa fa-envelope me-2 text-success"></i>Your Email
            </label>
            <input type="email" class="form-control" id="email" required>
          </div>

          <div class="mb-4">
            <label for="amount" class="form-label">
              <span class="me-2 text-success fw-bold">Rs</span>Amount (NPR)
            </label>
            <input type="number" class="form-control" id="amount" min="50" required>
          </div>

          <button type="submit" class="btn btn-success w-100 py-2 fs-5">
            <i class="fa fa-donate me-2"></i>Donate
          </button>
        </form>
      </div>
    </div>
  </div>
</section>


<?php include 'app/views/partials/footer.php'; ?>
