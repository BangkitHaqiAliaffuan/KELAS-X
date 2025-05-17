<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        if ($user = Auth::user()) {

        }
        return view('Backend.login');
    }
    public function postlogin(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required|min:3',

        ]);

        $data = $request->only('email', 'password');


        if (Auth::attempt($data)) {
            // echo '1';
            $user = Auth::user();


            if ($user->level == 'admin') {
                return redirect('admin/user');
            } else if ($user->level == 'kasir') {
                return redirect('admin/order');

            } else if ($user->level == 'manajer') {
                return redirect('admin/kategori');

            }



        }

        return redirect('admin');

    }


    public function logout()
    {
        session()->flush();
        Auth::logout();
        return redirect('admin');
    }


}
