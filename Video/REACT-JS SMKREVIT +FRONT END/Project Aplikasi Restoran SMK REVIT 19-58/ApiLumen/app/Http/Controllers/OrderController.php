<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar semua order atau order berdasarkan idpelanggan
     */
    public function index(Request $request)
    {
        try {
            $query = Order::with(['pelanggan', 'orderDetails.menu']);

            // Filter by date range if provided
            if ($request->has('start_date') && $request->has('end_date')) {
                $query->whereBetween('tglorder', [$request->start_date, $request->end_date]);
            }

            // Filter by customer ID if provided
            if ($request->has('idpelanggan')) {
                $query->where('idpelanggan', $request->input('idpelanggan'));
            }

            // Sort by newest first
            $query->orderBy('created_at', 'desc');

            $orders = $query->get();

            return response()->json([
                'status' => true,
                'data' => $orders
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error retrieving orders: ' . $e->getMessage()
            ], 500);
        }
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
    /**
     * Create a new order with its details (checkout process)
     */
    public function checkout(Request $request)
    {
        try {
            DB::beginTransaction();

            // Get user from token
            $user = $request->user();

            // If idpelanggan is not provided, try to get it from the authenticated user
            $idpelanggan = $request->input('idpelanggan', $user->idpelanggan ?? null);

            if (!$idpelanggan) {
                throw new \Exception('Customer ID not found');
            }

            // Validate request
            $request->validate([
                'idpelanggan' => 'required|exists:pelanggans,idpelanggan',
                'items' => 'required|array',
                'items.*.idmenu' => 'required|exists:menus,idmenu',
                'items.*.jumlah' => 'required|integer|min:1',
                'items.*.hargajual' => 'required|numeric|min:0'
            ]);

            // Create order
            $order = new Order();
            $order->idpelanggan = $idpelanggan;
            $order->tglorder = now();
            $order->total = 0; // Will be updated after adding details
            $order->bayar = 0;
            $order->kembali = 0;
            $order->status = 1; // 1 = Pending
            $order->save();

            $total = 0;

            // Create order details
            foreach ($request->items as $item) {
                $subtotal = $item['jumlah'] * $item['hargajual'];
                $total += $subtotal;

                OrderDetail::create([
                    'idorder' => $order->idorder,
                    'idmenu' => $item['idmenu'],
                    'jumlah' => $item['jumlah'],
                    'hargajual' => $item['hargajual']
                ]);
            }

            // Update order total
            $order->total = $total;
            $order->save();

            DB::commit();

            // Load the order with its relationships
            $order = Order::with(['orderDetails.menu', 'pelanggan'])
                        ->find($order->idorder);

            return response()->json([
                'status' => true,
                'message' => 'Order berhasil dibuat',
                'data' => $order
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal membuat order: ' . $e->getMessage()
            ], 500);
        }
    }

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
