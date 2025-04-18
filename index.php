<?php
include('config/db.php');
$categories = $pdo->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaFurnish | Contemporary Furniture</title>
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
            overflow-x: hidden;
        }

        h1, h2, h3, h4 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            line-height: 1.2;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .btn {
            display: inline-block;
            padding: 12px 30px;
            background-color: var(--primary);
            color: var(--white);
            border: none;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 14px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .btn:hover {
            background-color: var(--primary-light);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: var(--white);
        }

        /* Header & Navigation */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background-color: var(--white);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
        }

        .header-scrolled {
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            transition: var(--transition);
        }

        .logo {
            font-size: 26px;
            font-weight: 700;
            color: var(--primary);
            font-family: 'Playfair Display', serif;
            display: flex;
            align-items: center;
        }

        .logo-icon {
            margin-right: 8px;
            color: var(--accent);
        }

        .nav-links {
            display: flex;
            list-style: none;
        }

        .nav-links li {
            margin-left: 25px;
            position: relative;
        }

        .nav-links a {
            font-weight: 500;
            transition: var(--transition);
            padding: 5px 0;
            display: inline-block;
        }

        .nav-links a:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background: var(--primary);
            bottom: 0;
            left: 0;
            transition: var(--transition);
        }

        .nav-links a:hover:after {
            width: 100%;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .nav-icon {
            font-size: 20px;
            cursor: pointer;
            transition: var(--transition);
            padding: 5px;
        }

        .nav-icon:hover {
            color: var(--primary);
            transform: translateY(-2px);
        }

        .hamburger {
            display: none;
            cursor: pointer;
            font-size: 24px;
            padding: 5px;
        }

        /* Hero Section */
        .hero {
            height: 100vh;
            min-height: 600px;
            background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('https://images.unsplash.com/photo-1556228453-efd6c1ff04f6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') no-repeat center center/cover;
            display: flex;
            align-items: center;
            text-align: center;
            color: var(--white);
            padding-top: 80px;
            position: relative;
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
            animation: fadeIn 1s ease-out;
            position: relative;
            z-index: 2;
        }

        .hero h1 {
            font-size: clamp(2.5rem, 5vw, 4rem);
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .hero p {
            font-size: clamp(1rem, 2vw, 1.2rem);
            margin-bottom: 30px;
            opacity: 0.9;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .scroll-down {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            color: var(--white);
            font-size: 24px;
            animation: bounce 2s infinite;
            cursor: pointer;
        }

        /* Categories Section */
        .section {
            padding: 80px 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title h2 {
            font-size: clamp(1.8rem, 3vw, 2.5rem);
            color: var(--secondary);
            position: relative;
            display: inline-block;
        }

        .section-title h2:after {
            content: '';
            position: absolute;
            width: 50%;
            height: 3px;
            background: var(--accent);
            bottom: -10px;
            left: 25%;
        }

        .section-title p {
            max-width: 700px;
            margin: 15px auto 0;
            color: var(--gray);
        }

        .categories {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }

        .category-card {
            background: var(--white);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
            position: relative;
        }

        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .category-img {
            height: 250px;
            overflow: hidden;
        }

        .category-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .category-card:hover .category-img img {
            transform: scale(1.05);
        }

        .category-info {
            padding: 25px;
            text-align: center;
        }

        .category-info h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: var(--secondary);
        }

        .category-info p {
            color: var(--gray);
            margin-bottom: 15px;
        }

        .category-price {
            font-weight: 700;
            color: var(--primary);
            font-size: 1.1rem;
        }

        /* Products Section Styles to Match Theme */
#products .category-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.8rem;
    color: var(--secondary);
    text-align: center;
    margin: 60px 0 30px;
    position: relative;
}

#products .category-title::after {
    content: '';
    position: absolute;
    width: 80px;
    height: 3px;
    background: var(--accent);
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
}

#products .product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 30px;
    margin-bottom: 60px;
}

