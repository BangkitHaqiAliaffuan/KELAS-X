<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminAuthController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('product.details');

Route::middleware(['auth'])->group(function () {
    Route::get('/history', [App\Http\Controllers\HistoryController::class, 'index'])->name('history');
    Route::post('/products/{id}/reviews', [ProductController::class, 'submitReview'])->name('products.reviews.submit');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');



    Route::get('/payment', [App\Http\Controllers\PaymentController::class, 'index'])
        ->name('payment.index');

    // Process payment
    Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process');
    // Show payment details
    // Change this in your routes file
    Route::get('/payment/show/{cart_id}', [PaymentController::class,'show'])->name('payment.show');

    // Mark order as paid
    Route::post('/payment/mark-paid/{cartId}', [App\Http\Controllers\PaymentController::class, 'markAsPaid'])
    ->name('payment.markAsPaid');

    Route::get('/library', [LibraryController::class, 'index'])->name('library.index');
Route::post('/library/toggle-favorite', [LibraryController::class, 'toggleFavorite'])->name('library.toggleFavorite');
});
// Cart Routes
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/remove', [App\Http\Controllers\CartController::class, 'removeItem'])->name('cart.remove');
Route::post('/cart/clear', [App\Http\Controllers\CartController::class, 'clearCart'])->name('cart.clear');
Route::get('/order', [OrderController::class, 'order'])->name('order.create');
Route::get('/search', [ProductController::class, 'search'])->name('search');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Add other routes as needed (e.g., news, history, friends)
Route::get('/news', function () {
    return view('news'); })->name('news');
Route::get('/news/1', function () {
    return view('news1'); })->name('news1');
Route::get('/news/2', function () {
    return view('news2'); })->name('news2');

    Route::get('/friends', [FriendController::class, 'index'])->name('friends.index');
    Route::post('/friends/action', [FriendController::class, 'handleAction'])->name('friends.action');

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin Routes (Protected by admin middleware)
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    // Add this inside your admin routes group

    Route::get('/dashboard/data', [AdminController::class, 'dashboardData'])->name('dashboard.data');
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/revenue', [AdminController::class, 'revenue'])->name('revenue');

    // Product Management
    Route::get('/products/add', [AdminController::class, 'addProduct'])->name('products.add');
    Route::post('/products/store', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/edit/{id}', [AdminController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/update/{id}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/delete/{id}', [AdminController::class, 'deleteProduct'])->name('products.delete');

    // User Management
    Route::get('/users/manage/{id}', [AdminController::class, 'manageUsers'])->name('users.manage');
    Route::put('/users/update/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/delete/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');

    // Order Management
    Route::get('/orders/cart-detail/{cartId}', [AdminController::class, 'cartDetail'])->name('orders.cart-detail');
    Route::delete('/orders/delete', [AdminController::class, 'deleteOrder'])->name('orders.delete');
});

