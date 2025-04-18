<?php
include('../config/db.php');

$username = "Elias"; 
$password = "12345"; 

// Hash the password for storage
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert into the admin table
$stmt = $pdo->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
$stmt->execute([$username, $hashed_password]);

echo "Admin user created successfully!";
?>
