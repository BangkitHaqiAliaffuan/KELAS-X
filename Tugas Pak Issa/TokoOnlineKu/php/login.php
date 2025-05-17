<?php
include 'php/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if (empty($username) || empty($password)) {
        $error = "Please fill all required fields.";
    } else {
        // Using prepared statement to prevent SQL injection
        // Added role column to the SELECT query
        $stmt = $conn->prepare("SELECT id, email, password, role FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($password === $row['password']) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_email'] = $row['email'];
                $_SESSION['last_activity'] = time();
                
                // If remember me is checked
                if (isset($_POST['remember_me'])) {
                    setcookie('user_email', $row['email'], time() + 30 * 24 * 60 * 60, '/', '', true, true);
                }

                // Check user role and redirect accordingly
                    // $_SESSION['is_admin'] = true;
                    header("Location: index.php?menu=home");
                exit();
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "User not found.";
        }
        $stmt->close();
    }
}
?>
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

        .form-check-input {
            background-color: #2a2a2a;
            border-color: #888;
        }

        .form-check-input:checked {
            background-color: #0078f2;
            border-color: #0078f2;
        }

        .alert {
            background: #2a2a2a;
            border: none;
            color: #ff4444;
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
    <div class="container my-5">
        <div class="login-container">
            <h2 class="text-center mb-4">Login Account</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="username" class="form-label">Username or Email</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember_me" name="remember_me">
                    <label class="form-check-label" for="remember_me">Remember me</label>
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

