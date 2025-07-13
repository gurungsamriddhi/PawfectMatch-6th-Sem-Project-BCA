<?php include 'app/views/partials/header.php'; ?>
<?php

$volunteer_errors = $_SESSION['volunteer_errors'] ?? [];
if (!empty($volunteer_errors)) {
    $volunteer_old = $_SESSION['volunteer_old'] ?? [];
}
$volunteer_success = $_SESSION['volunteer_success'] ?? '';

unset($_SESSION['volunteer_errors'], $_SESSION['volunteer_old'], $_SESSION['volunteer_success']);
?>
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

            <?php if (!empty($volunteer_errors['general'])): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($volunteer_errors['general']) ?></div>
            <?php endif; ?>

            <?php if (!empty($volunteer_success)): ?>
                <div id="volunteerSuccessMsg" class="alert alert-success">
                    <?= htmlspecialchars($volunteer_success) ?>
                </div>
                <script>
                    setTimeout(() => {
                        const msg = document.getElementById('volunteerSuccessMsg');
                        if (msg) {
                            msg.style.transition = "opacity 0.5s ease";
                            msg.style.opacity = "0";
                            setTimeout(() => {
                                msg.style.display = "none";
                            }, 500);
                        }
                    }, 5000);
                </script>
            <?php endif; ?>

            <form class="mx-auto" style="max-width:500px;" method="POST" action="index.php?page=volunteer/apply" novalidate>
                <?php if (isset($_SESSION['user'])): ?>
                    <input type="hidden" name="user_id" value="<?= $_SESSION['user']['id'] ?>">
                    <input type="hidden" name="name" value="<?= htmlspecialchars($_SESSION['user']['name']) ?>">
                <?php endif; ?>

                <!-- Email -->
                <div class="mb-3">
                    <label for="userEmail" class="form-label fw-semibold">Email</label>
                    <input type="email" class="form-control" id="userEmail" value="<?= htmlspecialchars($_SESSION['user']['email']) ?>" readonly>
                    <input type="hidden" name="email" value="<?= htmlspecialchars($_SESSION['user']['email']) ?>">
                </div>

                <!-- Contact Number -->
                <div class="mb-3">
                    <label for="contactNumber" class="form-label fw-semibold">Contact Number</label>
                    <div class="input-group">
                        <span class="input-group-text">+977</span>
                        <input
                            type="tel"
                            class="form-control guest-protected <?= isset($volunteer_errors['contact_number']) ? 'is-invalid' : '' ?>"
                            name="contact_number"
                            id="contactNumber"
                            placeholder="98XXXXXXXX"
                            required
                            value="<?= htmlspecialchars($old['contact_number'] ?? '') ?>">
                        <?php if (isset($volunteer_errors['contact_number'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($volunteer_errors['contact_number']) ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Area of Interest -->
                <?php $oldArea = $old['area'] ?? ''; ?>
                <div class="mb-3">
                    <label for="volInterest" class="form-label fw-semibold">Area of Interest</label>
                    <select
                        class="form-select guest-protected <?= isset($volunteer_errors['area']) ? 'is-invalid' : '' ?>"
                        name="area"
                        id="volInterest"
                        required>
                        <option value="" disabled <?= $oldArea === '' ? 'selected' : '' ?>>Select an option</option>
                        <option value="pet care" <?= $oldArea === 'pet care' ? 'selected' : '' ?>>Animal care</option>
                        <option value="training" <?= $oldArea === 'training' ? 'selected' : '' ?>>Adoption events / training</option>
                        <option value="fundraising" <?= $oldArea === 'fundraising' ? 'selected' : '' ?>>Fundraising & marketing</option>
                        <option value="other" <?= $oldArea === 'other' ? 'selected' : '' ?>>Other</option>
                    </select>
                    <?php if (isset($volunteer_errors['area'])): ?>
                        <div id="areaError" class="text-danger mb-2"><?= htmlspecialchars($volunteer_errors['area']) ?></div>
                    <?php endif; ?>
                </div>

                <!-- Availability Days -->
                <?php $oldAvailability = $old['availability_days'] ?? []; ?>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Availability Days</label>
                    <?php if (isset($volunteer_errors['availability_days'])): ?>
                        <div id="availabilityDaysError" class="text-danger mb-2"><?= htmlspecialchars($volunteer_errors['availability_days']) ?></div>
                    <?php endif; ?>

                    <?php
                    $days = [
                        "Weekends" => "Weekends",
                        "Weekdays" => "Weekdays",
                        "Mon-Wed" => "Mon-Wed",
                        "Thu-Fri" => "Thu-Fri",
                        "Evenings" => "Evenings",
                        "Flexible" => "Flexible"
                    ];
                    foreach ($days as $val => $label):
                    ?>
                        <div class="form-check">
                            <input
                                class="form-check-input guest-protected"
                                type="checkbox"
                                name="availability_days[]"
                                value="<?= $val ?>"
                                id="<?= strtolower(str_replace([' ', '-'], '', $val)) ?>"
                                <?= in_array($val, $oldAvailability) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="<?= strtolower(str_replace([' ', '-'], '', $val)) ?>">
                                <?= $label ?>
                            </label>
                        </div>
                    <?php endforeach; ?>

                </div>

                <!-- Remarks -->
                <div class="mb-3">
                    <label for="remarks" class="form-label fw-semibold">Remarks (Optional)</label>
                    <textarea
                        class="form-control guest-protected"
                        name="remarks"
                        id="remarks"
                        rows="3"><?= htmlspecialchars($old['remarks'] ?? '') ?></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-100 fw-bold guest-protected">Submit</button>
            </form>
        </div>
    </section>



</main>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const areaSelect = document.getElementById('volInterest');
        const checkboxes = document.querySelectorAll('input[name="availability_days[]"]');
        const areaError = document.getElementById('areaError');

        // Hide Area of Interest error when user selects a valid option
        if (areaSelect) {
            areaSelect.addEventListener('change', () => {
                const selectedValue = areaSelect.value;

                // If user selected a valid option
                if (selectedValue !== '') {
                    areaSelect.classList.remove('is-invalid');
                    if (areaError) {
                        areaError.style.display = 'none';
                    }
                }
            });
        }

        // Hide Availability Days error when any checkbox is checked
        checkboxes.forEach(box => {
            box.addEventListener('change', () => {
                const checkedCount = [...checkboxes].filter(c => c.checked).length;
                if (checkedCount > 0) {
                    const availError = document.getElementById('availabilityDaysError');
                    if (availError) availError.style.display = 'none';
                }
            });
        });

        // Optional: Hide contact number error when user types
        const contactInput = document.getElementById('contactNumber');
        if (contactInput) {
            contactInput.addEventListener('input', () => {
                contactInput.classList.remove('is-invalid');
                const next = contactInput.parentElement.querySelector('.invalid-feedback');
                if (next) next.style.display = 'none';
            });
        }
    });
</script>


<?php include 'app/views/partials/footer.php'; ?>