<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\OrderController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rute yang memerlukan autentikasi
Route::group(['middleware' => 'api_token'], function () {
    Route::get('/users', [AuthController::class, 'index']);
    Route::put('/users/{iduser}/status', [AuthController::class, 'updateStatus']);

    Route::resource('pelanggans', PelangganController::class);
    Route::resource('kategoris', KategoriController::class);
    Route::resource('menus', \App\Http\Controllers\MenuController::class);

    // Route untuk Order dan Detail Order
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::put('/orders/{id}/payment', [OrderController::class, 'updatePayment']);

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



