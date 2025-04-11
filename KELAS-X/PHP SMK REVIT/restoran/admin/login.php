<?php 
  session_start();
  require_once "../dbcontroller.php"; 
  $db = new DB();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Restoran</title>
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
        $password = hash('sha256', $_POST['password']);
        
        $sql = "SELECT * FROM tableuser WHERE email='$email' AND password='$password'";
            
        
        $count = $db->rowCOUNT($sql);

        if($count == 0){
            echo "<center><h3>Email Atau Password Salah</h3></center>";
        }else{
            $sql = "SELECT * FROM tableuser WHERE email='$email' AND password='$password'";
            $row = $db -> getITEM($sql);

            $_SESSION['user']=$row['email'];
            $_SESSION['level']=$row['level'];
            $_SESSION['iduser']=$row['iduser'];
            header("Location: index.php");
        }

    }

?>