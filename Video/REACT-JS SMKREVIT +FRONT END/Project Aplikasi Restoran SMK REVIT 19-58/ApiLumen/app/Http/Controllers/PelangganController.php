<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::all();
        return response()->json($pelanggans);
    }

    public function update(Request $request, string $id)
    {
        $validator = validator($request->all(), [
            'pelanggan' => 'required|string|max:100',
            'alamat' => 'required|string',
            'telp' => 'required|string|max:20',
            'email' => 'required|email|unique:pelanggans,email,'.$id,
            'password' => 'nullable|min:4'
        ]);

        try {
            $pelanggan = Pelanggan::findOrFail($id);

            $updateData = [
                'pelanggan' => $request->pelanggan,
                'alamat' => $request->alamat,
                'telp' => $request->telp,
                'email' => $request->email
            ];

            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            $pelanggan->update($updateData);

            return response()->json([
                'status' => 'success',
                'message' => 'Data pelanggan berhasil diperbarui',
                'data' => $pelanggan
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data pelanggan tidak ditemukan atau gagal diperbarui',
                'error' => $e->getMessage()
            ], 404);
        }
    }
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'pelanggan' => 'required|string|max:100',
            'alamat' => 'required|string',
            'telp' => 'required|string|max:20',
            'email' => 'required|email|unique:pelanggans,email',
            'password' => 'required|min:4'
        ]);

        try {
            $pelanggan = Pelanggan::create([
                'pelanggan' => $request->pelanggan,
                'alamat' => $request->alamat,
                'telp' => $request->telp,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'aktif' => 1,
                'is_verified' => 0
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Data pelanggan berhasil ditambahkan',
                'data' => $pelanggan
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menambahkan data pelanggan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $pelanggan = Pelanggan::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $pelanggan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data pelanggan tidak ditemukan',
            ], 404);
        }
    }

    public function destroy(string $id)
    {
        try {
            $pelanggan = Pelanggan::findOrFail($id);
            $pelanggan->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Data pelanggan berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data pelanggan tidak ditemukan',
            ], 404);
        }
    }

    public function login(Request $request)
    {
        $validator = validator($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $pelanggan = Pelanggan::where('email', $request->email)->first();

            if (!$pelanggan || !Hash::check($request->password, $pelanggan->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email atau password salah'
                ], 401);
            }

            if (!$pelanggan->aktif) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Akun anda tidak aktif'
                ], 401);
            }

            $token = bin2hex(random_bytes(20));
            $pelanggan->api_token = $token;
            $pelanggan->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Login berhasil',
                'data' => [
                    'idpelanggan' => $pelanggan->idpelanggan,
                    'pelanggan' => $pelanggan->pelanggan,
                    'email' => $pelanggan->email,
                    'alamat' => $pelanggan->alamat,
                    'telp' => $pelanggan->telp,
                    'api_token' => $token
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal melakukan login',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function register(Request $request)
    {
        $validator = validator($request->all(), [
            'pelanggan' => 'required|string|max:100',
            'alamat' => 'required|string',
            'telp' => 'required|string|max:20',
            'email' => 'required|email|unique:pelanggans,email',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $token = bin2hex(random_bytes(40));

            $pelanggan = Pelanggan::create([
                'pelanggan' => $request->pelanggan,
                'alamat' => $request->alamat,
                'telp' => $request->telp,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'aktif' => 1,
                'is_verified' => 0,
                'api_token' => $token
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Registrasi berhasil',
                'data' => [
                    'pelanggan' => $pelanggan->pelanggan,
                    'email' => $pelanggan->email,
                    'alamat' => $pelanggan->alamat,
                    'telp' => $pelanggan->telp,
                    'api_token' => $token
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal melakukan registrasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $pelanggan = Pelanggan::where('api_token', $request->header('Authorization'))->first();

            if (!$pelanggan) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Pelanggan tidak ditemukan'
                ], 404);
            }

            $pelanggan->api_token = null;
            $pelanggan->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Logout berhasil'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal melakukan logout',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

