<?php

namespace App\Http\Controllers;

use App\Models\order;
use Illuminate\Http\Request;
use App\Http\Requests\StoreorderRequest;
use App\Http\Requests\UpdateorderRequest;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::join('pelanggans','orders.idpelanggan','=', 'pelanggans.idpelanggan')
            ->select(['orders.*','pelanggans.*'])
            ->orderBy('status', 'ASC')
            ->paginate(2);
        ;
            return view('backend.order.select', ['orders'=>$orders]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreorderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show( $idorder)
    {
        $order = Order::where('idorder', $idorder)->first();
        return view('backend.order.update',['order'=>$order]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($idorder)
    {
        $orders = Order::join('order_details','orders.idorder','=', 'order_details.idorder')
        ->join('menus','order_details.idmenu','=','menus.idmenu')
        ->join('pelanggans','orders.idpelanggan','=','pelanggans.idpelanggan')
        ->where('orders.idorder',$idorder)
        ->get(['orders.*','order_details.*','menus.*','pelanggans.*'])

    ;
        return view('backend.order.detail', ['orders'=>$orders]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $idorder)
    {
        $data = $request->validate([
            'bayar' => 'required'
        ]);

        $kembalis = Order::where('idorder',$idorder)->first();
        $kembali = $data['bayar']-$kembalis->total;

        Order::where('idorder', $idorder)->update([
            'bayar' => $data['bayar'],
            'kembali' => $kembali,
            'status' => 1
        ]);

        return redirect('admin/order');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(order $order)
    {
        //
    }
}
