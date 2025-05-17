<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('halo', function(){
//     echo 'halo bosku';
// });

// Route::get('belajar', function(){
//     return view('belajar');
// });


// Route::get('/', function () {
//     return view('home');
// });

// Route::get('/profil', function () {
//     return view('profil');
// });

// Route::get('/kontak', function () {
//     return view('kontak');
// });

// Route::get('/jurusan', function () {
//     return view('jurusan');
// });



use App\Http\Controllers\PageController;

Route::get('/', [PageController::class, 'home']);
Route::get('/menu', [PageController::class, 'menu']);
Route::get('/order', [PageController::class, 'order']);
Route::get('/kontak', [PageController::class, 'kontak']);
Route::get('/chat', [PageController::class, 'chat']);

Route::get('/pesanan',[PageController::class, 'pesanan']);
