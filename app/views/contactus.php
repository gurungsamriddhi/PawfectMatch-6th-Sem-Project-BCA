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
                  <form action="index.php?page=contactsubmit" method="POST">
                    <div class="row">
                      <div class="col-6">
                        <div class="form-group">
                          <label class="text-black" for="fname">First name</label>
                          <input type="text" class="form-control" id="fname" name="fname" required>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group">
                          <label class="text-black" for="lname">Last name</label>
                          <input type="text" class="form-control" id="lname" required>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="text-black" for="email">Email address</label>
                      <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group mb-4">
                      <label class="text-black" for="message">Message</label>
                      <textarea class="form-control" id="message" cols="30" rows="5" name="message" required></textarea>
                    </div>
               <!-- Recipient selection: Admin or Adoption Center -->
                    <div class="form-group mb-4">
                      <label for="recipient_type">Send to:</label>
                      <select id="recipient_type" name="recipient_type" class="form-control" required onchange="toggleCenterSelect()">
                        <option value="" disabled selected>Select recipient</option>
                        <option value="admin">Admin</option>
                        <option value="adoption_center">Adoption Center</option>
                      </select>
                    </div>

                    <!-- Adoption centers dropdown, hidden by default -->
                    <div class="form-group mb-4" id="centerSelect" style="display:none;">
                      <label for="recipient_id">Choose Adoption Center</label>
                      <select id="recipient_id" name="recipient_id" class="form-control">
                        <option value="" disabled selected>Select center</option>
                        <!-- Options will be filled dynamically by PHP -->
                        <?php
                        // Example PHP to fill options from $centers array
                        foreach ($centers as $center) {
                          echo "<option value=\"{$center['user_id']}\">" . htmlspecialchars($center['name']) . "</option>";
                        }
                        ?>
                      </select>
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

<?php include 'app/views/partials/footer.php'; ?>