<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SMK Resto - Aplikasi Restoran Modern</title>
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/smkresto-modern.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="theme-color" content="#FF6B35">
    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--gray-100);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--gray-300);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--gray-400);
        }

        /* Layout */
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .page-wrapper {
            display: flex;
            flex: 1;
        }

        .main-content {
            flex: 1;
            min-width: 0;
            padding-top: 76px;
            transition: all 0.3s ease;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 76px;
            overflow-y: auto;
            z-index: 100;
            transition: all 0.3s ease;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: var(--gray-700);
            border-radius: 0.5rem;
            margin: 0.25rem 0;
            transition: all 0.3s ease;
        }

        .sidebar-link:hover, .sidebar-link.active {
            color: var(--primary);
            background-color: var(--primary-light);
        }

        .sidebar-link i {
            width: 24px;
            font-size: 1.1rem;
        }

        /* Avatar */
        .avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .avatar:hover {
            transform: scale(1.05);
        }

        /* Navbar */
        .navbar {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            z-index: 1000;
        }

        .navbar .nav-link {
            position: relative;
        }

        .navbar .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background-color: var(--primary);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .navbar .nav-link:hover::after {
            width: 80%;
        }

        /* Content area */
        .content-wrapper {
            padding: 2rem;
            margin-left: 280px;
            transition: all 0.3s ease;
        }

        .content-card {
            background: white;
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow);
            padding: 2rem;
            min-height: calc(100vh - 200px);
        }

        /* Footer */
        .footer {
            background-color: white;
            padding: 2rem 0;
            margin-top: auto;
            margin-left: 280px;
            transition: all 0.3s ease;
        }

        /* Mobile adjustments */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .content-wrapper, .footer {
                margin-left: 0;
            }

            .content-wrapper.sidebar-open, .footer.sidebar-open {
                margin-left: 280px;
            }
        }

        /* User info in sidebar */
        .user-info {
            background-color: var(--gray-100);
            border-radius: var(--border-radius-lg);
            padding: 1.25rem;
            margin: 1.5rem 0;
            transition: all 0.3s ease;
        }

        .user-info:hover {
            box-shadow: var(--shadow);
            transform: translateY(-3px);
        }

        /* Category menu */
        .category-menu .sidebar-link {
            padding-left: 2rem;
        }

        /* Dropdown menu */
        .dropdown-menu {
            border: none;
            box-shadow: var(--shadow-lg);
            border-radius: var(--border-radius-lg);
            padding: 0.75rem 0;
            animation: fadeInDown 0.3s ease;
        }

        .dropdown-item {
            padding: 0.6rem 1.5rem;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: var(--primary-light);
            color: var(--primary);
        }

        .dropdown-item i {
            width: 20px;
            margin-right: 0.5rem;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top bg-white">
        <div class="container-fluid px-4">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <i class="fas fa-utensils text-primary me-2"></i>
                <span class="fw-bold">SMK Resto</span>
            </a>

            <div class="d-flex align-items-center order-lg-2">
                @if (Session::has('idpelanggan'))
                    <a href="{{ url('cart') }}" class="btn btn-light rounded-circle me-3 position-relative">
                        <i class="fas fa-shopping-cart"></i>
                        @if (session()->has('cart'))
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>

                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @php
                                $pelanggan = session('idpelanggan');
                                $initial = strtoupper(substr($pelanggan['email'], 0, 1));
                                $colors = ['#FF6B35', '#4CAF50', '#2196F3', '#9C27B0', '#FF9800'];
                                $colorIndex = array_rand($colors);
                                $bgColor = $colors[$colorIndex];
                            @endphp

                            @if(!empty($pelanggan['image']))
                                <div class="avatar me-2" style="width: 36px; height: 36px;">
                                    <img src="{{ asset('storage/uploads/pelanggan/' . $pelanggan['image']) }}"
                                         alt="Foto Profil" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            @else
                                <div class="avatar me-2 text-white"
                                     style="width: 36px; height: 36px; background-color: {{ $bgColor }};">
                                    {{ $initial }}
                                </div>
                            @endif
                            <span class="d-none d-md-inline ms-1">{{ session('idpelanggan')['pelanggan'] }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end animate-slideInUp" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ url('profile') }}"><i class="fas fa-user"></i> Profil</a></li>
                            <li><a class="dropdown-item" href="{{ url('order-history') }}"><i class="fas fa-history"></i> Riwayat Pesanan</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ url('logout') }}"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                        </ul>
                    </div>
                @else
                    <a href="{{ url('login') }}" class="btn btn-outline me-2">
                        <i class="fas fa-sign-in-alt me-1"></i> Login
                    </a>
                    <a href="{{ url('register') }}" class="btn btn-primary">
                        <i class="fas fa-user-plus me-1"></i> Register
                    </a>
                @endif

                <button class="navbar-toggler ms-3 border-0" type="button" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                            <i class="fas fa-home me-1"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('menu') ? 'active' : '' }}" href="{{ url('menu') }}">
                            <i class="fas fa-hamburger me-1"></i> Menu
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-th-list me-1"></i> Kategori
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                            @foreach ($kategoris as $kategori)
                                <li>
                                    <a class="dropdown-item" href="{{ url('kategori/'.$kategori->idkategori) }}">
                                        <i class="{{ $kategori->icon ?? 'fas fa-utensils' }}"></i> {{ $kategori->kategori }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#footer">
                            <i class="fas fa-info-circle me-1"></i> Tentang Kami
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="page-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="p-4">
                @if (session()->has('idpelanggan'))
                    <div class="user-info">
                        <div class="d-flex align-items-center mb-3">
                            @php
                                $pelanggan = session('idpelanggan');
                                $initial = strtoupper(substr($pelanggan['email'], 0, 1));
                                $colors = ['#FF6B35', '#4CAF50', '#2196F3', '#9C27B0', '#FF9800'];
                                $colorIndex = array_rand($colors);
                                $bgColor = $colors[$colorIndex];
                            @endphp

                            @if(!empty($pelanggan['image']))
                                <div class="avatar" style="width: 48px; height: 48px;">
                                    <img src="{{ asset('storage/uploads/pelanggan/' . $pelanggan['image']) }}"
                                         alt="Foto Profil" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            @else
                                <div class="avatar text-white d-flex align-items-center justify-content-center"
                                     style="width: 48px; height: 48px; background-color: {{ $bgColor }};">
                                    {{ $initial }}
                                </div>
                            @endif
                            <div class="ms-3">
                                <h6 class="mb-0 fw-bold">{{ session('idpelanggan')['pelanggan'] }}</h6>
                                <small class="text-muted">{{ session('idpelanggan')['email'] }}</small>
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <a href="{{ url('profile') }}" class="btn btn-sm btn-primary w-100">
                                <i class="fas fa-user-edit me-2"></i> Edit Profil
                            </a>
                            <a href="{{ url('logout') }}" class="btn btn-sm btn-outline w-100">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </div>
                    </div>
                @else
                    <div class="d-grid gap-2 mb-4">
                        <a href="{{ url('login') }}" class="btn btn-outline w-100">
                            <i class="fas fa-sign-in-alt me-2"></i> Login
                        </a>
                        <a href="{{ url('register') }}" class="btn btn-primary w-100">
                            <i class="fas fa-user-plus me-2"></i> Register
                        </a>
                    </div>
                @endif

                <h6 class="sidebar-heading d-flex align-items-center mt-4 mb-3">
                    <i class="fas fa-compass me-2"></i> Menu Utama
                </h6>
                <ul class="nav flex-column gap-1">
                    <li class="nav-item">
                        <a href="{{ url('/') }}" class="sidebar-link {{ request()->is('/') ? 'active' : '' }}">
                            <i class="fas fa-home"></i>
                            <span class="ms-3">Beranda</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('menu') }}" class="sidebar-link {{ request()->is('menu') ? 'active' : '' }}">
                            <i class="fas fa-utensils"></i>
                            <span class="ms-3">Semua Menu</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('cart') }}" class="sidebar-link {{ request()->is('cart') ? 'active' : '' }}">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="ms-3">Keranjang</span>
                            @if (session()->has('cart'))
                            <span class="badge bg-primary rounded-pill ms-auto">{{ count(session('cart')) }}</span>
                            @endif
                        </a>
                    </li>
                    @if (Session::has('idpelanggan'))
                    <li class="nav-item">
                        <a href="{{ url('order-history') }}" class="sidebar-link {{ request()->is('order-history') ? 'active' : '' }}">
                            <i class="fas fa-history"></i>
                            <span class="ms-3">Riwayat Pesanan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('profile') }}" class="sidebar-link {{ request()->is('profile') ? 'active' : '' }}">
                            <i class="fas fa-user"></i>
                            <span class="ms-3">Profil</span>
                        </a>
                    </li>
                    @endif
                </ul>

                <!-- Kategori Menu -->
                <h6 class="sidebar-heading d-flex align-items-center mt-4 mb-3">
                    <i class="fas fa-tags me-2"></i> Kategori Menu
                </h6>
                <ul class="nav flex-column category-menu gap-1">
                    @foreach ($kategoris as $kategori)
                        <li class="nav-item">
                            <a href="{{ url('kategori/'.$kategori->idkategori) }}"
                               class="sidebar-link {{ request()->is('kategori/'.$kategori->idkategori) ? 'active' : '' }}">
                                <i class="{{ $kategori->icon ?? 'fas fa-utensils' }}"></i>
                                <span class="ms-3">{{ $kategori->kategori }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="content-wrapper">
                <div class="content-card animate-fadeIn">
                    @yield('content')
                    @yield('isi')
                </div>
            </div>

            <!-- Footer -->
            <footer class="footer border-top" id="footer">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 mb-4 mb-md-0">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-utensils text-primary me-2" style="font-size: 1.5rem;"></i>
                                <h5 class="mb-0 text-primary fw-bold">SMK Resto</h5>
                            </div>
                            <p class="text-muted">Restoran modern dengan cita rasa autentik. Nikmati pengalaman kuliner terbaik dengan menu-menu pilihan kami.</p>
                            <div class="social-links mt-3">
                                <a href="#" class="btn btn-light rounded-circle me-2"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class="btn btn-light rounded-circle me-2"><i class="fab fa-instagram"></i></a>
                                <a href="#" class="btn btn-light rounded-circle me-2"><i class="fab fa-twitter"></i></a>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4 mb-md-0">
                            <h6 class="fw-bold mb-3">Menu Utama</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="{{ url('/') }}" class="text-decoration-none"><i class="fas fa-chevron-right me-2 small text-primary"></i>Home</a></li>
                                <li class="mb-2"><a href="{{ url('menu') }}" class="text-decoration-none"><i class="fas fa-chevron-right me-2 small text-primary"></i>Menu</a></li>
                                <li class="mb-2"><a href="#" class="text-decoration-none"><i class="fas fa-chevron-right me-2 small text-primary"></i>Kategori</a></li>
                                <li class="mb-2"><a href="#" class="text-decoration-none"><i class="fas fa-chevron-right me-2 small text-primary"></i>Tentang Kami</a></li>
                            </ul>
                        </div>
                        <div class="col-md-5">
                            <h6 class="fw-bold mb-3">Kontak</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-map-marker-alt me-3 mt-1 text-primary"></i>
                                    <span>Jl. Pendidikan No. 123, Kota Malang, Jawa Timur, Indonesia</span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-phone me-3 mt-1 text-primary"></i>
                                    <span>(021) 1234-5678</span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-envelope me-3 mt-1 text-primary"></i>
                                    <span>info@smkresto.com</span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-clock me-3 mt-1 text-primary"></i>
                                    <div>
                                        <div>Senin - Jumat: 08.00 - 22.00</div>
                                        <div>Sabtu - Minggu: 10.00 - 23.00</div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                        <p class="mb-2 mb-md-0 text-muted">© {{ date('Y') }} SMK Resto. All rights reserved.</p>
                        <div>
                            <a href="#" class="text-decoration-none me-3">Kebijakan Privasi</a>
                            <a href="#" class="text-decoration-none">Syarat & Ketentuan</a>
                        </div>
                    </div>
                </div>
            </footer>
        </main>
    </div>

    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar toggle
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.querySelector('.main-content');
            const contentWrapper = document.querySelector('.content-wrapper');
            const footer = document.querySelector('.footer');

            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');

                if (window.innerWidth < 992) {
                    contentWrapper.classList.toggle('sidebar-open');
                    footer.classList.toggle('sidebar-open');
                }
            });

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth < 992 &&
                    !sidebar.contains(event.target) &&
                    !sidebarToggle.contains(event.target) &&
                    sidebar.classList.contains('show')) {
                    sidebar.classList.remove('show');
                    contentWrapper.classList.remove('sidebar-open');
                    footer.classList.remove('sidebar-open');
                }
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 992) {
                    contentWrapper.classList.remove('sidebar-open');
                    footer.classList.remove('sidebar-open');
                }
            });

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    </script>
</body>
</html>
