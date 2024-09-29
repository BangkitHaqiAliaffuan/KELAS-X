<h3>Insert User</h3>
<div class="form-group">
    <form action="" method="post">
        <div class="form-group">
            <label for="">Nama User :</label>
            <input type="text" name="user" required placeholder="Isi Nama User" class="form-control w-50 mt-2">            
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
        <div class="form-group">
            <label for="">Level</label>
            <br>
            <select name="level" id="">
                <option value="admin">Admin</option>
                <option value="kasir">Kasir</option>
                <option value="koki">Koki</option>
            </select>            
        </div>
        <div class="">
            <input class="btn btn-primary mt-5" type="submit" name="simpan" value="simpan">
        </div>
    </form>
</div>
<?php 

    if(isset($_POST['simpan'])){
        $user = $_POST['user'];
        $password = hash('sha256', $_POST['password']);
        $email = $_POST['email'];
        $konfirmasi = hash('sha256', $_POST['konfirmasi']);
        $level = $_POST['level'];

        if($password === $konfirmasi){
            $sql = "INSERT INTO tableuser VALUES ('', '$user','$password','$email','$level',1)";
            $db->runSQL($sql);
            header("location:?f=user&m=select"); 
        } else{
            echo "<h1>Password Tidak Sama</h1>";
        }

        // 
    }

?>