<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Game Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #121212;
            color: white;
        }

        .header {
            display: flex;
            align-items: center;
            padding: 15px 30px;
            background: #18181b;
            border-bottom: 1px solid #2a2a2a;
        }

        .nav-items {
            display: flex;
            gap: 20px;
        }

        .nav-item {
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            position: relative;
            transition: color 0.3s ease;
        }

        .nav-item::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background-color: #0078f2;
            transition: width 0.3s ease;
        }

        .nav-item:hover::after {
            width: 100%;
        }

        .login-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background: #18181b;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            transform: translateY(20px);
            opacity: 0;
            animation: fadeInUp 0.5s forwards;
        }

        @keyframes fadeInUp {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .form-control {
            background: #2a2a2a;
            border: none;
            color: white;
            padding: 12px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: #3a3a3a;
            box-shadow: 0 0 0 2px rgba(0, 120, 242, 0.5);
            color: white;
        }

        .form-label {
            color: #888;
            margin-bottom: 8px;
        }

        .btn-primary {
            background: #0078f2;
            border: none;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 120, 242, 0.3);
            background: #0086ff;
        }

        .btn-outline-secondary {
            border-color: #2a2a2a;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            background: #2a2a2a;
            border-color: #2a2a2a;
            color: white;
        }

        footer {
            background: #18181b;
            border-top: 1px solid #2a2a2a;
            padding: 20px;
            margin-top: 50px;
        }

        footer a {
            color: #888;
            text-decoration: none;
            margin: 0 10px;
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: #0078f2;
        }

        .navbar-brand {
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 20px;
        }

        .navbar-toggler {
            border-color: #2a2a2a;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 0.7)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .register-link {
            color: #0078f2;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .register-link:hover {
            color: #0086ff;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header class="header sticky-top">
        <a href="#" class="navbar-brand">Admin Game Store</a>
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <!-- <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link nav-item" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-item" href="produk.php">Products</a>
                        </li>
                    </ul> -->
                    <div class="ms-3">
                        <a href="register.php" class="btn btn-outline-secondary">Register</a>
                        <a href="login.php" class="btn btn-outline-secondary ms-2">Login</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="container my-5">
        <div class="login-container">
            <h2 class="text-center mb-4">Login Account</h2>
            <form>
                <div class="mb-3">
                    <label for="username" class="form-label">Username or Email</label>
                    <input type="text" class="form-control" id="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
            <p class="text-center mt-3">Don't have an account? <a href="register.php" class="register-link">Register here</a></p>
        </div>
    </div>

    <footer class="text-center">
        <div>
            <a href="#">Menu</a> |
            <a href="#">Payment</a> |
            <a href="#">Social Media</a> |
            <a href="#">Contact</a>
        </div>
        <p class="mt-3 text-muted">&copy; 2025 Game Store. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>