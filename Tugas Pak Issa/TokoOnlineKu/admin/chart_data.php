<?php
session_start();
require_once '../php/config.php';

// Check if user is admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('HTTP/1.1 403 Forbidden');
    echo json_encode(['error' => 'Unauthorized access']);
    exit();
}

// Disable error display for this request
ini_set('display_errors', 0);
error_reporting(0);

// Set proper JSON header
header('Content-Type: application/json');

// Function to get chart data
function getChartData($conn) {
    $data = [];
    $currentDate = date('Y-m-d');
    
    try {
        // Get data for total products (games)
        $result = $conn->query("SELECT COUNT(*) as total FROM products");
        $total_products = $result->fetch_assoc()['total'];
        $data['games'] = [['date' => $currentDate, 'count' => (int)$total_products]];
        
        // Get data for users
        $result = $conn->query("SELECT COUNT(*) as total FROM users");
        $total_users = $result->fetch_assoc()['total'];
        $data['users'] = [['date' => $currentDate, 'count' => (int)$total_users]];
        
        // Get data for pending orders
        $result = $conn->query("SELECT COUNT(*) as total FROM orders WHERE status = 'pending'");
        $pending_orders = $result->fetch_assoc()['total'];
        $data['orders'] = [['date' => $currentDate, 'count' => (int)$pending_orders]];
        
        // Get data for revenue
        $result = $conn->query("SELECT SUM(amount) as total FROM orders WHERE status = 'done'");
        $total_revenue = $result->fetch_assoc()['total'] ?? 0;
        $data['revenue'] = [['date' => $currentDate, 'total' => (float)$total_revenue]];
        
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
    
    return $data;
}

echo json_encode(getChartData($conn));
exit;