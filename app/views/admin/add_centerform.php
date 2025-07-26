<?php


// Load and clear errors and old inputs from session
$register_errors = $_SESSION['register_errors'] ?? [];
$register_success = $_SESSION['success_message'] ?? null;
$register_old = $_SESSION['register_old'] ?? [];

// Optionally clear session after reading
unset($_SESSION['register_errors'], $_SESSION['register_old'], $_SESSION['success_message']);
?>
<?php include 'app/views/admin/adminpartials/sidebaradmin.php'; ?>
<!-- Main Content -->
<div class="body-wrapper w-100">
	<!-- Header -->
	<header class="app-header bg-dark text-white py-3 px-4">
		<div class="d-flex justify-content-between align-items-center">
			<h5 class="mb-0">Add New Adoption Center</h5>
			<div class="d-flex align-items-center gap-3">
				<i class="fas fa-bell"></i>
				<i class="fas fa-user-circle"></i>
			</div>
		</div>
	</header>



	<!-- Content -->
	<div class="container-fluid py-5 px-5">
		<?php if ($register_success): ?>
			<div class="alert alert-success">
				<?= htmlspecialchars($register_success) ?>
			</div>
		<?php endif; ?>
		<form id="registerForm" method="POST" action="index.php?page=admin/add_Center" autocomplete="off">
			<?php if (!empty($register_errors)): ?>
				<div class="alert alert-danger">
					Please fix the errors below and try again.
				</div>
			<?php endif; ?>

			<!-- Name Field -->
			<div class="mb-3">
				<label for="name" class="form-label fw-semibold">Name</label>
				<input type="text"
					class="form-control <?= isset($register_errors['name']) ? 'is-invalid' : '' ?>"
					id="name"
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
				<label for="emailReg" class="form-label fw-semibold">Email</label>
				<!--adds bootstrap .is-invalid class only if there was an email error in the session-->
				<input type="email"
					class="form-control <?= isset($register_errors['email']) ? 'is-invalid' : '' ?>"
					id="emailReg"
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
			<button type="submit" class="btn btn-primary d-block mx-auto w-50 fw-semibold">Register</button>
		</form>


	</div>
	
	<?php include 'app/views/admin/adminpartials/admin_footer.php'; ?>