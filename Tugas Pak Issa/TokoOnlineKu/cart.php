<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Game Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #121212;
            color: white;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        .header {
            background: #18181b;
            border-bottom: 1px solid #2a2a2a;
            padding: 15px 30px;
        }

        .navbar-brand {
            color: white !important;
            font-weight: 600;
        }

        .nav-link {
            color: #ffffff80 !important;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: white !important;
        }

        .cart-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 30px;
            background: #18181b;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            animation: fadeIn 0.6s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .cart-item {
            background: #1f1f23;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .cart-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .cart-item img {
            width: 120px;
            height: 160px;
            object-fit: cover;
            border-radius: 4px;
        }

        .item-details {
            flex: 1;
        }

        .item-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .item-price {
            font-size: 1.1rem;
            color: #0078f2;
            font-weight: 600;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }

        .quantity-btn {
            background: #2a2a2a;
            border: none;
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .quantity-btn:hover {
            background: #3a3a3a;
        }

        .quantity-input {
            background: #2a2a2a;
            border: none;
            color: white;
            width: 50px;
            height: 32px;
            text-align: center;
            border-radius: 4px;
        }

        .remove-btn {
            background: #ff4444;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .remove-btn:hover {
            background: #cc0000;
            transform: translateY(-2px);
        }

        .cart-summary {
            background: #1f1f23;
            border-radius: 8px;
            padding: 20px;
            margin-top: 30px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .checkout-btn {
            background: #0078f2;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            font-weight: 600;
            border-radius: 4px;
            margin-top: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .checkout-btn:hover {
            background: #0066cc;
            transform: translateY(-2px);
        }

        footer {
            background: #18181b;
            color: #ffffff80;
            padding: 20px 0;
            margin-top: 60px;
            text-align: center;
        }

        footer a {
            color: #ffffff80;
            text-decoration: none;
            margin: 0 10px;
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: white;
        }

        .empty-cart {
            text-align: center;
            padding: 40px;
        }

        .empty-cart-icon {
            font-size: 48px;
            margin-bottom: 20px;
            color: #ffffff40;
        }
    </style>
</head>
<body>
    <header class="header">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="#">Game Store</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="produk.php">Browse</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container">
        <div class="cart-container">
            <h2 class="mb-4">Shopping Cart</h2>
            
            <!-- Cart Items -->
            <div class="cart-item">
                <img src="./images/final.webp" alt="Final Fantasy VII Rebirth">
                <div class="item-details">
                    <div class="item-title">FINAL FANTASY VII REBIRTH</div>
                    <div class="item-price">IDR 899,999</div>
                    <div class="quantity-control">
                        <button class="quantity-btn">-</button>
                        <input type="number" class="quantity-input" value="1" min="1">
                        <button class="quantity-btn">+</button>
                    </div>
                </div>
                <button class="remove-btn">Remove</button>
            </div>

            <div class="cart-item">
                <img src="./images/bmw.webp" alt="Black Myth: Wukong">
                <div class="item-details">
                    <div class="item-title">Black Myth: Wukong</div>
                    <div class="item-price">IDR 699,999</div>
                    <div class="quantity-control">
                        <button class="quantity-btn">-</button>
                        <input type="number" class="quantity-input" value="1" min="1">
                        <button class="quantity-btn">+</button>
                    </div>
                </div>
                <button class="remove-btn">Remove</button>
            </div>

            <!-- Cart Summary -->
            <div class="cart-summary">
                <h3 class="mb-4">Order Summary</h3>
                <div class="summary-item">
                    <span>Subtotal</span>
                    <span>IDR 1,599,998</span>
                </div>
                <div class="summary-item">
                    <span>Tax</span>
                    <span>IDR 159,999</span>
                </div>
                <hr style="border-color: #2a2a2a;">
                <div class="summary-item">
                    <span><strong>Total</strong></span>
                    <span><strong>IDR 1,759,997</strong></span>
                </div>
                <button class="checkout-btn">Proceed to Checkout</button>
            </div>

            <!-- Empty Cart State (hidden by default) -->
            <div class="empty-cart" style="display: none;">
                <div class="empty-cart-icon">🛒</div>
                <h3>Your cart is empty</h3>
                <p>Browse our games and add something to your cart!</p>
                <a href="produk.php" class="btn btn-primary mt-3">Browse Games</a>
            </div>
        </div>
    </div>

    <footer>
        <div>
            <a href="#">About</a> |
            <a href="#">Support</a> |
            <a href="#">Community</a> |
            <a href="#">Contact</a>
        </div>
        <p class="mt-3">&copy; 2025 Game Store. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>