<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include('../config/db.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    if ($name) {
        $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->execute([$name]);
    }
}

// Handle deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $pdo->prepare("DELETE FROM categories WHERE id = ?")->execute([$id]);
}

// Fetch all categories
$categories = $pdo->query("SELECT * FROM categories ORDER BY id DESC")->fetchAll();
?>

<h2>Manage Categories</h2>

<form method="POST">
    <input type="text" name="name" placeholder="New Category" required>
    <button type="submit">Add</button>
</form>

<ul>
<?php foreach ($categories as $cat): ?>
    <li>
        <?php echo htmlspecialchars($cat['name']); ?>
        <a href="?delete=<?php echo $cat['id']; ?>" onclick="return confirm('Delete this category?')">🗑️</a>
    </li>
<?php endforeach; ?>
</ul>

<a href="index.php">← Back to Dashboard</a>
