<?php include 'app/views/partials/header.php'; ?>
<?php
// Province & Cities data for Nepal
$nepaliProvincesCities = [
    "Province 1" => ["Biratnagar", "Dharan", "Dhankuta", "Illam", "Morang", "Sunsari"],
    "Province 2" => ["Janakpur", "Birgunj", "Rajbiraj", "Jaleshwar", "Bardibas"],
    "Bagmati Province" => ["Kathmandu", "Lalitpur", "Bhaktapur", "Hetauda", "Madhyapur Thimi"],
    "Gandaki Province" => ["Pokhara", "Baglung", "Gorkha", "Damauli", "Besisahar"],
    "Lumbini Province" => ["Butwal", "Bhairahawa", "Gulmi", "Kapilvastu", "Dang"],
    "Karnali Province" => ["Birendranagar", "Jumla", "Dolpa", "Surkhet", "Mugu"],
    "Sudurpashchim Province" => ["Dhangadhi", "Tikapur", "Mahendranagar", "Baitadi", "Dadeldhura"]
];
?>

<?php
// Always safely define variables
$volunteer_errors = $_SESSION['volunteer_errors'] ?? [];
$volunteer_old = [];

// Only assign old values if there were errors
if (!empty($volunteer_errors)) {
    $volunteer_old = $_SESSION['volunteer_old'] ?? [];
}

$volunteer_success = $_SESSION['volunteer_success'] ?? '';

// Clear session after using values
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

    <section id="volunteerForm" class="py-5 bg-light" >
        <div class="container">
            <h3 class="mb-4 text-center fw-bold">Volunteer With Us</h3>

            <?php if (!empty($volunteer_errors['general'])): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($volunteer_errors['general']) ?></div>
            <?php endif; ?>

            <?php if (!empty($volunteer_errors['alreadyassigned'])): ?>
                <div class="alert alert-success"><?= htmlspecialchars($volunteer_errors['alreadyassigned']) ?></div>
            <?php endif; ?>

            <?php if (!empty($volunteer_errors['pending'])): ?>
                <div class="alert alert-warning"><?= htmlspecialchars($volunteer_errors['pending']) ?></div>
            <?php endif; ?>

            <?php if (!empty($volunteer_errors) && empty($volunteer_errors['alreadyassigned']) && empty($volunteer_errors['pending'])): ?>
                <div class="alert alert-danger">
                    Please fix the errors below and try again.
                </div>
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
                    <input type="hidden" name="user_id" value="<?= $_SESSION['user']['id'] ?? '' ?>">
                    <input type="hidden" name="name" value="<?= htmlspecialchars($_SESSION['user']['name']) ?>">
                <?php endif; ?>

                <!-- Email -->
                <div class="mb-3">
                    <label for="userEmail" class="form-label fw-semibold">Email</label>
                    <input type="email" class="form-control guest-protected" id="userEmail" value="<?= htmlspecialchars($_SESSION['user']['email'] ?? '') ?>" readonly>
                    <input type="hidden" name="email" value="<?= htmlspecialchars($_SESSION['user']['email'] ?? '') ?>">
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
                            value="<?= htmlspecialchars($volunteer_old['contact_number'] ?? '') ?>">

                        <?php if (isset($volunteer_errors['contact_number'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($volunteer_errors['contact_number']) ?></div>
                        <?php endif; ?>
                    </div>

                </div>
                <!-- Area of Interest -->
                <?php $oldArea = $volunteer_old['area'] ?? ''; ?>
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
                <?php $oldAvailability = $volunteer_old['availability_days'] ?? []; ?>
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

                <!-- Address Line 1 -->
                <div class="mb-3">
                    <label for="addressLine1" class="form-label fw-semibold">Address Line 1</label>
                    <div class="input-group">
                        <input
                            type="text"
                            class="form-control guest-protected <?= isset($volunteer_errors['address_line1']) ? 'is-invalid' : '' ?>"
                            name="address_line1"
                            id="addressLine1"
                            value="<?= htmlspecialchars($volunteer_old['address_line1'] ?? '') ?>"
                            required>
                        <?php if (isset($volunteer_errors['address_line1'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($volunteer_errors['address_line1']) ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Address Line 2 -->
                <div class="mb-3">
                    <label for="addressLine2" class="form-label fw-semibold">Address Line 2 (Optional)</label>
                    <input
                        type="text"
                        class="form-control guest-protected"
                        name="address_line2"
                        id="addressLine2"
                        value="<?= htmlspecialchars($volunteer_old['address_line2'] ?? '') ?>">
                </div>

                <!-- Province -->
                <div class="mb-3">
                    <label for="province" class="form-label fw-semibold">Province</label>

                    <select
                        class="form-select guest-protected <?= isset($volunteer_errors['province']) ? 'is-invalid' : '' ?>"
                        name="province"
                        id="province"
                        required>
                        <option value="" disabled <?= empty($volunteer_old['province']) ? 'selected' : '' ?>>Select Province</option>
                        <?php foreach (array_keys($nepaliProvincesCities) as $prov): ?>
                            <option value="<?= htmlspecialchars($prov) ?>" <?= (isset($volunteer_old['province']) && $volunteer_old['province'] === $prov) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($prov) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($volunteer_errors['province'])): ?>
                        <div id="provinceError" class="text-danger mb-2"><?= htmlspecialchars($volunteer_errors['province']) ?></div>
                    <?php endif; ?>
                </div>

                <!-- City -->
                <div class="mb-3">
                    <label for="city" class="form-label fw-semibold">City</label>
                    <div class="input-group">
                        <select
                            class="form-select guest-protected <?= isset($volunteer_errors['city']) ? 'is-invalid' : '' ?>"
                            name="city"
                            id="city"
                            required>
                            <option value="" disabled <?= empty($volunteer_old['city']) ? 'selected' : '' ?>>Select City</option>
                            <!-- City options populated dynamically by JS -->
                        </select>
                        <?php if (isset($volunteer_errors['city'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($volunteer_errors['city']) ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Postal Code -->
                <div class="mb-3">
                    <label for="postalCode" class="form-label fw-semibold">Postal Code</label>
                    <div class="input-group">
                        <input
                            type="text"
                            class="form-control guest-protected <?= isset($volunteer_errors['postal_code']) ? 'is-invalid' : '' ?>"
                            name="postal_code"
                            id="postalCode"
                            value="<?= htmlspecialchars($volunteer_old['postal_code'] ?? '') ?>">
                        <?php if (isset($volunteer_errors['postal_code'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($volunteer_errors['postal_code']) ?></div>
                        <?php endif; ?>
                    </div>
                </div>




                <!-- Remarks -->
                <div class="mb-3">
                    <label for="remarks" class="form-label fw-semibold">Remarks (Optional)</label>
                    <div class="input group">
                        <textarea
                            class="form-control guest-protected"
                            name="remarks"
                            id="remarks"
                            rows="3"
                            value="<?= htmlspecialchars($volunteer_old['remarks'] ?? '') ?>">
                    </textarea>
                    </div>
                </div>
                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-100 fw-bold guest-protected">Submit</button>
            </form>
        </div>
    </section>



</main>


<script>
    const provincesCities = <?= json_encode($nepaliProvincesCities) ?>;
    const oldProvince = <?= json_encode($volunteer_old['province'] ?? '') ?>;
    const oldCity = <?= json_encode($volunteer_old['city'] ?? '') ?>;
</script>
<script src="public/assets/js/volunteerform.js"></script>

<?php include 'app/views/partials/footer.php'; ?>