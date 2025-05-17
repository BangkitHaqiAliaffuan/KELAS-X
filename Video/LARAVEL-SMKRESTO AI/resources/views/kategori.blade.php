@extends('front')

@section('content')
<div class="container-fluid px-0">
    <div class="row">
        <div class="col-12 mb-5">
            <div class="d-flex align-items-center mb-4">
                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                    <i class="fas fa-tags text-white"></i>
                </div>
                <div>
                    <h2 class="fw-bold mb-1">{{ $kategori->kategori ?? 'Menu Kategori' }}</h2>
                    <p class="text-muted mb-0">Pilihan menu terbaik untuk Anda</p>
                </div>
            </div>

            <!-- Search bar -->
            <div class="row mb-4">
                <div class="col-md-8 col-lg-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" id="searchMenu" placeholder="Cari menu dalam kategori ini...">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 menu-container">
        @foreach ($menus as $menu)
        <div class="col menu-item animate-fadeIn"
             data-name="{{ $menu->menu }}"
             style="animation-delay: {{ $loop->index * 0.1 }}s">
            <div class="menu-card h-100">
                <div class="position-relative overflow-hidden">
                    <img src="{{ asset('gambar/'.$menu->gambar) }}" class="card-img-top" alt="{{ $menu->menu }}"
                         style="height: 200px; object-fit: cover;">
                    <div class="position-absolute top-0 end-0 m-2">
                        <span class="badge bg-secondary rounded-pill px-3 py-2 shadow-sm">
                            {{ $menu->kategori->kategori ?? 'Menu' }}
                        </span>
                    </div>
                    <div class="position-absolute bottom-0 start-0 w-100 p-3 text-center"
                         style="background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);">
                        <h5 class="menu-card-title text-white mb-0">{{ $menu->menu }}</h5>
                    </div>
                </div>

                <div class="menu-card-body d-flex flex-column p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="menu-card-price mb-0">Rp {{ number_format($menu->harga, 0, ',', '.') }}</h5>
                        <div class="menu-rating">
                            @php
                                $rating = rand(3, 5); // Simulating a rating between 3-5
                                $fullStars = floor($rating);
                                $halfStar = $rating - $fullStars >= 0.5;
                            @endphp

                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $fullStars)
                                    <i class="fas fa-star text-warning"></i>
                                @elseif ($halfStar && $i == $fullStars + 1)
                                    <i class="fas fa-star-half-alt text-warning"></i>
                                @else
                                    <i class="far fa-star text-warning"></i>
                                @endif
                            @endfor
                        </div>
                    </div>

                    <p class="menu-card-description mb-3">{{ \Illuminate\Support\Str::limit($menu->deskripsi, 80) }}</p>

                    <div class="mt-auto">
                        <div class="d-grid">
                            <a href="{{ url('beli/'.$menu->idmenu) }}" class="btn btn-secondary">
                                <i class="fas fa-shopping-cart me-2"></i> Tambah ke Keranjang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-5">
        <div class="pagination-container">
            {{ $menus->links() }}
        </div>
    </div>
</div>

<style>
    /* Enhanced pagination styling */
    .pagination-container .pagination {
        gap: 8px;
    }

    .pagination-container .page-item .page-link {
        border-radius: var(--border-radius-full);
        color: var(--gray-700);
        border: 1px solid var(--gray-200);
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 500;
        transition: all var(--transition-fast) ease;
    }

    .pagination-container .page-item .page-link:hover {
        background-color: var(--secondary-light);
        color: var(--secondary);
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }

    .pagination-container .page-item.active .page-link {
        background-color: var(--secondary);
        border-color: var(--secondary);
        color: white;
        box-shadow: var(--shadow);
    }

    .pagination-container .page-item.disabled .page-link {
        color: var(--gray-400);
        background-color: var(--gray-100);
        border-color: var(--gray-200);
        opacity: 0.7;
    }

    /* Menu card enhancements */
    .menu-card {
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .menu-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    .menu-card:hover img {
        transform: scale(1.05);
    }

    .menu-card img {
        transition: transform 0.5s ease;
    }

    .menu-rating {
        font-size: 0.8rem;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchMenu');
        const menuItems = document.querySelectorAll('.menu-item');

        // Search functionality
        searchInput.addEventListener('input', function() {
            const searchTerm = searchInput.value.toLowerCase();

            menuItems.forEach(item => {
                const name = item.dataset.name.toLowerCase();

                if (name.includes(searchTerm)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection
