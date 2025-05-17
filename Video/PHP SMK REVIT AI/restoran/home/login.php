<?php 
    if(isset($_POST['login'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $sql = "SELECT * FROM tablepelanggan WHERE email='$email' AND password='$password' AND aktif=1";
            
        $count = $db->rowCOUNT($sql);

        if($count == 0){
            $error_message = "Email atau password salah. Silakan coba lagi.";
        } else {
            $row = $db -> getITEM($sql);

            $_SESSION['pelanggan'] = $row['email'];
            $_SESSION['idpelanggan'] = $row['idpelanggan'];
            header("Location: index.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Restoran SMK</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../css/custom.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        :root {
            --primary-color: #0ea5e9;
            --primary-dark: #0284c7;
            --primary-light: #e0f2fe;
            --secondary-color: #14b8a6;
            --accent-color: #8b5cf6;
            --dark-color: #1e293b;
            --light-color: #f8fafc;
            --gray-color: #e2e8f0;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin: 0;
        }
        
        .login-container {
            width: 100%;
            max-width: 420px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            animation: fadeInUp 0.5s ease-out;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .login-header {
            padding: 30px 30px 20px;
            text-align: center;
        }
        
        .login-logo {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #0ea5e9, #14b8a6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 30px;
            box-shadow: 0 10px 20px rgba(14, 165, 233, 0.2);
        }
        
        .login-header h3 {
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 10px;
        }
        
        .login-header p {
            color: #64748b;
            font-size: 15px;
            margin-bottom: 0;
        }
        
        form {
            padding: 0 30px 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #1e293b;
            display: flex;
            align-items: center;
        }
        
        .form-group label i {
            color: #0ea5e9;
            margin-right: 8px;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #0ea5e9;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.15);
            outline: none;
        }
        
        .form-control::placeholder {
            color: #94a3b8;
        }
        
        .password-input {
            position: relative;
        }
        
        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            padding: 0;
            font-size: 16px;
            transition: color 0.3s ease;
        }
        
        .password-toggle:hover {
            color: #0ea5e9;
        }
        
        .forgot-password {
            display: block;
            text-align: right;
            margin-top: -15px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #0ea5e9;
            text-decoration: none;
            transition: color 0.2s ease;
        }
        
        .forgot-password:hover {
            color: #0284c7;
            text-decoration: underline;
        }
        
        .btn-primary {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #0ea5e9, #14b8a6);
            color: white;
            border: none;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #0284c7, #0f766e);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .text-center {
            text-align: center;
        }
        
        .mt-3 {
            margin-top: 15px;
        }
        
        .text-decoration-none {
            text-decoration: none;
        }
        
        .social-login {
            display: flex;
            gap: 15px;
            margin-top: 25px;
        }
        
        .social-btn {
            flex: 1;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            background: white;
            color: #64748b;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .social-btn:hover {
            background: #f8fafc;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        
        .social-btn i {
            margin-right: 8px;
            font-size: 16px;
        }
        
        .social-btn.google i {
            color: #ea4335;
        }
        
        .social-btn.facebook i {
            color: #1877f2;
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
            color: #94a3b8;
            font-size: 14px;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }
        
        .divider::before {
            margin-right: 15px;
        }
        
        .divider::after {
            margin-left: 15px;
        }
        
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        
        .alert-danger {
            background-color: #fee2e2;
            color: #b91c1c;
        }
        
        .alert i {
            margin-right: 10px;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <div class="login-logo">
                <i class="fas fa-utensils"></i>
            </div>
            <h3>Selamat Datang</h3>
            <p>Masuk untuk memesan makanan favorit Anda</p>
        </div>
        
        <?php if(isset($error_message)): ?>
            <div class="alert alert-danger mx-4 mb-4">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        
        <form action="" method="post">
            <div class="form-group">
                <label for="email">
                    <i class="fas fa-envelope"></i>
                    <span>Email</span>
                </label>
                <input type="email" id="email" name="email" required 
                       placeholder="Masukkan email Anda" class="form-control">
            </div>
            
            <div class="form-group">
                <label for="password">
                    <i class="fas fa-lock"></i>
                    <span>Password</span>
                </label>
                <div class="password-input">
                    <input type="password" id="password" name="password" required 
                           placeholder="Masukkan password Anda" class="form-control">
                    <button type="button" class="password-toggle" onclick="togglePassword()">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            
            <a href="#" class="forgot-password">Lupa password?</a>
            
            <button type="submit" name="login" class="btn-primary">
                Masuk <i class="fas fa-sign-in-alt ms-2"></i>
            </button>
            
            <div class="divider">atau masuk dengan</div>
            
            <div class="social-login">
                <button type="button" class="social-btn google">
                    <i class="fab fa-google"></i> Google
                </button>
                <button type="button" class="social-btn facebook">
                    <i class="fab fa-facebook-f"></i> Facebook
                </button>
            </div>
            
            <div class="text-center mt-3">
                <p>Belum punya akun? <a href="?f=home&m=daftar" class="text-decoration-none">Daftar sekarang</a></p>
            </div>
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const icon = document.querySelector('.password-toggle i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>