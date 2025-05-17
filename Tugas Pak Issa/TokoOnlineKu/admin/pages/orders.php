<?php
// Database connection check
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Debug mode - set to true to see query results
$debug = true;

// Updated queries for both orders and cart orders
$orders_query = "SELECT 
    o.id,
    o.user_id,
    o.product_id,
    o.amount,
    o.status,
    o.order_date,
    u.email as user_email,
    DATE(o.order_date) as order_date 
FROM orders o 
LEFT JOIN users u ON o.user_id = u.id 
ORDER BY o.order_date DESC, u.email ASC";

$cart_orders_query = "SELECT 
    co.id,
    co.user_id,
    co.product_id,
    co.created_at,
    co.status,
    co.cart_id,
    co.price,
    u.email as user_email,
    DATE(co.created_at) as order_date,
    SUM(co.price) as total_price
FROM cart_orders co 
LEFT JOIN users u ON co.user_id = u.id 
GROUP BY co.cart_id, co.user_id, u.email, DATE(co.created_at)
ORDER BY co.created_at DESC, u.email ASC";

// Execute queries
$orders_result = $conn->query($orders_query);
$cart_orders_result = $conn->query($cart_orders_query);

// Debug information if enabled
if ($debug) {
    if (!$orders_result) {
        echo "Error in orders query: " . $conn->error . "<br>";
    }
    if (!$cart_orders_result) {
        echo "Error in cart orders query: " . $conn->error . "<br>";
    }

    $orders_count = $orders_result ? $orders_result->num_rows : 0;
    $cart_orders_count = $cart_orders_result ? $cart_orders_result->num_rows : 0;


}

// Function to group orders by date and email
function groupOrders($orders_result, $is_cart = false)
{
    $grouped_orders = [];

    if ($orders_result && $orders_result->num_rows > 0) {
        while ($row = $orders_result->fetch_assoc()) {
            $date = date('Y-m-d', strtotime($row['order_date']));
            $email = $row['user_email'];

            if (!isset($grouped_orders[$date])) {
                $grouped_orders[$date] = [];
            }

            if (!isset($grouped_orders[$date][$email])) {
                $grouped_orders[$date][$email] = [];
            }

            // Add an 'is_cart' flag to differentiate between order types
            $row['is_cart'] = $is_cart;

            // Set the amount based on order type
            if ($is_cart) {
                $row['amount'] = $row['total_price'] ?? 0;
            } else {
                $row['amount'] = $row['amount'] ?? 0;
            }

            $grouped_orders[$date][$email][] = $row;
        }
    }

    return $grouped_orders;
}

// Process both types of orders
$grouped_orders = groupOrders($orders_result);
$grouped_cart_orders = groupOrders($cart_orders_result, true);

// Merge function to combine regular and cart orders
function mergeGroupedOrders($orders1, $orders2)
{
    $merged = [];

    // Combine all dates
    $all_dates = array_unique(array_merge(array_keys($orders1), array_keys($orders2)));

    foreach ($all_dates as $date) {
        if (!isset($merged[$date])) {
            $merged[$date] = [];
        }

        // Get all emails for this date
        $emails1 = isset($orders1[$date]) ? array_keys($orders1[$date]) : [];
        $emails2 = isset($orders2[$date]) ? array_keys($orders2[$date]) : [];
        $all_emails = array_unique(array_merge($emails1, $emails2));

        foreach ($all_emails as $email) {
            $merged[$date][$email] = [];

            // Merge orders for this email
            if (isset($orders1[$date][$email])) {
                $merged[$date][$email] = array_merge($merged[$date][$email], $orders1[$date][$email]);
            }
            if (isset($orders2[$date][$email])) {
                $merged[$date][$email] = array_merge($merged[$date][$email], $orders2[$date][$email]);
            }

            // Sort by order date descending
            usort($merged[$date][$email], function ($a, $b) {
                return strtotime($b['order_date']) - strtotime($a['order_date']);
            });
        }
    }

    return $merged;
}

// Merge orders and sort by date
$all_grouped_orders = mergeGroupedOrders($grouped_orders, $grouped_cart_orders);
krsort($all_grouped_orders);

