<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include('../config/db.php');

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        // Add new product
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $price = trim($_POST['price']);
        $category_id = $_POST['category_id'];
        $material = trim($_POST['material'] ?? '');
        $dimensions = trim($_POST['dimensions'] ?? '');

        // Handle image upload
        $image_path = '';
        if (!empty($_FILES['image']['name'])) {
            $image_name = time() . '_' . basename($_FILES['image']['name']);
            $target = '../uploads/' . $image_name;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $image_path = 'uploads/' . $image_name;
            }
        }

        if ($title && $description && $price && $category_id && $image_path) {
            $stmt = $pdo->prepare("INSERT INTO products (title, description, price, image_path, category_id, material, dimensions) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $description, $price, $image_path, $category_id, $material, $dimensions]);
            $_SESSION['message'] = 'Product added successfully!';
            header("Location: products.php");
            exit;
        }
    }
}

// Delete product
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    // Get image path before deleting
    $stmt = $pdo->prepare("SELECT image_path FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch();
    
    if ($product) {
        // Delete the image file
        $image_path = '../' . $product['image_path'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        // Delete from database
        $pdo->prepare("DELETE FROM products WHERE id = ?")->execute([$id]);
        $_SESSION['message'] = 'Product deleted successfully!';
        header("Location: products.php");
        exit;
    }
}

// Fetch categories for dropdown
$categories = $pdo->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll();

// Fetch all products with category names
$products = $pdo->query("
    SELECT p.*, c.name AS category_name 
    FROM products p 
    JOIN categories c ON p.category_id = c.id 
    ORDER BY p.id DESC
")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products | NovaFurnish Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #2A5C8B;
            --primary-light: #5D8CB3;
            --secondary: #3F4A4E;
            --accent: #E8C07D;
            --light: #F8F9FA;
            --dark: #2D3436;
            --white: #FFFFFF;
            --gray: #636E72;
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light);
            color: var(--dark);
            padding-top: 80px;
        }

        h1, h2, h3, h4 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
        }

        .admin-card {
            background: var(--white);
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            margin-bottom: 30px;
            border-left: 4px solid var(--accent);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(42, 92, 139, 0.25);
        }

        .btn-primary {
            background: var(--primary);
            border: none;
            padding: 10px 25px;
            border-radius: 30px;
            font-weight: 600;
            transition: var(--transition);
        }

        .btn-primary:hover {
            background: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .btn-outline-secondary {
            border-color: var(--primary);
            color: var(--primary);
        }

        .btn-outline-secondary:hover {
            background: var(--primary);
            color: var(--white);
        }

        .product-img-thumb {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #eee;
        }

        .table {
            background: var(--white);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .table th {
            background: var(--primary);
            color: var(--white);
            font-weight: 600;
            vertical-align: middle;
        }

        .table td, .table th {
            padding: 15px;
            vertical-align: middle;
        }

        .table tr:nth-child(even) {
            background-color: rgba(93, 140, 179, 0.05);
        }

        .action-btn {
            color: var(--primary);
            margin: 0 5px;
            transition: var(--transition);
            display: inline-block;
        }

        .action-btn:hover {
            color: var(--primary-light);
            transform: translateY(-2px);
        }

        .action-btn.delete {
            color: #dc3545;
        }

        .action-btn.delete:hover {
            color: #bb2d3b;
        }

        .price-tag {
            font-weight: 700;
            color: var(--primary);
        }

        .alert-message {
            position: fixed;
            top: 90px;
            right: 20px;
            z-index: 1000;
            animation: fadeInOut 5s forwards;
            border-radius: 8px;
        }

        @keyframes fadeInOut {
            0% { opacity: 0; transform: translateY(-20px); }
            10% { opacity: 1; transform: translateY(0); }
            90% { opacity: 1; transform: translateY(0); }
            100% { opacity: 0; transform: translateY(-20px); }
        }

        .file-upload {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }

        .file-upload-input {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-upload-label {
            display: block;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .file-upload-label:hover {
            border-color: var(--primary);
        }

        .text-accent {
            color: var(--accent);
        }

        .text-primary {
            color: var(--primary);
        }
    </style>
</head>
<body>

<div class="container py-4">
    <!-- Success Message -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success alert-message alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?php echo $_SESSION['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
    
    <!-- Add Product Form -->
    <div class="admin-card">
        <h2 class="mb-4"><i class="fas fa-plus-circle me-2 text-accent"></i> Add New Product</h2>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Product Title</label>
                    <input type="text" class="form-control" name="title" required>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">Category</label>
                    <select class="form-select" name="category_id" required>
                        <option value="">-- Select Category --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="col-md-4">
                    <label class="form-label">Price (Ksh)</label>
                    <input type="text" class="form-control" name="price" required>
                </div>
                
                <div class="col-md-4">
                    <label class="form-label">Material</label>
                    <input type="text" class="form-control" name="material">
                </div>
                
                <div class="col-md-4">
                    <label class="form-label">Dimensions</label>
                    <input type="text" class="form-control" name="dimensions" placeholder="e.g., 120x80x60cm">
                </div>
                
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description" rows="3" required></textarea>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">Product Image</label>
                    <div class="file-upload">
                        <label class="file-upload-label" id="file-name">
                            <i class="fas fa-cloud-upload-alt me-2"></i> Choose an image...
                        </label>
                        <input type="file" class="file-upload-input" name="image" accept="image/*" required>
                    </div>
                </div>
                
                <div class="col-12 mt-3">
                    <button type="submit" name="add" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Add Product
                    </button>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Products Table -->
    <div class="admin-card">
        <h2 class="mb-4"><i class="fas fa-couch me-2 text-accent"></i> All Products</h2>
        
        <?php if (count($products) > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $p): ?>
                            <tr>
                                <td>
                                    <img src="../<?php echo htmlspecialchars($p['image_path']); ?>" class="product-img-thumb" alt="<?php echo htmlspecialchars($p['title']); ?>">
                                </td>
                                <td>
                                    <strong><?php echo htmlspecialchars($p['title']); ?></strong><br>
                                    <small class="text-muted"><?php echo htmlspecialchars($p['material'] ?? 'N/A'); ?></small>
                                </td>
                                <td><?php echo htmlspecialchars($p['category_name']); ?></td>
                                <td class="price-tag">Ksh <?php echo number_format((float) preg_replace('/[^\d.]/', '', $p['price'])); ?></td>
                                <td>
                                    <a href="edit_product.php?id=<?php echo $p['id']; ?>" class="action-btn" title="Edit">
                                        <i class="fas fa-edit fa-lg"></i>
                                    </a>
                                    <a href="?delete=<?php echo $p['id']; ?>" class="action-btn delete" title="Delete" 
                                       onclick="return confirm('Are you sure you want to delete this product?');">
                                        <i class="fas fa-trash-alt fa-lg"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i> No products found. Please add your first product.
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Back Button -->
    <div class="text-center mt-3">
        <a href="dashboard.php" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
        </a>
    </div>
</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom Script -->
<script>
    // Show selected file name
    document.querySelector('.file-upload-input').addEventListener('change', function(e) {
        const fileName = e.target.files[0] ? e.target.files[0].name : 'Choose an image...';
        document.getElementById('file-name').innerHTML = `<i class="fas fa-cloud-upload-alt me-2"></i>${fileName}`;
    });
</script>

</body>
</html>