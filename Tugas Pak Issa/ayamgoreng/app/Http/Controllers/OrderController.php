<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Ambil semua pesanan milik pengguna yang sedang login
        $orders = Order::where('user_id', auth()->id())->get();
        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        // Ambil pesanan berdasarkan ID, pastikan milik pengguna yang login
        $order = Order::with('orderItems.menu')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('orders.show', compact('order'));
    }
}
