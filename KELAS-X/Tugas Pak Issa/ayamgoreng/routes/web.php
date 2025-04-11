<?php

use App\Http\Controllers\AlamatController;
use App\Models\User;
use App\Models\UserOtp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;

Route::get('/', [HomeController::class, 'index']);
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/update-avatar', [ProfileController::class, 'updateAvatar'])->name('profile.updateAvatar');
    Route::put('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
});

Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout')->middleware('auth');
Route::post('/alamat/add', [AlamatController::class, 'add'])->name('alamat.add')->middleware('auth');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add')->middleware('auth');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update')->middleware('auth');
Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove')->middleware('auth');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('login', [AuthController::class, 'showLogin']);
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('register', [AuthController::class, 'showRegister']);
Route::post('postlogin', [AuthController::class, 'login']);
Route::post('postregister', [AuthController::class, 'register']);
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
Route::get('/orders/{id}/pay', [PaymentController::class, 'confirmPayment']);

Route::get('admin/orders/{id}/pay', [PaymentController::class, 'confirmPayment']);
Route::get('admin/menus/{id}/edit', [MenuController::class, 'edit']);
Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard Route
    Route::get('/login', [AdminController::class, 'login'])->name('login');
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
    Route::post('/postlogin', [AdminController::class, 'postlogin'])->name('postlogin');
    Route::get('/', [AdminController::class, 'index'])->name('dashboard')->middleware('admin.auth');
    // User Management Routes
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{id}', [AdminController::class, 'showUsers'])->name('users.show');
    Route::put('/users/{userId}/toggle-ban', [AdminController::class, 'toggleBannedStatus'])->name('users.toggle-ban');


    // Order Management Routes
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/orders/{id}/view', [AdminController::class, 'showOrder'])->name('orders.show');

    // Menu Management Routes
    Route::controller(MenuController::class)->prefix('menus')->name('menus.')->group(function () {
        Route::get('/', 'showmenus')->name('showmenus');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    // Admin Management Routes
    Route::get('/admin', [AdminController::class, 'listAdmins'])->name('admins');
    Route::post('/create', [AdminController::class, 'storeNewAdmin'])->name('store');
    Route::get('/admin/{id}', [AdminController::class, 'viewAdminDetails'])->name('show');
    Route::get('/{id}/edit', [AdminController::class, 'editAdminForm'])->name('edit');
    Route::put('/{id}', [AdminController::class, 'updateAdminDetails'])->name('update');
    Route::get('/{id}/delete', [AdminController::class, 'deleteAdmin'])->name('delete');

    // Additional Routes  Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{id}', [ContactController::class, 'show'])->name('messages.show');
    Route::get('/messages/{id}/reply', [ContactController::class, 'showReplyForm'])->name('messages.showReplyForm');
    Route::post('/messages/{id}/reply', [ContactController::class, 'reply'])->name('messages.reply');
    Route::post('/messages/{id}/archive', [ContactController::class, 'archive'])->name('messages.archive');
    Route::delete('/messages/{id}/delete', [ContactController::class, 'delete'])->name('messages.delete');
    Route::get('/messages', [ContactController::class, 'showmessage'])->name('messages');

});

Route::get('/otp-verification/{user}', [OtpController::class, 'showVerificationForm'])->name('otp_verification');
Route::post('/otp-verification/{user}', [OtpController::class, 'verify'])->name('otp.verify');
Route::get('/otp-resend/{user}', [OtpController::class, 'resend'])->name('otp.resend');
