<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Website Anda</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="text-2xl font-bold text-gray-800">
                    <a href="{{ url('/') }}">Hambrigde</a>
                </div>

                <nav class="hidden md:flex space-x-8">
                    <a href="{{ url('/') }}" class="text-gray-600 hover:text-gray-900 transition">Home</a>
                    <a href="{{ url('profil') }}" class="text-gray-600 hover:text-gray-900 transition">Profil</a>
                    <a href="{{ url('jurusan') }}" class="text-gray-600 hover:text-gray-900 transition">Jurusan</a>
                    <a href="{{ url('kontak') }}" class="text-gray-600 hover:text-gray-900 transition">Kontak</a>
                </nav>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-gray-500 hover:text-gray-900 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile menu -->
            <div id="mobile-menu" class="md:hidden hidden mt-4 pb-2">
                <a href="{{ url('/') }}" class="block py-2 text-gray-600 hover:text-gray-900">Home</a>
                <a href="{{ url('profil') }}" class="block py-2 text-gray-600 hover:text-gray-900">Profil</a>
                <a href="{{ url('jurusan') }}" class="block py-2 text-gray-600 hover:text-gray-900">Jurusan</a>
                <a href="{{ url('kontak') }}" class="block py-2 text-gray-600 hover:text-gray-900">Kontak</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-16">
        <div class="container mx-auto px-4 py-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-semibold mb-4">Hambrigde</h3>
                    <p class="text-gray-300">Menghadirkan solusi pendidikan berkualitas untuk masa depan yang lebih baik.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Tautan</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ url('/') }}" class="text-gray-300 hover:text-white transition">Home</a></li>
                        <li><a href="{{ url('/profil') }}" class="text-gray-300 hover:text-white transition">Profil</a></li>
                        <li><a href="{{ url('/jurusan') }}" class="text-gray-300 hover:text-white transition">Jurusan</a></li>
                        <li><a href="{{ url('/kontak') }}" class="text-gray-300 hover:text-white transition">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Hubungi Kami</h3>
                    <div class="space-y-2 text-gray-300">
                        <p><i class="fas fa-map-marker-alt mr-2"></i> Jl. Pendidikan No. 123, Jakarta</p>
                        <p><i class="fas fa-phone-alt mr-2"></i> +62 123 4567 890</p>
                        <p><i class="fas fa-envelope mr-2"></i> info@Hambrigde.com</p>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Hambrigde. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>
</body>
</html>
