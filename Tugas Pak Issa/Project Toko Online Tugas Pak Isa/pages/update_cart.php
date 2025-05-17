<?php
session_start(); // Pastikan sesi dimulai

// Memeriksa apakah ID dan jumlah diterima dari permintaan AJAX
if (isset($_POST['id']) && isset($_POST['quantity'])) {
    $id = $_POST['id'];
    $quantity = (int)$_POST['quantity'];

    // Memastikan bahwa produk ada dalam keranjang dan jumlah valid
    if (isset($_SESSION['cart'][$id]) && $quantity > 0) {
        $_SESSION['cart'][$id]['jumlah'] = $quantity; // Update jumlah dalam sesi
        
        echo json_encode(['status' => 'success', 'message' => 'Jumlah diperbarui']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Produk tidak ditemukan']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Data tidak valid']);
}
?>