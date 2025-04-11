<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP - Ayam Goreng Lezat</title>
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
            line-height: 1.6;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background: linear-gradient(135deg, #e65100, #ff9800);
            padding: 30px;
            text-align: center;
            color: white;
        }

        .email-logo {
            display: inline-block;
            width: 80px;
            height: 80px;
            background-color: white;
            border-radius: 50%;
            padding: 5px;
            margin-bottom: 15px;
        }

        .email-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .email-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .email-body {
            padding: 40px;
            background-color: white;
            position: relative;
        }

        .email-body::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 150px;
            height: 150px;
            background: linear-gradient(135deg, #fff3e0, #ffccbc);
            border-radius: 0 0 0 100%;
            z-index: 0;
            opacity: 0.3;
        }

        .email-body::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 150px;
            height: 150px;
            background: linear-gradient(135deg, #ffccbc, #fff3e0);
            border-radius: 0 100% 0 0;
            z-index: 0;
            opacity: 0.3;
        }

        .greeting {
            font-size: 20px;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        .message {
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
        }

        .otp-container {
            margin: 30px 0;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .otp-code {
            display: inline-block;
            padding: 15px 40px;
            background-color: #f1f1f1;
            border-radius: 8px;
            font-size: 32px;
            font-weight: 700;
            letter-spacing: 5px;
            color: #e65100;
            border: 2px dashed #e65100;
        }

        .expire-text {
            margin-top: 15px;
            color: #777;
            font-size: 14px;
        }

        .instructions {
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
        }

        .help-text {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #777;
            font-size: 14px;
            position: relative;
            z-index: 1;
        }

        .email-footer {
            background-color: #f5f5f5;
            padding: 20px;
            text-align: center;
            font-size: 13px;
            color: #666;
        }

        .social-icons {
            margin: 15px 0;
        }

        .social-icons a {
            display: inline-block;
            margin: 0 10px;
            color: #e65100;
            text-decoration: none;
        }

        .footer-links a {
            color: #e65100;
            text-decoration: none;
            margin: 0 10px;
        }

        .footer-links a:hover,
        .social-icons a:hover {
            text-decoration: underline;
        }

        @media screen and (max-width: 600px) {
            .email-body {
                padding: 30px 20px;
            }

            .otp-code {
                padding: 12px 30px;
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <div class="email-logo">
                <img src="{{ $message->embed(public_path('gambar/ayamlogo.jpg')) }}" alt="Ayam Goreng Lezat Logo">
            </div>
            <h1 class="email-title">Kode OTP Anda</h1>
            <p>Verifikasi untuk melanjutkan</p>
        </div>

        <div class="email-body">
            <h2 class="greeting">Halo {{ $user->name }},</h2>

            <div class="message">
                <p>Kami menerima permintaan untuk mengakses akun Ayam Goreng Lezat Anda. Gunakan kode One-Time Password (OTP) di bawah ini untuk melanjutkan.</p>
            </div>

            <div class="otp-container">
                <div class="otp-code">{{ $otp }}</div>
                <p class="expire-text">Kode ini akan kedaluwarsa dalam 15 menit.</p>
            </div>

            <div class="instructions">
                <p>Silakan masukkan kode ini di halaman verifikasi untuk melanjutkan proses.</p>
                <p>Jika Anda tidak melakukan permintaan ini, silakan abaikan email ini atau hubungi dukungan pelanggan kami.</p>
            </div>

            <div class="help-text">
                <p>Jika Anda memiliki pertanyaan atau kesulitan, silakan hubungi tim dukungan kami di <a href="mailto:support@ayamgorenglezat.com">support@ayamgorenglezat.com</a> atau hubungi nomor telepon kami di +62 123-456-7890.</p>
            </div>
        </div>

        <div class="email-footer">
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>

            <div class="footer-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Contact Us</a>
            </div>

            <p>&copy; {{ date('Y') }} Ayam Goreng Lezat. Semua hak dilindungi.</p>
            <p>Jl. Ayam Goreng No. 123, Jakarta Selatan, Indonesia</p>
        </div>
    </div>
</body>
</html>
