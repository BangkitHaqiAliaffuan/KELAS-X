<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\OwnedGame;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user profile
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();

        // Get favorite games
        $favoriteGames = OwnedGame::where('user_id', $user->id)
            ->where('is_favorite', 1)
            ->join('products', 'owned_games.product_id', '=', 'products.id')
            ->select('owned_games.*', 'products.name', 'products.image')
            ->get();

        return view('profile', compact('user', 'favoriteGames'));
    }

    /**
     * Update the user profile
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'description' => 'nullable|string|max:1000',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120', // 5MB max
        ]);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = 'profile_' . $user->id . '_' . time() . '.' . $image->extension();

            // Define the full path for storage
            $path = public_path('uploads/profiles');

            // Create directory if it doesn't exist
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            // Delete old profile image if exists
            if ($user->profile_image && file_exists(public_path('uploads/profiles/' . $user->profile_image))) {
                unlink(public_path('uploads/profiles/' . $user->profile_image));
            }

            // Store new image directly in the uploads/profiles folder
            $image->move($path, $imageName);
            $user->profile_image = $imageName;
        }

        // Update user data
        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->description = $request->description;
        $user->save();

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully!');
    }
}
