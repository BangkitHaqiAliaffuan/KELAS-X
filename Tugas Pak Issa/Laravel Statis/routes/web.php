<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

Route::get('/', function () {
    return view('home');
});

Route::get('/kontak', [PageController::class, 'kontak']);
Route::get('/profil', [PageController::class, 'profil']);
Route::get('/jurusan', [PageController::class, 'jurusan']);
