<h3>Registrasi Pelanggan</h3>
<div class="form-group">
    <form action="" method="post">
        <div class="form-group">
            <label for="">Nama Pelanggan :</label>
            <input type="text" name="pelanggan" required placeholder="Isi Nama Anda" class="form-control w-50 mt-2">            
        </div>
        <div class="form-group">
            <label for="">Alamat :</label>
            <input type="text" name="alamat" required placeholder="Isi Alamat Anda" class="form-control w-50 mt-2">            
        </div>
        <div class="form-group">
            <label for="">telp :</label>
            <input type="text" name="telp" required placeholder="Isi Nomor Telpon Anda" class="form-control w-50 mt-2">            
        </div>
        <div class="form-group w-50">
            <label for="">Email :</label>
            <input type="email" required placeholder="Isi Email Anda" class="form-control" name="email">
        </div>
        <div class="form-group w-50">
            <label for="">Password :</label>
            <input type="password" required placeholder="Isi Password Anda" class="form-control" name="password">
        </div>
        <div class="form-group w-50">
            <label for="">Konfirmasi Password Anda</label>
            <input type="password" required placeholder="Konfirmasi Password Anda" class="form-control" name="konfirmasi">
        </div>
        
        <div class="">
            <input class="btn btn-primary mt-5" type="submit" name="simpan" value="simpan">
        </div>
    </form>
</div>
<?php 

    if(isset($_POST['simpan'])){
        $pelanggan = $_POST['pelanggan'];
        $alamat = $_POST['alamat'];
        $telp = $_POST['telp'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $konfirmasi = $_POST['konfirmasi'];
    

        if($password === $konfirmasi){
            $sql = "INSERT INTO tablepelanggan VALUES ('', '$pelanggan','$alamat','$telp','$password','$email',1)";
            // echo $sql;
            $db->runSQL($sql);
            header("location:?f=home&m=info"); 
        } else{
            echo "<h1>Password Tidak Sama</h1>";
        }

        // 
    }

?>