<?php
// pages/search.php
$host = "localhost";
$user = "root";
$password = "";
$database = "kacamata";

$koneksi = mysqli_connect($host, $user, $password, $database);
if(isset($_POST['search'])) {
    $search = mysqli_real_escape_string($koneksi, $_POST['search']);
    
    $query = "SELECT * FROM produk WHERE 
              produk LIKE '%$search%' OR 
              deskripsi LIKE '%$search%' OR 
              karya LIKE '%$search%'
              LIMIT 10";
              
    $result = mysqli_query($koneksi, $query);
    
    if(mysqli_num_rows($result) > 0) {
        echo '<div class="search-results">';
        while($row = mysqli_fetch_assoc($result)) {
            echo '<div class="product-card">';
            echo '<img src="uploads/' . htmlspecialchars($row['gambar']) . '" alt="' . htmlspecialchars($row['produk']) . '" class="product-image" onerror="this.src=\'../uploads/default.jpg\'">';
            echo '<div class="product-info">';
            echo '<h3>' . htmlspecialchars($row['produk']) . '</h3>';
            echo '<p class="author">Penulis: ' . htmlspecialchars($row['karya']) . '</p>';
            echo '<p class="price">Rp ' . number_format($row['harga'], 0, ',', '.') . '</p>';
            echo '<a href="?menu=produkdetail&id=' . $row['id'] . '" class="view-detail">Lihat Detail</a>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo '<div class="search-results"><p class="no-results">Tidak ada produk yang ditemukan.</p></div>';
    }
    exit();
}
?>