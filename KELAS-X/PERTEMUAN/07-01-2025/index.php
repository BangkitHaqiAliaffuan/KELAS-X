<?php
include_once 'koneksi.php';
include_once 'Barang.php';

$database = new Database();
$db = $database->getConnection();
$barang = new Barang($db);

// Menangani operasi create
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['create'])) {
        if ($barang->create($_POST['nama_barang'], $_POST['harga'], $_POST['stok'], $_FILES['gambar'])) {
            // Redirect setelah berhasil menambah barang
            header("Location: index.php");
            exit(); // Pastikan untuk keluar setelah redirect
        } else {
            echo "<script>alert('Gagal menambahkan data.');</script>";
        }
    }

    // Menangani operasi delete
    if (isset($_POST['delete'])) {
        if ($barang->delete($_POST['id'])) {
            header("Location: index.php");
            exit();
        } else {
            echo "<script>alert('Gagal menghapus data.');</script>";
        }
    }

    // Menangani operasi update
    if (isset($_POST['update'])) {
        if ($barang->update($_POST['id'], $_POST['nama_barang'], $_POST['harga'], $_POST['stok'], $_FILES['gambar'])) {
            header("Location: index.php");
            exit();
        } else {
            echo "<script>alert('Gagal memperbarui data.');</script>";
        }
    }
}

// Menampilkan data barang
$stmt = $barang->read();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CRUD Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Data Barang</h1>
    
    <form method="post" class="form" id="form-barang" enctype="multipart/form-data">
        <input type="hidden" name="id" id="barang-id">
        <input type="text" name="nama_barang" id="barang-nama" placeholder="Nama Barang" required>
        <input type="number" name="harga" id="barang-harga" placeholder="Harga" required>
        <input type="number" name="stok" id="barang-stok" placeholder="Stok" required>
        <input type="file" name="gambar" id="barang-gambar">
        <button type="submit" name="create">Tambah Barang</button>
        <button type="submit" name="update" style="display:none;">Perbarui Barang</button> <!-- Sembunyikan tombol ini -->
    </form>

    <table border="1">
      <tr>
          <th>ID</th>
          <th>Nama Barang</th>
          <th>Harga</th>
          <th>Stok</th>
          <th>Gambar</th>
          <th>Aksi</th> <!-- Tambahkan kolom aksi -->
      </tr>
      <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
      <tr>
          <td><?php echo htmlspecialchars($row['id']); ?></td>
          <td><?php echo htmlspecialchars($row['nama_barang']); ?></td>
          <td><?php echo htmlspecialchars($row['harga']); ?></td>
          <td><?php echo htmlspecialchars($row['stok']); ?></td>
          <td><img src="<?php echo htmlspecialchars($row['gambar']); ?>" width="50"></td>
          <td>
              <!-- Tombol hapus -->
              <form method="post" style="display:inline;">
                  <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                  <button type="submit" name="delete" onclick="return confirm('Apakah Anda yakin ingin menghapus?');">Hapus</button>
              </form>

              <!-- Tombol edit -->
              <button onclick='editBarang(<?php echo json_encode($row); ?>)'>Edit</button>
          </td>
      </tr>
      <?php endwhile; ?>
    </table>
</div>

<script>
// Fungsi untuk mengisi form dengan data barang yang akan diedit
function editBarang(data) {
    document.getElementById('barang-id').value = data.id;
    document.getElementById('barang-nama').value = data.nama_barang;
    document.getElementById('barang-harga').value = data.harga;
    document.getElementById('barang-stok').value = data.stok;

    // Ubah tombol tambah menjadi tombol perbarui
    document.querySelector('button[name=create]').style.display = 'none';
    document.querySelector('button[name=update]').style.display = 'inline-block'; // Tampilkan tombol perbarui
}

// Fungsi untuk reset form
function resetForm() {
    document.getElementById('form-barang').reset();
    document.querySelector('button[name=create]').style.display = 'inline-block'; // Tampilkan tombol tambah
    document.querySelector('button[name=update]').style.display = 'none'; // Sembunyikan tombol perbarui
}

// Tambahkan event listener untuk reset form saat halaman dimuat
window.onload = function() {
    resetForm();
};

</script>

</body>
</html>
