<?php

namespace App\Http\Controllers;

use App\Models\User;
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

        $user->api_token = Str::random(80);
        $user->save();

        return response()->json([
            'message' => 'Login berhasil',
            'user' => $user,
            'token' => $user->api_token
        ], 200);
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
