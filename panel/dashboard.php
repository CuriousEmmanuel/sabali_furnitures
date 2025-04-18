<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include('../config/db.php');

$categoryCount = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
$productCount = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | NovaFurnish</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="background: #f0f2f5; padding-top: 80px; font-family: 'Segoe UI', sans-serif;">

<div class="container py-4">
    <div class="p-4 mb-4 rounded-4 shadow-sm" style="background: white;">
        <h1 class="mb-3" style="color: #333;"><i class="fas fa-tachometer-alt me-2 text-primary"></i> Admin Dashboard</h1>
        <p class="lead">Welcome back, <?php echo htmlspecialchars($_SESSION['admin_name'] ?? 'Admin'); ?>!</p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4 col-12">
            <div class="rounded-4 shadow-sm p-4 h-100" style="background: white; border-left: 5px solid #0d6efd;">
                <i class="fas fa-tags fa-2x text-secondary mb-3"></i>
                <div style="font-size: 2rem; font-weight: bold;"><?php echo $categoryCount; ?></div>
                <div style="text-transform: uppercase; font-size: 0.9rem; color: #666;">Categories</div>
            </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="rounded-4 shadow-sm p-4 h-100" style="background: white; border-left: 5px solid #198754;">
                <i class="fas fa-couch fa-2x text-secondary mb-3"></i>
                <div style="font-size: 2rem; font-weight: bold;"><?php echo $productCount; ?></div>
                <div style="text-transform: uppercase; font-size: 0.9rem; color: #666;">Products</div>
            </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="rounded-4 shadow-sm p-4 h-100" style="background: white; border-left: 5px solid #ffc107;">
                <i class="fas fa-shopping-cart fa-2x text-secondary mb-3"></i>
                <div style="font-size: 2rem; font-weight: bold;">Coming soon</div>
                <div style="text-transform: uppercase; font-size: 0.9rem; color: #666;">New Orders</div>
            </div>
        </div>
    </div>

    <h3 class="mb-4" style="color: #222;"><i class="fas fa-bolt me-2 text-warning"></i>Quick Actions</h3>

    <div class="row g-4">
        <div class="col-md-3 col-sm-6 col-12">
            <a href="products.php" class="text-decoration-none">
                <div class="text-center rounded-4 shadow-sm p-4 h-100" style="background: white; transition: 0.3s;">
                    <i class="fas fa-box-open fa-lg text-primary mb-2"></i>
                    <h6 style="color: #333;">Manage Products</h6>
                    <p style="font-size: 0.85rem; color: #777;">Add, edit or remove products</p>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <a href="categories.php" class="text-decoration-none">
                <div class="text-center rounded-4 shadow-sm p-4 h-100" style="background: white; transition: 0.3s;">
                    <i class="fas fa-list fa-lg text-success mb-2"></i>
                    <h6 style="color: #333;">Manage Categories</h6>
                    <p style="font-size: 0.85rem; color: #777;">Organize product categories</p>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <a href="orders.php" class="text-decoration-none">
                <div class="text-center rounded-4 shadow-sm p-4 h-100" style="background: white; transition: 0.3s;">
                    <i class="fas fa-receipt fa-lg text-warning mb-2"></i>
                    <h6 style="color: #333;">View Orders</h6>
                    <p style="font-size: 0.85rem; color: #777;">Process customer orders</p>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <a href="users.php" class="text-decoration-none">
                <div class="text-center rounded-4 shadow-sm p-4 h-100" style="background: white; transition: 0.3s;">
                    <i class="fas fa-users fa-lg text-danger mb-2"></i>
                    <h6 style="color: #333;">Manage Users</h6>
                    <p style="font-size: 0.85rem; color: #777;">Admin user management</p>
                </div>
            </a>
        </div>
    </div>

    <div class="mt-5">
        <h3 class="mb-4" style="color: #222;"><i class="fas fa-history me-2 text-info"></i>Recent Activity</h3>
        <div class="card shadow-sm rounded-4">
            <div class="card-body">
                <p class="text-muted mb-0">Activity log will appear here...</p>
            </div>
        </div>
    </div>

    <div class="text-center mt-5">
        <a href="logout.php" class="btn btn-dark px-4 py-2 rounded-3">
            <i class="fas fa-sign-out-alt me-2"></i> Logout
        </a>
    </div>
</div>

<a href="qr_code.php" class="qr-float-btn" title="Generate QR Code">
    <i class="fas fa-qrcode"></i>
</a>

<style>
.qr-float-btn {
    position: fixed;
    bottom: 80px;
    right: 20px;
    background-color: #0d6efd;
    color: white;
    border-radius: 50%;
    padding: 15px 18px;
    font-size: 24px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    z-index: 999;
    text-decoration: none;
    transition: background-color 0.3s ease;
}
.qr-float-btn:hover {
    background-color: #0b5ed7;
}
@media (max-width: 768px) {
    .qr-float-btn {
        bottom: 60px;
        right: 15px;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
