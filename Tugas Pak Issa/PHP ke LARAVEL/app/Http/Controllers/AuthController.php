<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\OtpVerification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Menampilkan form login
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Menangani proses login
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cek apakah login menggunakan email atau username
        $loginType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Sesuaikan kredensial berdasarkan tipe login
        $authCredentials = [
            $loginType => $request->username,
            'password' => $request->password
        ];

        if (Auth::attempt($authCredentials)) {
            $request->session()->regenerate();

            // Set session untuk user
            $user = Auth::user();
            session(['user_id' => $user->id]);
            session(['user_email' => $user->email]);
            session(['last_activity' => time()]);

            // Jika remember me dicentang
            if ($request->filled('remember_me')) {
                Cookie::queue('user_email', $user->email, 30 * 24 * 60);
            }

            return redirect()->route('home');
        }

        // Jika autentikasi gagal
        return back()->withErrors([
            'username' => 'Kredensial yang diberikan tidak sesuai dengan data kami.',
        ])->withInput($request->except('password'));
    }

    /**
     * Menampilkan form register
     *
     * @return \Illuminate\View\View
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Menangani proses registrasi
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
{
    $request->validate([
        'username' => 'required|string|min:3|max:50|unique:users',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => [
            'required',
            'string',
            'min:8',
            'confirmed',
            Password::defaults()
        ],
    ], [
        'username.unique' => 'Username sudah digunakan.',
        'email.unique' => 'Email sudah terdaftar.',
        'password.confirmed' => 'Konfirmasi password tidak cocok.',
    ]);

    // Generate OTP (6 digit)
    $otp = rand(100000, 999999);
    $otp_expiry = now()->addMinutes(10); // OTP berlaku selama 10 menit

    // Buat user baru
    $user = User::create([
        'username' => $request->username,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'otp' => $otp,
        'otp_expiry' => $otp_expiry,
        'email_verified_at' => null,
        'is_active' => false // User tidak aktif sampai verifikasi email
    ]);

    // Kirim email OTP
    try {
        Mail::to($user->email)->send(new OtpVerification($user, $otp));

        // Simpan informasi user di session
        session(['temp_user_id' => $user->id]);

        return redirect()->route('verification.notice')->with('success', 'Registrasi berhasil! Silakan verifikasi email Anda dengan kode OTP yang telah dikirim.');
    } catch (\Exception $e) {
        // Hapus user jika gagal mengirim email
        $user->delete();
        return redirect()->back()->with('error', 'Gagal mengirim kode OTP. Silakan coba lagi.');
    }
}

// Buat route dan halaman untuk verifikasi OTP
public function showVerificationForm()
{
    if (!session()->has('temp_user_id')) {
        return redirect()->route('register');
    }

    return view('auth.verify-otp');
}

public function verifyOtp(Request $request)
{
    $request->validate([
        'otp' => 'required|numeric|digits:6'
    ]);

    $userId = session('temp_user_id');
    $user = User::find($userId);

    if (!$user) {
        return redirect()->route('register')->with('error', 'Sesi telah berakhir. Silakan daftar kembali.');
    }

    if ($user->otp != $request->otp) {
        return redirect()->back()->with('error', 'Kode OTP tidak valid.');
    }

    if (now() > $user->otp_expiry) {
        return redirect()->back()->with('error', 'Kode OTP telah kadaluarsa.');
    }

    // Verifikasi user
    $user->email_verified_at = now();
    $user->is_active = true;
    $user->otp = null;
    $user->otp_expiry = null;
    $user->save();

    // Login otomatis setelah verifikasi
    Auth::login($user);

    session(['user_id' => $user->id]);
    session(['user_email' => $user->email]);
    session(['last_activity' => time()]);
    session()->forget('temp_user_id');

    return redirect()->route('home')->with('success', 'Verifikasi email berhasil! Selamat datang di Game Store.');
}

// Fungsi untuk mengirim ulang OTP
public function resendOtp()
{
    $userId = session('temp_user_id');
    $user = User::find($userId);

    if (!$user) {
        return redirect()->route('register')->with('error', 'Sesi telah berakhir. Silakan daftar kembali.');
    }

    // Generate OTP baru
    $otp = rand(100000, 999999);
    $otp_expiry = now()->addMinutes(10);

    $user->otp = $otp;
    $user->otp_expiry = $otp_expiry;
    $user->save();

    try {
        Mail::to($user->email)->send(new OtpVerification($user, $otp));
        return redirect()->back()->with('success', 'Kode OTP baru telah dikirim ke email Anda.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal mengirim kode OTP. Silakan coba lagi.');
    }
}

    /**
     * Logout pengguna
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
