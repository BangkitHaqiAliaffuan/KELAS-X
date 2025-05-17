@extends('layouts.app')

@section('content')
<div class="epic-container">
    <div class="epic-header">
        <h1>Checkout</h1>
        <div class="epic-steps">
            <div class="epic-step completed">
                <div class="epic-step-number">1</div>
                <div class="epic-step-label">Cart</div>
            </div>
            <div class="epic-step active">
                <div class="epic-step-number">2</div>
                <div class="epic-step-label">Payment</div>
            </div>
            <div class="epic-step">
                <div class="epic-step-number">3</div>
                <div class="epic-step-label">Confirmation</div>
            </div>
        </div>
    </div>

    @if (!empty($duplicateItems))
        <div class="epic-alert epic-alert-danger">
            <div class="epic-alert-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
            </div>
            <div class="epic-alert  y1="16" x2="12.01" y2="16"></line></svg>
            </div>
            <div class="epic-alert-content">
                <h3>Warning: Already Owned Games</h3>
                <p>The following games are already in your library:</p>
                <ul class="duplicate-games-list">
                    @foreach ($duplicateItems as $game)
                        <li>{{ $game }}</li>
                    @endforeach
                </ul>
                <p>Please remove these items from your cart before proceeding.</p>
            </div>
        </div>
    @endif

    <div class="epic-checkout-grid">
        <div class="epic-order-summary">
            <div class="epic-card">
                <div class="epic-card-header">
                    <h2>Order Summary</h2>
                    <span class="epic-item-count">{{ count(session('cart')) }} items</span>
                </div>
                <div class="epic-card-body">
                    @php
                        $subtotal = 0;
                        foreach (session('cart') as $item) {
                            $subtotal += $item['price'] * $item['quantity'];
                        }
                        $tax = $subtotal * 0.1;
                        $total = $subtotal + $tax;
                    @endphp

                    <div class="epic-cart-items">
                        @foreach (session('cart') as $item)
                            <div class="epic-cart-item">
                                <div class="epic-cart-item-info">
                                    <div class="epic-cart-item-image">
                                        <div class="game-thumbnail" style="background-color: #2a2a2a;">
                                            <span>{{ substr($item['name'], 0, 1) }}</span>
                                        </div>
                                    </div>
                                    <div class="epic-cart-item-details">
                                        <h4>{{ $item['name'] }}</h4>
                                        <span class="epic-cart-item-platform">PC Digital Download</span>
                                    </div>
                                </div>
                                <div class="epic-cart-item-price">
                                    IDR {{ number_format($item['price'], 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="epic-divider"></div>

                    <div class="epic-price-summary">
                        <div class="epic-price-row">
                            <span>Subtotal</span>
                            <span>IDR {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="epic-price-row">
                            <span>Tax (10%)</span>
                            <span>IDR {{ number_format($tax, 0, ',', '.') }}</span>
                        </div>
                        <div class="epic-price-row epic-price-total">
                            <span>Total</span>
                            <span>IDR {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="epic-payment-methods">
            <div class="epic-card">
                <div class="epic-card-header">
                    <h2>Select Payment Method</h2>
                </div>
                <div class="epic-card-body">
                    <form method="POST" action="{{ route('payment.process') }}" id="payment-form">
                        @csrf
                        <div class="epic-payment-options">
                            <label class="epic-payment-option" for="bank_transfer">
                                <input type="radio" id="bank_transfer" name="payment_method" value="bank_transfer" required>
                                <div class="epic-payment-option-content">
                                    <div class="epic-payment-option-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"></rect><line x1="2" y1="10" x2="22" y2="10"></line></svg>
                                    </div>
                                    <div class="epic-payment-option-details">
                                        <h4>Bank Transfer</h4>
                                        <p>Pay via bank transfer</p>
                                    </div>
                                    <div class="epic-payment-option-check">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    </div>
                                </div>
                            </label>

                            <label class="epic-payment-option" for="e_wallet">
                                <input type="radio" id="e_wallet" name="payment_method" value="e_wallet" required>
                                <div class="epic-payment-option-content">
                                    <div class="epic-payment-option-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="6" width="20" height="12" rx="2"></rect><circle cx="12" cy="12" r="2"></circle><path d="M6 12h.01M18 12h.01"></path></svg>
                                    </div>
                                    <div class="epic-payment-option-details">
                                        <h4>E-Wallet</h4>
                                        <p>Pay using your e-wallet</p>
                                    </div>
                                    <div class="epic-payment-option-check">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <button type="submit" class="epic-button epic-button-primary epic-button-lg epic-button-block {{ !empty($duplicateItems) ? 'epic-button-disabled' : '' }}" {{ !empty($duplicateItems) ? 'disabled' : '' }}>
                            <span class="epic-button-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                            </span>
                            <span>Proceed to Payment</span>
                        </button>
                    </form>
                </div>
                <div class="epic-card-footer">
                    <div class="epic-secure-payment">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        <span>Secure payment processing</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Epic Games Theme - Main Styles */
    :root {
        --epic-bg-dark: #121212;
        --epic-bg-card: #202020;
        --epic-bg-hover: #2a2a2a;
        --epic-primary: #0078f2;
        --epic-primary-hover: #0069d9;
        --epic-secondary: #2a2a2a;
        --epic-secondary-hover: #333333;
        --epic-text: #ffffff;
        --epic-text-secondary: #9a9a9a;
        --epic-border: #333333;
        --epic-success: #0ac18e;
        --epic-warning: #f5a623;
        --epic-danger: #ff3b30;
        --epic-info: #0078f2;
    }

    body {
        background-color: var(--epic-bg-dark);
        color: var(--epic-text);
        font-family: 'Segoe UI', 'Roboto', sans-serif;
        line-height: 1.5;
    }

    .epic-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    /* Header Styles */
    .epic-header {
        margin-bottom: 2rem;
        text-align: center;
    }

    .epic-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: var(--epic-text);
    }

    /* Steps Navigation */
    .epic-steps {
        display: flex;
        justify-content: center;
        margin: 2rem 0;
    }

    .epic-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        padding: 0 2rem;
    }

    .epic-step:not(:last-child)::after {
        content: '';
        position: absolute;
        top: 1rem;
        right: -1rem;
        width: 2rem;
        height: 2px;
        background-color: var(--epic-border);
    }

    .epic-step-number {
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        background-color: var(--epic-secondary);
        color: var(--epic-text);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.5rem;
        font-weight: bold;
    }

    .epic-step.active .epic-step-number {
        background-color: var(--epic-primary);
    }

    .epic-step.completed .epic-step-number {
        background-color: var(--epic-success);
    }

    .epic-step-label {
        font-size: 0.875rem;
        color: var(--epic-text-secondary);
    }

    .epic-step.active .epic-step-label {
        color: var(--epic-text);
    }

    /* Card Styles */
    .epic-card {
        background-color: var(--epic-bg-card);
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
        border: 1px solid var(--epic-border);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .epic-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .epic-card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--epic-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .epic-card-header h2 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
    }

    .epic-card-body {
        padding: 1.5rem;
    }

    .epic-card-footer {
        padding: 1.25rem 1.5rem;
        border-top: 1px solid var(--epic-border);
    }

    /* Alert Styles */
    .epic-alert {
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: flex-start;
    }

    .epic-alert-icon {
        margin-right: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .epic-alert-content {
        flex: 1;
    }

    .epic-alert-content h3, .epic-alert-content h4 {
        margin-top: 0;
        margin-bottom: 0.5rem;
    }

    .epic-alert-success {
        background-color: rgba(10, 193, 142, 0.1);
        border: 1px solid var(--epic-success);
    }

    .epic-alert-success .epic-alert-icon {
        color: var(--epic-success);
    }

    .epic-alert-danger {
        background-color: rgba(255, 59, 48, 0.1);
        border: 1px solid var(--epic-danger);
    }

    .epic-alert-danger .epic-alert-icon {
        color: var(--epic-danger);
    }

    .epic-alert-warning {
        background-color: rgba(245, 166, 35, 0.1);
        border: 1px solid var(--epic-warning);
    }

    .epic-alert-warning .epic-alert-icon {
        color: var(--epic-warning);
    }

    .epic-alert-info {
        background-color: rgba(0, 120, 242, 0.1);
        border: 1px solid var(--epic-info);
    }

    .epic-alert-info .epic-alert-icon {
        color: var(--epic-info);
    }

    /* Button Styles */
    .epic-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        border-radius: 0.25rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        border: none;
    }

    .epic-button svg {
        margin-right: 0.5rem;
    }

    .epic-button-primary {
        background-color: var(--epic-primary);
        color: white;
    }

    .epic-button-primary:hover {
        background-color: var(--epic-primary-hover);
    }

    .epic-button-secondary {
        background-color: var(--epic-secondary);
        color: white;
    }

    .epic-button-secondary:hover {
        background-color: var(--epic-secondary-hover);
    }

    .epic-button-lg {
        padding: 1rem 2rem;
        font-size: 1.125rem;
    }

    .epic-button-block {
        display: flex;
        width: 100%;
    }

    .epic-button-disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    /* Divider */
    .epic-divider {
        height: 1px;
        background-color: var(--epic-border);
        margin: 1.5rem 0;
    }

    /* Checkout Grid */
    .epic-checkout-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    @media (min-width: 768px) {
        .epic-checkout-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    /* Cart Items */
    .epic-cart-items {
        margin-bottom: 1.5rem;
    }

    .epic-cart-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid var(--epic-border);
    }

    .epic-cart-item:last-child {
        border-bottom: none;
    }

    .epic-cart-item-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .epic-cart-item-image {
        width: 3rem;
        height: 3rem;
        border-radius: 0.25rem;
        overflow: hidden;
    }

    .game-thumbnail {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.5rem;
        color: var(--epic-text);
    }

    .epic-cart-item-details h4 {
        margin: 0 0 0.25rem 0;
        font-size: 1rem;
    }

    .epic-cart-item-platform {
        font-size: 0.875rem;
        color: var(--epic-text-secondary);
    }

    .epic-cart-item-price {
        font-weight: 600;
    }

    /* Price Summary */
    .epic-price-summary {
        margin-top: 1rem;
    }

    .epic-price-row {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
    }

    .epic-price-total {
        font-weight: 700;
        font-size: 1.125rem;
        margin-top: 0.5rem;
        padding-top: 0.5rem;
        border-top: 1px solid var(--epic-border);
    }

    /* Payment Options */
    .epic-payment-options {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .epic-payment-option {
        position: relative;
        cursor: pointer;
    }

    .epic-payment-option input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    .epic-payment-option-content {
        display: flex;
        align-items: center;
        padding: 1.25rem;
        border: 2px solid var(--epic-border);
        border-radius: 0.5rem;
        transition: all 0.2s ease;
    }

    .epic-payment-option.selected .epic-payment-option-content {
        border-color: var(--epic-primary);
        background-color: rgba(0, 120, 242, 0.1);
    }

    .epic-payment-option.hover .epic-payment-option-content {
        border-color: var(--epic-primary);
    }

    .epic-payment-option-icon {
        width: 3rem;
        height: 3rem;
        background-color: var(--epic-secondary);
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        color: var(--epic-primary);
    }

    .epic-payment-option-details {
        flex: 1;
    }

    .epic-payment-option-details h4 {
        margin: 0 0 0.25rem 0;
    }

    .epic-payment-option-details p {
        margin: 0;
        color: var(--epic-text-secondary);
        font-size: 0.875rem;
    }

    .epic-payment-option-check {
        color: var(--epic-primary);
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    .epic-payment-option.selected .epic-payment-option-check {
        opacity: 1;
    }

    /* Secure Payment */
    .epic-secure-payment {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        color: var(--epic-text-secondary);
        font-size: 0.875rem;
    }

    /* Duplicate Games List */
    .duplicate-games-list {
        list-style-type: none;
        padding-left: 0;
        margin: 0.5rem 0;
    }

    .duplicate-games-list li {
        padding: 0.5rem;
        background-color: rgba(255, 59, 48, 0.1);
        border-radius: 0.25rem;
        margin-bottom: 0.5rem;
    }

    /* Animation */
    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(0, 120, 242, 0.7);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(0, 120, 242, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(0, 120, 242, 0);
        }
    }

    .pulse {
        animation: pulse 1.5s infinite;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .epic-container {
            padding: 1rem;
        }

        .epic-header h1 {
            font-size: 2rem;
        }

        .epic-step {
            padding: 0 1rem;
        }
    }
</style>

<script>
    // Payment method selection
    document.querySelectorAll('.epic-payment-option input').forEach(input => {
        input.addEventListener('change', function() {
            document.querySelectorAll('.epic-payment-option').forEach(option => {
                option.classList.remove('selected');
            });
            if (this.checked) {
                this.closest('.epic-payment-option').classList.add('selected');
            }
        });
    });

    // Select the first payment method by default
    if (document.querySelector('.epic-payment-option input')) {
        document.querySelector('.epic-payment-option input').checked = true;
        document.querySelector('.epic-payment-option').classList.add('selected');
    }

    // Add hover effects to payment options
    document.querySelectorAll('.epic-payment-option').forEach(option => {
        option.addEventListener('mouseenter', function() {
            if (!this.classList.contains('selected')) {
                this.classList.add('hover');
            }
        });
        option.addEventListener('mouseleave', function() {
            this.classList.remove('hover');
        });
    });

    // Add pulse animation to proceed button
    const proceedButton = document.querySelector('.epic-button-primary');
    if (proceedButton && !proceedButton.classList.contains('epic-button-disabled')) {
        setTimeout(() => {
            proceedButton.classList.add('pulse');
            setTimeout(() => {
                proceedButton.classList.remove('pulse');
            }, 1500);
        }, 1000);
    }
</script>
@endsection

