@extends('layouts.app')

@section('title', 'Kontak')

@section('content')
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="relative">
            <img src="{{ asset('gambar/kontak.jpg') }}" alt="Contact Banner" class="w-full h-48 md:h-64 object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center">
                <div class="container mx-auto px-4">
                    <h1 class="text-3xl md:text-4xl font-bold text-white">Hubungi Kami</h1>
                </div>
            </div>
        </div>

        <div class="p-6 md:p-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Contact Form -->
                <div class="lg:col-span-2">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Kirim Pesan</h2>

                    <form action="" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
                                <input type="text" id="name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>

                            <div>
                                <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                                <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>
                        </div>

                        <div>
                            <label for="subject" class="block text-gray-700 font-medium mb-2">Subjek</label>
                            <input type="text" id="subject" name="subject" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>

                        <div>
                            <label for="message" class="block text-gray-700 font-medium mb-2">Pesan</label>
                            <textarea id="message" name="message" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                        </div>

                        <div>
                            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">Kirim Pesan</button>
                        </div>
                    </form>
                </div>

                <!-- Contact Information -->
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Informasi Kontak</h2>

                    <div class="space-y-8">
                        <div class="flex items-start">
                            <div class="bg-blue-100 p-3 rounded-full mr-4">
                                <i class="fas fa-map-marker-alt text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-1">Alamat</h3>
                                <p class="text-gray-600">Jl. Pendidikan No. 123, Jakarta Selatan, DKI Jakarta, Indonesia 12345</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-blue-100 p-3 rounded-full mr-4">
                                <i class="fas fa-phone-alt text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-1">Telepon</h3>
                                <p class="text-gray-600">+62 123 4567 890</p>
                                <p class="text-gray-600">+62 098 7654 321</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-blue-100 p-3 rounded-full mr-4">
                                <i class="fas fa-envelope text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-1">Email</h3>
                                <p class="text-gray-600">info@yourbrand.com</p>
                                <p class="text-gray-600">admissions@yourbrand.com</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-blue-100 p-3 rounded-full mr-4">
                                <i class="fas fa-clock text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-1">Jam Operasional</h3>
                                <p class="text-gray-600">Senin - Jumat: 08:00 - 16:00</p>
                                <p class="text-gray-600">Sabtu: 09:00 - 13:00</p>
                                <p class="text-gray-600">Minggu: Tutup</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="font-semibold text-gray-800 mb-4">Ikuti Kami</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="bg-gray-100 hover:bg-gray-200 p-3 rounded-full transition">
                                <i class="fab fa-facebook-f text-gray-700"></i>
                            </a>
                            <a href="#" class="bg-gray-100 hover:bg-gray-200 p-3 rounded-full transition">
                                <i class="fab fa-twitter text-gray-700"></i>
                            </a>
                            <a href="#" class="bg-gray-100 hover:bg-gray-200 p-3 rounded-full transition">
                                <i class="fab fa-instagram text-gray-700"></i>
                            </a>
                            <a href="#" class="bg-gray-100 hover:bg-gray-200 p-3 rounded-full transition">
                                <i class="fab fa-linkedin-in text-gray-700"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Map -->
            <div class="mt-12">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Lokasi Kami</h2>
                <div class="bg-gray-100 rounded-lg w-full h-80 flex items-center justify-center">
                    <p class="text-gray-500">Peta Lokasi YourBrand akan ditampilkan di sini</p>
                    <!-- Tambahkan integrasi Google Maps atau peta lainnya di sini -->
                </div>
            </div>
        </div>
    </div>
@endsection
