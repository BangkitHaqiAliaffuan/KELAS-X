@extends('layouts.app')

@section('content')
<style>
    .sidebar {
        width: 250px;
        background: #18181b;
        padding: 20px;
        height: 90vh;
        flex-shrink: 0;
    }

    .right-sidebar {
        width: 280px;
        background: #18181b;
        padding: 20px;
        flex-shrink: 0;
        border-left: 1px solid #2a2a2a;
    }

    .banner {
        flex: 1;
        position: relative;
        overflow: hidden;
    }

    .slider {
        height: 100%;
        display: flex;
        transition: transform 0.5s ease-in-out;
    }

    .slide {
        min-width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        position: relative;
    }

    .game-info {
        position: absolute;
        bottom: 50px;
        left: 50px;
        z-index: 2;
    }

    .game-title {
        font-size: 24px;
        margin-bottom: 10px;
    }

    .game-description {
        font-size: 16px;
        margin-bottom: 20px;
        max-width: 500px;
    }

    .price {
        font-size: 18px;
        margin-bottom: 20px;
    }

    .button-group {
        display: flex;
        gap: 10px;
    }

    .buy-button {
        background: white;
        color: black;
        border: none;
        padding: 10px 30px;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
    }

    .buy-button {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .buy-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 255, 255, 0.2);
    }

    .buy-button:active {
        transform: translateY(0);
    }

    .sidebar {
        top: 0;
        height: 84.7vh;
        overflow-y: auto;
    }

    .game-grid {
        padding: 30px;
        background: #121212;
    }

    .grid-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .grid-title {
        font-size: 24px;
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .grid-title::after {
        content: '›';
        font-size: 28px;
    }

    .grid-nav {
        display: flex;
        gap: 10px;
    }

    .nav-button {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        border: none;
        color: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .nav-button:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    .wishlist-button {
        background: transparent;
        color: white;
        border: 1px solid white;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .quick-launch {
        margin-top: 50px;
    }

    .quick-launch-title {
        font-size: 12px;
        color: #666;
        margin-bottom: 10px;
    }

    .slider-nav {
        position: absolute;
        bottom: 20px;
        right: 50px;
        display: flex;
        gap: 8px;
        z-index: 2;
    }

    .slider-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .slider-dot.active {
        background: white;
        transform: scale(1.2);
    }

    .game-recommendation {
        display: flex;
        align-items: center;
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 4px;
        transition: background-color 0.2s;
        text-decoration: none;
        color: white;
    }

    .game-recommendation:hover {
        background: #2a2a2a;
    }

    .game-recommendation img {
        width: 42px;
        height: 42px;
        border-radius: 4px;
        margin-right: 12px;
        object-fit: cover;
    }

    .game-recommendation-info {
        flex: 1;
    }

    .game-recommendation-title {
        font-size: 14px;
        margin-bottom: 4px;
    }

    .sidebar-item {
        display: flex;
        align-items: center;
        padding: 10px;
        color: white;
        text-decoration: none;
        margin-bottom: 10px;
        border-radius: 4px;
        transition: background-color 0.2s;
    }

    .sidebar-item:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .sidebar-item.active {
        background: #0078f2;
    }

    .home-container {
        display: flex;
        height: 90vh
    }

    .best-games-section {
        padding: 40px 30px;
        background: #121212;
    }

    .best-games-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 32px;
    }

    .best-games-title {
        font-size: 28px;
        font-weight: bold;
        color: white;
    }

    .trophy-icon {
        color: #FFD700;
        width: 32px;
        height: 32px;
    }

    .best-games-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
    }

    .card-description {
        color: #888;
        font-size: 14px;
        margin: 8px 0;
        line-height: 1.4;
    }

    .game-card {
        background: #18181b;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .game-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 20px rgba(0, 0, 0, 0.2);
    }

    .game-card img {
        width: 100%;
        height: 380px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .game-card:hover img {
        transform: scale(1.05);
    }

    .card-info {
        padding: 20px;
        background: #18181b;
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
        color: #fff;
        line-height: 1.4;
    }

    .card-price {
        display: flex;
        align-items: center;
        gap: 12px;
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

    .status-badge {
        display: block !important;
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(0, 0, 0, 0.85);
        color: white;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
        backdrop-filter: blur(4px);
        z-index: 1;
    }

    @media (max-width: 1200px) {
        .best-games-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .best-games-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="home-container">
    <div class="sidebar">
        <a href="{{ route('home') }}" class="sidebar-item">Store</a>
        <a href="{{ route('library.index') }}" class="sidebar-item">Library</a>

        <div class="quick-launch">
            <div class="quick-launch-title">QUICK LAUNCH</div>
            @guest
                <div class="sidebar-item">Login first to see your games</div>
            @else
                @forelse($ownedGames as $game)
                    <a href="" class="sidebar-item">
                        <img src="{{ asset('uploads/' . $game->image) }}"
                             width="32"
                             alt="{{ $game->name }}"
                             style="margin-right: 10px; border-radius: 4px;">
                        {{ $game->name }}
                    </a>
                @empty
                    <div class="quick-launch-empty">No games in your library yet</div>
                @endforelse
            @endguest
        </div>
    </div>

    <div class="banner">
        <div class="slider">
            <div class="slide" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.8)), url('{{ asset('images/bmw.webp') }}')">
                <div class="game-info">
                    <h1 class="game-title">BLACK MYTH: WUKONG</h1>
                    <p class="game-description">Set out as the Destined One in this action RPG rooted in Chinese mythology.</p>
                    <div class="price">IDR 699,999</div>
                    <div class="button-group">
                        <button class="buy-button">Buy Now</button>
                        <button class="wishlist-button">Add to Wishlist</button>
                    </div>
                </div>
            </div>
            <div class="slide" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.8)), url('{{ asset('images/fortnitebg.jpg') }}')">
                <div class="game-info">
                    <h1 class="game-title">Fortnite Festival</h1>
                    <p class="game-description">The ultimate battle royale experience evolves with music.</p>
                    <div class="price">Free to Play</div>
                    <div class="button-group">
                        <a href="{{ route('library.index') }}">
                            <button class="buy-button">Download Now</button>
                        </a>
                        <button class="wishlist-button">Add to Wishlist</button>
                    </div>
                </div>
            </div>
            <div class="slide" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.8)), url('{{ asset('images/final.webp') }}')">
                <div class="game-info">
                    <h1 class="game-title">FINAL FANTASY VII REBIRTH</h1>
                    <p class="game-description">Continue the story in this stunning reimagining of the classic RPG.</p>
                    <div class="price">IDR 899,999</div>
                    <div class="button-group">
                        <a href="{{ route('product.details', 7) }}">
                            <button class="buy-button">Pre-Purchase</button>
                        </a>
                        <button class="wishlist-button">Add to Wishlist</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="slider-nav"></div>
    </div>
