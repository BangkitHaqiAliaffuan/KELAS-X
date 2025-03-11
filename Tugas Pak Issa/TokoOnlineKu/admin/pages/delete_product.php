<?php
session_start();
require_once '../php/config.php';

if (!isset($_SESSION['is_admin'])) {
    $_SESSION['error'] = "Unauthorized access!";
    header("Location: index.php");
    exit();
}

function deleteProduct($conn, $id) {
    try {
        // Begin transaction
        $conn->begin_transaction();

        // First, get all related image information from product_images
        $stmt = $conn->prepare("SELECT image_url FROM product_images WHERE product_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product_images = $result->fetch_all(MYSQLI_ASSOC);

        // Delete all related images from product_images table
        $stmt = $conn->prepare("DELETE FROM product_images WHERE product_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // Get main product image filename before deletion
        $stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        // Delete product from database
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            // Delete main product image file if exists
            if ($product && $product['image']) {
                $image_path = "../uploads/" . $product['image'];
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
            }

            // Delete all related product images from filesystem
            foreach ($product_images as $image) {
                $image_path = "../" . $image['image_url'];
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
            }

            // Commit transaction
            $conn->commit();
            
            $_SESSION['success'] = "Product and all related images deleted successfully!";
            return true;
        } else {
            throw new Exception("Failed to delete product");
        }
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        $_SESSION['error'] = "Error: " . $e->getMessage();
        return false;
    }
}

// Main execution
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    
    if ($id === false) {
        $_SESSION['error'] = "Invalid product ID!";
    } else {
        deleteProduct($conn, $id);
    }
} else {
    $_SESSION['error'] = "Invalid request!";
}

// Redirect back to products page
header("Location: admin.php?page=products");
exit();