<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    /**
     * Menampilkan seluruh isi tabel details
     */
    public function index(Request $request)
    {
        $query = OrderDetail::with(['order.pelanggan', 'menu']);

        // Filter berdasarkan tanggal jika ada
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereHas('order', function($q) use ($request) {
                $q->whereBetween('tglorder', [
                    $request->input('start_date'),
                    $request->input('end_date')
                ]);
            });
        }

        $orderDetails = $query->get();

        return response()->json([
            'status' => true,
            'data' => $orderDetails
        ]);
    }

    /**
     * Menampilkan detail order berdasarkan ID order
     */
    public function getByOrderId($idorder)
    {
        $order = Order::with('pelanggan')->find($idorder);

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Order tidak ditemukan'
            ], 404);
        }

        $orderDetails = OrderDetail::with('menu')
            ->where('idorder', $idorder)
            ->get();

        return response()->json([
            'status' => true,
            'order' => $order,
            'details' => $orderDetails
        ]);
    }

    /**
     * Menampilkan detail order berdasarkan ID detail
     */
    public function show($id)
    {
        $orderDetail = OrderDetail::with(['order', 'menu'])->find($id);

        if (!$orderDetail) {
            return response()->json([
                'status' => false,
                'message' => 'Detail order tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $orderDetail
        ]);
    }
}