</div>

<!-- Best Games Section -->
<div class="best-games-section">
    <div class="best-games-header">
        <svg class="trophy-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M8.21 13.89L7 23l5-3 5 3-1.21-9.11" />
            <path d="M6 4h12v7a6 6 0 01-12 0V4z" />
            <path d="M6 4h12" />
        </svg>
        <h2 class="best-games-title">Best Games</h2>
    </div>

    <div class="best-games-grid">
        @forelse($bestGames as $game)
            @php
                // Calculate discount if applicable
                $originalPrice = $game->price;
                $discountPercentage = $game->discount ?? 0;
                $discountedPrice = $originalPrice * (1 - ($discountPercentage / 100));

                // Set status based on release_status
                $status = 'Available Now';
                if ($game->release_status === 'coming_soon') {
                    $status = 'Coming Soon';
                } elseif ($game->release_status === 'pre_order') {
                    $status = 'Pre-Order';
                }
            @endphp

            <a href="{{ route('product.details', $game->id) }}">
                <div class="game-card">
                    <span class="status-badge">{{ $status }}</span>
                    <img src="{{ asset('uploads/' . $game->image) }}" alt="{{ $game->name }}">
                    <div class="card-info">
                        <div class="card-category">{{ $game->category_name }}</div>
                        <div class="card-title">{{ $game->name }}</div>
                        <div class="card-description">{{ Str::limit($game->description, 100) }}</div>
                        <div class="card-price">
                            @if($discountPercentage > 0)
                                <span class="discount">-{{ $discountPercentage }}%</span>
                                <span class="original-price">IDR {{ number_format($originalPrice, 0) }}</span>
                            @endif
                            <span class="final-price">IDR {{ number_format($discountedPrice, 0) }}</span>
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <div class="no-products">No featured games available.</div>
        @endforelse
    </div>
</div>

@endsection
