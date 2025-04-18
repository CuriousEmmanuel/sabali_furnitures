<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

include('../config/db.php');

// Get product ID
if (!isset($_GET['id'])) {
    die("Product ID missing.");
}

$id = $_GET['id'];

// Fetch product
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    die("Product not found.");
}

// Fetch categories
$catStmt = $pdo->query("SELECT * FROM categories");
$categories = $catStmt->fetchAll();

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $category_id = $_POST['category_id'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . '_' . $_FILES['image']['name'];
        $targetPath = '../uploads/' . $imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);
        $image_path = 'uploads/' . $imageName;

        $update = $pdo->prepare("UPDATE products SET title = ?, category_id = ?, description = ?, price = ?, image_path = ? WHERE id = ?");
        $update->execute([$title, $category_id, $description, $price, $image_path, $id]);
    } else {
        $update = $pdo->prepare("UPDATE products SET title = ?, category_id = ?, description = ?, price = ? WHERE id = ?");
        $update->execute([$title, $category_id, $description, $price, $id]);
    }

    header("Location: products.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Edit Product</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" value="<?= $product['title'] ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Category</label>
            <select name="category_id" class="form-control" required>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $product['category_id']) ? 'selected' : '' ?>>
                        <?= $cat['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" required><?= $product['description'] ?></textarea>
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input type="text" name="price" value="<?= $product['price'] ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Change Image (optional)</label>
            <input type="file" name="image" class="form-control">
            <small>Current: <?= $product['image_path'] ?></small>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="products.php" class="btn btn-secondary">Cancel</a>
    </form>
</body>
</html>
