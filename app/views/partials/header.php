<?php global $current_page; ?>
<!-- to apply css for active pages  -->
<?php

$register_errors = $_SESSION['register_errors'] ?? [];
$register_old = [];
//only assign old input if there are errors
if (!empty($register_errors)) {  
	$register_old = $_SESSION['old'] ?? [];
}

$register_success = $_SESSION['success_message'] ?? null;
$keep_modal_open = $_SESSION['keep_register_modal_open'] ?? false;

//login form sessions variables
$login_errors = $_SESSION['login_errors'] ?? [];
$keep_login_modal_open = $_SESSION['keep_login_modal_open'] ?? false;
$login_old = [];

if (!empty($login_errors)) {
	$login_old = $_SESSION['old_login'] ?? [];
}

$verification_success = $_SESSION['verification_success'] ?? null;
$verification_error = $_SESSION['verification_error'] ?? null;

unset(
	$_SESSION['verification_success'],
	$_SESSION['verification_error']
);
// Clear for next request
unset(
	$_SESSION['register_errors'],
	$_SESSION['old'],
	$_SESSION['success_message'],
	$_SESSION['keep_register_modal_open']
); //immediately removes them from session ,so they don't persist after reload

//clear login session data for next request
unset(
	$_SESSION['login_errors'],
	$_SESSION['old_login'],
	$_SESSION['keep_login_modal_open']
)
?>

<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!--<link rel="shortcut icon" href="favicon.png">
    <meta name="description" content="" />
	<meta name="keywords" content="bootstrap, bootstrap4" />-->

	<!-- Bootstrap CSS -->
	<link href="public/assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"><!-- to use icons--of envelope user..-->
	<link href="public/assets/css/tiny-slider.css" rel="stylesheet">
	<link href="public/assets/css/style.css" rel="stylesheet">
	<link href="public/assets/css/user.css" rel="stylesheet">
	<title>Pets For Adoption </title>
	<script>
    const isLoggedIn = <?= isset($_SESSION['user']) ? 'true' : 'false' ?>;
</script>
</head>

<body>

	<!-- Start Header/Navigation -->

	<nav class="custom-navbar navbar navbar-expand-md navbar-dark  sticky-top">


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
					<li class="nav-item <?= ($current_page == 'aboutus') ? 'active' : '' ?>">
						<a class="nav-link" href="index.php?page=aboutus">About us</a>
					</li>
					<li class="nav-item <?= ($current_page == 'browse') ? 'active' : '' ?>">
						<a class="nav-link" href="index.php?page=browse">Browse</a>
					</li>
                    <li class="nav-item dropdown <?= ($current_page == 'donate' || $current_page == 'volunteer') ? 'active' : '' ?>">
                       <a class="nav-link dropdown-toggle" href="#" id="servicesDropdown" role="button" onclick="toggleServicesDropdown(event)">
                         Services
                       </a>
					   <ul class="dropdown-menu" id="servicesDropdownMenu" aria-labelledby="servicesDropdown" style="display: none;">
						<li><a class="dropdown-item <?= ($current_page == 'donate') ? 'active' : '' ?>" href="index.php?page=donate">Donation</a></li>
						<li><a class="dropdown-item <?= ($current_page == 'volunteer') ? 'active' : '' ?>" href="index.php?page=volunteer">Volunteer</a></li>
					   </ul>
				    </li>
                    <li class="nav-item <?= ($current_page == 'adoptionprocess') ? 'active' : '' ?>">
						<a class="nav-link" href="index.php?page=adoptionprocess">Adoption Process</a>
					</li>
                    <li class="nav-item <?= ($current_page == 'contactus') ? 'active' : '' ?>">
						<a class="nav-link" href="index.php?page=contactus">Contact us</a>
					</li>
					<?php if (isset($_SESSION['user'])): ?>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" onclick="toggleUserDropdown(event)">
            <i class="fas fa-user-circle me-2" style="font-size: 1.2rem;"></i>
            <span><?= htmlspecialchars($_SESSION['user']['name']) ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" id="userDropdownMenu" aria-labelledby="userDropdown" style="display: none;">
            <li><a class="dropdown-item" href="index.php?page=user_dashboard"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
            <li><a class="dropdown-item" href="index.php?page=user_profile"><i class="fas fa-user-edit me-2"></i>Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#" onclick="confirmLogout(event)"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
        </ul>
    </li>
<?php endif; ?>
				</ul>
				<!-- Auth buttons -->
				<div class="d-flex">
    <?php if (!isset($_SESSION['user'])): ?>
        <button class="btn login-btn " data-bs-toggle="modal" data-bs-target="#loginModal">Login/Register</button>
    <?php endif; ?>
