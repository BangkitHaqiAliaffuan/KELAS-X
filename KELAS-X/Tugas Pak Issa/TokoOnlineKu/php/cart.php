<?php
include 'config.php';

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle cart actions from query string
if (isset($_GET['menu']) && $_GET['menu'] === 'cart') {
    if (isset($_GET['id'])) {
        $product_id = intval($_GET['id']);
        addToCart($product_id);
        header('Location: index.php?menu=cart');
        exit;
    }
}

function addToCart($product_id, $quantity = 1) {
    global $conn;
    
    // Validate product exists and get its details
    $query = "SELECT id, name, price, discount, image FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        return [
            'success' => false,
            'message' => 'Product not found'
        ];
    }
    
    $product = $result->fetch_assoc();
    
    // Calculate discounted price
    $final_price = $product['price'];
    if ($product['discount'] > 0) {
        $final_price = $product['price'] * (1 - ($product['discount'] / 100));
    }
    
    // Add or update cart item
    $cart_item = [
        'id' => $product['id'],
        'name' => $product['name'],
        'image' => $product['image'],
        'price' => $final_price,
        'quantity' => $quantity
    ];
    
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $cart_item;
    }
    
    return [
        'success' => true,
        'message' => 'Product added to cart',
        'cart_count' => count($_SESSION['cart'])
    ];
}

// Other cart functions remain the same


function removeFromCart($product_id) {
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
        return true;
    }
    return false;
}

function handleClearCart() {
    $_SESSION['cart'] = [];
}

function getCartTotal() {
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    return $total;
}

// Handle remaining POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
        
            case 'remove_item':
                $product_id = intval($_POST['product_id']);
                removeFromCart($product_id);
                break;
            case 'clear_cart':
                handleClearCart();
                break;
        }
        header('Location: index.php?menu=cart');
        exit;
    }
}

?>
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
   
    <div class="container">
        <div class="cart-container">
            <h2 class="mb-4">Shopping Cart</h2>
            
            <!-- Cart Items -->
            <?php if (!empty($_SESSION['cart'])): ?>
                <?php foreach ($_SESSION['cart'] as $product_id => $item): ?>
                    <div class="cart-item">
                        <img src="uploads/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>">
                        <div class="item-details">
                            <div class="item-title"><?php echo $item['name']; ?></div>
                            <div class="item-price">IDR <?php echo number_format($item['price'], 0, ',', '.'); ?></div>
                            
                        </div>
                        <form method="POST" action="">
                            <input type="hidden" name="action" value="remove_item">
                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                            <button type="submit" class="remove-btn">Remove</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-cart">
                    <div class="empty-cart-icon">🛒</div>
                    <h3>Your cart is empty</h3>
                    <p>Browse our games and add something to your cart!</p>
                    <a href="index.php?menu=produk" class="btn btn-primary mt-3">Browse Games</a>
                </div>
            <?php endif; ?>

            <!-- Cart Summary -->
            <?php if (!empty($_SESSION['cart'])): ?>
                <div class="cart-summary">
                    <h3 class="mb-4">Order Summary</h3>
                    <div class="summary-item">
                        <span>Subtotal</span>
                        <span>IDR <?php echo number_format(getCartTotal(), 0, ',', '.'); ?></span>
                    </div>
                    <div class="summary-item">
                        <span>Tax</span>
                        <span>IDR <?php echo number_format(getCartTotal() * 0.1, 0, ',', '.'); ?></span>
                    </div>
                    <hr style="border-color: #2a2a2a;">
                    <div class="summary-item">
                        <span><strong>Total</strong></span>
                        <span><strong>IDR <?php echo number_format(getCartTotal() * 1.1, 0, ',', '.'); ?></strong></span>
                    </div>
                    <form method="POST" action="?menu=payment_cart">
                        <input type="hidden" name="action" value="clear_cart">
                        <button type="submit" class="checkout-btn">Proceed to Checkout</button>
                    </form>
                </div>
            <?php endif; ?>
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
    <?php echo $item['image']; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>