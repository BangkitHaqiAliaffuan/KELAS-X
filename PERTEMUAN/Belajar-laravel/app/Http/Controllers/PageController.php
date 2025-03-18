<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{

    public function pesanan(){
        return view('pesanan');
    }

    public function home()
    {
        return view('home');
    }


    public function menu()
    {
        return view('menu');
    }

    public function order()
    {
        return view('order');
    }

    public function kontak()
    {
        return view('kontak');
    }

    public function chat()
    {
        return view('chat');
    }
}
