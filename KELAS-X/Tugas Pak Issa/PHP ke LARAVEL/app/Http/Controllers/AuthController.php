<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
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

        // Buat user baru
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Login otomatis setelah registrasi
        Auth::login($user);

        session(['user_id' => $user->id]);
        session(['user_email' => $user->email]);
        session(['last_activity' => time()]);

        return redirect()->route('home')->with('success', 'Registrasi berhasil! Selamat datang di Game Store.');
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
