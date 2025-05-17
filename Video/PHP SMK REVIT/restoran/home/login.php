

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pelanggan</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-4 mx-auto mt-4">
                <div class="form-group">
                    <form action="" method="post">
                        <div class="">
                            <h3>Login Restoran</h3>
                        </div>
                        <div class="form-group">
                            <label for="">Email :</label>
                            <input type="email" name="email" required placeholder="Isi email" class="form-control  mt-2">            
                        </div>
                        <div class="form-group">
                            <label for="">Password :</label>
                            <input type="password" name="password" required placeholder="Isi Password" class="form-control  mt-2">            
                        </div>
                        <div class="">
                            <input class="btn btn-primary mt-5" type="submit" name="login" value="login">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php 

    if(isset($_POST['login'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $sql = "SELECT * FROM tablepelanggan WHERE email='$email' AND password='$password' AND aktif=1";
            
        
        $count = $db->rowCOUNT($sql);

        if($count == 0){
            echo "<center><h3>Email Atau Password Salah</h3></center>";
        }else{
            $row = $db -> getITEM($sql);

            $_SESSION['pelanggan']=$row['email'];
            $_SESSION['idpelanggan']=$row['idpelanggan'];
            header("Location: index.php");
        }

    }

?>