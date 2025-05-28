<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
}

