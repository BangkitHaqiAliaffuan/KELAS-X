<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "kacamata";

$koneksi = mysqli_connect($host, $user, $password, $database);

if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Memeriksa apakah ID produk valid
if ($id > 0) {
    // Query untuk produk
    $sql = "SELECT * FROM produk WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $nama_produk = $row['produk'];
        $harga_produk = $row['harga'];
        $deskripsi_produk = $row['deskripsi'];
        $jumlah_produk = $row['stock'];
        $gambar_produk = $row['gambar'];

        // Fetch detail buku
        $sql_details = "SELECT * FROM detail_buku WHERE produk_id = ?";
        $stmt_details = mysqli_prepare($koneksi, $sql_details);
        mysqli_stmt_bind_param($stmt_details, "i", $id);
        mysqli_stmt_execute($stmt_details);
        $result_details = mysqli_stmt_get_result($stmt_details);

        if ($details_row = mysqli_fetch_assoc($result_details)) {
            $penerbit = $details_row['penerbit'];
            $tanggal_terbit = date('d M Y', strtotime($details_row['tanggal_terbit']));
            $isbn = $details_row['isbn'];
            $halaman = $details_row['halaman'];
            $bahasa = $details_row['bahasa'];
            $panjang = $details_row['panjang'];
            $lebar = $details_row['lebar'];
            $berat = $details_row['berat'];
        }

        // Calculate average rating
        $sql_avg_rating = "SELECT AVG(rating) as avg_rating FROM ulasan WHERE produk_id = ?";
        $stmt_avg_rating = mysqli_prepare($koneksi, $sql_avg_rating);
        mysqli_stmt_bind_param($stmt_avg_rating, "i", $id);
        mysqli_stmt_execute($stmt_avg_rating);
        $avg_rating_result = mysqli_stmt_get_result($stmt_avg_rating);
        $avg_rating_row = mysqli_fetch_assoc($avg_rating_result);
        $avg_rating = round($avg_rating_row['avg_rating'], 1);

        // Fetch ulasan/reviews
        $sql_reviews = "SELECT u.nama AS username, ul.komentar, ul.rating, ul.tanggal
                       FROM ulasan ul 
                       JOIN user u ON ul.user_id = u.id 
                       WHERE ul.produk_id = ? 
                       ORDER BY ul.tanggal DESC";
        $stmt_reviews = mysqli_prepare($koneksi, $sql_reviews);
        mysqli_stmt_bind_param($stmt_reviews, "i", $id);
        mysqli_stmt_execute($stmt_reviews);
        $result_reviews = mysqli_stmt_get_result($stmt_reviews);
        
        // Count total reviews
        $total_reviews = mysqli_num_rows($result_reviews);
        
    } else {
        die('Produk tidak ditemukan.');
    }
} else {
    die('ID produk tidak valid.');
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <title>Detail Produk</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }

        .product-container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .product-wrapper {
            display: flex;
            gap: 40px;
            padding: 40px;
        }

        .book-image {
            flex: 1;
            max-width: 400px;
        }

        .book-image img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .book-details {
            flex: 2;
        }

        .book-details h1 {
            font-size: 32px;
            margin: 0 0 16px;
            color: #2d3748;
        }

        .price {
            font-size: 28px;
            font-weight: 600;
            color: #2563eb;
            margin-bottom: 20px;
        }

        .description {
            background-color: #f0f9ff;
            padding: 24px;
            border-radius: 8px;
            margin-bottom: 24px;
            border: 1px solid #bfdbfe;
        }

        .description h2 {
            color: #1e40af;
            margin-top: 0;
        }

        .stock-info {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: #dbeafe;
            padding: 8px 16px;
            border-radius: 6px;
            color: #1e40af;
            margin-top: 16px;
        }

        .quantity-container {
            margin: 24px 0;
            background-color: #f8fafc;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
        }

        .quantity-button {
            width: 40px;
            height: 40px;
            border: none;
            background-color: #2563eb;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.2s;
        }

        .quantity-button:hover {
            background-color: #1d4ed8;
        }

        #quantity {
            width: 60px;
            height: 40px;
            text-align: center;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-size: 16px;
        }

        .buy-buttons {
            display: flex;
            gap: 16px;
        }

        .buy-button {
            flex: 1;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .buy-now {
            background-color: #2563eb;
            color: white;
        }

        .buy-now:hover {
            background-color: #1d4ed8;
        }

        .add-to-cart {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .add-to-cart:hover {
            background-color: #bfdbfe;
        }

        .reviews-section {
            padding: 32px;
            background-color: #fff;
            border-top: 1px solid #e2e8f0;
        }

        .reviews-section h2 {
            color: #1e40af;
            margin-bottom: 24px;
            font-size: 24px;
        }

        .review {
            background-color: #f8fafc;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #e2e8f0;
        }

        .review h4 {
            margin: 0 0 8px;
            color: #2d3748;
        }

        .stars {
            display: flex;
            gap: 4px;
            margin-bottom: 12px;
        }

        .stars .fa-star {
            color: #94a3b8;
        }

        .stars .fa-star.active {
            color: #2563eb;
        }

        .ratings {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .book-details-section {
            background-color: #f0f9ff;
            padding: 24px;
            border-radius: 8px;
            margin: 24px 0;
            border: 1px solid #bfdbfe;
        }

        .book-details-section h2 {
            color: #1e40af;
            margin-top: 0;
        }

        .book-details-section p {
            margin: 8px 0;
        }

        .book-details-section strong {
            color: #1e40af;
        }

        @media (max-width: 768px) {
            .product-wrapper {
                flex-direction: column;
                padding: 24px;
            }

            .book-image {
                max-width: 100%;
            }

            .buy-buttons {
                flex-direction: column;
            }
        }
        .rating-summary {
            background-color: #f0f9ff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 24px;
            border: 1px solid #bfdbfe;
        }

        .rating-summary .average {
            font-size: 48px;
            font-weight: bold;
            color: #2563eb;
        }

        .rating-info {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .review-date {
            color: #64748b;
            font-size: 14px;
            margin-top: 8px;
        }
    </style>
</head>

<body>
    <div class="product-container">
        <div class="product-wrapper">
            <div class="book-image">
                <img alt="<?php echo htmlspecialchars($nama_produk); ?>" 
                     src="uploads/<?php echo htmlspecialchars($gambar_produk); ?>" />
            </div>
            
            <div class="book-details">
                <h1><?php echo htmlspecialchars($nama_produk); ?></h1>
                
                <!-- Rating Summary -->
                <div class="rating-info">
                    <div class="stars">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="fas fa-star <?php echo $i <= $avg_rating ? 'active' : ''; ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <span><?php echo $avg_rating; ?> dari 5</span>
                    <span>(<?php echo $total_reviews; ?> ulasan)</span>
                </div>

                <p class="price">Rp <?php echo number_format($harga_produk, 0, ',', '.'); ?></p>

                <div class="description">
                    <h2>Deskripsi</h2>
                    <p><?php echo nl2br(htmlspecialchars($deskripsi_produk)); ?></p>
                    <div class="stock-info">
                        <i class="fas fa-box"></i>
                        <span>Stok Tersisa: <?php echo htmlspecialchars($jumlah_produk); ?> buah</span>
                    </div>
                </div>

                <div class="quantity-container">
                    <form action="index.php?menu=save_order" method="POST">
                        <input type="hidden" name="nama_produk" value="<?php echo htmlspecialchars($nama_produk); ?>">
                        <input type="hidden" name="harga_produk" value="<?php echo htmlspecialchars($harga_produk); ?>">
                        <input type="hidden" name="produk_id" value="<?php echo (int)$id; ?>">

                        <div class="quantity-controls">
                            <button type="button" class="quantity-button" onclick="decreaseQuantity()">-</button>
                            <input type="number" 
                                   name="quantity" 
                                   id="quantity" 
                                   value="1" 
                                   min="1" 
                                   max="<?php echo htmlspecialchars($jumlah_produk); ?>" 
                                   required />
                            <button type="button" class="quantity-button" onclick="increaseQuantity()">+</button>
                        </div>

                        <div class="buy-buttons">
                            <button type="submit" class="buy-button buy-now">
                                <i class="fas fa-shopping-bag"></i>
                                Beli Sekarang
                            </button>
                            <button type="button" 
                                    class="buy-button add-to-cart" 
                                    onclick="addToCart(<?php echo (int)$id; ?>)">
                                <i class="fas fa-shopping-cart"></i>
                                Tambah ke Keranjang
                            </button>
                        </div>
                    </form>
                </div>

                <div class="book-details-section">
                    <h2>Detail Buku</h2>
                    <p><strong>Penerbit:</strong> <?php echo htmlspecialchars($penerbit); ?></p>
                    <p><strong>Tanggal Terbit:</strong> <?php echo htmlspecialchars($tanggal_terbit); ?></p>
                    <p><strong>ISBN:</strong> <?php echo htmlspecialchars($isbn); ?></p>
                    <p><strong>Halaman:</strong> <?php echo htmlspecialchars($halaman); ?></p>
                    <p><strong>Bahasa:</strong> <?php echo htmlspecialchars($bahasa); ?></p>
                    <p><strong>Dimensi:</strong> <?php echo htmlspecialchars($panjang); ?> x <?php echo htmlspecialchars($lebar); ?> cm</p>
                    <p><strong>Berat:</strong> <?php echo htmlspecialchars($berat); ?> kg</p>
                </div>
            </div>
        </div>

        <div class="reviews-section">
            <h2>Ulasan Produk</h2>
            <?php if ($total_reviews > 0): ?>
                <?php while ($review = mysqli_fetch_assoc($result_reviews)): ?>
                    <div class="review">
                        <h4><?php echo htmlspecialchars($review['username']); ?></h4>
                        <div class="stars">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="fas fa-star <?php echo $i <= $review['rating'] ? 'active' : ''; ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <p><?php echo nl2br(htmlspecialchars($review['komentar'])); ?></p>
                        <p class="review-date">
                            <?php echo date('d M Y', strtotime($review['tanggal'])); ?>
                        </p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Tidak ada ulasan untuk produk ini.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function increaseQuantity() {
            var quantityInput = document.getElementById('quantity');
            var currentValue = parseInt(quantityInput.value);
            var maxValue = parseInt(quantityInput.max);
            
            if (currentValue < maxValue) {
                quantityInput.value = currentValue + 1;
            }
        }

        function decreaseQuantity() {
            var quantityInput = document.getElementById('quantity');
            var currentValue = parseInt(quantityInput.value);
            
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        }

        function addToCart(productId) {
            var quantityInput = document.getElementById('quantity');
            var quantity = quantityInput.value;

            var form = document.createElement('form');
            form.method = 'POST';
            form.action = 'index.php?menu=cart&add=' + productId;

            var inputQuantity = document.createElement('input');
            inputQuantity.type = 'hidden';
            inputQuantity.name = 'quantity';
            inputQuantity.value = quantity;

            form.appendChild(inputQuantity);
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>
</html>

<?php
mysqli_close($koneksi);
?>