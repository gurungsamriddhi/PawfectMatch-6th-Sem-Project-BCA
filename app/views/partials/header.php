<?php global $current_page; ?><!-- to apply css for active pages  -->
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="shortcut icon" href="favicon.png">

	<meta name="description" content="" />
	<meta name="keywords" content="bootstrap, bootstrap4" />

	<!-- Bootstrap CSS -->
	<link href="public/assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
	<link href="public/assets/css/tiny-slider.css" rel="stylesheet">
	<link href="public/assets/css/style.css" rel="stylesheet">
	<link href="public/assets/css/authentication.css" rel="stylesheet">
	<title>Pets For Adoption </title>
</head>

<body>

	<!-- Start Header/Navigation -->

	<nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark  sticky-top">


		<div class="container">
			<a class="navbar-brand" href="index.php?page=home">PawfectMatch</a>

			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbars">
				<span class="navbar-toggler-icon"></span><!--hamburger toggle button for small screens -->
			</button>

			<div class="collapse navbar-collapse" id="navbars">
				<ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
					<li class="nav-item  <?= ($current_page == 'home') ? 'active' : '' ?>"><!--class active to the list-->
						<a class="nav-link" href="index.php?page=home">Home</a>
					</li>
					<li class="nav-item <?= ($current_page == 'browse') ? 'active' : '' ?>">
						<a class="nav-link" href="index.php?page=browse">Browse</a>
					</li>

					<li class="nav-item <?= ($current_page == 'adoptionprocess') ? 'active' : '' ?>">
						<a class="nav-link" href="index.php?page=adoptionprocess">Adoption Process</a>
					</li>
					<li class="nav-item <?= ($current_page == 'volunteer') ? 'active' : '' ?>">
						<a class="nav-link" href="index.php?page=volunteer">Volunteer</a>
					</li>
					<li class="nav-item <?= ($current_page == 'aboutus') ? 'active' : '' ?>">
						<a class="nav-link" href="index.php?page=aboutus">About us</a>
					</li>
					<li class="nav-item <?= ($current_page == 'contactus') ? 'active' : '' ?>">
						<a class="nav-link" href="index.php?page=contactus">Contact us</a>
					</li>
					<button class="btn login-btn me-2 " data-bs-toggle="modal" data-bs-target="#loginModal">Login/Register</button>

				</ul>
			</div>
		</div>

	</nav>
	<!-- End Header/Navigation -->

	<!-- Login Modal -->

	<!-- Login Modal -->
	<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header border-0 d-flex justify-content-between align-items-center">
					<h5 class="modal-title mb-0" id="loginModalLabel">Login to Pawfect Match</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body pt-0">

					<form method="POST" action="login.php" autocomplete="off">
						<div class="mb-3">
							<label for="email" class="form-label fw-semibold">Email</label>
							<div class="input-group">
								<span class="input-group-text"><i class="fas fa-envelope"></i></span>
								<input type="email" class="form-control" id="email" name="email" placeholder="Email" required><!-- input validation and feedback logic check required here -->
								<div class="invalid-feedback">
									Please enter a valid email address.
								</div>
							</div>
						</div>
						<div class="mb-3">
							<label for="password" class="form-label fw-semibold">Password</label>
							<div class="input-group">
								<span class="input-group-text"><i class="fas fa-lock"></i></span>
								<input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
								<div class="invalid-feedback">
									Please enter a valid password
								</div>
							</div>
						</div>
						<button type="submit" class="btn btn-success w-100 fw-semibold">Login</button>
					</form>

					<div class="login-links">
						<a href="forgot_password.php">Forgot Password?</a><br>
						 Don’t have an account?
						<a href="#" data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal">Register</a>

					</div>
				</div>
			</div>
		</div>
</div>

		<!-- Register Modal -->
		<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header border-0">
						<h5 class="modal-title" id="registerModalLabel">Register for Pawfect Match</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
					</div>
					<div class="modal-body pt-0">

						<form method="POST" action="register.php" autocomplete="off">
							<div class="mb-3">
								<label for="name" class="form-label fw-semibold">Name</label>
								<input type="text" class="form-control" id="name" name="name" placeholder="Full Name" required>
							</div>
							<div class="mb-3">
								<label for="emailReg" class="form-label fw-semibold">Email</label>
								<input type="email" class="form-control" id="emailReg" name="email" placeholder="Email" required>
							</div>
							<div class="mb-3">
								<label for="passwordReg" class="form-label fw-semibold">Password</label>
								<input type="password" class="form-control" id="passwordReg" name="password" placeholder="Password" required>
							</div>
							<button type="submit" class="btn btn-success w-100 fw-semibold">Register</button>
						</form>

						<div class="login-links mt-3 text-center small">
							Already have an account?
							<a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">Login here</a>
						</div>
					</div>
				</div>
			</div>
		</div>


	