<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Requests\StoreorderDetailRequest;
use App\Http\Requests\UpdateorderDetailRequest;

class OrderDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $details = OrderDetail::join('orders', 'order_details.idorder', '=', 'orders.idorder')
        ->join('menus','order_details.idmenu','=','menus.idmenu')
        ->join('pelanggans','orders.idpelanggan','=','pelanggans.idpelanggan')
        ->select(['order_details.*','orders.*','menus.*','pelanggans.*'])
        ->paginate(3)
        ;

        return view('backend.detail.select',['details'=>$details]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $tglmulai = $request->tglmulai;
        $tglakhir = $request->tglakhir;


        $details = OrderDetail::join('orders', 'order_details.idorder', '=', 'orders.idorder')
        ->join('menus','order_details.idmenu','=','menus.idmenu')
        ->join('pelanggans','orders.idpelanggan','=','pelanggans.idpelanggan')
        ->whereBetween('orders.tglorder',[$tglmulai, $tglakhir])
        ->select(['order_details.*','orders.*','menus.*','pelanggans.*'])
        ->paginate(3)
        ;
        return view('backend.detail.select',['details'=>$details]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreorderDetailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(orderDetail $orderDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(orderDetail $orderDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateorderDetailRequest $request, orderDetail $orderDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(orderDetail $orderDetail)
    {
        //
    }
}
