
<?php 

    if (isset($_GET['id'])){
        $id = $_GET['id'];
        $sql = ("SELECT * FROM tableuser WHERE iduser=$id");
        $row = $db->getITEM($sql);
    }

?>

<h3>Update User</h3>
<div class="form-group">
    <form action="" method="post">
        <div class="form-group">
            <label for="">Nama User :</label>
            <input type="text" name="user" required value="<?php echo $row['user']?>" class="form-control w-50 mt-2">            
        </div>
        <div class="form-group w-50">
            <label for="">Email :</label>
            <input type="email" required  value="<?php echo $row['email'] ?>" class="form-control" name="email">
        </div>
        <div class="form-group w-50">
            <label for="">Password :</label>
            <input type="password" required value="<?php echo $row['password'] ?>" class="form-control" name="password">
        </div>
        <div class="form-group w-50">
            <label for="">Konfirmasi Password Anda</label>
            <input type="password" required value="<?php echo $row['password'] ?>" class="form-control" name="konfirmasi">
        </div>
        <div class="form-group">
            <label for="">Level</label>
            <br>
            <select name="level" id="">
                <option value="admin" <?php if($row['level']==="admin") echo "selected" ?>>Admin</option>
                <option value="kasir" <?php if($row['level']==="kasir") echo "selected" ?>>Kasir</option>
                <option value="koki" <?php if($row['level']==="koki") echo "selected" ?>>Koki</option>
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
        $password = $_POST['password'];
        $email = $_POST['email'];
        $konfirmasi = $_POST['konfirmasi'];
        $level = $_POST['level'];

        if($password === $konfirmasi){
            $sql = "UPDATE tableuser SET user='$user', email='$email', password='$password', level='$level' WHERE iduser=$id";
            $db->runSQL($sql);
            header("location:?f=user&m=select"); 
        } else{
            echo "<h1>Password Tidak Sama</h1>";
        }
    }

?>