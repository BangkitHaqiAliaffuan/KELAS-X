<?php
date_default_timezone_set('Asia/Jakarta');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Tambahkan variabel untuk menampilkan OTP dari database
$stored_otp = '';
$debug_info = '';

if(isset($_GET['email'])){
    $email = $_GET['email'];
    
    // Cek OTP yang tersimpan di database untuk email ini - TANPA filter expired untuk debugging
    $sql_check = "SELECT * FROM otp_verification WHERE email = '$email' AND is_verified = 0 ORDER BY created_at DESC LIMIT 1";
    $result_check = $db->runSQL($sql_check);
    
    if($result_check->num_rows > 0) {
        $row = $result_check->fetch_assoc();
        $stored_otp = $row['otp_code'];
        $expired_at = $row['expired_at'];
        $is_expired = (strtotime($expired_at) < time()) ? "Ya (sudah lewat)" : "Tidak";
        $current_time = date('Y-m-d H:i:s');
        
        $debug_info = "OTP untuk email $email: <strong>$stored_otp</strong><br>
                      Expired pada: $expired_at<br>
                      Waktu sekarang: $current_time<br>
                      Sudah kadaluarsa? $is_expired";
    } else {
        $debug_info = "Tidak ada OTP aktif yang ditemukan untuk email $email";
    }

    if(isset($_POST['verify'])){
        $otp_code = $_POST['otp_code'];

        // Tampilkan data yang dimasukkan dan data di database untuk debugging
        $debug_info .= "<br>OTP yang dimasukkan: <strong>$otp_code</strong>";

        // Cek validitas OTP - TANPA memeriksa waktu expired untuk debugging
        $sql = "SELECT * FROM otp_verification WHERE email = '$email' AND otp_code = '$otp_code' AND is_verified = 0";
        $result = $db->runSQL($sql);

        if($result->num_rows > 0){
            // Update status verifikasi
            $sql_update = "UPDATE otp_verification SET is_verified = 1 WHERE email = '$email'";
            $db->runSQL($sql_update);

            // Update status verifikasi pelanggan
            $sql_pelanggan = "UPDATE tablepelanggan SET is_verified = 1 WHERE email = '$email'";
            $db->runSQL($sql_pelanggan);

            header("location:?f=home&m=info");
        } else {
            $error_message = "Kode OTP tidak valid atau telah kadaluarsa";
            
            // Tambahkan informasi lebih detail untuk debugging
            $sql_debug = "SELECT * FROM otp_verification WHERE email = '$email' ORDER BY created_at DESC LIMIT 1";
            $result_debug = $db->runSQL($sql_debug);
            
            if($result_debug->num_rows > 0) {
                $row_debug = $result_debug->fetch_assoc();
                $debug_info .= "<br>Status: " . ($row_debug['is_verified'] == 1 ? "Sudah diverifikasi" : "Belum diverifikasi");
                
                $expired_time = strtotime($row_debug['expired_at']);
                $current_time = time();
                $time_diff = $expired_time - $current_time;
                
                $debug_info .= "<br>Kadaluarsa: ";
                if($time_diff < 0) {
                    $debug_info .= "Sudah kadaluarsa (lewat " . abs(round($time_diff/60)) . " menit)";
                } else {
                    $debug_info .= "Masih berlaku (tersisa " . round($time_diff/60) . " menit)";
                }
                
                $debug_info .= "<br>Expired pada: " . $row_debug['expired_at'];
                $debug_info .= "<br>Waktu server: " . date('Y-m-d H:i:s');
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - Restoran SMK</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #0ea5e9;
            --primary-dark: #0284c7;
            --primary-light: #e0f2fe;
            --secondary-color: #14b8a6;
            --accent-color: #8b5cf6;
            --dark-color: #1e293b;
            --light-color: #f8fafc;
            --gray-color: #e2e8f0;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin: 0;
        }

        .otp-container {
            width: 100%;
            max-width: 450px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            animation: fadeInUp 0.5s ease-out;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .otp-header {
            padding: 30px 30px 20px;
            text-align: center;
        }
        
        .otp-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #0ea5e9, #14b8a6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 36px;
            box-shadow: 0 10px 20px rgba(14, 165, 233, 0.2);
        }
        
        .otp-title {
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 15px;
        }
        
        .otp-description {
            color: #64748b;
            font-size: 15px;
            margin-bottom: 0;
            line-height: 1.6;
        }
        
        .email-highlight {
            font-weight: 600;
            color: #0ea5e9;
            word-break: break-all;
        }
        
        .otp-form {
            padding: 0 30px 30px;
        }
        
        .otp-input-group {
            margin: 25px 0;
        }
        
        .otp-input {
            width: 100%;
            padding: 15px;
            text-align: center;
            font-size: 24px;
            font-weight: 600;
            letter-spacing: 12px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #f8fafc;
            color: #1e293b;
            transition: all 0.3s ease;
        }
        
        .otp-input:focus {
            border-color: #0ea5e9;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.15);
            outline: none;
        }
        
        .timer {
            text-align: center;
            margin-bottom: 20px;
            color: #64748b;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
        
        .timer i {
            color: #f59e0b;
        }
        
        .timer-count {
            font-weight: 600;
            color: #1e293b;
        }
        
        .resend-link {
            text-align: center;
            margin-top: 15px;
        }
        
        .resend-link a {
            color: #0ea5e9;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: color 0.2s ease;
        }
        
        .resend-link a:hover {
            color: #0284c7;
            text-decoration: underline;
        }
        
        .btn-verify {
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
            gap: 8px;
        }
        
        .btn-verify:hover {
            background: linear-gradient(135deg, #0284c7, #0f766e);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
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
        
        .otp-digits {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin: 25px 0;
        }
        
        .digit-input {
            width: 50px;
            height: 60px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #f8fafc;
            font-size: 24px;
            font-weight: 600;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .digit-input:focus {
            border-color: #0ea5e9;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.15);
            outline: none;
        }
        
        @media (max-width: 480px) {
            .digit-input {
                width: 40px;
                height: 50px;
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="otp-container">
        <div class="otp-header">
            <div class="otp-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h3 class="otp-title">Verifikasi OTP</h3>
            <p class="otp-description">
                Masukkan kode OTP yang telah dikirim ke email 
                <span class="email-highlight"><?php echo isset($email) ? $email : ''; ?></span>
            </p>
        </div>
        
        <?php if(isset($error_message)): ?>
            <div class="alert alert-danger mx-4">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        
        <form method="post" class="otp-form">
            <div class="otp-input-group">
                <input type="text" id="otp_code" name="otp_code" required class="otp-input" 
                       placeholder="------" maxlength="6" autocomplete="off"
                       value="<?php echo isset($stored_otp) ? $stored_otp : ''; ?>">
            </div>
            
            <div class="timer">
                <i class="fas fa-clock"></i>
                <span>Kode berlaku selama: <span class="timer-count" id="countdown">05:00</span></span>
            </div>
            
            <button type="submit" name="verify" class="btn-verify">
                <i class="fas fa-check-circle"></i> Verifikasi
            </button>
            
            <div class="resend-link">
                Tidak menerima kode? <a href="#">Kirim ulang</a>
            </div>
        </form>
    </div>

    <script>
        // Auto focus to OTP input when page loads
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('otp_code').focus();
            
            // Countdown timer
            let timeLeft = 5 * 60; // 5 minutes in seconds
            const countdownEl = document.getElementById('countdown');
            
            const countdownTimer = setInterval(function() {
                const minutes = Math.floor(timeLeft / 60);
                let seconds = timeLeft % 60;
                seconds = seconds < 10 ? '0' + seconds : seconds;
                
                countdownEl.innerHTML = `${minutes}:${seconds}`;
                timeLeft--;
                
                if (timeLeft < 0) {
                    clearInterval(countdownTimer);
                    countdownEl.innerHTML = "Kadaluarsa";
                    countdownEl.style.color = "#ef4444";
                }
            }, 1000);
        });
    </script>
</body>
</html>