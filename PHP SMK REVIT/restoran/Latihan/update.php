

<?php 

    require_once "../function.php";

    $sql = "SELECT * FROM tablekategori WHERE idkategori = $id";

    $result = mysqli_query($koneksi, $sql);

    $row = mysqli_fetch_assoc($result);

    // $kategori = 'akbar sudah sigma';
    // $id = 16;
    // $sql = "UPDATE tablekategori SET kategori='$kategori' WHERE idkategori=$id ";

    // $result = mysqli_query($koneksi, $sql);
    // echo $sql;
?> 

<form action="" method="post">
    Kategori :
    <input type="text" name="kategori" value="<?php echo $row['kategori'];?>">
    <input type="submit" value="simpan" name="simpan">
</form>

<?php

    if (isset($_POST['simpan'])){

        $kategori = $_POST['kategori'];
        $sql = "UPDATE tablekategori SET kategori='$kategori' WHERE idkategori = $id";

        $result = mysqli_query($koneksi, $sql);

        header ("location:http://localhost/php-smk-revit/restoran/kategori/select.php");
    }

?>