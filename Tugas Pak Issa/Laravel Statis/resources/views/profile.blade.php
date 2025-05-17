@extends('layouts.app')

@section('title', 'Profil')

@section('content')
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="relative">
            <img src="{{ asset('gambar/jurusan.jpeg') }}" alt="Profile Banner" class="w-full h-48 md:h-64 object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center">
                <div class="container mx-auto px-4">
                    <h1 class="text-3xl md:text-4xl font-bold text-white">Profil YourBrand</h1>
                </div>
            </div>
        </div>

        <div class="p-6 md:p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Sejarah Singkat</h2>
                    <p class="text-gray-600 mb-4">
                        YourBrand didirikan pada tahun 2005 dengan visi untuk menghadirkan pendidikan berkualitas yang dapat diakses oleh semua kalangan. Berawal dari sebuah lembaga kecil, kini YourBrand telah berkembang menjadi salah satu institusi pendidikan terkemuka di Indonesia.
                    </p>
                    <p class="text-gray-600">
                        Selama perjalanannya, YourBrand telah menghasilkan ribuan lulusan berkualitas yang tersebar di berbagai sektor industri, baik di dalam maupun luar negeri. Keberhasilan para alumni menjadi bukti nyata komitmen YourBrand dalam memberikan pendidikan yang berkualitas.
                    </p>
                </div>

                <div>
                    <img src="{{ asset('gambar/uni.jpeg') }}" alt="Campus" class="w-full h-64 object-cover rounded-lg shadow-sm">
                </div>
            </div>

            <div class="mt-12">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Visi & Misi</h2>

                <div class="bg-gray-50 p-6 rounded-lg mb-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Visi</h3>
                    <p class="text-gray-600">
                        Menjadi pusat pendidikan terdepan yang menghasilkan lulusan berkualitas, berintegritas, dan mampu bersaing secara global.
                    </p>
                </div>

                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Misi</h3>
                    <ul class="list-disc list-inside text-gray-600 space-y-2">
                        <li>Menyelenggarakan pendidikan yang berkualitas, inovatif, dan relevan dengan kebutuhan industri.</li>
                        <li>Melaksanakan penelitian yang berorientasi pada pengembangan ilmu pengetahuan dan teknologi.</li>
                        <li>Mengembangkan lingkungan belajar yang kondusif untuk mendukung pengembangan potensi peserta didik.</li>
                        <li>Menjalin kerjasama dengan berbagai instansi dan lembaga, baik dalam maupun luar negeri.</li>
                        <li>Memberikan kontribusi nyata bagi pengembangan masyarakat melalui program pengabdian.</li>
                    </ul>
                </div>
            </div>

            <div class="mt-12">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Tim Kami</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white border border-gray-100 rounded-lg shadow-sm overflow-hidden text-center">
                        <img src="{{ asset('gambar/dr1.jpg') }}" alt="Person 1" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-800">Dr. Ahmad Subagyo</h3>
                            <p class="text-blue-600">Direktur</p>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-100 rounded-lg shadow-sm overflow-hidden text-center">
                        <img src="{{ asset('gambar/dr2.jpg') }}" alt="Person 2" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-800">Dr. Siti Rahayu</h3>
                            <p class="text-blue-600">Wakil Direktur</p>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-100 rounded-lg shadow-sm overflow-hidden text-center">
                        <img src="{{ asset('gambar/dr3.jpg') }}" alt="Person 3" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-800">Prof. Budi Santoso</h3>
                            <p class="text-blue-600">Kepala Akademik</p>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-100 rounded-lg shadow-sm overflow-hidden text-center">
                        <img src="{{ asset('gambar/dr4.jpg') }}" alt="Person 4" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-800">Dr. Maya Indira</h3>
                            <p class="text-blue-600">Kepala Penelitian</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
