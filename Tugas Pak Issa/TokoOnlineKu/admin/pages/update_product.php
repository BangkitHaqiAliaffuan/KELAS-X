<?php
// update_product_simple.php

require_once '../../php/config.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['id'];
    $uploadDir = '../../produkImg/';

    // Fungsi untuk upload gambar
    function uploadImage($conn, $product_id, $image, $uploadDir) {
        $filename = str_replace(' ', '_', preg_replace("/[^a-zA-Z0-9._-]/", "", $image['name']));
        $destination = $uploadDir . $filename;
        $counter = 1;
        $filenameParts = pathinfo($filename);

        while (file_exists($destination)) {
            $filename = $filenameParts['filename'] . '_' . $counter . '.' . $filenameParts['extension'];
            $destination = $uploadDir . $filename;
            $counter++;
        }

        if (move_uploaded_file($image['tmp_name'], $destination)) {
            // Add 'produkImg/' prefix to filename when storing in database
            $dbFilename = 'produkImg/' . $filename;
            $stmt = $conn->prepare("INSERT INTO product_images (product_id, image_url) VALUES ( ?, ?)");
            $stmt->bind_param('is' , $product_id, $dbFilename);
            if ($stmt->execute()) {
                $_SESSION['success'] .= "Image '$filename' uploaded successfully. ";
            } else {
                $_SESSION['error'] .= "Database error: " . $stmt->error . ". ";
                unlink($destination);
            }
            $stmt->close();
        } else {
            $_SESSION['error'] .= "Failed to move uploaded file. ";
        }
    }

    // Upload gambar baru
    if (!empty($_FILES['images']['name'][0])) {
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['images']['error'][$key] === 0) {
                uploadImage($conn, $product_id, [
                    'name' => $_FILES['images']['name'][$key],
                    'tmp_name' => $_FILES['images']['tmp_name'][$key]
                ], $uploadDir);
            } else {
                $_SESSION['error'] .= "Error uploading file: " . $_FILES['images']['error'][$key] . ". ";
            }
        }
    }

    // Hapus gambar yang dipilih
    if (isset($_POST['delete_images']) && is_array($_POST['delete_images'])) {
        foreach ($_POST['delete_images'] as $image_id) {
            $stmt = $conn->prepare("SELECT image_url FROM product_images WHERE id = ? AND product_id = ?");
            $stmt->bind_param('ii', $image_id, $product_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $image = $result->fetch_assoc();

            if ($image) {
                $image_url = $image['image_url'];
                $stmt = $conn->prepare("DELETE FROM product_images WHERE id = ? AND product_id = ?");
                $stmt->bind_param('ii', $image_id, $product_id);
                if ($stmt->execute()) {
                    // Remove 'produkImg/' prefix when deleting file
                    $filename = str_replace('produkImg/', '', $image_url);
                    $file_path = $uploadDir . $filename;
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                    $_SESSION['success'] .= "Image deleted successfully. ";
                } else {
                    $_SESSION['error'] .= "Error deleting image from database. ";
                }
            }
        }
    }

    // Update detail produk
    $fields = ['name' => 's', 'description' => 's', 'price' => 'd', 'category_id' => 'i', 'release_status' => 's'];
    $updates = [];
    $params = [];
    $types = '';

    foreach ($fields as $field => $type) {
        if (isset($_POST[$field]) && $_POST[$field] !== '') {
            $updates[] = "$field = ?";
            $params[] = $_POST[$field];
            $types .= $type;
        }
    }

    if (!empty($updates)) {
        $query = "UPDATE products SET " . implode(', ', $updates) . " WHERE id = ?";
        $types .= 'i';
        $params[] = $product_id;

        $stmt = $conn->prepare($query);
        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            $_SESSION['success'] .= "Product updated successfully!";
        } else {
            $_SESSION['error'] .= "Error updating product: " . $conn->error;
        }
    }

    header("Location: http://localhost/TokoOnlineKu/admin/admin.php?page=edit_product&id=" . $product_id);
    exit();
}
?>


