<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OwnedGame;
use Illuminate\Support\Facades\Auth;

class LibraryController extends Controller
{
    // Middleware untuk memastikan pengguna sudah login

    // Menampilkan daftar game di perpustakaan pengguna
    // app/Http/Controllers/LibraryController.php
    public function index(Request $request)
    {
        $user = auth()->user();
        $games = OwnedGame::where('user_id', $user->id)
            ->with('product') // Memuat relasi product
            ->get();

        return view('library.index', compact('games'));
    }
    // Mengubah status favorit game
    public function toggleFavorite(Request $request)
    {
        $user = Auth::user();
        $gameId = $request->input('game_id');

        // Temukan game yang dimiliki pengguna
        $ownedGame = OwnedGame::where('user_id', $user->id)
            ->where('product_id', $gameId)
            ->first();

        if ($ownedGame) {
            // Toggle status favorit
            $ownedGame->is_favorite = !$ownedGame->is_favorite;
            $ownedGame->save();
        }

        // Redirect kembali ke halaman sebelumnya
        return redirect()->back();
    }
}