#products .product-card {
    background: var(--white);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    transition: var(--transition);
    position: relative;
}

#products .product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
}

#products .product-image {
    height: 200px;
    width: 100%;
    object-fit: cover;
    transition: var(--transition);
}

#products .product-card:hover .product-image {
    transform: scale(1.05);
}

#products .product-info {
    padding: 20px;
}

#products .product-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.2rem;
    color: var(--secondary);
    margin-bottom: 10px;
}

#products .product-material {
    color: var(--gray);
    margin-bottom: 15px;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
}

#products .product-material i {
    color: var(--accent);
    margin-right: 8px;
}

#products .price-tag {
    font-weight: 700;
    color: var(--primary);
    font-size: 1.1rem;
}

#products .btn-modern {
    background: var(--primary);
    color: var(--white);
    border: none;
    padding: 8px 15px;
    border-radius: 30px;
    cursor: pointer;
    transition: var(--transition);
    font-weight: 600;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

#products .btn-modern:hover {
    background: var(--primary-light);
    transform: translateY(-2px);
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    #products .product-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }
}

@media (max-width: 576px) {
    #products .product-grid {
        grid-template-columns: 1fr;
    }
    
    #products .category-title {
        font-size: 1.5rem;
        margin: 40px 0 20px;
    }
}

        /* Products Section */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
        }

        .product-card {
            background: var(--white);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .product-img {
            height: 200px;
            overflow: hidden;
            position: relative;
        }

        .product-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .product-card:hover .product-img img {
            transform: scale(1.05);
        }

        .product-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: var(--accent);
            color: var(--dark);
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            z-index: 1;
        }

        .product-info {
            padding: 20px;
        }

        .product-info h3 {
            font-size: 1.2rem;
            margin-bottom: 10px;
            color: var(--secondary);
        }

        .product-info p {
            color: var(--gray);
            margin-bottom: 15px;
            font-size: 0.9rem;
        }

        .product-price {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .price {
            font-weight: 700;
            color: var(--primary);
            font-size: 1.1rem;
        }

        .price del {
            color: var(--gray);
            font-size: 0.9rem;
            margin-left: 5px;
            opacity: 0.7;
        }

        .add-to-cart {
            background: var(--primary);
            color: var(--white);
            border: none;
            padding: 8px 15px;
            border-radius: 30px;
            cursor: pointer;
            transition: var(--transition);
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .add-to-cart:hover {
            background: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }

        /* Testimonials */
        .testimonials {
            background-color: var(--white);
            padding: 80px 0;
        }

        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .testimonial-card {
            background: var(--light);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .testimonial-card:before {
            content: '"';
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 60px;
            color: var(--primary-light);
            opacity: 0.2;
            font-family: serif;
            line-height: 1;
        }

        .testimonial-content {
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
        }

        .author-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 15px;
        }

        .author-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .author-info h4 {
            font-size: 1rem;
            margin-bottom: 5px;
        }

        .author-info p {
            font-size: 0.8rem;
            color: var(--gray);
        }

        .rating {
            color: var(--accent);
            margin-top: 3px;
        }

        /* Newsletter Section */
        .newsletter {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: var(--white);
            padding: 80px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .newsletter:before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .newsletter:after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -80px;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .newsletter .section-title h2 {
            color: var(--white);
        }

        .newsletter .section-title h2:after {
            background: var(--accent);
        }

        .newsletter p {
            max-width: 600px;
            margin: 0 auto 30px;
            opacity: 0.9;
        }

        .newsletter-form {
            display: flex;
            max-width: 500px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .newsletter-form input {
            flex: 1;
            padding: 15px 20px;
            border: none;
            border-radius: 30px 0 0 30px;
            font-size: 16px;
            outline: none;
        }

        .newsletter-form button {
            padding: 15px 25px;
            background: var(--accent);
            color: var(--dark);
            border: none;
            border-radius: 0 30px 30px 0;
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .newsletter-form button:hover {
            background: var(--white);
            transform: translateY(-2px);
        }

        /* Footer */
        footer {
            background: var(--secondary);
            color: var(--white);
            padding: 80px 0 20px;
            position: relative;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-column h3 {
            font-size: 1.3rem;
            margin-bottom: 20px;
            color: var(--accent);
            position: relative;
            padding-bottom: 10px;
        }

        .footer-column h3:after {
            content: '';
            position: absolute;
            width: 50px;
            height: 2px;
            background: var(--primary-light);
            bottom: 0;
            left: 0;
        }

        .footer-column p {
            margin-bottom: 15px;
            opacity: 0.8;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            opacity: 0.8;
            transition: var(--transition);
            display: inline-block;
        }

        .footer-links a:hover {
            opacity: 1;
            color: var(--accent);
            transform: translateX(5px);
        }

        .footer-links i {
            margin-right: 8px;
            width: 20px;
            text-align: center;
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-links a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transition: var(--transition);
        }

        .social-links a:hover {
            background: var(--accent);
            color: var(--dark);
            transform: translateY(-3px);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 14px;
            opacity: 0.7;
        }

        .payment-methods {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .payment-methods img {
            height: 25px;
            filter: brightness(0) invert(1);
            opacity: 0.7;
            transition: var(--transition);
        }

        .payment-methods img:hover {
            opacity: 1;
        }

        /* Back to Top Button */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: var(--primary);
            color: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            cursor: pointer;
            transition: var(--transition);
            opacity: 0;
            visibility: hidden;
            z-index: 999;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .back-to-top.active {
            opacity: 1;
            visibility: visible;
        }

        .back-to-top:hover {
            background: var(--accent);
            color: var(--dark);
            transform: translateY(-5px);
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0) translateX(-50%);
            }
            40% {
                transform: translateY(-20px) translateX(-50%);
            }
            60% {
                transform: translateY(-10px) translateX(-50%);
            }
        }

        /* Responsive Styles */
        @media (max-width: 992px) {
            .nav-links li {
                margin-left: 15px;
            }
            
            .hero-actions {
                flex-direction: column;
                gap: 10px;
            }
            
            .btn {
                width: 100%;
                max-width: 250px;
                margin: 0 auto;
            }
        }

        @media (max-width: 768px) {
            .hamburger {
                display: block;
                order: 1;
            }

            .logo {
                order: 2;
                margin-left: auto;
                margin-right: auto;
            }

            .nav-actions {
                order: 3;
            }

            .nav-links {
                position: fixed;
                top: 80px;
                left: -100%;
                width: 80%;
                height: calc(100vh - 80px);
                background: var(--white);
                flex-direction: column;
                align-items: center;
                padding: 40px 20px;
                transition: var(--transition);
                box-shadow: 5px 0 15px rgba(0, 0, 0, 0.1);
            }

            .nav-links.active {
                left: 0;
            }

            .nav-links li {
                margin: 15px 0;
            }

            .section {
                padding: 60px 0;
            }
            
            .newsletter-form {
                flex-direction: column;
            }
            
            .newsletter-form input,
            .newsletter-form button {
                border-radius: 30px;
                width: 100%;
            }
            
            .newsletter-form button {
                margin-top: 10px;
            }
        }

        @media (max-width: 576px) {
            .categories, .products-grid, .testimonial-grid {
                grid-template-columns: 1fr;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
            }
            
            .footer-column h3:after {
                left: 50%;
                transform: translateX(-50%);
            }
            
            .social-links {
                justify-content: center;
            }
            
            .back-to-top {
                bottom: 20px;
                right: 20px;
                width: 40px;
                height: 40px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <!-- Header & Navigation -->
   <?php include 'includes/navbar.php'; ?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>Elevate Your Living Space</h1>
                <p>Discover handcrafted furniture that combines contemporary design with timeless comfort</p>
                <div class="hero-actions">
                    <a href="#products" class="btn">Shop Collection</a>
                    <a href="#about" class="btn btn-outline">Learn More</a>
                </div>
            </div>
        </div>
        <div class="scroll-down" id="scrollDown">
            <i class="fas fa-chevron-down"></i>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="section" id="categories">
        <div class="container">
            <div class="section-title">
                <h2>Our Collections</h2>
                <p>Explore our carefully curated furniture collections designed for modern living</p>
            </div>


<!-- logic with php -->

<!-- Products Section -->
<div class="container py-4" id="products">
    <?php foreach ($categories as $cat): ?>
        <h3 id="cat-<?php echo $cat['id']; ?>" class="category-title">
            <?php echo htmlspecialchars($cat['name']); ?>
        </h3>

        <div class="product-grid">
            <?php
            $stmt = $pdo->prepare("SELECT * FROM products WHERE category_id = ?");
            $stmt->execute([$cat['id']]);
            $products = $stmt->fetchAll();
            ?>

            <?php if ($products): ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <a href="product.php?id=<?php echo $product['id']; ?>">
                            <img src="<?php echo htmlspecialchars($product['image_path']); ?>" class="product-image" alt="<?php echo htmlspecialchars($product['title']); ?>">
                        </a>
                        <div class="product-info">
                            <h5 class="product-title"><?php echo htmlspecialchars($product['title']); ?></h5>
                            <p class="product-material">
                                <i class="fas fa-cube"></i> <?php echo htmlspecialchars($product['material'] ?? 'Solid Wood Construction'); ?>
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="price-tag">Ksh <?php echo number_format((float) preg_replace('/[^\d.]/', '', $product['price'])); ?></span>
                                <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn-modern btn-sm">DETAILS</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center" style="color: var(--text-light);">NEW COLLECTION COMING SOON</p>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>




    <!-- Footer -->
    

    <!-- Back to Top Button -->
    <div class="back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </div>

    <script>
        // Mobile Navigation
        const hamburger = document.querySelector('.hamburger');
        const navLinks = document.querySelector('.nav-links');
        const header = document.getElementById('header');
        const scrollDown = document.getElementById('scrollDown');
        const backToTop = document.getElementById('backToTop');

        hamburger.addEventListener('click', () => {
            navLinks.classList.toggle('active');
            hamburger.classList.toggle('active');
        });

        // Close mobile menu when clicking on a link
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                navLinks.classList.remove('active');
                hamburger.classList.remove('active');
            });
        });

        // Sticky Header on Scroll
        window.addEventListener('scroll', () => {
            if (window.scrollY > 100) {
                header.classList.add('header-scrolled');
            } else {
                header.classList.remove('header-scrolled');
            }

            // Show/hide back to top button
            if (window.scrollY > 300) {
                backToTop.classList.add('active');
            } else {
                backToTop.classList.remove('active');
            }
        });

        // Scroll Down Button
        scrollDown.addEventListener('click', () => {
            window.scrollTo({
                top: window.innerHeight - 80,
                behavior: 'smooth'
            });
        });

        // Back to Top Button
        backToTop.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Smooth Scrolling for Anchor Links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Animation on Scroll
        const animateOnScroll = () => {
            const elements = document.querySelectorAll('.category-card, .product-card, .testimonial-card');
            
            elements.forEach(element => {
                const elementPosition = element.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.2;
                
                if (elementPosition < screenPosition) {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }
            });
        };

        // Set initial state for animation
        document.querySelectorAll('.category-card, .product-card, .testimonial-card').forEach(element => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(20px)';
            element.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        });

        window.addEventListener('scroll', animateOnScroll);
        window.addEventListener('load', animateOnScroll);

        // Lazy loading for images
        if ('loading' in HTMLImageElement.prototype) {
            const images = document.querySelectorAll('img[loading="lazy"]');
            images.forEach(img => {
                img.src = img.dataset.src;
            });
        } else {
            // Fallback for browsers that don't support lazy loading
            const script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js';
            document.body.appendChild(script);
        }
    </script>
</body>
</html>