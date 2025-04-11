@extends('layouts.app')

@section('content')
    <div class="product-container">
        @if (session('error'))
            <div class="alert alert-danger">
                <div class="alert-content">
                    <i class="alert-icon">❌</i>
                    <span>{{ session('error') }}</span>
                </div>
                <button class="alert-close" onclick="this.parentElement.style.display='none'">×</button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                <div class="alert-content">
                    <i class="alert-icon">✓</i>
                    <span>{{ session('success') }}</span>
                </div>
                <button class="alert-close" onclick="this.parentElement.style.display='none'">×</button>
            </div>
        @endif

        <div class="product-header">
            <h1 class="product-title">{{ $product->name }}</h1>

            <nav class="product-nav">
                <a href="#overview" class="nav-link active">Overview</a>
                <a href="#description" class="nav-link">Description</a>
                <a href="#reviews" class="nav-link">Reviews</a>
            </nav>
        </div>

        <div class="product-content">
            <div class="product-gallery">
                <div class="banner-container">
                    <div class="banner-slider" id="bannerSlider">
                        @foreach ($images as $image)
                            <div class="banner-slide">
                                <img src="{{ asset($image) }}" alt="{{ $product->name }}">
                            </div>
                        @endforeach
                    </div>

                    <div class="slider-arrows">
                        <button class="arrow prev-arrow" onclick="prevSlide()">❮</button>
                        <button class="arrow next-arrow" onclick="nextSlide()">❯</button>
                    </div>

                    <div class="banner-progress">
                        <div class="progress-bar" id="sliderProgress"></div>
                    </div>
                </div>

                <div class="banner-nav">
                    @foreach ($images as $index => $image)
                        <div class="thumbnail {{ $index === 0 ? 'active' : '' }}" onclick="goToSlide({{ $index }})">
                            <img src="{{ asset($image) }}" alt="Thumbnail">
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="product-info">
                <div class="price-container">
                    @if ($product->discount > 0)
                        <div class="offer-banner">
                            <div class="offer-icon">🔥</div>
                            <div class="offer-details">
                                <span class="offer-text">Special Offer!</span>
                                <span class="offer-timer" id="offerTimer">23:59:59</span>
                            </div>
                        </div>
                    @endif

                    <div class="price-wrapper">
                        @if ($product->price == 0)
                            <span class="free-label">Free to Play</span>
                        @else
                            @if ($product->discount > 0)
                                <span class="discount-tag">-{{ $product->discount }}%</span>
                                <div class="price-display">
                                    <span class="original-price">
                                        <span class="currency">IDR</span>
                                        {{ number_format($product->price, 0) }}
                                    </span>
                                    <span class="current-price">
                                        <span class="currency">IDR</span>
                                        <span
                                            class="amount">{{ number_format($product->price * (1 - $product->discount / 100), 0) }}</span>
                                    </span>
                                </div>
                            @else
                                <div class="price-display">
                                    <span class="current-price">
                                        <span class="currency">IDR</span>
                                        <span class="amount">{{ number_format($product->price, 0) }}</span>
                                    </span>
                                </div>
                            @endif
                        @endif
                    </div>

                    <div class="action-buttons">
                        <a href="{{ route('order.create', $product->id) }}" class="btn-link">
                            <button class="btn btn-buy">
                                <span class="btn-icon">🛒</span>
                                <span>Buy Now</span>
                            </button>
                        </a>
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-cart">
                                <span class="btn-icon">+</span>
                                <span>Add to Cart</span>
                            </button>
                        </form>
                        <button class="btn btn-wishlist" onclick="addToWishlist({{ $product->id }})">
                            <span class="btn-icon">♥</span>
                        </button>
                    </div>
                </div>

                <div class="product-meta">
                    <div class="meta-item">
                        <span class="meta-label">Release Date:</span>
                        <span class="meta-value">{{ date('F j, Y', strtotime($product->created_at)) }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Category:</span>
                        <span class="meta-value">Game</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="game-description" id="description">
            <h2 class="section-title">Description</h2>
            <div class="description-content">
                @foreach (explode("\n\n", $product->description) as $paragraph)
                    <p>{!! nl2br(e($paragraph)) !!}</p>
                @endforeach
            </div>
        </div>

        <div class="system-requirements">
            <h2 class="section-title">System Requirements</h2>
            <div class="requirements-tabs">
                <button class="tab-btn active" data-tab="minimum">Minimum</button>
                <button class="tab-btn" data-tab="recommended">Recommended</button>
            </div>

            <div class="requirements-content active" id="minimum-content">
                <div class="requirements-grid">
                    <div class="requirements-column">
                        <div class="requirement-item">
                            <span class="requirement-label">OS</span>
                            <span class="requirement-value">Windows 10 64-bit</span>
                        </div>
                        <div class="requirement-item">
                            <span class="requirement-label">Processor</span>
                            <span class="requirement-value">Intel Core i5-6600K / AMD Ryzen 5 1600</span>
                        </div>
                        <div class="requirement-item">
                            <span class="requirement-label">Memory</span>
                            <span class="requirement-value">8 GB RAM</span>
                        </div>
                    </div>
                    <div class="requirements-column">
                        <div class="requirement-item">
                            <span class="requirement-label">Graphics</span>
                            <span class="requirement-value">NVIDIA GeForce GTX 1060 / AMD Radeon RX 580</span>
                        </div>
                        <div class="requirement-item">
                            <span class="requirement-label">Storage</span>
                            <span class="requirement-value">50 GB available space</span>
                        </div>
                        <div class="requirement-item">
                            <span class="requirement-label">Network</span>
                            <span class="requirement-value">Broadband Internet connection</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="requirements-content" id="recommended-content">
                <div class="requirements-grid">
                    <div class="requirements-column">
                        <div class="requirement-item">
                            <span class="requirement-label">OS</span>
                            <span class="requirement-value">Windows 10/11 64-bit</span>
                        </div>
                        <div class="requirement-item">
                            <span class="requirement-label">Processor</span>
                            <span class="requirement-value">Intel Core i7-8700K / AMD Ryzen 7 3700X</span>
                        </div>
                        <div class="requirement-item">
                            <span class="requirement-label">Memory</span>
                            <span class="requirement-value">16 GB RAM</span>
                        </div>
                    </div>
                    <div class="requirements-column">
                        <div class="requirement-item">
                            <span class="requirement-label">Graphics</span>
                            <span class="requirement-value">NVIDIA GeForce RTX 2070 / AMD Radeon RX 5700 XT</span>
                        </div>
                        <div class="requirement-item">
                            <span class="requirement-label">Storage</span>
                            <span class="requirement-value">50 GB SSD</span>
                        </div>
                        <div class="requirement-item">
                            <span class="requirement-label">Network</span>
                            <span class="requirement-value">Broadband Internet connection</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="reviews-section" id="reviews">
            <h2 class="section-title">Customer Reviews</h2>

            <!-- Review Summary -->
            <div class="review-summary">
                <div class="average-rating">
                    <div class="rating-circle">
                        <span class="rating-number">{{ number_format($stats->average ?: 0, 1) }}</span>
                    </div>
                    <div class="rating-details">
                        <div class="rating-stars">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="star {{ $i <= round($stats->average ?: 0) ? 'filled' : '' }}">★</span>
                            @endfor
                        </div>
                        <span class="total-reviews">Based on {{ $stats->total ?: 0 }} reviews</span>
                    </div>
                </div>

                <div class="rating-distribution">
                    @for ($i = 5; $i >= 1; $i--)
                        <div class="rating-bar">
                            <span class="rating-label">{{ $i }} ★</span>
                            <div class="progress">
                                <div class="progress-fill"
                                    style="width: {{ $stats->total > 0 ? (($stats->{"star{$i}"} ?? 0) / $stats->total) * 100 : 0 }}%">
                                </div>
                            </div>
                            <span class="rating-count">{{ $stats->{"star{$i}"} ?? 0 }}</span>
                        </div>
                    @endfor
                </div>
            </div>

            @auth
                @if ($canReview)
                    <div class="review-form">
                        <h3>Write a Review</h3>
                        <form method="POST" action="{{ route('products.reviews.submit', $product->id) }}" id="reviewForm">
                            @csrf

                            <div class="rating-input">
                                <label>Rating:</label>
                                <div class="star-rating">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <input type="radio" id="star{{ $i }}" name="rating"
                                            value="{{ $i }}" required>
                                        <label for="star{{ $i }}" title="{{ $i }} stars">★</label>
                                    @endfor
                                </div>
                            </div>

                            <div class="review-input">
                                <label for="review_text">Your Review:</label>
                                <textarea id="review_text" name="review_text" rows="4" required
                                    placeholder="Share your experience with this product..."></textarea>
                                <div class="char-counter">
                                    <span id="charCount">0</span>/1000
                                </div>
                            </div>

                            <button type="submit" class="btn btn-submit">Submit Review</button>
                        </form>
                    </div>
                @else
                    <div class="review-form review-form-disabled">
                        <div class="review-form-message">
                            <i class="message-icon">🛈</i>
                            <p>You need to purchase this product before you can leave a review.</p>
                        </div>
                    </div>
                @endif
            @else
                <div class="review-form review-form-disabled">
                    <div class="review-form-message">
                        <i class="message-icon">🛈</i>
                        <p>Please <a href="{{ route('login') }}" class="login-link">log in</a> to leave a review.</p>
                    </div>
                </div>
            @endauth

            <!-- Review List -->
            <div class="review-list">
                <div class="review-filters">
                    <select id="reviewSort" class="review-sort">
                        <option value="newest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="highest">Highest Rated</option>
                        <option value="lowest">Lowest Rated</option>
                    </select>
                </div>

                <div id="reviewsContainer">
                    @if (count($reviews) > 0)
                        @foreach ($reviews as $review)
                            <div class="review-item" data-rating="{{ $review->rating }}"
                                data-date="{{ $review->created_at }}">
                                <div class="review-header">
                                    <div class="reviewer-avatar">
                                        {{ substr($review->username, 0, 1) }}
                                    </div>
                                    <div class="review-meta">
                                        <div class="user-name">{{ $review->username }}</div>
                                        <div class="review-stats">
                                            <div class="rating-stars">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <span
                                                        class="star {{ $i <= $review->rating ? 'filled' : '' }}">★</span>
                                                @endfor
                                            </div>
                                            <div class="review-date">
                                                {{ date('F j, Y', strtotime($review->created_at)) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="review-content">
                                    <p>{!! nl2br(e($review->review_text)) !!}</p>
                                </div>
                                <div class="review-actions">
                                    <button class="review-action-btn" onclick="likeReview({{ $review->id }})">
                                        <span class="action-icon">👍</span>
                                        <span class="action-count">0</span>
                                    </button>
                                    <button class="review-action-btn" onclick="dislikeReview({{ $review->id }})">
                                        <span class="action-icon">👎</span>
                                        <span class="action-count">0</span>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="review-empty">
                            <div class="empty-icon">📝</div>
                            <p>No reviews yet. Be the first to review this product!</p>
                        </div>
                    @endif
                </div>

                @if (count($reviews) > 5)
                    <div class="load-more">
                        <button id="loadMoreBtn" class="btn btn-outline">Load More Reviews</button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        /* Base Styles */
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #121212;
            color: white;
            line-height: 1.6;
        }

        .product-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header Styles */
        .product-header {
            margin-bottom: 30px;
        }

        .product-title {
            font-size: 42px;
            font-weight: 800;
            margin-bottom: 20px;
            background: linear-gradient(90deg, #fff, #a3a3a3);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .product-nav {
            display: flex;
            gap: 30px;
            margin-bottom: 20px;
            border-bottom: 1px solid #333;
            padding-bottom: 10px;
        }

        .nav-link {
            color: #888;
            text-decoration: none;
            font-size: 16px;
            font-weight: 600;
            padding-bottom: 10px;
            border-bottom: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: #ccc;
        }

        .nav-link.active {
            color: white;
            border-bottom: 2px solid #0078f2;
        }

        /* Product Content Layout */
        .product-content {
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }

        @media (min-width: 992px) {
            .product-content {
                grid-template-columns: 3fr 2fr;
            }
        }

        /* Gallery Styles */
        .product-gallery {
            position: relative;
        }

        .banner-container {
            position: relative;
            width: 100%;
            height: 500px;
            overflow: hidden;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .banner-slider {
            display: flex;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
        }

        .banner-slide {
            min-width: 100%;
            height: 100%;
            position: relative;
        }

        .banner-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .banner-slide:hover img {
            transform: scale(1.02);
        }

        .banner-nav {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding-bottom: 10px;
            scrollbar-width: thin;
            scrollbar-color: #0078f2 #333;
        }

        .banner-nav::-webkit-scrollbar {
            height: 6px;
        }

        .banner-nav::-webkit-scrollbar-track {
            background: #333;
            border-radius: 10px;
        }

        .banner-nav::-webkit-scrollbar-thumb {
            background: #0078f2;
            border-radius: 10px;
        }

        .thumbnail {
            min-width: 100px;
            height: 60px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .thumbnail:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .thumbnail:hover img {
            transform: scale(1.1);
        }

        .thumbnail.active {
            border-color: #0078f2;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 120, 242, 0.4);
        }

        .slider-arrows {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
            z-index: 10;
        }

        .arrow {
            background: rgba(0, 0, 0, 0.6);
            color: white;
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 18px;
            margin: 0 15px;
            transition: all 0.3s ease;
            opacity: 0.7;
        }

        .arrow:hover {
            background: rgba(0, 120, 242, 0.8);
            transform: scale(1.1);
            opacity: 1;
        }

        .banner-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: rgba(255, 255, 255, 0.2);
        }

        .progress-bar {
            height: 100%;
            background: #0078f2;
            width: 0;
            transition: width 0.5s linear;
        }

        /* Price Container Styles */
        .price-container {
            background: linear-gradient(145deg, #1a1a1a, #222);
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .price-container:hover {
            transform: translateY(-5px);
        }

        .offer-banner {
            display: flex;
            align-items: center;
            gap: 15px;
            background: linear-gradient(90deg, #8e44ad, #9b59b6);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(142, 68, 173, 0.3);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(142, 68, 173, 0.4);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(142, 68, 173, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(142, 68, 173, 0);
            }
        }

        .offer-icon {
            font-size: 24px;
            animation: flame 0.5s infinite alternate;
        }

        @keyframes flame {
            from {
                transform: scale(1);
            }

            to {
                transform: scale(1.2);
            }
        }

        .offer-details {
            display: flex;
            flex-direction: column;
        }

        .offer-text {
            color: white;
            font-weight: 700;
            font-size: 18px;
        }

        .offer-timer {
            background: rgba(0, 0, 0, 0.3);
            padding: 6px 12px;
            border-radius: 4px;
            color: white;
            font-family: monospace;
            font-size: 16px;
            margin-top: 5px;
            display: inline-block;
        }

        .price-wrapper {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 25px;
        }

        .discount-tag {
            background: #8e44ad;
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 20px;
            box-shadow: 0 2px 4px rgba(142, 68, 173, 0.3);
        }

        .price-display {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .original-price {
            color: #888;
            text-decoration: line-through;
            font-size: 16px;
            position: relative;
            display: inline-block;
            margin-bottom: 5px;
        }

        .current-price {
            color: white;
            font-size: 36px;
            font-weight: 800;
            display: flex;
            align-items: center;
        }

        .currency {
            font-size: 0.7em;
            margin-right: 4px;
            opacity: 0.9;
        }

        .free-label {
            color: #4CAF50;
            font-size: 32px;
            font-weight: 800;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 14px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-link {
            text-decoration: none;
            flex: 1;
        }

        .btn-buy {
            background: linear-gradient(90deg, #8e44ad, #9b59b6);
            color: white;
            flex: 1;
            box-shadow: 0 4px 8px rgba(142, 68, 173, 0.3);
        }

        .btn-buy:hover {
            background: linear-gradient(90deg, #7d3c98, #8e44ad);
        }

        .btn-cart {
            background: #333;
            color: white;
            flex: 1;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .btn-wishlist {
            background: #333;
            color: white;
            width: 50px;
            padding: 14px 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }

        .btn-cart:hover,
        .btn-wishlist:hover {
            background: #444;
        }

        .btn-icon {
            font-size: 18px;
        }

        /* Product Meta */
        .product-meta {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            padding: 15px;
        }

        .meta-item {
            display: flex;
            flex-direction: column;
        }

        .meta-label {
            color: #888;
            font-size: 14px;
        }

        .meta-value {
            color: white;
            font-weight: 600;
        }

        /* Description Styles */
        .game-description {
            background: linear-gradient(145deg, #1a1a1a, #222);
            border-radius: 16px;
            padding: 30px;
            margin: 40px 0;
            color: #e4e4e7;
            line-height: 1.7;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .section-title {
            font-size: 28px;
            margin-bottom: 20px;
            color: #ffffff;
            position: relative;
            padding-bottom: 10px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: #0078f2;
        }

        .description-content {
            font-size: 16px;
        }

        .game-description p {
            margin-bottom: 16px;
        }

        .game-description p:last-child {
            margin-bottom: 0;
        }

        /* System Requirements Styles */
        .system-requirements {
            background: linear-gradient(145deg, #1a1a1a, #222);
            border-radius: 16px;
            padding: 30px;
            margin: 40px 0;
            color: #ffffff;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .requirements-tabs {
            display: flex;
            gap: 20px;
            margin-bottom: 24px;
            border-bottom: 1px solid #333;
            padding-bottom: 10px;
        }

        .tab-btn {
            background: none;
            border: none;
            color: #888;
            font-size: 16px;
            font-weight: 600;
            padding: 8px 16px;
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
        }

        .tab-btn:hover {
            color: #ccc;
        }

        .tab-btn.active {
            color: #fff;
        }

        .tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: -11px;
            left: 0;
            width: 100%;
            height: 2px;
            background: #0078f2;
        }

        .requirements-content {
            display: none;
        }

        .requirements-content.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .requirements-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 32px;
        }

        .requirements-column h3 {
            font-size: 18px;
            margin-bottom: 16px;
            color: #888;
        }

        .requirement-item {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 12px;
            transition: all 0.3s ease;
        }

        .requirement-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .requirement-label {
            display: block;
            color: #888;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .requirement-value {
            display: block;
            color: #fff;
            font-size: 16px;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .requirements-grid {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .system-requirements {
                padding: 20px;
            }
        }

        /* Reviews Section Styles */
        .reviews-section {
            background: linear-gradient(145deg, #1a1a1a, #222);
            border-radius: 16px;
            padding: 30px;
            margin-top: 40px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .review-summary {
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
            margin-bottom: 32px;
            padding: 24px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
        }

        @media (min-width: 768px) {
            .review-summary {
                grid-template-columns: 1fr 2fr;
            }
        }

        .average-rating {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        @media (min-width: 768px) {
            .average-rating {
                flex-direction: row;
                gap: 20px;
            }
        }

        .rating-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(145deg, #0078f2, #00a1ff);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            box-shadow: 0 4px 8px rgba(0, 120, 242, 0.3);
        }

        @media (min-width: 768px) {
            .rating-circle {
                margin-bottom: 0;
            }
        }

        .rating-number {
            font-size: 32px;
            font-weight: bold;
            color: #ffffff;
        }

        .rating-details {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        @media (min-width: 768px) {
            .rating-details {
                align-items: flex-start;
            }
        }

        .rating-stars {
            display: flex;
            gap: 2px;
            margin: 8px 0;
        }

        .star {
            color: #666;
            font-size: 24px;
        }

        .star.filled {
            color: #ffd700;
        }

        .total-reviews {
            color: #888;
            font-size: 14px;
        }

        .rating-distribution {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .rating-bar {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .rating-label {
            width: 40px;
            text-align: right;
            color: #888;
            font-size: 14px;
        }

        .progress {
            flex: 1;
            height: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: #0078f2;
            border-radius: 4px;
            transition: width 1s ease-out;
        }

        .rating-count {
            width: 30px;
            color: #888;
            font-size: 14px;
        }

        /* Review Form Styles */
        .review-form {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 32px;
            transition: all 0.3s ease;
        }

        .review-form:hover {
            background: rgba(255, 255, 255, 0.08);
        }

        .review-form h3 {
            margin-bottom: 20px;
            font-size: 20px;
            color: #fff;
        }

        .rating-input {
            margin-bottom: 20px;
        }

        .star-rating {
            display: inline-block;
            direction: rtl;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            color: #666;
            font-size: 30px;
            padding: 0 2px;
            cursor: pointer;
            display: inline-block;
            transition: color 0.2s ease;
        }

        .star-rating input:checked~label {
            color: #ffd700;
        }

        .star-rating label:hover,
        .star-rating label:hover~label {
            color: #ffd700;
        }

        .review-input {
            margin-bottom: 20px;
            position: relative;
        }

        .review-input label {
            display: block;
            margin-bottom: 8px;
            color: #ccc;
        }

        .review-input textarea {
            width: 100%;
            padding: 15px;
            border: 1px solid #333;
            border-radius: 8px;
            background: rgba(0, 0, 0, 0.2);
            color: white;
            resize: vertical;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .review-input textarea:focus {
            border-color: #0078f2;
            outline: none;
            box-shadow: 0 0 0 2px rgba(0, 120, 242, 0.3);
        }

        .char-counter {
            position: absolute;
            bottom: 10px;
            right: 10px;
            color: #888;
            font-size: 12px;
        }

        .btn-submit {
            background: linear-gradient(90deg, #0078f2, #00a1ff);
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            box-shadow: 0 4px 8px rgba(0, 120, 242, 0.3);
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 120, 242, 0.4);
        }

        .review-form-disabled {
            background: rgba(255, 255, 255, 0.03);
        }

        .review-form-message {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .message-icon {
            font-size: 24px;
            color: #0078f2;
        }

        .login-link {
            color: #0078f2;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .login-link:hover {
            text-decoration: underline;
        }

        /* Review List Styles */
        .review-filters {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .review-sort {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid #333;
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }

        .review-item {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .review-item:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateY(-2px);
        }

        .review-header {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }

        .reviewer-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(145deg, #0078f2, #00a1ff);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: bold;
            color: white;
        }

        .review-meta {
            flex: 1;
        }

        .user-name {
            font-weight: 600;
            color: #ffffff;
            font-size: 18px;
        }

        .review-stats {
            display: flex;
            gap: 16px;
            color: #888;
            font-size: 14px;
            margin-top: 4px;
            align-items: center;
        }

        .review-stats .rating-stars {
            margin: 0;
        }

        .review-stats .star {
            font-size: 16px;
        }

        .review-date {
            color: #888;
        }

        .review-content {
            color: #dddddd;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .review-actions {
            display: flex;
            gap: 15px;
        }

        .review-action-btn {
            background: rgba(255, 255, 255, 0.05);
            border: none;
            border-radius: 6px;
            padding: 8px 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #888;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .review-action-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .action-icon {
            font-size: 16px;
        }

        .action-count {
            font-size: 14px;
        }

        .review-empty {
            text-align: center;
            padding: 40px 0;
            color: #888;
        }

        .empty-icon {
            font-size: 48px;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        .load-more {
            text-align: center;
            margin-top: 30px;
        }

        .btn-outline {
            background: transparent;
            border: 2px solid #0078f2;
            color: #0078f2;
        }

        .btn-outline:hover {
            background: rgba(0, 120, 242, 0.1);
        }

        /* Alert Styles */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            animation: slideIn 0.5s ease;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .alert-content {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-icon {
            font-size: 18px;
        }

        .alert-success {
            background-color: rgba(76, 175, 80, 0.2);
            border-left: 4px solid #4CAF50;
            color: #4CAF50;
        }

        .alert-danger {
            background-color: rgba(244, 67, 54, 0.2);
            border-left: 4px solid #f44336;
            color: #f44336;
        }

        .alert-close {
            background: none;
            border: none;
            color: inherit;
            font-size: 20px;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.3s ease;
        }

        .alert-close:hover {
            opacity: 1;
        }
    </style>



    <script>
        // Image Slider Functionality
        let currentSlide = 0;
        const slider = document.getElementById('bannerSlider');
        const slides = document.querySelectorAll('.banner-slide');
        const thumbnails = document.querySelectorAll('.thumbnail');
        const progressBar = document.getElementById('sliderProgress');
        const totalSlides = slides.length;
        let slideInterval;

        // Menampilkan notifikasi berdasarkan pesan flash saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                showNotification('Success', '{{ session('success') }}', 'success');
            @endif

            @if (session('error'))
                showNotification('Error', '{{ session('error') }}', 'error');
            @endif
        });

        function updateSlider() {
            if (slider) {
                slider.style.transform = `translateX(-${currentSlide * 100}%)`;
            }

            thumbnails.forEach((thumb, index) => {
                thumb.classList.toggle('active', index === currentSlide);
            });

            // Update progress bar
            if (progressBar) {
                progressBar.style.width = `${((currentSlide + 1) / totalSlides) * 100}%`;
            }
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            updateSlider();
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            updateSlider();
        }

        function goToSlide(index) {
            currentSlide = index;
            updateSlider();
            resetSlideInterval();
        }

        function updateSliderPosition() {
            if (slider) {
                slider.style.transform = `translateX(-${currentSlide * 100}%)`;
            }
        }

        function resetSlideInterval() {
            clearInterval(slideInterval);
            slideInterval = setInterval(nextSlide, 5000);
        }

        // Initialize slider
        if (slider && slides.length > 0) {
            // Set initial slide position
            updateSlider();

            // Make sure progress bar is initialized correctly
            if (progressBar) {
                progressBar.style.width = `${((currentSlide + 1) / totalSlides) * 100}%`;
            }

            // Set up auto-slide with proper interval clearing
            slideInterval = setInterval(nextSlide, 5000);

            // Pause autoplay on hover
            slider.addEventListener('mouseenter', () => clearInterval(slideInterval));
            slider.addEventListener('mouseleave', () => {
                clearInterval(slideInterval);
                slideInterval = setInterval(nextSlide, 5000);
            });

            // Add touch support for mobile
            let touchStartX = 0;
            let touchEndX = 0;

            slider.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
            }, {
                passive: true
            });

            slider.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                if (touchStartX - touchEndX > 50) {
                    nextSlide();
                } else if (touchEndX - touchStartX > 50) {
                    prevSlide();
                }
            }, {
                passive: true
            });
        }

        // Timer Functionality
        function updateTimer() {
            const timerElement = document.getElementById('offerTimer');
            if (!timerElement) return;

            let time = timerElement.innerText.split(':');
            let hours = parseInt(time[0]);
            let minutes = parseInt(time[1]);
            let seconds = parseInt(time[2]);

            seconds--;

            if (seconds < 0) {
                seconds = 59;
                minutes--;
                if (minutes < 0) {
                    minutes = 59;
                    hours--;
                    if (hours < 0) {
                        hours = 23;
                    }
                }
            }

            timerElement.innerText =
                `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        }

        if (document.getElementById('offerTimer')) {
            setInterval(updateTimer, 1000);
        }

        // System Requirements Tabs
        const tabButtons = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.requirements-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                const tabName = button.getAttribute('data-tab');

                // Update active tab button
                tabButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');

                // Show selected tab content
                tabContents.forEach(content => content.classList.remove('active'));
                document.getElementById(`${tabName}-content`).classList.add('active');
            });
        });

        // Review Form Character Counter
        const reviewTextarea = document.getElementById('review_text');
        const charCount = document.getElementById('charCount');

        if (reviewTextarea && charCount) {
            reviewTextarea.addEventListener('input', () => {
                const count = reviewTextarea.value.length;
                charCount.textContent = count;

                if (count > 1000) {
                    charCount.style.color = '#f44336';
                } else {
                    charCount.style.color = '#888';
                }
            });
        }

        // Review Sorting
        const reviewSort = document.getElementById('reviewSort');
        const reviewsContainer = document.getElementById('reviewsContainer');

        if (reviewSort && reviewsContainer) {
            reviewSort.addEventListener('change', () => {
                const reviews = Array.from(reviewsContainer.querySelectorAll('.review-item'));
                const sortValue = reviewSort.value;

                reviews.sort((a, b) => {
                    if (sortValue === 'newest') {
                        return new Date(b.dataset.date) - new Date(a.dataset.date);
                    } else if (sortValue === 'oldest') {
                        return new Date(a.dataset.date) - new Date(b.dataset.date);
                    } else if (sortValue === 'highest') {
                        return parseInt(b.dataset.rating) - parseInt(a.dataset.rating);
                    } else if (sortValue === 'lowest') {
                        return parseInt(a.dataset.rating) - parseInt(b.dataset.rating);
                    }
                });

                // Clear and re-append sorted reviews
                reviewsContainer.innerHTML = '';
                reviews.forEach(review => reviewsContainer.appendChild(review));
            });
        }

        // Load More Reviews
        const loadMoreBtn = document.getElementById('loadMoreBtn');
        if (loadMoreBtn) {
            let visibleReviews = 5;
            const reviews = document.querySelectorAll('.review-item');

            // Initially hide reviews beyond the first 5
            for (let i = visibleReviews; i < reviews.length; i++) {
                reviews[i].style.display = 'none';
            }

            loadMoreBtn.addEventListener('click', () => {
                // Show next batch of reviews
                for (let i = visibleReviews; i < visibleReviews + 5 && i < reviews.length; i++) {
                    reviews[i].style.display = 'block';
                    reviews[i].style.animation = 'fadeIn 0.5s ease';
                }

                visibleReviews += 5;

                // Hide button if all reviews are visible
                if (visibleReviews >= reviews.length) {
                    loadMoreBtn.style.display = 'none';
                }
            });
        }

        // Cart and Wishlist Functionality

        function addToWishlist(productId) {
            fetch(`/wishlist/add/${productId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Success', 'Product added to wishlist', 'success');
                        document.querySelector('.btn-wishlist .btn-icon').innerHTML = '❤️';
                    } else {
                        showNotification('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    showNotification('Error', 'Failed to add to wishlist', 'error');
                    console.error('Error:', error);
                });
        }

        // Review Actions
        function likeReview(reviewId) {
            const button = event.currentTarget;
            const countElement = button.querySelector('.action-count');
            let count = parseInt(countElement.textContent);

            // Simple toggle for demo purposes
            if (button.classList.contains('active')) {
                button.classList.remove('active');
                countElement.textContent = count - 1;
            } else {
                button.classList.add('active');
                countElement.textContent = count + 1;
            }

            // In a real app, you would send this to the server
            // fetch(`/reviews/${reviewId}/like`, {...})
        }

        function dislikeReview(reviewId) {
            const button = event.currentTarget;
            const countElement = button.querySelector('.action-count');
            let count = parseInt(countElement.textContent);

            // Simple toggle for demo purposes
            if (button.classList.contains('active')) {
                button.classList.remove('active');
                countElement.textContent = count - 1;
            } else {
                button.classList.add('active');
                countElement.textContent = count + 1;
            }

            // In a real app, you would send this to the server
            // fetch(`/reviews/${reviewId}/dislike`, {...})
        }

        // Notification function
        function showNotification(title, message, type) {
            // Remove any existing notifications
            const existingNotifications = document.querySelectorAll('.notification');
            existingNotifications.forEach(notification => notification.remove());

            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            background: ${type === 'success' ? 'rgba(76, 175, 80, 0.9)' :
                          type === 'error' ? 'rgba(244, 67, 54, 0.9)' :
                          'rgba(33, 150, 243, 0.9)'};
            color: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            z-index: 1000;
            animation: slideIn 0.3s ease-out;
            backdrop-filter: blur(5px);
            max-width: 300px;
        `;

            notification.innerHTML = `
            <h4 style="margin: 0 0 5px 0; font-weight: 600;">${title}</h4>
            <p style="margin: 0;">${message}</p>
        `;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease-out forwards';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Update cart count in UI
        function updateCartCount(count) {
            const cartCountElement = document.getElementById('cart-count');
            if (cartCountElement) {
                cartCountElement.textContent = count;

                // Add a little animation
                cartCountElement.style.animation = 'pulse 0.5s ease';
                setTimeout(() => {
                    cartCountElement.style.animation = '';
                }, 500);
            }
        }

        // Add animations
        const style = document.createElement('style');
        style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
    `;
        document.head.appendChild(style);

        // Smooth scroll for navigation links
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);

                if (targetElement) {
                    // Update active link
                    document.querySelectorAll('.nav-link').forEach(navLink => {
                        navLink.classList.remove('active');
                    });
                    this.classList.add('active');

                    // Smooth scroll to target
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
@endsection
