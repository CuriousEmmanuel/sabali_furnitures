<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include('../config/db.php');

// Add category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $name = trim($_POST['name']);
    if ($name !== '') {
        $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->execute([$name]);
        $_SESSION['message'] = 'Category added successfully!';
        header("Location: categories.php");
        exit;
    }
}

// Edit category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    if ($name !== '') {
        $stmt = $pdo->prepare("UPDATE categories SET name = ? WHERE id = ?");
        $stmt->execute([$name, $id]);
        $_SESSION['message'] = 'Category updated successfully!';
        header("Location: categories.php");
        exit;
    }
}

// Delete category
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    $_SESSION['message'] = 'Category deleted successfully!';
    header("Location: categories.php");
    exit;
}

// Get all categories
$categories = $pdo->query("SELECT * FROM categories ORDER BY id DESC")->fetchAll();

// If editing, get current category
$editCategory = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    $editCategory = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Categories | Urban Furniture Admin</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    
    <!-- Custom Styles -->
    <style>
        :root {
            --primary: #2A5C8B;  /* Deep Blue */
            --secondary: #3F4A4E; /* Dark Gray */
            --accent: #E8C07D;    /* Warm Gold */
            --background: #F8F9FA;/* Light Gray */
            --card-bg: #FFFFFF;
            --text-color: #2D3436;
        }

        body {
            background-color: var(--background);
            padding-top: 80px;
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
        }

        .admin-card {
            background: var(--card-bg);
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            border-left: 5px solid var(--accent);
        }

        h2 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            color: var(--secondary);
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(42, 92, 139, 0.25);
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 30px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--secondary);
            transform: scale(1.05);
        }

        .btn-outline-primary {
            border: 2px solid var(--primary);
            color: var(--primary);
            padding: 8px 16px;
            border-radius: 30px;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary);
            color: white;
        }

        .table th {
            background-color: var(--primary);
            color: white;
            font-weight: bold;
        }

        .table td {
            padding: 15px;
            vertical-align: middle;
        }

        .table-striped tbody tr:nth-child(odd) {
            background-color: rgba(42, 92, 139, 0.1);
        }

        .table-hover tbody tr:hover {
            background-color: var(--secondary);
            color: white;
        }

        .action-link {
            color: var(--accent);
            margin-right: 10px;
            transition: all 0.3s ease;
        }

        .action-link:hover {
            color: var(--primary);
            text-decoration: none;
        }

        .alert-message {
            position: fixed;
            top: 90px;
            right: 20px;
            z-index: 1000;
            animation: fadeInOut 5s forwards;
        }

        @keyframes fadeInOut {
            0% { opacity: 0; transform: translateY(-20px); }
            10% { opacity: 1; transform: translateY(0); }
            90% { opacity: 1; transform: translateY(0); }
            100% { opacity: 0; transform: translateY(-20px); }
        }

    </style>
</head>
<body>

<div class="container py-4">
    <!-- Success Message -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success alert-message alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
    
    <!-- Category Form -->
    <div class="admin-card">
        <h2 class="mb-4">
            <i class="fas fa-<?php echo $editCategory ? 'edit' : 'plus'; ?> me-2"></i>
            <?php echo $editCategory ? 'Edit Category' : 'Add New Category'; ?>
        </h2>
        
        <form method="POST">
            <div class="row g-3">
                <div class="col-md-8">
                    <input type="text" class="form-control" name="name" placeholder="Category name" 
                           value="<?php echo htmlspecialchars($editCategory['name'] ?? ''); ?>" required>
                </div>
                <div class="col-md-4">
                    <?php if ($editCategory): ?>
                        <input type="hidden" name="id" value="<?php echo $editCategory['id']; ?>">
                        <button type="submit" name="update" class="btn btn-primary me-2">
                            <i class="fas fa-save me-1"></i> Update
                        </button>
                        <a href="categories.php" class="btn btn-outline-primary">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                    <?php else: ?>
                        <button type="submit" name="add" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Add Category
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Categories Table -->
    <div class="admin-card">
        <h2 class="mb-4"><i class="fas fa-list me-2"></i>All Categories</h2>
        
        <?php if (count($categories) > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $cat): ?>
                            <tr>
                                <td><?php echo $cat['id']; ?></td>
                                <td>
                                    <a href="?edit=<?php echo $cat['id']; ?>" class="text-decoration-none" style="color: var(--primary);">
                                        <?php echo htmlspecialchars($cat['name']); ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="?edit=<?php echo $cat['id']; ?>" class="action-link" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="?delete=<?php echo $cat['id']; ?>" class="action-link text-danger" 
                                       title="Delete" onclick="return confirm('Are you sure you want to delete this category?');">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i> No categories found. Please add your first category.
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Back Button -->
    <div class="text-center mt-3">
        <a href="dashboard.php" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
        </a>
    </div>
</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
