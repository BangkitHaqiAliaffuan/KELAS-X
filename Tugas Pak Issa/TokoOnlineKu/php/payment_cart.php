<?php
include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("location: index.php?menu=login");
    exit();
}

// Check if cart is empty
if (empty($_SESSION['cart'])) {
    header("location: index.php?menu=cart");
    exit();
}

$user_id = $_SESSION['user_id'];

// Calculate total from cart
function generateCartId() {
    // Gunakan microtime untuk resolusi milidetik
    $timestamp = (int)(microtime(true) * 1000); // Mengalikan dengan 1000 untuk konversi ke milidetik
    $random = mt_rand(1000, 9999);
    $cart_id = (string)($timestamp . $random); // Gabungkan timestamp dan random
    
    // Pastikan panjangnya sesuai dengan kapasitas kolom di database (misalnya, BIGINT)
    global $conn;
    $check_query = "SELECT COUNT(*) as count FROM cart_orders WHERE cart_id = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("s", $cart_id); // Gunakan string karena nilai bisa panjang
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->fetch_assoc()['count'];
    
    // Jika cart_id sudah ada, generate ulang secara rekursif
    if ($count > 0) {
        return generateCartId();
    }
    
    return $cart_id;
}

function getCartTotalWithTax() {
    $subtotal = 0;
    foreach ($_SESSION['cart'] as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }
    return $subtotal * 1.1; // Including 10% tax
}

// Handle payment processing
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'process_payment') {
    $total_amount = getCartTotalWithTax();
    $payment_method = $_POST['payment_method'];

    // Start transaction
    $conn->begin_transaction();

    try {
        // Generate payment instructions first
        $payment_instructions = generatePaymentInstructions($payment_method, $total_amount);
        
        // Insert payment details first to get payment_id
        $payment_query = "INSERT INTO payment_details (instructions, expire_time) VALUES (?, DATE_ADD(NOW(), INTERVAL 24 HOUR))";
        $stmt = $conn->prepare($payment_query);
        $stmt->bind_param("s", $payment_instructions);
        $stmt->execute();
        $payment_id = $conn->insert_id;
        $cart_id = generateCartId();

        // Insert orders for each cart item with payment_id
        foreach ($_SESSION['cart'] as $item) {
            // Create order in cart_orders table
            $order_query = "INSERT INTO cart_orders (
                user_id,
                product_id,
                quantity,
                price,
                created_at,
                cart_id,
                status,
                payment_method,
                payment_id
            ) VALUES (?, ?, ?, ?, NOW(), ?, 'pending', ?, ?)";

            $stmt = $conn->prepare($order_query);
            $stmt->bind_param(
                "iiidssi", // i=integer, i=integer, i=integer, d=double, s=string, s=string, i=integer
                $user_id,
                $item['id'],
                $item['quantity'],
                $item['price'],
                $cart_id,
                $payment_method,
                $payment_id
            );
            $stmt->execute();
            $last_order_id = $conn->insert_id;

            // Update payment_details with the last order_id
            $update_payment_query = "UPDATE payment_details SET order_id = ? WHERE id = ?";
            $stmt = $conn->prepare($update_payment_query);
            $stmt->bind_param("ii", $last_order_id, $payment_id);
            $stmt->execute();
        }

        // Commit transaction
        $conn->commit();

        // Store cart_id in session for reference
        $_SESSION['temp_cart_id'] = $cart_id;
        $_SESSION['temp_order_id'] = $last_order_id;

        // Redirect to show payment details
        header("Location: " . $_SERVER['PHP_SELF'] . "?menu=payment_cart&order_created=1");
        exit();
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        $_SESSION['error'] = "An error occurred while processing your order. Please try again.";

        header("Location: index.php?menu=cart");
        exit();
    }
}

