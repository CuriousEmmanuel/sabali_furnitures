<?php
$url = "https://"; // Replace with your actual domain
$qr_api = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=" . urlencode($url);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QR Code - </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f3f0;
            font-family: 'Montserrat', sans-serif;
            padding-top: 80px;
            text-align: center;
        }
        .qr-container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            display: inline-block;
        }
        .qr-title {
            font-family: 'Roboto Condensed', sans-serif;
            font-size: 2rem;
            margin-bottom: 20px;
        }
        .qr-actions {
            margin-top: 20px;
        }
        .qr-actions a {
            margin: 0 10px;
        }
        .btn-custom {
            background-color: #2a9d8f;
            border: none;
            color: white;
        }
        .btn-custom:hover {
            background-color: #21867a;
        }
    </style>
</head>
<body>

<?php // include('includes/navbar.php'); ?>

<div class="container">
    <div class="qr-container">
        <h2 class="qr-title">Sabali Furnitures</h2>
        <h3 class="qr-title">Scan to view our products</h3>
        <img src="<?php echo $qr_api; ?>" alt="QR Code" id="qrImage" class="img-fluid">
        
        <div class="qr-actions mt-4">
    <!-- Download Button -->
    <a href="<?php echo $qr_api; ?>" download="sabali_furniture_qr.png" class="btn btn-custom">
        <i class="fas fa-download"></i> Download QR
    </a>

    <!-- WhatsApp Share -->
    <a href="https://wa.me/254700268962?text=Sabali%20Furnitures!%20Scan%20this%20QR%20to%20view%20our%20products:%20<?php echo urlencode($url); ?>" target="_blank" class="btn btn-success">
        <i class="fab fa-whatsapp"></i> Share on WhatsApp
    </a>

    <!-- Facebook Share -->
    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($url); ?>" target="_blank" class="btn btn-primary">
        <i class="fab fa-facebook-f"></i> Share on Facebook
    </a>

<div class="text-center mt-3">
    <a href="dashboard.php" class="btn btn-outline-primary">
        <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
    </a>
</div>

</div>


<?php //include('../includes/footer.php'); ?>
</body>
</html>
