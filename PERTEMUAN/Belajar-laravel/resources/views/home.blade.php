<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ayam Goreng Joss - Home</title>
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

        .hero {
            height: 80vh;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('/api/placeholder/1920/1080') center/cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            position: relative;
        }

        .hero-content {
            max-width: 800px;
            padding: 0 20px;
            z-index: 1;
        }

        .hero-title {
            font-size: 54px;
            font-weight: bold;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .hero-subtitle {
            font-size: 22px;
            margin-bottom: 30px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }

        .btn-primary {
            background-color: var(--gold);
            border: none;
            color: var(--dark-brown);
            padding: 12px 30px;
            font-size: 18px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .btn-primary:hover {
            background-color: var(--gold);
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
        }

        .section {
            padding: 80px 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
            position: relative;
            font-size: 36px;
            font-weight: bold;
        }

        .section-title:after {
            content: "";
            display: block;
            width: 80px;
            height: 3px;
            background-color: var(--gold);
            margin: 15px auto 0;
        }

        .feature-box {
            text-align: center;
            padding: 30px 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            height: 100%;
        }

        .feature-box:hover {
            transform: translateY(-10px);
        }

        .feature-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 80px;
            height: 80px;
            background-color: var(--cream);
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .feature-icon i {
            font-size: 36px;
            color: var(--dark-brown);
        }

        .feature-title {
            font-size: 22px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .testimonial {
            background-color: var(--dark-brown);
            color: white;
            padding: 100px 0;
            position: relative;
        }

        .testimonial:before {
            content: """;
            position: absolute;
            top: 20px;
            left: 50px;
            font-size: 200px;
            color: rgba(255, 255, 255, 0.1);
            font-family: serif;
        }

        .testimonial-box {
            text-align: center;
            max-width: 700px;
            margin: 0 auto;
        }

        .testimonial-text {
            font-size: 24px;
            line-height: 1.6;
            margin-bottom: 30px;
            font-style: italic;
        }

        .testimonial-author {
            font-size: 18px;
            color: var(--gold);
            display: block;
            margin-top: 20px;
        }

        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .gallery-img {
            transition: transform 0.5s;
            height: 250px;
            width: 100%;
            object-fit: cover;
        }

        .gallery-item:hover .gallery-img {
            transform: scale(1.1);
        }

        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(58, 39, 24, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }

        .gallery-caption {
            color: white;
            font-size: 20px;
            text-align: center;
            padding: 0 20px;
        }

        .cta-section {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('/api/placeholder/1920/600') center/cover;
            color: white;
            padding: 80px 0;
            text-align: center;
        }

        .cta-title {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .cta-text {
            font-size: 18px;
            margin-bottom: 30px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .footer {
            background-color: var(--dark-brown);
            color: white;
            padding: 40px 0 20px;
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
                    <li class="nav-item active">
                        <a class="nav-link" href="/"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item">
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
    <section class="hero">
        <div class="hero-content">
            <h1 class="hero-title">Selamat Datang di Ayam Goreng Joss</h1>
            <p class="hero-subtitle">Pengalaman kuliner autentik dengan cita rasa premium ayam goreng terbaik di kota ini</p>
            <a href="/menu" class="btn btn-primary">Lihat Menu Kami</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Kenapa Memilih Kami</h2>

            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <h3 class="feature-title">Kualitas Premium</h3>
                        <p>Kami hanya menggunakan bahan berkualitas terbaik untuk menciptakan hidangan yang sempurna bagi Anda.</p>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <h3 class="feature-title">Resep Rahasia</h3>
                        <p>Bumbu rahasia turun-temurun yang memberikan cita rasa unik dan tak tertandingi.</p>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <h3 class="feature-title">Pengiriman Cepat</h3>
                        <p>Nikmati hidangan kami langsung di rumah Anda dengan layanan pengiriman cepat dan handal.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section class="testimonial">
        <div class="container">
            <div class="testimonial-box">
                <p class="testimonial-text">"Ayam Goreng Joss menghadirkan perpaduan sempurna antara renyah di luar dan juicy di dalam. Bumbu yang meresap sampai ke tulang membuat setiap gigitan terasa istimewa."</p>
                <span class="testimonial-author">- Budi Santoso, Food Blogger</span>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Galeri Hidangan</h2>

            <div class="row">
                <div class="col-md-4">
                    <div class="gallery-item">
                        <img src="/api/placeholder/400/250" alt="Ayam Goreng" class="gallery-img">
                        <div class="gallery-overlay">
                            <div class="gallery-caption">Ayam Goreng Original</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="gallery-item">
                        <img src="/api/placeholder/400/250" alt="Ayam Goreng Pedas" class="gallery-img">
                        <div class="gallery-overlay">
                            <div class="gallery-caption">Ayam Goreng Pedas</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="gallery-item">
                        <img src="/api/placeholder/400/250" alt="Ayam Goreng Spesial" class="gallery-img">
                        <div class="gallery-overlay">
                            <div class="gallery-caption">Ayam Goreng Spesial</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2 class="cta-title">Pesan Sekarang</h2>
            <p class="cta-text">Nikmati pengalaman kuliner terbaik kami langsung di rumah Anda. Pesan sekarang dan dapatkan diskon 10% untuk pesanan pertama Anda.</p>
            <a href="/order" class="btn btn-primary">Order Online</a>
        </div>
    </section>

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