// Handle "Mark as Paid" action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'mark_paid' && isset($_POST['cart_id'])) {
    $cart_id = $_POST['cart_id'];

    // Start transaction
    $conn->begin_transaction();

    try {
        // Update payment status for all orders in the cart
        $update_orders = "UPDATE cart_orders SET status = 'done' WHERE cart_id = ? AND user_id = ?";
        $stmt = $conn->prepare($update_orders);
        $stmt->bind_param("si", $cart_id, $user_id);
        $stmt->execute();

        $update_paid = "UPDATE payment_details SET is_paid = 1 WHERE order_id IN (
            SELECT id FROM cart_orders WHERE cart_id = ? AND user_id = ?
        )";
        $stmt = $conn->prepare($update_paid);
        $stmt->bind_param("si", $cart_id, $user_id);
        $stmt->execute();

        // Get purchased product IDs
        $get_items = "SELECT product_id FROM cart_orders WHERE cart_id = ? AND user_id = ?";
        $stmt = $conn->prepare($get_items);
        $stmt->bind_param("si", $cart_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Store purchased products in session and also collect product IDs for library
        if (!isset($_SESSION['purchased_products'])) {
            $_SESSION['purchased_products'] = array();
        }
        
        $product_ids = array();

        while ($order = $result->fetch_assoc()) {
            if (!in_array($order['product_id'], $_SESSION['purchased_products'])) {
                $_SESSION['purchased_products'][] = $order['product_id'];
            }
            $product_ids[] = $order['product_id'];
        }

        // Add games to user's library
        if (!empty($product_ids)) {
            $add_game = "INSERT INTO owned_games (user_id, product_id) VALUES (?, ?)";
            $stmt = $conn->prepare($add_game);
            
            foreach ($product_ids as $product_id) {
                $stmt->bind_param("ii", $user_id, $product_id);
                $stmt->execute();
            }
        }

        // Commit transaction
        $conn->commit();
        
        // Clear cart and redirect
        $_SESSION['cart'] = [];
        header("Location: index.php?menu=library&thank_you=1");
        exit();
    } catch (Exception $e) {
        // Rollback on error
        $conn->rollback();
        $_SESSION['error'] = "An error occurred while processing your payment: " . $e->getMessage();
        header("Location: index.php?menu=cart");
        exit();
    }
}

function generatePaymentInstructions($payment_method, $total_amount) {
    $formatted_amount = number_format($total_amount, 0, ',', '.');

    switch ($payment_method) {
        case 'bank_transfer':
            return "Please transfer the total amount to:\n\n" .
                "Bank: GameStore Bank\n" .
                "Account Number: 1234-5678-9012-3456\n" .
                "Account Name: Game Store Official\n\n" .
                "Total Amount: IDR {$formatted_amount}\n\n" .
                "Please complete the payment within 24 hours.\n" .
                "After payment, click 'Mark as Paid' button below.";

        case 'e_wallet':
            return "Please pay using your E-Wallet:\n\n" .
                "Scan the QR code below or use ID: GS-" . rand(1000000, 9999999) . "\n" .
                "Total Amount: IDR {$formatted_amount}\n\n" .
                "Please complete the payment within 24 hours.\n" .
                "Payment will be automatically verified.";

        default:
            return "Invalid payment method selected.";
    }
}

