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
    pd.price as product_price
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
    die("Cart order not found.");
}

// Get the first row for general order information
$first_order = $cart_order_result->fetch_assoc();
// Reset pointer to get all items again
$cart_order_result->data_seek(0);

// Calculate total price
$total_price = 0;
$temp_result = $cart_order_result;
while ($row = $temp_result->fetch_assoc()) {
    $total_price += $row['price'];
}
$cart_order_result->data_seek(0);
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
        }

        .table-striped > tbody > tr:nth-of-type(odd) {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .table thead th {
            background-color: var(--epic-gray);
            color: white;
            border-bottom: none;
            padding: 1rem;
        }

        .table td {
        color: white;
            padding: 1rem;
            border-color: var(--epic-gray);
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

        strong {
            color: white;
        }

        /* Status badge styling */
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

        /* Price emphasis */
        .price-text {
            color: var(--epic-blue);
            font-weight: bold;
            font-size: 1.1em;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4">Cart Order Detail</h2>
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="mb-3">Cart ID: <?= htmlspecialchars($first_order['cart_id']) ?></h4>
                <p><strong>Customer Email:</strong> <?= htmlspecialchars($first_order['user_email']) ?></p>
                <p><strong>Status:</strong> <span class="status-badge"><?= ucfirst($first_order['status']) ?></span></p>
                <p><strong>Order Date:</strong> <?= date('d F Y H:i', strtotime($first_order['created_at'])) ?></p>
                <p><strong>Total Order Price:</strong> <span class="price-text">IDR <?= number_format($total_price, 0) ?></span></p>

                <?php if ($first_order['payment_instructions']): ?>
                    <h4 class="mt-4">Payment Instructions</h4>
                    <p class="mb-0"><?= htmlspecialchars($first_order['payment_instructions']) ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="mb-4">Order Items</h4>
                <div class="table-responsive">
                    <table class="table  text-light">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Product Name</th>
                                <th>Product ID</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($item = $cart_order_result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['id']) ?></td>
                                    <td><?= htmlspecialchars($item['product_name']) ?></td>
                                    <td><?= htmlspecialchars($item['product_id']) ?></td>
                                    <td class="price-text">IDR <?= number_format($item['price'], 0) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                
                <a href="?page=orders" class="btn btn-primary mt-3">Back to Orders</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>