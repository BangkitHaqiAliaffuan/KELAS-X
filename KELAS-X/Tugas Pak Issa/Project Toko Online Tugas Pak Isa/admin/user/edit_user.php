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

// Handle pengeditan user
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Update user into database
    $sql_update = "UPDATE user SET nama='$name', email='$email', role='$role' WHERE id='$id'";

    if (mysqli_query($conn, $sql_update)) {
        echo "<script>alert('User  berhasil diperbarui.'); window.location.href='user.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Ambil data user berdasarkan ID
$id = $_GET['id'];
$sql = "SELECT * FROM user WHERE id='$id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

// Cek apakah user ditemukan
if (!$user) {
    die("User  tidak ditemukan.");
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="../admin.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            /* Warna latar belakang */
            margin: 0;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        h1 {
            color: #007bff;
            /* Aksen warna biru */
        }

        .container-home {
            width: 700px;
            /* Lebar maksimum form */
            margin: 0 auto;
            /* Pusatkan form */
            background-color: #fff;
            /* Warna latar belakang form */
            padding: 20px;
            /* Ruang di dalam form */
            border-radius: 10px;
            /* Sudut membulat */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            /* Bayangan untuk efek kedalaman */
        }

        label {
            display: block;
            /* Membuat label menjadi block */
            margin-bottom: 5px;
            /* Jarak bawah label */
            color: #333;
            /* Warna teks label */
        }

        input[type="text"],
        input[type="email"],
        select {
            width: 90%;
            /* Lebar penuh */
            padding: 10px;
            /* Ruang di dalam input */
            margin-bottom: 15px;
            /* Jarak bawah input */
            border: 1px solid #ccc;
            /* Border abu-abu */
            border-radius: 5px;
            /* Sudut melengkung */
            font-size: 1em;
            /* Ukuran font */
            transition: border-color 0.3s;
            /* Transisi untuk border */
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        select:focus {
            border-color: #007bff;
            /* Warna border saat fokus */
            outline: none;
            /* Menghilangkan outline default */
        }

        input[type="submit"] {
            background-color: #007bff;
            /* Warna biru */
            color: white;
            /* Warna teks putih */
            border: none;
            /* Menghilangkan border default */
            padding: 10px 20px;
            /* Ruang di dalam tombol */
            border-radius: 5px;
            /* Sudut melengkung */
            font-size: 1.2em;
            /* Ukuran font tombol */
            cursor: pointer;
            /* Menunjukkan bahwa ini bisa diklik */
            transition: background-color 0.3s, transform 0.2s;
            /* Transisi untuk efek hover */
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
            /* Warna lebih gelap saat hover */
            transform: translateY(-2px);
            /* Efek angkat saat hover */
        }

        input[type="submit"]:active {
            transform: translateY(0);
            /* Kembali ke posisi semula saat ditekan */
        }
    </style>
</head>

<body>
   
    

    <div class="container-home">
        <form method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">

            <label for="name">Nama:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['nama']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="admin" <?php echo ($user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                <option value="user" <?php echo ($user['role'] == 'user') ? 'selected' : ''; ?>>User </option>
                <!-- Tambahkan opsi lain sesuai kebutuhan -->
            </select>

            <input type="submit" value="Perbarui User">
        </form>
    </div>

    <?php mysqli_close($conn); ?>
</body>

</html>