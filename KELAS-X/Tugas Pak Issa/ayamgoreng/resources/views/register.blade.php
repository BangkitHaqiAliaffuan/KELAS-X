@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar - Ayam Goreng Lezat</title>
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

        .register-section {
            position: relative;
            min-height: 100vh;
            padding: 60px 5% 80px;
            background: linear-gradient(135deg, #ffebee 0%, #fff8e1 100%);
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-section::before {
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

        .register-section::after {
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

        .register-container {
            width: 100%;
            max-width: 600px;
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

        .register-container.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .register-container::before {
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

        .register-container::after {
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

        .register-logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .register-logo img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
            padding: 5px;
            background: linear-gradient(135deg, #e65100, #ff9800);
            box-shadow: 0 5px 15px rgba(230, 81, 0, 0.2);
        }

        .register-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .register-title {
            font-size: 2rem;
            color: #e65100;
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }

        .register-title::after {
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

        .register-subtitle {
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

        .form-group input, .form-group textarea {
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

        .form-group textarea {
            height: 120px;
            resize: vertical;
        }

        .form-group input:focus, .form-group textarea:focus {
            border-color: #e65100;
            outline: none;
            box-shadow: 0 0 0 3px rgba(230, 81, 0, 0.1);
            background-color: white;
        }

        .form-group input:focus + label, .form-group textarea:focus + label {
            color: #e65100;
        }

        .form-icon {
            position: absolute;
            left: 15px;
            top: 48px;
            color: #e65100;
            font-size: 1.2rem;
        }

        .form-section-title {
            font-size: 1.2rem;
            color: #e65100;
            margin: 30px 0 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #ffe0b2;
        }

        .terms-checkbox {
            display: flex;
            align-items: flex-start;
            margin-bottom: 30px;
        }

        .terms-checkbox input {
            margin-right: 10px;
            margin-top: 5px;
            accent-color: #e65100;
        }

        .terms-checkbox label {
            color: #666;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .terms-checkbox a {
            color: #e65100;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .terms-checkbox a:hover {
            color: #ff9800;
            text-decoration: underline;
        }

        .register-button {
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

        .register-button::before {
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

        .register-button:hover::before {
            left: 0;
        }

        .register-button:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(230, 81, 0, 0.2);
        }

        .login-link {
            text-align: center;
            margin-top: 30px;
        }

        .login-link p {
            color: #666;
            margin-bottom: 10px;
        }

        .login-link a {
            color: #e65100;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .login-link a:hover {
            color: #ff9800;
            text-decoration: underline;
        }

        .social-register {
            margin-top: 40px;
            text-align: center;
        }

        .social-register p {
            position: relative;
            margin-bottom: 20px;
            color: #666;
        }

        .social-register p::before,
        .social-register p::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 30%;
            height: 1px;
            background-color: #ddd;
        }

        .social-register p::before {
            left: 0;
        }

        .social-register p::after {
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

        .chicken3 {
            top: 40%;
            right: 10%;
            animation-delay: 4s;
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

        .invalid-feedback {
            display: block;
            margin-top: 5px;
            color: #c62828;
            font-size: 0.8rem;
        }

        .password-strength {
            margin-top: 8px;
            height: 5px;
            border-radius: 3px;
            background-color: #eee;
            overflow: hidden;
        }

        .password-meter {
            height: 100%;
            width: 0;
            transition: width 0.3s ease, background-color 0.3s ease;
        }

        .password-text {
            font-size: 0.8rem;
            margin-top: 5px;
            color: #666;
        }

        @media screen and (max-width: 768px) {
            .register-section {
                padding: 40px 20px;
            }

            .register-container {
                padding: 40px 30px;
            }

            .floating-chicken {
                display: none;
            }
        }

        @media screen and (max-width: 480px) {
            .register-container {
                padding: 30px 20px;
            }

            .register-title {
                font-size: 1.8rem;
            }

            .form-group input, .form-group textarea {
                padding: 12px 15px 12px 40px;
            }
        }
    </style>
</head>
<body>

    <section class="register-section">
        <div class="floating-chicken chicken1"></div>
        <div class="floating-chicken chicken2"></div>
        <div class="floating-chicken chicken3"></div>
        <div class="register-container">
            <div class="register-logo">
                <img src="{{ asset('gambar/ayamlogo.jpg') }}" alt="Ayam Goreng Lezat Logo">
            </div>
            <div class="register-header">
                <h1 class="register-title">Daftar</h1>
                <p class="register-subtitle">Buat akun untuk menikmati ayam goreng terlezat</p>
            </div>
            @if (session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            <form method="POST" action="{{ url('postregister') }}">
                @csrf
                <h3 class="form-section-title">Informasi Akun</h3>
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <i class="fas fa-user form-icon"></i>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <i class="fas fa-envelope form-icon"></i>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Alamat email Anda" required>
                    @error('email')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <i class="fas fa-lock form-icon"></i>
                    <input type="password" id="password" name="password" placeholder="Buat password Anda" required>
                    <div class="password-strength"><div class="password-meter"></div></div>
                    <div class="password-text">Gunakan minimal 8 karakter dengan huruf, angka, dan simbol</div>
                    @error('password')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password-confirm">Konfirmasi Password</label>
                    <i class="fas fa-lock form-icon"></i>
                    <input type="password" id="password-confirm" name="password_confirmation" placeholder="Masukkan password Anda kembali" required>
                </div>

                <h3 class="form-section-title">Alamat Pengiriman</h3>
                <div class="form-group">
                    <label for="alamat">Alamat Lengkap</label>
                    <i class="fas fa-map-marker-alt form-icon"></i>
                    <textarea id="alamat" name="alamat" placeholder="Masukkan alamat lengkap Anda" required>{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="terms-checkbox">
                    <input type="checkbox" name="terms" id="terms" required>
                    <label for="terms">Saya menyetujui <a href="#">Syarat dan Ketentuan</a> serta <a href="#">Kebijakan Privasi</a></label>
                </div>
                <button type="submit" class="register-button">Daftar Sekarang <i class="fas fa-user-plus ml-2"></i></button>
                <div class="login-link">
                    <p>Sudah punya akun?</p>
                    <a href="{{ url('login') }}">Masuk</a>
                </div>
                <div class="social-register">
                    <p>Atau daftar dengan</p>
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
            // Animation for register container
            setTimeout(() => {
                document.querySelector('.register-container').classList.add('visible');
            }, 300);

            // Password strength meter
            const passwordInput = document.getElementById('password');
            const passwordMeter = document.querySelector('.password-meter');
            const passwordText = document.querySelector('.password-text');

            passwordInput.addEventListener('input', () => {
                const value = passwordInput.value;
                let strength = 0;

                if (value.length >= 8) strength += 25;
                if (value.match(/[a-z]/)) strength += 25;
                if (value.match(/[A-Z]/)) strength += 25;
                if (value.match(/[0-9]/)) strength += 25;
                if (value.match(/[^a-zA-Z0-9]/)) strength += 25;

                // Cap at 100%
                strength = Math.min(100, strength);

                passwordMeter.style.width = `${strength}%`;

                if (strength < 25) {
                    passwordMeter.style.backgroundColor = '#ff5252';
                    passwordText.textContent = 'Password sangat lemah';
                } else if (strength < 50) {
                    passwordMeter.style.backgroundColor = '#ff9800';
                    passwordText.textContent = 'Password lemah';
                } else if (strength < 75) {
                    passwordMeter.style.backgroundColor = '#ffeb3b';
                    passwordText.textContent = 'Password cukup kuat';
                } else {
                    passwordMeter.style.backgroundColor = '#4caf50';
                    passwordText.textContent = 'Password sangat kuat';
                }
            });
        });
    </script>
</body>
</html>
@endsection
