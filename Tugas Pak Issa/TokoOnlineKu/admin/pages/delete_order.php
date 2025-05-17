<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "toko_online");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the required parameters are set
if (!isset($_GET['id']) || !isset($_GET['is_cart'])) {
    echo "<script>alert('Invalid request: Missing parameters.'); window.location.href = '?page=manage_orders';</script>";
    exit();
}

// Get parameters from URL
$order_id = $_GET['id'];
$is_cart = $_GET['is_cart'] === 'true';

// Begin transaction
$conn->begin_transaction();

try {
    if ($is_cart) {
        // For cart orders, we need to delete all entries with the same cart_id
        // First, get the cart_id for the given order_id
        $cart_id_query = "SELECT cart_id FROM cart_orders WHERE id = ?";
        $stmt = $conn->prepare($cart_id_query);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $cart_id_result = $stmt->get_result();

        if ($cart_id_result->num_rows === 0) {
            throw new Exception("Cart order not found.");
        }

        $cart_id_row = $cart_id_result->fetch_assoc();
        $cart_id = $cart_id_row['cart_id'];

        // Delete all cart orders with the same cart_id
        $delete_sql = "DELETE FROM cart_orders WHERE cart_id = ?";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("s", $cart_id);
        $stmt->execute();

        // Optional: Delete related payment_details if needed
        // If payment_details is linked and should be deleted, uncomment the following:
        /*
        $delete_payment_sql = "DELETE FROM payment_details WHERE id = (SELECT payment_id FROM cart_orders WHERE cart_id = ? LIMIT 1)";
        $stmt = $conn->prepare($delete_payment_sql);
        $stmt->bind_param("s", $cart_id);
        $stmt->execute();
        */
    } else {
        // For regular orders, delete the single entry based on id
        $delete_sql = "DELETE FROM orders WHERE id = ?";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();

        // Optional: Delete related payment_details if needed
        // If payment_details is linked and should be deleted, uncomment the following:
        /*
        $delete_payment_sql = "DELETE FROM payment_details WHERE id = (SELECT payment_id FROM orders WHERE id = ? LIMIT 1)";
        $stmt = $conn->prepare($delete_payment_sql);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        */
    }

    // Commit transaction
    $conn->commit();

    // Redirect with success message
    echo "<script>alert('" . ($is_cart ? "Cart order" : "Order") . " deleted successfully.'); window.location.href = '?page=orders';</script>";
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();

    // Redirect with error message
    echo "<script>alert('Error deleting " . ($is_cart ? "cart order" : "order") . ": " . addslashes($e->getMessage()) . "'); window.location.href = '?page=orders';</script>";
}

// Close the database connection
$conn->close();
?>