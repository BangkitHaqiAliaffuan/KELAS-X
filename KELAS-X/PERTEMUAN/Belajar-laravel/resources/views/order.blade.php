<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order - Ayam Goreng Joss</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --gold: #D4AF37;
            --dark-brown: #3A2718;
            --cream: #FFF8E1;
            --light-gold: #F8EFC9;
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

        .page-header {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('/api/placeholder/1920/600') center/cover;
            color: white;
            padding: 60px 0;
            text-align: center;
            margin-bottom: 50px;
        }

        .page-title {
            font-size: 42px;
            font-weight: bold;
            margin-bottom: 15px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .page-subtitle {
            font-size: 18px;
            max-width: 700px;
            margin: 0 auto;
        }

        .section-title {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
            font-size: 32px;
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

        .order-container {
            padding: 40px 0 80px;
        }

        .menu-list {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 30px;
            margin-bottom: 30px;
        }

        .menu-category {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--light-gold);
            color: var(--dark-brown);
        }

        .menu-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .menu-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .menu-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 20px;
            border: 2px solid var(--light-gold);
        }

        .menu-content {
            flex: 1;
        }

        .menu-name {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 5px;
        }

        .menu-description {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        .menu-price {
            font-weight: bold;
            color: var(--dark-brown);
        }

        .quantity-control {
            display: flex;
            align-items: center;
        }

        .qty-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: var(--dark-brown);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .qty-btn:hover {
            background-color: var(--gold);
        }

        .qty-input {
            width: 40px;
            height: 30px;
            text-align: center;
            border: 1px solid #ddd;
            margin: 0 10px;
            font-weight: bold;
        }

        .order-summary {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 30px;
            position: sticky;
            top: 30px;
        }

        .summary-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--light-gold);
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .summary-item-name {
            font-weight: 500;
        }

        .summary-item-price {
            font-weight: bold;
        }

        .summary-divider {
            border-top: 1px dashed #ddd;
            margin: 15px 0;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
        }

        .summary-total-price {
            color: var(--dark-brown);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
            font-family: 'Palatino', serif;
        }

        .form-control:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
        }

        textarea.form-control {
            min-height: 100px;
        }

        .payment-method {
            margin-top: 30px;
        }

        .payment-options {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 15px;
        }

        .payment-option {
            flex: 1;
            min-width: 150px;
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .payment-option:hover {
            border-color: var(--gold);
        }

        .payment-option.active {
            border-color: var(--gold);
            background-color: var(--light-gold);
        }

        .payment-icon {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .submit-order {
            background-color: var(--dark-brown);
            border: none;
            color: white;
            padding: 15px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 5px;
            width: 100%;
            margin-top: 30px;
            transition: background-color 0.3s;
        }

        .submit-order:hover {
            background-color: var(--gold);
            color: var(--dark-brown);
        }

        .promo-input {
            display: flex;
        }

        .promo-input .form-control {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .promo-btn {
            background-color: var(--dark-brown);
            color: white;
            border: none;
            padding: 0 20px;
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
            transition: background-color 0.3s;
        }

        .promo-btn:hover {
            background-color: var(--gold);
            color: var(--dark-brown);
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
                    <li class="nav-item">
                        <a class="nav-link" href="/"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/menu"><i class="fas fa-utensils"></i> Menu</a>
                    </li>
                    <li class="nav-item active">
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

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <h1 class="page-title">Pesan Sekarang</h1>
            <p class="page-subtitle">Nikmati kelezatan Ayam Goreng Joss kapan saja dan di mana saja</p>
        </div>
    </div>

    <!-- Order Section -->
    <div class="container order-container">
        <div class="row">
            <!-- Menu Items -->
            <div class="col-lg-8">
                <div class="menu-list">
                    <h3 class="menu-category">Menu Favorit</h3>

                    <!-- Menu Item 1 -->
                    <div class="menu-item">
                        <img src="/api/placeholder/80/80" alt="Ayam Goreng Original" class="menu-img">
                        <div class="menu-content">
                            <h4 class="menu-name">Ayam Goreng Original</h4>
                            <p class="menu-description">Ayam goreng renyah dengan bumbu tradisional yang kaya rempah.</p>
                            <div class="menu-price">Rp 25.000</div>
                        </div>
                        <div class="quantity-control">
                            <button class="qty-btn">-</button>
                            <input type="text" class="qty-input" value="0">
                            <button class="qty-btn">+</button>
                        </div>
                    </div>

                    <!-- Menu Item 2 -->
                    <div class="menu-item">
                        <img src="/api/placeholder/80/80" alt="Ayam Goreng Pedas" class="menu-img">
                        <div class="menu-content">
                            <h4 class="menu-name">Ayam Goreng Pedas</h4>
                            <p class="menu-description">Ayam goreng dengan balutan bumbu pedas yang membara.</p>
                            <div class="menu-price">Rp 28.000</div>
                        </div>
                        <div class="quantity-control">
                            <button class="qty-btn">-</button>
                            <input type="text" class="qty-input" value="0">
                            <button class="qty-btn">+</button>
                        </div>
                    </div>

                    <!-- Menu Item 3 -->
                    <div class="menu-item">
                        <img src="/api/placeholder/80/80" alt="Ayam Goreng Spesial" class="menu-img">
                        <div class="menu-content">
                            <h4 class="menu-name">Ayam Goreng Spesial</h4>
                            <p class="menu-description">Menu andalan dengan bumbu rahasia chef dan topping premium.</p>
                            <div class="menu-price">Rp 30.000</div>
                        </div>
                        <div class="quantity-control">
                            <button class="qty-btn">-</button>
                            <input type="text" class="qty-input" value="0">
                            <button class="qty-btn">+</button>
                        </div>
                    </div>
                </div>

                <div class="menu-list">
                    <h3 class="menu-category">Side Dishes</h3>

                    <!-- Side Dish 1 -->
                    <div class="menu-item">
                        <img src="/api/placeholder/80/80" alt="Nasi Putih" class="menu-img">
                        <div class="menu-content">
                            <h4 class="menu-name">Nasi Putih</h4>
                            <p class="menu-description">Nasi putih pulen dan hangat.</p>
                            <div class="menu-price">Rp 8.000</div>
                        </div>
                        <div class="quantity-control">
                            <button class="qty-btn">-</button>
                            <input type="text" class="qty-input" value="0">
                            <button class="qty-btn">+</button>
                        </div>
                    </div>

                    <!-- Side Dish 2 -->
                    <div class="menu-item">
                        <img src="/api/placeholder/80/80" alt="Sambal Spesial" class="menu-img">
                        <div class="menu-content">
                            <h4 class="menu-name">Sambal Spesial</h4>
                            <p class="menu-description">Sambal khas rumahan dengan resep spesial.</p>
                            <div class="menu-price">Rp 5.000</div>
                        </div>
                        <div class="quantity-control">
                            <button class="qty-btn">-</button>
                            <input type="text" class="qty-input" value="0">
                            <button class="qty-btn">+</button>
                        </div>
                    </div>
                </div>

                <div class="menu-list">
                    <h3 class="menu-category">Minuman</h3>

                    <!-- Drink 1 -->
                    <div class="menu-item">
                        <img src="/api/placeholder/80/80" alt="Es Teh Manis" class="menu-img">
                        <div class="menu-content">
                            <h4 class="menu-name">Es Teh Manis</h4>
                            <p class="menu-description">Teh manis segar dengan es batu.</p>
                            <div class="menu-price">Rp 7.000</div>
                        </div>
                        <div class="quantity-control">
                            <button class="qty-btn">-</button>
                            <input type="text" class="qty-input" value="0">
                            <button class="qty-btn">+</button>
                        </div>
                    </div>

                    <!-- Drink 2 -->
                    <div class="menu-item">
                        <img src="/api/placeholder/80/80" alt="Es Jeruk" class="menu-img">
                        <div class="menu-content">
                            <h4 class="menu-name">Es Jeruk</h4>
                            <p class="menu-description">Jeruk segar dengan es batu.</p>
                            <div class="menu-price">Rp 8.000</div>
                        </div>
                        <div class="quantity-control">
                            <button class="qty-btn">-</button>
                            <input type="text" class="qty-input" value="0">
                            <button class="qty-btn">+</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="order-summary">
                    <h3 class="summary-title">Ringkasan Pesanan</h3>

                    <div class="summary-item">
                        <span class="summary-item-name">Ayam Goreng Original × 2</span>
                        <span class="summary-item-price">Rp 50.000</span>
                    </div>

                    <div class="summary-item">
                        <span class="summary-item-name">Nasi Putih × 2</span>
                        <span class="summary-item-price">Rp 16.000</span>
                    </div>

                    <div class="summary-item">
                        <span class="summary-item-name">Es Teh Manis × 2</span>
                        <span class="summary-item-price">Rp 14.000</span>
                    </div>

                    <div class="summary-divider"></div>

                    <div class="summary-item">
                        <span class="summary-item-name">Subtotal</span>
                        <span class="summary-item-price">Rp 80.000</span>
                    </div>

                    <div class="summary-item">
                        <span class="summary-item-name">Biaya Pengiriman</span>
                        <span class="summary-item-price">Rp 10.000</span>
                    </div>

                    <div class="form-group mt-4">
                        <label class="form-label">Kode Promo</label>
                        <div class="promo-input">
                            <input type="text" class="form-control" placeholder="Masukkan kode promo">
                            <button type="button" class="promo-btn">Apply</button>
                        </div>
                    </div>

                    <div class="summary-divider"></div>

                    <div class="summary-total">
                        <span>Total</span>
                        <span class="summary-total-price">Rp 90.000</span>
                    </div>

                    <form>
                        <div class="form-group mt-4">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" placeholder="Masukkan nama lengkap Anda">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" placeholder="Masukkan nomor telepon Anda">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Alamat Pengiriman</label>
                            <textarea class="form-control" placeholder="Masukkan alamat lengkap Anda"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Catatan Tambahan</label>
                            <textarea class="form-control" placeholder="Misalnya: tidak pedas, tidak pakai bawang, dll."></textarea>
                        </div>

                        <div class="payment-method">
                            <label class="form-label">Metode Pembayaran</label>
                            <div class="payment-options">
                                <div class="payment-option active">
                                    <div class="payment-icon">
                                        <i class="fas fa-money-bill-wave"></i>
                                    </div>
                                    <div>Tunai</div>
                                </div>

                                <div class="payment-option">
                                    <div class="payment-icon">
                                        <i class="fas fa-credit-card"></i>
                                    </div>
                                    <div>Kartu Kredit</div>
                                </div>

                                <div class="payment-option">
                                    <div class="payment-icon">
                                        <i class="fas fa-wallet"></i>
                                    </div>
                                    <div>E-Wallet</div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="submit-order">Pesan Sekarang</button>
                    </form>
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
