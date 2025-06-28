<?php
$errors = $_SESSION['adminlogin_errors'] ?? [];
unset($_SESSION['adminlogin_errors']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Login - PawfectMatch</title>
    <link href="public/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"><!-- to use icons--of envelope user..-->
    <link rel="stylesheet" href="public/assets/css/login.css" />

</head>

<body>

    <div class="container d-flex justify-content-center align-items-center vh-100">

        <div class="login-form shadow p-4 rounded bg-white w-100" style="max-width: 400px;">
            <div class="text-center ">
                <div class="logobox">
                    <a class="navbar-brand " href="">PawfectMatch</a>
                </div>
            </div>
            <h2 class="text-center mb-4">Admin Login</h2>

            <!-- Show general login error -->
            <?php if (isset($errors['adminlogin'])): ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($errors['adminlogin']) ?>
                </div>
            <?php endif; ?>

            <form id="adminLoginForm" method="POST" action="index.php?page=admin/verify_admin" autocomplete="off">

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email"
                            class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                            id="email" name="email"
                            placeholder="Email"
                            autocomplete="new-email">

                        <?php if (isset($errors['email'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($errors['email']) ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password"
                            class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>"
                            id="adminPassword"
                            name="password"
                            placeholder="Password"
                            autocomplete="new-password">
                        <?php if (isset($errors['password'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($errors['password']) ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="form-check mb-3 mt-3">
                        <input type="checkbox" class="form-check-input" id="showAdminPasswordCheck" />
                        <label for="showAdminPasswordCheck" class="form-check-label">Show Passwords</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-success w-100 fw-semibold">Login</button>
            </form>

        </div>
    </div>

    <script src="public/assets/js/bootstrap.bundle.min.js"></script>

    <script src="public/assets/js/authentication.js"></script>

</body>

</html>