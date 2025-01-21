<?php
ob_start();

// 2. Start session

session_start();
$host = "localhost";
$user = "root";
$password = "";
$database = "kacamata";
$koneksi = mysqli_connect($host, $user, $password, $database);

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Gramedia</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .header {
            width: 97.5%;
            position: absolute;
            top: 0;
            background-color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-around;
            align-items: center;
            border-bottom: 1px solid #ddd;
            animation: slideDown 1s ease-out;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .header .logo {
            display: flex;
            align-items: center;
        }

        .header .logo img {
            height: 40px;
            margin-right: 10px;
        }

        .header .logo a {
            font-size: 24px;
            font-weight: 700;
            color: #1a73e8;
        }

        .header .search-bar {
            flex-grow: 1;
            margin: 0 20px;
            display: flex;
            align-items: center;
        }

        .search {
            max-width: 400px;
        }

        .header .search-bar input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .header .search-bar input:focus {
            border-color: #1a73e8;
            box-shadow: 0 0 10px rgba(26, 115, 232, 0.2);
        }

        .header .search-bar select {
            margin-left: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .header .search-bar select:focus {
            border-color: #1a73e8;
            box-shadow: 0 0 10px rgba(26, 115, 232, 0.2);
        }

        .header .nav-links {
            display: flex;
            font-size: 15px;
            margin-right: 20px;
            align-items: center;
        }

        .header .nav-links a {
            margin-left: 20px;
            color: #333;
            text-decoration: none;
            font-weight: 500;
            position: relative;
            transition: color 0.3s ease;
        }

        .header .nav-links a::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: -5px;
            left: 0;
            background-color: #1a73e8;
            visibility: hidden;
            transform: scaleX(0);
            transition: all 0.3s ease-in-out;
        }

        .header .nav-links a:hover::before {
            visibility: visible;
            transform: scaleX(1);
        }

        .header .nav-links a:hover {
            color: #1a73e8;
        }

        .header .auth-buttons {
            display: flex;
            margin-right: 25px;
            align-items: center;
        }

        .header .auth-buttons button {
            margin-left: 10px;
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .header .auth-buttons .login {
            background-color: #fff;
            color: #1a73e8;
            text-decoration: none;
            padding: 10px;
            margin-right: 10px;
            border-radius: 10px;
            border: 1px solid #1a73e8;
        }

        .header .auth-buttons .login:hover {
            background-color: #1a73e8;
            color: #fff;
        }

        .header .auth-buttons .register {
            background-color: #1a73e8;
            text-decoration: none;
            padding: 10px;
            color: #fff;
            border-radius: 10px;
        }

        .header .auth-buttons .register:hover {
            background-color: #fff;
            color: #1a73e8;
            border: 1px solid #1a73e8;
        }

        .main-content {
            margin-top: 60px;
            padding: 20px;
            animation: fadeIn 1s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.9);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loading-overlay .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid rgba(0, 0, 0, 0.1);
            border-top-color: #1a73e8;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .loading-overlay .text {
            margin-top: 20px;
            font-size: 18px;
            color: #1a73e8;
            animation: fadeInOut 1.5s ease-in-out infinite;
        } */

        @keyframes fadeInOut {

            0%,
            100% {
                opacity: 0;
            }

            50% {
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .header .search-bar {
                flex-direction: column;
            }

            .header .search-bar input,
            .header .search-bar select {
                margin-bottom: 10px;
                width: 60%;
            }

            .main-content .promo-section {
                flex-direction: column;
            }

            .main-content .promo-section .promo-item {
                margin-bottom: 20px;
                max-width: 100%;
            }

            .main-content .categories {
                flex-direction: column;
            }

            .main-content .categories .category-item {
                margin-bottom: 20px;
            }
        }

        .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            width: 500px;
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-top: 8px;
            max-height: 400px;
            overflow-y: auto;
            z-index: 1000;
        }

        /* Product Card */
        .product-card {
            display: flex;
            padding: 12px;
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.2s ease;
            text-decoration: none;
            color: inherit;
        }

        .product-card:last-child {
            border-bottom: none;
        }

        .product-card:hover {
            background-color: #f8f9fa;
        }

        /* Product Image */
        .product-image {
            width: 70px;
            height: 90px;
            object-fit: cover;
            border-radius: 4px;
            margin-right: 15px;
            border: 1px solid #f0f0f0;
        }

        /* Product Info */
        .product-info {
            flex: 1;
            min-width: 0;
            /* Prevents text overflow */
        }

        .product-info h3 {
            margin: 0 0 6px 0;
            font-size: 14px;
            font-weight: 500;
            color: #333;
            line-height: 1.3;
            /* Prevent long titles from breaking layout */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .author {
            font-size: 12px;
            color: #666;
            margin: 0 0 6px 0;
            /* Prevent long author names from breaking layout */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .price {
            font-size: 14px;
            font-weight: 600;
            color: #e4002b;
            margin: 0 0 8px 0;
        }

        /* View Detail Button */
        .view-detail {
            display: inline-block;
            padding: 6px 12px;
            background-color: #1a73e8;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            transition: background-color 0.2s ease;
        }

        .view-detail:hover {
            background-color: #1557b0;
        }

        /* No Results Message */
        .no-results {
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }

        /* Loading State */
        .search-results .loading {
            padding: 20px;
            text-align: center;
            color: #666;
        }

        /* Scrollbar Styling */
        .search-results::-webkit-scrollbar {
            width: 8px;
        }

        .search-results::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .search-results::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 4px;
        }

        .search-results::-webkit-scrollbar-thumb:hover {
            background: #999;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .search-results {
                width: 100%;
                max-width: 100%;
                border-radius: 0;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }

            .product-card {
                padding: 10px;
            }

            .product-image {
                width: 60px;
                height: 80px;
            }

            .product-info h3 {
                font-size: 13px;
            }
        }
    </style>
</head>

<body>
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
        <div class="text">Loading...</div>
    </div>

    <header class="header">
        <div class="logo">
            <img alt="Gramedia logo" src="uploads/logoGramed.png" />
            <a style="text-decoration:none;" href="?menu=home">Gramedia.com</a>
        </div>
        <div class="search-bar">

            <input placeholder="Cari Produk, Judul Buku, atau Penulis" class="search" type="text" />
        </div>
        <div class="nav-links">
            <?php if (isset($_SESSION['email'])) { ?>
                <a href="?menu=cart">Cart</a>
                <a href="?menu=profile"><?php echo $_SESSION['email']; ?></a>
                <a href="?menu=logout">Logout</a>
                <a href="?menu=show_order">Pesanan</a>
            <?php } ?>
            <a href="#">Promo</a>
        </div>
        <div class="auth-buttons">
            <?php if (!isset($_SESSION['email'])) { ?>
                <a href="?menu=login" class="login">Masuk</a>
                <a href="?menu=register" class="register">Daftar</a>
            <?php } ?>
        </div>
    </header>

    <main class="main-content">
        <?php
        if (isset($_GET['menu'])) {
            $menu = $_GET['menu'];
            switch ($menu) {
                case "login":
                    require_once "pages/login.php";
                    break;
                case "register":
                    require_once "pages/register.php";
                    break;
                case "home":
                    require_once "home.php";
                    break;
                case "logout":
                    require_once "pages/logout.php";
                    break;
                case "profile":
                    require_once "pages/profile/profile.php";
                    break;
                case "edit_profile":
                    require_once "pages/profile/edit_profile.php";
                    break;
                case "produk":
                    require_once "pages/produk.php";
                    break;
                case "produkdetail":
                    require_once "pages/produk-detail.php";
                    break;
                case "save_order":
                    require_once "pages/save_order.php";
                    break;
                case "order":
                    require_once "pages/order.php";
                    break;
                case "show_order":
                    require_once "pages/show_order.php";
                    break;
                case "cart":
                    require_once "pages/cart.php";
                    break;
                case "display_cart":
                    require_once "pages/display_cart.php";
                    break;
                default:
                    require_once "home.php";
            }
        } else {
            require_once "home.php";
        }
        ?>
    </main>

    <script>
        // Hide the loading overlay once the entire page is fully loaded
        window.onload = function() {
            document.getElementById("loadingOverlay").style.display = "none";
        };

        // Optionally show loading overlay initially
        // document.getElementById("loadingOverlay").style.display = "flex";
        // Show loading overlay

        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('.search');
            let searchTimeout;

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);

                // Remove existing search results
                const existingResults = document.querySelector('.search-results');
                if (existingResults) {
                    existingResults.remove();
                }

                const searchTerm = this.value.trim();

                if (searchTerm.length < 2) return;

                // Add loading indicator
                const loadingDiv = document.createElement('div');
                loadingDiv.className = 'search-results';
                loadingDiv.innerHTML = '<p style="text-align: center; padding: 10px;">Mencari...</p>';
                searchInput.parentNode.appendChild(loadingDiv);

                // Delay the search to prevent too many requests
                searchTimeout = setTimeout(() => {
                    const formData = new FormData();
                    formData.append('search', searchTerm);

                    fetch('pages/search.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.text())
                        .then(data => {
                            loadingDiv.remove();
                            searchInput.parentNode.insertAdjacentHTML('beforeend', data);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            loadingDiv.innerHTML = '<p style="text-align: center; padding: 10px;">Terjadi kesalahan</p>';
                        });
                }, 300);
            });

            // Close search results when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.search-bar')) {
                    const searchResults = document.querySelector('.search-results');
                    if (searchResults) {
                        searchResults.remove();
                    }
                }
            });
        });
    </script>
</body>

</html>