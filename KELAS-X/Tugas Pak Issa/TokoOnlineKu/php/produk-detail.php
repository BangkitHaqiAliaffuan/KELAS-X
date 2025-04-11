<?php
// Uncomment session_start() to enable sessions
// session_start(); // This needs to be uncommented for sessions to work
include 'config.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$product_id = intval($_GET['id']);
$query = "SELECT p.*, c.name as category_name 
          FROM products p
          LEFT JOIN categories c ON p.category_id = c.id
          WHERE p.id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: index.php');
    exit();
}

$product = $result->fetch_assoc();

// Get product images (assuming you have a product_images table)
$images_query = "SELECT image_url FROM product_images WHERE product_id = ? LIMIT 3";
$stmt = $conn->prepare($images_query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$images_result = $stmt->get_result();
$images = [];
while ($row = $images_result->fetch_assoc()) {
    $images[] = $row['image_url'];
}

function getReviewStats($conn, $product_id)
{
    $query = "SELECT COUNT(*) as total, AVG(rating) as average 
              FROM reviews 
              WHERE product_id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Get reviews
function getReviews($conn, $product_id)
{
    $query = "SELECT r.*, u.username 
              FROM reviews r
              JOIN users u ON r.user_id = u.id
              WHERE r.product_id = ?
              ORDER BY r.created_at DESC";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    return $stmt->get_result();
}

// Get statistics and reviews
$stats = getReviewStats($conn, $product_id);
$reviews = getReviews($conn, $product_id);

// Improved check for whether user can review
$can_review = false;
if (isset($_SESSION['user_id'])) {
    if (isset($_SESSION['purchased_products'])) {
        $can_review = in_array($product_id, $_SESSION['purchased_products']);
    }
    // For debugging: Uncomment if needed
    // else {
    //     $_SESSION['error'] = "No purchased products found in session";
    // }
} 
// For debugging: Uncomment if needed
// else {
//     $_SESSION['error'] = "User not logged in";
// }

// Handle review submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'submit_review') {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['error'] = "You must be logged in to submit a review.";
        header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $product_id);
        exit();
    }
    
    if (!$can_review) {
        $_SESSION['error'] = "You must purchase this product before leaving a review.";
        header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $product_id);
        exit();
    }

    $rating = intval($_POST['rating']);
    $review_text = trim($_POST['review_text']);
    $user_id = $_SESSION['user_id'];

    if ($rating < 1 || $rating > 5) {
        $_SESSION['error'] = "Invalid rating value.";
        header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $product_id);
        exit();
    }

    // Check if user already reviewed this product
    $check_query = "SELECT id FROM reviews WHERE user_id = ? AND product_id = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("ii", $user_id, $product_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $existing_review = $check_result->fetch_assoc();

    if ($existing_review) {
        // Update existing review
        $_SESSION['error'] = "You're already review this product";
    } else {
        // Insert new review
        $insert_query = "INSERT INTO reviews (user_id, product_id, rating, review_text, created_at) VALUES (?, ?, ?, ?, NOW())";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("iiis", $user_id, $product_id, $rating, $review_text);
        
        if ($insert_stmt->execute()) {
            $_SESSION['success'] = "Your review has been submitted successfully.";
        } else {
            $_SESSION['error'] = "An error occurred while submitting your review: " . $conn->error;
        }
    }

    // Redirect back to the product page
    header("Location: ?menu=produk_detail&id=" . $product_id);
    exit();
}

