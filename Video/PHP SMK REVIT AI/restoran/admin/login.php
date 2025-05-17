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
    <title>Login Admin</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background: var(--secondary-color);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            background: white;
            border-radius: 8px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .login-header {
            padding: 2rem;
            text-align: center;
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
        }

        .login-logo {
            width: 70px;
            height: 70px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2rem;
        }

        .login-header h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            opacity: 0.8;
            margin-bottom: 0;
        }

        form {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: flex;
            align-items: center;
            color: var(--text-color);
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .form-group label i {
            color: var(--primary-color);
            margin-right: 0.5rem;
        }

        .form-control {
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 0.75rem 1rem;
            transition: all var(--transition-speed);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .btn-primary {
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border: none;
            padding: 0.75rem;
            font-weight: 500;
            transition: all var(--transition-speed);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow);
        }

        .text-center a {
            color: var(--primary-color);
            font-weight: 500;
            transition: all var(--transition-speed);
        }

        .text-center a:hover {
            color: var(--primary-dark);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <div class="login-logo">
                <i class="fas fa-user-shield"></i>
            </div>
            <h3>Admin Panel</h3>
            <p>Masuk untuk mengelola restoran</p>
        </div>
        <form action="" method="post">
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i>Email</label>
                <input type="email" id="email" name="email" required placeholder="Masukkan email admin" class="form-control">
            </div>
            <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i>Password</label>
                <input type="password" id="password" name="password" required placeholder="Masukkan password admin" class="form-control">
            </div>
            <div class="form-group mb-0">
                <button type="submit" name="login" class="btn btn-primary w-100">Masuk <i class="fas fa-sign-in-alt ms-2"></i></button>
            </div>
            <div class="text-center mt-3">
                <a href="../index.php"><i class="fas fa-home me-1"></i> Kembali ke Beranda</a>
            </div>
        </form>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
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