<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        try {
            $data = DB::table('menus')
                ->join('kategoris', 'kategoris.idkategori', '=', 'menus.idkategori')
                ->select(
                    'menus.idmenu',
                    'menus.menu',
                    'menus.gambar',
                    'menus.harga',
                    'menus.created_at',
                    'menus.updated_at',
                    'kategoris.idkategori',
                    'kategoris.kategori'
                )
                ->orderBy('menus.created_at', 'desc')
                ->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Data menu berhasil diambil',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data menu',
                'error' => $e->getMessage()
            ], 500);
        }
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

    public function getMenuWithKategori()
    {
        $data = DB::table('menus')
            ->join('kategoris', 'kategoris.idkategori', '=', 'menus.idkategori')
            ->select('menus.*', 'kategoris.kategori')
            ->orderBy('menus.menu', 'desc')
            ->get();
        return response()->json($data);
    }

    public function getMenusWithCategories()
    {
        try {
            $menus = DB::table('menus')
                ->join('kategoris', 'kategoris.idkategori', '=', 'menus.idkategori')
                ->select(
                    'menus.idmenu',
                    'menus.menu',
                    'menus.gambar',
                    'menus.harga',
                    'menus.created_at',
                    'menus.updated_at',
                    'kategoris.idkategori',
                    'kategoris.kategori',
                    'kategoris.keterangan'
                )
                ->orderBy('kategoris.kategori', 'asc')
                ->get();

            $categories = DB::table('kategoris')
                ->select('kategoris.idkategori', 'kategoris.kategori', 'kategoris.keterangan', DB::raw('COUNT(menus.idmenu) as menu_count'))
                ->leftJoin('menus', 'kategoris.idkategori', '=', 'menus.idkategori')
                ->groupBy('kategoris.idkategori', 'kategoris.kategori', 'kategoris.keterangan')
                ->orderBy('kategoris.kategori', 'asc')
                ->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Data retrieved successfully',
                'data' => [
                    'categories' => $categories,
                    'menus' => $menus
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
