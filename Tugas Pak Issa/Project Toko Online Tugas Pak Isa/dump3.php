<?php
// Previous functions remain the same until markAsPaid...


function displayCartById($koneksi, $cart_id) {
    $stmt = $koneksi->prepare("SELECT oc.*, p.produk, p.deskripsi FROM orders_carts oc 
                              LEFT JOIN produk p ON oc.produk_id = p.id 
                              WHERE oc.cart_id = ?");
    $stmt->bind_param("s", $cart_id);
    $stmt->execute();
    return $stmt->get_result();
}

// Function to get cart address
function getCartAddress($koneksi, $cart_id) {
    $stmt = $koneksi->prepare("SELECT DISTINCT alamat FROM orders_carts WHERE cart_id = ? LIMIT 1");
    $stmt->bind_param("s", $cart_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc()['alamat'] ?? '';
}

// Function to save review
function saveReview($koneksi, $produk_id, $user_id, $rating, $komentar) {
    $stmt = $koneksi->prepare("INSERT INTO ulasan (produk_id, user_id, rating, komentar, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("iiis", $produk_id, $user_id, $rating, $komentar);
    return $stmt->execute();
}

// Function to check if user has already reviewed
function hasUserReviewed($koneksi, $produk_id, $user_id) {
    $stmt = $koneksi->prepare("SELECT id FROM ulasan WHERE produk_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $produk_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

function updateProductStock($koneksi, $product_id, $quantity) {
    $stmt = $koneksi->prepare("UPDATE produk SET stock = stock - ? WHERE id = ?");
    $stmt->bind_param("ii", $quantity, $product_id);
    return $stmt->execute();
}

function markAsPaid($koneksi, $cart_id, $user_id) {
    // First, get all products from this cart
    $result = displayCartById($koneksi, $cart_id);
    
    if ($result && $result->num_rows > 0) {
        $_SESSION['products_to_review'] = array();
        
        while ($row = $result->fetch_assoc()) {
            // Store products for review in session
            $_SESSION['products_to_review'][] = array(
                'produk_id' => $row['produk_id'],
                'produk_nama' => $row['produk']
            );
            
            // Update product stock
            updateProductStock($koneksi, $row['produk_id'], $row['jumlah']);
        }
        
        // Mark cart as paid
        $stmt = $koneksi->prepare("UPDATE orders_carts SET is_paid = 1 WHERE cart_id = ?");
        $stmt->bind_param("s", $cart_id);
        $stmt->execute();
        
        // Move order to order history
      
        return true;
    }
    return false;
}

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Handle review submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'submit_review') {
    $produk_id = $_POST['produk_id'];
    $rating = $_POST['rating'];
    $komentar = $_POST['komentar'];
    $user_id = $_SESSION['user_id'];

    if (saveReview($koneksi, $produk_id, $user_id, $rating, $komentar)) {
        // Remove the reviewed product from session
        if (isset($_SESSION['products_to_review'])) {
            $_SESSION['products_to_review'] = array_filter(
                $_SESSION['products_to_review'],
                function($product) use ($produk_id) {
                    return $product['produk_id'] != $produk_id;
                }
            );
            
            if (empty($_SESSION['products_to_review'])) {
                unset($_SESSION['products_to_review']);
                header("Location: index.php?message=reviews_completed");
                exit();
            }
        }
        // Refresh the page to show remaining reviews
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Handle payment
if (isset($_POST['pay'])) {
    $cart_id = $_POST['cart_id'];
    $user_id = $_SESSION['user_id'];
    
    if (markAsPaid($koneksi, $cart_id, $user_id)) {
        $_SESSION['thank_you_message'] = "Terima kasih telah melakukan pembelian!";
        $_SESSION['payment_completed'] = true;  // Add this flag
        
        // Delete from orders_carts after moving to history
        $delete_stmt = $koneksi->prepare("DELETE FROM orders_carts WHERE cart_id = ?");
        $delete_stmt->bind_param("s", $cart_id);
        $delete_stmt->execute();
        
        // Redirect to the same page
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?menu=login");
    exit();
}

$cart_id = isset($_GET['cart_id']) ? $_GET['cart_id'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Pembayaran</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Original styles remain the same */
        :root {
            --primary-color: #007bff;
            --secondary-color: #f8f9fa;
            --accent-color: #28a745;
            --text-color: #2d3436;
            --border-radius: 15px;
            --box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            color: var(--text-color);
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .order-summary {
            background: white;
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: var(--box-shadow);
            margin-bottom: 30px;
        }

        .section-title {
            color: var(--text-color);
            font-size: 1.5em;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--secondary-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cart-item {
            background: var(--secondary-color);
            padding: 20px;
            margin-bottom: 15px;
            border-radius: var(--border-radius);
            transition: transform 0.2s ease;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            align-items: center;
            gap: 20px;
        }

        .cart-item:hover {
            transform: translateY(-2px);
        }

        .product-info h3 {
            margin: 0 0 10px 0;
            color: var(--text-color);
            font-size: 1.1em;
        }

        .product-info p {
            margin: 5px 0;
            color: #636e72;
            font-size: 0.9em;
        }

        .quantity {
            text-align: center;
            font-weight: 500;
        }

        .price {
            text-align: right;
            color: var(--primary-color);
            font-weight: 600;
            font-size: 1.1em;
        }

        .shipping-address {
            background: white;
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: var(--box-shadow);
            margin-bottom: 30px;
        }

        .address-content {
            background: var(--secondary-color);
            padding: 20px;
            border-radius: var(--border-radius);
            margin-top: 15px;
        }

        .total-section {
            background: white;
            padding: 30px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }

        .total-price {
            font-size: 2em;
            color: var(--primary-color);
            font-weight: 700;
            margin: 20px 0;
        }

        .pay-button {
            background-color: var(--accent-color);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: var(--border-radius);
            cursor: pointer;
            width: 100%;
            font-size: 1.1em;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .pay-button:hover {
            background-color: #218838;
            transform: translateY(-2px);
        }

        .thank-you-message {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #d4edda;
            color: #155724;
            padding: 25px 40px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            text-align: center;
            z-index: 1000;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .cart-item {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .price {
                text-align: center;
            }

            .container {
                padding: 0 15px;
            }
        }
        /* Additional styles for review form */
        .review-form-container {
            background: white;
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: var(--box-shadow);
            margin: 30px 0;
        }

        .product-review-form {
            margin-bottom: 30px;
            padding: 20px;
            background: var(--secondary-color);
            border-radius: var(--border-radius);
        }

        .rating-container {
            margin: 20px 0;
        }

        .star-rating {
            display: inline-flex;
            flex-direction: row-reverse;
            gap: 5px;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            color: #ddd;
            cursor: pointer;
            font-size: 25px;
            padding: 5px;
        }

        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: #ffd700;
        }

        .comment-container textarea {
            width: 100%;
            min-height: 100px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            margin-top: 5px;
            font-family: inherit;
        }

        .submit-review-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: var(--border-radius);
            cursor: pointer;
            margin-top: 15px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .submit-review-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <?php if (isset($_SESSION['payment_completed'])): ?>
        <?php if (isset($_SESSION['thank_you_message'])): ?>
            <div class="thank-you-message" id="thankYouMessage">
                <i class="fas fa-check-circle" style="font-size: 24px; color: #28a745; margin-bottom: 10px;"></i><br>
                <?= htmlspecialchars($_SESSION['thank_you_message']) ?>
            </div>
            <?php unset($_SESSION['thank_you_message']); ?>
        <?php endif; ?>
        
        <?php if (!empty($_SESSION['products_to_review'])): ?>
            <div class="review-form-container">
                <h2 class="section-title">
                    <i class="fas fa-star"></i>
                    Beri Ulasan Produk
                </h2>
                
                <?php foreach ($_SESSION['products_to_review'] as $index => $product): ?>
                    <?php if (!hasUserReviewed($koneksi, $product['produk_id'], $_SESSION['user_id'])): ?>
                        <form action="" method="POST" class="product-review-form">
                            <input type="hidden" name="action" value="submit_review">
                            <input type="hidden" name="produk_id" value="<?= htmlspecialchars($product['produk_id']) ?>">
                            
                            <div class="product-name">
                                <h3><?= htmlspecialchars($product['produk_nama']) ?></h3>
                            </div>
                            
                            <div class="rating-container">
                                <label>Rating:</label>
                                <div class="star-rating">
                                    <?php for ($i = 5; $i >= 1; $i--): ?>
                                        <input type="radio" name="rating" value="<?= $i ?>" id="star<?= $i ?>_<?= $index ?>" required>
                                        <label for="star<?= $i ?>_<?= $index ?>"><i class="fas fa-star"></i></label>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            
                            <div class="comment-container">
                                <label for="komentar_<?= $index ?>">Komentar:</label>
                                <textarea name="komentar" id="komentar_<?= $index ?>" required></textarea>
                            </div>
                            
                            <button type="submit" class="submit-review-btn">Kirim Ulasan</button>
                        </form>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <?php 
            unset($_SESSION['payment_completed']); // Clear the payment flag
            ?>
            <script>
                window.location.href = 'index.php?message=order_completed';
            </script>
        <?php endif; ?>
    
    <?php elseif ($cart_id): ?>
        <!-- Payment form -->
        <form action="" method="POST">
            <input type="hidden" name="cart_id" value="<?= htmlspecialchars($cart_id) ?>">

            <div class="order-summary">
                <h2 class="section-title">
                    <i class="fas fa-shopping-cart"></i>
                    Ringkasan Pesanan
                </h2>
                <?php
                $result = displayCartById($koneksi, $cart_id);
                $total = 0;
                if ($result && $result->num_rows > 0):
                    while ($row = $result->fetch_assoc()):
                        $total += $row['total_harga'];
                ?>
                        <div class="cart-item">
                            <div class="product-info">
                                <h3><?= htmlspecialchars($row['produk']) ?></h3>
                                <p><?= htmlspecialchars($row['deskripsi']) ?></p>
                            </div>
                            <div class="quantity">
                                Jumlah: <?= htmlspecialchars($row['jumlah']) ?>
                            </div>
                            <div class="price">
                                Rp<?= number_format($row['total_harga'], 0, ',', '.') ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>

            <div class="shipping-address">
                <h2 class="section-title">
                    <i class="fas fa-map-marker-alt"></i>
                    Alamat Pengiriman
                </h2>
                <div class="address-content">
                    <?= htmlspecialchars(getCartAddress($koneksi, $cart_id)) ?>
                </div>
            </div>

            <div class="total-section">
                <h2 class="section-title">
                    <i class="fas fa-receipt"></i>
                    Total Pembayaran
                </h2>
                <div class="total-price">
                    Rp<?= number_format($total, 0, ',', '.') ?>
                </div>
                <button type="submit" name="pay" class="pay-button">
                    <i class="fas fa-lock"></i>
                    Bayar Sekarang
                </button>
            </div>
        </form>
    <?php else: ?>
        <p style="text-align: center; color: #636e72;">Tidak ada cart ID yang diberikan.</p>
    <?php endif; ?>
</div>

<script>
setTimeout(function() {
    var message = document.getElementById('thankYouMessage');
    if (message) {
        message.style.opacity = '0';
        message.style.transition = 'opacity 0.5s ease';
    }
}, 3000);
</script>
</body>
</html>