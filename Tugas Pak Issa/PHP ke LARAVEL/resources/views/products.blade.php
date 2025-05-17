@extends('layouts.app')
@section('content')

<div class="products-container">
    <!-- Filter -->
    <div class="filters-container">
        <div class="filters">
            <a href="{{ route('products', ['filter' => 'all']) }}" class="filter-button {{ $filter == 'all' ? 'active' : '' }}">
                <span>All Games</span>
            </a>
            <a href="{{ route('products', ['filter' => 'new']) }}" class="filter-button {{ $filter == 'new' ? 'active' : '' }}">
                <span>New Releases</span>
            </a>
            <a href="{{ route('products', ['filter' => 'coming']) }}" class="filter-button {{ $filter == 'coming' ? 'active' : '' }}">
                <span>Coming Soon</span>
            </a>
            <a href="{{ route('products', ['filter' => 'free']) }}" class="filter-button {{ $filter == 'free' ? 'active' : '' }}">
                <span>Free to Play</span>
            </a>
        </div>
    </div>

    <!-- Daftar Produk -->
    <div class="game-grid">
        @if($products->isEmpty())
            <div class="no-products">
                <div class="empty-state">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                        <line x1="8" y1="21" x2="16" y2="21"></line>
                        <line x1="12" y1="17" x2="12" y2="21"></line>
                    </svg>
                    <h3>No products available</h3>
                    <p>Try changing your filter criteria or check back later.</p>
                </div>
            </div>
        @else
            <div class="game-cards">
                @foreach($products as $product)
                    <div class="game-card">
                        <a href="{{ route('product.details', $product->id) }}" class="card-link">
                            <div class="card-image-container">
                                <span class="release-status">{{ $product->release_status ?? 'Available Now' }}</span>
                                <img src="{{ asset('uploads/' . $product->image) }}" alt="{{ htmlspecialchars($product->name) }}" loading="lazy">
                                <div class="card-overlay">
                                    <button class="view-details">View Details</button>
                                </div>
                            </div>
                            <div class="card-info">
                                <div class="card-category">{{ $product->category->name }}</div>
                                <h3 class="card-title">{{ htmlspecialchars($product->name) }}</h3>
                                <div class="card-price">
                                    @if($product->price == 0)
                                        <span class="free-tag">Free to Play</span>
                                    @else
                                        @if($product->discount > 0)
                                            <div class="price-container">
                                                <span class="discount">-{{ $product->discount }}%</span>
                                                <span class="original-price">IDR {{ number_format($product->price, 0) }}</span>
                                            </div>
                                            <span class="final-price">IDR {{ number_format($product->price * (1 - ($product->discount / 100)), 0) }}</span>
                                        @else
                                            <span class="final-price">IDR {{ number_format($product->price, 0) }}</span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Paginasi -->
    @if($products->lastPage() > 1)
        <div class="pagination">
            @php
                $range = 2;
                $initial = $products->currentPage() - $range;
                $limit = $products->currentPage() + $range;
            @endphp

            @if($products->onFirstPage())
                <span class="pagination-button disabled">«</span>
            @else
                <a href="{{ $products->previousPageUrl() }}" class="pagination-button">«</a>
            @endif

            @if($initial > 1)
                <a href="{{ $products->url(1) }}" class="pagination-button">1</a>
                @if($initial > 2)
                    <span class="pagination-info">...</span>
                @endif
            @endif

            @for($i = max(1, $initial); $i <= min($products->lastPage(), $limit); $i++)
                @if($i == $products->currentPage())
                    <span class="pagination-button active">{{ $i }}</span>
                @else
                    <a href="{{ $products->url($i) }}" class="pagination-button">{{ $i }}</a>
                @endif
            @endfor

            @if($limit < $products->lastPage())
                @if($limit < $products->lastPage() - 1)
                    <span class="pagination-info">...</span>
                @endif
                <a href="{{ $products->url($products->lastPage()) }}" class="pagination-button">{{ $products->lastPage() }}</a>
            @endif

            @if($products->hasMorePages())
                <a href="{{ $products->nextPageUrl() }}" class="pagination-button">»</a>
            @else
                <span class="pagination-button disabled">»</span>
            @endif

            <span class="pagination-info">Page {{ $products->currentPage() }} of {{ $products->lastPage() }} ({{ $products->total() }} items)</span>
        </div>
    @endif
</div>

