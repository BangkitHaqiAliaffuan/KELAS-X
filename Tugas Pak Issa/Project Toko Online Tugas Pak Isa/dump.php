<?php
// [Previous PHP code remains exactly the same until the HTML part]
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


// Menampilkan detail pemesanan jika tidak ada proses yang dilakukan
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan</title>
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
    </style>
</head>
<body>
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
</body>
</html>

<?php
$koneksi->close();
?>