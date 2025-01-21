<?php 

// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "kacamata");

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil ID dari URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Query untuk menghapus produk
    $sql = "DELETE FROM produk WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        echo "Produk berhasil dihapus.";
        
        // Atur ulang ID
        $resetSql = "SET @num := 0; UPDATE produk SET id = @num := (@num + 1); ALTER TABLE produk AUTO_INCREMENT = 1;";
        if (mysqli_multi_query($conn, $resetSql)) {
            do {
                // Menjalankan semua query dalam multi_query
            } while (mysqli_next_result($conn));
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "ID tidak ditemukan.";
}

// Tutup koneksi ke database
mysqli_close($conn);

// Redirect kembali ke halaman utama setelah beberapa detik
header("location:index.php"); // Ganti 'index.php' dengan nama file halaman utama Anda

?>