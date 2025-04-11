<?php
// Memeriksa apakah cart_id ada dalam query string
if (!isset($_GET["cart_id"])) {
    echo "Akses tidak valid.";
    exit();
}

// Ambil cart_id dari query string
$cart_id = $_GET["cart_id"];

// Cek status pembayaran
$check_payment = mysqli_query($koneksi, "SELECT is_paid FROM orders_carts WHERE cart_id='$cart_id' LIMIT 1");
$is_paid = mysqli_fetch_assoc($check_payment)['is_paid'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan</title>
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-hover: #1d4ed8;
            --background-color: #f8fafc;
            --card-background: #ffffff;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --border-color: #e2e8f0;
            --success-color: #22c55e;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--background-color);
            color: var(--text-primary);
            line-height: 1.5;
            padding: 2rem;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .header {
            margin-bottom: 2rem;
        }

        .header h1 {
            font-size: 2rem;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .tab-button {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            background-color: var(--card-background);
            color: var(--text-primary);
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .tab-button:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .tab-button.active {
            background-color: var(--primary-color);
            color: white;
        }

        .card {
            background-color: var(--card-background);
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--text-primary);
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }

        .order-item:last-child {
            margin-bottom: 0;
        }

        .product-info h3 {
            font-size: 1rem;
            margin-bottom: 0.25rem;
        }

        .product-info p {
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        .price {
            font-weight: 600;
            color: var(--text-primary);
        }

        .total-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-top: 1px solid var(--border-color);
            margin-top: 1rem;
        }

        .total-label {
            font-size: 1.125rem;
            font-weight: 500;
        }

        .total-amount {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .button {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            background-color: var(--primary-color);
            color: white;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s ease;
            text-align: center;
            width: 100%;
            text-decoration: none;
        }

        .button:hover {
            background-color: var(--primary-hover);
        }

        .review-form {
            margin-top: 1.5rem;
        }

        .rating {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        select.rating-select {
            padding: 0.5rem;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            width: 100%;
            margin-bottom: 1rem;
        }

        textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            font-family: inherit;
            resize: vertical;
            min-height: 100px;
        }

        textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-badge.paid {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-badge.unpaid {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            color: var(--primary-color);
            text-decoration: none;
            margin-top: 1.5rem;
            font-weight: 500;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            .tabs {
                flex-direction: column;
            }

            .order-item {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .total-section {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Detail Pesanan</h1>
        </div>

        <!-- Order Details Section -->
        <div class="card">
            <div class="card-title">Produk yang Dipesan</div>
            <?php
            // Ambil data pesanan berdasarkan cart_id
            $result = mysqli_query($koneksi, "SELECT oc.*, p.produk FROM orders_carts oc JOIN produk p ON oc.produk_id = p.id WHERE oc.cart_id='$cart_id'");
            $total_harga = 0;

            while ($row = mysqli_fetch_assoc($result)) { 
                $total_harga += $row["total_harga"];
            ?>
                <div class="order-item">
                    <div class="product-info">
                        <h3><?= htmlspecialchars($row["produk"]) ?></h3>
                        <p>Jumlah: <?= htmlspecialchars($row["jumlah"]) ?></p>
                    </div>
                    <div class="price">
                        Rp<?= number_format($row["total_harga"], 0, ',', '.') ?>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- Payment Section -->
        <div class="card">
            <div class="total-section">
                <span class="total-label">Total Pembayaran</span>
                <span class="total-amount">Rp<?= number_format($total_harga, 0, ',', '.') ?></span>
            </div>
            <?php if (!$is_paid): ?>
            <form action="" method="POST">
                <input type="hidden" name="cart_id" value="<?= htmlspecialchars($cart_id) ?>">
                <button type="submit" name="pay_now" class="button">Bayar Sekarang</button>
            </form>
            <?php else: ?>
            <div class="status-badge paid">Pembayaran Selesai</div>
            <?php endif; ?>
        </div>

        <!-- Review Section -->
        <?php if ($is_paid): ?>
        <div class="card">
            <div class="card-title">Beri Ulasan</div>
            <?php
            $result = mysqli_query($koneksi, "SELECT oc.*, p.produk FROM orders_carts oc JOIN produk p ON oc.produk_id = p.id WHERE oc.cart_id='$cart_id'");

            while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="review-form">
                    <h3 class="product-info"><?= htmlspecialchars($row["produk"]) ?></h3>
                    <form action="" method="POST">
                        <input type="hidden" name="produk_id" value="<?= htmlspecialchars($row["produk_id"]) ?>">
                        
                        <select name="rating" required class="rating-select">
                            <option value="">Pilih Rating...</option>
                            <option value="1">1 - Sangat Buruk</option>
                            <option value="2">2 - Buruk</option>
                            <option value="3">3 - Cukup</option>
                            <option value="4">4 - Bagus</option>
                            <option value="5">5 - Sangat Bagus</option>
                        </select>

                        <textarea name="komentar" required placeholder="Tulis ulasan Anda di sini..."></textarea>
                        <button type="submit" name="submit_review" class="button">Kirim Ulasan</button>
                    </form>
                </div>
            <?php } ?>
        </div>
        <?php endif; ?>

        <a href="index.php?menu=produk" class="back-link">← Kembali ke Produk</a>
    </div>

    <?php
    // Proses pengiriman ulasan
    if (isset($_POST["submit_review"])) {
        $produk_id = $_POST["produk_id"]; 
        $user_id = $_SESSION["user_id"]; 
        $rating = $_POST["rating"]; 
        $komentar = $_POST["komentar"];
        
        if ($stmt = mysqli_prepare($koneksi, "INSERT INTO ulasan (produk_id, user_id, rating, komentar) VALUES (?, ?, ?, ?)")) {
            mysqli_stmt_bind_param($stmt, "iiis", $produk_id, $user_id, $rating, $komentar);
            
            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Ulasan berhasil dikirim!'); window.location.href='index.php?cart_id=".urlencode($cart_id)."';</script>";
            } else {
                echo "Error: " . mysqli_error($koneksi);
            }
            
            mysqli_stmt_close($stmt);
        }
    }

    // Proses pembayaran
    if (isset($_POST["pay_now"])) {
        if ($stmt = mysqli_prepare($koneksi, "UPDATE orders_carts SET is_paid = 1 WHERE cart_id = ?")) {
            mysqli_stmt_bind_param($stmt, "s", $cart_id);
            
            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Pembayaran berhasil!'); window.location.href='index.php?cart_id=".urlencode($cart_id)."';</script>";
            } else {
                echo "Error: " . mysqli_error($koneksi);
            }
            
            mysqli_stmt_close($stmt);
        }
    }
    ?>
</body>
</html>