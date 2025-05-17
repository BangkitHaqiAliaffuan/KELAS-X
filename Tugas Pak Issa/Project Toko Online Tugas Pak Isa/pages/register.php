<?php
// Database connection variables
$host = "localhost"; // Your database host
$user = "root";      // Your database username
$password = "";      // Your database password
$database = "kacamata"; // Your database name

// Create connection
$koneksi = mysqli_connect($host, $user, $password, $database);

// Check connection
if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if (isset($_POST['submit'])) {
    $name = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = "user";
    
    // Insert user into the database
    $sql_user = "INSERT INTO user (nama, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
    
    if (mysqli_query($koneksi, $sql_user)) {
        // Get the last inserted user ID
        $user_id = mysqli_insert_id($koneksi);
        
        // Get address details from the form
        $jalan = $_POST['jalan'];
        $kota = $_POST['kota'];
        $provinsi = $_POST['provinsi'];
        $kode_pos = $_POST['kode_pos'];

        // Insert address into the database
        $sql_address = "INSERT INTO alamat (user_id, jalan, kota, provinsi, kode_pos) VALUES ('$user_id', '$jalan', '$kota', '$provinsi', '$kode_pos')";
        
        if (mysqli_query($koneksi, $sql_address)) {
            header("location:index.php?menu=login");
            exit();
        } else {
            echo "Error: " . mysqli_error($koneksi);
        }
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Gramedia - Register</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet" />
    <style>
        .hidden{
            display: none;
        }
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
        .register-container {
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
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .register-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        .register-container form {
            display: flex;
            flex-direction: column;
            position: relative;
        }
        .register-container form .input-container {
            position: relative;
            margin-bottom: 20px;
        }
        .register-container form input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 20px;
            transition: all 0.3s ease;
            outline: none;
            width: 100%;
        }
        .register-container form input:focus {
            border-color: #1a73e8;
            box-shadow: 0 0 10px rgba(26, 115, 232, 0.2);
        }
        .register-container form .input-container label {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            background-color: #fff;
            padding: 0 5px;
            color: #999;
        }
        .register-container form input:not(:placeholder-shown) + label,
        .register-container form input:focus + label {
            top: -10px; left: 10px; font-size: 12px; color: #1a73e8; 
        }
        .register-container form button {
            padding: 10px 20px;
            background-color: #1a73e8;
            color: #fff;
            border: none;
            border-radius: 20px;
            cursor: pointer;
        }
        .register-container form button:hover {
            background-color: #1558b0; 
        }
        .register-container .login-link {
           margin-top: 20px; font-size:14px; color:#333; 
       }
       .register-container .login-link a { color:#1a73e8; text-decoration:none; }
       .register-container .login-link a:hover { text-decoration:none; color:#1558b0; }
    </style>
</head>

<body>
    <div class="register-container">
        <h2>Daftar Akun Baru</h2>
        <form method="post" id="registration-form">
           <div id="basic-info">
               <div class="input-container">
                   <input id="name" name="nama" placeholder=" " type="text" required />
                   <label for="name">Nama Lengkap</label>
               </div>
               <div class="input-container">
                   <input id="email" name="email" placeholder=" " type="email" required />
                   <label for="email">Email</label>
               </div>
               <div class="input-container">
                   <input id="password" name="password" placeholder=" " type="password" required />
                   <label for="password">Password</label>
               </div>
               <div class="input-container">
                   <input id="confirm-password" placeholder=" " type="password" required />
                   <label for="confirm-password">Konfirmasi Password</label>
               </div>
               <!-- Button to proceed to address input -->
               <button type="button" id="proceed-button">Lanjut</button>
           </div>

           <!-- New Address Fields -->
           <div id="address-fields" class="hidden">
               <div class="input-container">
                   <input id="jalan" name="jalan" placeholder=" " type="text" required />
                   <label for="jalan">Jalan</label>
               </div>
               <div class="input-container">
                   <input id="kota" name="kota" placeholder=" " type="text" required />
                   <label for="kota">Kota</label>
               </div>
               <div class="input-container">
                   <input id="provinsi" name="provinsi" placeholder=" " type="text" required />
                   <label for="provinsi">Provinsi</label>
               </div>
               <div class="input-container">
                   <input id="kode_pos" name="kode_pos" placeholder=" " type="text" required />
                   <label for="kode_pos">Kode Pos</label>
               </div>

               <!-- Register button -->
               <button type="submit" name="submit" id="register-button">Daftar</button>
           </div>
           <!-- End of New Address Fields -->
       </form>
       <div class="login-link">
           Sudah punya akun? <a href="#">Masuk</a>
       </div>
   </div>

   <!-- JavaScript to handle showing address fields -->
   <script>
       document.getElementById('proceed-button').addEventListener('click', function() {
           const nameFilled = document.getElementById('name').value.trim() !== '';
           const emailFilled = document.getElementById('email').value.trim() !== '';
           const passwordFilled = document.getElementById('password').value.trim() !== '';

           if (nameFilled && emailFilled && passwordFilled) {
               // Hide basic info and show address fields
               document.getElementById('basic-info').classList.add('hidden');
               document.getElementById('address-fields').classList.remove('hidden');
           } else {
               alert("Silakan isi semua informasi dasar sebelum melanjutkan.");
           }
       });

       // Show/hide register button based on address fields completion
       const addressInputs = document.querySelectorAll('#address-fields input');
       addressInputs.forEach(input => {
           input.addEventListener('input', function() {
               const allFilled = Array.from(addressInputs).every(input => input.value.trim() !== '');
               document.getElementById('register-button').disabled = !allFilled;
           });
       });
   </script>

</body>
</html>
