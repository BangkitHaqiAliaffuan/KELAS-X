<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartOrder;
use App\Models\PaymentDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class HistoryController extends Controller
{
    /**
     * Display the order history for the authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get the authenticated user
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to view your order history.');
        }

        // Get all cart orders for the user, grouped by cart_id
        $cartOrders = CartOrder::where('user_id', $user->id)
            ->where('status', '!=', 'active') // Only get completed or processed orders
            ->with(['product', 'payment'])
            ->orderBy('created_at', 'desc')
            ->get();


        $orders = CartOrder::where('user_id', $user->id)->with('product')->get();
        $firstOrder = $orders->first();
        $payment_method = $firstOrder->payment_method;


        // Group orders by cart_id
        $groupedOrders = $cartOrders->groupBy('cart_id');

        // Transform the data for easier display in the view
        $orders = new Collection();

        foreach ($groupedOrders as $cartId => $items) {
            // Get the payment from the first item (all items in a cart should have the same payment)
            $payment = $items->first()->payment;

            $orders->push((object) [
                'payment_method' => $payment_method,
                'cart_id' => $cartId,
                'created_at' => $items->first()->created_at,
                'items' => $items, // This is a collection, not null
                'payment' => $payment
            ]);
        }

        return view('history_order', compact('orders','payment_method'));
    }

    /**
     * Display details for a specific order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($cartId)
    {
        // Get the authenticated user
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to view order details.');
        }

        // Find the cart orders and ensure they belong to the user
        $cartOrders = CartOrder::where('cart_id', $cartId)
            ->where('user_id', $user->id)
            ->with(['product', 'payment'])
            ->get();

        if ($cartOrders->isEmpty()) {
            return redirect()->route('history.index')->with('error', 'Order not found or you do not have permission to view it.');
        }

        // Redirect to the payment details page
        return redirect()->route('payment.show', $cartId);
    }

    /**
     * Download invoice for a specific order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function downloadInvoice($cartId)
    {
        // Get the authenticated user
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to download your invoice.');
        }

        // Find the cart orders and ensure they belong to the user
        $cartOrders = CartOrder::where('cart_id', $cartId)
            ->where('user_id', $user->id)
            ->with(['product', 'payment'])
            ->get();

        if ($cartOrders->isEmpty()) {
            return redirect()->route('history.index')->with('error', 'Order not found or you do not have permission to download this invoice.');
        }

        // Get the payment from the first item
        $payment = $cartOrders->first()->payment;

        // Check if payment is completed
        if (!$payment || !$payment->is_paid) {
            return redirect()->route('history.index')->with('error', 'Cannot download invoice for unpaid orders.');
        }

        // Generate and download invoice (implementation depends on your PDF generation library)
        // This is a placeholder for the actual invoice generation code

        return redirect()->route('history.index')->with('error', 'Invoice download functionality is not implemented yet.');
    }
}
