<?php include 'app/views/partials/header.php'; ?>

<!-- Hero Section -->
<section class="py-5 text-white text-center d-flex align-items-center" 
         style="background: url('public/assets/images/volunteer.avif') no-repeat center center; background-size: cover; min-height: 320px;">
  <div class="container">
    <h1 class="display-4 fw-bold text-shadow">Volunteer With Us</h1>
    <p class="lead text-shadow">Join our team of compassionate animal lovers and help make a difference!</p>
  </div>
</section>

<!-- Benefits Grid -->
<section class="py-5">
  <div class="container">
    <h2 class="mb-5 text-center fw-bold">Volunteer Opportunities</h2>
    <div class="row text-center g-4">
      <div class="col-md-4">
        <div class="p-4 border rounded shadow-sm h-100 hover-shadow transition">
          <i class="fa fa-paw fa-3x mb-3 text-primary"></i>
          <h4 class="fw-semibold">Hands-on Animal Care</h4>
          <p>Help with feeding, cleaning and socialising shelter pets.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4 border rounded shadow-sm h-100 hover-shadow transition">
          <i class="fa fa-users fa-3x mb-3 text-success"></i>
          <h4 class="fw-semibold">Community Building</h4>
          <p>Connect with fellow volunteers at events and meetups.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4 border rounded shadow-sm h-100 hover-shadow transition">
          <i class="fa fa-heart fa-3x mb-3 text-danger"></i>
          <h4 class="fw-semibold">Support the Cause</h4>
          <p>Contribute to finding loving homes for pets in need.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- How It Works (Steps) -->
<section class="py-5 bg-light">
  <div class="container">
    <h2 class="mb-5 text-center fw-bold">How It Works</h2>
    <div class="row text-center g-4">
      <div class="col-md-4">
        <div class="p-4 border rounded shadow-sm h-100 hover-shadow transition">
          <i class="fas fa-file-alt fa-3x mb-3 text-primary"></i>
          <h4>Fill out our volunteer application form.</h4>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4 border rounded shadow-sm h-100 hover-shadow transition">
          <i class="fas fa-chalkboard-teacher fa-3x mb-3 text-success"></i>
          <h4>Attend orientation and choose your volunteer role & schedule.</h4>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4 border rounded shadow-sm h-100 hover-shadow transition">
          <i class="fas fa-hand-holding-heart fa-3x mb-3 text-danger"></i>
          <h4>Start helping pets find forever homes!</h4>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="py-5 text-center" style="background-color: white;">
  <div class="container">
    <a href="#volunteerForm" class="btn btn-light btn-lg fw-bold px-5 shadow">Become a Volunteer</a>
  </div>
</section>

<!-- FAQ Section -->
<section class="py-5">
  <div class="container">
    <h3 class="mb-4 fw-bold">Frequently Asked Questions</h3>
    <div class="accordion" id="volFAQs">
      <div class="accordion-item">
        <h2 class="accordion-header" id="faq1">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
            What volunteer roles are available?
          </button>
        </h2>
        <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="faq1" data-bs-parent="#volFAQs">
          <div class="accordion-body">
            We have animal care, adoption events, social media, and more…
          </div>
        </div>
      </div>
      <h2 class="accordion-header" id="faq2">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
             Do I need prior experience to volunteer?
          </button>
        </h2>
        <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="faq2" data-bs-parent="#volFAQs">
          <div class="accordion-body">
             Not at all! We provide training and support for all volunteer roles.
          </div>
        </div>
      </div>
      <h2 class="accordion-header" id="faq3">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
             Is there a minimum age requirement?
          </button>
        </h2>
        <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="faq3" data-bs-parent="#volFAQs">
          <div class="accordion-body">
            Yes, volunteers must be at least 16 years old. Those under 18 may need parental consent.
          </div>
        </div>
      </div>
      <!-- Add more FAQ items here -->
    </div>
  </div>
</section>

<!-- Volunteer Registration Form -->
<section id="volunteerForm" class="py-5 bg-light">
  <div class="container">
    <h3 class="mb-4 text-center fw-bold">Volunteer With Us</h3>
    <form class="mx-auto" style="max-width:500px;">
      <div class="mb-3">
        <label for="volName" class="form-label fw-semibold">Name</label>
        <input type="text" class="form-control" id="volName" placeholder="Your Name" required>
      </div>
      <div class="mb-3">
        <label for="volEmail" class="form-label fw-semibold">Email</label>
        <input type="email" class="form-control" id="volEmail" placeholder="Your Email" required>
      </div>
      <div class="mb-3">
        <label for="volInterest" class="form-label fw-semibold">I'm interested in...</label>
        <select class="form-select" id="volInterest" required>
          <option value="" disabled selected>Select an option</option>
          <option>Animal care</option>
          <option>Adoption events</option>
          <option>Fundraising & marketing</option>
          <option>Other</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary w-100 fw-bold">Submit</button>
    </form>
  </div>
</section>

<?php include 'app/views/partials/footer.php'; ?>

<!-- Custom Styles -->
<style>
  .text-shadow {
    text-shadow: 0 0 8px rgba(0,0,0,0.7);
  }
  .hover-shadow:hover {
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    transform: translateY(-5px);
  }
  .transition {
    transition: all 0.3s ease;
  }
</style>
