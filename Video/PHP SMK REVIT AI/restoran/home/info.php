<div class="success-container">
    <div class="success-card">
        <div class="success-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <h2 class="success-title">Registrasi Berhasil!</h2>
        <p class="success-message">Akun Anda telah berhasil dibuat. Silakan login untuk mulai memesan makanan favorit Anda.</p>
        <div class="success-actions">
            <a class="btn btn-primary btn-login" href="?f=home&m=login">
                <i class="fas fa-sign-in-alt me-2"></i>Login Sekarang
            </a>
        </div>
        <div class="success-help">
            <p>Butuh bantuan? <a href="#">Hubungi kami</a></p>
        </div>
    </div>
</div>

<style>
    .success-container {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 80vh;
        padding: 20px;
    }
    
    .success-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        padding: 40px;
        text-align: center;
        max-width: 500px;
        width: 100%;
        animation: fadeInUp 0.5s ease-out, pulse 2s infinite;
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
    
    @keyframes pulse {
        0% {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }
        50% {
            box-shadow: 0 15px 40px rgba(14, 165, 233, 0.15);
        }
        100% {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }
    }
    
    .success-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #0ea5e9, #14b8a6);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        color: white;
        font-size: 50px;
        box-shadow: 0 10px 20px rgba(14, 165, 233, 0.3);
    }
    
    .success-title {
        font-size: 28px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 15px;
    }
    
    .success-message {
        color: #64748b;
        font-size: 16px;
        margin-bottom: 30px;
        line-height: 1.6;
    }
    
    .success-actions {
        margin-bottom: 25px;
    }
    
    .btn-login {
        padding: 14px 30px;
        background: linear-gradient(135deg, #0ea5e9, #14b8a6);
        border: none;
        border-radius: 8px;
        font-weight: 500;
        font-size: 16px;
        transition: all 0.3s ease;
    }
    
    .btn-login:hover {
        background: linear-gradient(135deg, #0284c7, #0f766e);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .success-help {
        margin-top: 20px;
        color: #94a3b8;
        font-size: 14px;
    }
    
    .success-help a {
        color: #0ea5e9;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s ease;
    }
    
    .success-help a:hover {
        color: #0284c7;
        text-decoration: underline;
    }
</style>