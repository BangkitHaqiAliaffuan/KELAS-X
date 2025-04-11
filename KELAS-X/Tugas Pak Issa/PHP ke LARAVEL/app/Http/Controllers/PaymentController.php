<?php

namespace App\Http\Controllers;

use App\Models\CartOrder;
use App\Models\OwnedGame;
use App\Models\PaymentDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class PaymentController extends Controller
{
    /**
     * Display the payment page
     */
    public function index()
    {
        // Check if user is logged in
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Check if cart is empty
        if (empty(session('cart'))) {
            return redirect()->route('cart.index');
        }

        $userId = auth()->id();

        // Get owned games to prevent duplicate purchases
        $ownedGames = OwnedGame::where('user_id', $userId)
            ->pluck('product_id')
            ->toArray();

        // Check if any cart items are already owned
        $duplicateItems = [];
        foreach (session('cart') as $productId => $item) {
            if (in_array($productId, $ownedGames)) {
                $duplicateItems[] = $item['name'];
            }
        }

        return view('payment.index', [
            'duplicateItems' => $duplicateItems
        ]);
    }

    /**
     * Process the payment
     */
    /**
     * Process the payment
     */
    public function process(Request $request)
    {
        // Validate request
        $request->validate([
            'payment_method' => 'required|in:bank_transfer,e_wallet',
        ]);

        $userId = auth()->id();

        // Check if cart exists in session
        if (!session()->has('cart') || empty(session('cart'))) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty. Please add items before checkout.');
        }

        $paymentMethod = $request->payment_method;

        // Calculate total with tax
        $cart = session('cart');
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $tax = $subtotal * 0.1;
        $totalAmount = $subtotal + $tax;

        // Start transaction
        DB::beginTransaction();

        try {
            // Generate payment instructions
            $paymentInstructions = $this->generatePaymentInstructions($paymentMethod, $totalAmount);

            // Create payment detail record
            $paymentDetail = PaymentDetail::create([
                'user_id' => $userId,
                'amount' => $totalAmount,
                'payment_method' => $paymentMethod,
                'instructions' => $paymentInstructions, // Already encoded as JSON in the method
                'expire_time' => Carbon::now()->addDay(),
                'status' => 'pending',
                'is_paid' => 0 // Ensure is_paid field is initialized to 0
            ]);

            // Get payment ID and generate cart ID
            $paymentId = $paymentDetail->id;
            $cartId = $this->generateCartId();

            // Insert orders for each cart item
            foreach ($cart as $item) {
                CartOrder::create([
                    'user_id' => $userId,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'cart_id' => $cartId,
                    'status' => 'pending',
                    'payment_method' => $paymentMethod,
                    'payment_id' => $paymentId,
                ]);
            }

            // Commit transaction
            DB::commit();

            // Store order created in session
            session(['order_created' => true]);

            // Redirect to show payment details with the cart ID
            return redirect('/payment/show/' . $cartId);

        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollback();

            // Log the error for debugging
            \Log::error('Payment processing error: ' . $e->getMessage());

            return redirect()->route('cart.index')
                ->with('error', 'An error occurred while processing your order: ' . $e->getMessage());
        }
    }
    /**
     * Display payment details after order is created
     */
    /**
     * Display payment details after order is created
     */
    /**
     * Display payment details after order is created
     */
    /**
     * Display payment details after order is created
     */
    public function show($cart_id)
    {
        // Mengambil semua order untuk cart_id yang diberikan
        $orders = CartOrder::where('cart_id', $cart_id)->with('product')->get();

        if ($orders->isEmpty()) {
            return redirect()->route('payment.index')->withErrors(['error' => 'Tidak ada order ditemukan untuk keranjang ini.']);
        }

        // Menggunakan payment_id dari order pertama
        $firstOrder = $orders->first();
        $paymentId = $firstOrder->payment_id;

        // Mengambil detail pembayaran berdasarkan payment_id pertama
        $paymentDetail = PaymentDetail::find($paymentId);

        if (!$paymentDetail) {
            return redirect()->route('payment.index')->withErrors(['error' => 'Detail pembayaran tidak ditemukan.']);
        }

        // Mendekode instruksi dengan fallback jika kosong
        $instructions = json_decode($paymentDetail->instructions ?? '{}', true) ?: [];

        // Menghitung total jumlah dari semua order
        $amount = $orders->sum(function ($order) {
            return $order->price * $order->quantity;
        });

        // Membuat objek paymentDetail untuk ditampilkan di view
        $paymentDetailData = (object) [
            'payment_method' => $firstOrder->payment_method, // Dari order pertama
            'amount' => $amount, // Total dari semua order
            'expire_time' => $paymentDetail->expire_time, // Dari payment_details
            'is_paid' => $paymentDetail->is_paid, // Dari payment_details
        ];

        // Menentukan status orderCreated
        $orderCreated = session()->pull('order_created', false);

        return view('payment.show', [
            'paymentDetail' => $paymentDetailData,
            'orders' => $orders,
            'cartId' => $cart_id,
            'instructions' => $instructions,
            'orderCreated' => $orderCreated
        ]);
    }

    /**
     * Mark an order as paid
     */
    public function markAsPaid(Request $request, $cartId)
{
    $userId = auth()->id();

    // Mulai transaksi
    DB::beginTransaction();

    try {
        // Ambil order pertama untuk mendapatkan payment_id
        $firstOrder = CartOrder::where('cart_id', $cartId)
            ->where('user_id', $userId)
            ->first();

        if (!$firstOrder) {
            throw new \Exception('Tidak ada pesanan ditemukan di keranjang.');
        }

        $paymentId = $firstOrder->payment_id;

        // Ambil detail pembayaran
        $paymentDetail = PaymentDetail::find($paymentId);

        if (!$paymentDetail) {
            throw new \Exception('Detail pembayaran tidak ditemukan.');
        }

        $requiredAmount = (double) $paymentDetail->amount; // Konversi ke double

        // Ambil jumlah yang dimasukkan dari request dan konversi ke double
        $enteredAmountStr = $request->input('amount');
        $enteredAmount = (double) str_replace('.', '', $enteredAmountStr); // Hapus titik dan konversi ke double

        // Validasi jika jumlah yang dimasukkan kurang dari yang diperlukan
        if ($enteredAmount < $requiredAmount) {
            throw new \Exception('Jumlah pembayaran tidak mencukupi. Dibutuhkan: ' . number_format($requiredAmount, 0, ',', '.') . ', Dimasukkan: ' . $enteredAmountStr);
        }

        // Update detail pembayaran
        $paymentDetail->payment_money = $enteredAmount; // Simpan sebagai double
        $paymentDetail->return = $enteredAmount - $requiredAmount; // Selisih sebagai double
        $paymentDetail->is_paid = 1;
        $paymentDetail->payment_date = $request->input('payment_date'); // Simpan tanggal pembayaran
        $paymentDetail->save();

        // Update status untuk semua order dalam keranjang
        CartOrder::where('cart_id', $cartId)
            ->where('user_id', $userId)
            ->update(['status' => 'done']);

        // Ambil ID produk yang dibeli
        $purchasedProducts = CartOrder::where('cart_id', $cartId)
            ->where('user_id', $userId)
            ->pluck('product_id')
            ->toArray();

        // Simpan produk yang dibeli ke session
        $sessionPurchased = session('purchased_products', []);
        foreach ($purchasedProducts as $productId) {
            if (!in_array($productId, $sessionPurchased)) {
                $sessionPurchased[] = $productId;
            }
        }
        session(['purchased_products' => $sessionPurchased]);

        // Tambahkan game ke perpustakaan pengguna
        foreach ($purchasedProducts as $productId) {
            OwnedGame::firstOrCreate([
                'user_id' => $userId,
                'product_id' => $productId
            ]);
        }

        // Commit transaksi
        DB::commit();

        // Bersihkan keranjang dan redirect
        session()->forget('cart');
        return redirect()->route('library.index')->with('thank_you', 1);
    } catch (\Exception $e) {
        // Rollback jika terjadi error
        DB::rollback();
        return redirect()->route('cart.index')->with('error', 'Terjadi kesalahan saat memproses pembayaran Anda: ' . $e->getMessage());
    }
}

    /**
     * Generate a unique cart ID
     */
    private function generateCartId()
    {
        return 'CART-' . time() . '-' . auth()->id();
    }

    /**
     * Calculate cart total with tax
     */
    private function getCartTotalWithTax()
    {
        $subtotal = 0;
        foreach (session('cart') as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $tax = $subtotal * 0.1;
        return $subtotal + $tax;
    }

    /**
     * Generate payment instructions based on payment method
     */
    private function generatePaymentInstructions($paymentMethod, $totalAmount)
    {
        $instructions = [];

        if ($paymentMethod == 'bank_transfer') {
            $instructions = [
                'bank_name' => 'Bank Central',
                'account_number' => '1234-5678-9012',
                'account_name' => 'Game Store',
                'amount' => $totalAmount,
                'reference' => 'ORDER-' . time()
            ];
        } elseif ($paymentMethod == 'e_wallet') {
            $instructions = [
                'wallet_provider' => 'E-Pay',
                'payment_code' => 'EPAY-' . strtoupper(substr(md5(time()), 0, 8)),
                'amount' => $totalAmount,
                'steps' => 'Open E-Pay app, select Pay, enter code, confirm payment'
            ];
        }

        return json_encode($instructions);
    }
}
