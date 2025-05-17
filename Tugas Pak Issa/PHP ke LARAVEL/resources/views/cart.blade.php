@extends('layouts.app')

@section('content')
<div class="container">
    <div class="cart-container">
        <h2 class="mb-4">Shopping Cart</h2>
        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
         @endif
        <!-- Cart Items -->
        @if (!empty(Session::get('cart')))
            <div class="cart-items-container">
                @foreach (Session::get('cart') as $product_id => $item)
                    <div class="cart-item" data-id="{{ $product_id }}">
                        <div class="item-image">
                            <img src="{{ asset('uploads/' . $item['image']) }}" alt="{{ $item['name'] }}">
                            <div class="item-hover-overlay">
                                <span class="view-details">View Details</span>
                            </div>
                        </div>
                        <div class="item-details">
                            <div class="item-title">{{ $item['name'] }}</div>
                            <div class="item-price">IDR {{ number_format($item['price'], 0, ',', '.') }}</div>

                            <div class="quantity-control">
                                <button type="button" class="quantity-btn decrease-btn" onclick="updateQuantity({{ $product_id }}, 'decrease')">-</button>
                                <input type="number" min="1" value="1" class="quantity-input" data-id="{{ $product_id }}" onchange="updateQuantity({{ $product_id }}, 'set', this.value)">
                                <button type="button" class="quantity-btn increase-btn" onclick="updateQuantity({{ $product_id }}, 'increase')">+</button>
                            </div>
                        </div>
                        <div class="item-actions">
                            <form method="POST" action="{{ route('cart.remove') }}" class="remove-form">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product_id }}">
                                <button type="submit" class="remove-btn">
                                    <span class="remove-icon">×</span>
                                    <span class="remove-text">Remove</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-cart">
                <div class="empty-cart-animation">
                    <div class="cart-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                    </div>
                </div>
                <h3>Your cart is empty</h3>
                <p>Browse our games and add something to your cart!</p>
                <a href="{{ route('products') }}" class="browse-btn">Browse Games</a>
            </div>
        @endif

        <!-- Cart Summary -->
        @if (!empty(Session::get('cart')))
            <div class="cart-summary">
                <h3>Order Summary</h3>
                <div class="summary-items">
                    <div class="summary-item">
                        <span>Subtotal</span>
                        <span class="subtotal-value">IDR {{ number_format(app(App\Http\Controllers\CartController::class)->getCartTotal(), 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-item">
                        <span>Tax (10%)</span>
                        <span class="tax-value">IDR {{ number_format(app(App\Http\Controllers\CartController::class)->getCartTotal() * 0.1, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-item discount-row hidden">
                        <span>Discount</span>
                        <span class="discount-value">-IDR 0</span>
                    </div>
                </div>

                <div class="promo-code-container">
                    <div class="promo-toggle" onclick="togglePromoCode()">
                        <span>Have a promo code?</span>
                        <span class="toggle-icon">+</span>
                    </div>
                    <div class="promo-input-container hidden">
                        <input type="text" class="promo-input" placeholder="Enter promo code">
                        <button type="button" class="apply-promo-btn" onclick="applyPromoCode()">Apply</button>
                    </div>
                </div>

                <div class="summary-total">
                    <span><strong>Total</strong></span>
                    <span class="total-value"><strong>IDR {{ number_format(app(App\Http\Controllers\CartController::class)->getCartTotal() * 1.1, 0, ',', '.') }}</strong></span>
                </div>

                <form method="GET" action="{{ route('payment.index') }}">
                    @csrf
                    <button type="submit" class="checkout-btn">
                        <span>Proceed to Checkout</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>

<style>
    body {
        margin: 0;
        padding: 0;
        background: #0f0f13;
        color: white;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
    }

    .container {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .cart-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 30px;
        background: #18181b;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        animation: fadeIn 0.6s ease;
        position: relative;
        overflow: hidden;
    }

    .cart-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #0078f2, #00b3ff, #0078f2);
        background-size: 200% 100%;
        animation: gradientMove 3s ease infinite;
    }

    @keyframes gradientMove {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }

    .cart-container h2 {
        font-size: 2rem;
        margin-bottom: 30px;
        position: relative;
        display: inline-block;
    }

    .cart-container h2::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 60px;
        height: 3px;
        background: #0078f2;
        border-radius: 3px;
    }

    .cart-items-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        max-height: 600px;
        overflow-y: auto;
        padding-right: 10px;
        scrollbar-width: thin;
        scrollbar-color: #0078f2 #2a2a2a;
    }

    .cart-items-container::-webkit-scrollbar {
        width: 6px;
    }

    .cart-items-container::-webkit-scrollbar-track {
        background: #2a2a2a;
        border-radius: 10px;
    }

    .cart-items-container::-webkit-scrollbar-thumb {
        background: #0078f2;
        border-radius: 10px;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .cart-item {
        background: #1f1f23;
        border-radius: 12px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 20px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        animation: slideIn 0.5s ease forwards;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .cart-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }

    .cart-item::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, transparent, #0078f2, transparent);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .cart-item:hover::after {
        opacity: 1;
    }

    .item-image {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        flex-shrink: 0;
    }

    .item-image img {
        width: 120px;
        height: 160px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .item-hover-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 120, 242, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .item-image:hover img {
        transform: scale(1.05);
    }

    .item-image:hover .item-hover-overlay {
        opacity: 1;
    }

    .view-details {
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 6px 12px;
        border: 2px solid white;
        border-radius: 4px;
        cursor: pointer;
    }

    .item-details {
        flex: 1;
    }

    .item-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 8px;
        color: #ffffff;
    }

    .item-price {
        font-size: 1.2rem;
        color: #0078f2;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .quantity-control {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 15px;
        max-width: 120px;
    }

    .quantity-btn {
        background: #2a2a2a;
        border: none;
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        font-weight: bold;
    }

    .quantity-btn:hover {
        background: #0078f2;
        transform: translateY(-2px);
    }

    .quantity-input {
        background: #2a2a2a;
        border: none;
        color: white;
        width: 50px;
        height: 32px;
        text-align: center;
        border-radius: 6px;
        font-weight: 600;
    }

    .item-actions {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }

    .remove-btn {
        background: transparent;
        color: #ff4444;
        border: 1px solid #ff4444;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .remove-btn:hover {
        background: #ff4444;
        color: white;
        transform: translateY(-2px);
    }

    .remove-icon {
        font-size: 1.2rem;
        font-weight: bold;
    }

    .cart-summary {
        background: #1f1f23;
        border-radius: 12px;
        padding: 25px;
        margin-top: 30px;
        animation: fadeIn 0.8s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .cart-summary h3 {
        font-size: 1.5rem;
        margin-bottom: 20px;
        position: relative;
        display: inline-block;
    }

    .cart-summary h3::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 40px;
        height: 3px;
        background: #0078f2;
        border-radius: 3px;
    }

    .summary-items {
        margin-bottom: 20px;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #2a2a2a;
        transition: all 0.3s ease;
    }

    .summary-item:last-child {
        border-bottom: none;
    }

    .promo-code-container {
        margin: 20px 0;
        border-top: 1px solid #2a2a2a;
        border-bottom: 1px solid #2a2a2a;
        padding: 15px 0;
    }

    .promo-toggle {
        display: flex;
        justify-content: space-between;
        cursor: pointer;
        padding: 5px 0;
        transition: all 0.3s ease;
    }

    .promo-toggle:hover {
        color: #0078f2;
    }

    .toggle-icon {
        font-size: 1.2rem;
        transition: transform 0.3s ease;
    }

    .promo-toggle.active .toggle-icon {
        transform: rotate(45deg);
    }

    .promo-input-container {
        display: flex;
        gap: 10px;
        margin-top: 15px;
        transition: all 0.3s ease;
        height: 0;
        overflow: hidden;
    }

    .promo-input-container.show {
        height: 40px;
    }

    .promo-input {
        flex: 1;
        background: #2a2a2a;
        border: none;
        color: white;
        padding: 10px 15px;
        border-radius: 6px;
    }

    .apply-promo-btn {
        background: #0078f2;
        color: white;
        border: none;
        padding: 0 15px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .apply-promo-btn:hover {
        background: #0066cc;
        transform: translateY(-2px);
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        margin: 20px 0;
        padding-top: 15px;
        font-size: 1.2rem;
    }

    .checkout-btn {
        background: #0078f2;
        color: white;
        border: none;
        padding: 15px;
        width: 100%;
        font-weight: 600;
        font-size: 1.1rem;
        border-radius: 8px;
        margin-top: 20px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        position: relative;
        overflow: hidden;
    }

    .checkout-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.1);
        transition: all 0.5s ease;
    }

    .checkout-btn:hover {
        background: #0066cc;
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0, 102, 204, 0.4);
    }

    .checkout-btn:hover::before {
        left: 100%;
    }

    .empty-cart {
        text-align: center;
        padding: 60px 20px;
        animation: fadeIn 0.8s ease;
    }

    .empty-cart-animation {
        margin-bottom: 30px;
        position: relative;
    }

    .cart-icon {
        color: #ffffff40;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-15px);
        }
        100% {
            transform: translateY(0px);
        }
    }

    .empty-cart h3 {
        font-size: 1.8rem;
        margin-bottom: 15px;
        color: #ffffff;
    }

    .empty-cart p {
        font-size: 1.1rem;
        color: #aaaaaa;
        margin-bottom: 30px;
    }

    .browse-btn {
        display: inline-block;
        background: #0078f2;
        color: white;
        text-decoration: none;
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .browse-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.1);
        transition: all 0.5s ease;
    }

    .browse-btn:hover {
        background: #0066cc;
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0, 102, 204, 0.4);
    }

    .browse-btn:hover::before {
        left: 100%;
    }

    .hidden {
        display: none;
    }

    /* Responsive styles */
    @media (max-width: 768px) {
        .cart-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .item-image {
            width: 100%;
            margin-bottom: 15px;
        }

        .item-image img {
            width: 100%;
            height: 200px;
        }

        .item-actions {
            width: 100%;
            align-items: flex-start;
            margin-top: 15px;
        }

        .remove-btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<script>
    // Function to update quantity
    function updateQuantity(productId, action, value = null) {
        const inputElement = document.querySelector(`.quantity-input[data-id="${productId}"]`);
        let currentValue = parseInt(inputElement.value);

        if (action === 'increase') {
            inputElement.value = currentValue + 1;
        } else if (action === 'decrease') {
            if (currentValue > 1) {
                inputElement.value = currentValue - 1;
            }
        } else if (action === 'set' && value !== null) {
            inputElement.value = parseInt(value);
        }

        // Here you would typically make an AJAX call to update the cart on the server
        // For demonstration, we'll just update the UI
        updateCartTotals();
    }

    // Function to toggle promo code input
    function togglePromoCode() {
        const promoContainer = document.querySelector('.promo-input-container');
        const promoToggle = document.querySelector('.promo-toggle');

        promoContainer.classList.toggle('hidden');
        promoToggle.classList.toggle('active');

        if (!promoContainer.classList.contains('hidden')) {
            promoContainer.classList.add('show');
            setTimeout(() => {
                document.querySelector('.promo-input').focus();
            }, 300);
        } else {
            promoContainer.classList.remove('show');
        }
    }

    // Function to apply promo code
    function applyPromoCode() {
        const promoInput = document.querySelector('.promo-input');
        const promoCode = promoInput.value.trim();

        if (promoCode === '') {
            // Show error
            promoInput.style.border = '1px solid #ff4444';
            setTimeout(() => {
                promoInput.style.border = 'none';
            }, 2000);
            return;
        }

        // Simulate promo code validation
        // In a real app, you would make an AJAX call to validate the promo code
        if (promoCode.toLowerCase() === 'discount20') {
            // Apply discount
            document.querySelector('.discount-row').classList.remove('hidden');
            document.querySelector('.discount-value').textContent = '-IDR 20.000';

            // Show success message
            const successMessage = document.createElement('div');
            successMessage.className = 'promo-success';
            successMessage.textContent = 'Promo code applied successfully!';
            successMessage.style.color = '#00cc66';
            successMessage.style.marginTop = '10px';
            successMessage.style.fontSize = '0.9rem';

            const promoContainer = document.querySelector('.promo-input-container');
            promoContainer.parentNode.insertBefore(successMessage, promoContainer.nextSibling);

            setTimeout(() => {
                successMessage.remove();
            }, 3000);

            // Update totals
            updateCartTotals(20000); // 20,000 IDR discount
        } else {
            // Show error message
            const errorMessage = document.createElement('div');
            errorMessage.className = 'promo-error';
            errorMessage.textContent = 'Invalid promo code. Please try again.';
            errorMessage.style.color = '#ff4444';
            errorMessage.style.marginTop = '10px';
            errorMessage.style.fontSize = '0.9rem';

            const promoContainer = document.querySelector('.promo-input-container');
            promoContainer.parentNode.insertBefore(errorMessage, promoContainer.nextSibling);

            setTimeout(() => {
                errorMessage.remove();
            }, 3000);
        }
    }

    // Function to update cart totals
    function updateCartTotals(discount = 0) {
        // In a real app, you would calculate these values based on the actual cart items
        // For demonstration, we'll use placeholder values
        const subtotal = 500000; // Example: 500,000 IDR
        const tax = subtotal * 0.1;
        const total = subtotal + tax - discount;

        // Format numbers with commas
        function formatNumber(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Update the UI
        document.querySelector('.subtotal-value').textContent = 'IDR ' + formatNumber(subtotal);
        document.querySelector('.tax-value').textContent = 'IDR ' + formatNumber(tax);
        document.querySelector('.total-value').textContent = 'IDR ' + formatNumber(total);
    }

    // Add animation when removing items
    document.addEventListener('DOMContentLoaded', function() {
        const removeForms = document.querySelectorAll('.remove-form');

        removeForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const cartItem = this.closest('.cart-item');
                cartItem.style.opacity = '0';
                cartItem.style.transform = 'translateX(20px)';

                setTimeout(() => {
                    // In a real app, you would submit the form here
                    // For demonstration, we'll just remove the item from the DOM
                    cartItem.remove();

                    // Check if cart is empty
                    const cartItems = document.querySelectorAll('.cart-item');
                    if (cartItems.length === 0) {
                        location.reload(); // Reload to show empty cart state
                    } else {
                        updateCartTotals();
                    }
                }, 300);
            });
        });
    });
</script>
@endsection
