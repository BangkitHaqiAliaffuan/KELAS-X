<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function toggleBannedStatus($userId)
    {
        try {
            $user = User::findOrFail($userId);

            // Toggle the banned status (0 to 1, or 1 to 0)
            $user->banned = $user->banned == 1 ? 0 : 1;
            $user->save();

            // Prepare response message
            $status = $user->banned == 1 ? 'banned' : 'unbanned';
            $message = "User {$user->name} has been successfully $status.";

            // Return JSON response
            return response()->json([
                'success' => true,
                'message' => $message,
                'banned' => $user->banned
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to update user status: ' . $e->getMessage()
            ], 500);
        }
    }
    public function index()
    {
        $totalOrders = Order::count(); // 2
        $totalRevenue = Order::sum('total'); // 37500 + 159500 = 197000
        $totalUsers = User::count(); // 2
        $totalMenus = Menu::count(); // 7
        $recentOrders = Order::with('user')->latest()->take(5)->get(); // 2 orders
        $recentUsers = User::latest()->take(5)->get(); // 2 users

        return view('admin/dashboard', compact('totalOrders', 'totalRevenue', 'totalUsers', 'totalMenus', 'recentOrders', 'recentUsers'));
    }
    public function orders()
    {
        $orders = Order::with('user')->latest()->paginate(10); // 2 orders
        return view('admin.orders', compact('orders'));
    }

    public function showOrder($id)
    {
        $order = Order::with(['user', 'orderItems.menu'])->findOrFail($id);
        return view('admin.showorder', compact('order'));
    }

    public function menus()
    {
        $categories = Category::all(); // Ambil semua kategori
        $menus = Menu::with('category')->paginate(8); // Ambil menu dengan relasi kategori, 8 per halaman
        return view('admin.menus', compact('menus', 'categories'));
    }
    public function users(Request $request)
    {
        $query = User::query();

        // Apply filters
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search%");
            });
        }

        $users = $query->paginate(6); // 6 users per page, matching template

        return view('admin.users', compact('users'));
    }
    public function showUsers($id)
    {
        $user = User::with('orders.orderDetails')->findOrFail($id);
        $response = [
            'id' => $user->id,
            'name' => $user->name,
            'role' => ucfirst($user->role),
            'status' => ucfirst($user->status),
            'email' => $user->email,
            'phone' => $user->phone,
            'address' => $user->address ?? 'N/A',
            'created_at' => $user->created_at->toDateTimeString(),
            'last_login' => $user->last_login?->toDateTimeString(),
            'gambar' => $user->gambar,
            'orders' => $user->orders->count(),
            'total_spent' => $user->orders->sum(function ($order) {
                return $order->orderDetails->sum('price');
            }),
            'rating' => $user->rating ?? 'N/A' // Assume rating is added or calculated elsewhere
        ];
        return response()->json($response);
    }
    public function messages()
    {
        return view('admin/messages');
    }

    /**
     * Display a listing of admin users.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function listAdmins(Request $request)
    {
        $query = Admin::query();

        // Filter by role
        if ($request->has('role') && $request->role) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Search by name or email
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Paginate results
        $admins = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.admins', compact('admins'));
    }

    /**
     * Show the form for creating a new admin.
     *
     * @return \Illuminate\View\View
     */


    /**
     * Store a newly created admin in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeNewAdmin(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:superadmin,admin,manager,staff',
            'is_active' => 'required|boolean',
        ]);

        $admin = Admin::create(array_merge($validated, [
            'password' => bcrypt($request->password)
        ]));

        // Redirect ke halaman daftar admin
        return redirect()->route('admin.admins')->with('success', 'Admin created successfully');
    }

    /**
     * Display the specified admin.
     *
     * @param Admin $admin
     * @return \Illuminate\View\View
     */
    public function viewAdminDetails(Admin $admin)
    {
        return view('admin.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified admin.
     *
     * @param Admin $admin
     * @return \Illuminate\View\View
     */
    public function editAdminForm(Admin $admin)
    {
        return view('admin.edit', compact('admin'));
    }

    /**
     * Update the specified admin in storage.
     *
     * @param Request $request
     * @param Admin $admin
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAdminDetails(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('admins')->ignore($admin->id)
            ],
            'password' => 'nullable|min:8',
            'role' => ['required', Rule::in(['superadmin', 'admin', 'manager', 'staff'])],
            'is_active' => 'boolean'
        ]);

        // Only update password if provided
        if ($request->filled('password')) {
            $admin->password = $request->password;
        }

        $admin->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'role' => $validatedData['role'],
            'is_active' => $validatedData['is_active']
        ]);

        return redirect()->route('admin.admins')
            ->with('success', 'Admin updated successfully.');
    }

    /**
     * Remove the specified admin from storage.
     *
     * @param Admin $admin
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAdmin($id)
    {
        $admin = Admin::findOrFail($id);

        $superAdminCount = Admin::where('role', 'superadmin')->count();
        if ($admin->role === 'superadmin' && $superAdminCount <= 1) {
            return redirect()->back()
                ->with('error', 'Cannot delete the last superadmin.');
        }

        $admin->delete();

        return redirect()->route('admin.admins')
            ->with('success', 'Admin deleted successfully.');
    }

    /**
     * Update admin's last login timestamp.
     *
     * @param Admin $admin
     */
    public function updateAdminLastLogin(Admin $admin)
    {
        $admin->update(['last_login' => now()]);
    }

    public function login()
    {
        return view('admin.login');
    }

    public function postLogin(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Cari admin berdasarkan email
        $admin = Admin::where('email', $request->email)->first();

        // Periksa apakah admin ada
        if ($admin) {
            // Verifikasi password menggunakan Hash
            if ($request->password === $admin->password) {
                // Cek apakah admin tidak diblokir
                // Simpan ID admin ke session
                $request->session()->put('admin_name', $admin->name);
                $request->session()->put('admin_email', $admin->email);
                $request->session()->put('admin_role', $admin->role);
                $request->session()->put('admin_id', $admin->id);

                // Redirect ke halaman dashboard
                return redirect('admin/dashboard');
                // Akun diblokir
            } else {
                return back()->withErrors([
                    'email' => 'Akun Anda diblokir.'
                ]);
            }
        }

        // Login gagal
        return back()->withErrors([
            'email' => 'Kredensial tidak valid.'
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        // Hapus semua data session admin
        $request->session()->forget([
            'admin_id',
            'admin_name',
            'admin_email'
        ]);

        // Hapus semua session
        $request->session()->flush();

        // Redirect ke halaman login
        return redirect('admin/login')->with('success', 'Anda berhasil logout');
    }

}
