<?php
include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("location: index.php?menu=login");
    exit();
}

// Get user information
$user_id = $_SESSION['user_id'];
$user_query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Get order details if product_id is set
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    $product_query = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($product_query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();

    // Calculate final price with discount
    $final_price = $product['price'];
    if ($product['discount'] > 0) {
        $final_price = $product['price'] * (1 - ($product['discount'] / 100));
    }
}

// Handle payment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payment_method = $_POST['payment_method'];
    $product_id = intval($_POST['product_id']);
    
    // Start transaction
    $conn->begin_transaction();
    
    try {
        // Create new order (without payment_id for now)
        $order_query = "INSERT INTO orders (user_id, product_id, amount, payment_method, status) VALUES (?, ?, ?, ?, 'pending')";
        $stmt = $conn->prepare($order_query);
        $stmt->bind_param("iids", $user_id, $product_id, $final_price, $payment_method);
        
        if ($stmt->execute()) {
            $order_id = $conn->insert_id;
            
            // Generate payment instructions
            $payment_instructions = generatePaymentInstructions($payment_method, $order_id, $final_price);
            
            // Insert payment details and get payment_id
            $payment_query = "INSERT INTO payment_details (order_id, instructions, expire_time) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 24 HOUR))";
            $stmt = $conn->prepare($payment_query);
            $stmt->bind_param("is", $order_id, $payment_instructions);
            $stmt->execute();
            $payment_id = $conn->insert_id;
            
            // Update order with payment_id
            $update_order_query = "UPDATE orders SET payment_id = ? WHERE id = ?";
            $stmt = $conn->prepare($update_order_query);
            $stmt->bind_param("ii", $payment_id, $order_id);
            $stmt->execute();
            
            // Commit transaction
            $conn->commit();
            
            // Redirect to payment instruction page
            header("Location: index.php?menu=payment_instruction&order_id=" . $order_id . "&id=" . $product_id);
            exit();
        }
    } catch (Exception $e) {
        // Rollback on error
        $conn->rollback();
        echo "Error processing payment: " . $e->getMessage();
    }
}

// Function to generate payment instructions
function generatePaymentInstructions($method, $order_id, $amount) {
    $instructions = '';
    switch ($method) {
        case 'bank_transfer':
            $instructions = "Bank Transfer Instructions:\n";
            $instructions .= "Bank: Example Bank\n";
            $instructions .= "Account Number: 1234-5678-9012\n";
            $instructions .= "Account Name: Game Store\n";
            $instructions .= "Amount: IDR " . number_format($amount, 0) . "\n";
            $instructions .= "Reference: ORDER-" . str_pad($order_id, 8, '0', STR_PAD_LEFT);
            break;
        
        case 'e_wallet':
            $instructions = "E-Wallet Payment Instructions:\n";
            $instructions .= "1. Open your e-wallet app\n";
            $instructions .= "2. Scan this QR code or enter this ID: GS-" . str_pad($order_id, 8, '0', STR_PAD_LEFT) . "\n";
            $instructions .= "3. Enter amount: IDR " . number_format($amount, 0) . "\n";
            $instructions .= "4. Confirm payment";
            break;
    }
    return $instructions;
}
?>

<!DOCTYPE html>
<!-- Rest of the HTML code remains the same -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Payment</title>
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

        .order-summary {
            background: #1f1f23;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 24px;
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .product-image {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
        }

        .price-details {
            border-top: 1px solid #333;
            padding-top: 20px;
            margin-top: 20px;
        }

        .payment-methods {
            display: grid;
            gap: 16px;
            margin-top: 24px;
        }

        .payment-method {
            background: #1f1f23;
            padding: 16px;
            border-radius: 8px;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .payment-method.selected {
            border-color: #0078f2;
        }

        .payment-method-header {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .method-icon {
            width: 32px;
            height: 32px;
            background: #333;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-pay {
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

        .btn-pay:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Order Payment</h1>
        
        <?php if (isset($product)): ?>
        <div class="order-summary">
            <div class="product-info">
                <img src="uploads/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image">
                <div>
                    <h2><?= htmlspecialchars($product['name']) ?></h2>
                    <?php if ($product['discount'] > 0): ?>
                        <p>Discount: <?= $product['discount'] ?>%</p>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="price-details">
                <p>Original Price: IDR <?= number_format($product['price'], 0) ?></p>
                <?php if ($product['discount'] > 0): ?>
                    <p>Discount Amount: IDR <?= number_format($product['price'] - $final_price, 0) ?></p>
                <?php endif; ?>
                <h3>Final Price: IDR <?= number_format($final_price, 0) ?></h3>
            </div>
        </div>

        <form method="POST" action="">
            <input type="hidden" name="product_id" value="<?= $product_id ?>">
            
            <h2>Select Payment Method</h2>
            <div class="payment-methods">
                <label class="payment-method">
                    <div class="payment-method-header">
                        <input type="radio" name="payment_method" value="bank_transfer" required>
                        <div class="method-icon">🏦</div>
                        <div>
                            <h3>Bank Transfer</h3>
                            <p>Transfer to our bank account</p>
                        </div>
                    </div>
                </label>

                <label class="payment-method">
                    <div class="payment-method-header">
                        <input type="radio" name="payment_method" value="e_wallet" required>
                        <div class="method-icon">📱</div>
                        <div>
                            <h3>E-Wallet</h3>
                            <p>Pay using your preferred e-wallet</p>
                        </div>
                    </div>
                </label>
            </div>

            <button type="submit" class="btn-pay">Proceed to Payment</button>
        </form>
        <?php else: ?>
            <p>No product selected. Please go back to the product page.</p>
        <?php endif; ?>
    </div>

    <script>
        // Add selected class to payment method when radio is checked
        document.querySelectorAll('input[name="payment_method"]').forEach(input => {
            input.addEventListener('change', function() {
                document.querySelectorAll('.payment-method').forEach(method => {
                    method.classList.remove('selected');
                });
                this.closest('.payment-method').classList.add('selected');
            });
        });
    </script>
</body>
</html>