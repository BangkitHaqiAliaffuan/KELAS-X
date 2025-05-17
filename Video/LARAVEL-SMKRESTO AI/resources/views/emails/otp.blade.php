<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - SMK Resto</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: Arial, sans-serif;">
    <table role="presentation" width="100%" style="background-color: #f4f4f4; padding: 20px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" style="margin: auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #4F46E5 0%, #10B981 100%); padding: 40px 20px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px;">SMK Resto</h1>
                            <p style="color: #ffffff; margin: 10px 0 0; font-size: 16px;">Kode Verifikasi OTP</p>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="margin: 0 0 20px; font-size: 16px; color: #333333;">Halo {{ $pelanggan->pelanggan }},</p>
                            <p style="margin: 0 0 20px; font-size: 16px; color: #333333;">Terima kasih telah mendaftar di SMK Resto. Berikut adalah kode OTP Anda:</p>

                            <!-- OTP Box -->
                            <div style="background-color: #f8f9fa; border: 2px dashed #4F46E5; border-radius: 8px; padding: 20px; margin: 30px 0; text-align: center;">
                                <h2 style="margin: 0; color: #4F46E5; letter-spacing: 8px; font-size: 32px; font-weight: bold;">{{ $otp }}</h2>
                            </div>

                            <p style="margin: 0 0 10px; font-size: 16px; color: #333333;">Kode ini akan kadaluarsa dalam 5 menit.</p>
                            <p style="margin: 0 0 20px; font-size: 14px; color: #666666;">Jika Anda tidak merasa mendaftar di SMK Resto, abaikan email ini.</p>

                            <!-- Security Notice -->
                            <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                                <p style="margin: 0; font-size: 14px; color: #666666;">Demi keamanan:</p>
                                <ul style="margin: 10px 0; padding-left: 20px; color: #666666; font-size: 14px;">
                                    <li>Jangan bagikan kode OTP ini kepada siapapun</li>
                                    <li>Pastikan Anda berada di website resmi SMK Resto</li>
                                    <li>SMK Resto tidak pernah meminta kode OTP melalui telepon atau email</li>
                                </ul>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8f9fa; padding: 20px; text-align: center; border-top: 1px solid #eee;">
                            <p style="margin: 0; font-size: 14px; color: #666666;">&copy; 2025 SMK Resto. Semua hak dilindungi.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
