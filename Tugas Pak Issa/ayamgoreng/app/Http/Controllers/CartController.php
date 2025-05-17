<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Models\Cart;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $alamatController = new AlamatController();
        $addresses = $alamatController->getAddressesForCart();
        $cartItems = Cart::where('session_id', session()->getId())->with('menu')->get();
        return view('cart', compact('cartItems', 'addresses'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $menu = Menu::findOrFail($request->menu_id);
        $cartItem = Cart::firstOrNew([
            'session_id' => session()->getId(),
            'menu_id' => $menu->id
        ]);
        $cartItem->quantity = ($cartItem->quantity ?? 0) + $request->quantity;
        $cartItem->save();

        return redirect('cart');
    }

    public function updateCart(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = Cart::findOrFail($request->cart_id);
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return redirect()->back()->with('success', 'Keranjang diperbarui');
    }

    public function removeFromCart($id)
    {
        $cartItem = Cart::findOrFail($id);
        $cartItem->delete();

        return redirect()->back()->with('success', 'Item dihapus dari keranjang');
    }

    public function checkout(Request $request)
    {
        // Ambil item keranjang berdasarkan session ID
        $addressId = $request->address_id;
        $address = Alamat::findOrFail($addressId);
        // Cek apakah keranjang kosong
        $cartItems = Cart::where('session_id', session()->getId())->with('menu')->get();

        // Hitung subtotal
        $subtotal = $cartItems->sum(function ($item) {
            return $item->menu->price * $item->quantity;
        });

        // Tambahkan biaya pengiriman dan pajak (sesuai cart.blade.php)
        $shippingCost = 10000; // Rp 10.000
        $tax = $subtotal * 0.1; // Pajak 10%
        $total = $subtotal + $shippingCost + $tax;

        // Ambil user yang sedang login (jika ada autentikasi)
        $user = auth()->user();

        $address = Alamat::findOrFail($addressId);

        if (auth()->check() && $address->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke alamat ini');
        }


        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang belanja Anda kosong');
        }
        $order = Order::create([
            'user_id' => $user ? $user->id : null, // Null jika tidak ada autentikasi
            'total' => $total,
            'status' => 'pending',
            'alamat' => $address->alamat
        ]);

        // Simpan detail item pesanan
        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $cartItem->menu_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->menu->price,
            ]);
        }

        // Hapus item dari keranjang setelah checkout
        Cart::where('session_id', session()->getId())->delete();

        // Redirect ke halaman konfirmasi pesanan (bisa dibuat terpisah)
        return redirect()->route('orders.show', $order->id)
                        ->with('success', 'Pesanan Anda telah dibuat');
    }
}
