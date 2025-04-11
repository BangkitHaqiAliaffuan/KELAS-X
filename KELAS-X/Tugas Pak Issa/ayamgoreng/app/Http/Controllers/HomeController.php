<?php
namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all(); // Ambil semua kategori
        // Ambil 3 menu unggulan (misalnya, ditandai dengan kolom 'featured' atau acak)
        $featuredMenus = Menu::inRandomOrder()->take(3)->get();
        return view('home', compact('featuredMenus', 'categories'));
    }
}
