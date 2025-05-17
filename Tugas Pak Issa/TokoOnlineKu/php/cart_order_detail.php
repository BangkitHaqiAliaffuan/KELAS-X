<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "toko_online");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get cart ID from URL
$cart_id = $_GET['cart_id'];

// Modified query to get all items with the same cart_id
$cart_order_query = "SELECT 
    co.*,
    u.email as user_email,
    p.instructions as payment_instructions,
    pd.name as product_name,
    pd.price as product_price,
    p.is_paid as payment_is_paid
FROM cart_orders co
LEFT JOIN users u ON co.user_id = u.id
LEFT JOIN payment_details p ON co.payment_id = p.id
LEFT JOIN products pd ON co.product_id = pd.id
WHERE co.cart_id = ?";

$stmt = $conn->prepare($cart_order_query);
$stmt->bind_param("s", $cart_id);
$stmt->execute();
$cart_order_result = $stmt->get_result();

if ($cart_order_result->num_rows === 0) {
    die("Cart order not found. Cart ID: $cart_id");
}

// Get the first row for general order information
$first_order = $cart_order_result->fetch_assoc();
// Store all rows in an array to avoid pointer issues
$all_orders = $cart_order_result->fetch_all(MYSQLI_ASSOC);
// Reset pointer to the beginning
$cart_order_result->data_seek(0);

// Calculate total price using the array
$total_price = 0;
foreach ($all_orders as $row) {
    $total_price += $row['price'];
}
// Reset pointer for table loop
$cart_order_result->data_seek(0);

// Handle "Mark as Paid" action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'mark_paid') {
    $conn->begin_transaction();

    try {
        // Update payment_details to mark as paid for the cart
        $update_payment_query = "UPDATE payment_details pd
                                JOIN cart_orders co ON pd.id = co.payment_id
                                SET pd.is_paid = 1
                                WHERE co.cart_id = ?";
        $stmt = $conn->prepare($update_payment_query);
        $stmt->bind_param("s", $cart_id);
        $stmt->execute();

        // Update cart_orders status to 'done'
        $update_order_status = "UPDATE cart_orders SET status = 'done' WHERE cart_id = ?";
        $stmt = $conn->prepare($update_order_status);
        $stmt->bind_param("s", $cart_id);
        $stmt->execute();

        // Insert each item into owned_games
        foreach ($all_orders as $order) {
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
        }

        // Commit transaction
        $conn->commit();

        // Redirect to refresh the page or show success message
        header("Location: ?cart_id=" . $cart_id . "&status=paid");
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
    <title>Cart Order Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --epic-dark: #121212;
            --epic-darker: #202020;
            --epic-blue: #037BFF;
            --epic-gray: #474747;
            --epic-light-gray: #cccccc;
        }

        body {
            background-color: var(--epic-dark);
            color: var(--epic-light-gray);
            font-family: 'Segoe UI', -apple-system, sans-serif;
        }

        .container {
            max-width: 1200px;
            padding: 2rem;
        }

        h2, h4 {
            color: white;
            font-weight: 600;
        }

        .card {
            background-color: var(--epic-darker);
            border: 1px solid var(--epic-gray);
            border-radius: 4px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 1.5rem;
        }

        .table {
            color: var(--epic-light-gray);
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .table-striped > tbody > tr:nth-of-type(odd) {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .table thead th {
            background-color: var(--epic-gray);
            color: white;
            border-bottom: none;
            padding: 1rem;
            text-align: left;
        }

        .table td {
            padding: 1rem;
            border-bottom: 1px solid var(--epic-gray);
            color: white;
            word-wrap: break-word;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .btn-primary {
            background-color: var(--epic-blue);
            border: none;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: background-color 0.2s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-mark-paid {
            background-color: #28a745;
            border: none;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: background-color 0.2s;
        }

        .btn-mark-paid:hover {
            background-color: #218838;
        }

        .btn-mark-paid:disabled {
            background-color: #666;
            cursor: not-allowed;
        }

        strong {
            color: white;
        }

        .status-badge {
            display: inline-block;
            padding: 0.35em 0.65em;
            font-size: 0.875em;
            font-weight: 700;
            border-radius: 0.25rem;
            text-transform: uppercase;
            background-color: var(--epic-blue);
            color: white;
        }

        .price-text {
            color: var(--epic-blue);
            font-weight: bold;
            font-size: 1.1em;
        }

        .success-message {
            background-color: #28a745;
            color: white;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .debug-note {
            color: yellow;
            font-size: 0.8em;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4">Cart Order Detail</h2>
        <div class="card mb-4">
            <div class="card-body">
                <?php if (isset($_GET['status']) && $_GET['status'] === 'paid'): ?>
                    <div class="success-message">
                        Payment marked as paid successfully!
                    </div>
                <?php endif; ?>

                <h4 class="mb-3">Cart ID: <?= htmlspecialchars($first_order['cart_id']) ?></h4>
                <p><strong>Customer Email:</strong> <?= htmlspecialchars($first_order['user_email']) ?></p>
                <p><strong>Status:</strong> <span class="status-badge"><?= ucfirst($first_order['status']) ?></span></p>
                <p><strong>Order Date:</strong> <?= date('d F Y H:i', strtotime($first_order['created_at'])) ?></p>
                <p><strong>Total Order Price:</strong> <span class="price-text">IDR <?= number_format($total_price, 0) ?></span></p>

                <?php if ($first_order['payment_instructions']): ?>
                    <h4 class="mt-4">Payment Instructions</h4>
                    <p class="mb-0"><?= htmlspecialchars($first_order['payment_instructions']) ?></p>
                <?php endif; ?>

                <!-- Form to Mark as Paid -->
                <form method="POST" action="" class="mt-4">
                    <input type="hidden" name="action" value="mark_paid">
                    <button type="submit" class="btn btn-mark-paid" <?= $first_order['payment_is_paid'] ? 'disabled' : '' ?>>
                        <?= $first_order['payment_is_paid'] ? 'Already Paid' : 'Mark as Paid' ?>
                    </button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="mb-4">Order Items</h4>
                <div class="table-responsive">
                    <table class="table text-light">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Product Name</th>
                                <th>Product ID</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $cart_order_result->data_seek(0); // Pastikan pointer diatur ulang
                            $row_count = 0;
                            while ($item = $cart_order_result->fetch_assoc()):
                                $row_count++;
                                // Debugging output
                                echo "<!-- Row $row_count: Order ID " . htmlspecialchars($item['id']) . " -->\n";
                            ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['id']) ?></td>
                                    <td><?= htmlspecialchars($item['product_name'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($item['product_id']) ?></td>
                                    <td class="price-text">IDR <?= number_format($item['price'] ?? 0, 0) ?></td>
                                </tr>
                            <?php endwhile; ?>
                            <?php if ($row_count === 0): ?>
                                <tr><td colspan="4" class="debug-note">No items found for this cart.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <?php if ($row_count < 2 && $row_count > 0): ?>
                        <div class="debug-note">Warning: Only <?php echo $row_count; ?> row(s) displayed. Expected 2 or more.</div>
                    <?php endif; ?>
                </div>
                
                <a href="?page=orders" class="btn btn-primary mt-3">Back to Orders</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>