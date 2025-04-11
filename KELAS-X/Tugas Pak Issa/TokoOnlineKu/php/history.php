<?php
include 'config.php';

// Database connection check
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get current user's ID (assuming it's stored in session)
$current_user_id = $_SESSION['user_id'] ?? null;

if (!$current_user_id) {
    header('Location: ?menu=login');
    exit();
}

// Debugging: Check if user_id is set
echo "<!-- Debug: Current User ID = $current_user_id -->\n";

// Queries to get only the current user's orders
$orders_query = "SELECT 
    o.id,
    o.product_id,
    o.amount,
    o.status,
    o.order_date,
    p.name as product_name,
    DATE(o.order_date) as order_date 
FROM orders o 
LEFT JOIN products p ON o.product_id = p.id 
WHERE o.user_id = ? 
ORDER BY o.order_date DESC";

// Use prepared statement to prevent SQL injection
$stmt = $conn->prepare($orders_query);
$stmt->bind_param("i", $current_user_id);
$stmt->execute();
$orders_result = $stmt->get_result();

// Debugging: Check number of single orders and each row
echo "<!-- Debug: Number of single orders = " . $orders_result->num_rows . " -->\n";
$orders_result->data_seek(0); // Reset pointer for debugging
while ($row = $orders_result->fetch_assoc()) {
    echo "<!-- Debug: Single Order ID = " . $row['id'] . ", Product ID = " . $row['product_id'] . ", Date = " . $row['order_date'] . " -->\n";
}
$orders_result->data_seek(0); // Reset pointer for use in groupOrders

$cart_orders_query = "SELECT 
    co.id,
    co.product_id,
    co.created_at,
    co.status,
    co.cart_id,
    co.price,
    p.name as product_name,
    DATE(co.created_at) as order_date,
    SUM(co.price) as total_price
FROM cart_orders co 
LEFT JOIN products p ON co.product_id = p.id 
WHERE co.user_id = ? 
GROUP BY co.cart_id, DATE(co.created_at)
ORDER BY co.created_at DESC";

// Use prepared statement for cart orders
$stmt = $conn->prepare($cart_orders_query);
$stmt->bind_param("i", $current_user_id);
$stmt->execute();
$cart_orders_result = $stmt->get_result();

// Debugging: Check number of cart orders and each row
echo "<!-- Debug: Number of cart orders = " . $cart_orders_result->num_rows . " -->\n";
$cart_orders_result->data_seek(0); // Reset pointer for debugging
while ($row = $cart_orders_result->fetch_assoc()) {
    echo "<!-- Debug: Cart Order ID = " . $row['id'] . ", Cart ID = " . $row['cart_id'] . ", Product ID = " . $row['product_id'] . ", Date = " . $row['order_date'] . " -->\n";
}
$cart_orders_result->data_seek(0); // Reset pointer for use in groupOrders

// Function to group orders by date
function groupOrders($orders_result, $is_cart = false)
{
    $grouped_orders = [];

    if ($orders_result && $orders_result->num_rows > 0) {
        while ($row = $orders_result->fetch_assoc()) {
            $date = date('Y-m-d', strtotime($row['order_date']));
            if (!isset($grouped_orders[$date])) {
                $grouped_orders[$date] = [];
            }
            $row['is_cart'] = $is_cart;
            $row['amount'] = $is_cart ? ($row['total_price'] ?? 0) : ($row['amount'] ?? 0);
            $grouped_orders[$date][] = $row;
        }
    }

    return $grouped_orders;
}

// Process both types of orders
$grouped_orders = groupOrders($orders_result);
$grouped_cart_orders = groupOrders($cart_orders_result, true);

// Debugging: Check grouped orders
echo "<!-- Debug: Grouped Single Orders = " . count($grouped_orders) . " dates -->\n";
echo "<!-- Debug: Grouped Cart Orders = " . count($grouped_cart_orders) . " dates -->\n";

// Merge orders and sort by date
$all_orders = [];
foreach (array_merge($grouped_orders, $grouped_cart_orders) as $date => $orders) {
    if (!isset($all_orders[$date])) {
        $all_orders[$date] = [];
    }
    $all_orders[$date] = array_merge($all_orders[$date], $orders);
}
krsort($all_orders);

