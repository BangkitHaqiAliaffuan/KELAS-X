<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PelangganController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/', function (Request $request) {
    return response()->json(['message' => 'API Lumen']);
});


Route::resource('pelanggans', PelangganController::class);
Route::middleware(['auth:sanctum', 'admin', 'api'])->group(function () {
    Route::resource('kategoris', KategoriController::class);
    Route::resource('menus', \App\Http\Controllers\MenuController::class);
});


