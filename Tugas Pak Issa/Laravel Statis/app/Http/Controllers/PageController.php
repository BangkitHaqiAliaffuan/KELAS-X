<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function kontak(){
        return view('contact');
    }
    public function profil(){
        return view('profile');
    }
    public function jurusan(){
        return view('departements');
    }
}
