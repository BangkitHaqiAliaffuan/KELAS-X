<?php 

    require_once "../function.php";

    $sql = "DELETE FROM tablekategori WHERE idkategori = $id";

    $result = mysqli_query($koneksi, $sql);

    echo $sql;

    header ("http://localhost/php-smk-revit/restoran/kategori/select.php");

?>