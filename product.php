<?php
include('../config/db.php');

// Get product by ID
if (!isset($_GET['id'])) {
    die("Product ID not provided.");
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    die("Product not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['title']); ?> | NovaFurnish</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--dark);
            line-height: 1.6;
            background-color: var(--light);
        }

        h1, h2, h3, h4 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            line-height: 1.2;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .py-5 {
            padding: 3rem 0;
            margin-top: 40px;
        }

        .mb-4 {
            margin-bottom: 1.5rem;
        }

        .me-2 {
            margin-right: 0.5rem;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -15px;
        }

        .col-lg-6 {
            flex: 0 0 50%;
            max-width: 50%;
            padding: 0 15px;
        }

        /* Product Image */
        .product-img-container {
            background: var(--white);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

.product-img {
    width: 100%;         /* Make the image fill the container width */
    height: 100%;        /* Make the image fill the container height */
    object-fit: cover;   /* Cover the container, preserving aspect ratio */
    transition: var(--transition);
}


        /* Product Info */
        .product-info {
            background: var(--white);
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            height: 100%;
        }

        .product-title {
            font-size: 2rem;
            color: var(--secondary);
            margin-bottom: 10px;
        }

        .product-category {
            display: inline-block;
            background: var(--primary-light);
            color: var(--white);
            padding: 5px 15px;
            border-radius: 30px;
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        .product-description {
            color: var(--gray);
            margin-bottom: 25px;
            line-height: 1.7;
        }

        .product-price {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary);
            margin: 25px 0;
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            text-align: center;
        }

        .back-btn {
            background: var(--light);
            color: var(--primary);
            border: 1px solid var(--primary);
        }

        .back-btn:hover {
            background: var(--primary);
            color: var(--white);
        }

        .btn-whatsapp {
            background: #25D366;
            color: var(--white);
            width: 100%;
            margin-bottom: 25px;
        }

        .btn-whatsapp:hover {
            background: #128C7E;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* Specifications Table */
        .specs-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .specs-table tr {
            border-bottom: 1px solid #eee;
        }

        .specs-table td {
            padding: 12px 0;
        }

        .specs-table td:first-child {
            font-weight: 600;
            color: var(--secondary);
            width: 40%;
        }

        /* Responsive Styles */
        @media (max-width: 992px) {
            .product-img-container {
                height: 400px;
            }
        }

        @media (max-width: 768px) {
            .col-lg-6 {
                flex: 0 0 100%;
                max-width: 100%;
            }
            
            .product-img-container {
                height: 350px;
                margin-bottom: 30px;
            }
            
            .product-title {
                font-size: 1.8rem;
            }
        }

        @media (max-width: 576px) {
            .product-img-container {
                height: 300px;
            }
            
            .product-info {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <?php include('includes/navbar.php'); ?>

    <div class="container py-5">
        <a href="index.php" class="btn back-btn mb-4">
            <i class="fas fa-arrow-left me-2"></i> Back to Catalog
        </a>

        <div class="row">
            <!-- Product Image -->
            <div class="col-lg-6">
                <div class="product-img-container">
                    <img src="<?php echo htmlspecialchars($product['image_path']); ?>" class="product-img" alt="<?php echo htmlspecialchars($product['title']); ?>">
                </div>
            </div>
            
            <!-- Product Info -->
            <div class="col-lg-6">
                <div class="product-info">
                    <h1 class="product-title"><?php echo htmlspecialchars($product['title']); ?></h1>
                    <span class="product-category"><?php echo htmlspecialchars($product['category_name']); ?></span>
                    
                    <p class="product-description"><?php echo htmlspecialchars($product['description']); ?></p>
                    
                    <div class="product-price">
                        Ksh <?php echo number_format((float) preg_replace('/[^\d.]/', '', $product['price'])); ?>
                    </div>
                    
                    <?php
                    $whatsappNumber = "254712345678"; // REPLACE with your real number
                    $whatsappMessage = "Hello, I'm interested in the product: " . $product['title'] . " (Product ID: " . $product['id'] . ")";
                    $whatsappLink = "https://wa.me/{$whatsappNumber}?text=" . urlencode($whatsappMessage);
                    ?>
                    <a href="<?= $whatsappLink ?>" class="btn btn-whatsapp" target="_blank">
                        <i class="fab fa-whatsapp me-2"></i> Inquire on WhatsApp
                    </a>
                    
                    <!-- Product Specifications -->
                    <table class="specs-table">
                        <tr>
                            <td>Material</td>
                            <td><?php echo htmlspecialchars($product['material'] ?? 'Solid Wood'); ?></td>
                        </tr>
                        <tr>
                            <td>Dimensions</td>
                            <td><?php echo htmlspecialchars($product['dimensions'] ?? 'N/A'); ?></td>
                        </tr>
                        <tr>
                            <td>Weight</td>
                            <td><?php echo htmlspecialchars($product['weight'] ?? 'N/A'); ?></td>
                        </tr>
                        <tr>
                            <td>Color</td>
                            <td><?php echo htmlspecialchars($product['color'] ?? 'Natural'); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>