<?php
// Replace 'YourAdminPassword123' with the password you want to hash
$password = 'P@wfectMatch$2025';

// Hash the password securely using PASSWORD_DEFAULT algorithm
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Output the hashed password string
echo $hashedPassword;
//INSERT INTO users (name, email, password, verify_token, is_verified, user_type) 
//VALUES ('PawfectMatch', 'pawfectmatch27@gmail.com', '$2y$10$E1.zcEjbrTnCDM2boRpGs.LSJ2ajN1aqM4atWjfk6DIc6JquIXb6e', '', 1, 'admin');
?>
