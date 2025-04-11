<form action="nav.php" method="get">
    Nama    :
    <input type="text" name="nama" placeholder="Masukkan Nama Anda">
    Alamat  :
    <input type="text" name="alamat" placeholder="Masukkan Alamat Anda">
    <input type="submit" value="simpan" name="kirim">
</form>

<?php 

    if ( isset($_GET['kirim'])){
       
        $nama = $_GET['nama'];
        $alamat = $_GET['alamat'];

        echo $nama;
        echo '<br>';
        echo $alamat;
    }

?>