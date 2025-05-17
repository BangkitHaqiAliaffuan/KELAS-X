<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Gramedia - Banner</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .banner-container {
            width: 90%;
            margin: 30px auto;
            max-width: 1400px;
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            height: 400px;
        }

        .banner-slide {
            display: flex;
            transition: transform 0.5s ease-in-out;
            height: 100%;
        }

        .banner-item {
            min-width: 100%;
            box-sizing: border-box;
        }

        .banner-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 20px;
        }

        .banner-controls button {
            background-color: rgba(255, 255, 255, 0.9);
            border: none;
            color: #333;
            padding: 15px;
            cursor: pointer;
            border-radius: 50%;
            transition: all 0.3s ease;
            margin: 0 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .banner-controls button:hover {
            background-color: #007bff;
            color: white;
            transform: scale(1.1);
        }

        .categories {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin: 40px auto;
            max-width: 1400px;
            padding: 0 20px;
            overflow-x: auto; /* Enable horizontal scroll if needed */
            scrollbar-width: none; /* Hide scrollbar for Firefox */
            -ms-overflow-style: none; /* Hide scrollbar for IE and Edge */
        }
        
        /* Hide scrollbar for Chrome, Safari and Opera */
        .categories::-webkit-scrollbar {
            display: none;
        }

        .category {
            flex: 1;
            min-width: 130px; /* Ensure minimum width */
            background: linear-gradient(145deg, #ffffff, #f5f5f5);
            padding: 15px 10px;
            border-radius: 15px;
            box-shadow: 5px 5px 15px #d1d9e6, -5px -5px 15px #ffffff;
            transition: all 0.3s ease;
            text-decoration: none;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .category i {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #007bff;
            transition: all 0.3s ease;
        }

        .category p {
            margin: 5px 0 0;
            font-weight: 500;
            font-size: 0.8rem;
            text-align: center;
            line-height: 1.2;
        }

        /* Update media query for better mobile responsiveness */
        @media (max-width: 768px) {
            .categories {
                gap: 10px;
                padding: 0 15px;
            }
            
            .category {
                min-width: 100px;
                padding: 10px 5px;
            }
            
            .category i {
                font-size: 1.2rem;
            }
            
            .category p {
                font-size: 0.7rem;
            }
        }

        
        .category:hover {
            transform: translateY(-10px);
            box-shadow: 8px 8px 20px #d1d9e6, -8px -8px 20px #ffffff;
            background: linear-gradient(145deg, #007bff, #0056b3);
            color: white;
        }

        .category:hover i {
            color: white;
            transform: scale(1.2);
        }
        .description-section {
            max-width: 1400px;
            margin: 60px auto;
            padding: 40px 20px;
            text-align: center;
            background: linear-gradient(145deg, #ffffff, #f8f9fa);
            border-radius: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
        }
        
        .description-section h2 {
            color: #1a1a1a;
            font-size: 2.5rem;
            margin-bottom: 25px;
            font-weight: 700;
            background: linear-gradient(45deg, #007bff, #00bcd4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .description-section > p {
            color: #666;
            font-size: 1.2rem;
            line-height: 1.8;
            max-width: 800px;
            margin: 0 auto 40px;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .feature {
            background: white;
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .feature::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #007bff, #00bcd4);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .feature:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        }

        .feature:hover::before {
            transform: scaleX(1);
        }

        .feature h3 {
            color: #007bff;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }

        .feature p {
            color: #666;
            line-height: 1.6;
            margin: 0;
            font-size: 1rem;
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

        .feature {
            animation: fadeInUp 0.6s ease forwards;
        }

        .feature:nth-child(2) {
            animation-delay: 0.2s;
        }

        .feature:nth-child(3) {
            animation-delay: 0.4s;
        }

        @media (max-width: 768px) {
            .banner-container {
                height: 300px;
            }

            .categories {
                grid-template-columns: repeat(2, 1fr);
            }

            .description-section h2 {
                font-size: 2rem;
            }

            .feature {
                padding: 25px;
            }
        }
    </style>
</head>
<body>
    <div class="banner-container">
        <div class="banner-slide" id="bannerSlide">
            <div class="banner-item">
                <img alt="Banner 1" src="assetweb/banner1.jpg"/>
            </div>
            <div class="banner-item">
                <img alt="Banner 2" src="assetweb/banner2.jpg"/>
            </div>
            <div class="banner-item">
                <img alt="Banner 3" src="assetweb/banner3.jpg"/>
            </div>
        </div>
        <div class="banner-controls">
            <button id="prevBtn">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button id="nextBtn">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>

    <div class="categories">
        <a href="?menu=produk&kategori_id=1" class="category">
            <i class="fas fa-book"></i>
            <p>Buku Baru Andalan</p>
        </a>
        <a href="?menu=produk&kategori_id=2" class="category">
            <i class="fas fa-globe"></i>
            <p>International Books</p>
        </a>
        <a href="?menu=produk" class="category">
            <i class="fas fa-newspaper"></i>
            <p>Majalah Gramedia</p>
        </a>
        <a href="?menu=produk&kategori_id=4" class="category">
            <i class="fas fa-pencil-alt"></i>
            <p>Stationery, Sekolah & Kantor</p>
        </a>
        <a href="?menu=produk&kategori_id=5" class="category">
            <i class="fas fa-futbol"></i>
            <p>Olahraga</p>
        </a>
        <a href="?menu=produk&kategori_id=6" class="category">
            <i class="fas fa-gamepad"></i>
            <p>Mainan & Hobi</p>
        </a>
        <a href="?menu=produk&kategori_id=7" class="category">
            <i class="fas fa-tshirt"></i>
            <p>Fashion & Aksesoris</p>
        </a>
    </div>

    <div class="description-section">
        <h2>Jelajahi Dunia Bersama Gramedia</h2>
        <p>Temukan beragam koleksi buku, alat tulis, dan produk lifestyle berkualitas dalam satu destinasi belanja terpercaya. Bersama Gramedia, wujudkan inspirasi dan kreativitas Anda.</p>
        
        <div class="features">
            <div class="feature">
                <h3>Koleksi Terlengkap</h3>
                <p>Nikmati akses ke ribuan judul buku terbaik, peralatan tulis berkualitas, dan produk lifestyle modern. Semua kebutuhan Anda tersedia dalam satu platform.</p>
            </div>
            <div class="feature">
                <h3>Belanja Lebih Mudah</h3>
                <p>Pengalaman berbelanja yang aman dan nyaman dengan sistem pembayaran terpercaya, pengiriman cepat, dan layanan pelanggan 24/7.</p>
            </div>
            <div class="feature">
                <h3>Update Terus-Menerus</h3>
                <p>Temukan koleksi terbaru setiap hari, dari buku best-seller hingga produk lifestyle trendy. Selalu ada sesuatu yang baru untuk Anda di Gramedia.</p>
            </div>
        </div>
    </div>

    <script>
        const bannerSlide = document.getElementById('bannerSlide');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        let currentIndex = 0;

        function showSlide(index) {
            const totalSlides = bannerSlide.children.length;
            if (index >= totalSlides) {
                currentIndex = 0;
            } else if (index < 0) {
                currentIndex = totalSlides - 1;
            } else {
                currentIndex = index;
            }
            const offset = -currentIndex * 100;
            bannerSlide.style.transform = `translateX(${offset}%)`;
        }

        prevBtn.addEventListener('click', () => {
            showSlide(currentIndex - 1);
        });

        nextBtn.addEventListener('click', () => {
            showSlide(currentIndex + 1);
        });

        setInterval(() => {
            showSlide(currentIndex + 1);
        }, 5000);
    </script>
</body>
</html>