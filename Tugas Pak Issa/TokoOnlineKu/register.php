<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Game Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #121212;
            color: white;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        .register-container {
            max-width: 500px;
            margin: 40px auto;
            padding: 30px;
            background: #18181b;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            transform: translateY(20px);
            opacity: 0;
            animation: slideUp 0.6s ease forwards;
        }

        @keyframes slideUp {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .form-label {
            color: #ffffff;
            font-weight: 500;
            font-size: 0.9rem;
            margin-bottom: 8px;
            display: block;
            transform: translateY(0);
            transition: all 0.3s ease;
        }

        .form-control {
            background: #2a2a2a;
            border: 1px solid #3a3a3a;
            color: white;
            transition: all 0.3s ease;
            padding: 12px;
            font-size: 16px;
        }

        .form-control:focus {
            background: #2a2a2a;
            border-color: #0078f2;
            box-shadow: 0 0 0 2px rgba(0, 120, 242, 0.25);
            color: white;
        }

        .form-control:focus + .form-label {
            color: #0078f2;
        }

        .btn-register {
            background: #0078f2;
            color: white;
            border: none;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-register:hover {
            background: #0066cc;
            transform: translateY(-2px);
        }

        .btn-register:after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }

        .btn-register:focus:not(:active)::after {
            animation: ripple 1s ease-out;
        }


        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 0.5;
            }
            100% {
                transform: scale(100, 100);
                opacity: 0;
            }
        }

        .form-group {
            position: relative;
            margin-bottom: 24px;
        }

        .form-group:focus-within .form-label {
            color: #0078f2;
            transform: translateY(-2px);
        }

        .input-highlight {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: #0078f2;
            transition: width 0.3s ease;
        }

        .form-control:focus + .input-highlight {
            width: 100%;
        }

        .login-link {
            color: #0078f2;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .login-link:hover {
            color: #0066cc;
            text-decoration: underline;
        }

        footer {
            background: #18181b;
            color: #ffffff80;
            padding: 20px 0;
            margin-top: 60px;
        }

        footer a {
            color: #ffffff80;
            text-decoration: none;
            margin: 0 10px;
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-container">
            <h2 class="text-center mb-4">Create Account</h2>
            <form>
                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" required>
                    <div class="input-highlight"></div>
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" required>
                    <div class="input-highlight"></div>
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" required>
                    <div class="input-highlight"></div>
                </div>
                <div class="form-group">
                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmPassword" required>
                    <div class="input-highlight"></div>
                </div>
                <button type="submit" class="btn btn-register w-100">Create Account</button>
            </form>
            <p class="text-center mt-4">Already have an account? <a href="login.php" class="login-link">Sign In</a></p>
        </div>
    </div>

    <footer class="text-center">
        <div>
            <a href="#">About</a> |
            <a href="#">Support</a> |
            <a href="#">Community</a> |
            <a href="#">Contact</a>
        </div>
        <p class="mt-3">&copy; 2025 Game Store. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>