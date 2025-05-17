<form action="" method="post">
    kategori :
    <input type="text" name="kategori">
    <input type="submit" value="simpan" name="simpan">
</form>

<?php 

    require_once "../function.php";

    if (isset($_POST['simpan'])){

        $kategori = $_POST['kategori'];

        $sql = "INSERT INTO tablekategori VALUES ('', '$kategori')";

        $result = mysqli_query($koneksi, $sql);

        header ("http://localhost/php-smk-revit/restoran/kategori/select.php");

    }

?>