<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class MenuController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $menus = Menu::when($request->category, function ($query) use ($request) {
            return $query->where('category_id', $request->category);
        })->get();

        return view('menu', compact('categories', 'menus'));
    }
    public function showmenus(Request $request)
    {
        $query = Menu::with('category');

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Search by name
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $menus = $query->paginate(10);
        $categories = Category::all();

        return view('admin.menus', compact('menus', 'categories'));
    }


    /**
     * Show a specific menu item
     */
    public function show($id)
    {
        $menu = Menu::with('category')->findOrFail($id);

        return response()->json([
            'id' => $menu->id,
            'name' => $menu->name,
            'description' => $menu->description,
            'price' => $menu->price,
            'category' => $menu->category->name,
            'image' => asset($menu->image),
            'created_at' => $menu->created_at,
            'updated_at' => $menu->updated_at
        ]);
    }

    /**
     * Show create menu form
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.menus.create', compact('categories'));
    }

    /**
     * Store a new menu item
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048'
        ]);

        // Generate slug from name
        // $validated['slug'] = Str::slug($validated['name']);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('gambar', 'public');
            $validated['image'] = $imagePath;
        }

        $menu = Menu::create($validated);

        return redirect()->route('admin.menus.showmenus')
            ->with('success', 'Menu item created successfully.');
    }

    /**
     * Show edit menu form
     */
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $categories = Category::all();
        return response()->json([
            'id' => $menu->id,
            'name' => $menu->name,
            'category_id' => $menu->category_id,
            'description' => $menu->description,
            'price' => $menu->price,
            'image' => $menu->image
        ]);
        // return view('admin.menus.edit', compact('menu', 'categories'));
    }

    /**
     * Update a menu item
     */
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048'
        ]);

        // Update slug
        // $validated['slug'] = Str::slug($validated['name']);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($menu->image && file_exists(public_path('gambar/' . $menu->image))) {
                unlink(public_path('gambar/' . $menu->image));
            }

            // Generate nama file unik
            $imageName = 'gambar/'. time() . '.' . $request->file('image')->getClientOriginalExtension();

            // Pindahkan file ke public/gambar
            $request->file('image')->move(public_path('gambar'), $imageName);

            // Simpan nama file ke database
            $validated['image'] = $imageName;
        }


        $menu->update($validated);

        return redirect()->route('admin.menus.showmenus')
            ->with('success', 'Menu item updated successfully.');
    }

    /**
     * Delete a menu item
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        // Delete associated image
        if ($menu->image && Storage::disk('public')->exists($menu->image)) {
            Storage::disk('public')->delete($menu->image);
        }

        $menu->delete();

        return redirect()->route('admin.menus.showmenus');
    }
}
