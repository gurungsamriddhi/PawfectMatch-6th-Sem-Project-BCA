<?php include 'app/views/partials/header.php';?>
<main>
    <!-- Start Hero Section -->
    <div class="hero">
        <div class="container">
            <div class="text-center ">
                <h1>Volunteer with us!</h1>
                <p>Join our team of compassionate animal lovers and help make a difference!</p>
            </div>
        </div>
    </div>
    <!-- End Hero Section -->
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
            <form class="mx-auto" style="max-width:500px;" method="POST" action="index.php?page=volunteer&action=apply">
                <div class="mb-3">
                    <label for="volInterest" class="form-label fw-semibold">Area of Interest</label>
                    <select class="form-select" name="area" id="volInterest" required>
                        <option value="" disabled selected>Select an option</option>
                        <option value="pet care">Animal care</option>
                        <option value="training">Adoption events / training</option>
                        <option value="fundraising">Fundraising & marketing</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="availability" class="form-label fw-semibold">Availability Days</label>
                    <input type="text" class="form-control" name="availability_days" id="availability" placeholder="e.g., Weekends, Mon-Wed" required>
                </div>
                <div class="mb-3">
                    <label for="remarks" class="form-label fw-semibold">Remarks (Optional)</label>
                    <textarea class="form-control" name="remarks" id="remarks" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-bold">Submit</button>
            </form>
        </div>
    </section>
</main>
<?php include 'app/views/partials/footer.php'; ?>

<!-- Custom Styles -->
<style>
    .text-shadow {
        text-shadow: 0 0 8px rgba(0, 0, 0, 0.7);
    }

    .hover-shadow:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        transform: translateY(-5px);
    }

    .transition {
        transition: all 0.3s ease;
    }
</style>