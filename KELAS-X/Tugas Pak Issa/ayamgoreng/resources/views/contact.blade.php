@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hubungi Kami - Ayam Goreng Lezat</title>
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

        .contact-section {
            position: relative;
            padding: 80px 5% 100px;
            background: linear-gradient(135deg, #ffebee 0%, #fff8e1 100%);
            overflow: hidden;
        }

        .contact-section::before {
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

        .contact-section::after {
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

        .contact-header {
            text-align: center;
            margin-bottom: 60px;
            position: relative;
            z-index: 2;
            opacity: 0;
            transform: translateY(50px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }

        .contact-header.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .section-title {
            font-size: 2.5rem;
            color: #e65100;
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
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

        .contact-subtitle {
            font-size: 1.1rem;
            color: #666;
            max-width: 600px;
            margin: 20px auto 0;
        }

        .contact-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 40px;
            margin-bottom: 80px;
            position: relative;
            z-index: 2;
        }

        .contact-info,
        .contact-form-container,
        .map-frame,
        .cta-banner {
            opacity: 0;
            transform: translateY(50px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }

        .contact-info.visible,
        .contact-form-container.visible,
        .map-frame.visible,
        .cta-banner.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .contact-info {
            flex: 1;
            min-width: 320px;
            background-color: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.07);
        }

        .contact-info:hover {
            transform: translateY(-10px);
        }

        .info-item {
            display: flex;
            margin-bottom: 30px;
            align-items: flex-start;
        }

        .info-icon {
            font-size: 2rem;
            margin-right: 20px;
            color: #e65100;
            width: 50px;
            height: 50px;
            background-color: #fff3e0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .info-item:hover .info-icon {
            background-color: #e65100;
            color: white;
            transform: rotateY(180deg);
        }

        .info-content h3 {
            margin-bottom: 10px;
            font-size: 1.3rem;
            color: #333;
            font-weight: 600;
        }

        .info-content p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 5px;
        }

        .social-container {
            margin-top: 40px;
            background-color: #fff3e0;
            padding: 25px;
            border-radius: 12px;
        }

        .social-container h3 {
            margin-bottom: 20px;
            font-size: 1.3rem;
            color: #333;
            font-weight: 600;
            text-align: center;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .social-icons a {
            display: inline-block;
            height: 50px;
            width: 50px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #e65100;
            text-decoration: none;
            font-size: 1.2rem;
            transition: all 0.4s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .social-icons a:hover {
            background-color: #e65100;
            color: white;
            transform: translateY(-8px) rotate(360deg);
        }

        .contact-form-container {
            flex: 1;
            min-width: 320px;
            background-color: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.07);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .contact-form-container::before {
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

        .contact-form-container::after {
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

        .contact-form-container h2 {
            margin-bottom: 30px;
            font-size: 1.8rem;
            color: #e65100;
            text-align: center;
            font-weight: 600;
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

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 14px 20px;
            border: 2px solid #eee;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #f9f9f9;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #e65100;
            outline: none;
            box-shadow: 0 0 0 3px rgba(230, 81, 0, 0.1);
            background-color: white;
        }

        .form-group input:focus + label,
        .form-group textarea:focus + label {
            color: #e65100;
        }

        .submit-button {
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

        .submit-button::before {
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

        .submit-button:hover::before {
            left: 0;
        }

        .submit-button:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(230, 81, 0, 0.2);
        }

        .map-container {
            margin-top: 80px;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .map-title {
            margin-bottom: 30px;
            font-size: 2rem;
            color: #e65100;
            position: relative;
            display: inline-block;
        }

        .map-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(to right, #e65100, #ff9800);
            border-radius: 2px;
        }

        .map-subtitle {
            color: #666;
            margin-bottom: 30px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .map-frame {
            height: 450px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .map-frame::before {
            content: '🍗';
            position: absolute;
            top: -25px;
            right: -25px;
            font-size: 4rem;
            opacity: 0.2;
            transform: rotate(15deg);
            z-index: -1;
        }

        .map-frame iframe {
            width: 100%;
            height: 100%;
            border: none;
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
            top: 20%;
            right: 5%;
            animation-delay: 2s;
        }

        .chicken3 {
            bottom: 15%;
            left: 8%;
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

        .cta-banner {
            background: linear-gradient(135deg, #e65100, #ff9800);
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            margin-top: 80px;
            box-shadow: 0 15px 30px rgba(230, 81, 0, 0.2);
            position: relative;
            overflow: hidden;
        }

        .cta-banner::before {
            content: '';
            position: absolute;
            top: -50px;
            left: -50px;
            width: 150px;
            height: 150px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .cta-banner::after {
            content: '';
            position: absolute;
            bottom: -50px;
            right: -50px;
            width: 150px;
            height: 150px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .cta-title {
            color: white;
            font-size: 2rem;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .cta-text {
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 30px;
            font-size: 1.1rem;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-button {
            display: inline-block;
            padding: 15px 35px;
            background-color: white;
            color: #e65100;
            font-weight: 600;
            font-size: 1.1rem;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .cta-button:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        @media screen and (max-width: 992px) {
            .contact-container {
                flex-direction: column;
            }

            .contact-form-container,
            .contact-info {
                min-width: 100%;
            }
        }

        @media screen and (max-width: 768px) {
            .contact-section {
                padding: 60px 4% 80px;
            }

            .section-title {
                font-size: 2rem;
            }

            .map-frame {
                height: 350px;
            }

            .contact-info,
            .contact-form-container {
                padding: 30px;
            }

            .floating-chicken {
                display: none;
            }
        }

        @media screen and (max-width: 480px) {
            .section-title {
                font-size: 1.8rem;
            }

            .info-icon {
                font-size: 1.5rem;
                width: 40px;
                height: 40px;
            }

            .info-content h3 {
                font-size: 1.1rem;
            }

            .map-frame {
                height: 300px;
            }

            .cta-title {
                font-size: 1.5rem;
            }

            .cta-banner {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <section class="contact-section">
        <div class="floating-chicken chicken1"></div>
        <div class="floating-chicken chicken2"></div>
        <div class="floating-chicken chicken3"></div>

        <div class="contact-header">
            <h1 class="section-title">Hubungi Kami</h1>
            <p class="contact-subtitle">Kami siap melayani pertanyaan, saran, atau pesanan Anda. Jangan ragu untuk menghubungi kami melalui salah satu cara di bawah ini.</p>
        </div>

        <div class="contact-container">
            <div class="contact-info">
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="info-content">
                        <h3>Alamat</h3>
                        <p>Jl. Ayam Goreng No. 123</p>
                        <p>Kota Lezat, 12345</p>
                        <p>Indonesia</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-phone-alt"></i></div>
                    <div class="info-content">
                        <h3>Telepon</h3>
                        <p>+62 8123 4567 890</p>
                        <p>+62 8123 4567 891 (Layanan Pelanggan)</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-envelope"></i></div>
                    <div class="info-content">
                        <h3>Email</h3>
                        <p>info@ayamgorenglezat.com</p>
                        <p>pesanan@ayamgorenglezat.com</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-clock"></i></div>
                    <div class="info-content">
                        <h3>Jam Operasional</h3>
                        <p>Senin - Jumat: 10:00 - 22:00</p>
                        <p>Sabtu - Minggu: 09:00 - 23:00</p>
                        <p>Hari Libur: 09:00 - 23:00</p>
                    </div>
                </div>

                <div class="social-container">
                    <h3>Ikuti Kami</h3>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
            </div>

            <div class="contact-form-container">
                <h2>Kirim Pesan</h2>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form class="contact-form" action="{{ route('contact.store') }}" method="POST">
                    <!-- Form fields tetap sama -->
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" id="name" name="name" placeholder="Masukkan nama lengkap Anda" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Masukkan alamat email Anda" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Nomor Telepon</label>
                        <input type="tel" id="phone" name="phone" placeholder="Masukkan nomor telepon Anda">
                    </div>

                    <div class="form-group">
                        <label for="subject">Subjek</label>
                        <input type="text" id="subject" name="subject" placeholder="Subjek pesan Anda" required>
                    </div>

                    <div class="form-group">
                        <label for="message">Pesan</label>
                        <textarea id="message" name="message" rows="6" placeholder="Tuliskan pesan Anda di sini..." required></textarea>
                    </div>

                    <button type="submit" class="submit-button">Kirim Pesan <i class="fas fa-paper-plane ml-2"></i></button>
                </form>
            </div>
        </div>

        <div class="map-container">
            <h2 class="map-title">Lokasi Kami</h2>
            <p class="map-subtitle">Kunjungi restoran kami untuk menikmati kelezatan Ayam Goreng terbaik di kota. Kami berlokasi strategis dan mudah dijangkau.</p>
            <div class="map-frame">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d253163.47936455611!2d112.54877757830982!3d-7.500605795378514!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7e14a7b3be9cd%3A0x42649bc57549aa15!2sRicheese%20Factory%20Sidoarjo!5e0!3m2!1sid!2sid!4v1742527944361!5m2!1sid!2sid" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>

        <div class="cta-banner">
            <h2 class="cta-title">Ingin Memesan Ayam Goreng Lezat?</h2>
            <p class="cta-text">Kami menyediakan layanan pesan antar untuk area Kota Lezat dan sekitarnya. Nikmati kelezatan Ayam Goreng kami langsung di rumah Anda!</p>
            <a href="#" class="cta-button">Pesan Sekarang <i class="fas fa-arrow-right ml-2"></i></a>
        </div>
    </section>

    <script>
        // Animasi saat scroll menggunakan Intersection Observer
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        // Berhenti mengamati elemen setelah terlihat untuk efisiensi
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1, // Elemen mulai terlihat saat 10% masuk viewport
                rootMargin: '0px 0px -50px 0px' // Margin bawah untuk memicu lebih awal
            });

            // Pilih elemen yang akan dianimasikan
            const elementsToAnimate = document.querySelectorAll('.contact-header, .contact-info, .contact-form-container, .map-frame, .cta-banner');
            elementsToAnimate.forEach(element => {
                observer.observe(element);
            });
        });
    </script>
</body>
</html>
@endsection
