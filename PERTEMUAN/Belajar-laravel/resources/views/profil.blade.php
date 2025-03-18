@extends('layouts.app')

@section('title', 'Profil')

@section('content')
    <div class="container">
        <h1>Profil Kami</h1>
        <div class="profile-content">
            <div class="profile-image">
                <img src="{{ asset('images/bakso.jpeg') }}" alt="Profil Institusi">
            </div>
            <div class="profile-text">
                <h2>Tentang Kami</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris. Vivamus hendrerit arcu sed erat molestie vehicula.</p>

                <h2>Visi</h2>
                <p>Menjadi institusi pendidikan terkemuka yang menghasilkan lulusan berkualitas.</p>

                <h2>Misi</h2>
                <ul>
                    <li>Menyelenggarakan pendidikan berkualitas</li>
                    <li>Mengembangkan penelitian dan inovasi</li>
                    <li>Berkontribusi dalam pengembangan masyarakat</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
