<?php
// Define the password you want to hash
$password = 'admin123'; // Replace with the actual password

// Generate the hashed password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Display the hashed password
echo "Hashed Password: " . $hashedPassword;
?>