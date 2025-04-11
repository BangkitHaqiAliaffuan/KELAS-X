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
    p.instructions as payment_instructions
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
?>
