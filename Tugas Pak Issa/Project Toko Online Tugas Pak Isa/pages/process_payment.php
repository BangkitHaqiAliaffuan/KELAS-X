<?php
include '../index.php'; // Pastikan koneksi database sudah ada

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi input
    if (!isset($_POST['cart_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'Cart ID tidak ditemukan']);
        exit();
    }

    $cart_id = $_POST['cart_id'];

    // Perbarui kolom is_paid menjadi 1 di tabel orders_carts
    $query = "UPDATE orders_carts SET is_paid = 1 WHERE cart_id = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("s", $cart_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode request tidak valid']);
}
?>
