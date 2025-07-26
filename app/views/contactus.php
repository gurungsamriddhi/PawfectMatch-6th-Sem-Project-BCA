<?php
// extract $data to variables for easy access
$errors = $data['errors'] ?? [];
$old = $data['old'] ?? [];
$success = $data['success'] ?? '';
?>



<?php include 'app/views/partials/header.php'; ?>
<main>
  <!-- Start Contact us Hero Section -->
  <div class="hero">
    <div class="container">
      <div class="row justify-content-between mb-5">
        <div class="col-lg-5">
          <div class="intro-excerpt">
            <h1>Let's Get in Touch</h1>
            <p class="mb-4">Have questions about adopting a pet, making a donation, or rescuing an animal in need? We’d love to hear from you!</p>
          </div>
        </div>

        <div class="col-lg-7">
          <div class="hero-img-wrap">
            <img src="public/assets/images/herosection.png" class="img-fluid" alt="Hero Image">
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Hero Section -->

  <!-- Start Contact Section -->
  <div class="co-section">
    <div class="container">
      <div class="block">
        <div class="row justify-content-center">
          <div class="col-md-10 col-lg-10 pb-4">
            <div class="row mb-5">
              <!-- Address -->
              <div class="col-lg-4">
                <div class="service no-shadow align-items-center link horizontal d-flex active">
                  <div class="service-icon color-1 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                      <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                    </svg>
                  </div>
                  <div class="service-contents">
                    <p>Simalchaur-08, Pokhara 33700, Nepal</p>
                  </div>
                </div>
              </div>
              <!-- Email -->
              <div class="col-lg-4">
                <div class="service no-shadow align-items-center link horizontal d-flex active">
                  <div class="service-icon color-1 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                      <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555zM0 4.697v7.104l5.803-3.558L0 4.697zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757zm3.436-.586L16 11.801V4.697l-5.803 3.546z" />
                    </svg>
                  </div>
                  <div class="service-contents">
                    <p>info@yourdomain.com</p>
                  </div>
                </div>
              </div>
              <!-- Phone -->
              <div class="col-lg-4">
                <div class="service no-shadow align-items-center link horizontal d-flex active">
                  <div class="service-icon color-1 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                      <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                    </svg>
                  </div>
                  <div class="service-contents">
                    <p>+977 9876543210</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Full-Width Form & Map Row -->
            <div class="container-fluid px-0">
              <div class="row gx-3">
                <!-- Contact Form -->
                <div class="col-lg-6 mb-4">
                  <?php if (!empty($success)): ?>
                    <div class="alert alert-success"><?= $success ?></div>
                  <?php endif; ?>

                  <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                      <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                          <li><?= $error ?></li>
                        <?php endforeach; ?>
                      </ul>
                    </div>
                  <?php endif; ?>

                  <?php
                  $fname = $old['fname'] ?? ($_SESSION['user']['name'] ?? '');
                  $email = $old['email'] ?? ($_SESSION['user']['email'] ?? '');
                  $message = $old['message'] ?? '';
                  ?>



                 <form id="contact-form" action="index.php?page=contactcontroller/contactsubmit" method="POST">
                    <div class="form-group mb-3">
                      <label for="fname">Full Name</label>
                      <input type="text" class="form-control" name="fname" id="fname"
                             value="<?= htmlspecialchars($fname) ?>" required>
                    </div>

                    <div class="form-group mb-3">
                      <label for="contactEmail">Email Address</label>
                      <input type="email" class="form-control" name="email" id="contactEmail"
                             value="<?= htmlspecialchars($email) ?>" required autocomplete="email">
                    </div>

                    <div class="form-group mb-3">
                      <label for="message">Message</label>
                      <textarea class="form-control" name="message" id="message" rows="5" required><?= htmlspecialchars($message) ?></textarea>
                    </div>



                    <button type="submit" class="btn btn-primary-hover-outline">Send Message</button>
                  </form>
                </div>

                <script>
                  function toggleCenterSelect() {
                    var recipientType = document.getElementById('recipient_type').value;
                    document.getElementById('centerSelect').style.display = recipientType === 'adoption_center' ? 'block' : 'none';
                  }
                </script>

                <!-- Google Map -->
                <div class="col-lg-6">
                  <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3532.546129896565!2d83.9857218751968!3d28.240907006411267!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3995943dc2ecf801%3A0x3b4fc23f7ce4ebf1!2sSimalchaur%2C%20Pokhara%2033700%2C%20Nepal!5e0!3m2!1sen!2snp!4v1718447312345!5m2!1sen!2snp"
                    width="100%"
                    height="100%"
                    style="min-height: 400px; border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                  </iframe>
                </div>
              </div>
              <!-- End Form & Map Row -->

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Contact Section -->
</main>
<?php if (!empty($errors) || !empty($success)): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Scroll smoothly to the contact form container or main form element
        const form = document.getElementById('contact-form');
        if (form) {
            form.scrollIntoView({behavior: 'smooth'});

            // Focus first invalid input, or the form itself
            const invalidInput = form.querySelector('.is-invalid, input:invalid, textarea:invalid');
            if (invalidInput) {
                invalidInput.focus();
            } else {
                form.focus();
            }
        }
    });
</script>
<?php endif; ?>

<?php include 'app/views/partials/footer.php'; ?>