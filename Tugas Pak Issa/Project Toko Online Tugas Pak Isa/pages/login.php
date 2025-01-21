<?php

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM user WHERE email='$email' and password='$password'";
    
    $result = mysqli_query($koneksi, $sql);
    
    if (mysqli_num_rows($result) === 0) {
        echo "<h1>Email atau Password Salah</h1>";
    } else {
        // Ambil data pengguna
        $row = mysqli_fetch_assoc($result);
        
        // Simpan ID pengguna dan email ke dalam sesi
        $role = $row['role'];
        if ($role == 'admin') {
            $_SESSION['email'] = $row['email']; // Simpan email pengguna
            $_SESSION['user_id'] = $row['id']; // Simpan ID pengguna
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_name'] = $row['nama'];
            header('location: admin/index.php');
            exit();
        } 
        if ($role == 'user') {
            $_SESSION['user_id'] = $row['id']; // Simpan ID pengguna
            $_SESSION['email'] = $row['email']; // Simpan email pengguna
            echo "<script>window.location.href = 'index.php?menu=home'</script>";
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Gramedia - Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            margin-left: -40px;
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .login-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        .login-container form {
            display: flex;
            flex-direction: column;
            position: relative;
        }
        .login-container form .input-container {
            position: relative;
            margin-bottom: 20px;
        }
        .login-container form input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 20px;
            transition: all 0.3s ease;
            outline: none;
            width: 100%;
        }
        .login-container form input:focus {
            border-color: #1a73e8;
            box-shadow: 0 0 10px rgba(26, 115, 232, 0.2);
        }
        .login-container form .input-container label {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            background-color: #fff;
            padding: 0 5px;
            color: #999;
        }
        .login-container form input:focus + label,
        .login-container form input:not(:placeholder-shown) + label {
            top: -10px; left: 10px; font-size: 12px; color: #1a73e8;
        }
        .login-container form button {
            padding: 10px 20px;
            background-color: #1a73e8;
            color: #fff;
            border: none;
            border-radius: 20px;
            cursor: pointer;
        }
        .login-container form button:hover {
            background-color: #1558b0;
        }
        .login-container .register-link {
            margin-top: 20px; font-size: 14px; color: #333;
        }
        .login-container .register-link a {
           color:#1a73e8; text-decoration:none; font-weight:bold; 
       }
       .login-container .register-link a:hover { text-decoration:none; color:#1558b0; }
    </style>
</head>
<body>
    <div class="login-container">
       <h2>Masuk ke Akun Anda</h2>
       <form method="post">
           <div class="input-container">
               <input id="email" name="email" placeholder=" " type="email" required/>
               <label for="email">Email</label>
           </div>
           <div class="input-container">
               <input id="password" name="password" placeholder=" " type="password" required/>
               <label for="password">Password</label>
           </div>
           <button type="submit" name="submit">Masuk</button>
       </form>
       <div class="register-link">
           Belum punya akun? <a href="#">Daftar</a>
       </div>
   </div>
</body>
</html>
