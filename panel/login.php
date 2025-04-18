<?php
session_start();

if (isset($_SESSION['admin'])) {
    header("Location: dashboard.php");
    exit;
}

include('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
        session_regenerate_id(true);
        $_SESSION['admin'] = true;
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['name'];
        $_SESSION['last_login'] = time();

        setcookie(session_name(), session_id(), [
            'expires' => time() + 3600,
            'path' => '/',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict'
        ]);

        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password";
        error_log("Failed login attempt for username: $username");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login | Urban Furniture</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Raleway:wght@400;600&display=swap" rel="stylesheet">

    <!-- NovaFurnish Themed Inline Styles -->
    <style>
        body {
            margin: 0;
            font-family: 'Raleway', sans-serif;
            background-color: #F8F9FA;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 30px;
        }

        .login-card {
            background-color: white;
            border-radius: 20px;
            padding: 40px 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .login-header h2 {
            font-family: 'Playfair Display', serif;
            color: #2A5C8B;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 600;
            color: #3F4A4E;
        }

        .input-group-text {
            background-color: #f2f2f2;
            border: none;
            border-radius: 8px 0 0 8px;
        }

        .form-control {
            border-radius: 0 8px 8px 0;
            border: 1px solid #ccc;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #2A5C8B;
        }

        .btn-login {
            background-color: #2A5C8B;
            color: white;
            border-radius: 30px;
            padding: 10px;
            font-weight: 600;
            transition: transform 0.2s ease;
        }

        .btn-login:hover {
            transform: scale(1.03);
        }

        .error-message {
            font-size: 14px;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            font-weight: 600;
            text-decoration: none;
            color: #2A5C8B;
            transition: color 0.3s;
        }

        .back-link:hover {
            color: #1f446b;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header text-center">
                <h2><i class="fas fa-lock me-2"></i> ADMIN LOGIN</h2>
            </div>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger text-center error-message">
                    <i class="fas fa-exclamation-circle me-2"></i><?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" autocomplete="off">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" name="username" class="form-control" placeholder="Enter username" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                    </div>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-login btn-lg">
                        <i class="fas fa-sign-in-alt me-2"></i> LOGIN
                    </button>
                </div>
            </form>

            <div class="text-center">
                <a href="../index.php" class="back-link">
                    <i class="fas fa-arrow-left me-2"></i>Back to Main Site
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Disable form submission on Enter key -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelector('form').addEventListener('keydown', function (e) {
                if (e.key === 'Enter' && e.target.tagName !== 'TEXTAREA') {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>
