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

// Proses penghapusan user
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus user dari database
    $sql_delete = "DELETE FROM user WHERE id='$id'";
    
    if (mysqli_query($conn, $sql_delete)) {
        echo "<script>alert('User berhasil dihapus.'); window.location.href='user.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
