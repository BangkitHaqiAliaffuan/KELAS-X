@extends('layouts.app')

@section('title', 'Kontak')

@section('content')
    <div class="container">
        <h1>Hubungi Kami</h1>
        <div class="contact-container">
            <div class="contact-info">
                <h2>Informasi Kontak</h2>
                <p><strong>Alamat:</strong> Jl. Contoh No. 123, Kota, Kode Pos</p>
                <p><strong>Telepon:</strong> (021) 1234-5678</p>
                <p><strong>Email:</strong> info@example.com</p>
                <p><strong>Jam Operasional:</strong> Senin-Jumat, 08.00-16.00</p>
            </div>
            <div class="contact-form">
                <h2>Kirim Pesan</h2>
                <form>
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="subject">Subjek</label>
                        <input type="text" id="subject" name="subject" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Pesan</label>
                        <textarea id="message" name="message" required></textarea>
                    </div>
                    <button type="submit" class="btn">Kirim Pesan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
