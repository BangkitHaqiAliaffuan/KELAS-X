<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - SMK Resto</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            /* Color Palette - Bright Theme */
            --primary: #FF6B35;
            --primary-hover: #FF8C5A;
            --primary-light: #FFE0D3;
            --secondary: #2EC4B6;
            --secondary-hover: #38D9CA;
            --secondary-light: #D1F5F2;
            --accent: #FDCA40;
            --accent-hover: #FFD966;
            --accent-light: #FFF3D1;
            --success: #4CAF50;
            --info: #2196F3;
            --warning: #FF9800;
            --danger: #F44336;
            --light: #F8F9FA;
            --dark: #343A40;
            --white: #FFFFFF;

            /* Grays */
            --gray-100: #F8F9FA;
            --gray-200: #E9ECEF;
            --gray-300: #DEE2E6;
            --gray-400: #CED4DA;
            --gray-500: #ADB5BD;
            --gray-600: #6C757D;
            --gray-700: #495057;
            --gray-800: #343A40;
            --gray-900: #212529;

            /* Typography */
            --font-family: 'Poppins', sans-serif;

            /* Spacing */
            --spacing-1: 0.25rem;
            --spacing-2: 0.5rem;
            --spacing-3: 0.75rem;
            --spacing-4: 1rem;
            --spacing-5: 1.25rem;
            --spacing-6: 1.5rem;
            --spacing-8: 2rem;

            /* Borders */
            --border-radius: 0.375rem;
            --border-radius-lg: 0.5rem;
            --border-radius-full: 9999px;

            /* Shadows */
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);

            /* Transitions */
            --transition-normal: 0.3s;
        }

        body {
            font-family: var(--font-family);
            background-color: var(--gray-100);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .auth-card {
            max-width: 450px;
            width: 100%;
            padding: var(--spacing-8);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-lg);
            background-color: white;
            animation: slideInUp 0.5s ease-in-out;
        }

        @keyframes slideInUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .auth-header {
            text-align: center;
            margin-bottom: var(--spacing-6);
        }

        .auth-logo {
            margin-bottom: 1.5rem;
        }

        .auth-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: var(--spacing-2);
        }

        .auth-subtitle {
            color: var(--gray-600);
        }

        .otp-container {
            position: relative;
            margin: 2rem auto;
        }

        .otp-input-group {
            display: flex;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 1.5rem;
        }

        .otp-input {
            width: 50px;
            height: 60px;
            font-size: 1.5rem;
            font-weight: 600;
            text-align: center;
            border-radius: var(--border-radius);
            border: 2px solid var(--gray-300);
            background-color: var(--white);
            transition: all var(--transition-normal) ease;
        }

        .otp-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.25);
            outline: none;
        }

        .otp-input.filled {
            border-color: var(--primary);
            background-color: var(--primary-light);
        }

        .timer {
            margin: 1.5rem 0;
            color: var(--gray-600);
            text-align: center;
        }

        .timer-circle {
            position: relative;
            width: 80px;
            height: 80px;
            margin: 0 auto 1rem;
        }

        .timer-circle svg {
            width: 100%;
            height: 100%;
            transform: rotate(-90deg);
        }

        .timer-circle circle {
            fill: none;
            stroke-width: 8;
            stroke-linecap: round;
            stroke: var(--gray-200);
        }

        .timer-circle circle.progress {
            stroke: var(--primary);
            stroke-dasharray: 251.2;
            stroke-dashoffset: 0;
            transition: stroke-dashoffset 1s linear;
        }

        .timer-time {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
        }

        .btn {
            font-weight: 500;
            border-radius: var(--border-radius);
            transition: all var(--transition-normal) ease;
            padding: 0.75rem 1.5rem;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
            box-shadow: 0 4px 10px rgba(255, 107, 53, 0.3);
        }

        .btn-outline {
            background-color: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline:hover:not(:disabled) {
            background-color: var(--primary);
            color: white;
            box-shadow: 0 4px 10px rgba(255, 107, 53, 0.2);
        }

        .btn-outline:disabled {
            border-color: var(--gray-400);
            color: var(--gray-400);
            cursor: not-allowed;
        }

        .alert {
            border: none;
            border-radius: var(--border-radius);
        }

        .alert-danger {
            background-color: #FEECEB;
            color: var(--danger);
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo">
                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                    <i class="fas fa-shield-alt" style="font-size: 2.5rem;"></i>
                </div>
            </div>
            <h1 class="auth-title">Verifikasi OTP</h1>
            <p class="auth-subtitle">Masukkan kode 6 digit yang telah dikirim ke email Anda</p>
        </div>

        @if(session('error'))
            <div class="alert alert-danger d-flex align-items-center mb-4" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        <form action="{{ url('/otp/verify') }}" method="POST">
            @csrf
            <div class="otp-container">
                <div class="otp-input-group">
                    <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required autofocus>
                    <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                    <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                    <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                    <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                    <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                </div>
                <input type="hidden" name="otp" id="otpValue">
            </div>

            <div class="timer">
                <div class="timer-circle">
                    <svg viewBox="0 0 100 100">
                        <circle cx="50" cy="50" r="40"></circle>
                        <circle cx="50" cy="50" r="40" class="progress" id="timerProgress"></circle>
                    </svg>
                    <div class="timer-time" id="countdown">05:00</div>
                </div>
                <p class="mb-0">Kode akan kedaluwarsa dalam <span id="countdownText">5 menit</span></p>
            </div>

            <div class="d-grid gap-3 mb-4">
                <button type="submit" class="btn btn-primary py-3 rounded-pill shadow-sm fw-semibold">
                    Verifikasi <i class="fas fa-check-circle ms-2"></i>
                </button>

                <div class="text-center">
                    <p class="mb-2">Tidak menerima kode?</p>
                    <button type="button" id="resendBtn" class="btn btn-outline py-2 px-4" disabled>
                        <i class="fas fa-paper-plane me-2"></i> Kirim Ulang Kode
                    </button>
                </div>
            </div>
        </form>

        <div class="text-center mt-3">
            <a href="{{ url('/login') }}" class="text-decoration-none">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke halaman login
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // OTP input handling
            const otpInputs = document.querySelectorAll('.otp-input');
            const otpValue = document.getElementById('otpValue');

            // Focus on first input
            otpInputs[0].focus();

            // Handle input in OTP fields
            otpInputs.forEach((input, index) => {
                // Auto-focus next input
                input.addEventListener('input', function(e) {
                    // Only allow numbers
                    this.value = this.value.replace(/[^0-9]/g, '');

                    if (this.value.length === 1) {
                        this.classList.add('filled');
                        // Focus next input if available
                        if (index < otpInputs.length - 1) {
                            otpInputs[index + 1].focus();
                        }
                    } else {
                        this.classList.remove('filled');
                    }

                    // Update hidden input with complete OTP
                    updateOtpValue();
                });

                // Handle backspace
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && this.value === '' && index > 0) {
                        otpInputs[index - 1].focus();
                        otpInputs[index - 1].value = '';
                        otpInputs[index - 1].classList.remove('filled');
                        updateOtpValue();
                    }
                });

                // Handle paste
                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const pasteData = e.clipboardData.getData('text').trim();

                    // Check if pasted data is a 6-digit number
                    if (/^\d{6}$/.test(pasteData)) {
                        // Fill all inputs
                        otpInputs.forEach((input, i) => {
                            input.value = pasteData[i] || '';
                            if (input.value) {
                                input.classList.add('filled');
                            } else {
                                input.classList.remove('filled');
                            }
                        });
                        updateOtpValue();
                    }
                });
            });

            function updateOtpValue() {
                otpValue.value = Array.from(otpInputs).map(input => input.value).join('');
            }

            // Timer functionality
            const countdown = document.getElementById('countdown');
            const countdownText = document.getElementById('countdownText');
            const timerProgress = document.getElementById('timerProgress');
            const resendBtn = document.getElementById('resendBtn');

            let timeLeft = 5 * 60; // 5 minutes in seconds
            const totalTime = timeLeft;
            const circumference = 2 * Math.PI * 40; // 2πr where r=40

            timerProgress.style.strokeDasharray = circumference;

            const timer = setInterval(function() {
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;

                // Update countdown display
                countdown.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                countdownText.textContent = `${minutes} menit ${seconds} detik`;

                // Update progress circle
                const dashOffset = circumference * (1 - timeLeft / totalTime);
                timerProgress.style.strokeDashoffset = dashOffset;

                // Update progress color based on time left
                if (timeLeft < 60) { // Less than 1 minute
                    timerProgress.style.stroke = var(--danger);
                } else if (timeLeft < 120) { // Less than 2 minutes
                    timerProgress.style.stroke = var(--warning);
                }

                if (--timeLeft < 0) {
                    clearInterval(timer);
                    countdown.textContent = "00:00";
                    countdownText.textContent = "Kode telah kedaluwarsa";
                    resendBtn.disabled = false;
                }
            }, 1000);

            // Resend button
            resendBtn.addEventListener('click', function() {
                if (!this.disabled) {
                    // Reset OTP inputs
                    otpInputs.forEach(input => {
                        input.value = '';
                        input.classList.remove('filled');
                    });
                    updateOtpValue();

                    // Reset timer
                    timeLeft = totalTime;
                    timerProgress.style.stroke = var(--primary);
                    timerProgress.style.strokeDashoffset = 0;
                    this.disabled = true;

                    // Send AJAX request to resend OTP
                    fetch('{{ url("/otp/resend") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success message
                            alert('Kode OTP baru telah dikirim ke email Anda.');
                        } else {
                            // Show error message
                            alert('Gagal mengirim kode OTP. Silakan coba lagi.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    });
                }
            });
        });
    </script>
</body>
</html>
