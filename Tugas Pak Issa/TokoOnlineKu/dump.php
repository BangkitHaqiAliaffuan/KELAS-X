<style>
        .review-form {
            background: #1f1f23;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 24px;
        }

        .review-form h3 {
            margin-bottom: 16px;
        }

        .rating-input {
            margin-bottom: 16px;
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
            font-size: 24px;
            padding: 0 2px;
            cursor: pointer;
            display: inline-block;
        }

        .star-rating input:checked~label {
            color: #ffd700;
        }

        .star-rating label:hover,
        .star-rating label:hover~label {
            color: #ffd700;
        }

        .review-input {
            margin-bottom: 16px;
        }

        .review-input textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #333;
            border-radius: 4px;
            background: #18181b;
            color: white;
            resize: vertical;
        }

        .review-form .btn {
            background: #0078f2;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
        }

        .review-form .btn:hover {
            opacity: 0.9;
        }

        .price-container {
            background: #18181b;
            padding: 24px;
            border-radius: 12px;
            margin: 24px 0;
        }

        .offer-banner {
            display: flex;
            align-items: center;
            gap: 12px;
            background: linear-gradient(90deg, #ff4d4d, #ff8533);
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .offer-text {
            color: white;
            font-weight: 600;
            font-size: 18px;
        }

        .offer-timer {
            background: rgba(0, 0, 0, 0.2);
            padding: 6px 12px;
            border-radius: 4px;
            color: white;
            font-family: monospace;
            font-size: 16px;
        }

        .price-wrapper {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
        }

        .discount-tag {
            background: #4CAF50;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 20px;
        }

        .price-display {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .original-price {
            color: #888;
            text-decoration: line-through;
            font-size: 16px;
            position: relative;
        }



        .current-price {
            color: white;
            font-size: 32px;
            font-weight: bold;
        }

        .currency {
            font-size: 0.7em;
            margin-right: 4px;
            opacity: 0.9;
        }

        .free-label {
            color: #4CAF50;
            font-size: 28px;
            font-weight: bold;
        }

        .game-description {
            background: #1f1f23;
            border-radius: 8px;
            padding: 24px;
            margin: 20px 0;
            color: #e4e4e7;
            line-height: 1.6;
        }

        .game-description p {
            margin-bottom: 16px;
        }

        .game-description p:last-child {
            margin-bottom: 0;
        }

        /* Style for bullet points */
        .game-description ul {
            padding-left: 20px;
            margin: 16px 0;
        }

        .game-description li {
            margin-bottom: 8px;
        }

        @media (max-width: 768px) {
            .game-description {
                padding: 16px;
            }
        }

        .reviews-section {
            background: #18181b;
            border-radius: 12px;
            padding: 24px;
            margin-top: 32px;
        }

        .section-title {
            font-size: 24px;
            margin-bottom: 24px;
            color: #ffffff;
        }

        .review-summary {
            text-align: center;
            margin-bottom: 32px;
            padding: 24px;
            background: #1f1f23;
            border-radius: 8px;
        }

        .rating-number {
            font-size: 48px;
            font-weight: bold;
            color: #ffffff;
        }

        .rating-stars {
            color: #ffd700;
            font-size: 24px;
            margin: 8px 0;
        }

        .total-reviews {
            color: #888;
            font-size: 14px;
        }

        .review-item {
            background: #1f1f23;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 16px;
        }

        .user-name {
            font-weight: 600;
            color: #ffffff;
        }

        .review-stats {
            display: flex;
            gap: 16px;
            color: #888;
            font-size: 14px;
            margin-top: 4px;
        }

        .review-content {
            color: #dddddd;
            line-height: 1.6;
            margin-top: 16px;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #121212;
            color: white;
        }

        .product-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .product-title {
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .product-nav {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .nav-link {
            color: #888;
            text-decoration: none;
            font-size: 16px;
            padding-bottom: 5px;
            border-bottom: 2px solid transparent;
        }

        .nav-link.active {
            color: white;
            border-bottom: 2px solid #0078f2;
        }

        .banner-container {
            position: relative;
            width: 100%;
            height: 600px;
            overflow: hidden;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .banner-slider {
            display: flex;
            transition: transform 0.5s ease;
            height: 100%;
        }

        .banner-slide {
            min-width: 100%;
            height: 100%;
        }

        .banner-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .banner-nav {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
        }

        .thumbnail {
            width: 100px;
            height: 60px;
            border: 2px solid rgba(255, 255, 255, 0.5);
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .thumbnail.active {
            border-color: #0078f2;
        }

        .slider-arrows {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
        }

        .arrow {
            background: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 15px;
            cursor: pointer;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 20px;
        }

        .purchase-section {
            background: #18181b;
            padding: 20px;
            border-radius: 12px;
            margin-top: 20px;
        }

        .price-info {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: #0078f2;
            color: white;
        }

        .btn-secondary {
            background: #2a2a2a;
            color: white;
        }

        .btn-wishlist {
            background: #333;
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .system-requirements {
            background: #18181b;
            border-radius: 12px;
            padding: 24px;
            margin-top: 32px;
            color: #ffffff;
        }

        .requirements-section h2 {
            font-size: 24px;
            margin-bottom: 24px;
        }

        .requirements-tabs {
            margin-bottom: 24px;
            border-bottom: 2px solid #1f1f23;
        }

        .tab-btn {
            background: none;
            border: none;
            color: #888;
            font-size: 16px;
            padding: 8px 16px;
            cursor: pointer;
            position: relative;
        }

        .tab-btn.active {
            color: #fff;
        }

        .tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background: #0078f2;
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
            background: #1f1f23;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 12px;
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
        }

        @media (max-width: 768px) {
            .requirements-grid {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .system-requirements {
                padding: 16px;
            }
        }
    </style>