</div>

			</div>
	</nav>
	<!-- End Header/Navigation -->



	<!-- Login Modal -->
	<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header border-0 d-flex justify-content-between align-items-center">
					<h5 class="modal-title mb-0" id="loginModalLabel">Login to PawfectMatch</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body pt-0">


					<form id="loginForm" method="POST" action="index.php?page=login" autocomplete="off">
						<?php if (isset($login_errors['login'])): ?>
							<div class="alert alert-danger">
								<?= htmlspecialchars($login_errors['login']) ?>
							</div>
						<?php endif; ?>

						<div class="mb-3">
							<label for="loginEmail" class="form-label fw-semibold">Email</label>
							<div class="input-group">
								<span class="input-group-text"><i class="fas fa-envelope"></i></span>
								<input type="email"
									class="form-control <?= isset($login_errors['email']) ? 'is-invalid' : '' ?>"
									id="loginEmail" name="email"
									placeholder="Email"
									autocomplete="new-email"
									value="<?= htmlspecialchars($login_old['email'] ?? '') ?>">

								<?php if (isset($login_errors['email'])): ?>
									<div class="invalid-feedback"><?= htmlspecialchars($login_errors['email']) ?></div>
								<?php endif; ?>
							</div>
						</div>
						<div class="mb-3">
							<label for="loginPassword" class="form-label fw-semibold">Password</label>
							<div class="input-group">
								<span class="input-group-text"><i class="fas fa-lock"></i></span>
								<input type="password"
									class="form-control <?= isset($login_errors['password']) ? 'is-invalid' : '' ?>"
									id="loginPassword"
									name="password"
									placeholder="Password"
									autocomplete="new-password">
								<?php if (isset($login_errors['password'])): ?>
									<div class="invalid-feedback"><?= htmlspecialchars($login_errors['password']) ?></div>
								<?php endif; ?>
							</div>
							<div class="form-check mb-3 mt-3">
								<input type="checkbox" class="form-check-input" id="ShowLoginPasswordCheck" />
								<label for="ShowLoginPasswordCheck" class="form-check-label">Show Passwords</label>
							</div>
						</div>
						<button type="submit" class="btn btn-primary w-100 fw-semibold">Login</button>
					</form>

					<div class="login-links">
						<a href="forgot_password.php">Forgot Password?</a><br>
						Don’t have an account?
						<a href="#"  data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal">Register</a>

					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- Register Modal -->
	<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header border-0 d-flex justify-content-between align-items-center">
					<h5 class="modal-title mb-0" id="registerModalLabel">Register for PawfectMatch</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body pt-0">
					<?php if ($register_success): ?>
						<div class="alert alert-success">
							<?= htmlspecialchars($register_success) ?> You can now login.
						</div>
					<?php endif; ?>

					<form id="registerForm" method="POST" action="index.php?page=register" autocomplete="off">
						<?php if (!empty($register_errors)): ?>
							<div class="alert alert-danger">
								Please fix the errors below and try again.
							</div>
						<?php endif; ?>

						<!-- Name Field -->
						<div class="mb-3">
							<label for="registerName" class="form-label fw-semibold">Name</label>
							<input type="text"
								class="form-control <?= isset($register_errors['name']) ? 'is-invalid' : '' ?>"
								id="registerName"
								name="name"
								placeholder="Full Name"
								autocomplete="new-name"
								value="<?= htmlspecialchars($register_old['name'] ?? '') ?>"><!-- if $register_old['name'] is set and not null use its value -->
							<?php if (isset($register_errors['name'])): ?>
								<div class="invalid-feedback"><?= htmlspecialchars($register_errors['name']) ?></div>
							<?php endif; ?>
						</div>

						<!-- Email Field -->
						<div class="mb-3">
							<label for="registerEmail" class="form-label fw-semibold">Email</label>
							<!--adds bootstrap .is-invalid class only if there was an email error in the session-->
							<input type="email"
								class="form-control <?= isset($register_errors['email']) ? 'is-invalid' : '' ?>"
								id="registerEmail"
								name="email"
								placeholder="Email"
								autocomplete="new-email"
								value="<?= htmlspecialchars($register_old['email'] ?? '') ?>">
							<?php if (isset($register_errors['email'])): ?>
								<div class="invalid-feedback"><?= htmlspecialchars($register_errors['email']) ?></div>
							<?php endif; ?>
						</div>

						<!-- Password Field -->
						<div class="mb-3">
							<label for="passwordReg" class="form-label fw-semibold">Password</label>
							<input type="password"
								class="form-control <?= isset($register_errors['password']) ? 'is-invalid' : '' ?>"
								id="passwordReg"
								name="password"
								placeholder="Password" autocomplete="new-password">
							<?php if (isset($register_errors['password'])): ?>
								<div class="invalid-feedback"><?= htmlspecialchars($register_errors['password']) ?></div>
							<?php endif; ?>
						</div>

						<!-- Confirm Password Field -->
						<div class="mb-3">
							<label for="confirmPasswordReg" class="form-label fw-semibold">Confirm Password</label>
							<input type="password"
								class="form-control <?= isset($register_errors['confirm_password']) ? 'is-invalid' : '' ?>"
								id="confirmPasswordReg"
								name="confirm_password"
								placeholder="Confirm Password" autocomplete="confirm-password">
							<div id="passwordMismatch" class="text-danger small mb-2" style="display: none;">
								Passwords do not match.
							</div>

							<?php if (isset($register_errors['confirm_password'])): ?>
								<div class="invalid-feedback"><?= htmlspecialchars($register_errors['confirm_password']) ?></div>
							<?php endif; ?>
						</div>

						<!-- Show Password Checkbox -->
						<div class="form-check mb-3">
							<input type="checkbox" class="form-check-input" id="showPasswordCheck" />
							<label for="showPasswordCheck" class="form-check-label">Show Passwords</label>
						</div>

						<!-- Submit Button -->
						<button type="submit" class="btn btn-primary w-100 fw-semibold">Register</button>
					</form>

					<div class="login-links mt-3 text-center small">
						Already have an account?
						<a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">Login here</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Logout Confirmation Modal -->
	<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header border-0 d-flex justify-content-between align-items-center">
					<h5 class="modal-title mb-0" id="logoutModalLabel">Confirm Logout</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body d-flex justify-content-center align-items-center" style="height: 100px;">
					Are you sure you want to log out?
				</div>
				<div class="modal-footer border-0 d-flex justify-content-center align-items-center">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					<a href="index.php?page=logout" class="btn btn-danger">Logout</a>
				</div>
			</div>
		</div>
	</div>

	<?php if (
		!empty($register_errors) ||
		$register_success ||
		$keep_login_modal_open ||
		$verification_success ||
		$verification_error
	): ?>
		<script>
			document.addEventListener('DOMContentLoaded', function() {
				<?php if (!empty($register_errors) || $register_success): ?>
					new bootstrap.Modal(document.getElementById('registerModal')).show();
				<?php endif; ?>

				<?php if ($keep_login_modal_open || $verification_success): ?>
					new bootstrap.Modal(document.getElementById('loginModal')).show();
				<?php endif; ?>

				<?php if ($verification_success): ?>
					alert("<?= addslashes($verification_success) ?>");
				<?php elseif ($verification_error): ?>
					alert("<?= addslashes($verification_error) ?>");
				<?php endif; ?>
			});
		</script>
	<?php endif; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Custom dropdown functionality
