<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function confirmPayment($orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->ispaid = true;
        $order->save();

        return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi');
    }
}
