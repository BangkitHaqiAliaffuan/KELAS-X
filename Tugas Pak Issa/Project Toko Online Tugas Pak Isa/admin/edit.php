<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "kacamata";

$koneksi = mysqli_connect($host, $user, $password, $database);

if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}

// Ambil ID dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Memeriksa apakah ID produk valid
if ($id > 0) {
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
    } else {
        die('Produk tidak ditemukan.');
    }
} else {
    die('ID produk tidak valid.');
}

// Handle update produk
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Initialize arrays for building the query
    $updateFields = [];
    $params = [];
    $types = "";

    // Check and add nama_barang
    if (!empty($_POST['nama_barang'])) {
        $updateFields[] = "produk=?";
        $params[] = $_POST['nama_barang'];
        $types .= "s";
    }
    
    // Check and add deskripsi
    if (!empty($_POST['deskripsi'])) {
        $updateFields[] = "deskripsi=?";
        $params[] = $_POST['deskripsi'];
        $types .= "s";
    }

    // Check and add harga
    if (!empty($_POST['harga'])) {
        $updateFields[] = "harga=?";
        $params[] = $_POST['harga'];
        $types .= "d";
    }

    // Check and add stock
    if (!empty($_POST['stock'])) {
        $updateFields[] = "stock=?";
        $params[] = $_POST['stock'];
        $types .= "i";
    }

    // Handle file upload
    if ($_FILES["gambar"]["error"] == UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($_FILES["gambar"]["type"], $allowedTypes)) {
            $target_dir = "../uploads/";
            $target_file_path = $target_dir . basename($_FILES["gambar"]["name"]);
            
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file_path)) {
                $updateFields[] = "gambar=?";
                $params[] = $target_file_path;
                $types .= "s";
            }
        }
    }

    // Only proceed if there are fields to update
    if (!empty($updateFields)) {
        // Build the SQL query
        $sql_update = "UPDATE produk SET " . implode(", ", $updateFields) . " WHERE id=?";
        
        // Add the ID parameter
        $params[] = $id;
        $types .= "i";

        // Prepare and execute the statement
        if ($stmt_update = mysqli_prepare($koneksi, $sql_update)) {
            // Create array with $types as first element followed by references to params
            $bindParams = array($stmt_update, $types);
            foreach ($params as &$param) {
                $bindParams[] = &$param;
            }
            
            // Call bind_param with the constructed array
            call_user_func_array('mysqli_stmt_bind_param', $bindParams);
            
            if (mysqli_stmt_execute($stmt_update)) {
                echo "<script>alert('Produk berhasil diperbarui.'); window.location.href='index.php';</script>";
            } else {
                echo "Error: " . mysqli_error($koneksi);
            }
            
            mysqli_stmt_close($stmt_update);
        }
    } else {
        echo "<script>alert('Tidak ada field yang diupdate.');</script>";
    }
}

mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
 background-color: #f4f4f4;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"],
        input[type="number"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            text-align: center;
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<h2>Edit Produk</h2>

<form method="post" enctype="multipart/form-data">
    <label for="nama_barang">Nama Barang:</label>
    <input type="text" id="nama_barang" name="nama_barang" value="<?php echo htmlspecialchars($nama_produk); ?>">

    <label for="deskripsi">Deskripsi:</label>
    <textarea id="deskripsi" name="deskripsi"><?php echo htmlspecialchars($deskripsi_produk); ?></textarea>

    <label for="harga">Harga:</label>
    <input type="text" id="harga" name="harga" value="<?php echo htmlspecialchars($harga_produk); ?>">
    
    <label for="gambar">Pilih Gambar Baru (jika ingin mengganti):</label>
    <input type="file" id="gambar" name="gambar" accept="image/*">

    <label for="stock">Stock:</label>
    <input type="number" id="stock" name="stock" value="<?php echo htmlspecialchars($jumlah_produk); ?>">

    <input type="submit" value="Perbarui Produk">
</form>

<a href="index.php">Kembali ke Daftar Produk</a>
</body>
</html>