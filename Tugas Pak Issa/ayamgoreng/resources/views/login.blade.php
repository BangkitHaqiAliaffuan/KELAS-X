@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Login - Ayam Goreng Lezat</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Poppins', sans-serif;
            }

            body {
                background-color: #f8f8f8;
                color: #333;
            }

            .login-section {
                position: relative;
                min-height: 100vh;
                padding: 80px 5% 100px;
                background: linear-gradient(135deg, #ffebee 0%, #fff8e1 100%);
                overflow: hidden;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .login-section::before {
                content: '';
                position: absolute;
                top: -50px;
                right: -50px;
                width: 200px;
                height: 200px;
                background: url('/api/placeholder/200/200') no-repeat;
                opacity: 0.1;
                transform: rotate(15deg);
                z-index: 0;
            }

            .login-section::after {
                content: '';
                position: absolute;
                bottom: -50px;
                left: -50px;
                width: 200px;
                height: 200px;
                background: url('/api/placeholder/200/200') no-repeat;
                opacity: 0.1;
                transform: rotate(-15deg);
                z-index: 0;
            }

            .login-container {
                width: 100%;
                max-width: 450px;
                background-color: white;
                border-radius: 15px;
                padding: 50px 40px;
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
                position: relative;
                z-index: 1;
                opacity: 0;
                transform: translateY(50px);
                transition: opacity 0.8s ease, transform 0.8s ease;
            }

            .login-container.visible {
                opacity: 1;
                transform: translateY(0);
            }

            .login-container::before {
                content: '';
                position: absolute;
                top: 0;
                right: 0;
                width: 150px;
                height: 150px;
                background: linear-gradient(135deg, #fff3e0, #ffccbc);
                border-radius: 0 0 0 100%;
                z-index: -1;
            }

            .login-container::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                width: 150px;
                height: 150px;
                background: linear-gradient(135deg, #ffccbc, #fff3e0);
                border-radius: 0 100% 0 0;
                z-index: -1;
            }

            .login-logo {
                text-align: center;
                margin-bottom: 30px;
            }

            .login-logo img {
                width: 80px;
                height: 80px;
                object-fit: cover;
                border-radius: 50%;
                padding: 5px;
                background: linear-gradient(135deg, #e65100, #ff9800);
                box-shadow: 0 5px 15px rgba(230, 81, 0, 0.2);
            }

            .login-header {
                text-align: center;
                margin-bottom: 40px;
            }

            .login-title {
                font-size: 2rem;
                color: #e65100;
                margin-bottom: 15px;
                position: relative;
                display: inline-block;
            }

            .login-title::after {
                content: '';
                position: absolute;
                bottom: -10px;
                left: 50%;
                transform: translateX(-50%);
                width: 80px;
                height: 4px;
                background: linear-gradient(to right, #e65100, #ff9800);
                border-radius: 2px;
            }

            .login-subtitle {
                font-size: 1rem;
                color: #666;
            }

            .form-group {
                margin-bottom: 25px;
                position: relative;
            }

            .form-group label {
                display: block;
                margin-bottom: 8px;
                font-weight: 500;
                color: #333;
                transition: all 0.3s ease;
            }

            .form-group input {
                width: 100%;
                padding: 14px 20px;
                padding-left: 45px;
                border: 2px solid #eee;
                border-radius: 8px;
                font-family: 'Poppins', sans-serif;
                font-size: 1rem;
                transition: all 0.3s ease;
                background-color: #f9f9f9;
            }

            .form-group input:focus {
                border-color: #e65100;
                outline: none;
                box-shadow: 0 0 0 3px rgba(230, 81, 0, 0.1);
                background-color: white;
            }

            .form-group input:focus+label {
                color: #e65100;
            }

            .form-icon {
                position: absolute;
                left: 15px;
                top: 48px;
                color: #e65100;
                font-size: 1.2rem;
            }

            .remember-forgot {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 30px;
            }

            .remember-me {
                display: flex;
                align-items: center;
            }

            .remember-me input {
                margin-right: 8px;
                accent-color: #e65100;
            }

            .remember-me label {
                color: #666;
                font-size: 0.9rem;
            }

            .forgot-password {
                color: #e65100;
                text-decoration: none;
                font-size: 0.9rem;
                transition: all 0.3s ease;
            }

            .forgot-password:hover {
                color: #ff9800;
                text-decoration: underline;
            }

            .login-button {
                display: block;
                width: 100%;
                padding: 16px;
                background: linear-gradient(to right, #e65100, #ff9800);
                color: white;
                border: none;
                border-radius: 8px;
                font-weight: 600;
                font-size: 1.1rem;
                cursor: pointer;
                transition: all 0.4s ease;
                position: relative;
                overflow: hidden;
                z-index: 1;
            }

            .login-button::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(to right, #ff9800, #e65100);
                transition: all 0.4s ease;
                z-index: -1;
            }

            .login-button:hover::before {
                left: 0;
            }

            .login-button:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(230, 81, 0, 0.2);
            }

            .register-link {
                text-align: center;
                margin-top: 30px;
            }

            .register-link p {
                color: #666;
                margin-bottom: 10px;
            }

            .register-link a {
                color: #e65100;
                text-decoration: none;
                font-weight: 600;
                transition: all 0.3s ease;
            }

            .register-link a:hover {
                color: #ff9800;
                text-decoration: underline;
            }

            .social-login {
                margin-top: 40px;
                text-align: center;
            }

            .social-login p {
                position: relative;
                margin-bottom: 20px;
                color: #666;
            }

            .social-login p::before,
            .social-login p::after {
                content: '';
                position: absolute;
                top: 50%;
                width: 30%;
                height: 1px;
                background-color: #ddd;
            }

            .social-login p::before {
                left: 0;
            }

            .social-login p::after {
                right: 0;
            }

            .social-icons {
                display: flex;
                justify-content: center;
                gap: 15px;
            }

            .social-icons a {
                display: inline-block;
                height: 45px;
                width: 45px;
                background-color: white;
                border: 1px solid #eee;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #e65100;
                text-decoration: none;
                font-size: 1.1rem;
                transition: all 0.4s ease;
                box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            }

            .social-icons a:hover {
                background-color: #e65100;
                color: white;
                transform: translateY(-5px);
            }

            .floating-chicken {
                position: absolute;
                width: 120px;
                height: 120px;
                background: url('/api/placeholder/120/120') no-repeat;
                z-index: 1;
                animation: float 6s ease-in-out infinite;
            }

            .chicken1 {
                top: 10%;
                left: 5%;
                animation-delay: 0s;
            }

            .chicken2 {
                bottom: 20%;
                right: 5%;
                animation-delay: 2s;
            }

            @keyframes float {
                0% {
                    transform: translateY(0px) rotate(0deg);
                }

                50% {
                    transform: translateY(-20px) rotate(5deg);
                }

                100% {
                    transform: translateY(0px) rotate(0deg);
                }
            }

            .alert {
                padding: 15px;
                margin-bottom: 20px;
                border-radius: 8px;
                display: flex;
                align-items: center;
            }

            .alert-danger {
                background-color: #ffebee;
                color: #c62828;
                border-left: 4px solid #c62828;
            }

            .alert-success {
                background-color: #e8f5e9;
                color: #2e7d32;
                border-left: 4px solid #2e7d32;
            }

            .alert i {
                margin-right: 10px;
                font-size: 1.2rem;
            }

            @media screen and (max-width: 768px) {
                .login-section {
                    padding: 40px 20px;
                }

                .login-container {
                    padding: 40px 30px;
                }

                .floating-chicken {
                    display: none;
                }
            }

            @media screen and (max-width: 480px) {
                .login-container {
                    padding: 30px 20px;
                }

                .login-title {
                    font-size: 1.8rem;
                }

                .form-group input {
                    padding: 12px 15px 12px 40px;
                }

                .remember-forgot {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 15px;
                }
            }
        </style>
    </head>

    <body>

        <section class="login-section">
            <div class="floating-chicken chicken1"></div>
            <div class="floating-chicken chicken2"></div>
            <div class="login-container">
                <div class="login-logo">
                    <img src="{{ asset('gambar/ayamlogo.jpg') }}" alt="Ayam Goreng Lezat Logo">
                </div>
                <div class="login-header">
                    <h1 class="login-title">Login</h1>
                    <p class="login-subtitle">Masuk ke akun Anda untuk memesan ayam goreng lezat</p>
                </div>
                @if (session('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    </div>
                @endif
                @if (session('success'))
                    {{ session()->put('sukseslogin') }}
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif
                <form method="POST" action="{{ url('postlogin') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email</label>
                        <i class="fas fa-envelope form-icon"></i>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            placeholder="Masukkan alamat email Anda" required autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <i class="fas fa-lock form-icon"></i>
                        <input type="password" id="password" name="password" placeholder="Masukkan password Anda" required>
                        @error('password')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="remember-forgot">
                        <div class="remember-me">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember">Ingat Saya</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-password">Lupa Password?</a>
                        @endif
                    </div>
                    <button type="submit" class="login-button">Login <i class="fas fa-sign-in-alt ml-2"></i></button>
                    <div class="register-link">
                        <p>Belum punya akun?</p>
                        <a href="{{ url('register') }}">Daftar Sekarang</a>
                    </div>
                    <div class="social-login">
                        <p>Atau masuk dengan</p>
                        <div class="social-icons">
                            <a href="#"><i class="fab fa-google"></i></a>
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Animation for login container
                setTimeout(() => {
                    document.querySelector('.login-container').classList.add('visible');
                }, 300);
            });
        </script>
    </body>

    </html>
@endsection
