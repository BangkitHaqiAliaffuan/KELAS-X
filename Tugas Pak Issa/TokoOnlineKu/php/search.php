<?php
include 'config.php';
header('Content-Type: application/json');

if (isset($_GET['query'])) {
    $search = '%' . $_GET['query'] . '%';
    
    try {
        $stmt = $conn->prepare("SELECT id, name, image, price FROM products WHERE name LIKE ?");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        
        $stmt->bind_param("s", $search);
        
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        
        $result = $stmt->get_result();
        
        $products = array();
        while ($row = $result->fetch_assoc()) {
            $products[] = array(
                'id' => $row['id'],
                'name' => $row['name'],
                'image' => $row['image'],
                'price' => number_format($row['price'], 0)
            );
        }
        
        echo json_encode($products);
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
    
    if (isset($stmt)) {
        $stmt->close();
    }
    $conn->close();
}
?>