// Handle Delete Action
if (isset($_GET['delete_order_id'])) {
    $order_id = $_GET['delete_order_id'];
    $is_cart = isset($_GET['is_cart']) && $_GET['is_cart'] == 'true';

    // Perform the delete operation
    if ($is_cart) {
        $cart_id_query = "SELECT cart_id FROM cart_orders WHERE id = '" . $conn->real_escape_string($order_id) . "' LIMIT 1";
        $cart_id_result = $conn->query($cart_id_query);
        if ($cart_id_result && $cart_id_row = $cart_id_result->fetch_assoc()) {
            $cart_id = $cart_id_row['cart_id'];
            $delete_sql = "DELETE FROM cart_orders WHERE cart_id = '" . $conn->real_escape_string($cart_id) . "'";
        }
    } else {
        $delete_sql = "DELETE FROM orders WHERE id = '" . $conn->real_escape_string($order_id) . "'";
    }

    if (isset($delete_sql) && $conn->query($delete_sql) === TRUE) {
        echo "<script>alert('" . ($is_cart ? "Cart" : "Order") . " deleted successfully.'); window.location.href = 'makanan';</script>";
    } else {
        echo "<script>alert('Error deleting " . ($is_cart ? "cart" : "order") . ": " . $conn->error . "'); window.location.href = window.location.pathname;</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<!-- [Previous HTML head and style sections remain the same] -->

<head>
    <style>
        :root {
            --epic-bg: #121212;
            --epic-card-bg: #202020;
            --epic-text: #ffffff;
            --epic-secondary: #2a2a2a;
            --epic-hover: #303030;
            --epic-blue: #037BEF;
            --epic-accent: #037BEF;
            --epic-danger: #dc3545;
        }

        body {
            background-color: var(--epic-bg);
            color: var(--epic-text);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.5;
        }

        .container-fluid {
            max-width: 1800px;
            padding: 2rem;
        }

        .card {
            background-color: var(--epic-card-bg);
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .card-body {
            padding: 2rem;
        }

        .order-date-header {
            background-color: var(--epic-secondary);
            padding: 1.25rem 1.75rem;
            border-radius: 10px;
            margin: 2rem 0 1.5rem;
            color: var(--epic-text);
            border-left: 4px solid var(--epic-blue);
        }

        .order-date-header h4 {
            margin: 0;
            font-size: 1.3rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .customer-email-header {
            color: var(--epic-blue);
            padding: 1.25rem 0;
            border-bottom: 2px solid var(--epic-secondary);
            margin-bottom: 1.5rem;
        }

        .customer-email-header h5 {
            font-size: 1.2rem;
            font-weight: 500;
            margin: 0;
            letter-spacing: 0.3px;
        }

        .table {
            color: var(--epic-text);
            border-collapse: separate;
            border-spacing: 0 8px;
            margin-bottom: 2rem;
        }

        .table thead {
            background-color: transparent;
        }

        .table thead th {
            border: none;
            padding: 1.25rem 1rem;
            font-weight: 600;
            color: #9a9a9a;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
        }

        .table tbody tr {
            background-color: var(--epic-card-bg);
            margin-bottom: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: var(--epic-hover);
            transform: translateX(4px);
        }

        .table td {
            padding: 1.25rem 1rem;
            border: none;
            vertical-align: middle;
        }

        .btn {
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
            font-weight: 500;
            letter-spacing: 0.3px;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background-color: var(--epic-blue);
            border: none;
        }

        .btn-primary:hover {
            background-color: #0366d6;
            transform: translateY(-1px);
        }

        .btn-danger {
            background-color: var(--epic-danger);
            border: none;
        }

        .btn-danger:hover {
            background-color: #bb2d3b;
            transform: translateY(-1px);
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        .cart-badge {
            background-color: var(--epic-blue);
            padding: 0.35rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            margin-left: 8px;
            text-transform: uppercase;
        }

        .badge {
            padding: 0.6rem 1rem;
            border-radius: 6px;
            font-weight: 500;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-size: 0.75rem;
        }

        .product-tooltip {
            background: var(--epic-card-bg);
            border: 1px solid var(--epic-secondary);
            padding: 1.25rem;
            border-radius: 10px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
            min-width: 280px;
            line-height: 1.6;
        }

        h2.mb-4 {
            color: var(--epic-text);
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 2.5rem !important;
            letter-spacing: 0.5px;
        }

        .alert-info {
            background-color: var(--epic-secondary);
            color: var(--epic-text);
            border: 1px solid var(--epic-blue);
            border-radius: 10px;
            padding: 1.25rem;
        }

        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        ::-webkit-scrollbar-track {
            background: var(--epic-bg);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--epic-secondary);
            border-radius: 5px;
            border: 2px solid var(--epic-bg);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--epic-blue);
        }

        @media (max-width: 768px) {
            .container-fluid {
                padding: 1rem;
            }

            .card-body {
                padding: 1rem;
            }

            .table td,
            .table th {
                padding: 1rem 0.75rem;
            }

            h2.mb-4 {
                font-size: 1.5rem;
            }
        }

        /* Orders Summary Box Styles */
        .orders-summary {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        .orders-count-box {
            background-color: var(--epic-card-bg);
            border-radius: 12px;
            padding: 1.5rem;
            flex: 1;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border-left: 4px solid var(--epic-blue);
            position: relative;
            overflow: hidden;
        }

        .orders-count-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.25);
        }

        .orders-count-box.cart-orders {
            border-left-color: #6c5ce7;
            /* Different color for cart orders */
        }

        .orders-count-box h3 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #9a9a9a;
            margin-bottom: 0.8rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .orders-count-box .count {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--epic-text);
            margin-bottom: 0.5rem;
        }

        .orders-count-box .count-label {
            font-size: 0.9rem;
            color: #9a9a9a;
        }

        .orders-count-box::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 80px;
            height: 80px;
            background-color: rgba(3, 123, 239, 0.1);
            border-radius: 50% 0 0 0;
            z-index: 1;
        }

        .orders-count-box.cart-orders::after {
            background-color: rgba(108, 92, 231, 0.1);
        }

        .orders-count-box .icon {
            position: absolute;
            bottom: 1rem;
            right: 1rem;
            font-size: 1.8rem;
            color: rgba(255, 255, 255, 0.2);
            z-index: 2;
        }

        /* Animation for count loading */
        @keyframes countUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .orders-count-box .count {
            animation: countUp 0.8s ease-out forwards;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .orders-summary {
                flex-direction: column;
                gap: 15px;
            }

            .orders-count-box {
                padding: 1.2rem;
            }

            .orders-count-box .count {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid py-4">
        <h2 class="mb-4">Manage Orders</h2>
        <div class="orders-summary">
            <div class="orders-count-box">
                <h3>Regular Orders</h3>
                <div class="count"><?= $orders_count ?></div>
                <div class="count-label">Total regular orders in system</div>
                <div class="icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>

            <div class="orders-count-box cart-orders">
                <h3>Cart Orders</h3>
                <div class="count"><?= $cart_orders_count ?></div>
                <div class="count-label">Total cart orders in system</div>
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <?php if (empty($all_grouped_orders)): ?>
                    <div class="alert alert-info">No orders found.</div>
                <?php else: ?>
                    <?php foreach ($all_grouped_orders as $date => $users): ?>
                        <div class="order-date-header">
                            <h4>Orders for <?= date('d F Y', strtotime($date)) ?></h4>
                        </div>

                        <?php foreach ($users as $email => $orders): ?>
                            <div class="table-container">
                                <div class="customer-email-header">
                                    <h5>Customer: <?= htmlspecialchars($email) ?></h5>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Product ID</th>
                                                <th>Total Amount</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($orders as $order): ?>
                                                <tr>
                                                    <td>
                                                        <?= htmlspecialchars($order['id']) ?>
                                                        <?php if ($order['is_cart']): ?>
                                                            <span class="badge cart-badge">Cart</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="product-info">
                                                        <?= htmlspecialchars($order['product_id']) ?>

                                                    </td>
                                                    <td>IDR <?= number_format($order['amount'], 0) ?></td>
                                                    <td>
                                                        <span
                                                            class="badge bg-<?= $order['status'] == 'completed' ? 'success' : ($order['status'] == 'pending' ? 'warning' : 'danger') ?>">
                                                            <?= ucfirst($order['status']) ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <?php if ($order['is_cart']): ?>
                                                            <a href="?page=cart_order_detail&cart_id=<?= $order['cart_id'] ?>"
                                                                class="btn btn-sm btn-primary">
                                                                View Details
                                                            </a>
                                                        <?php else: ?>
                                                            <a href="?page=order_detail&id=<?= $order['id'] ?>"
                                                                class="btn btn-sm btn-primary">
                                                                View Details
                                                            </a>
                                                        <?php endif; ?>
                                                        <a href="?page=delete_order&id=<?= $order['id'] ?>&is_cart=<?= $order['is_cart'] ? 'true' : 'false' ?>"
                                                            onclick="return confirm('Are you sure you want to delete this <?= $order['is_cart'] ? 'cart' : 'order' ?>? This action cannot be undone.');"
                                                            class="btn btn-sm btn-danger">
                                                            Delete
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <hr class="mt-4">
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>