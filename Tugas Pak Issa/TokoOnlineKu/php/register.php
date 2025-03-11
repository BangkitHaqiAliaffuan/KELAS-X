<?php
// Database configuration
include 'config.php';
// Create connection

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
$registration_error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirmPassword'];

    // Validate inputs
    $errors = [];

    // Username validation
    if (empty($username) || strlen($username) < 3 || strlen($username) > 50) {
        $errors[] = "Username must be between 3 and 50 characters.";
    }

    // Email validation
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address.";
    }

    // Password validation
    if (empty($password) || strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }

    // Confirm password
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // Check if username or email already exists
    if (empty($errors)) {
        $check_query = "SELECT * FROM users WHERE username = ? OR email = ?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $errors[] = "Username or email already exists.";
        }
        $stmt->close();
    }

    // If no errors, proceed with registration
    if (empty($errors)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Prepare and execute insert statement
        $insert_query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to login page with success message
            header("Location: index.php?menu=login");
            exit();
        } else {
            $registration_error = "Registration failed: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $registration_error = implode(" ", $errors);
    }
}

// Close the database connection
$conn->close();
?>
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

        .error-message {
            color: #ff4d4d;
            margin-bottom: 15px;
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
            
            <?php
            // Display registration errors
            if (!empty($registration_error)) {
                echo '<div class="alert alert-danger text-center">' . htmlspecialchars($registration_error) . '</div>';
            }
            ?>
            
            <form method="POST" id="registrationForm" onsubmit="return validateForm()">
                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required minlength="3" maxlength="50" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" required value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required minlength="8">
                </div>
                <div class="form-group">
                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required minlength="8">
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

    <script>
    function validateForm() {
        // Get form elements
        const username = document.getElementById('username');
        const email = document.getElementById('email');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirmPassword');

        // Validate username
        if (username.value.length < 3) {
            alert('Username must be at least 3 characters long');
            return false;
        }

        // Validate email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email.value)) {
            alert('Please enter a valid email address');
            return false;
        }

        // Validate password
        if (password.value.length < 8) {
            alert('Password must be at least 8 characters long');
            return false;
        }

        // Confirm password match
        if (password.value !== confirmPassword.value) {
            alert('Passwords do not match');
            return false;
        }

        return true;
    }
    </script>
</body>
</html>