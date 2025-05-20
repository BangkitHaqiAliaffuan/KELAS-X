<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar semua order
     */
    public function index(Request $request)
    {
        $query = Order::with('pelanggan');

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('tglorder', [$request->start_date, $request->end_date]);
        }

        $orders = $query->get();
        return response()->json([
            'status' => true,
            'data' => $orders
        ]);
    }

    /**
     * Menampilkan detail order berdasarkan ID
     */
    public function show($id)
    {
        $order = Order::with('pelanggan')->find($id);

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Order tidak ditemukan'
            ], 404);
        }

        $orderDetails = OrderDetail::with('menu')
            ->where('idorder', $id)
            ->get();

        return response()->json([
            'status' => true,
            'order' => $order,
            'details' => $orderDetails
        ]);
    }

    /**
     * Fungsi pembayaran - update kolom bayar, kembali, dan status
     */
    public function updatePayment(Request $request, $id)
    {
        $request->validate([
            'bayar' => 'required|numeric',
            'status' => 'required|numeric'
        ]);

        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Order tidak ditemukan'
            ], 404);
        }

        // Hitung kembalian
        $bayar = $request->input('bayar');
        $kembali = $bayar - $order->total;

        // Update data pembayaran
        $order->bayar = $bayar;
        $order->kembali = $kembali;
        $order->status = $request->input('status');
        $order->save();

        return response()->json([
            'status' => true,
            'message' => 'Pembayaran berhasil diupdate',
            'data' => $order
        ]);
    }
}
