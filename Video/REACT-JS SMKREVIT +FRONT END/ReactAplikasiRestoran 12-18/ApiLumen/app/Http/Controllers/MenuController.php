<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return response()->json($menus);
    }

    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'menu' => 'required|string|max:100',
            'idkategori' => 'required|integer',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'harga' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $gambar = $request->file('gambar');
            $namaGambar = Str::random(32) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('uploads/menu'), $namaGambar);

            $menu = Menu::create([
                'menu' => $request->menu,
                'idkategori' => $request->idkategori,
                'gambar' => 'uploads/menu/' . $namaGambar,
                'harga' => $request->harga
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Menu berhasil ditambahkan',
                'data' => $menu
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menambahkan menu',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        $validator = validator($request->all(), [
            'menu' => 'required|string|max:100',
            'idkategori' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'harga' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $menu = Menu::findOrFail($id);
            $updateData = [
                'menu' => $request->menu,
                'idkategori' => $request->idkategori,
                'harga' => $request->harga
            ];

            if ($request->hasFile('gambar')) {
                // Hapus gambar lama
                if ($menu->gambar && file_exists(public_path($menu->gambar))) {
                    unlink(public_path($menu->gambar));
                }

                $gambar = $request->file('gambar');
                $namaGambar = Str::random(32) . '.' . $gambar->getClientOriginalExtension();
                $gambar->move(public_path('uploads/menu'), $namaGambar);
                $updateData['gambar'] = 'uploads/menu/' . $namaGambar;
            }

            $menu->update($updateData);

            return response()->json([
                'status' => 'success',
                'message' => 'Menu berhasil diperbarui',
                'data' => $menu
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu tidak ditemukan atau gagal diperbarui',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function show(string $id)
    {
        try {
            $menu = Menu::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $menu
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu tidak ditemukan',
            ], 404);
        }
    }

    public function destroy(string $id)
    {
        try {
            $menu = Menu::findOrFail($id);

            // Hapus file gambar jika ada
            if ($menu->gambar && file_exists(public_path($menu->gambar))) {
                unlink(public_path($menu->gambar));
            }

            $menu->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Menu berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu tidak ditemukan',
            ], 404);
        }
    }
}
