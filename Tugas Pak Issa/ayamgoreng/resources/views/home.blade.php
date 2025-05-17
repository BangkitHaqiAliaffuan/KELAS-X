<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ayam Goreng Lezat - Renyah Sampai ke Tulang</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        :root {
            --main-color: #e65100;
            --main-color-dark: #d84315;
            --secondary-color: #ffcc80;
            --text-color: #333;
            --light-text: #f9f9f9;
            --background-color: #f9f9f9;
            --card-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color);
            overflow-x: hidden;
        }

        body::-webkit-scrollbar{
            width: 8px;
        }

        body::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        body::-webkit-scrollbar-thumb {
            background: var(--main-color);
            border-radius: 10px;
        }

        body::-webkit-scrollbar-thumb:hover {
            background: var(--main-color-dark);
        }

        .menu-toggle {
            display: none;
            cursor: pointer;
            font-size: 1.5rem;
        }

        /* Floating Cart Button */
        .floating-cart {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background-color: var(--main-color);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 24px;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            z-index: 100;
            transition: all 0.3s ease;
        }

        .floating-cart:hover {
            background-color: var(--main-color-dark);
            transform: scale(1.1);
        }

        .cart-count {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #ff3d00;
            color: white;
            font-size: 12px;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
        }

        /* Product Showcase */
        .product-showcase {
            height: 100vh;
            width: 100%;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #fff8e1, #fff3e0);
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s ease;
        }

        .product-showcase.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Hero Text */
        .hero-text {
            position: absolute;
            top: 20%;
            left: 10%;
            max-width: 350px;
            z-index: 5;
            opacity: 0;
            transform: translateX(-50px);
            transition: all 1s ease;
        }

        .product-showcase.visible .hero-text {
            opacity: 1;
            transform: translateX(0);
        }

        .hero-text h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            color: var(--text-color);
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        .hero-text p {
            max-width: 320px;
            font-size: 1.2rem;
            margin-bottom: 30px;
            color: #555;
            line-height: 1.6;
        }

        .cta-button {
            display: inline-block;
            padding: 12px 30px;
            background-color: var(--main-color);
            color: white;
            text-decoration: none;
            border-radius: 30px;
            font-weight: 600;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }

        .cta-button:hover {
            background-color: var(--main-color-dark);
            transform: translateY(-5px);
            box-shadow: 0 7px 20px rgba(0,0,0,0.2);
        }

        .product-carousel {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            position: relative;
        }

        .product-item {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.5s ease;
            opacity: 0;
            pointer-events: none;
            transform: scale(0.8) rotate(-5deg);
            filter: blur(5px);
        }

        .product-item.active {
            opacity: 1;
            pointer-events: all;
            transform: scale(1) rotate(0deg);
            z-index: 10;
            filter: blur(0);
        }

        .product-item.prev {
            transform: translateX(-100px) scale(0.8) rotate(-5deg);
            opacity: 0.5;
            z-index: 5;
        }

        .product-item.next {
            transform: translateX(100px) scale(0.8) rotate(5deg);
            opacity: 0.5;
            z-index: 5;
        }

        .product-image {
            height: 400px;
            transition: transform 0.3s ease;
            filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.2));
        }

        .product-item:hover .product-image {
            transform: scale(1.1) rotate(3deg);
        }

        .product-info {
            position: absolute;
            bottom: -50px;
            left: 0;
            right: 0;
            text-align: center;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .product-item.active .product-info {
            opacity: 1;
            bottom: -30px;
        }

        .product-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--main-color);
            margin-bottom: 5px;
        }

        .product-price {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-color);
        }

        .nav-buttons {
            position: absolute;
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding: 0 5%;
            z-index: 15;
        }

        .nav-button {
            background-color: rgba(255, 255, 255, 0.8);
            color: var(--main-color);
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .nav-button:hover {
            background-color: var(--main-color);
            color: white;
            transform: scale(1.1);
        }

        .carousel-dots {
            position: absolute;
            bottom: 30px;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .carousel-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .carousel-dot.active {
            background-color: var(--main-color);
            transform: scale(1.3);
        }

        /* Product Modal */
        .product-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .product-modal.active {
            opacity: 1;
            pointer-events: all;
        }

        .modal-content {
            background-color: white;
            border-radius: 15px;
            max-width: 600px;
            width: 90%;
            padding: 30px;
            position: relative;
            transform: translateY(50px);
            opacity: 0;
            transition: all 0.4s ease;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .product-modal.active .modal-content {
            transform: translateY(0);
            opacity: 1;
        }

        .close-modal {
            position: absolute;
            top: 15px;
            right: 15px;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #999;
            transition: color 0.3s ease;
        }

        .close-modal:hover {
            color: var(--main-color);
        }

        .modal-product {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .modal-image {
            height: 200px;
            margin-bottom: 20px;
            filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.15));
            transition: transform 0.5s ease;
        }

        .modal-image:hover {
            transform: rotate(5deg) scale(1.05);
        }

        .modal-title {
            font-size: 2rem;
            margin-bottom: 10px;
            color: var(--text-color);
        }

        .modal-description {
            color: #666;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .modal-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--main-color);
            margin-bottom: 20px;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .quantity-btn {
            width: 36px;
            height: 36px;
            background-color: #f0f0f0;
            border: none;
            border-radius: 50%;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quantity-btn:hover {
            background-color: var(--main-color);
            color: white;
        }

        .quantity-input {
            width: 60px;
            height: 36px;
            text-align: center;
            font-size: 1.2rem;
            margin: 0 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .add-to-cart {
            padding: 12px 30px;
            background-color: var(--main-color);
            color: white;
            border: none;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .add-to-cart:hover {
            background-color: var(--main-color-dark);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .add-to-cart i {
            font-size: 1.2rem;
        }

        /* Success Animation */
        .add-success {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .add-success.show {
            opacity: 1;
        }

        .success-icon {
            font-size: 4rem;
            color: #4CAF50;
            margin-bottom: 20px;
        }

        .success-message {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 30px;
        }

        .featured-section {
            padding: 80px 5%;
            text-align: center;
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s ease;
            position: relative;
            overflow: hidden;
        }

        .featured-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;utf8,<svg width="100" height="100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="3" fill="%23e65100" opacity="0.1"/></svg>');
            z-index: -1;
            opacity: 0.5;
        }

        .featured-section.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .section-title {
            font-size: 2.8rem;
            margin-bottom: 2rem;
            color: var(--text-color);
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            height: 4px;
            width: 60px;
            background-color: var(--main-color);
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
        }

        .section-subtitle {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 40px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Updated Menu Cards with Hover Effects */
        .menu-cards {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            margin-top: 40px;
        }

        .menu-card {
            width: 350px;
            height: 480px;
            border-radius: 15px;
            overflow: hidden;
            position: relative;
            box-shadow: var(--card-shadow);
            transition: all 0.5s ease;
            opacity: 0;
            transform: translateY(30px);
            background-color: white;
        }

        .menu-card.visible {
            opacity: 1;
            transform: translateY(0);
            transition: all 0.6s ease;
        }

        .menu-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .menu-card-image {
            width: 100%;
            height: 65%;
            background-size: cover;
            background-position: center;
            transition: all 0.5s ease;
            position: relative;
        }

        .menu-card:hover .menu-card-image {
            transform: scale(1.1);
        }

        .menu-card-content {
            padding: 20px;
            text-align: left;
            position: relative;
        }

        .menu-card-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--text-color);
        }

        .menu-card-description {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
            overflow: hidden;
        }

        .menu-card-price {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--main-color);
            margin-bottom: 15px;
        }

        .menu-card-button {
            background-color: var(--main-color);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .menu-card-button:hover {
            background-color: var(--main-color-dark);
            transform: translateY(-3px);
        }

        .menu-card-badge {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: var(--main-color);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 1;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .menu-card:hover .menu-card-badge {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* Filter Section */
        .filter-section {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
            gap: 15px;
            flex-wrap: wrap;
        }

        .filter-button {
            background-color: #f0f0f0;
            color: #666;
            border: none;
            padding: 10px 20px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-button.active {
            background-color: var(--main-color);
            color: white;
        }

        .filter-button:hover:not(.active) {
            background-color: #e0e0e0;
            transform: translateY(-3px);
        }

        /* Testimonials Section */
        .testimonials-section {
            /* max-height: 00px; */
            padding: 80px 5%;
            background-color: #f5f5f5;
            text-align: center;
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s ease;
        }

        .testimonials-section.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .testimonials-container {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            margin-top: 50px;
            min-height: 300px;
        }

        .testimonial {
            background-color: white;
            border-radius: 15px;
            padding: 30px;
            max-width: 800px;
            box-shadow: var(--card-shadow);
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            margin: auto;
            opacity: 0;
            transform: translateX(100px);
            transition: all 0.5s ease;
            pointer-events: none;
        }

        .testimonial.active {
            opacity: 1;
            transform: translateX(0);
            pointer-events: all;
        }

        .testimonial-content {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #555;
            margin-bottom: 20px;
            font-style: italic;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .author-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-size: cover;
            background-position: center;
        }

        .author-info {
            text-align: left;
        }

        .author-name {
            font-weight: 700;
            color: var(--text-color);
            margin-bottom: 5px;
        }

        .author-title {
            font-size: 0.9rem;
            color: #888;
        }

        .testimonial-nav {
            display: flex;
            justify-content: center;
            /* margin-top: 330px; */
            gap: 10px;
        }

        .testimonial-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #ddd;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .testimonial-dot.active {
            background-color: var(--main-color);
            transform: scale(1.3);
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, var(--main-color), #ff7043);
            padding: 80px 5%;
            text-align: center;
            color: white;
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s ease;
        }

        .cta-section.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .cta-title {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .cta-text {
            font-size: 1.2rem;
            margin-bottom: 30px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-form {
            display: flex;
            max-width: 500px;
            margin: 0 auto;
        }

        .cta-input {
            flex: 1;
            padding: 15px 20px;
            border: none;
            border-radius: 30px 0 0 30px;
            font-size: 1rem;
        }

        .cta-submit {
            padding: 15px 30px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 0 30px 30px 0;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .cta-submit:hover {
            background-color: #222;
        }

        /* Special Animation */
        .bounce-animation {
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-20px);
            }
            60% {
                transform: translateY(-10px);
            }
        }

        /* Footer */
        .footer {
            background-color: #333;
            color: white;
            padding: 60px 5% 20px;
            text-align: center;
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s ease;
        }

        .footer.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .footer-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-bottom: 40px;
        }

        .footer-column {
            flex: 1;
            min-width: 200px;
            margin: 10px;
            text-align: left;
        }

        .footer-column h3 {
            font-size: 1.2rem;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
            color: var(--light-text);
        }

        .footer-column h3::after {
            content: '';
            position: absolute;
            height: 2px;
            width: 40px;
            background-color: var(--main-color);
            bottom: 0;
            left: 0;
        }

        .footer-column p, .footer-column a {
            display: block;
            margin-bottom: 10px;
            color: #ddd;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-column a:hover {
            color: var(--main-color);
            padding-left: 10px;
        }

        .social-icons {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }

        .social-icons a {
            display: inline-block;
            height: 40px;
            width: 40px;
            background-color: #444;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            color: white;
            font-size: 1.2rem;
        }

        .social-icons a:hover {
            background-color: var(--main-color);
            transform: translateY(-5px);
        }

        .copyright {
            border-top: 1px solid #444;
            padding-top: 20px;
            font-size: 0.9rem;
            color: #999;
        }

        /* Notification Toast */
        .notification-toast {
            position: fixed;
            bottom: -100px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #333;
            color: white;
            padding: 15px 25px;
            border-radius: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            transition: all 0.5s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .notification-toast.show {
            bottom: 30px;
        }

        .notification-icon {
            color: var(--main-color);
            font-size: 1.2rem;
        }

        /* Typing Effect */
        .typing-container {
            display: inline-block;
            overflow: hidden;
            white-space: nowrap;
            border-right: 3px solid var(--main-color);
            animation: typing 5s steps(40, end) infinite, blink-caret 0.75s step-end infinite;
        }

        @keyframes typing {
            0%, 90%, 100% {
                width: 0;
            }
            30%, 60% {
                width: 100%;
            }
        }

        @keyframes blink-caret {
            from, to { border-color: transparent }
            50% { border-color: var(--main-color) }
        }

        /* Back to Top Button */
        .back-to-top {
            position: fixed;
            bottom: 100px;
            right: 30px;
            width: 50px;
            height: 50px;
            background-color: var(--main-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            opacity: 0;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
            z-index: 99;
        }

        .back-to-top.visible {
            opacity: 1;
        }

        .back-to-top:hover {
            background-color: var(--main-color-dark);
            transform: translateY(-5px);
        }

        @media screen and (max-width: 768px) {
            .navbar {
                padding: 1rem 4%;
            }

            .logo h1 {
                font-size: 1.2rem;
            }

            .menu-toggle {
                display: block;
            }

            .hero-text {
                top: 10%;
                left: 50%;
                transform: translateX(-50%);
                text-align: center;
                padding: 0 20px;
            }

            .hero-text h1 {
                font-size: 2.5rem;
            }

            .product-showcase.visible .hero-text {
                transform: translateX(-50%);
            }
            .product-image {
                height: 300px;
            }

            .section-title {
                font-size: 2rem;
            }

            .modal-image {
                height: 150px;
            }

            .modal-title {
                font-size: 1.5rem;
            }

            .menu-card {
                width: 290px;
                height: 400px;
            }

            .cta-form {
                flex-direction: column;
                gap: 10px;
            }

            .cta-input, .cta-submit {
                border-radius: 30px;
                width: 100%;
            }

            .footer-column {
                min-width: 100%;
                text-align: center;
                margin-bottom: 30px;
            }

            .footer-column h3::after {
                left: 50%;
                transform: translateX(-50%);
            }

            .social-icons {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    @extends('layouts.app')
    @section('content')

    <!-- Floating Cart Button -->
    <div class="floating-cart">
        <i class="fas fa-shopping-cart"></i>
        <span class="cart-count">0</span>
    </div>

    <!-- Back to Top Button -->
    <div class="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </div>

    <!-- Notification Toast -->
    <div class="notification-toast">
        <i class="fas fa-check-circle notification-icon"></i>
        <span class="notification-message">Berhasil ditambahkan ke keranjang!</span>
    </div>

    <!-- Product Showcase -->
    <section class="product-showcase">
        <div class="hero-text">
            <h1>Ayam Goreng <span style="color: var(--main-color);">Lezat</span></h1>
            <p>Renyah di luar, juicy di dalam. Dibuat dengan resep rahasia turun-temurun untuk pengalaman kuliner tak terlupakan.</p>
            <div class="typing-container">Renyah sampai ke tulang!</div>
            <button class="cta-button bounce-animation">Pesan Sekarang</button>
        </div>

        <div class="product-carousel">
            <div class="product-item active" data-index="0">
                <img src="{{ asset('gambar/ayamkrispi.webp') }}" alt="Ayam Original Crispy" class="product-image">
                <div class="product-info">
                    <div class="product-name">Ayam Original Crispy</div>
                    <div class="product-price">Rp 25.000</div>
                </div>
            </div>
            <div class="product-item next" data-index="1">
                <img src="{{ asset('gambar/ayampedas.webp') }}" alt="Ayam Spicy Hot" class="product-image">
                <div class="product-info">
                    <div class="product-name">Ayam Spicy Hot</div>
                    <div class="product-price">Rp 27.000</div>
                </div>
            </div>
            <div class="product-item" data-index="2">
                <img src="{{ asset('gambar/paketkeluarga.webp') }}" alt="Paket Keluarga" class="product-image">
                <div class="product-info">
                    <div class="product-name">Paket Keluarga</div>
                    <div class="product-price">Rp 120.000</div>
                </div>
            </div>
        </div>

        <div class="nav-buttons">
            <button class="nav-button prev-button"><i class="fas fa-chevron-left"></i></button>
            <button class="nav-button next-button"><i class="fas fa-chevron-right"></i></button>
        </div>

        <div class="carousel-dots">
            <div class="carousel-dot active" data-index="0"></div>
            <div class="carousel-dot" data-index="1"></div>
            <div class="carousel-dot" data-index="2"></div>
        </div>
    </section>

    <!-- Product Modal -->
    <div class="product-modal">
        <div class="modal-content">
            <button class="close-modal">×</button>
            <div class="modal-product">
                <img src="{{ asset('gambar/ayamkrispi.webp') }}" alt="Product" class="modal-image">
                <h2 class="modal-title">Nama Produk</h2>
                <p class="modal-description">Deskripsi produk akan muncul di sini.</p>
                <div class="modal-price">Rp 25.000</div>
                <div class="quantity-selector">
                    <button class="quantity-btn minus-btn"><i class="fas fa-minus"></i></button>
                    <input type="number" min="1" value="1" class="quantity-input">
                    <button class="quantity-btn plus-btn"><i class="fas fa-plus"></i></button>
                </div>
                <button class="add-to-cart"><i class="fas fa-shopping-cart"></i> Tambahkan ke Keranjang</button>
            </div>
            <div class="add-success">
                <i class="fas fa-check-circle success-icon"></i>
                <div class="success-message">Berhasil ditambahkan!</div>
                <button class="cta-button continue-shopping">Lanjutkan Belanja</button>
            </div>
        </div>
    </div>

    <!-- Featured Menu Section -->
   <!-- Featured Menu Section -->
<section class="featured-section">
    <h2 class="section-title">Menu Unggulan Kami</h2>
    <p class="section-subtitle">Pilihan menu terbaik kami yang dibuat dengan bahan berkualitas tinggi dan cita rasa yang tak tertandingi. Setiap sajian dibuat dengan penuh cinta untuk memuaskan lidah Anda.</p>

    <div class="filter-section">
        <button class="filter-button active" data-filter="all">Semua</button>
        @foreach ($categories as $category)
            <button class="filter-button" data-filter="{{ $category->id }}">{{ $category->name }}</button>
        @endforeach
    </div>

    <div class="menu-cards">
        @foreach ($featuredMenus as $menu)
            <div class="menu-card" data-category="{{ $menu->category_id }}">
                <div class="menu-card-badge">{{ $menu->badge }}</div>
                <div class="menu-card-image" style="background-image: url('{{ asset($menu->image) }}');"></div>
                <div class="menu-card-content">
                    <h3 class="menu-card-title">{{ $menu->name }}</h3>
                    <p class="menu-card-description">{{ Str::limit($menu->description, 50) }}</p>
                    <div class="menu-card-price">Rp {{ number_format($menu->price, 0, ',', '.') }}</div>
                    <button class="menu-card-button" data-id="{{ $menu->id }}">
                        <i class="fas fa-plus"></i> Tambahkan
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</section>

    <!-- Testimonials Section -->
    <section class="testimonials-section">
        <h2 class="section-title">Apa Kata Pelanggan</h2>
        <p class="section-subtitle">Pengalaman autentik dari pelanggan setia kami yang telah merasakan kelezatan Ayam Goreng Lezat.</p>

        <div class="testimonials-container">
            <div class="testimonial active" data-index="0">
                <p class="testimonial-content">"Ayam goreng paling renyah dan juicy yang pernah saya coba! Bumbu meresap sampai ke dalam dan rasanya benar-benar autentik. Sudah jadi langganan keluarga kami setiap akhir pekan."</p>
                <div class="testimonial-author">
                    <div class="author-avatar" style="background-color: #ddd;"></div>
                    <div class="author-info">
                        <div class="author-name">Budi Santoso</div>
                        <div class="author-title">Pelanggan Setia</div>
                    </div>
                </div>
            </div>

            <div class="testimonial" data-index="1">
                <p class="testimonial-content">"Saya sangat suka dengan paket keluarga mereka. Porsinya pas, ayamnya lezat, dan pelayanannya ramah. Harga juga sangat terjangkau untuk kualitas sekelas ini!"</p>
                <div class="testimonial-author">
                    <div class="author-avatar" style="background-color: #ddd;"></div>
                    <div class="author-info">
                        <div class="author-name">Siti Aminah</div>
                        <div class="author-title">Food Blogger</div>
                    </div>
                </div>
            </div>

            <div class="testimonial" data-index="2">
                <p class="testimonial-content">"Sebagai pecinta kuliner pedas, ayam spicy hot mereka adalah favorit saya! Tingkat kepedasannya pas dan tetap bisa menikmati rasa rempah khasnya. Recommended banget!"</p>
                <div class="testimonial-author">
                    <div class="author-avatar" style="background-color: #ddd;"></div>
                    <div class="author-info">
                        <div class="author-name">Deni Wijaya</div>
                        <div class="author-title">Koki Profesional</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="testimonial-nav">
            <div class="testimonial-dot active" data-index="0"></div>
            <div class="testimonial-dot" data-index="1"></div>
            <div class="testimonial-dot" data-index="2"></div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <h2 class="cta-title">Dapatkan Promo Spesial!</h2>
        <p class="cta-text">Daftar sekarang dan dapatkan promo spesial untuk pemesanan pertama Anda. Kami juga akan mengirimkan penawaran eksklusif langsung ke email Anda.</p>
        <form class="cta-form">
            <input type="email" placeholder="Masukkan email Anda" class="cta-input" required>
            <button type="submit" class="cta-submit">Berlangganan</button>
        </form>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-column">
                <h3>Ayam Goreng Lezat</h3>
                <p>Menyajikan ayam goreng berkualitas dengan resep rahasia turun temurun sejak 2005.</p>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="footer-column">
                <h3>Jam Operasional</h3>
                <p>Senin - Jumat: 10:00 - 22:00</p>
                <p>Sabtu - Minggu: 09:00 - 23:00</p>
                <p>Hari Libur: 09:00 - 23:00</p>
            </div>
            <div class="footer-column">
                <h3>Tautan Cepat</h3>
                <a href="#">Beranda</a>
                <a href="#">Menu</a>
                <a href="#">Promo</a>
                <a href="#">Lokasi</a>
                <a href="#">Kontak</a>
            </div>
            <div class="footer-column">
                <h3>Hubungi Kami</h3>
                <p>Jl. Ayam Goreng No. 123</p>
                <p>Kota Lezat, 12345</p>
                <p>info@ayamgorenglezat.com</p>
                <p>+62 8123 4567 890</p>
            </div>
        </div>
        <div class="copyright">
            <p>© 2025 Ayam Goreng Lezat. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script>

        // Products data
        const products = [
            {
                name: "Ayam Original Crispy",
                description: "Ayam goreng renyah dengan bumbu rahasia yang meresap sampai ke dalam. Digoreng dengan minyak berkualitas untuk hasil yang renyah di luar, juicy di dalam.",
                price: "Rp 25.000",
                image: "{{ asset('gambar/ayamkrispi.webp') }}"
            },
            {
                name: "Ayam Spicy Hot",
                description: "Ayam goreng dengan tambahan bumbu pedas spesial yang akan memanjakan lidah para pecinta kuliner pedas. Tingkat kepedasan yang pas dengan rasa yang menggigit.",
                price: "Rp 27.000",
                image: "{{ asset('gambar/ayampedas.webp') }}"
            },
            {
                name: "Paket Keluarga",
                description: "Paket spesial untuk dinikmati bersama keluarga. Terdiri dari 8 potong ayam dengan 3 pilihan rasa, 4 nasi, dan 4 minuman segar. Paket hemat untuk momen kebersamaan.",
                price: "Rp 120.000",
                image: "{{ asset('gambar/paketkeluarga.webp') }}"
            }
        ];

        // Cart functionality
        let cartCount = 0;
        const cartCountElement = document.querySelector('.cart-count');
        const floatingCart = document.querySelector('.floating-cart');

        floatingCart.addEventListener('click', function() {
            alert('Fitur keranjang akan segera hadir!');
        });

        // Toggle Menu for Mobile
        // const menuToggle = document.querySelector('.menu-toggle');
        const navLinks = document.querySelector('.nav-links');

        // menuToggle.addEventListener('click', () => {
        //     navLinks.classList.toggle('active');
        // });

        // Product Carousel
        const items = document.querySelectorAll('.product-item');
        const dots = document.querySelectorAll('.carousel-dot');
        const prevButton = document.querySelector('.prev-button');
        const nextButton = document.querySelector('.next-button');
        let currentIndex = 0;

        function updateProductClasses() {
            items.forEach((item, index) => {
                item.classList.remove('active', 'prev', 'next');

                if (index === currentIndex) {
                    item.classList.add('active');
                } else if (index === (currentIndex - 1 + items.length) % items.length) {
                    item.classList.add('prev');
                } else if (index === (currentIndex + 1) % items.length) {
                    item.classList.add('next');
                }
            });
        }

        function showProduct(index) {
            currentIndex = index;

            // Update product classes
            updateProductClasses();

            // Update dots
            dots.forEach(dot => {
                dot.classList.remove('active');
            });
            dots[index].classList.add('active');
        }

        // Set up dot navigation
        dots.forEach(dot => {
            dot.addEventListener('click', function() {
                const index = parseInt(this.dataset.index);
                showProduct(index);
            });
        });

        // Set up prev/next buttons
        prevButton.addEventListener('click', () => {
            const newIndex = (currentIndex - 1 + items.length) % items.length;
            showProduct(newIndex);
        });

        nextButton.addEventListener('click', () => {
            const newIndex = (currentIndex + 1) % items.length;
            showProduct(newIndex);
        });

        // Modal functionality
        const modal = document.querySelector('.product-modal');
        const closeModal = document.querySelector('.close-modal');
        const modalImage = document.querySelector('.modal-image');
        const modalTitle = document.querySelector('.modal-title');
        const modalDescription = document.querySelector('.modal-description');
        const modalPrice = document.querySelector('.modal-price');
        const addToCartButton = document.querySelector('.add-to-cart');
        const continueShoppingButton = document.querySelector('.continue-shopping');
        const successMessage = document.querySelector('.add-success');

        // Quantity selector
        const minusBtn = document.querySelector('.minus-btn');
        const plusBtn = document.querySelector('.plus-btn');
        const quantityInput = document.querySelector('.quantity-input');

        minusBtn.addEventListener('click', () => {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        });

        plusBtn.addEventListener('click', () => {
            let currentValue = parseInt(quantityInput.value);
            quantityInput.value = currentValue + 1;
        });

        // Open modal when product is clicked
        items.forEach(item => {
            item.addEventListener('click', function() {
                const index = parseInt(this.dataset.index);
                const product = products[index];

                // Populate modal with product info
                modalImage.src = product.image;
                modalImage.alt = product.name;
                modalTitle.textContent = product.name;
                modalDescription.textContent = product.description;
                modalPrice.textContent = product.price;

                // Reset quantity
                quantityInput.value = 1;

                // Hide success message if visible
                successMessage.classList.remove('show');

                // Show modal
                modal.classList.add('active');

                // Animate modal content
                gsap.fromTo('.modal-content', {
                    y: 50,
                    opacity: 0
                }, {
                    y: 0,
                    opacity: 1,
                    duration: 0.4
                });

                // Prevent body scrolling when modal is open
                document.body.style.overflow = 'hidden';
            });
        });

        // Add to cart functionality
        addToCartButton.addEventListener('click', function() {
            const quantity = parseInt(quantityInput.value);
            cartCount += quantity;
            cartCountElement.textContent = cartCount;

            // Show success message
            successMessage.classList.add('show');

            // Show notification toast
            showNotification('Berhasil ditambahkan ke keranjang!');

            // Animate cart
            gsap.fromTo('.floating-cart', {
                scale: 1
            }, {
                scale: 1.3,
                duration: 0.3,
                repeat: 1,
                yoyo: true
            });
        });

        // Continue shopping button
        continueShoppingButton.addEventListener('click', function() {
            modal.classList.remove('active');
            document.body.style.overflow = '';
            successMessage.classList.remove('show');
        });

        // Close modal
        closeModal.addEventListener('click', () => {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        });

        // Close modal when clicking outside content
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
        });

        // Add to cart from menu cards
        const menuCardButtons = document.querySelectorAll('.menu-card-button');
        menuCardButtons.forEach(button => {
            button.addEventListener('click', function() {
                cartCount++;
                cartCountElement.textContent = cartCount;

                // Show notification
                showNotification('Berhasil ditambahkan ke keranjang!');

                // Animate cart
                gsap.fromTo('.floating-cart', {
                    scale: 1
                }, {
                    scale: 1.3,
                    duration: 0.3,
                    repeat: 1,
                    yoyo: true
                });

                // Animate button
                gsap.fromTo(this, {
                    scale: 1
                }, {
                    scale: 0.9,
                    duration: 0.2,
                    repeat: 1,
                    yoyo: true
                });
            });
        });

        // Notification toast
        function showNotification(message) {
            const notificationToast = document.querySelector('.notification-toast');
            const notificationMessage = document.querySelector('.notification-message');

            notificationMessage.textContent = message;
            notificationToast.classList.add('show');

            setTimeout(() => {
                notificationToast.classList.remove('show');
            }, 3000);
        }

        // Menu filtering
       // Menu filtering
const filterButtons = document.querySelectorAll('.filter-button');
const menuCards = document.querySelectorAll('.menu-card');

filterButtons.forEach(button => {
    button.addEventListener('click', function() {
        // Remove active class from all buttons
        filterButtons.forEach(btn => btn.classList.remove('active'));

        // Add active class to clicked button
        this.classList.add('active');

        const filter = this.dataset.filter;

        // Filter menu cards
        menuCards.forEach(card => {
            if (filter === 'all' || card.dataset.category === filter) {
                card.style.display = 'block';

                // Add animation
                gsap.fromTo(card, {
                    y: 30,
                    opacity: 0
                }, {
                    y: 0,
                    opacity: 1,
                    duration: 0.5,
                    delay: Math.random() * 0.3
                });
            } else {
                card.style.display = 'none';
            }
        });
    });
});

        // Testimonial slider
        const testimonials = document.querySelectorAll('.testimonial');
        const testimonialDots = document.querySelectorAll('.testimonial-dot');
        let currentTestimonialIndex = 0;

        function showTestimonial(index) {
            testimonials.forEach(item => {
                item.classList.remove('active');
            });

            testimonialDots.forEach(dot => {
                dot.classList.remove('active');
            });

            testimonials[index].classList.add('active');
            testimonialDots[index].classList.add('active');

            currentTestimonialIndex = index;
        }

        testimonialDots.forEach(dot => {
            dot.addEventListener('click', function() {
                const index = parseInt(this.dataset.index);
                showTestimonial(index);
            });
        });

        // Auto rotate testimonials
        setInterval(() => {
            const newIndex = (currentTestimonialIndex + 1) % testimonials.length;
            showTestimonial(newIndex);
        }, 6000);

        // CTA Section Form
        const ctaForm = document.querySelector('.cta-form');
        ctaForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const input = this.querySelector('.cta-input');

            if (input.value) {
                showNotification('Terima kasih telah berlangganan!');
                input.value = '';
            }
        });

        // Back to Top Button
        const backToTopButton = document.querySelector('.back-to-top');

        window.addEventListener('scroll', function() {
            if (window.scrollY > 500) {
                backToTopButton.classList.add('visible');
            } else {
                backToTopButton.classList.remove('visible');
            }
        });

        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Auto rotate carousel every 5 seconds
        setInterval(() => {
            const newIndex = (currentIndex + 1) % items.length;
            showProduct(newIndex);
        }, 5000);

        // Scroll Animation
        function handleScroll() {
            const elements = document.querySelectorAll('.product-showcase, .featured-section, .testimonials-section, .cta-section, .footer, .menu-card');

            elements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                const elementBottom = element.getBoundingClientRect().bottom;
                const windowHeight = window.innerHeight;

                // Element is in viewport
                if (elementTop < windowHeight - 100 && elementBottom > 0) {
                    element.classList.add('visible');

                    // For menu cards, add staggered animation
                    if (element.classList.contains('menu-card') && !element.classList.contains('animated')) {
                        gsap.fromTo(element, {
                            y: 30,
                            opacity: 0
                        }, {
                            y: 0,
                            opacity: 1,
                            duration: 0.5,
                            delay: 0.1 * Array.from(document.querySelectorAll('.menu-card')).indexOf(element) % 3
                        });
                        element.classList.add('animated');
                    }
                }
            });
        }

        // Initialize GSAP animations
        function initAnimations() {
            // Hero section animations
            gsap.timeline()
                .from('.hero-text h1', {opacity: 0, y: 30, duration: 0.8, delay: 0.5})
                .from('.hero-text p', {opacity: 0, y: 20, duration: 0.8}, '-=0.4')
                .from('.typing-container', {opacity: 0, duration: 0.5}, '-=0.2')
                .from('.cta-button', {opacity: 0, y: 20, duration: 0.5}, '-=0.2');

            // Bounce animation for CTA button
            gsap.to('.bounce-animation', {
                y: -10,
                duration: 1,
                repeat: -1,
                yoyo: true,
                ease: "power1.inOut"
            });
        }

        // Initial check and animations
        window.addEventListener('scroll', handleScroll);
        window.addEventListener('load', function() {
            handleScroll();
            initAnimations();

            // Set initial carousel state
            updateProductClasses();
        });
    </script>
@endsection
</body>
</html>
