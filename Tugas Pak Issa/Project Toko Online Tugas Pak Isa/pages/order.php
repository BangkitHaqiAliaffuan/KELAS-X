<?php
// [Previous PHP code remains the same until before the HTML]
if (isset($_SESSION['order'])) {
    $order = $_SESSION['order'];
} else {
    die('Tidak ada produk yang dipesan.');
}

// Mengambil ID pengguna dari sesi
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; // Ambil ID pengguna dari sesi
} else {
    header('Location: index.php?menu=login');
    exit(); // Pastikan untuk keluar setelah redirect
}

// Koneksi ke database
// Memeriksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Proses pembayaran
if (isset($_POST['pay_order'])) {
    // Mengambil nama produk dari form
    $nama_produk = $order['nama_produk'];

    // Menyiapkan dan mengikat parameter untuk memperbarui status pembayaran
    $stmt = $koneksi->prepare("UPDATE orders SET is_paid = 1 WHERE user_id = ? AND produk = ?");
    $stmt->bind_param("is", $user_id, $nama_produk); // Mengikat ID pengguna dan nama produk

    // Menjalankan pernyataan
    if ($stmt->execute()) {
        // Mengupdate sesi untuk mencerminkan status pembayaran baru
        $_SESSION['order']['is_paid'] = 1; 
        header("Location: index.php?menu=order"); // Arahkan kembali ke halaman pemesanan setelah berhasil membayar
        exit(); // Pastikan untuk keluar setelah redirect
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Proses pembatalan pesanan
if (isset($_POST['cancel_order'])) {
    // Mengambil nama produk dari sesi
    $nama_produk = $order['nama_produk'];

    // Menghapus pesanan dari tabel orders berdasarkan user_id dan produk
    $stmt = $koneksi->prepare("DELETE FROM orders WHERE user_id = ? AND produk = ?");
    $stmt->bind_param("is", $user_id, $nama_produk); 

    if ($stmt->execute()) {
        unset($_SESSION['order']); // Menghapus data pesanan dari sesi
        header("Location: index.php?menu=produk"); // Arahkan ke halaman beranda setelah membatalkan
        exit(); 
    } else {
        echo "Error: " . $stmt->error;
    }
}


// Handle review submission
if (isset($_POST['submit_review'])) {
    $rating = $_POST['rating'];
    $komentar = $_POST['komentar'];
    $produk_id = $order['produk_id']; 
    
    // Validate input
    if ($rating >= 1 && $rating <= 5 && !empty($komentar)) {
        // Check if user has already reviewed this product
        $check_review = $koneksi->prepare("SELECT id FROM ulasan WHERE user_id = ? AND produk_id = ?");
        $check_review->bind_param("ii", $user_id, $produk_id);
        $check_review->execute();
        $existing_review = $check_review->get_result();
        
        if ($existing_review->num_rows == 0) {
            // Insert new review
            $stmt = $koneksi->prepare("INSERT INTO ulasan (produk_id, user_id, rating, komentar) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiis", $produk_id, $user_id, $rating, $komentar);
            
            if ($stmt->execute()) {
                $review_success = "Terima kasih atas ulasan Anda!";
            } else {
                $review_error = "Gagal mengirim ulasan: " . $stmt->error;
            }
        } else {
            $review_error = "Anda sudah memberikan ulasan untuk produk ini.";
        }
    } else {
        $review_error = "Rating dan komentar harus diisi dengan benar.";
    }
}

if (isset($order['produk_id'])) {
    $check_review = $koneksi->prepare("SELECT id FROM ulasan WHERE user_id = ? AND produk_id = ?");
    $check_review->bind_param("ii", $user_id, $order['produk_id']);
    $check_review->execute();
    $existing_review = $check_review->get_result();
    $has_reviewed = $existing_review->num_rows > 0;
}
// Check if user has already reviewed
$has_reviewed = false;

?>
<!DOCTYPE html>
<html lang="id">
<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fa;
            min-height: 100vh;
            padding: 2rem;
            color: #2d3748;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        h1 {
            color: #2d3748;
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2.5rem;
            font-weight: 600;
        }

        .order-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .order-header {
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
        }

        .order-title {
            font-size: 1.5rem;
            color: #2d3748;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .order-info {
            display: grid;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .info-group {
            display: grid;
            gap: 0.5rem;
        }

        .info-label {
            font-size: 0.875rem;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .info-value {
            font-size: 1.125rem;
            color: #2d3748;
            font-weight: 500;
        }

        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-weight: 500;
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        .status-paid {
            background-color: #C6F6D5;
            color: #2F855A;
        }

        .status-unpaid {
            background-color: #FED7D7;
            color: #C53030;
        }

        .success-message {
            background-color: #C6F6D5;
            color: #2F855A;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            font-size: 1rem;
        }

        .btn-pay {
            background-color: #4299e1;
            color: white;
        }

        .btn-pay:hover {
            background-color: #3182ce;
        }

        .btn-cancel {
            background-color: #FC8181;
            color: white;
        }

        .btn-cancel:hover {
            background-color: #F56565;
        }

        .back-link {
            display: block;
            text-align: center;
            color: #4299e1;
            text-decoration: none;
            font-weight: 500;
            margin-top: 2rem;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color: #3182ce;
            text-decoration: underline;
        }

        @media (max-width: 640px) {
            body {
                padding: 1rem;
            }

            .order-card {
                padding: 1.5rem;
            }

            .actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
   
/* Add these new styles to your existing CSS */
.review-form {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 2px solid #e2e8f0;
}

.review-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: #2d3748;
}

.rating-container {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.star-rating {
    display: none;
}

.star-label {
    cursor: pointer;
    font-size: 1.5rem;
    color: #CBD5E0;
}

.star-rating:checked ~ .star-label,
.star-rating:hover ~ .star-label {
    color: #F6E05E;
}

.review-textarea {
    width: 100%;
    min-height: 100px;
    padding: 0.75rem;
    border: 1px solid #E2E8F0;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
    resize: vertical;
}

.review-submit {
    background-color: #48BB78;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    border: none;
    cursor: pointer;
    font-weight: 500;
    transition: background-color 0.3s;
}

.review-submit:hover {
    background-color: #38A169;
}

.review-message {
    padding: 1rem;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
}

.review-success {
    background-color: #C6F6D5;
    color: #2F855A;
}

.review-error {
    background-color: #FED7D7;
    color: #C53030;
}
</style>

<body>
    <div class="container">
    <div class="container">
        <h1>Detail Pesanan</h1>
        <div class="order-card">
            <div class="order-header">
                <div class="order-title">Informasi Pesanan</div>
                <div class="status-badge <?php echo $order['is_paid'] == 1 ? 'status-paid' : 'status-unpaid'; ?>">
                    <?php echo $order['is_paid'] == 1 ? 'Sudah Dibayar' : 'Belum Dibayar'; ?>
                </div>
            </div>

            <div class="order-info">
                <div class="info-group">
                    <div class="info-label">Produk</div>
                    <div class="info-value"><?php echo htmlspecialchars($order['nama_produk']); ?></div>
                </div>

                <div class="info-group">
                    <div class="info-label">Jumlah</div>
                    <div class="info-value"><?php echo htmlspecialchars($order['quantity']); ?> unit</div>
                </div>

                <div class="info-group">
                    <div class="info-label">Total Harga</div>
                    <div class="info-value">Rp<?php echo number_format($order['total_harga'], 0, ',', '.'); ?></div>
                </div>
                <?php 
                echo $order['produk_id']; 
                echo "Id Adalah ";
                ?>
                <div class="info-group">
                    <div class="info-label">Alamat Pengiriman</div>
                    <div class="info-value"><?php echo htmlspecialchars($order['alamat']); ?></div>
                </div>
            </div>

            <?php if ($order['is_paid'] == 1): ?>
                <div class="success-message">
                    Terima kasih telah melakukan pembayaran! Pesanan Anda sedang diproses dan akan segera dikirim.
                </div>
            <?php endif; ?>

            <?php if ($order['is_paid'] == 0): ?>
                <div class="actions">
                    <form action="" method="POST" style="flex: 1;">
                        <input type="hidden" name="pay_order" value="1">
                        <button type="submit" class="btn btn-pay">Bayar Sekarang</button>
                    </form>
                    
                    <form action="" method="POST" style="flex: 1;">
                        <input type="hidden" name="cancel_order" value="1">
                        <button type="submit" class="btn btn-cancel">Batalkan Pesanan</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
        
        <a href="index.php" class="back-link">Kembali ke Beranda</a>
    </div>
        <?php if ($order['is_paid'] == 1 && !$has_reviewed): ?>
            <div class="review-form">
                <h2 class="review-title">Berikan Ulasan Anda</h2>
                
                <?php if (isset($review_success)): ?>
                    <div class="review-message review-success"><?php echo $review_success; ?></div>
                <?php endif; ?>
                
                <?php if (isset($review_error)): ?>
                    <div class="review-message review-error"><?php echo $review_error; ?></div>
                <?php endif; ?>
                
                <form action="" method="POST">
                    <div class="rating-container">
                        <?php for ($i = 5; $i >= 1; $i--): ?>
                            <input type="radio" name="rating" value="<?php echo $i; ?>" id="star<?php echo $i; ?>" class="star-rating" required>
                            <label for="star<?php echo $i; ?>" class="star-label">★</label>
                        <?php endfor; ?>
                    </div>
                    
                    <textarea name="komentar" class="review-textarea" placeholder="Bagikan pengalaman Anda dengan produk ini..." required></textarea>
                    
                    <button type="submit" name="submit_review" class="review-submit">Kirim Ulasan</button>
                </form>
            </div>
        <?php endif; ?>
        
        <?php if ($has_reviewed): ?>
            <div class="review-message review-success">
                Anda telah memberikan ulasan untuk produk ini. Terima kasih atas kontribusi Anda!
            </div>
        <?php endif; ?>
        
        <a href="index.php" class="back-link">Kembali ke Beranda</a>
    </div>
</body>
</html>

<?php
$koneksi->close();
?>