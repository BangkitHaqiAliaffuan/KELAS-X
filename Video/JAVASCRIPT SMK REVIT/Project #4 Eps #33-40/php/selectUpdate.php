<?php 

    require_once "koneksi.php";

    
    $data = stripslashes(file_get_contents("php://input"));

    $idpelanggan = json_decode($data, true);

    $idpelanggan = $idpelanggan['idpelanggan'];

    $sql = "SELECT * FROM tblpelanggan WHERE idpelanggan = $idpelanggan";

    $result = mysqli_query($conn, $sql);

    $row = mysqli_fetch_array($result);

    echo json_encode($row);

?>