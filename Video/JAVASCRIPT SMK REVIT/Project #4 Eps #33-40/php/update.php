<?php 

    require_once "koneksi.php";

    $data = stripslashes(file_get_contents("php://input"));   
    $dataPelanggan = json_decode($data, true);

    $idpelanggan = $dataPelanggan['idpelanggan'];
    $pelanggan = $dataPelanggan['pelanggan'];
    $alamat = $dataPelanggan['alamat'];
    $telp = $dataPelanggan['telp'];

    if(!empty($pelanggan) && !empty($alamat) && !empty($telp)){
        $sql = "UPDATE tblpelanggan SET pelanggan = '$pelanggan', alamat = `$alamat`, telp = `$telp` WHERE idpelanggan";

        if($result = mysqli_query($con, $sql)){
            echo "Data Sudah Terubah";
        } else{
            echo "Data Gagal Diubah";
        }

    } else{
        echo "Data Kosong";
    }

?>