<style>
    /* Base Styles */
    body {
        margin: 0;
        padding: 0;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        background: #121212;
        color: white;
    }

    /* Container */
    .products-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }

    /* Filters */
    .filters-container {
        position: sticky;
        top: 0;
        z-index: 10;
        background: rgba(18, 18, 18, 0.95);
        backdrop-filter: blur(10px);
        padding: 15px 0;
        margin-bottom: 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .filters {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .filter-button {
        background: #2a2a2a;
        border: none;
        color: white;
        padding: 10px 18px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        font-weight: 500;
    }

    .filter-button:hover {
        background: #3a3a3a;
        transform: translateY(-2px);
    }

    .filter-button.active {
        background: #0078f2;
        box-shadow: 0 0 15px rgba(0, 120, 242, 0.4);
    }

    /* Game Grid */
    .game-grid {
        margin-bottom: 40px;
    }

    .game-cards {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
    }

    /* Empty State */
    .no-products {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 400px;
    }

    .empty-state {
        text-align: center;
        padding: 40px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        max-width: 400px;
    }

    .empty-state svg {
        color: #888;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        font-size: 20px;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #888;
    }

    /* Game Card */
    .game-card {
        background: #18181b;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        height: 100%;
    }

    .game-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
    }

    .card-link {
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .card-image-container {
        position: relative;
        overflow: hidden;
    }

    .game-card img {
        width: 100%;
        height: 380px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .game-card:hover img {
        transform: scale(1.05);
    }

    .card-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .game-card:hover .card-overlay {
        opacity: 1;
    }

    .view-details {
        background: #0078f2;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transform: translateY(20px);
        transition: all 0.3s ease;
        opacity: 0;
    }

    .game-card:hover .view-details {
        transform: translateY(0);
        opacity: 1;
    }

    .view-details:hover {
        background: #0069d9;
    }

    .release-status {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(0, 0, 0, 0.85);
        color: white;
        padding: 8px 14px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
        backdrop-filter: blur(4px);
        z-index: 1;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    /* Card Info */
    .card-info {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .card-category {
        font-size: 12px;
        color: #888;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .card-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 12px;
        margin-top: 0;
        color: #fff;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-price {
        margin-top: auto;
    }

    .price-container {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 5px;
    }

    .discount {
        background: #0078f2;
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-weight: 600;
        font-size: 14px;
    }

    .original-price {
        text-decoration: line-through;
        color: #888;
        font-size: 14px;
    }

    .final-price {
        font-size: 18px;
        font-weight: 600;
        color: #fff;
    }

    .free-tag {
        background: #2ecc71;
        color: white;
        padding: 6px 10px;
        border-radius: 4px;
        font-weight: 600;
        font-size: 14px;
        display: inline-block;
    }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin: 30px 0;
        padding: 20px;
    }

    .pagination-button {
        background: #2a2a2a;
        border: none;
        color: white;
        padding: 10px 16px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s ease;
        min-width: 40px;
        text-align: center;
        text-decoration: none;
        font-weight: 500;
    }

    .pagination-button:hover {
        background: #3a3a3a;
        transform: translateY(-2px);
    }

    .pagination-button.active {
        background: #0078f2;
        box-shadow: 0 0 15px rgba(0, 120, 242, 0.4);
    }

    .pagination-button.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
    }

    .pagination-info {
        color: #888;
        font-size: 14px;
        margin: 0 15px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .game-cards {
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 15px;
        }

        .game-card img {
            height: 280px;
        }

        .card-info {
            padding: 15px;
        }

        .card-title {
            font-size: 16px;
        }

        .final-price {
            font-size: 16px;
        }

        .pagination {
            padding: 10px;
        }
    }

    @media (max-width: 480px) {
        .game-cards {
            grid-template-columns: 1fr;
        }

        .filters {
            justify-content: center;
        }

        .pagination-info {
            width: 100%;
            text-align: center;
            margin-top: 10px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add hover effect for game cards
        const gameCards = document.querySelectorAll('.game-card');

        gameCards.forEach(card => {
            // Add subtle animation when cards enter viewport
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            setTimeout(() => {
                                entry.target.style.opacity = '1';
                                entry.target.style.transform = 'translateY(0)';
                            }, Math.random() * 300);
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.1 });

                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                observer.observe(card);
            }
        });

        // Smooth scroll to top when changing pages
        const paginationLinks = document.querySelectorAll('.pagination a');
        paginationLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                // Store the scroll position in session storage
                sessionStorage.setItem('scrollPosition', window.scrollY);
            });
        });

        // Check if we need to scroll to top (coming from another page)
        if (performance.navigation.type === 1) {
            // This is a page refresh, not a navigation from pagination
            sessionStorage.removeItem('scrollPosition');
        }
    });
</script>
@endsection

