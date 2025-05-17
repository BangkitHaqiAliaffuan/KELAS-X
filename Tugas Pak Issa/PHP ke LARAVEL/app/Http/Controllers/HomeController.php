<?php
// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display the home page
     */
    public function index()
    {
        $bestGames = $this->getBestGames(4);

        $ownedGames = [];
        if (auth()->check()) {
            $ownedGames = $this->getOwnedGames(auth()->id());
        }

        return view('home', [
            'bestGames' => $bestGames,
            'ownedGames' => $ownedGames
        ]);
    }

    /**
     * Get owned games for a user
     *
     * @param int $userId The user ID
     * @return \Illuminate\Support\Collection
     */
    private function getOwnedGames($userId)
    {
        return DB::table('owned_games')
            ->join('products', 'owned_games.product_id', '=', 'products.id')
            ->where('owned_games.user_id', $userId)
            ->select('products.id', 'products.name', 'products.image')
            ->limit(5)
            ->get();
    }

    /**
     * Get best games based on price
     *
     * @param int $limit Number of games to return
     * @return \Illuminate\Support\Collection
     */
    private function getBestGames($limit = 4)
    {
        return DB::table('products')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.name as category_name')
            ->orderBy('products.price', 'desc')
            ->limit($limit)
            ->get();
    }
}
