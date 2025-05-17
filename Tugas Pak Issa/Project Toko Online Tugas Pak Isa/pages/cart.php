<?php

// Memeriksa apakah pengguna terdaftar
if (!isset($_SESSION['email'])) {
    echo "<script>window.location.href = 'index.php?menu=login'</script>";
    exit(); // Pastikan untuk keluar setelah redirect
}

// Ambil alamat dari database berdasarkan user_id
$alamat_query = "SELECT * FROM alamat WHERE user_id = ?";
$stmt = $koneksi->prepare($alamat_query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$alamat_result = $stmt->get_result();
$alamat_list = $alamat_result->fetch_all(MYSQLI_ASSOC);

// Proses checkout
if (isset($_POST['checkout'])) {
    $cart_id = uniqid(); // Menggunakan unique ID sebagai cart_id
    $address = $_POST['alamat']; // Mengambil alamat dari dropdown

    foreach ($_SESSION['cart'] as $item) {
        // Menyimpan data pesanan ke dalam tabel orders_carts
        $stmt = $koneksi->prepare("INSERT INTO orders_carts (user_id, produk_id, jumlah, total_harga, cart_id, alamat) VALUES (?, ?, ?, ?, ?, ?)");

        // Ambil ID pengguna dari sesi
        $user_id = $_SESSION['user_id'];
        $total_harga_item = $item['harga'] * $item['jumlah'];

        // Bind parameter dan eksekusi pernyataan
        if ($stmt) {
            $stmt->bind_param("iiidss", $user_id, $item['id'], $item['jumlah'], $total_harga_item, $cart_id, $address);
            if (!$stmt->execute()) {
                echo "Error saat menyimpan pesanan : " . $stmt->error;
            }
        } else {
            echo "Error saat mempersiapkan statement : " . mysqli_error($koneksi);
            exit(); // Hentikan jika ada error
        }
    }
    
    unset($_SESSION['cart']); // Kosongkan keranjang setelah pembelian berhasil
    header("Location: index.php?menu=display_cart&cart_id=" . $cart_id);
    exit(); // Hentikan jika ada error
    // Redirect ke halaman display cart dengan cart_id
}

// Proses penghapusan item dari keranjang
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    unset($_SESSION['cart'][$id]);
}

// Proses penambahan item ke keranjang
if (isset($_GET['add'])) {
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    $id = $_GET['add'];
    $sql = "SELECT * FROM produk WHERE id = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $hasil = $stmt->get_result();

    if ($row = mysqli_fetch_assoc($hasil)) {
        $_SESSION['cart'][$row['id']] = [
            'id' => $row['id'],
            'produk' => $row['produk'],
            'deskripsi' => $row['deskripsi'],
            'harga' => $row['harga'], // Menyimpan harga produk
            'jumlah' => isset($_SESSION['cart'][$row['id']]) ? $_SESSION['cart'][$row['id']]['jumlah'] + $quantity : $quantity
        ];
    }
    echo "<script>window.location.href = 'index.php?menu=cart'</script>";
    exit();
}

// Proses pengurangan item dari keranjang
if (isset($_GET['subtract'])) {
    $id = $_GET['subtract'];

    if (isset($_SESSION['cart'][$id])) {
        // Kurangi jumlah jika lebih dari satu
        if ($_SESSION['cart'][$id]['jumlah'] > 1) {
            $_SESSION['cart'][$id]['jumlah'] -= 1; // Kurangi satu
        } else {
            unset($_SESSION['cart'][$id]); // Hapus item jika jumlahnya nol
        }
    }
    header('location: index.php?menu=cart');
    exit();
}
$cart = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; // Pastikan untuk memeriksa apakah session cart ada

