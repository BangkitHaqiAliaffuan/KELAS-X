<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Ayam Goreng JOSS') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Ayam Goreng JOSS - Custom Navbar Styling */
        html::-webkit-scrollbar{
            display: none;
        }
        /* Main styling */
        :root {
            --primary-color: #FF6B35;
            --secondary-color: #2E294E;
            --accent-color: #F7C59F;
            --light-color: #EFEFEF;
            --dark-color: #1A1A1A;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Navbar container */
        .navbar {
            background: linear-gradient(135deg, var(--primary-color), #FF8E63);
            padding: 0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* Brand logo */
        .navbar-brand {
            font-size: 1.8rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
            padding: 15px 0;
            position: relative;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s;
            display: flex;
            align-items: center;
        }

        .navbar-brand:before {
            content: '🍗';
            margin-right: 8px;
            font-size: 1.2em;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
        }

        /* Hamburger menu */
        .navbar-toggler {
            background-color: transparent;
            border: none;
            cursor: pointer;
            padding: 10px;
            display: none;
        }

        .navbar-toggler-icon {
            display: block;
            width: 25px;
            height: 3px;
            background-color: white;
            position: relative;
            transition: background-color 0.3s;
        }

        .navbar-toggler-icon:before,
        .navbar-toggler-icon:after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background-color: white;
            transition: transform 0.3s;
        }

        .navbar-toggler-icon:before {
            transform: translateY(-8px);
        }

        .navbar-toggler-icon:after {
            transform: translateY(8px);
        }

        /* Nav links container */
        .navbar-collapse {
            display: flex;
            flex-grow: 1;
            justify-content: space-between;
        }

        /* Nav links */
        .navbar-nav {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            color: white;
            text-decoration: none;
            padding: 25px 18px;
            display: inline-block;
            font-weight: 500;
            transition: all 0.3s;
            position: relative;
        }

        .nav-link:after {
            content: '';
            position: absolute;
            bottom: 15px;
            left: 50%;
            width: 0;
            height: 3px;
            background-color: var(--accent-color);
            transform: translateX(-50%);
            transition: width 0.3s;
            border-radius: 3px;
        }

        .nav-link:hover {
            color: var(--accent-color);
        }

        .nav-link:hover:after {
            width: 70%;
        }

        /* Dropdown styling */
        .dropdown-toggle {
            position: relative;
            padding-right: 25px;
        }

        .dropdown-toggle:after {
            content: '▼';
            font-size: 0.7em;
            margin-left: 5px;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background-color: white;
            border-radius: 8px;
            min-width: 180px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s;
            padding: 10px 0;
            z-index: 100;
        }

        .dropdown-item {
            display: block;
            color: var(--secondary-color);
            padding: 10px 20px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .dropdown-item:hover {
            background-color: var(--accent-color);
            color: var(--dark-color);
        }

        .dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        /* Active state */
        .nav-item.active .nav-link {
            color: var(--accent-color);
        }

        .nav-item.active .nav-link:after {
            width: 70%;
        }

        /* Cart item with badge */
        .nav-item:nth-child(3) .nav-link {
            position: relative;
        }

        .nav-item:nth-child(3) .nav-link:before {
            content: '🛒';
            margin-right: 5px;
        }

        /* Special animation for promo link */
        .nav-item:nth-child(4) .nav-link {
            animation: pulse 2s infinite;
            color: var(--accent-color);
            font-weight: 600;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        /* User menu styling - Fixed to remove line through username */
        .user-menu {
            display: flex;
            align-items: center;
        }

        .user-menu .nav-link {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 20px 18px;
        }

        /* Remove the underline effect for user dropdown specifically */
        .user-menu .nav-link:after {
            display: none;
        }

        .user-menu .nav-link:before {
            content: '👤';
            font-size: 1.1em;
        }

        /* Make sure dropdown toggle doesn't have text decoration */
        .user-menu .dropdown-toggle {
            text-decoration: none;
            border-bottom: none;
        }

        .user-menu .dropdown-menu {
            min-width: 200px;
        }

        /* Dropdown divider styling */
        .dropdown-divider {
            height: 1px;
            margin: 8px 0;
            overflow: hidden;
            background-color: #e9ecef;
        }

        /* Responsive design */
        @media (max-width: 991px) {
            .navbar-toggler {
                display: block;
                order: 1;
            }

            .navbar-collapse {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background-color: var(--primary-color);
                flex-direction: column;
                padding: 0;
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.5s;
                box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            }

            .navbar-collapse.show {
                max-height: 1000px;
            }

            .navbar-nav {
                flex-direction: column;
                width: 100%;
            }

            .navbar-nav.ms-auto {
                border-top: 1px solid rgba(255, 255, 255, 0.2);
            }

            .nav-link {
                padding: 15px 20px;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }

            .nav-link:after {
                display: none;
            }

            .dropdown-menu {
                position: static;
                background-color: rgba(0, 0, 0, 0.1);
                box-shadow: none;
                opacity: 1;
                visibility: visible;
                transform: none;
                padding: 0;
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s;
            }

            .dropdown.show .dropdown-menu {
                max-height: 200px;
            }

            .dropdown-item {
                color: white;
                padding: 12px 30px;
            }

            .dropdown-item:hover {
                background-color: rgba(0, 0, 0, 0.2);
                color: var(--accent-color);
            }
        }

        /* Required JavaScript for mobile menu */
        @media (max-width: 991px) {
            .menu-toggle.active .navbar-toggler-icon {
                background-color: transparent;
            }

            .menu-toggle.active .navbar-toggler-icon:before {
                transform: rotate(45deg);
            }

            .menu-toggle.active .navbar-toggler-icon:after {
                transform: rotate(-45deg);
            }
        }
    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Ayam Goreng JOSS') }}
                </a>
                <button class="navbar-toggler menu-toggle" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto nav-links">
                        <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Beranda</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('menu') }}">Menu</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('cart') }}">Keranjang</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Promo</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('contact') }}">Kontak</a></li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        @if(!session()->has('user_id'))
                            <li class="nav-item"><a class="nav-link" href="{{ url('login') }}">Login</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ url('register') }}">Daftar</a></li>
                        @else
                            <li class="nav-item dropdown user-menu">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown">
                                    {{ session('user_name', Auth::user()->name) }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ url('profile') }}">
                                        Profil Saya
                                    </a>
                                    <a class="dropdown-item" href="{{ route('orders.index') }}">Pesanan Saya</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ url('logout') }}">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ url('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        <main class="">
            @yield('content')
        </main>
    </div>

    <!-- JavaScript untuk navbar -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle menu for mobile
            const menuToggle = document.querySelector('.menu-toggle');
            const navbarCollapse = document.getElementById('navbarSupportedContent');

            if (menuToggle) {
                menuToggle.addEventListener('click', function() {
                    this.classList.toggle('active');
                    navbarCollapse.classList.toggle('show');
                });
            }

            // For dropdown menus on mobile
            const dropdowns = document.querySelectorAll('.dropdown');

            dropdowns.forEach(dropdown => {
                const dropdownToggle = dropdown.querySelector('.dropdown-toggle');

                if (window.innerWidth < 992) {
                    dropdownToggle.addEventListener('click', function(e) {
                        e.preventDefault();
                        dropdown.classList.toggle('show');
                    });
                }
            });
        });
    </script>
</body>

</html>
