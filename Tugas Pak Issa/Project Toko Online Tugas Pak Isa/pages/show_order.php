<?php

// Memeriksa apakah pengguna terdaftar
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?menu=login');
    exit(); // Pastikan untuk keluar setelah redirect
}

// Koneksi ke database
// Memeriksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Mengambil ID pengguna dari sesi
$user_id = $_SESSION['user_id'];

// Mengambil semua pesanan dari tabel orders berdasarkan user_id
$sql_orders = "SELECT * FROM orders WHERE user_id = ?";
$stmt_orders = $koneksi->prepare($sql_orders);
$stmt_orders->bind_param("i", $user_id);
$stmt_orders->execute();
$result_orders = $stmt_orders->get_result();

// Mengambil semua keranjang yang belum dibayar dari tabel orders_carts
$sql_carts = "SELECT oc.*, p.produk, p.deskripsi, p.harga FROM orders_carts oc 
              JOIN produk p ON oc.produk_id = p.id 
              WHERE oc.user_id = ? AND oc.is_paid = 0";
$stmt_carts = $koneksi->prepare($sql_carts);
$stmt_carts->bind_param("i", $user_id);
$stmt_carts->execute();
$result_carts = $stmt_carts->get_result();

// Proses pembayaran
if (isset($_POST['pay_cart'])) {
    $cart_id = $_POST['pay_cart']; // Mengambil cart ID dari form

    // Memperbarui status pembayaran untuk setiap item dalam cart
    $update_stmt = $koneksi->prepare("UPDATE orders_carts SET is_paid = 1 WHERE cart_id = ? AND user_id = ?");
    $update_stmt->bind_param("si", $cart_id, $user_id);

    if ($update_stmt->execute()) {
        // Hapus item dari tabel orders_carts setelah pembayaran berhasil
        $delete_stmt = $koneksi->prepare("DELETE FROM orders_carts WHERE cart_id = ? AND user_id = ?");
        $delete_stmt->bind_param("si", $cart_id, $user_id);
        $delete_stmt->execute();

        // Set thank you message
        $_SESSION['thank_you_message'] = "Terima kasih telah melakukan pembelian!";

        header("Location: index.php?menu=show_order");
        exit();
    } else {
        echo "Error: " . $update_stmt->error;
    }
}

// Proses pembatalan pesanan dari tabel orders_carts
if (isset($_POST['cancel_cart'])) {
    $cart_id_to_cancel = $_POST['cart_id']; // Mengambil cart ID dari form

    // Menghapus keranjang dari tabel orders_carts berdasarkan cart_id dan user_id
    $delete_cart_stmt = $koneksi->prepare("DELETE FROM orders_carts WHERE cart_id = ? AND user_id = ?");
    $delete_cart_stmt->bind_param("si", $cart_id_to_cancel, $user_id);

    if ($delete_cart_stmt->execute()) {
        header("Location: index.php?menu=show_order"); // Arahkan kembali setelah membatalkan
        exit();
    } else {
        echo "Error: " . $delete_cart_stmt->error;
    }
}

