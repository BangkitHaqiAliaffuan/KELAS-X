@extends('front')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h2 class="fw-bold mb-3">Menu Kami</h2>
        <p class="text-muted">Pilihan menu terbaik untuk Anda</p>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        @foreach ($menus as $menu)
        <div class="col">
            <div class="card h-100 border-0 shadow-sm">
                <div class="position-relative">
                    <img src="{{ asset('gambar/'.$menu->gambar) }}" class="card-img-top" alt="{{ $menu->menu }}" style="height: 180px; object-fit: cover; border-radius: 8px 8px 0 0;">
                    <div class="position-absolute top-0 end-0 m-2">
                        <span class="badge bg-primary rounded-pill px-3 py-2">{{ $menu->kategori->kategori ?? 'Menu' }}</span>
                    </div>
                </div>

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold mb-2">{{ $menu->menu }}</h5>
                    <p class="card-text text-muted mb-3" style="height: 60px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
                        {{ $menu->deskripsi }}
                    </p>
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold text-primary mb-0">Rp {{ number_format($menu->harga, 0, ',', '.') }}</h5>
                            <a href="{{ url('beli/'.$menu->idmenu) }}" class="btn btn-primary px-4 rounded-pill">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus me-1" viewBox="0 0 16 16">
                                    <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
                                    <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                </svg>
                                Beli
                            </a>
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
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

    .card-img-top {
        transition: transform 0.5s ease;
    }

    .card:hover .card-img-top {
        transform: scale(1.05);
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

    .badge {
        font-weight: 500;
        letter-spacing: 0.5px;
        box-shadow: 0 3px 5px rgba(0,0,0,0.1);
    }

    .pagination {
        gap: 5px;
    }

    .page-item .page-link {
        border-radius: 5px;
        color: #0d6efd;
        border: 1px solid #dee2e6;
        padding: 0.5rem 0.75rem;
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
