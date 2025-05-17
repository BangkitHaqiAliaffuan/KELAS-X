<?php
session_start();

// Koneksi ke database
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php"); // Redirect to login page
    exit();
}
$conn = mysqli_connect("localhost", "root", "", "kacamata");

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Handle penambahan user
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name']; // Ambil nama dari input
    $email = $_POST['email'];
    $password = $_POST['password']; // Hash password for security
    $role = $_POST['role']; // Ambil role dari input

    // Insert user into database
    $sql_insert = "INSERT INTO user (nama, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
    
    if (mysqli_query($conn, $sql_insert)) {
        echo "<script>alert('User berhasil ditambahkan.');</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Paging
$limit = 5; // Jumlah user per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Halaman saat ini
$offset = ($page - 1) * $limit; // Hitung offset

// Ambil data user dari database dengan paging
$sql = "SELECT * FROM user LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $sql);

// Hitung total jumlah user
$total_sql = "SELECT COUNT(*) as total FROM user";
$total_result = mysqli_query($conn, $total_sql);
$total_row = mysqli_fetch_assoc($total_result);
$total_users = $total_row['total'];
$total_pages = ceil($total_users / $limit); // Total halaman
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar User</title>
    <link rel="stylesheet" href="../admin.css">
</head>

<body>
    <header>
        <h1>Dashboard Admin</h1>
    </header>
    <nav>
        <ul>
            <li><a href="../logout.php">Logout</a></li>
            <li><a href="#">User Management</a></li>
            <li><a href="../index.php">Produk</a></li>
            <li><a href="#">Laporan</a></li>
        </ul>
    </nav>

    <div class="container-home">
        <!-- Tombol untuk menampilkan form tambah user -->
        <button id="showAddUserForm">Tambah User Baru</button>

        <!-- Form untuk menambah user baru -->
        <!-- Form untuk menambah user baru -->
        <div id="addUserForm" style="display:none;">
            <h2>Tambah User Baru</h2>
            <form id="addUserFormContent" method="post">
                <label for="name">Nama:</label>
                <input type="text" id="name" name="name" placeholder="Masukkan nama" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Masukkan email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required>

                <label for="role">Role:</label>
                <select id="role" name="role" required>
                    <option value="">Pilih Role</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                    <!-- Tambahkan opsi lain sesuai kebutuhan -->
                </select>

                <input type="submit" value="Tambah User">
            </form>
        </div>


        <!-- Tampilkan daftar user -->
        <h2>Daftar User</h2>
        <div id="userList">
            <?php
            // Cek apakah ada hasil
            if (mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<tr> <th>ID</th> <th>Nama</th> <th>Email</th> <th>Aksi</th>  </tr>";
                // Loop melalui hasil query dan tampilkan masing-masing record
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td class='column-aksi'> 
                        <a href='edit_user.php?id=" . urlencode($row['id']) . "'>Edit</a> | 
                        <a href='delete_user.php?id=" . urlencode($row['id']) . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus user ini?\");'>Hapus</a> 
                      </td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "Tidak ada user yang ditemukan.";
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

    <script>
        document.getElementById('showAddUserForm').onclick = function() {
            document.getElementById('addUserForm').style.display =
                document.getElementById('addUserForm').style.display === 'none' ? 'block' : 'none';
        };
    </script>

    <footer>
        &copy; <?php echo date("Y"); ?> Kacamata Online. Semua hak dilindungi.
    </footer>

    <?php // Tutup koneksi ke database mysqli_close($conn); 
    ?>
</body>

</html>