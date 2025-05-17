<?php
include 'config.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("location: index.php?menu=login");
    exit();
}

// Check if order_id is set
if (!isset($_GET['order_id'])) {
    header("location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$order_id = intval($_GET['order_id']);

// Get order and payment details
$order_query = "SELECT o.*, p.instructions, p.expire_time, p.is_paid, o.product_id FROM orders o
                JOIN payment_details p ON o.id = p.order_id
                WHERE o.id = ? AND o.user_id = ?";
$stmt = $conn->prepare($order_query);
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    header("location: index.php");
    exit();
}

// Get product_id from the order, not from GET parameter
$product_id = $order['product_id']; 

// Handle "Mark as Paid" button click
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_paid'])) {
    // Start transaction
    $conn->begin_transaction();

    try {
        // Update payment status
        $update_payment_query = "UPDATE payment_details SET is_paid = 1 WHERE order_id = ?";
        $stmt = $conn->prepare($update_payment_query);
        $stmt->bind_param("i", $order_id);
        $result1 = $stmt->execute();
        
        if (!$result1) {
            throw new Exception("Failed to update payment status: " . $conn->error);
        }

        // Update order status to 'done'
        $update_order_query = "UPDATE orders SET status = 'done' WHERE id = ?";
        $stmt = $conn->prepare($update_order_query);
        $stmt->bind_param("i", $order_id);
        $result2 = $stmt->execute();
        
        if (!$result2) {
            throw new Exception("Failed to update order status: " . $conn->error);
        }

        // Initialize purchased_products session if not exists
        if (!isset($_SESSION['purchased_products'])) {
            $_SESSION['purchased_products'] = array();
        }

        // Add to purchased products session if not already there
        if (!in_array($product_id, $_SESSION['purchased_products'])) {
            $_SESSION['purchased_products'][] = $product_id;
        }

        // Check if game is already in user's library
        $check_game_query = "SELECT * FROM owned_games WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($check_game_query);
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
        $existing_game = $stmt->get_result()->fetch_assoc();
        
        // Add game to user's library if not already there
        if (!$existing_game) {
            $add_game_query = "INSERT INTO owned_games (user_id, product_id) VALUES (?, ?)";
            $stmt = $conn->prepare($add_game_query);
            $stmt->bind_param("ii", $user_id, $product_id);
            $result3 = $stmt->execute();
            
            if (!$result3) {
                throw new Exception("Failed to add game to library: " . $conn->error);
            }
        }

        // Commit transaction
        $conn->commit();
        
        // For AJAX requests, return success response
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            echo json_encode(['success' => true]);
            exit();
        }
        
        // For normal form submission
        header("Location: index.php?menu=library&thank_you=1");
        exit();
    } catch (Exception $e) {
        // Rollback on error
        $conn->rollback();
        
        // Log the error
        error_log('Payment processing error: ' . $e->getMessage());
        
        // For AJAX requests
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            exit();
        }
        
        // For normal form submission
        $_SESSION['error'] = "An error occurred while processing your payment: " . $e->getMessage();
        header("Location: index.php?menu=cart");
        exit();
    }
}

// Format expire time
$expire_time = new DateTime($order['expire_time']);
$current_time = new DateTime();
$interval = $current_time->diff($expire_time);
$time_left = $interval->format('%h hours %i minutes');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Instructions</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #121212;
            color: white;
            margin: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #18181b;
            padding: 24px;
            border-radius: 12px;
        }

        .instructions {
            background: #1f1f23;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 24px;
            white-space: pre-line;
        }

        .timer {
            background: #1f1f23;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 24px;
            text-align: center;
        }

        .timer h2 {
            margin: 0;
            font-size: 24px;
        }

        .btn-back {
            background: #0078f2;
            color: white;
            border: none;
            padding: 16px 32px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            width: 100%;
            margin-top: 24px;
            cursor: pointer;
        }

        .btn-back:hover {
            opacity: 0.9;
        }

        .btn-mark-paid {
            background: #28a745;
            color: white;
            border: none;
            padding: 16px 32px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            width: 100%;
            margin-top: 24px;
            cursor: pointer;
        }

        .btn-mark-paid:hover {
            opacity: 0.9;
        }

        .thank-you-message {
            text-align: center;
            font-size: 20px;
            margin-top: 20px;
            color: #28a745;
        }

        .thank-you-purchasing {
            text-align: center;
            font-size: 24px;
            margin-top: 20px;
            color: #28a745;
            display: none; /* Hidden by default */
        }
        
        .error-message {
            text-align: center;
            font-size: 18px;
            margin-top: 20px;
            color: #dc3545;
            padding: 10px;
            background: rgba(220, 53, 69, 0.1);
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Payment Instructions</h1>

        <div class="timer">
            <h2>Time Left to Complete Payment: <?= $time_left ?></h2>
        </div>

        <div class="instructions">
            <?= htmlspecialchars($order['instructions']) ?>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message">
                <?= $_SESSION['error'] ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if ($order['is_paid'] == 0): ?>
            <form method="POST" action="" id="paymentForm">
                <input type="hidden" name="mark_paid" value="1">
                <button type="submit" class="btn-mark-paid">Mark as Paid</button>
            </form>
        <?php else: ?>
            <div class="thank-you-message">
                Thank you for your payment! Your order is being processed.
            </div>
        <?php endif; ?>

        <div class="thank-you-purchasing" id="thankYouPurchasing">
            Thank you for purchasing!
        </div>

        <button class="btn-back" onclick="window.location.href='index.php'">Back to Home</button>
    </div>

    <script>
        // Timer countdown
        const expireTime = new Date("<?= $order['expire_time'] ?>").getTime();

        const timer = setInterval(() => {
            const now = new Date().getTime();
            const timeLeft = expireTime - now;

            if (timeLeft <= 0) {
                clearInterval(timer);
                document.querySelector('.timer h2').textContent = "Payment time has expired!";
                return;
            }

            const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
            document.querySelector('.timer h2').textContent = `Time Left to Complete Payment: ${hours} hours ${minutes} minutes ${seconds} seconds`;
        }, 1000);

        // Handle "Mark as Paid" button click
        const paymentForm = document.getElementById('paymentForm');
        if (paymentForm) {
            paymentForm.addEventListener('submit', function(event) {
                // Show the "Thank you for purchasing" message
                const thankYouMessage = document.getElementById('thankYouPurchasing');
                thankYouMessage.style.display = 'block';
                
                // Continue with form submission (don't prevent default)
            });
        }
    </script>
</body>
</html>