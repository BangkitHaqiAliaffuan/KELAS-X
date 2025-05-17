<?php

include '../index.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengambil data dari AJAX request
    $produk_id = $_POST['produk_id'];
    $user_id = $_POST['user_id'];
    $rating = $_POST['rating'];
    $komentar = $_POST['komentar'];

    // Simpan ulasan ke database
    if ($stmt = mysqli_prepare($koneksi, "INSERT INTO ulasan (produk_id, user_id, rating, komentar) VALUES (?, ?, ?, ?)")) {
        mysqli_stmt_bind_param($stmt, "iiis", $produk_id, $user_id, $rating, $komentar);
        
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => mysqli_error($koneksi)]);
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($koneksi)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
