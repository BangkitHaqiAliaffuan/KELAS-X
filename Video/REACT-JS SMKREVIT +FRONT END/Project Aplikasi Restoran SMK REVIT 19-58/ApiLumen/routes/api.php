<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\OrderController;

// Admin/Staff Authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Customer Authentication Routes
Route::post('/pelanggan/register', [PelangganController::class, 'register']);
Route::post('/pelanggan/login', [PelangganController::class, 'login']);
Route::post('/pelanggan/logout', [PelangganController::class, 'logout'])->middleware('api_token');

// Route untuk menu dan kategori (publik)
Route::get('/kategoris', [KategoriController::class, 'index']);
Route::get('/menus', [\App\Http\Controllers\MenuController::class, 'index']);
Route::get('/menus-with-categories', [\App\Http\Controllers\MenuController::class, 'getMenusWithCategories']); // Combined menu and category data

// Rute yang memerlukan autentikasi
Route::group(['middleware' => 'api_token'], function () {
    Route::get('/users', [AuthController::class, 'index']);
    Route::put('/users/{iduser}/status', [AuthController::class, 'updateStatus']);

    // Route untuk Order dan Detail Order
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::put('/orders/{id}/payment', [OrderController::class, 'updatePayment']);
    Route::post('/orders/checkout', [OrderController::class, 'checkout']);

    // Route untuk menu dan kategori (admin)
    Route::resource('pelanggans', PelangganController::class);
    Route::post('/kategoris', [KategoriController::class, 'store']);
    Route::put('/kategoris/{id}', [KategoriController::class, 'update']);
    Route::delete('/kategoris/{id}', [KategoriController::class, 'destroy']);
    Route::post('/menus', [\App\Http\Controllers\MenuController::class, 'store']);
    Route::put('/menus/{id}', [\App\Http\Controllers\MenuController::class, 'update']);
    Route::delete('/menus/{id}', [\App\Http\Controllers\MenuController::class, 'destroy']);

    // Route untuk Order Detail
    Route::get('/order-details', [\App\Http\Controllers\OrderDetailController::class, 'index']);
    Route::get('/order-details/order/{idorder}', [\App\Http\Controllers\OrderDetailController::class, 'getByOrderId']);
    Route::get('/order-details/{id}', [\App\Http\Controllers\OrderDetailController::class, 'show']);
    Route::put('/users/{iduser}/logout', [AuthController::class, 'logout']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/', function (Request $request) {
    return response()->json(['message' => 'API Lumen']);
});