// HTML content starts after this line...
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']) ?></title>
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
        
        /* Notification styling for success/error messages */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        
        .alert-success {
            background-color: #4CAF50;
            color: white;
        }
        
        .alert-danger {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>

<body>
    <div class="product-container">
        <!-- Display error or success messages -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($_SESSION['error']) ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_SESSION['success']) ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <!-- For debugging: uncomment to see session data -->
        <?php 
        // echo '<pre>Session: ';
        // print_r($_SESSION);
        // echo '</pre>';
        ?>

        <h1 class="product-title"><?= htmlspecialchars($product['name']) ?></h1>

        <nav class="product-nav">
            <a href="#overview" class="nav-link active">Overview</a>
        </nav>

        <div class="banner-container">
            <div class="banner-slider" id="bannerSlider">
                <?php foreach ($images as $image): ?>
                    <div class="banner-slide">
                        <img src="./<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="slider-arrows">
                <button class="arrow" onclick="prevSlide()">❮</button>
                <button class="arrow" onclick="nextSlide()">❯</button>
            </div>

            <div class="banner-nav">
                <?php foreach ($images as $index => $image): ?>
                    <div class="thumbnail <?= $index === 0 ? 'active' : '' ?>" onclick="goToSlide(<?= $index ?>)">
                        <img src="<?= htmlspecialchars($image) ?>" alt="Thumbnail">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="price-container">
            <?php if ($product['discount'] > 0): ?>
                <div class="offer-banner">
                    <i>🔥</i>
                    <span class="offer-text">Special Offer!</span>
                    <span class="offer-timer" id="offerTimer">23:59:59</span>
                </div>
            <?php endif; ?>

            <div class="price-wrapper">
                <?php if ($product['price'] == 0): ?>
                    <span class="free-label">Free to Play</span>
                <?php else: ?>
                    <?php if ($product['discount'] > 0): ?>
                        <span class="discount-tag">-<?= $product['discount'] ?>%</span>
                        <div class="price-display">
                            <span class="original-price">
                                <span class="currency">IDR</span>
                                <?= number_format($product['price'], 0) ?>
                            </span>
                            <span class="current-price">
                                <span class="currency">IDR</span>
                                <span class="amount"><?= number_format($product['price'] * (1 - ($product['discount'] / 100)), 0) ?></span>
                            </span>
                        </div>
                    <?php else: ?>
                        <div class="price-display">
                            <span class="current-price">
                                <span class="currency">IDR</span>
                                <span class="amount"><?= number_format($product['price'], 0) ?></span>
                            </span>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <div class="action-buttons">
                <a href="?menu=order&id=<?= $product['id'] ?>">
                    <button class="btn btn-buy">Buy Now</button>
                </a>
                <a href="?menu=cart&id=<?= $product['id'] ?>">
                    <button class="btn btn-cart">Add to Cart</button>
                </a>
            </div>
        </div>

        <div class="game-description">
            <?php
            // Split description by double newlines to separate paragraphs
            $paragraphs = explode("\n\n", $product['description']);
            ?>

            <?php foreach ($paragraphs as $paragraph): ?>
                <p><?= nl2br(htmlspecialchars($paragraph)) ?></p>
            <?php endforeach; ?>
        </div>

        <div class="system-requirements">
            <div class="requirements-section">
                <h2>System Requirements</h2>

                <div class="requirements-tabs">
                    <button class="tab-btn active">Windows</button>
                </div>

                <div class="requirements-grid">
                    <div class="requirements-column">
                        <h3>Minimum</h3>

                        <div class="requirement-item">
                            <span class="requirement-label">OS version</span>
                            <span class="requirement-value">Windows 10</span>
                        </div>

                        <div class="requirement-item">
                            <span class="requirement-label">CPU</span>
                            <span class="requirement-value">Ryzen 3 3100/Intel Core i5-1135G7</span>
                        </div>

                        <div class="requirement-item">
                            <span class="requirement-label">Memory</span>
                            <span class="requirement-value">8 GB RAM</span>
                        </div>

                        <div class="requirement-item">
                            <span class="requirement-label">GPU</span>
                            <span class="requirement-value">AMD Radeon RX 560/Nvidia GTX 1050</span>
                        </div>

                        <div class="requirement-item">
                            <span class="requirement-label">Storage</span>
                            <span class="requirement-value">650 MB available space</span>
                        </div>
                    </div>

                    <div class="requirements-column">
                        <h3>Recommended</h3>

                        <div class="requirement-item">
                            <span class="requirement-label">OS version</span>
                            <span class="requirement-value">Windows 10</span>
                        </div>

                        <div class="requirement-item">
                            <span class="requirement-label">CPU</span>
                            <span class="requirement-value">AMD Ryzen 5 5500U/Intel Core i5-9400F</span>
                        </div>

                        <div class="requirement-item">
                            <span class="requirement-label">Memory</span>
                            <span class="requirement-value">16 GB RAM</span>
                        </div>

                        <div class="requirement-item">
                            <span class="requirement-label">GPU</span>
                            <span class="requirement-value">AMD RX Vega 56/Nvidia GTX 1070</span>
                        </div>

                        <div class="requirement-item">
                            <span class="requirement-label">Storage</span>
                            <span class="requirement-value">650 MB available space</span>
                        </div>
                    </div>
                </div>
            </div>


            <div class="reviews-section">
                <h2 class="section-title">Customer Reviews</h2>

                <!-- Review Summary -->
                <div class="review-summary">
                    <div class="average-rating">
                        <span class="rating-number"><?= number_format($stats['average'] ?: 0, 1) ?></span>
                        <div class="rating-stars">
                            <?= str_repeat('★', round($stats['average'] ?: 0)) . str_repeat('☆', 5 - round($stats['average'] ?: 0)) ?>
                        </div>
                        <span class="total-reviews">Based on <?= $stats['total'] ?: 0 ?> reviews</span>
                    </div>
                </div>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($can_review): ?>
                        <div class="review-form">
                            <h3>Write a Review</h3>
                            <form method="POST" action="">
                                <input type="hidden" name="action" value="submit_review">

                                <div class="rating-input">
                                    <label>Rating:</label>
                                    <div class="star-rating">
                                        <?php for ($i = 5; $i >= 1; $i--): ?>
                                            <input type="radio" id="star<?php echo $i; ?>" name="rating" value="<?php echo $i; ?>" required>
                                            <label for="star<?php echo $i; ?>">★</label>
                                        <?php endfor; ?>
                                    </div>
                                </div>

                                <div class="review-input">
                                    <label for="review_text">Your Review:</label>
                                    <textarea id="review_text" name="review_text" rows="4" required></textarea>
                                </div>

                                <button type="submit" class="btn">Submit Review</button>
                            </form>
                        </div>
                    <?php else: ?>
                        <div class="review-form">
                            <p>You need to purchase this product before you can leave a review.</p>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="review-form">
                        <p>Please <a href="login.php">log in</a> to leave a review.</p>
                    </div>
                <?php endif; ?>

                <!-- Review List -->
                <div class="review-list">
                    <?php if ($reviews->num_rows > 0): ?>
                        <?php while ($review = $reviews->fetch_assoc()): ?>
                            <div class="review-item">
                                <div class="review-header">
                                    <div class="review-meta">
                                        <div class="user-name"><?= htmlspecialchars($review['username']) ?></div>
                                        <div class="review-stats">
                                            <div class="rating-stars">
                                                <?= str_repeat('★', $review['rating']) . str_repeat('☆', 5 - $review['rating']) ?>
                                            </div>
                                            <div class="review-date">
                                                <?= date('F j, Y', strtotime($review['created_at'])) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="review-content">
                                    <p><?= nl2br(htmlspecialchars($review['review_text'])) ?></p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="review-item">
                            <p>No reviews yet. Be the first to review this product!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <script>
            // Add this script to your product page
            function addToCart(productId, quantity = 1) {
                const formData = new FormData();
                formData.append('action', 'add_to_cart');
                formData.append('product_id', productId);
                formData.append('quantity', quantity);

                fetch('cart_functions.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success message
                            showNotification('Success', 'Product added to cart', 'success');

                            // Update cart count in UI if you have one
                            updateCartCount(data.cart_count);
                        } else {
                            showNotification('Error', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        showNotification('Error', 'Failed to add product to cart', 'error');
                        console.error('Error:', error);
                    });
            }

            // Notification function
            function showNotification(title, message, type) {
                const notification = document.createElement('div');
                notification.className = `notification ${type}`;
                notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 25px;
        background: ${type === 'success' ? '#4CAF50' : '#f44336'};
        color: white;
        border-radius: 4px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        z-index: 1000;
        animation: slideIn 0.3s ease-out;
    `;

                notification.innerHTML = `
        <h4 style="margin: 0 0 5px 0;">${title}</h4>
        <p style="margin: 0;">${message}</p>
    `;
    document.body.appendChild(notification);

setTimeout(() => {
    notification.style.animation = 'slideOut 0.3s ease-out';
    setTimeout(() => notification.remove(), 300);
}, 3000);
}

// Update cart count in UI
function updateCartCount(count) {
const cartCountElement = document.getElementById('cart-count');
if (cartCountElement) {
    cartCountElement.textContent = count;
}
}

// Add this to your CSS
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
`;
document.head.appendChild(style);

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

timerElement.innerText = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
}

if (document.getElementById('offerTimer')) {
setInterval(updateTimer, 1000);
}

let currentSlide = 0;
const slider = document.getElementById('bannerSlider');
const slides = document.querySelectorAll('.banner-slide');
const thumbnails = document.querySelectorAll('.thumbnail');
const totalSlides = slides.length;

function updateSlider() {
slider.style.transform = `translateX(-${currentSlide * 100}%)`;
thumbnails.forEach((thumb, index) => {
    thumb.classList.toggle('active', index === currentSlide);
});
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
}

// Optional: Auto-play
setInterval(nextSlide, 5000);
</script>
</body>
</html>