// Get owned games to prevent duplicate purchases
$owned_query = "SELECT product_id FROM owned_games WHERE user_id = ?";
$stmt = $conn->prepare($owned_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$owned_result = $stmt->get_result();
$owned_games = [];
while ($row = $owned_result->fetch_assoc()) {
    $owned_games[] = $row['product_id'];
}

// Check if any cart items are already owned
$duplicate_items = [];
foreach ($_SESSION['cart'] as $product_id => $item) {
    if (in_array($product_id, $owned_games)) {
        $duplicate_items[] = $item['name'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart Payment</title>
</head>
<style>
    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        background: #121212;
        color: white;
        margin: 0;
    }

    .container {
        margin-top: 400px;
        max-width: 800px;
        margin: 0 auto;
        background: #18181b;
        padding: 24px;
        border-radius: 12px;
    }

    .warning {
        background: #ff4444;
        color: white;
        padding: 16px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .order-summary {
        background: #1f1f23;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 24px;
    }

    .payment-instructions {
        background: #1f1f23;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 24px;
        white-space: pre-line;
    }

    .order-item {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #2a2a2a;
    }

    .payment-methods {
        display: flex;
        gap: 16px;
        margin-bottom: 24px;
    }

    .payment-method {
        flex: 1;
        padding: 16px;
        border: 2px solid #2a2a2a;
        border-radius: 8px;
        cursor: pointer;
        text-align: center;
    }

    .payment-method.selected {
        border-color: #0078f2;
        background: rgba(0, 120, 242, 0.1);
    }

    .btn {
        border: none;
        padding: 16px 32px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        width: 100%;
        margin-top: 24px;
        cursor: pointer;
        transition: opacity 0.2s;
    }

    .btn:hover {
        opacity: 0.9;
    }

    .btn-proceed {
        background: #0078f2;
        color: white;
    }

    .btn-mark-paid {
        background: #28a745;
        color: white;
    }

    .btn:disabled {
        background: #666;
        cursor: not-allowed;
    }
</style>

<body>
    <div class="container">
        <h1>Order Summary</h1>

        <?php if (!empty($duplicate_items)): ?>
            <div class="warning">
                <h3>Warning: Already Owned Games</h3>
                <p>The following games are already in your library:</p>
                <ul>
                    <?php foreach ($duplicate_items as $game): ?>
                        <li><?php echo htmlspecialchars($game); ?></li>
                    <?php endforeach; ?>
                </ul>
                <p>Please remove these items from your cart before proceeding.</p>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['order_created']) && isset($_SESSION['temp_order_id'])): ?>
            <div class="payment-instructions">
                <h3>Payment Instructions</h3>
                <?php
                // Dapatkan payment_id dari order
                $get_payment_id = "SELECT payment_id FROM cart_orders WHERE id = ?";
                $stmt = $conn->prepare($get_payment_id);
                $stmt->bind_param("i", $_SESSION['temp_order_id']);
                $stmt->execute();
                $payment_result = $stmt->get_result();
                
                if ($payment_result && $payment_data = $payment_result->fetch_assoc()) {
                    // Gunakan payment_id untuk mendapatkan detail pembayaran
                    $order_query = "SELECT co.*, pd.instructions, pd.expire_time, pd.is_paid 
                                   FROM cart_orders co
                                   JOIN payment_details pd ON pd.id = ?
                                   WHERE co.payment_id = ? AND co.user_id = ?
                                   GROUP BY co.cart_id";
                    
                    $stmt = $conn->prepare($order_query);
                    $payment_id = $payment_data['payment_id'];
                    $stmt->bind_param("iii", $payment_id, $payment_id, $_SESSION['user_id']);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    if ($result && $order = $result->fetch_assoc()) {
                        // Tampilkan instruksi pembayaran
                        echo htmlspecialchars($order['instructions']);
                        
                        // Tampilkan detail order
                        ?>
                        <div class="order-details">
                            <h4>Order Details</h4>
                            <p>Order Time: <?php echo date('d M Y H:i', strtotime($order['created_at'])); ?></p>
                            <p>Payment Method: <?php echo ucfirst(str_replace('_', ' ', $order['payment_method'])); ?></p>
                            <p>Status: <?php echo ucfirst($order['status']); ?></p>
                            <p>Expires: <?php echo date('d M Y H:i', strtotime($order['expire_time'])); ?></p>
                        </div>
                        
                        <!-- Form Mark as Paid -->
                        <form method="POST" action="">
                            <input type="hidden" name="action" value="mark_paid">
                            <input type="hidden" name="cart_id" value="<?php echo htmlspecialchars($order['cart_id']); ?>">
                            <button type="submit" class="btn btn-mark-paid" <?php echo $order['is_paid'] ? 'disabled' : ''; ?>>
                                <?php echo $order['is_paid'] ? 'Already Paid' : 'Mark as Paid'; ?>
                            </button>
                        </form>
                        <?php
                    } else {
                        echo "<div class='error'>Error: Order details not found.</div>";
                    }
                } else {
                    echo "<div class='error'>Error: Payment ID not found.</div>";
                }
                ?>
            </div>
        <?php else: ?>
            <div class="order-summary">
                <?php foreach ($_SESSION['cart'] as $item): ?>
                    <div class="order-item">
                        <span><?php echo htmlspecialchars($item['name']); ?></span>
                        <span>IDR <?php echo number_format($item['price'], 0, ',', '.'); ?></span>
                    </div>
                <?php endforeach; ?>

                <div class="order-item">
                    <strong>Subtotal</strong>
                    <span>IDR <?php echo number_format(getCartTotalWithTax() / 1.1, 0, ',', '.'); ?></span>
                </div>

                <div class="order-item">
                    <span>Tax (10%)</span>
                    <span>IDR <?php echo number_format((getCartTotalWithTax() / 1.1) * 0.1, 0, ',', '.'); ?></span>
                </div>

                <div class="order-item">
                    <strong>Total</strong>
                    <strong>IDR <?php echo number_format(getCartTotalWithTax(), 0, ',', '.'); ?></strong>
                </div>
            </div>

            <h3>Select Payment Method</h3>
            <form method="POST" action="">
                <input type="hidden" name="action" value="process_payment">

                <div class="payment-methods">
                    <label class="payment-method">
                        <input type="radio" name="payment_method" value="bank_transfer" required>
                        <h4>Bank Transfer</h4>
                        <p>Pay via bank transfer</p>
                    </label>

                    <label class="payment-method">
                        <input type="radio" name="payment_method" value="e_wallet" required>
                        <h4>E-Wallet</h4>
                        <p>Pay using your e-wallet</p>
                    </label>
                </div>

                <button type="submit" class="btn btn-proceed" <?php echo !empty($duplicate_items) ? 'disabled' : ''; ?>>
                    Proceed to Payment
                </button>
            </form>
        <?php endif; ?>
    </div>

    <script>
        document.querySelectorAll('.payment-method input').forEach(input => {
            input.addEventListener('change', function() {
                document.querySelectorAll('.payment-method').forEach(method => {
                    method.classList.remove('selected');
                });
                if (this.checked) {
                    this.closest('.payment-method').classList.add('selected');
                }
            });
        });
    </script>
</body>

</html>