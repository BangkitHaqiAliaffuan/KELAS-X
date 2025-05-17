@extends('layouts.app')

@section('content')
<div class="epic-container">
    @if(session('error'))
        <div class="epic-alert epic-alert-danger">
            <div class="epic-alert-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
            </div>
            <div class="epic-alert-content">
                {{ session('error') }}
            </div>
        </div>
    @endif

    @if(session('success'))
        <div class="epic-alert epic-alert-success">
            <div class="epic-alert-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            </div>
            <div class="epic-alert-content">
                <h4>Payment Marked as Paid!</h4>
                <p>Your payment has been recorded. Thank you for your purchase.</p>
            </div>
        </div>
    @endif

    @if($orderCreated)
        <div class="epic-alert epic-alert-success">
            <div class="epic-alert-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            </div>
            <div class="epic-alert-content">
                <h4>Order Successfully Created!</h4>
                <p>Please complete your payment using the instructions below.</p>
            </div>
        </div>
    @endif

    <div class="epic-card payment-details-card">
        <div class="epic-card-header">
            <h2>Payment Details</h2>
            <div class="epic-badge epic-badge-{{ $paymentDetail->is_paid ? 'success' : 'warning' }}">
                {{ ucfirst($paymentDetail->is_paid ? 'Paid' : 'Pending') }}
            </div>
        </div>
        <div class="epic-card-body">
            <div class="payment-method-info">
                <div class="payment-method-icon">
                    @if($paymentDetail->payment_method == 'bank_transfer')
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"></rect><line x1="2" y1="10" x2="22" y2="10"></line></svg>
                    @elseif($paymentDetail->payment_method == 'e_wallet')
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="6" width="20" height="12" rx="2"></rect><circle cx="12" cy="12" r="2"></circle><path d="M6 12h.01M18 12h.01"></path></svg>
                    @endif
                </div>
                <div class="payment-method-details">
                    <h4>{{ ucfirst($paymentDetail->payment_method) }}</h4>
                    <div class="payment-info-grid">
                        <div class="payment-info-item">
                            <span class="info-label">Amount</span>
                            <span class="info-value">IDR {{ number_format($paymentDetail->amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="payment-info-item">
                            <span class="info-label">Expires</span>
                            <span class="info-value countdown" data-expire="{{ \Carbon\Carbon::parse($paymentDetail->expire_time)->format('Y-m-d H:i:s') }}">
                                {{ \Carbon\Carbon::parse($paymentDetail->expire_time)->format('d M Y, H:i') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="epic-divider"></div>

            <div class="payment-instructions">
                <h4>Payment Instructions</h4>
                <div class="epic-card instruction-card">
                    <div class="epic-card-body">
                        @if($paymentDetail->payment_method == 'bank_transfer')
                            <div class="instruction-grid">
                                <div class="instruction-item">
                                    <span class="instruction-label">Bank Name</span>
                                    <span class="instruction-value">{{ $instructions['bank_name'] }}</span>
                                </div>
                                <div class="instruction-item">
                                    <span class="instruction-label">Account Number</span>
                                    <div class="copy-field">
                                        <span id="account-number" class="instruction-value">{{ $instructions['account_number'] }}</span>
                                        <button class="copy-btn" data-clipboard-target="#account-number">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="instruction-item">
                                    <span class="instruction-label">Account Name</span>
                                    <span class="instruction-value">{{ $instructions['account_name'] }}</span>
                                </div>
                                <div class="instruction-item">
                                    <span class="instruction-label">Amount</span>
                                    <div class="copy-field">
                                        <span id="amount" class="instruction-value">IDR {{ number_format($instructions['amount'], 0, ',', '.') }}</span>
                                        <button class="copy-btn" data-clipboard-target="#amount">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="instruction-item">
                                    <span class="instruction-label">Reference</span>
                                    <div class="copy-field">
                                        <span id="reference" class="instruction-value">{{ $instructions['reference'] }}</span>
                                        <button class="copy-btn" data-clipboard-target="#reference">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="epic-alert epic-alert-info mt-3">
                                <div class="epic-alert-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                </div>
                                <div class="epic-alert-content">
                                    Please include the reference number in your transfer description.
                                </div>
                            </div>
                        @elseif($paymentDetail->payment_method == 'e_wallet')
                            <div class="instruction-grid">
                                <div class="instruction-item">
                                    <span class="instruction-label">E-Wallet Provider</span>
                                    <span class="instruction-value">{{ $instructions['wallet_provider'] }}</span>
                                </div>
                                <div class="instruction-item">
                                    <span class="instruction-label">Payment Code</span>
                                    <div class="copy-field">
                                        <span id="payment-code" class="instruction-value">{{ $instructions['payment_code'] }}</span>
                                        <button class="copy-btn" data-clipboard-target="#payment-code">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="instruction-item">
                                    <span class="instruction-label">Amount</span>
                                    <div class="copy-field">
                                        <span id="e-amount" class="instruction-value">IDR {{ number_format($instructions['amount'], 0, ',', '.') }}</span>
                                        <button class="copy-btn" data-clipboard-target="#e-amount">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="epic-alert epic-alert-info mt-3">
                                <div class="epic-alert-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                </div>
                                <div class="epic-alert-content">
                                    <p><strong>Steps:</strong></p>
                                    <p>{{ $instructions['steps'] }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="epic-divider"></div>

            <div class="order-items">
                <h4>Order Items</h4>
                <div class="epic-table-responsive">
                    <table class="epic-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $subtotal = 0; @endphp
                            @foreach($orders as $orderItem)
                                @php
                                    $subtotal += $orderItem->price * $orderItem->quantity;
                                @endphp
                                <tr>
                                    <td>{{ $orderItem->product->name ?? 'Product #'.$orderItem->product_id }}</td>
                                    <td>IDR {{ number_format($orderItem->price, 0, ',', '.') }}</td>
                                    <td>{{ $orderItem->quantity }}</td>
                                    <td>IDR {{ number_format($orderItem->price * $orderItem->quantity, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Subtotal</th>
                                <td>IDR {{ number_format($subtotal, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-end">Tax (10%)</th>
                                <td>IDR {{ number_format($subtotal * 0.1, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="total-row">
                                <th colspan="3" class="text-end">Total</th>
                                <td><strong>IDR {{ number_format($subtotal + ($subtotal * 0.1), 0, ',', '.') }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="epic-card-footer">
            <div class="epic-button-group">
                <a href="{{ route('home') }}" class="epic-button epic-button-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                    Continue Shopping
                </a>
                @if(!$paymentDetail->is_paid)
                <button id="mark-as-paid-btn" class="epic-button epic-button-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    Mark as Paid
                </button>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Payment Form Modal -->
<div id="payment-modal" class="epic-modal">
    <div class="epic-modal-content">
        <div class="epic-modal-header">
            <h3>Mark Payment as Paid</h3>
            <button class="epic-modal-close">&times;</button>
        </div>
        <div class="epic-modal-body">
            <form action="{{ route('payment.markAsPaid', $cartId) }}" method="POST" id="payment-form">
                @csrf
                <div class="epic-form-group">
                    <label for="amount">Payment Amount (IDR)</label>
                    <input type="text" id="amount-input" name="amount" class="epic-input" value="{{ number_format($paymentDetail->amount, 0, ',', '.') }}" required>
                </div>

                @if($paymentDetail->payment_method == 'bank_transfer')
                <div class="epic-form-group">
                    <label for="bank_name">Bank Name</label>
                    <input type="text" id="bank_name" name="bank_name" class="epic-input" value="{{ $instructions['bank_name'] }}" readonly>
                </div>
                <div class="epic-form-group">
                    <label for="account_number">Account Number</label>
                    <input type="text" id="account_number" name="account_number" class="epic-input" value="{{ $instructions['account_number'] }}" readonly>
                </div>
                <div class="epic-form-group">
                    <label for="reference_number">Reference Number</label>
                    <input type="text" id="reference_number" name="reference_number" class="epic-input" value="{{ $instructions['reference'] }}" required>
                </div>
                @elseif($paymentDetail->payment_method == 'e_wallet')
                <div class="epic-form-group">
                    <label for="wallet_provider">E-Wallet Provider</label>
                    <input type="text" id="wallet_provider" name="wallet_provider" class="epic-input" value="{{ $instructions['wallet_provider'] }}" readonly>
                </div>
                <div class="epic-form-group">
                    <label for="payment_code">Payment Code</label>
                    <input type="text" id="payment_code" name="payment_code" class="epic-input" value="{{ $instructions['payment_code'] }}" readonly>
                </div>
                @endif

                <div class="epic-form-group">
                    <label for="payment_date">Payment Date</label>
                    <input type="datetime-local" id="payment_date" name="payment_date" class="epic-input" required>
                </div>

                <div class="epic-alert epic-alert-info">
                    <div class="epic-alert-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                    </div>
                    <div class="epic-alert-content">
                        <p>By submitting this form, you confirm that you have completed the payment according to the instructions provided.</p>
                    </div>
                </div>

                <div class="epic-form-actions">
                    <button type="button" class="epic-button epic-button-secondary modal-cancel-btn">Cancel</button>
                    <button type="submit" class="epic-button epic-button-primary">Submit Payment</button>
                </div>
            </form>
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

    /* Badge Styles */
    .epic-badge {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .epic-badge-success {
        background-color: var(--epic-success);
        color: white;
    }

    .epic-badge-warning {
        background-color: var(--epic-warning);
        color: black;
    }

    .epic-badge-danger {
        background-color: var(--epic-danger);
        color: white;
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

    .epic-button-group {
        display: flex;
        gap: 1rem;
    }

    /* Divider */
    .epic-divider {
        height: 1px;
        background-color: var(--epic-border);
        margin: 1.5rem 0;
    }

    /* Table Styles */
    .epic-table-responsive {
        overflow-x: auto;
    }

    .epic-table {
        width: 100%;
        border-collapse: collapse;
    }

    .epic-table th, .epic-table td {
        padding: 0.75rem 1rem;
        text-align: left;
        border-bottom: 1px solid var(--epic-border);
    }

    .epic-table th {
        font-weight: 600;
        color: var(--epic-text);
        background-color: rgba(0, 0, 0, 0.2);
    }

    .epic-table tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.05);
    }

    .epic-table .total-row {
        background-color: rgba(0, 120, 242, 0.1);
    }

    /* Payment Method Info */
    .payment-method-info {
        display: flex;
        align-items: flex-start;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .payment-method-icon {
        width: 3rem;
        height: 3rem;
        background-color: var(--epic-secondary);
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--epic-primary);
    }

    .payment-method-details {
        flex: 1;
    }

    .payment-method-details h4 {
        margin-top: 0;
        margin-bottom: 0.75rem;
        font-size: 1.25rem;
    }

    .payment-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .payment-info-item {
        display: flex;
        flex-direction: column;
    }

    .info-label {
        font-size: 0.875rem;
        color: var(--epic-text-secondary);
        margin-bottom: 0.25rem;
    }

    .info-value {
        font-weight: 600;
    }

    /* Payment Instructions */
    .instruction-card {
        background-color: rgba(255, 255, 255, 0.05);
    }

    .instruction-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }

    .instruction-item {
        display: flex;
        flex-direction: column;
    }

    .instruction-label {
        font-size: 0.875rem;
        color: var(--epic-text-secondary);
        margin-bottom: 0.25rem;
    }

    .instruction-value {
        font-weight: 600;
    }

    .copy-field {
        display: flex;
        align-items: center;
        background-color: rgba(255, 255, 255, 0.05);
        border-radius: 0.25rem;
        padding: 0.5rem;
    }

    .copy-field .instruction-value {
        flex: 1;
    }

    .copy-btn {
        background: none;
        border: none;
        color: var(--epic-text-secondary);
        cursor: pointer;
        padding: 0.25rem;
        border-radius: 0.25rem;
        transition: all 0.2s ease;
    }

    .copy-btn:hover {
        color: var(--epic-text);
        background-color: rgba(255, 255, 255, 0.1);
    }

    .copy-btn.copied {
        color: var(--epic-success);
    }

    /* Countdown */
    .countdown {
        color: var(--epic-warning);
        font-weight: 600;
    }

    .countdown.expired {
        color: var(--epic-danger);
    }

    /* Modal Styles */
    .epic-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        z-index: 1000;
        overflow-y: auto;
        padding: 2rem 1rem;
    }

    .epic-modal-content {
        background-color: var(--epic-bg-card);
        border-radius: 0.5rem;
        max-width: 600px;
        margin: 0 auto;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        border: 1px solid var(--epic-border);
    }

    .epic-modal-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--epic-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .epic-modal-header h3 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
    }

    .epic-modal-close {
        background: none;
        border: none;
        color: var(--epic-text-secondary);
        font-size: 1.5rem;
        cursor: pointer;
        padding: 0;
        line-height: 1;
    }

    .epic-modal-close:hover {
        color: var(--epic-text);
    }

    .epic-modal-body {
        padding: 1.5rem;
    }

    /* Form Styles */
    .epic-form-group {
        margin-bottom: 1.5rem;
    }

    .epic-form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    .epic-input, .epic-textarea, .epic-select {
        width: 100%;
        padding: 0.75rem;
        background-color: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--epic-border);
        border-radius: 0.25rem;
        color: var(--epic-text);
        font-family: inherit;
        transition: border-color 0.2s ease;
    }

    .epic-input:focus, .epic-textarea:focus, .epic-select:focus {
        outline: none;
        border-color: var(--epic-primary);
    }

    .epic-input::placeholder, .epic-textarea::placeholder {
        color: var(--epic-text-secondary);
    }

    .epic-input[readonly], .epic-textarea[readonly] {
        background-color: rgba(0, 0, 0, 0.2);
        cursor: not-allowed;
    }

    .epic-form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .epic-container {
            padding: 1rem;
        }

        .instruction-grid {
            grid-template-columns: 1fr;
        }

        .epic-button-group {
            flex-direction: column;
        }

        .epic-form-actions {
            flex-direction: column;
        }

        .epic-modal-content {
            margin: 0;
        }
    }

    /* Utility Classes */
    .mt-3 {
        margin-top: 1rem;
    }

    .text-end {
        text-align: right;
    }
</style>


<script>
    // Copy to clipboard functionality
    document.querySelectorAll('.copy-btn').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-clipboard-target');
            const textToCopy = document.querySelector(targetId).textContent;

            navigator.clipboard.writeText(textToCopy).then(() => {
                // Show success feedback
                this.classList.add('copied');
                setTimeout(() => {
                    this.classList.remove('copied');
                }, 2000);
            });
        });
    });

    // Countdown timer for expiration
    const countdownElement = document.querySelector('.countdown');
    if (countdownElement) {
        const expireTime = new Date(countdownElement.getAttribute('data-expire')).getTime();

        const countdownTimer = setInterval(function() {
            const now = new Date().getTime();
            const distance = expireTime - now;

            if (distance < 0) {
                clearInterval(countdownTimer);
                countdownElement.innerHTML = "EXPIRED";
                countdownElement.classList.add('expired');
                return;
            }

            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            countdownElement.innerHTML = `${hours}h ${minutes}m ${seconds}s remaining`;
        }, 1000);
    }

    // Modal functionality
    const modal = document.getElementById('payment-modal');
    const openModalBtn = document.getElementById('mark-as-paid-btn');
    const closeModalBtn = document.querySelector('.epic-modal-close');
    const cancelModalBtn = document.querySelector('.modal-cancel-btn');

    if (openModalBtn) {
        openModalBtn.addEventListener('click', function() {
            modal.style.display = 'block';
            // Set current date and time as default for payment date
            const now = new Date();
            const dateTimeLocal = new Date(now.getTime() - now.getTimezoneOffset() * 60000).toISOString().slice(0, 16);
            document.getElementById('payment_date').value = dateTimeLocal;
        });
    }

    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });
    }

    if (cancelModalBtn) {
        cancelModalBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });
    }

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Format amount input with thousand separators
    const amountInput = document.getElementById('amount-input');
    if (amountInput) {
        amountInput.addEventListener('input', function(e) {
            // Remove non-numeric characters
            let value = this.value.replace(/\D/g, '');

            // Format with thousand separators
            if (value) {
                value = parseInt(value).toLocaleString('id-ID');
            }

            this.value = value;
        });
    }
</script>
@endsection
