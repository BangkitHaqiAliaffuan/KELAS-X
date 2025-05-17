<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "toko_online");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get order ID from URL
$order_id = $_GET['id'];

// Fetch order details
$order_query = "SELECT 
    o.*, 
    u.email as user_email, 
    p.instructions as payment_instructions,
    p.is_paid as payment_is_paid
FROM orders o
LEFT JOIN users u ON o.user_id = u.id
LEFT JOIN payment_details p ON o.payment_id = p.id
WHERE o.id = ?";
$stmt = $conn->prepare($order_query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order_result = $stmt->get_result();
$order = $order_result->fetch_assoc();

if (!$order) {
    die("Order not found.");
}

// Handle "Mark as Paid" action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'mark_paid') {
    $conn->begin_transaction();

    try {
        // Update payment_details to mark as paid
        $update_query = "UPDATE payment_details SET is_paid = 1 WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("i", $order['payment_id']);
        $stmt->execute();

        // Update order status to 'done'
        $update_order_status = "UPDATE orders SET status = 'done' WHERE id = ?";
        $stmt = $conn->prepare($update_order_status);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();

        // Insert the order into owned_games
        $user_id = $order['user_id'];
        $product_id = $order['product_id'];
        $purchase_date = date('Y-m-d H:i:s'); // Current date and time
        $is_favorite = 0; // Default to not favorite
        $install_status = 'not_installed'; // Default to not installed

        // Check if the user already owns this product
        $check_query = "SELECT COUNT(*) FROM owned_games WHERE user_id = ? AND product_id = ?";
        $check_stmt = $conn->prepare($check_query);
        $check_stmt->bind_param("ii", $user_id, $product_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        $count = $check_result->fetch_row()[0];

        // If the user does not already own this product, insert it
        if ($count == 0) {
            $insert_query = "INSERT INTO owned_games (user_id, product_id, purchase_date, is_favorite, install_status)
                             VALUES (?, ?, ?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_query);
            $insert_stmt->bind_param("iisis", $user_id, $product_id, $purchase_date, $is_favorite, $install_status);
            $insert_stmt->execute();
        }

        // Commit transaction
        $conn->commit();

        // Redirect to refresh the page or show success message
        header("Location: ?id=" . $order_id . "&status=paid");
        exit();
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        die("Error updating payment status or adding to owned_games: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --epic-dark: #121212;
            --epic-darker: #202020;
            --epic-blue: #037BEE;
            --epic-hover: #0060BC;
            --epic-text: #E7E7E7;
            --epic-secondary: #666666;
        }

        body {
            background-color: var(--epic-dark);
            color: var(--epic-text);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            max-width: 1200px;
            padding: 2rem;
        }

        h2 {
            color: white;
            font-weight: 600;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid var(--epic-blue);
            padding-bottom: 0.5rem;
        }

        .card {
            background-color: var(--epic-darker);
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 2rem;
        }

        h4 {
            color: white;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        p {
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        strong {
            color: white;
            font-weight: 600;
        }

        .btn-primary {
            background-color: var(--epic-blue);
            border: none;
            padding: 0.8rem 1.5rem;
            font-weight: 600;
            transition: background-color 0.2s ease;
        }

        .btn-primary:hover {
            background-color: var(--epic-hover);
        }

        .btn-mark-paid {
            background-color: #28a745;
            border: none;
            padding: 0.8rem 1.5rem;
            font-weight: 600;
            transition: background-color 0.2s ease;
        }

        .btn-mark-paid:hover {
            background-color: #218838;
        }

        .btn-mark-paid:disabled {
            background-color: #666;
            cursor: not-allowed;
        }

        .order-status {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            background-color: var(--epic-blue);
            color: white;
            font-weight: 600;
        }

        .payment-instructions {
            background-color: rgba(255, 255, 255, 0.05);
            padding: 1.5rem;
            border-radius: 6px;
            margin-top: 1rem;
            margin-bottom: 2rem;
        }

        .order-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .order-info-item {
            color: white;
            background-color: rgba(255, 255, 255, 0.05);
            padding: 1rem;
            border-radius: 6px;
        }

        .success-message {
            background-color: #28a745;
            color: white;
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Order Detail</h2>
        <div class="card">
            <div class="card-body">
                <?php if (isset($_GET['status']) && $_GET['status'] === 'paid'): ?>
                    <div class="success-message">
                        Payment marked as paid successfully!
                    </div>
                <?php endif; ?>

                <div class="order-info">
                    <div class="order-info-item">
                        <h4 class="mb-3">Order ID: <?= htmlspecialchars($order['id']) ?></h4>
                        <p><strong>Customer Email:</strong><br><?= htmlspecialchars($order['user_email']) ?></p>
                    </div>
                    <div class="order-info-item">
                        <a href="?menu=produk_detail&id=<?= $order['product_id'] ?>">
                            <p><strong>Product ID:</strong><br><?= htmlspecialchars($order['product_id']) ?></p>
                            <p><strong>Amount:</strong><br>IDR <?= number_format($order['amount'], 0) ?></p>
                        </a>
                    </div>
                    <div class="order-info-item">
                        <p><strong>Status:</strong><br><span class="order-status"><?= ucfirst($order['status']) ?></span></p>
                        <p><strong>Order Date:</strong><br><?= date('d F Y H:i', strtotime($order['order_date'])) ?></p>
                    </div>
                </div>

                <h4>Payment Instructions</h4>
                <div class="payment-instructions">
                    <?= htmlspecialchars($order['payment_instructions']) ?>
                </div>

                <!-- Form to Mark as Paid -->
                <form method="POST" action="">
                    <input type="hidden" name="action" value="mark_paid">
                    <button type="submit" class="btn btn-mark-paid" <?= $order['payment_is_paid'] ? 'disabled' : '' ?>>
                        <?= $order['payment_is_paid'] ? 'Already Paid' : 'Mark as Paid' ?>
                    </button>
                </form>

                <a href="?page=orders" class="btn btn-primary">Back to Orders</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>