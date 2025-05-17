@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <!-- Hero Section -->
    <section class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="relative">
            <img src="{{ asset('gambar/uni.jpeg') }}" alt="Banner" class="w-full h-64 md:h-96 object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                <div class="text-center px-4">
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Selamat Datang di Hambridhe</h1>
                    <p class="text-xl text-white mb-6">Pusat Pendidikan Terbaik untuk Masa Depan Anda</p>
                    <a href="{{ url('/kontak') }}" class="bg-white text-gray-900 hover:bg-gray-100 px-6 py-3 rounded-lg font-semibold transition duration-300">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="mt-12">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">Kenapa Memilih Kami?</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                <div class="bg-blue-100 w-16 h-16 mx-auto rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-graduation-cap text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3">Pendidikan Berkualitas</h3>
                <p class="text-gray-600">Kami menyediakan layanan pendidikan berkualitas dengan tenaga pengajar profesional.</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                <div class="bg-green-100 w-16 h-16 mx-auto rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-users text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3">Komunitas Inspiratif</h3>
                <p class="text-gray-600">Bergabunglah dengan komunitas pelajar yang saling mendukung dan inspiratif.</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                <div class="bg-purple-100 w-16 h-16 mx-auto rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-laptop text-purple-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3">Fasilitas Modern</h3>
                <p class="text-gray-600">Fasilitas modern untuk mendukung proses belajar yang efektif dan nyaman.</p>
            </div>
        </div>
    </section>

    <!-- Latest News Section -->
    <section class="mt-16">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-800">Berita Terbaru</h2>
            <a href="#" class="text-blue-600 hover:underline">Lihat Semua</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <img src="/api/placeholder/400/200" alt="News 1" class="w-full h-48 object-cover">
                <div class="p-5">
                    <p class="text-sm text-gray-500 mb-2">15 Maret 2025</p>
                    <h3 class="text-xl font-semibold mb-3">Pembukaan Pendaftaran Tahun Ajaran Baru</h3>
                    <p class="text-gray-600 mb-4">Telah dibuka pendaftaran untuk tahun ajaran baru 2025/2026 untuk semua jurusan.</p>
                    <a href="#" class="text-blue-600 hover:underline">Baca Selengkapnya</a>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <img src="/api/placeholder/400/200" alt="News 2" class="w-full h-48 object-cover">
                <div class="p-5">
                    <p class="text-sm text-gray-500 mb-2">10 Maret 2025</p>
                    <h3 class="text-xl font-semibold mb-3">Seminar Teknologi Terkini</h3>
                    <p class="text-gray-600 mb-4">Seminar tentang perkembangan teknologi AI dan penerapannya dalam berbagai bidang.</p>
                    <a href="#" class="text-blue-600 hover:underline">Baca Selengkapnya</a>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <img src="/api/placeholder/400/200" alt="News 3" class="w-full h-48 object-cover">
                <div class="p-5">
                    <p class="text-sm text-gray-500 mb-2">5 Maret 2025</p>
                    <h3 class="text-xl font-semibold mb-3">Kerjasama dengan Industri</h3>
                    <p class="text-gray-600 mb-4">Penandatanganan MoU dengan beberapa perusahaan untuk program magang mahasiswa.</p>
                    <a href="#" class="text-blue-600 hover:underline">Baca Selengkapnya</a>
                </div>
            </div>
        </div>
    </section>
@endsection
