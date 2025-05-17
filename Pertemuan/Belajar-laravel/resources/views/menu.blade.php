<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Ayam Goreng Joss</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --gold: #D4AF37;
            --dark-brown: #3A2718;
            --cream: #FFF8E1;
        }

        body {
            font-family: 'Palatino', serif;
            background-color: var(--cream);
            color: var(--dark-brown);
        }

        .navbar {
            background-color: var(--dark-brown) !important;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 15px 0;
        }

        .navbar-brand {
            color: var(--gold) !important;
            font-size: 28px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .navbar-nav .nav-link {
            color: white !important;
            font-size: 16px;
            margin: 0 10px;
            transition: color 0.3s;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-item.active .nav-link {
            color: var(--gold) !important;
        }

        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('/api/placeholder/1200/400') center/cover;
            color: white;
            padding: 80px 0;
            margin-bottom: 50px;
            text-align: center;
        }

        .hero-title {
            font-size: 48px;
            font-weight: bold;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            margin-bottom: 20px;
        }

        .hero-subtitle {
            font-size: 20px;
            max-width: 700px;
            margin: 0 auto;
        }

        .menu-container {
            padding: 50px 0;
        }

        .menu-title {
            color: var(--dark-brown);
            font-size: 36px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 50px;
            position: relative;
        }

        .menu-title:after {
            content: "";
            display: block;
            width: 100px;
            height: 3px;
            background-color: var(--gold);
            margin: 15px auto;
        }

        .menu-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .menu-card:hover {
            transform: translateY(-10px);
        }

        .menu-image {
            height: 200px;
            background-position: center;
            background-size: cover;
        }

        .menu-content {
            padding: 20px;
        }

        .menu-item {
            font-size: 22px;
            font-weight: bold;
            color: var(--dark-brown);
            margin-bottom: 10px;
        }

        .menu-description {
            color: #666;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .menu-price {
            color: var(--gold);
            font-size: 20px;
            font-weight: bold;
        }

        .order-btn {
            background-color: var(--dark-brown);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            float: right;
            transition: background-color 0.3s;
        }

        .order-btn:hover {
            background-color: var(--gold);
            color: var(--dark-brown);
        }

        .footer {
            background-color: var(--dark-brown);
            color: white;
            padding: 40px 0 20px;
            margin-top: 50px;
        }

        .footer-title {
            color: var(--gold);
            font-size: 20px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .footer-contact {
            list-style: none;
            padding: 0;
        }

        .footer-contact li {
            margin-bottom: 10px;
        }

        .footer-contact i {
            color: var(--gold);
            margin-right: 10px;
        }

        .social-icons {
            list-style: none;
            padding: 0;
            display: flex;
        }

        .social-icons li {
            margin-right: 15px;
        }

        .social-icons a {
            color: white;
            font-size: 20px;
            transition: color 0.3s;
        }

        .social-icons a:hover {
            color: var(--gold);
        }

        .copyright {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Ayam Goreng Joss</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="/menu"><i class="fas fa-utensils"></i> Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/order"><i class="fas fa-shopping-cart"></i> Order</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/kontak"><i class="fas fa-envelope"></i> Kontak</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/chat"><i class="fas fa-comments"></i> Chat</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <h1 class="hero-title">Menu Eksklusif Kami</h1>
            <p class="hero-subtitle">Nikmati kelezatan ayam goreng premium dengan bumbu pilihan dan resep rahasia turun-temurun</p>
        </div>
    </div>

    <!-- Menu Section -->
    <div class="container menu-container">
        <h2 class="menu-title">Menu Signature</h2>

        <div class="row">
            <!-- Menu Item 1 -->
            <div class="col-md-4">
                <div class="menu-card">
                    <div class="menu-image" style="background-image: url('/api/placeholder/400/200')"></div>
                    <div class="menu-content">
                        <h3 class="menu-item">Ayam Goreng Original</h3>
                        <p class="menu-description">Ayam goreng renyah dengan bumbu tradisional yang kaya rempah. Digoreng dengan teknik khusus untuk mendapatkan tekstur sempurna.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="menu-price">Rp 25.000</span>
                            <button class="order-btn">Pesan</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menu Item 2 -->
            <div class="col-md-4">
                <div class="menu-card">
                    <div class="menu-image" style="background-image: url('{{ asset('images/ayam1.jpg') }}')"></div>
                    <div class="menu-content">
                        <h3 class="menu-item">Ayam Goreng Pedas</h3>
                        <p class="menu-description">Ayam goreng dengan balutan bumbu pedas yang membara. Dibuat dari cabai pilihan yang akan menggugah selera para pecinta pedas.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="menu-price">Rp 28.000</span>
                            <button class="order-btn">Pesan</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menu Item 3 -->
            <div class="col-md-4">
                <div class="menu-card">
                    <div class="menu-image" style="background-image: url('{{ asset('images/ayam1.jpg') }}')"></div>
                    <div class="menu-content">
                        <h3 class="menu-item">Ayam Goreng Spesial</h3>
                        <p class="menu-description">Menu andalan dengan bumbu rahasia chef. Dimasak dengan teknik khusus dan disajikan dengan topping premium untuk pengalaman kuliner istimewa.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="menu-price">Rp 30.000</span>
                            <button class="order-btn">Pesan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h4 class="footer-title">Ayam Goreng Joss</h4>
                    <p>Pengalaman kuliner ayam goreng premium dengan cita rasa autentik Indonesia yang mewah dan berkualitas.</p>
                </div>

                <div class="col-md-4">
                    <h4 class="footer-title">Kontak Kami</h4>
                    <ul class="footer-contact">
                        <li><i class="fas fa-map-marker-alt"></i> Jl. Kuliner Raya No. 123, Jakarta</li>
                        <li><i class="fas fa-phone"></i> +62 812 3456 7890</li>
                        <li><i class="fas fa-envelope"></i> info@ayamgorengjoss.com</li>
                    </ul>
                </div>

                <div class="col-md-4">
                    <h4 class="footer-title">Jam Operasional</h4>
                    <p>Senin - Jumat: 10:00 - 22:00</p>
                    <p>Sabtu - Minggu: 08:00 - 23:00</p>

                    <h4 class="footer-title mt-4">Ikuti Kami</h4>
                    <ul class="social-icons">
                        <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                        <li><a href="#"><i class="fab fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fab fa-tiktok"></i></a></li>
                    </ul>
                </div>
            </div>

            <div class="copyright">
                <p>&copy; 2025 Ayam Goreng Joss. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
