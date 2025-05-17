<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    /**
     * Show the admin login form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showLoginForm()
    {
        return view('admin.login');
    }

    /**
     * Handle an admin login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
{
    $credentials = $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    $admin = Admin::where('username', $credentials['username'])->first();

    if ($admin && $credentials['password'] === $admin->password) {
        // Store admin ID in session
        session()->put('admin_id', $admin->id);
        session()->put('is_admin', true);

        // Log in the admin
        Auth::guard('admin')->login($admin);

        return redirect()->route('admin.dashboard');
    }

    return back()->withErrors([
        'username' => 'The provided credentials do not match our records.',
    ]);
}
    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->forget(['admin_id', 'is_admin']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
