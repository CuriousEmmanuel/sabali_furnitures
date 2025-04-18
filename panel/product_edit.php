<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include('../config/db.php');

if (!isset($_GET['id'])) {
    header('Location: products.php');
    exit;
}

$id = $_GET['id'];

// Fetch product data
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    echo "Product not found!";
    exit;
}

// Fetch categories
$categories = $pdo->query("SELECT * FROM categories")->fetchAll();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];

    $image_path = $product['image_path']; // default to current

    // Check if new image uploaded
    if (!empty($_FILES['image']['name'])) {
        $new_image = time() . '_' . basename($_FILES['image']['name']);
        $target = '../uploads/' . $new_image;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $image_path = 'uploads/' . $new_image;
            // You could unlink old image here if you want
        }
    }

    // Update query
    $stmt = $pdo->prepare("UPDATE products SET title = ?, description = ?, price = ?, image_path = ?, category_id = ? WHERE id = ?");
    $stmt->execute([$title, $description, $price, $image_path, $category_id, $id]);

    header('Location: products.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
</head>
<body>
<h2>Edit Product</h2>

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" value="<?php echo htmlspecialchars($product['title']); ?>" required><br><br>

    <textarea name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea><br><br>

    <input type="text" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required><br><br>

    <select name="category_id" required>
        <?php foreach ($categories as $cat): ?>
            <option value="<?php echo $cat['id']; ?>" <?php if ($cat['id'] == $product['category_id']) echo 'selected'; ?>>
                <?php echo htmlspecialchars($cat['name']); ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <img src="../<?php echo $product['image_path']; ?>" width="150"><br><br>
    <input type="file" name="image"><br><small>(Leave blank to keep current image)</small><br><br>

    <button type="submit">Save Changes</button>
</form>

<br><a href="products.php">← Back to Products</a>
</body>
</html>
