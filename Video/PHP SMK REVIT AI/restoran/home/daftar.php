<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
    if(isset($_POST['simpan'])){
        $pelanggan = $_POST['pelanggan'];
        $alamat = $_POST['alamat'];
        $telp = $_POST['telp'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $konfirmasi = $_POST['konfirmasi'];
    
        if($password === $konfirmasi){
            // Cek apakah email sudah terdaftar
            $sql_cek = "SELECT * FROM tablepelanggan WHERE email = '$email'";
            $result_cek = $db->runSQL($sql_cek);
            if($result_cek->num_rows > 0){
                $error_message = "Email sudah terdaftar. Silakan gunakan email lain.";
            } else {
                // 1. Simpan data pelanggan terlebih dahulu
                $sql = "INSERT INTO tablepelanggan (pelanggan, alamat, telp, email, password, aktif, is_verified) 
                        VALUES ('$pelanggan', '$alamat', '$telp', '$email', '$password', 1, 0)";
                $db->runSQL($sql);
                
                // 2. Dapatkan ID pelanggan yang baru saja dibuat
                $idpelanggan = $db->getLastInsertId();
                
                // 3. Generate OTP
                $otp_code = rand(100000, 999999);
                $current_time = date('Y-m-d H:i:s');
                $expired_at = date('Y-m-d H:i:s', strtotime('+5 minutes'));
                
                // 4. Simpan OTP ke database dengan idpelanggan
                $sql_otp = "INSERT INTO otp_verification (idpelanggan, email, otp_code, created_at, expired_at, is_verified) 
                            VALUES ($idpelanggan, '$email', '$otp_code', '$current_time', '$expired_at', 0)";
                $db->runSQL($sql_otp);
                
                // 4. Kirim email OTP dengan template HTML
                $to = $email;
                $subject = 'Kode Verifikasi Restoran SMK';
                // HTML Email Template
            $message = '
            <!DOCTYPE html>
            <html lang="id">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Kode Verifikasi Restoran SMK</title>
                <style>
                    @import url(\'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap\');
                    
                    body {
                        font-family: \'Poppins\', Arial, sans-serif;
                        margin: 0;
                        padding: 0;
                        background-color: #f8fafc;
                        color: #1e293b;
                        line-height: 1.6;
                    }
                    
                    .email-container {
                        max-width: 600px;
                        margin: 20px auto;
                        background-color: #ffffff;
                        border-radius: 16px;
                        overflow: hidden;
                        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
                    }
                    
                    .email-header {
                        background: linear-gradient(135deg, #0ea5e9, #14b8a6);
                        color: white;
                        padding: 30px 20px;
                        text-align: center;
                    }
                    
                    .email-header h1 {
                        margin: 0;
                        font-size: 28px;
                        font-weight: 700;
                        letter-spacing: -0.5px;
                    }
                    
                    .email-header .logo {
                        font-size: 36px;
                        margin-bottom: 10px;
                    }
                    
                    .email-body {
                        padding: 40px 30px;
                        text-align: center;
                    }
                    
                    .greeting {
                        font-size: 22px;
                        font-weight: 600;
                        margin-bottom: 20px;
                        color: var(--dark-color);
                    }
                    
                    .message {
                        font-size: 16px;
                        margin-bottom: 30px;
                        color: #64748b;
                        line-height: 1.7;
                    }
                    
                    .otp-container {
                        background-color: #f1f5f9;
                        border-radius: 12px;
                        padding: 25px 20px;
                        margin: 0 auto 35px;
                        max-width: 320px;
                        border: 1px dashed #cbd5e1;
                        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
                    }
                    
                    .otp-code {
                        font-size: 36px;
                        font-weight: 700;
                        letter-spacing: 8px;
                        color: #0ea5e9;
                        margin: 10px 0;
                        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
                    }
                    
                    .expiry {
                        font-size: 14px;
                        color: #94a3b8;
                        margin-top: 15px;
                    }
                    
                    .note {
                        font-size: 14px;
                        color: #94a3b8;
                        margin-top: 35px;
                        padding-top: 25px;
                        border-top: 1px solid #e2e8f0;
                    }
                    
                    .email-footer {
                        background-color: #1e293b;
                        color: #e2e8f0;
                        text-align: center;
                        padding: 25px 20px;
                        font-size: 14px;
                    }
                </style>
            </head>
            <body>
                <div class="email-container">
                    <div class="email-header">
                        <div class="logo">🍽️</div>
                        <h1>Restoran SMK</h1>
                    </div>
                    <div class="email-body">
                        <div class="greeting">Halo, ' . $pelanggan . '!</div>
                        <div class="message">
                            Terima kasih telah mendaftar di Restoran SMK. Untuk menyelesaikan pendaftaran, silakan masukkan kode verifikasi berikut pada halaman verifikasi.
                        </div>
                        <div class="otp-container">
                            <div class="otp-code">' . $otp_code . '</div>
                            <div class="expiry">Kode berlaku selama 5 menit</div>
                        </div>
                        <div>
                            Jika Anda tidak merasa mendaftar di Restoran SMK, silakan abaikan email ini.
                        </div>
                        <div class="note">
                            Email ini dikirim secara otomatis, mohon tidak membalas email ini.
                        </div>
                    </div>
                    <div class="email-footer">
                        &copy; ' . date('Y') . ' Restoran SMK. Semua hak dilindungi.
                    </div>
                </div>
            </body>
            </html>
            ';
            
            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'xuanxingluh@gmail.com';
                $mail->Password = 'xudjfjhbbvuyadhh';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

                //Recipients
                $mail->setFrom('xuanxingluh@gmail.com', 'Restoran SMK');
                $mail->addAddress($to);

                //Content
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = $message;
                $mail->AltBody = 'Kode verifikasi Anda adalah: ' . $otp_code . '. Kode berlaku selama 5 menit.';

                $mail->send();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            
            // 5. Redirect ke halaman verifikasi
            header("location:?f=home&m=verify&email=$email");
        } 
    }
    else {
            echo "<div class='alert alert-danger mb-4'>
                    <i class='fas fa-exclamation-circle me-2'></i>
                    Password tidak sama. Silakan periksa kembali.
                  </div>";
        }
    }
?>

<div class="register-container">
    <div class="register-card">
        <div class="register-header">
            <div class="register-logo">
                <i class="fas fa-utensils"></i>
            </div>
            <h3 class="register-title">Daftar Akun Baru</h3>
            <p class="register-subtitle">Bergabunglah dengan Restoran SMK untuk menikmati pengalaman kuliner terbaik</p>
        </div>
        
        <?php if(isset($error_message)): ?>
            <div class="alert alert-danger mb-4">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        
        <form action="" method="post" class="register-form">
            <div class="form-row">
                <div class="form-group">
                    <label for="pelanggan">
                        <i class="fas fa-user form-icon"></i>
                        <span>Nama Lengkap</span>
                    </label>
                    <input type="text" id="pelanggan" name="pelanggan" required 
                           placeholder="Masukkan nama lengkap Anda" class="form-control">
                </div>
                <div class="form-group">
                    <label for="telp">
                        <i class="fas fa-phone form-icon"></i>
                        <span>Nomor Telepon</span>
                    </label>
                    <input type="text" id="telp" name="telp" required 
                           placeholder="Masukkan nomor telepon aktif" class="form-control">
                </div>
            </div>
            
            <div class="form-group">
                <label for="alamat">
                    <i class="fas fa-map-marker-alt form-icon"></i>
                    <span>Alamat Lengkap</span>
                </label>
                <input type="text" id="alamat" name="alamat" required 
                       placeholder="Masukkan alamat lengkap Anda" class="form-control">
            </div>
            
            <div class="form-group">
                <label for="email">
                    <i class="fas fa-envelope form-icon"></i>
                    <span>Email</span>
                </label>
                <input type="email" id="email" name="email" required 
                       placeholder="Masukkan email aktif Anda" class="form-control">
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock form-icon"></i>
                        <span>Password</span>
                    </label>
                    <div class="password-input">
                        <input type="password" id="password" name="password" required 
                               placeholder="Buat password Anda" class="form-control">
                        <button type="button" class="password-toggle" onclick="togglePassword('password')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="konfirmasi">
                        <i class="fas fa-check-circle form-icon"></i>
                        <span>Konfirmasi Password</span>
                    </label>
                    <div class="password-input">
                        <input type="password" id="konfirmasi" name="konfirmasi" required 
                               placeholder="Konfirmasi password Anda" class="form-control">
                        <button type="button" class="password-toggle" onclick="togglePassword('konfirmasi')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="form-agreement">
                <label class="checkbox-container">
                    <input type="checkbox" required>
                    <span class="checkmark"></span>
                    <span class="agreement-text">
                        Saya menyetujui <a href="#">Syarat & Ketentuan</a> dan <a href="#">Kebijakan Privasi</a>
                    </span>
                </label>
            </div>
            
            <button type="submit" class="btn-register" name="simpan" value="simpan">
                <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
            </button>
            
            <div class="login-link">
                Sudah punya akun? <a href="?f=home&m=login">Masuk sekarang</a>
            </div>
        </form>
    </div>
</div>

<style>
    .register-container {
        max-width: 800px;
        margin: 40px auto;
        animation: fadeIn 0.5s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    .register-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        padding: 40px;
        overflow: hidden;
        position: relative;
    }
    
    .register-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 6px;
        background: linear-gradient(135deg, #0ea5e9, #14b8a6);
    }
    
    .register-header {
        text-align: center;
        margin-bottom: 30px;
    }
    
    .register-logo {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #0ea5e9, #14b8a6);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        color: white;
        font-size: 30px;
        box-shadow: 0 10px 20px rgba(14, 165, 233, 0.2);
    }
    
    .register-title {
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 10px;
    }
    
    .register-subtitle {
        color: #64748b;
        font-size: 15px;
        max-width: 500px;
        margin: 0 auto;
    }
    
    .register-form {
        margin-top: 30px;
    }
    
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    
    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
            gap: 15px;
        }
        
        .register-card {
            padding: 30px 20px;
        }
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
        font-weight: 500;
        color: #1e293b;
    }
    
    .form-icon {
        color: #0ea5e9;
        margin-right: 8px;
        width: 16px;
    }
    
    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-family: 'Poppins', sans-serif;
        font-size: 15px;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #0ea5e9;
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.15);
        outline: none;
    }
    
    .form-control::placeholder {
        color: #94a3b8;
    }
    
    .password-input {
        position: relative;
    }
    
    .password-toggle {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        padding: 0;
        font-size: 16px;
        transition: color 0.3s ease;
    }
    
    .password-toggle:hover {
        color: #0ea5e9;
    }
    
    .form-agreement {
        margin: 25px 0;
    }
    
    .checkbox-container {
        display: flex;
        align-items: flex-start;
        position: relative;
        padding-left: 30px;
        cursor: pointer;
        user-select: none;
    }
    
    .checkbox-container input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }
    
    .checkmark {
        position: absolute;
        top: 2px;
        left: 0;
        height: 20px;
        width: 20px;
        background-color: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 4px;
        transition: all 0.2s ease;
    }
    
    .checkbox-container:hover input ~ .checkmark {
        background-color: #e0f2fe;
    }
    
    .checkbox-container input:checked ~ .checkmark {
        background-color: #0ea5e9;
        border-color: #0ea5e9;
    }
    
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }
    
    .checkbox-container input:checked ~ .checkmark:after {
        display: block;
    }
    
    .checkbox-container .checkmark:after {
        left: 7px;
        top: 3px;
        width: 6px;
        height: 10px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }
    
    .agreement-text {
        font-size: 14px;
        color: #64748b;
        line-height: 1.5;
    }
    
    .agreement-text a {
        color: #0ea5e9;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s ease;
    }
    
    .agreement-text a:hover {
        color: #0284c7;
        text-decoration: underline;
    }
    
    .btn-register {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #0ea5e9, #14b8a6);
        color: white;
        border: none;
        border-radius: 8px;
        font-family: 'Poppins', sans-serif;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-register:hover {
        background: linear-gradient(135deg, #0284c7, #0f766e);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .login-link {
        text-align: center;
        margin-top: 25px;
        font-size: 15px;
        color: #64748b;
    }
    
    .login-link a {
        color: #0ea5e9;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s ease;
    }
    
    .login-link a:hover {
        color: #0284c7;
        text-decoration: underline;
    }
    
    .alert {
        padding: 15px;
        border-radius: 8px;
        display: flex;
        align-items: center;
    }
    
    .alert-danger {
        background-color: #fee2e2;
        color: #b91c1c;
    }
    
    .alert i {
        margin-right: 10px;
        font-size: 18px;
    }
</style>

<script>
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const icon = event.currentTarget.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>