// Menampilkan data pesanan jika tidak ada proses yang dilakukan
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Riwayat Pesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
        }

        h1 {
            color: #007bff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:hover {
            background-color: rgba(226, 225, 225, 0.91);
            transition: all ease 200ms;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .back-button {
            display: inline-block;
            margin-top: 20px;
            margin-bottom: 20px;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .back-button:hover {
            background-color: #0056b3;
        }

        .cart-item {
            background-color: white;
            padding: 10px;
            margin: 20px;
            display: flex;
            flex-direction: column;
            border-radius: 10px;
        }

        #thankYouMessage {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>Riwayat Pesanan Anda</h1>

    <?php if (isset($_SESSION['thank_you_message'])): ?>
        <div id="thankYouMessage">
            <?= htmlspecialchars($_SESSION['thank_you_message']) ?>
        </div>
        <?php unset($_SESSION['thank_you_message']); ?> <!-- Unset the message after displaying -->
    <?php endif; ?>

    <?php if ($result_orders->num_rows > 0): ?>
        <h2>Pesanan yang Sudah Dibayar</h2>
        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Alamat Pengiriman</th>
                    <th>Status Pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_orders->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['produk']); ?></td>
                        <td><?php echo htmlspecialchars($row['jumlah']); ?></td>
                        <td>Rp<?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
                        <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                        <td><?php echo $row['is_paid'] == 1 ? 'Sudah Dibayar' : 'Belum Dibayar'; ?></td>
                        <td>
                            <!-- Form untuk membatalkan pesanan -->
                            <form action="" method="POST" style="display:inline;">
                                <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                <input type="hidden" name="cancel_order" value="1">
                                <button type="submit">Batalkan Pesanan</button>
                            </form>

                            <!-- Form untuk melakukan pembayaran -->
                            <?php if ($row['is_paid'] == 0): ?>
                                <form action="" method="POST" style="display:inline;">
                                    <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                    <input type="hidden" name="pay_order" value="1">
                                    <button type="submit">Bayar</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Anda belum memiliki pesanan.</p>
    <?php endif; ?>

    <?php if ($result_carts->num_rows > 0): ?>
        <h2>Keranjang Belanja yang Belum Dibayar</h2>

        <?php while ($cart_row = $result_carts->fetch_assoc()): ?>
            <div class="cart-item">
                <h3>Cart ID : <?= htmlspecialchars($cart_row['cart_id']) ?></h3>

                <!-- Fetch products in this cart -->
                <?php
                $cart_products_stmt = $koneksi->prepare("SELECT p.produk, p.deskripsi, p.harga, oc.jumlah FROM orders_carts oc 
                                                          JOIN produk p ON oc.produk_id = p.id 
                                                          WHERE oc.cart_id = ?");
                $cart_products_stmt->bind_param("s", $cart_row['cart_id']);
                $cart_products_stmt->execute();
                $cart_products_result = $cart_products_stmt->get_result();

                // Initialize totals
                $total_quantity = 0;
                $total_price = 0;

                if ($cart_products_result && $cart_products_result->num_rows > 0): ?>
                    <table style="width:auto;">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($product_row = $cart_products_result->fetch_assoc()): ?>
                                <?php
                                // Calculate totals
                                $product_total_price = $product_row['harga'] * $product_row['jumlah'];
                                $total_quantity += (int)$product_row['jumlah'];
                                $total_price += (float)$product_total_price;
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($product_row['produk']); ?></td>
                                    <td><?php echo htmlspecialchars($product_row['jumlah']); ?></td>
                                    <td>Rp<?php echo number_format($product_total_price, 0, ',', '.'); ?></td> <!-- Total price calculated here -->
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>

                    <!-- Display total quantity and total price for the cart -->
                    <p><strong>Total Jumlah:</strong> <?= htmlspecialchars($total_quantity) ?></p>
                    <p><strong>Total Harga:</strong> Rp<?= number_format($total_price, 0, ',', '.') ?></p>

                    <!-- Payment button for the entire cart -->
                        <form action="" method="POST" style="display:inline;">
                            <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($cart_row['cart_id']); ?>">
                            <input type="hidden" name="pay_order" value="1">
                            <button type="submit">Bayar</button>
                        </form>
                    <form action="" method="POST" style="display:inline;">
                        <input type="hidden" name="cart_id" value="<?php echo htmlspecialchars($cart_row['cart_id']); ?>">
                        <button type="submit" style="margin-top: 20px;" name="cancel_cart">Batalkan Pesanan</button>
                    </form>


                <?php else: ?>
                    <p>Tidak ada produk dalam keranjang ini.</p>
                <?php endif; ?>

                <!-- Close cart item div -->
            </div>

            <?php
            // Clean up prepared statement
            $cart_products_stmt->close();
            ?>

        <?php endwhile; ?>

    <?php else: ?>
        <p>Tidak ada keranjang yang belum dibayar.</p>
    <?php endif; ?>

    <!-- Back button -->
    <a href="index.php" class="back-button">Kembali ke Beranda</a>

    <script>
        // Check if the thank you message exists and set a timeout for it to disappear
        window.onload = function() {
            const thankYouMessage = document.getElementById('thankYouMessage');
            if (thankYouMessage) {
                setTimeout(function() {
                    thankYouMessage.style.display = 'none'; // Hide the message after 3 seconds
                }, 3000); // Hide after 3000 milliseconds (3 seconds)
            }
        };
    </script>

</body>

<?php
// Menutup pernyataan dan koneksi
$stmt_orders->close();
$stmt_carts->close();
$koneksi->close();
?>