// Debugging: Check total merged orders
echo "<!-- Debug: Total Merged Orders = " . count($all_orders) . " dates -->\n";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <style>
        :root {
            --epic-bg: #121212;
            --epic-card-bg: #202020;
            --epic-text: #ffffff;
            --epic-secondary: #2a2a2a;
            --epic-hover: #303030;
            --epic-blue: #037BEF;
            --epic-accent: #037BEF;
            --epic-success: #28a745;
            --epic-warning: #ffc107;
            --epic-danger: #dc3545;
        }

        body {
            background-color: var(--epic-bg);
            color: var(--epic-text);
            font-family: 'Inter', sans-serif;
            line-height: 1.5;
            margin: 0;
            /* padding: 20px; */
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 2rem;
            color: var(--epic-text);
        }

        .order-date {
            background-color: var(--epic-secondary);
            padding: 1rem 1.5rem;
            border-radius: 10px;
            margin: 2rem 0 1rem;
            border-left: 4px solid var(--epic-blue);
        }

        .order-card {
            background-color: var(--epic-card-bg);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: transform 0.2s ease;
        }

        .order-card:hover {
            transform: translateY(-2px);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--epic-secondary);
        }

        .order-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .detail-item {
            padding: 0.5rem;
        }

        .detail-label {
            color: #9a9a9a;
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .detail-value {
            font-weight: 500;
        }

        .badge {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
        }

        .badge-cart {
            background-color: var(--epic-blue);
            color: white;
        }

        .badge-status {
            padding: 0.5rem 1rem;
            border-radius: 6px;
        }

        .status-completed { background-color: var(--epic-success); }
        .status-pending { background-color: var(--epic-warning); color: #000; }
        .status-cancelled { background-color: var(--epic-danger); }

        .btn {
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
            font-weight: 500;
            text-decoration: none;
            color: white;
            background-color: var(--epic-blue);
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .debug-note {
            color: yellow;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            .order-details {
                grid-template-columns: 1fr;
            }

            .page-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="page-title">My Orders</h1>
        
        <?php if (empty($all_orders)): ?>
            <div class="order-card">
                <p>You haven't placed any orders yet.</p>
            </div>
        <?php else: ?>
            <?php if ($orders_result->num_rows === 0): ?>
                <div class="debug-note">
                    No single orders found for this user (User ID: <?= htmlspecialchars($current_user_id) ?>).
                </div>
            <?php endif; ?>
            <?php if ($cart_orders_result->num_rows === 0): ?>
                <div class="debug-note">
                    No cart orders found for this user (User ID: <?= htmlspecialchars($current_user_id) ?>).
                </div>
            <?php endif; ?>
            
            <?php foreach ($all_orders as $date => $orders): ?>
                <div class="order-date">
                    <h3><?= date('d F Y', strtotime($date)) ?></h3>
                </div>
                
                <?php foreach ($orders as $order): ?>
                    <div class="order-card">
                        <div class="order-header">
                            <div>
                                <span>Order #<?= htmlspecialchars($order['id']) ?></span>
                                <?php if ($order['is_cart']): ?>
                                    <span class="badge badge-cart">Cart Order</span>
                                <?php endif; ?>
                            </div>
                            <span class="badge badge-status status-<?= strtolower($order['status']) ?>">
                                <?= ucfirst($order['status']) ?>
                            </span>
                        </div>
                        
                        <div class="order-details">
                            <div class="detail-item">
                                <div class="detail-label">Product</div>
                                <div class="detail-value"><?= htmlspecialchars($order['product_name'] ?? 'N/A') ?></div>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">Amount</div>
                                <div class="detail-value">IDR <?= number_format($order['amount'], 0) ?></div>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">Date</div>
                                <div class="detail-value">
                                    <?= date('d M Y H:i', strtotime($order['is_cart'] ? $order['created_at'] : $order['order_date'])) ?>
                                </div>
                            </div>
                        </div>

                        <div>
                            <?php if ($order['is_cart']): ?>
                                <a href="?menu=cart_order_detail&cart_id=<?= htmlspecialchars($order['cart_id']) ?>" class="btn">
                                    View Details
                                </a>
                            <?php else: ?>
                                <a href="?menu=order_detail&id=<?= htmlspecialchars($order['id']) ?>" class="btn">
                                    View Details
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>