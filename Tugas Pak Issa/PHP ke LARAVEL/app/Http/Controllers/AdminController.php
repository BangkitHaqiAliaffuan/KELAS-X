<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\CartOrder;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\PaymentDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    /**
     * Get dashboard data for AJAX request.
     *
     */
    public function index()
    {
        try {
            // Get total users
            $totalUsers = User::count();

            // Get total products
            $totalProducts = Product::count();

            // Get total orders
            $totalOrders = CartOrder::count();

            // Get total revenue
            $totalRevenue = CartOrder::sum('price');

            // Get monthly revenue for current year
            $monthlyRevenue = CartOrder::selectRaw('MONTH(created_at) as month, SUM(price) as revenue')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->get()
                ->map(function ($item) {
                    return [
                        'month' => $item->month,
                        'revenue' => $item->revenue
                    ];
                })
                ->values()
                ->toArray();

            // Get recent activity (orders, new users, new products)
            $recentActivity = [];

            // Recent orders
            $recentOrders = CartOrder::with('user')
                ->orderBy('created_at', 'desc')
                ->limit(3)
                ->get();

            foreach ($recentOrders as $order) {
                $recentActivity[] = [
                    'type' => 'order',
                    'message' => 'New order #' . $order->id . ' from ' . $order->user->email,
                    'time' => $order->created_at->diffForHumans()
                ];
            }

            // Recent users
            $recentUsers = User::orderBy('created_at', 'desc')
                ->limit(3)
                ->get();

            foreach ($recentUsers as $user) {
                $recentActivity[] = [
                    'type' => 'user',
                    'message' => 'New user registered: ' . $user->email,
                    'time' => $user->created_at->diffForHumans()
                ];
            }

            // Recent products
            $recentProducts = Product::orderBy('created_at', 'desc')
                ->limit(3)
                ->get();

            foreach ($recentProducts as $product) {
                $recentActivity[] = [
                    'type' => 'product',
                    'message' => 'New game added: ' . $product->name,
                    'time' => $product->created_at->diffForHumans()
                ];
            }

            // Sort by time (most recent first)
            usort($recentActivity, function ($a, $b) {
                return strtotime($b['time']) - strtotime($a['time']);
            });

            // Limit to 5 most recent activities
            $recentActivity = array_slice($recentActivity, 0, 5);

            // Get top selling products
            $topProducts = DB::table('products')
                ->leftJoin('cart_orders', 'products.id', '=', 'cart_orders.product_id')
                ->select(
                    'products.id',
                    'products.name',
                    'products.price',
                    'products.image',
                    DB::raw('COUNT(cart_orders.id) as sales')
                )
                ->groupBy('products.id', 'products.name', 'products.price', 'products.image')
                ->orderBy('sales', 'desc')
                ->limit(5)
                ->get()
                ->map(function ($product) {
                    $product->image = asset('uploads/' . $product->image);
                    return $product;
                });

            // Mengembalikan view dengan data dashboard
            return view('admin/dashboard', [
                'totalUsers' => $totalUsers,
                'totalProducts' => $totalProducts,
                'totalOrders' => $totalOrders,
                'totalRevenue' => $totalRevenue,
                'monthlyRevenue' => $monthlyRevenue,
                'recentActivity' => $recentActivity,
                'topProducts' => $topProducts
            ]);

        } catch (\Exception $e) {
            // Mengembalikan redirect ke rute 'cart.index' dengan pesan error menggunakan 'with'
            return redirect()->route('cart.index')->with('error', 'Terjadi kesalahan saat mengambil data dashboard: ' . $e->getMessage());
        }
    }

    /**
     * Show the products management page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function products()
    {
        $products = Product::with('category')->orderBy('id', 'desc')->get();
        return view('admin.products', compact('products'));
    }


    /**
     * Show the users management page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function users()
    {
        $users = User::orderBy('id', 'asc')->get();
        return view('admin.users', compact('users'));
    }

    /**
     * Show the orders management page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function orders()
    {
        $cartOrders = DB::table('cart_orders')
            ->join('users', 'cart_orders.user_id', '=', 'users.id')
            ->select([
                'cart_orders.cart_id as id',
                'cart_orders.user_id',
                'users.email as user_email',
                DB::raw('DATE(cart_orders.created_at) as order_date'),
                DB::raw('SUM(cart_orders.price) as amount'),
                DB::raw('MIN(cart_orders.status) as status'),
                DB::raw('MIN(cart_orders.created_at) as order_time')
            ])
            ->groupBy('cart_orders.cart_id', 'cart_orders.user_id', 'users.email', DB::raw('DATE(cart_orders.created_at)'))
            ->orderBy('order_time', 'desc')
            ->orderBy('users.email', 'asc')
            ->get();

        // Mengelompokkan pesanan berdasarkan tanggal dan kemudian email
        $groupedCartOrders = $this->groupOrders($cartOrders);

        $allGroupedOrders = $groupedCartOrders->toArray();
        krsort($allGroupedOrders);

        $cartOrdersCount = $cartOrders->count();

        return view('admin.orders', compact('allGroupedOrders', 'cartOrdersCount'));
    }

    public function cartDetail($cart_id)
    {
        // Mengambil semua order untuk cart_id yang diberikan
        $orders = CartOrder::where('cart_id', $cart_id)->with('product')->get();

        if ($orders->isEmpty()) {
            return redirect()->route('payment.index')->withErrors(['error' => 'Tidak ada order ditemukan untuk keranjang ini.']);
        }

        // Menggunakan payment_id dari order pertama
        $firstOrder = $orders->first();
        $paymentId = $firstOrder->payment_id;

        // Mengambil detail pembayaran berdasarkan payment_id pertama
        $paymentDetail = PaymentDetail::find($paymentId);

        if (!$paymentDetail) {
            return redirect()->route('payment.index')->withErrors(['error' => 'Detail pembayaran tidak ditemukan.']);
        }

        // Mendekode instruksi dengan fallback jika kosong
        $instructions = json_decode($paymentDetail->instructions ?? '{}', true) ?: [];

        // Menghitung total jumlah dari semua order
        $amount = $orders->sum(function ($order) {
            return $order->price * $order->quantity;
        });

        // Membuat objek paymentDetail untuk ditampilkan di view
        $paymentDetailData = (object) [
            'payment_method' => $firstOrder->payment_method, // Dari order pertama
            'amount' => $amount, // Total dari semua order
            'expire_time' => $paymentDetail->expire_time, // Dari payment_details
            'is_paid' => $paymentDetail->is_paid, // Dari payment_details
        ];

        // Menentukan status orderCreated
        $orderCreated = session()->pull('order_created', false);

        return view('admin.orders.show', [
            'paymentDetail' => $paymentDetailData,
            'orders' => $orders,
            'cartId' => $cart_id,
            'instructions' => $instructions,
            'orderCreated' => $orderCreated
        ]);
    }
    /**
     * Group orders by date and email.
     *
     *
     */
    private function groupOrders($orders)
    {
        return $orders->groupBy('order_date')->map(function ($dateOrders) {
            return $dateOrders->groupBy('user_email');
        });
    }

    /**
     * Merge grouped orders.
     *
     * @param array $orders1
     * @param array $orders2
     * @return array
     */
    private function mergeGroupedOrders($orders1, $orders2)
    {
        $merged = [];

        // Combine all dates
        $allDates = array_unique(array_merge(array_keys($orders1), array_keys($orders2)));

        foreach ($allDates as $date) {
            if (!isset($merged[$date])) {
                $merged[$date] = [];
            }

            // Get all emails for this date
            $emails1 = isset($orders1[$date]) ? array_keys($orders1[$date]) : [];
            $emails2 = isset($orders2[$date]) ? array_keys($orders2[$date]) : [];
            $allEmails = array_unique(array_merge($emails1, $emails2));

            foreach ($allEmails as $email) {
                $merged[$date][$email] = [];

                // Merge orders for this email
                if (isset($orders1[$date][$email])) {
                    $merged[$date][$email] = array_merge($merged[$date][$email], $orders1[$date][$email]);
                }
                if (isset($orders2[$date][$email])) {
                    $merged[$date][$email] = array_merge($merged[$date][$email], $orders2[$date][$email]);
                }

                // Sort by order date descending
                usort($merged[$date][$email], function ($a, $b) {
                    return strtotime($b->order_date) - strtotime($a->order_date);
                });
            }
        }

        return $merged;
    }

    /**
     * Delete an order.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteOrder(Request $request)
    {
        $id = $request->id;
        $isCart = $request->is_cart == 'true';

        if ($isCart) {
            $cartId = CartOrder::where('id', $id)->value('cart_id');
            if ($cartId) {
                CartOrder::where('cart_id', $cartId)->delete();
                return redirect()->route('admin.orders')->with('success', 'Cart order deleted successfully.');
            }
        } else {
            CartOrder::destroy($id);
            return redirect()->route('admin.orders')->with('success', 'Order deleted successfully.');
        }

        return redirect()->route('admin.orders')->with('error', 'Error deleting order.');
    }

    /**
     * Show order details.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function orderDetail($id)
    {
        $order = CartOrder::with('user', 'product')->findOrFail($id);
        return view('admin.order_detail', compact('order'));
    }

    /**
     * Show cart order details.
     *
     * @param string $cartId
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function cartOrderDetail($cartId)
    {
        $cartOrders = CartOrder::with('user', 'product')
            ->where('cart_id', $cartId)
            ->get();

        return view('admin.cart_order_detail', compact('cartOrders'));
    }

    /**
     * Show add product form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function addProduct()
    {
        $categories = Category::all();
        return view('admin.products.add_product', compact('categories'));
    }

    /**
     * Store a new product.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'release_status' => 'required|in:released,upcoming,early_access',
            'detail_image1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'detail_image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'detail_image3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle main product image
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads'), $imageName);

        // Create new product
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->release_status = $request->release_status;
        $product->image = $imageName;
        $product->save();

        // Handle detail images
        $this->handleDetailImages($request, $product);

        return redirect()->route('admin.products')->with('success', 'Product added successfully.');
    }


    /**
     * Show edit product form.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function editProduct($id)
    {
        $product = Product::with('productImages')->findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit_product', compact('product', 'categories'));
    }
    /**
     * Update a product.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'release_status' => 'required|in:released,upcoming,early_access',
            'detail_image1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'detail_image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'detail_image3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);

        // Update main product image if provided
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads'), $imageName);

            // Delete old image if it exists
            if ($product->image && File::exists(public_path('uploads/' . $product->image))) {
                File::delete(public_path('uploads/' . $product->image));
            }

            $product->image = $imageName;
        }

        // Update product details
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->release_status = $request->release_status;
        $product->save();

        // Handle detail images
        $this->handleDetailImages($request, $product);

        return redirect()->route('admin.products')->with('success', 'Product updated successfully.');
    }

    /**
     * Handle the upload and storage of detail images.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return void
     */
    private function handleDetailImages(Request $request, Product $product)
    {
        // Create produklmg directory if it doesn't exist
        $uploadPath = public_path('produklmg');
        if (!File::isDirectory($uploadPath)) {
            File::makeDirectory($uploadPath, 0777, true);
        }

        // Get existing images
        $existingImages = $product->productImages;

        // Process each detail image
        for ($i = 1; $i <= 3; $i++) {
            $imageField = "detail_image{$i}";

            if ($request->hasFile($imageField)) {
                // Generate a slug-friendly product name for the filename
                $productSlug = Str::slug($product->name);

                // Create filename in the format: produklmg/productname_image1.jpg
                $extension = $request->file($imageField)->getClientOriginalExtension();
                $filename = "{$productSlug}_image{$i}.{$extension}";
                $filepath = "produklmg/{$filename}";

                // Move the uploaded file
                $request->file($imageField)->move($uploadPath, $filename);

                // Check if there's an existing image for this index
                if (isset($existingImages[$i - 1])) {
                    // Delete the old file if it exists
                    if (File::exists(public_path($existingImages[$i - 1]->image_url))) {
                        File::delete(public_path($existingImages[$i - 1]->image_url));
                    }

                    // Update the existing record
                    $existingImages[$i - 1]->image_url = $filepath;
                    $existingImages[$i - 1]->save();
                } else {
                    // Create a new record
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_url' => $filepath
                    ]);
                }
            }
        }
    }

    /**
     * Delete a product.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    /**
     * Delete a product if it's not owned by any users.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    /**
     * Delete a product if it's not owned by any users.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    /**
     * Delete a product and all its references.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteProduct($id)
    {
        try {
            DB::beginTransaction();

            // Get the product first to ensure it exists
            $product = Product::findOrFail($id);

            // Log the product being deleted for debugging
            \Log::info("Attempting to delete product ID: {$id}, Name: {$product->name}");

            // First check if there are any related records to delete
            $productImagesCount = DB::table('product_images')->where('product_id', $id)->count();
            $ownedGamesCount = DB::table('owned_games')->where('product_id', $id)->count();
            $cartOrdersCount = DB::table('cart_orders')->where('product_id', $id)->count();

            \Log::info("Related records count - Images: {$productImagesCount}, Owned games: {$ownedGamesCount}, Cart orders: {$cartOrdersCount}");

            // Delete all related records
            DB::table('product_images')->where('product_id', $id)->delete();
            DB::table('owned_games')->where('product_id', $id)->delete();
            DB::table('cart_orders')->where('product_id', $id)->delete();

            // Delete any other potential relationships
            // Check if wishlist table exists and delete from there too
            if (Schema::hasTable('wishlists')) {
                DB::table('wishlists')->where('product_id', $id)->delete();
            }

            // Check if reviews table exists and delete from there too
            if (Schema::hasTable('reviews')) {
                DB::table('reviews')->where('product_id', $id)->delete();
            }

            // Delete the product using the model to trigger any events
            $deleted = $product->delete();

            if (!$deleted) {
                throw new \Exception("Failed to delete product with ID: {$id}");
            }

            \Log::info("Product deleted successfully: {$id}");
            DB::commit();

            return redirect()->route('admin.products')->with('success', 'Game and all its references deleted successfullawdy.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Error deleting product {$id}: " . $e->getMessage());
            return redirect()->route('admin.products')->with('error', 'Error deleting game: ' . $e->getMessage());
        }
    }
    /**
     * Show manage users form.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function manageUsers($id)
    {
        $user = User::findOrFail($id);
        return view('admin.manage_users', compact('user'));
    }

    /**
     * Update a user.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|in:user,admin',
        ]);

        $user = User::findOrFail($id);
        $user->username = $request->username;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->save();

        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }

    /**
     * Delete a user.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteUser($id)
    {
        User::destroy($id);
        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }

    /**
     * Show revenue statistics.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function revenue()
    {
        // Get revenue data for charts
        $monthlyRevenue = CartOrder::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->whereRaw('YEAR(created_at) = YEAR(CURDATE())')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $cartMonthlyRevenue = CartOrder::selectRaw('MONTH(created_at) as month, SUM(price) as total')
            ->whereRaw('YEAR(created_at) = YEAR(CURDATE())')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Combine regular and cart order revenue
        $combinedRevenue = [];
        for ($i = 1; $i <= 12; $i++) {
            $combinedRevenue[$i] = 0;
        }

        foreach ($monthlyRevenue as $revenue) {
            $combinedRevenue[$revenue->month] += $revenue->total;
        }

        foreach ($cartMonthlyRevenue as $revenue) {
            $combinedRevenue[$revenue->month] += $revenue->total;
        }

        // Format data for chart
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $chartData = [];
        foreach ($combinedRevenue as $month => $total) {
            $chartData[] = [
                'month' => $months[$month - 1],
                'revenue' => $total
            ];
        }

        return view('admin.revenue', compact('chartData'));
    }
}
