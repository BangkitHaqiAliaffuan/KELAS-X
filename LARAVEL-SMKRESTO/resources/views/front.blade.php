<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aplikasi Restoran SMK</title>
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            border-radius: 8px;
            padding: 0.5rem 1rem;
        }

        .navbar-brand img {
            transition: transform 0.3s ease;
        }

        .navbar-brand img:hover {
            transform: scale(1.05);
        }

        .nav-link {
            color: #495057;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: color 0.2s ease;
        }

        .nav-link:hover {
            color: #0d6efd;
        }

        .list-group-item {
            border-left: none;
            border-right: none;
            padding: 0.75rem 1.25rem;
            transition: background-color 0.2s ease;
        }

        .list-group-item:first-child {
            border-top: none;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .list-group-item:last-child {
            border-bottom: none;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        .list-group-item:hover {
            background-color: #f1f3f5;
        }

        .list-group-item a {
            color: #495057;
            text-decoration: none;
            display: block;
        }

        .list-group-item a:hover {
            color: #0d6efd;
        }

        .main-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 1.5rem;
            min-height: 400px;
        }

        .footer {
            padding: 1rem;
            border-top: 1px solid #dee2e6;
            border-radius: 0 0 8px 8px;
            margin-top: 2rem;
        }

        .footer p {
            margin-bottom: 0;
            color: #6c757d;
        }

        .cart-badge {
            background-color: #0d6efd;
            color: white;
            border-radius: 50%;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg bg-white mb-4">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">
                    <img style="width: 80px" src="{{ asset('gambar/LOGO.png') }}" alt="Logo Restoran">
                </a>
                <div class="ms-auto">
                    <ul class="navbar-nav d-flex flex-row gap-4 align-items-center">
                        @if (session()->has('cart'))
                            <li class="nav-item">
                                <a href="{{ url('cart') }}" class="nav-link d-flex align-items-center">
                                    <span>Cart</span>
                                    <span class="cart-badge ms-2">
                                        @php
                                            $count = count(session('cart'));
                                            echo $count;
                                        @endphp
                                    </span>
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ url('cart') }}" class="nav-link">Cart</a>
                            </li>
                        @endif

                        @if (session()->missing('idpelanggan'))
                            <li class="nav-item">
                                <a href="{{ url('register') }}" class="nav-link">Register</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('login') }}" class="nav-link">Login</a>
                            </li>
                        @endif

                        @if (session()->has('idpelanggan'))
                            <li class="nav-item">
                                <span class="nav-link">{{ session('idpelanggan')['email'] }}</span>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('logout') }}" class="nav-link">Logout</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 mb-4">
                <div class="bg-white rounded shadow-sm">
                    <h5 class="p-3 border-bottom">Kategori Menu</h5>
                    <ul class="list-group list-group-flush">
                        @foreach ($kategoris as $kategori)
                            <li class="list-group-item">
                                <a href="{{ url('show/' . $kategori->idkategori) }}">
                                    {{ $kategori->kategori }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Content Area -->
            <div class="col-md-9 col-lg-10">
                <div class="main-container">
                    @yield('content')
                    @yield('isi')
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer text-center bg-white">
            <p>© 2025 Aplikasi Restoran SMK - smkrevit.com</p>
        </footer>
    </div>

    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
