@extends('front')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h2 class="fw-bold mb-3">Menu Kami</h2>
        <p class="text-muted">Pilihan menu terbaik untuk Anda</p>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach ($menus as $menu)
        <div class="col">
            <div class="card h-100 border-0 shadow-sm">
                <div class="position-relative">
                    <img src="{{ asset('gambar/'.$menu->gambar) }}" class="card-img-top" alt="{{ $menu->menu }}" style="height: 200px; object-fit: cover; border-radius: 8px 8px 0 0;">
                </div>

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold mb-2">{{ $menu->menu }}</h5>
                    <p class="card-text text-muted mb-3" style="height: 60px; overflow: hidden;">{{ $menu->deskripsi }}</p>
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold text-primary mb-0">Rp {{ number_format($menu->harga, 0, ',', '.') }}</h5>
                            <a href="{{ url('beli/'.$menu->idmenu) }}" class="btn btn-primary px-4 rounded-pill">Beli</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-5">
        {{ $menus->links() }}
    </div>
</div>

<style>
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

    .btn-primary {
        background-color: #0d6efd;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
        transform: scale(1.05);
    }

    .pagination {
        gap: 5px;
    }

    .page-item .page-link {
        border-radius: 5px;
        color: #0d6efd;
        border: 1px solid #dee2e6;
    }

    .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .page-item.disabled .page-link {
        color: #6c757d;
        background-color: #fff;
        border-color: #dee2e6;
    }
</style>
@endsection
