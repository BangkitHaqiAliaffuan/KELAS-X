<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Akun Game Store</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f7f7f7; color: #ffffff;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; margin: 0 auto; background-color: #121212; border-collapse: collapse;">
        <!-- Header -->
        <tr>
            <td align="center" style="padding: 30px 0; background-color: #0a0a0a; border-bottom: 3px solid #037BFC;">
                <h1 style="margin: 0; font-size: 28px; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; color: #ffffff; text-shadow: 0 0 10px rgba(3, 123, 252, 0.5);">EPIC GAME STORE</h1>
            </td>
        </tr>

        <!-- Content -->
        <tr>
            <td style="padding: 40px 30px; background-color: #121212;">
                <h2 style="color: #ffffff; margin-top: 0; margin-bottom: 20px; font-size: 22px; text-transform: uppercase; letter-spacing: 1px;">Verifikasi Akun Game Store</h2>

                <p style="color: #9d9d9d; margin-bottom: 15px; font-size: 16px;">Halo <span style="color: #ffffff; font-weight: bold;">{{ $user->username }}</span>,</p>

                <p style="color: #9d9d9d; margin-bottom: 25px; font-size: 16px;">Terima kasih telah mendaftar di Game Store. Untuk menyelesaikan proses pendaftaran, silakan masukkan kode OTP berikut:</p>

                <div style="background-color: #1e1e1e; border: 2px solid #037BFC; border-radius: 6px; padding: 20px; text-align: center; margin: 30px 0;">
                    <p style="margin: 0 0 10px 0; color: #9d9d9d; font-size: 14px; text-transform: uppercase; letter-spacing: 1px;">KODE VERIFIKASI ANDA</p>
                    <div style="font-size: 32px; font-weight: bold; letter-spacing: 8px; color: #ffffff; text-shadow: 0 0 10px rgba(3, 123, 252, 0.3);">{{ $otp }}</div>
                    <p style="margin: 10px 0 0 0; color: #9d9d9d; font-size: 12px;">Berlaku selama 10 menit</p>
                </div>

                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 30px 0;">
                    <tr>
                        <td align="center">
                            <div style="background-color: #037BFC; border-radius: 4px; display: inline-block;">
                                <a href="#" style="display: inline-block; padding: 15px 30px; font-size: 16px; color: #ffffff; text-decoration: none; font-weight: bold; text-transform: uppercase; letter-spacing: 1px;">Verifikasi Sekarang</a>
                            </div>
                        </td>
                    </tr>
                </table>

                <p style="color: #9d9d9d; margin-bottom: 15px; font-size: 14px; border-left: 3px solid #FF5757; padding-left: 15px; background-color: rgba(255, 87, 87, 0.1);">Kode OTP ini berlaku selama 10 menit. Jika Anda tidak merasa mendaftar di Game Store, abaikan email ini.</p>

                <p style="color: #9d9d9d; margin-top: 30px; margin-bottom: 0; font-size: 16px;">Salam,<br><span style="color: #ffffff; font-weight: bold;">Tim Game Store</span></p>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="padding: 20px; text-align: center; background-color: #0a0a0a; border-top: 1px solid #2a2a2a;">
                <p style="color: #9d9d9d; margin: 0; font-size: 14px;">© 2025 Epic Game Store. All rights reserved.</p>
                <p style="color: #9d9d9d; margin: 10px 0 0 0; font-size: 12px;">Jika Anda memiliki pertanyaan, silakan hubungi <a href="mailto:support@epicgamestore.com" style="color: #037BFC; text-decoration: none;">support@epicgamestore.com</a></p>
            </td>
        </tr>
    </table>
</body>
</html>
