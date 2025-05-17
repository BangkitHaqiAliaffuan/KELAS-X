@extends('layouts.app')

@section('title', 'Jurusan')

@section('content')
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="relative">
            <img src="{{ asset('gambar/uni.jpeg') }}" alt="Departments Banner" class="w-full h-48 md:h-64 object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center">
                <div class="container mx-auto px-4">
                    <h1 class="text-3xl md:text-4xl font-bold text-white">Jurusan</h1>
                </div>
            </div>
        </div>

        <div class="p-6 md:p-8">
            <p class="text-gray-600 mb-8 max-w-3xl">
                YourBrand menyediakan berbagai jurusan yang dirancang untuk memenuhi kebutuhan industri saat ini dan masa depan. Setiap jurusan dilengkapi dengan kurikulum yang komprehensif dan fasilitas pendukung yang memadai.
            </p>

            <!-- Technology Department -->
            <div class="mb-12 border-b border-gray-200 pb-10">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="md:col-span-1">
                        <img src="{{ asset('gambar/teknologi.jpeg') }}" alt="Teknologi" class="w-full h-56 object-cover rounded-lg shadow-sm">
                    </div>

                    <div class="md:col-span-2">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Teknologi Informasi</h2>
                        <p class="text-gray-600 mb-4">
                            Jurusan Teknologi Informasi dirancang untuk membekali mahasiswa dengan keterampilan dalam bidang pengembangan perangkat lunak, keamanan siber, analisis data, dan teknologi jaringan. Mahasiswa akan mempelajari berbagai bahasa pemrograman, metodologi pengembangan perangkat lunak, dan teknologi terkini.
                        </p>

                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Program Studi:</h3>
                        <ul class="list-disc list-inside text-gray-600 mb-6 space-y-1">
                            <li>Teknik Informatika</li>
                            <li>Sistem Informasi</li>
                            <li>Keamanan Siber</li>
                            <li>Data Science</li>
                        </ul>

                        <a href="#" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">Detail Jurusan</a>
                    </div>
                </div>
            </div>

            <!-- Business Department -->
            <div class="mb-12 border-b border-gray-200 pb-10">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="md:col-span-1">
                        <img src="{{ asset('gambar/bisnis.jpeg') }}" alt="Bisnis" class="w-full h-56 object-cover rounded-lg shadow-sm">
                    </div>

                    <div class="md:col-span-2">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Bisnis dan Manajemen</h2>
                        <p class="text-gray-600 mb-4">
                            Jurusan Bisnis dan Manajemen mempersiapkan mahasiswa untuk dunia bisnis yang dinamis dengan pengetahuan tentang manajemen, pemasaran, keuangan, dan kewirausahaan. Kurikulum dirancang dengan pendekatan praktis dan teori yang seimbang.
                        </p>

                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Program Studi:</h3>
                        <ul class="list-disc list-inside text-gray-600 mb-6 space-y-1">
                            <li>Manajemen Bisnis</li>
                            <li>Akuntansi</li>
                            <li>Pemasaran Digital</li>
                            <li>Kewirausahaan</li>
                        </ul>

                        <a href="#" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">Detail Jurusan</a>
                    </div>
                </div>
            </div>

            <!-- Design Department -->
            <div class="mb-12 border-b border-gray-200 pb-10">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="md:col-span-1">
                        <img src="{{ asset('gambar/perhotelan.jpg') }}" alt="Desain" class="w-full h-56 object-cover rounded-lg shadow-sm">
                    </div>

                    <div class="md:col-span-2">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Desain dan Komunikasi Visual</h2>
                        <p class="text-gray-600 mb-4">
                            Jurusan Desain dan Komunikasi Visual mengembangkan kreativitas dan kemampuan teknis mahasiswa dalam menciptakan karya visual yang efektif dan estetis. Mahasiswa akan belajar tentang prinsip desain, tipografi, ilustrasi, dan berbagai software desain profesional.
                        </p>

                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Program Studi:</h3>
                        <ul class="list-disc list-inside text-gray-600 mb-6 space-y-1">
                            <li>Desain Grafis</li>
                            <li>Desain UI/UX</li>
                            <li>Animasi Digital</li>
                            <li>Fotografi</li>
                        </ul>

                        <a href="#" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">Detail Jurusan</a>
                    </div>
                </div>
            </div>

            <!-- Hospitality Department -->
            <div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="md:col-span-1">
                        <img src="{{ asset('gambar/perhotelan.jpg') }}" alt="Perhotelan" class="w-full h-56 object-cover rounded-lg shadow-sm">
                    </div>

                    <div class="md:col-span-2">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Perhotelan dan Pariwisata</h2>
                        <p class="text-gray-600 mb-4">
                            Jurusan Perhotelan dan Pariwisata menyiapkan mahasiswa untuk berkarir di industri hospitality yang berkembang pesat. Kurikulum mencakup manajemen hotel, manajemen acara, kuliner, dan pengembangan pariwisata dengan pendekatan yang berorientasi pada pelayanan dan pengalaman pelanggan.
                        </p>

                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Program Studi:</h3>
                        <ul class="list-disc list-inside text-gray-600 mb-6 space-y-1">
                            <li>Manajemen Perhotelan</li>
                            <li>Seni Kuliner</li>
                            <li>Manajemen Acara</li>
                            <li>Pariwisata Berkelanjutan</li>
                        </ul>

                        <a href="#" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">Detail Jurusan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
