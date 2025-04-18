<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

include('../config/db.php');

if (!isset($_GET['id'])) {
    die("Missing product ID.");
}

$id = $_GET['id'];

// Optional: delete image file too if needed

$stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
$stmt->execute([$id]);

header("Location: products.php");
exit;
