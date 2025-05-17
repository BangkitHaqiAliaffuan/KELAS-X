<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Ayam Goreng JOSS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        :root {
            --primary-color: #ff6b00;
            --primary-dark: #d84315;
            --primary-light: #ffab40;
            --accent-color: #e65100;
            --text-dark: #333333;
            --text-light: #f9f9f9;
            --background-light: #f8f9fa;
            --background-dark: #263238;
            --success-color: #4caf50;
            --warning-color: #ff9800;
            --danger-color: #f44336;
            --info-color: #2196f3;
            --border-color: #e0e0e0;
            --card-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            --hover-transition: all 0.3s ease;
        }

        body {
            background-color: var(--background-light);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }

        .login-logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-icon {
            width: 70px;
            height: 70px;
            background-color: var(--primary-color);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            margin: 0 auto 15px;
        }

        .logo-text {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--text-dark);
        }

        .logo-text span {
            color: var(--primary-color);
        }

        .login-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }

        .login-header {
            padding: 25px;
            text-align: center;
            border-bottom: 1px solid var(--border-color);
        }

        .login-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .login-subtitle {
            color: #888;
            font-size: 0.9rem;
        }

        .login-body {
            padding: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.95rem;
            transition: var(--hover-transition);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(255, 107, 0, 0.1);
        }

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 15px;
            color: #888;
        }

        .input-with-icon {
            padding-left: 45px;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            right: 15px;
            color: #888;
            cursor: pointer;
            background: none;
            border: none;
            font-size: 1rem;
        }

        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .form-check-input {
            margin-right: 10px;
            width: 18px;
            height: 18px;
            accent-color: var(--primary-color);
        }

        .form-check-label {
            font-size: 0.9rem;
        }

        .forgot-password {
            float: right;
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.9rem;
            transition: var(--hover-transition);
        }

        .forgot-password:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .login-button {
            width: 100%;
            padding: 12px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--hover-transition);
        }

        .login-button:hover {
            background-color: var(--primary-dark);
        }

        .login-footer {
            text-align: center;
            padding: 20px 25px;
            border-top: 1px solid var(--border-color);
            font-size: 0.9rem;
        }

        .alert {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .alert-danger {
            background-color: rgba(244, 67, 54, 0.1);
            color: var(--danger-color);
            border: 1px solid rgba(244, 67, 54, 0.2);
        }

        .alert-success {
            background-color: rgba(76, 175, 80, 0.1);
            color: var(--success-color);
            border: 1px solid rgba(76, 175, 80, 0.2);
        }

        @media (max-width: 576px) {
            .login-container {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-logo">
            <div class="logo-icon">
                <i class="fas fa-drumstick-bite"></i>
            </div>
            <div class="logo-text">Ayam Goreng <span>JOSS</span></div>
        </div>

        <div class="login-card">
            <div class="login-header">
                <h1 class="login-title">Admin Login</h1>
                <p class="login-subtitle">Masuk ke dashboard admin</p>
            </div>

            <div class="login-body">
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ url('admin/postlogin') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" id="email" name="email" class="form-input input-with-icon" placeholder="admin@example.com" value="{{ old('email') }}" required>
                        </div>
                        @error('email')
                            <div class="text-danger" style="font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" id="password" name="password" class="form-input input-with-icon" placeholder="••••••••" required>
                            <button type="button" class="password-toggle" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="text-danger" style="font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>



                    <button type="submit" class="login-button">Masuk</button>
                </form>
            </div>

            <div class="login-footer">
                &copy; {{ date('Y') }} Ayam Goreng JOSS. All rights reserved.
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Toggle icon
                const icon = this.querySelector('i');
                if (type === 'text') {
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    </script>
</body>
</html>