function toggleUserDropdown(event) {
    event.preventDefault();
    event.stopPropagation();
    
    const dropdownMenu = document.getElementById('userDropdownMenu');
    const isVisible = dropdownMenu.style.display === 'block';
    
    // Close all other dropdowns first
    document.querySelectorAll('.dropdown-menu').forEach(menu => {
        menu.style.display = 'none';
    });
    
    // Toggle current dropdown
    dropdownMenu.style.display = isVisible ? 'none' : 'block';
    
    console.log('User dropdown toggled, visible:', !isVisible);
}

function toggleServicesDropdown(event) {
    event.preventDefault();
    event.stopPropagation();
    
    const dropdownMenu = document.getElementById('servicesDropdownMenu');
    const isVisible = dropdownMenu.style.display === 'block';
    
    // Close all other dropdowns first
    document.querySelectorAll('.dropdown-menu').forEach(menu => {
        menu.style.display = 'none';
    });
    
    // Toggle current dropdown
    dropdownMenu.style.display = isVisible ? 'none' : 'block';
    
    console.log('Services dropdown toggled, visible:', !isVisible);
}

function confirmLogout(event) {
    event.preventDefault();
    event.stopPropagation();
    
    const logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
    logoutModal.show();
}

// Close dropdown when clicking outside
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, setting up dropdown...');
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const userDropdownMenu = document.getElementById('userDropdownMenu');
        const userDropdown = document.getElementById('userDropdown');
        const servicesDropdownMenu = document.getElementById('servicesDropdownMenu');
        const servicesDropdown = document.getElementById('servicesDropdown');
        
        // Close user dropdown if clicking outside
        if (userDropdownMenu && !userDropdown.contains(event.target) && !userDropdownMenu.contains(event.target)) {
            userDropdownMenu.style.display = 'none';
        }
        
        // Close services dropdown if clicking outside
        if (servicesDropdownMenu && !servicesDropdown.contains(event.target) && !servicesDropdownMenu.contains(event.target)) {
            servicesDropdownMenu.style.display = 'none';
        }
    });
    
    // Close dropdown when pressing Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const userDropdownMenu = document.getElementById('userDropdownMenu');
            const servicesDropdownMenu = document.getElementById('servicesDropdownMenu');
            
            if (userDropdownMenu) {
                userDropdownMenu.style.display = 'none';
            }
            if (servicesDropdownMenu) {
                servicesDropdownMenu.style.display = 'none';
            }
        }
    });
});
</script>
</body>
</html>