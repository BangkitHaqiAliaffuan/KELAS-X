<?php
namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter filter dari query string, default ke 'all'
        $filter = $request->query('filter', 'all');

        // Bangun query Eloquent untuk produk
        $products = Product::with('category')
            ->when($filter == 'new', function ($query) {
                return $query->where('release_status', 'New Release');
            })
            ->when($filter == 'coming', function ($query) {
                return $query->where('release_status', 'Coming Soon');
            })
            ->when($filter == 'free', function ($query) {
                return $query->where('price', 0);
            })
            ->paginate(8) // Paginasi dengan 8 item per halaman
            ->appends(['filter' => $filter]); // Pertahankan parameter filter di link paginasi

        // Kembalikan view dengan data produk dan filter
        return view('products', [
            'products' => $products,
            'filter' => $filter
        ]);
    }
    public function show($id)
    {
        $product = Product::with('category')
            ->findOrFail($id);

        // Get product images
        $images = ProductImage::where('product_id', $id)
            ->limit(3)
            ->pluck('image_url')
            ->toArray();

        // Get review statistics
        $stats = $this->getReviewStats($id);

        // Get reviews
        $reviews = $this->getReviews($id);

        // Check if user can review
        $canReview = false;
        if (Auth::check()) {
            // Check if user has purchased the product
            // This would depend on your purchase tracking system
            // For example, if you store purchased products in a purchases table:
            $canReview = DB::table('owned_games')
                ->where('user_id', Auth::id())
                ->where('product_id', $id)
                ->exists();
        }

        return view('products-detail', compact('product', 'images', 'stats', 'reviews', 'canReview'));
    }

    protected function getReviewStats($productId)
    {
        $stats = Review::where('product_id', $productId)
            ->selectRaw('COUNT(*) as total, AVG(rating) as average')
            ->first();

        return $stats;
    }

    protected function getReviews($productId)
    {
        $reviews = Review::where('reviews.product_id', $productId)
            ->join('users', 'reviews.user_id', '=', 'users.id')
            ->select('reviews.*', 'users.username')
            ->orderBy('reviews.created_at', 'desc')
            ->get();

        return $reviews;
    }

    public function submitReview(Request $request, $productId)
    {
        // Validate the request
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'required|string'
        ]);

        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('products.show', $productId)
                ->with('error', 'You must be logged in to submit a review.');
        }

        // Check if user has purchased the product
        $hasPurchased = DB::table('purchases')
            ->where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->exists();

        if (!$hasPurchased) {
            return redirect()->route('products.show', $productId)
                ->with('error', 'You must purchase this product before leaving a review.');
        }

        // Check if user already reviewed this product
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($existingReview) {
            return redirect()->route('products.show', $productId)
                ->with('error', "You've already reviewed this product.");
        }

        // Create new review
        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
            'rating' => $request->rating,
            'review_text' => $request->review_text,
            'created_at' => now(),
        ]);

        return redirect()->route('products.show', $productId)
            ->with('success', 'Your review has been submitted successfully.');
    }
}
