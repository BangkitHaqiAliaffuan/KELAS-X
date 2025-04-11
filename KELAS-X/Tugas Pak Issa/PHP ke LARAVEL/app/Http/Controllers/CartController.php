<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CartOrder;
use App\Models\OwnedGame;
use Illuminate\Http\Request;
use App\Models\PaymentDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display the cart page
     */
    public function index()
    {
        // Initialize cart if it doesn't exist
        if (!Session::has('cart')) {
            Session::put('cart', []);
        }

        return view('cart');
    }

    /**
     * Add item to cart
     */
    public function addToCart(Request $request, $id)
    {
        $product_id = intval($id);
        $quantity = $request->input('quantity', 1);

        $result = $this->addItemToCart($product_id, $quantity);

        if ($result['success']) {
            return redirect()->back()->with('success', 'Product added to cart successfully');
        } else {
            return redirect()->back()->with('error', $result['message'] ?? 'Failed to add product to cart');
        }
    }
    /**
     * Remove item from cart
     */
    public function removeItem(Request $request)
    {
        $product_id = intval($request->input('product_id'));

        if (Session::has('cart')) {
            $cart = Session::get('cart');

            if (isset($cart[$product_id])) {
                unset($cart[$product_id]);
                Session::put('cart', $cart);
            }
        }

        return redirect()->route('cart.index');
    }

    /**
     * Clear the entire cart
     */
    public function clearCart()
    {
        Session::put('cart', []);

        return redirect()->route('cart.index');
    }

    /**
     * Process checkout from cart
     */


    /**
     * Add an item to the cart (helper method)
     */
    private function addItemToCart($product_id, $quantity = 1)
    {
        // Validate product exists and get its details
        $product = Product::find($product_id);

        if (!$product) {
            return [
                'success' => false,
                'message' => 'Product not found'
            ];
        }

        // Calculate discounted price
        $final_price = $product->price;
        if ($product->discount > 0) {
            $final_price = $product->price * (1 - ($product->discount / 100));
        }

        // Get current cart or initialize
        $cart = Session::get('cart', []);

        // Add or update cart item
        $cart_item = [
            'id' => $product->id,
            'name' => $product->name,
            'image' => $product->image,
            'price' => $final_price,
            'quantity' => $quantity
        ];

        if (isset($cart[$product_id])) {
            $cart[$product_id]['quantity'] += $quantity;
        } else {
            $cart[$product_id] = $cart_item;
        }

        Session::put('cart', $cart);

        return [
            'success' => true,
            'message' => 'Product added to cart',
            'cart_count' => count($cart)
        ];
    }

    /**
     * Get cart total (helper method)
     */
    public function getCartTotal()
    {
        $total = 0;
        $cart = Session::get('cart', []);

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return $total;
    }


    /**
     * Menampilkan halaman pembayaran keranjang
     */
    
}
