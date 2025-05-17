<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Swift_TransportException;
use Exception;

class OtpController extends Controller
{
    public function sendOtp(Request $request)
    {
        try {
            // Validasi email
            if (!$request->has('email')) {
                Log::warning('Percobaan pengiriman OTP tanpa email');
                return back()->with('error', 'Email harus diisi');
            }

            if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                Log::warning('Format email tidak valid: ' . $request->email);
                return back()->with('error', 'Format email tidak valid');
            }

            try {
                $pelanggan = Pelanggan::where('email', $request->email)->first();
            } catch (QueryException $e) {
                Log::error('Database error saat mencari pelanggan: ' . $e->getMessage());
                return back()->with('error', 'Terjadi kesalahan pada database. Silakan coba lagi.');
            }

            if (!$pelanggan) {
                Log::warning('Percobaan pengiriman OTP ke email tidak terdaftar: ' . $request->email);
                return back()->with('error', 'Email tidak ditemukan dalam sistem');
            }

            // Generate OTP
            try {
                $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            } catch (Exception $e) {
                Log::error('Gagal generate OTP: ' . $e->getMessage());
                return back()->with('error', 'Gagal membuat kode OTP. Silakan coba lagi.');
            }

            // Set waktu kadaluarsa OTP
            $otpExpired = Carbon::now()->addMinutes(5);

            // Simpan OTP ke database
            try {
                $updated = Pelanggan::where('idpelanggan', $pelanggan->idpelanggan)
                    ->update([
                        'otp' => $otp,
                        'otp_expired' => $otpExpired
                    ]);

                if (!$updated) {
                    throw new Exception('Gagal update data pelanggan');
                }
            } catch (QueryException $e) {
                Log::error('Database error saat update OTP: ' . $e->getMessage());
                return back()->with('error', 'Gagal menyimpan OTP ke database. Silakan coba lagi.');
            } catch (Exception $e) {
                Log::error('Error umum saat update OTP: ' . $e->getMessage());
                return back()->with('error', 'Terjadi kesalahan saat memproses OTP. Silakan coba lagi.');
            }

            // Kirim OTP melalui email
            try {
                // Di dalam method sendOtp, ganti bagian Mail::raw dengan:

                $emailContent = view('emails.otp', [
                    'otp' => $otp,
                    'pelanggan' => $pelanggan
                ])->render();

                Mail::html($emailContent, function($message) use ($pelanggan) {
                    $message->to($pelanggan->email)
                            ->subject('Kode Verifikasi OTP - SMK Resto');
                });
            } catch (\Symfony\Component\Mailer\Exception\TransportException $e) {
                Log::error('SMTP error saat kirim email: ' . $e->getMessage());
                return back()->with('error', 'Gagal mengirim email OTP. Silakan periksa konfigurasi email.');
            } catch (Exception $e) {
                Log::error('Error umum saat kirim email: ' . $e->getMessage());
                return back()->with('error', 'Gagal mengirim email OTP. Silakan coba lagi.');
            }

            Log::info('OTP berhasil dikirim ke: ' . $pelanggan->email);
            return back()->with('success', 'OTP telah dikirim ke email Anda');

        } catch (Exception $e) {
            Log::error('Error tidak terduga: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan yang tidak terduga. Silakan coba lagi.');
        }
    }

    public function verifyOtp(Request $request)
    {
        try {
            // Validasi input
            if (!$request->has('otp')) {
                Log::warning('Percobaan verifikasi tanpa kode OTP');
                return back()->with('error', 'Kode OTP harus diisi');
            }

            if (!preg_match('/^[0-9]{6}$/', $request->otp)) {
                Log::warning('Format OTP tidak valid: ' . $request->otp);
                return back()->with('error', 'Format kode OTP tidak valid');
            }

            $email = session('email_for_otp');
            if (!$email) {
                Log::warning('Percobaan verifikasi OTP tanpa email di session');
                return back()->with('error', 'Sesi verifikasi telah berakhir. Silakan daftar ulang.');
            }

            try {
                $pelanggan = Pelanggan::where('email', $email)->first();
            } catch (QueryException $e) {
                Log::error('Database error saat mencari pelanggan: ' . $e->getMessage());
                return back()->with('error', 'Terjadi kesalahan pada database. Silakan coba lagi.');
            }

            if (!$pelanggan) {
                Log::warning('Email tidak ditemukan saat verifikasi: ' . $email);
                return back()->with('error', 'Data pelanggan tidak ditemukan');
            }

            if ($pelanggan->otp !== $request->otp) {
                Log::warning('OTP tidak cocok untuk pelanggan ID: ' . $pelanggan->idpelanggan);
                return back()->with('error', 'Kode OTP tidak valid');
            }

            if (!$pelanggan->otp_expired) {
                Log::warning('Tanggal kadaluarsa OTP tidak ada untuk pelanggan ID: ' . $pelanggan->idpelanggan);
                return back()->with('error', 'Data OTP tidak valid. Silakan minta OTP baru.');
            }

            if (Carbon::now()->isAfter($pelanggan->otp_expired)) {
                Log::warning('OTP sudah kadaluarsa untuk pelanggan ID: ' . $pelanggan->idpelanggan);
                return back()->with('error', 'Kode OTP telah kadaluarsa. Silakan minta OTP baru.');
            }

            // Update status verifikasi
            try {
                $updated = Pelanggan::where('idpelanggan', $pelanggan->idpelanggan)
                    ->update([
                        'is_verified' => true,
                        'aktif' => 1,
                        'otp' => null,
                        'otp_expired' => null
                    ]);

                if (!$updated) {
                    throw new Exception('Gagal update status verifikasi');
                }
            } catch (QueryException $e) {
                Log::error('Database error saat update status verifikasi: ' . $e->getMessage());
                return back()->with('error', 'Gagal memperbarui status verifikasi. Silakan coba lagi.');
            }

            // Auto login setelah verifikasi berhasil
            $loginData = [
                'idpelanggan' => $pelanggan->idpelanggan,
                'email' => $pelanggan->email,
            ];

            // Set session login
            session(['idpelanggan' => $loginData]);

            // Hapus session email OTP
            session()->forget('email_for_otp');

            Log::info('Verifikasi OTP berhasil dan auto login untuk pelanggan ID: ' . $pelanggan->idpelanggan);
            return redirect('/')->with('success', 'Verifikasi berhasil. Anda telah login otomatis.');

        } catch (Exception $e) {
            Log::error('Error tidak terduga saat verifikasi: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan yang tidak terduga. Silakan coba lagi.');
        }
    }
}
