<?php include 'app/views/partials/header.php'; ?>

   <section class="py-5 bg-light">
    <div class="container">
      <h1 class="text-center mb-5 fw-bold">How the Adoption Process Works</h1>
      <div class="row g-4 justify-content-center">
        <?php
        $steps = [
          ['icon' => 'fa-user', 'title' => 'Create Your Profile', 'desc' => 'Sign up on Pawfect Match to create your personal profile.'],
          ['icon' => 'fa-search', 'title' => 'Search for a Pet', 'desc' => 'Browse available pets and find one that matches your preferences.'],
          ['icon' => 'fa-heart', 'title' => 'Express Interest', 'desc' => 'Found a pet you like? Contact us directly, we’ll guide you through the next steps.'],
          ['icon' => 'fa-calendar-check', 'title' => 'Arrange a Meet & Greet', 'desc' => 'We’ll help you schedule a meeting with the pet to ensure it’s a perfects match before adoption.'],
          ['icon' => 'fa-home', 'title' => 'Adopt the Pet', 'desc' => 'Complete the adoption process and bring your new pet home.']
        ];

        foreach ($steps as $i => $step): ?>
          <div class="col-md-6 col-lg-4">
            <div class="step-hover h-100 border-0 shadow-sm p-4 text-center rounded-4 ">
              <div class="icon-circle mb-3">
                <i class="fa <?= $step['icon'] ?> fa-lg text-primary"></i>
              </div>
              <h5 class="fw-semibold"><?= $step['title'] ?></h5>
              <p class="text-muted"><?= $step['desc'] ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  
<?php include 'app/views/partials/footer.php'; ?>
