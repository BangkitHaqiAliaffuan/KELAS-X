@extends('layouts.app')

@section('title', 'Jurusan')

@section('content')
    <div class="container">
        <h1>Jurusan</h1>
        <div class="departments">
            <div class="department-item">
                <h2>Teknik Informatika</h2>
                <p>Program studi yang mempelajari prinsip-prinsip ilmu komputer dan penerapannya dalam teknologi.</p>
                <ul>
                    <li>Pemrograman</li>
                    <li>Jaringan Komputer</li>
                    <li>Kecerdasan Buatan</li>
                    <li>Pengembangan Web & Mobile</li>
                </ul>
            </div>

            <div class="department-item">
                <h2>Sistem Informasi</h2>
                <p>Program studi yang mempelajari integrasi teknologi informasi dengan proses bisnis.</p>
                <ul>
                    <li>Analisis Sistem</li>
                    <li>Database Management</li>
                    <li>Bisnis Digital</li>
                    <li>Enterprise Resource Planning</li>
                </ul>
            </div>

            <div class="department-item">
                <h2>Manajemen Bisnis</h2>
                <p>Program studi yang mempelajari teori dan praktik manajemen dalam konteks bisnis.</p>
                <ul>
                    <li>Manajemen Strategis</li>
                    <li>Pemasaran</li>
                    <li>Keuangan</li>
                    <li>Sumber Daya Manusia</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
