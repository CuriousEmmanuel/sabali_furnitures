<?php
include('config/db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About Us | Urban Furniture</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        :root {
            --wood-dark: #3a2e26;
            --wood-medium: #6d5c4d;
            --wood-light: #a89988;
            --bg-grey: #f5f3f0;
            --text-dark: #2a2a2a;
            --text-light: #5a5a5a;
            --accent: #8b7355;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            background: var(--bg-grey);
            color: var(--text-dark);
            line-height: 1.6;
            padding-top: 80px; /* Offset for fixed navbar */
        }
        
        h1, h2, h3, h4 {
            font-family: 'Roboto Condensed', sans-serif;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: var(--wood-dark);
        }
        
        /* Sticky Navbar */
        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            padding: 15px 0;
            transition: all 0.3s ease;
        }
        
        .navbar-brand img {
            height: 40px;
        }
        
        .nav-link {
            color: var(--wood-dark) !important;
            font-weight: 600;
            margin: 0 10px;
            transition: color 0.3s;
        }
        
        .nav-link:hover {
            color: var(--accent) !important;
        }
        
        .btn-nav {
            background: var(--wood-medium);
            color: white !important;
            border-radius: 4px;
            padding: 8px 20px;
            transition: all 0.3s;
        }
        
        .btn-nav:hover {
            background: var(--wood-dark);
            transform: translateY(-2px);
        }
        
        /* About Us Content */
        .about-section {
            padding: 60px 0;
        }
        
        .about-header {
            position: relative;
            margin-bottom: 40px;
            padding-bottom: 15px;
        }
        
        .about-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 3px;
            background: var(--accent);
        }
        
        .mission-vision {
            background: white;
            padding: 30px;
            border-radius: 4px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

<?php include('includes/navbar.php'); ?>

<div class="container about-section">
    <div class="about-header">
        <h1>About Urban Furniture</h1>
    </div>
    
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="mission-vision">
                <h2>Our Story</h2>
                <p>Founded in 2015, Urban Furniture has grown from a small workshop to a leading provider of contemporary furniture solutions. We specialize in high-quality urban furniture for modern living spaces, combining comfort, durability, and style in every piece we create.</p>
            </div>
            
            <div class="mission-vision">
                <h4>Our Mission</h4>
                <p>To transform living and working spaces through thoughtfully designed furniture that blends functionality with aesthetic appeal. We take pride in our craftsmanship and are committed to exceeding customer expectations at every touchpoint.</p>
            </div>
            
            <div class="mission-vision">
                <h4>Our Vision</h4>
                <p>To become the most trusted name in urban furniture design, recognized for our sustainable practices, innovative designs, and exceptional customer service. We aim to redefine modern living through furniture that tells a story.</p>
            </div>
            
            <div class="mission-vision">
                <h4>Our Values</h4>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-check-circle me-2" style="color: var(--accent);"></i> Quality craftsmanship</li>
                    <li class="mb-2"><i class="fas fa-check-circle me-2" style="color: var(--accent);"></i> Sustainable materials</li>
                    <li class="mb-2"><i class="fas fa-check-circle me-2" style="color: var(--accent);"></i> Customer-centric approach</li>
                    <li class="mb-2"><i class="fas fa-check-circle me-2" style="color: var(--accent);"></i> Innovative design</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Navbar Scroll Effect -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navbar = document.querySelector('.navbar');
        
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                navbar.style.boxShadow = '0 4px 15px rgba(0,0,0,0.1)';
                navbar.style.padding = '10px 0';
            } else {
                navbar.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
                navbar.style.padding = '15px 0';
            }
        });
    });
</script>

</body>
</html>