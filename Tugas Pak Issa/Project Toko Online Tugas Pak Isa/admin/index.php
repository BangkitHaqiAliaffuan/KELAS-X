<?php
session_start();
// Koneksi ke database
// if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
//     header("Location: login.php"); // Redirect to login page
//     exit();
// }
$conn = mysqli_connect("localhost", "root", "", "kacamata");

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Handle penambahan produk
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_barang = $_POST['nama_barang'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $stock = $_POST['stock']; // Ambil nilai stock dari form

    // Handle file upload
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["gambar"]["name"]);

    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
        $sql_insert = "INSERT INTO produk (produk, deskripsi, harga, gambar, stock) VALUES ('$nama_barang', '$deskripsi', '$harga', '$target_file', '$stock')";

        if (mysqli_query($conn, $sql_insert)) {
            echo "<script>alert('Produk berhasil ditambahkan.');</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
    }
}

// Paging
$limit = 5; // Jumlah barang per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Halaman saat ini
$offset = ($page - 1) * $limit; // Hitung offset

// Ambil data produk dari database dengan paging
$sql = "SELECT * FROM produk LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $sql);

// Hitung total jumlah produk
$total_sql = "SELECT COUNT(*) as total FROM produk";
$total_result = mysqli_query($conn, $total_sql);
$total_row = mysqli_fetch_assoc($total_result);
$total_products = $total_row['total'];
$total_pages = ceil($total_products / $limit); // Total halaman

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar Produk</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="admin.css">
    <style>
        
        
    </style>
</head>

<body>
    <header>
        <h1>Dashboard Admin</h1>
    </header>

    <!-- Navbar -->
    <nav>
        <ul>
            <li><a href="logout.php">Logout</a></li>
            <li><a href="user/user.php">User Management</a></li>
            <li><a href="#">Produk</a></li>
            <li><a href="#">Laporan</a></li>
        </ul>
    </nav>

    <div class="container-home">
        <!-- Tombol untuk menampilkan form tambah produk -->
        <button id="showAddProductForm">Tambah Produk Baru</button>

        <!-- Form untuk menambah produk baru -->
        <div id="addProductForm" style="display:none;">
            <h2>Tambah Produk Baru</h2>
            <form id="addProductFormContent" method="post" enctype="multipart/form-data">
                <label for="nama_barang">Nama Barang:</label>
                <input type="text" id="nama_barang" name="nama_barang" placeholder="Masukkan nama barang" required>

                <label for="deskripsi">Deskripsi:</label>
                <textarea id="deskripsi" name="deskripsi" placeholder="Masukkan deskripsi produk" required></textarea>

                <label for="harga">Harga:</label>
                <input type="number" id="harga" name="harga" placeholder="Masukkan harga produk" required>

                <label for="gambar" class="custom-file-upload">
                    <input type="file" id="gambar" name="gambar" accept="image/*">
                    Pilih Gambar
                </label>

                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" placeholder="Masukkan jumlah stock" required>

                <div id="imagePreviewContainer" style="display: none;">
                    <h3>Preview Gambar:</h3>
                    <img id="imagePreview" src="" alt="Preview Gambar" style="max-width: 100%; border-radius: 5px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                </div>

                <input type="submit" value="Tambah Produk">
            </form>
        </div>

        <!-- Tampilkan daftar produk -->
        <h2>Daftar Produk</h2>
        <div id="productList">
            <?php
            // Cek apakah ada hasil
            if (mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<tr>
                        <th>ID</th>
                        <th>Nama Barang</th>
                        <th>Deskripsi</th>
                        <th>Stock</th>
                        <th>Harga</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                      </tr>";

                // Loop melalui hasil query dan tampilkan masing-masing record
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr class='produk'>"; // Tambahkan kelas 'produk' untuk efek hover
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['produk']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['deskripsi']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['stock']) . "</td>"; // Menampilkan stock
                    echo "<td class='column-harga'>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>"; // Format harga
                    echo "<td><img src='" . htmlspecialchars($row['gambar']) . "' alt='" . htmlspecialchars($row['produk']) . "'></td>";

                    // Kolom untuk aksi edit dan hapus
                    echo "<td class='column-aksi'>
                            <a href='edit.php?id=" . urlencode($row['id']) . "'>Edit</a> | 
                            <a href='delete.php?id=" . urlencode($row['id']) . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus produk ini?\");'>Hapus</a>
                          </td>";

                    echo "</tr>";
                }

                // Tutup tabel HTML
                echo "</table>";
            } else {
                echo "Tidak ada produk yang ditemukan.";
            }
            ?>
        </div>

        <!-- Navigasi Paging -->
        <?php if ($total_pages > 1): ?>
            <div class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <?php if ($i == $page): ?>
                        <strong><?php echo $i; ?></strong> <!-- Halaman saat ini -->
                    <?php else: ?>
                        <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a> <!-- Tautan ke halaman lain -->
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Script AJAX untuk menambah produk -->
    <script>
        $(document).ready(function() {
            $('#showAddProductForm').click(function() {
                $('#addProductForm').toggle(); // Tampilkan atau sembunyikan form saat tombol diklik
            });
        });
    </script>

    <!-- Script untuk preview gambar -->
    <script>
        document.getElementById('gambar').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                const imagePreview = document.getElementById('imagePreview');
                imagePreview.src = e.target.result; // Set src dari img ke hasil pembacaan
                document.getElementById('imagePreviewContainer').style.display = 'block'; // Tampilkan kontainer preview
            }

            if (file) {
                reader.readAsDataURL(file); // Membaca file sebagai URL data
            }
        });
    </script>

    <footer>
        &copy; <?php echo date("Y"); ?> Kacamata Online. Semua hak dilindungi.
    </footer>

    <?php
    // Tutup koneksi ke database
    mysqli_close($conn);
    ?>
</body>

</html>