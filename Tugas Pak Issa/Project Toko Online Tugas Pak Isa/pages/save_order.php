<?php
// Mengambil data dari sesi
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    header('Location: index.php?menu=login');
    exit();
}

// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "kacamata");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Mengambil data dari form
$nama_produk = isset($_POST['nama_produk']) ? $_POST['nama_produk'] : '';
$id = isset($_POST['produk_id']) ? $_POST['produk_id'] : '';
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;
$harga_produk = isset($_POST['harga_produk']) ? (float)$_POST['harga_produk'] : 0;
$total_harga = $harga_produk * $quantity;

// Ambil alamat pengguna dari database
function fetch_user_addresses($user_id, $koneksi) {
    $stmt = $koneksi->prepare("SELECT * FROM alamat WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

$addresses = fetch_user_addresses($user_id, $koneksi);

// Jika alamat belum disediakan, tampilkan formulir
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['alamat'])) {
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Alamat Pengiriman</title>
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
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        h1 {
            color: #2d3748;
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2rem;
            font-weight: 600;
        }

        .form-container {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 169px;
        }

        .address-list {
            display: grid;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .address-card {
            border: 2px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .address-card:hover {
            border-color: #4299e1;
            transform: translateY(-2px);
        }

        .address-card.selected {
            border-color: #4299e1;
            background-color: #ebf8ff;
        }

        .address-card input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        .address-card label {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            cursor: pointer;
        }

        .radio-custom {
            width: 1.25rem;
            height: 1.25rem;
            border: 2px solid #cbd5e0;
            border-radius: 50%;
            display: inline-block;
            position: relative;
            flex-shrink: 0;
            margin-top: 0.25rem;
        }

        .address-card.selected .radio-custom {
            border-color: #4299e1;
        }

        .address-card.selected .radio-custom::after {
            content: '';
            position: absolute;
            width: 0.75rem;
            height: 0.75rem;
            background: #4299e1;
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .address-details {
            flex-grow: 1;
        }

        .address-text {
            font-size: 1rem;
            color: #4a5568;
            line-height: 1.5;
        }

        .new-address {
            margin-top: 1.5rem;
        }

        .new-address input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .new-address input:focus {
            outline: none;
            border-color: #4299e1;
        }

        .submit-btn {
            display: block;
            width: 100%;
            padding: 1rem;
            background-color: #4299e1;
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 2rem;
        }

        .submit-btn:hover {
            background-color: #3182ce;
        }

        @media (max-width: 640px) {
            body {
                padding: 1rem;
            }

            .form-container {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Pilih Alamat Pengiriman</h1>
        <form action="" method="POST" class="form-container">
            <!-- Hidden inputs for product details -->
            <input type="hidden" name="nama_produk" value="<?php echo htmlspecialchars($nama_produk); ?>">
            <input type="hidden" name="produk_id" value="<?php echo $id; ?>">
            <input type="hidden" name="harga_produk" value="<?php echo $harga_produk; ?>">
            <input type="hidden" name="quantity" value="<?php echo $quantity; ?>">

            <?php if ($addresses): ?>
                <div class="address-list">
                    <?php foreach ($addresses as $index => $address): ?>
                        <div class="address-card">
                            <input type="radio" 
                                   name="alamat" 
                                   id="address_<?php echo $index; ?>" 
                                   value="<?php echo htmlspecialchars($address['jalan'] . ', ' . $address['kota'] . ', ' . $address['provinsi'] . ', ' . $address['kode_pos']); ?>"
                                   required>
                            <label for="address_<?php echo $index; ?>">
                                <span class="radio-custom"></span>
                                <div class="address-details">
                                    <p class="address-text">
                                        <?php echo htmlspecialchars($address['jalan']); ?><br>
                                        <?php echo htmlspecialchars($address['kota']); ?>, 
                                        <?php echo htmlspecialchars($address['provinsi']); ?><br>
                                        <?php echo htmlspecialchars($address['kode_pos']); ?>
                                    </p>
                                </div>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="new-address">
                    <input type="text" 
                           name="alamat" 
                           id="alamat" 
                           required 
                           placeholder="Masukkan alamat lengkap pengiriman">
                </div>
            <?php endif; ?>

            <button type="submit" class="submit-btn">Konfirmasi Pesanan</button>
        </form>
    </div>

    <script>
        // Add selected class to address card when radio is checked
        document.querySelectorAll('.address-card input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('.address-card').forEach(card => {
                    card.classList.remove('selected');
                });
                this.closest('.address-card').classList.add('selected');
            });
        });
    </script>
</body>
</html>
<?php
}

// Process the form submission
if (isset($_POST['alamat'])) {
    $alamat = $_POST['alamat'];
    $is_paid = 0;

    // Prepare and execute the order insertion
    $stmt = $koneksi->prepare("INSERT INTO orders (produk, jumlah, total_harga, user_id, is_paid, alamat) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sidsis", $nama_produk, $quantity, $total_harga, $user_id, $is_paid, $alamat);

    if ($stmt->execute()) {
        $_SESSION['order'] = [
            'nama_produk' => $nama_produk,
            'quantity' => $quantity,
            'total_harga' => $total_harga,
            'alamat' => $alamat,
            'is_paid' => $is_paid,
            'produk_id' => $id
        ];
        
        header("Location: index.php?menu=order");
        exit();
    }

    $stmt->close();
}

$koneksi->close();
?>