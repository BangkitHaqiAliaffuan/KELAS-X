<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\OtpMail;
use App\Models\UserOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use App\Models\Alamat; // Tambahkan import model Alamat
use Symfony\Component\HttpFoundation\RateLimiter\RequestRateLimiterInterface;

class AuthController extends Controller
{
    public function register(Request $request)
{
    $data = $request->validate([
        'name' => 'required',
        'password' => 'required',
        'email' => 'required|email|unique:users',
        'alamat' => 'required',
    ], [
        'name.required' => 'Nama harus diisi',
        'password.required' => 'Password harus diisi',
        'email.required' => 'Email harus diisi',
        'email.unique' => 'Email sudah terdaftar',
        'alamat.required' => 'Alamat harus diisi',
    ]);

    // Membuat user baru
    $user = User::create([
        'name' => $data['name'],
        'password' => bcrypt($data['password']),
        'email' => $data['email'],
    ]);

    // Membuat alamat untuk user yang baru dibuat
    Alamat::create([
        'user_id' => $user->id,
        'alamat' => $data['alamat'],
    ]);

    // Generate OTP dan simpan
    $otp = rand(100000, 999999);
    UserOtp::create([
        'user_id' => $user->id,
        'otp_code' => $otp,
        'expired_at' => now()->addMinutes(5)
    ]);

    // Kirim OTP ke email
    Mail::to($user->email)->send(new OtpMail($user, $otp));

    event(new Registered($user));

    return redirect()->route('otp_verification', $user->id);
}

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        // Check if user exists and is not banned
        if (
            $user
            && $user->banned == 0 && Auth::attempt([
                'email' => $request->email,
                'password' =>
                    $request->password

            ])
        ) {
            $userid = Auth::id();
            $request->session()->put('user_id', $userid);
            return redirect('/');
        } else {
            // If login fails or user is banned, return to login with error
            return redirect('login')->with('error', 'Login gagal. Akun Anda mungkin diblokir atau kredensial salah.');
        }
    }

    public function showRegister()
    {
        return view('register');
    }

    public function showLogin()
    {
        return view('login');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user_id');
        Auth::logout();
        return redirect('/');
    }


}
