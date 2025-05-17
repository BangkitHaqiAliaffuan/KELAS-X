<div class="register">
    <h1>Register</h1>
    <form action="" method="post">
        <input type="email" name="email" required placeholder="Masukkan Alamat Email Anda">
        <input type="password" name="password" required placeholder="Masukkan Password">
        <input type="submit" name="register" value="register">
    </form>
</div>
<?php

if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // echo $email;
    // echo "<br>";
    // echo $password;

    $sql = "INSERT INTO customer (email, password) VALUES ('$email', '$password')";
    echo $sql;
    mysqli_query($koneksi, $sql);
    
    header("location:index.php?menu=login");

    echo $sql;
}



?>