if ($cart !== 0) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Keranjang Belanja</title>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Poppins', sans-serif;
                background-color: #f8f9fa;
                color: #333;
                line-height: 1.6;
            }
            
            .container {
                max-width: 1200px;
                margin: 40px auto;
                padding: 0 20px;
            }

            .page-title {
                font-size: 2.2em;
                color: #2d3436;
                margin-bottom: 30px;
                text-align: center;
                font-weight: 600;
            }

            .cart-grid {
                display: grid;
                grid-template-columns: 2fr 1fr;
                gap: 30px;
                margin-top: 20px;
            }
            
            .cart-items {
                background: white;
                border-radius: 15px;
                padding: 25px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            }

            .cart-item {
                display: grid;
                grid-template-columns: 3fr 1fr auto;
                align-items: center;
                padding: 20px;
                margin-bottom: 15px;
                background: #fff;
                border-radius: 12px;
                border: 1px solid #eee;
                transition: all 0.3s ease;
            }

            .cart-item:hover {
                transform: translateY(-3px);
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            }
            
            .item-details h3 {
                font-size: 1.2em;
                color: #2d3436;
                margin-bottom: 8px;
            }
            
            .item-details p {
                color: #636e72;
                font-size: 0.95em;
                margin: 5px 0;
            }

            .quantity-control {
                display: flex;
                align-items: center;
                gap: 10px;
                background: #f8f9fa;
                padding: 8px;
                border-radius: 8px;
                width: fit-content;
            }
            
            .quantity-control a {
                color: #2d3436;
                text-decoration: none;
                width: 28px;
                height: 28px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: white;
                border-radius: 6px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease;
            }
            
            .quantity-control a:hover {
                background: #007bff;
                color: white;
            }

            .quantity-control input {
                width: 40px;
                text-align: center;
                border: none;
                background: transparent;
                font-weight: 600;
            }
            
            .remove-item {
                color: #ff4757;
                background: #ffe5e7;
                padding: 8px 15px;
                border-radius: 8px;
                text-decoration: none;
                font-size: 0.9em;
                transition: all 0.3s ease;
            }
            
            .remove-item:hover {
                background: #ff4757;
                color: white;
            }

            .cart-summary {
                background: white;
                border-radius: 15px;
                padding: 25px;
                position: sticky;
                top: 20px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            }
            
            .summary-title {
                font-size: 1.4em;
                color: #2d3436;
                margin-bottom: 20px;
                padding-bottom: 15px;
                border-bottom: 2px solid #f1f2f6;
            }
            
            .total-amount {
                font-size: 2em;
                color: #2d3436;
                font-weight: 700;
                margin: 20px 0;
            }
            
            .address-select {
                width: 100%;
                padding: 12px;
                border: 2px solid #f1f2f6;
                border-radius: 8px;
                margin: 15px 0;
                font-size: 0.95em;
                color: #2d3436;
                background: #f8f9fa;
                transition: all 0.3s ease;
            }
            
            .address-select:focus {
                border-color: #007bff;
                outline: none;
            }

            .checkout-btn {
                width: 100%;
                padding: 15px;
                background: #007bff;
                color: white;
                border: none;
                border-radius: 8px;
                font-size: 1.1em;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s ease;
            }
            
            .checkout-btn:hover {
                background: #0056b3;
                transform: translateY(-2px);
            }

            .price-tag {
                color: #007bff;
                font-weight: 600;
                font-size: 1.1em;
            }
            
            @media (max-width: 768px) {
                .cart-grid {
                    grid-template-columns: 1fr;
                }
                
                .cart-item {
                    grid-template-columns: 1fr;
                    gap: 15px;
                }
                
                .container {
                    padding: 0 15px;
                }
            }
        </style>
    </head>

    <body>
        <div class="container">
            <h1 class="page-title">Keranjang Belanja</h1>
            
            <div class="cart-grid">
                <div class="cart-items">
                    <?php
                    $total_harga = 0;
                    foreach ($_SESSION['cart'] as $key) { ?>
                        <div class="cart-item">
                            <div class="item-details">
                                <h3><?= htmlspecialchars($key['produk']) ?></h3>
                                <p class="price-tag">Rp<?= number_format($key['harga'], 0, ',', '.') ?></p>
                                <p><?= htmlspecialchars($key['deskripsi']) ?></p>
                                <div class="quantity-control">
                                    <a href="?menu=cart&subtract=<?= htmlspecialchars($key['id']) ?>"><i class="fas fa-minus"></i></a>
                                    <input type="number" value="<?= htmlspecialchars($key['jumlah']) ?>" readonly />
                                    <a href="?menu=cart&add=<?= htmlspecialchars($key['id']) ?>"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                            <p class="price-tag">Total: Rp<?= number_format($key['harga'] * $key['jumlah'], 0, ',', '.') ?></p>
                            <a href="?menu=cart&hapus=<?= htmlspecialchars($key['id']) ?>" class="remove-item">
                                <i class="fas fa-trash-alt"></i> Hapus
                            </a>
                        </div>
                        <?php
                        $total_harga += $key['harga'] * $key['jumlah'];
                    } ?>
                </div>
                
                <div class="cart-summary">
                    <h2 class="summary-title">Ringkasan Belanja</h2>
                    <div class="total-amount">
                        Rp<?= number_format($total_harga, 0, ',', '.') ?>
                    </div>
                    <form action="" method="POST">
                        <select name="alamat" class="address-select" required>
                            <option value="">Pilih Alamat Pengiriman...</option>
                            <?php foreach ($alamat_list as $address) {
                                $full_address = htmlspecialchars($address['jalan']) . ', ' .
                                htmlspecialchars($address['kota']) . ', ' .
                                htmlspecialchars($address['provinsi']) . ', ' .
                                'Kode Pos ' . htmlspecialchars($address['kode_pos']);
                                ?>
                                <option value="<?= htmlspecialchars($full_address); ?>">
                                    <?= htmlspecialchars($full_address); ?>
                                </option>
                                <?php } ?>
                            </select>
                            <button type="submit" name="checkout" class="checkout-btn">
                                <i class="fas fa-lock"></i> Checkout Sekarang
                            </button>
                        </form>
                    </div>
                </div>
        </div>
    <?php
} else if($cart <= 0) {
    header("location: index.php?menu=produk");
}
?>
    </body>
    </html>