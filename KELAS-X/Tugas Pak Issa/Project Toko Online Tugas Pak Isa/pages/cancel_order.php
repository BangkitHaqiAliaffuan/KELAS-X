<?php
session_start(); // Pastikan sesi dimulai

// Memeriksa apakah permintaan untuk membatalkan pesanan ada
if (isset($_POST['cancel_order'])) {
    // Mengambil ID pengguna dari sesi
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } else {
        die('Pengguna tidak terdaftar.');
    }

    // Mengambil informasi pesanan dari sesi
    if (isset($_SESSION['order'])) {
        $order = $_SESSION['order'];
        $nama_produk = $order['nama_produk'];
        
        // Koneksi ke database
        $servername = "localhost";
        $username = "username"; // Ganti dengan username database Anda
        $password = "password"; // Ganti dengan password database Anda
        $dbname = "myDB"; // Ganti dengan nama database Anda

        // Membuat koneksi
        $koneksi = new mysqli($servername, $username, $password, $dbname);

        // Memeriksa koneksi
        if ($koneksi->connect_error) {
            die("Koneksi gagal: " . $koneksi->connect_error);
        }

        // Menghapus pesanan dari tabel orders berdasarkan user_id dan nama_produk
        $stmt = $koneksi->prepare("DELETE FROM orders WHERE user_id = ? AND produk = ?");
        $stmt->bind_param("is", $user_id, $nama_produk);

        if ($stmt->execute()) {
            // Menghapus data pesanan dari sesi
            unset($_SESSION['order']);
            
            // Redirect ke halaman beranda atau halaman lain setelah membatalkan
            header("Location: index.php?menu=produk");
            exit(); // Pastikan untuk keluar setelah redirect
        } else {
            echo "Error: " . $stmt->error;
        }

        // Menutup pernyataan dan koneksi
        $stmt->close();
        $koneksi->close();
    } else {
        die('Tidak ada produk yang dipesan.');
    }
} else {
    die('Tidak ada permintaan untuk membatalkan pesanan.');
}
?>