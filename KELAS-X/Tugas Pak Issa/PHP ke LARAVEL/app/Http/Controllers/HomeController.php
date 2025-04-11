<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $bestGames = Product::with('category')
            ->orderBy('price', 'desc')
            ->limit(4)
            ->get();
        return view('home', compact('bestGames'));
    }
}
