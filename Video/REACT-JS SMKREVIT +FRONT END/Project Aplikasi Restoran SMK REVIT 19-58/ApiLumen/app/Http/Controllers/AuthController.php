<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json([
            'message' => 'Data user berhasil diambil',
            'users' => $users
        ], 200);
    }

    public function register(Request $request)
    {
        $request->validate([
            'user' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'level' => 'required|string|in:admin,kasir,koki'
        ]);

        $user = User::create([
            'user' => $request->name,
            'relasi' => $request->relasi,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'level' => $request->level,
            'api_token' => Str::random(80)
        ]);

        return response()->json([
            'message' => 'Registrasi berhasil',
            'user' => $user,
            'token' => $user->api_token
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || $request->password !== $user->password) {
            return response()->json([
                'message' => 'Email atau password salah'
            ], 401);
        }

        // Verify that the user is not a customer
        if ($user->level === 'customer') {
            return response()->json([
                'message' => 'Akses ditolak. Silakan gunakan login customer.'
            ], 403);
        }

        $user->api_token = Str::random(80);
        $user->save();

        return response()->json([
            'message' => 'Login berhasil',
            'user' => $user,
            'token' => $user->api_token
        ], 200);
    }

    public function customerLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $customer = Pelanggan::where('email', $request->email)->first();

        if (!$customer || !Hash::check($request->password, $customer->password)) {
            return response()->json([
                'message' => 'Email atau password salah'
            ], 401);
        }

        $customer->api_token = Str::random(80);
        $customer->save();

        return response()->json([
            'message' => 'Login berhasil',
            'user' => $customer,
            'token' => $customer->api_token
        ], 200);
    }

    public function customerRegister(Request $request)
    {
        $request->validate([
            'pelanggan' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pelanggans,email',
            'password' => 'required|string|min:6',
            'alamat' => 'required|string',
            'telp' => 'required|string'
        ]);

        $customer = Pelanggan::create([
            'pelanggan' => $request->pelanggan,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'alamat' => $request->alamat,
            'telp' => $request->telp,
            'api_token' => Str::random(80)
        ]);

        return response()->json([
            'message' => 'Registrasi berhasil',
            'user' => $customer,
            'token' => $customer->api_token
        ], 201);
    }

    public function updateStatus(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        $user->status = $user->status === 1 ? 0 : 1;
        $user->save();

        return response()->json([
            'message' => 'Status user berhasil diperbarui',
            'user' => $user
        ], 200);
    }

    public function logout(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        $user->api_token = null;
        $user->save();

        return response()->json([
            'message' => 'Logout berhasil'
        ], 200);
    }
}
