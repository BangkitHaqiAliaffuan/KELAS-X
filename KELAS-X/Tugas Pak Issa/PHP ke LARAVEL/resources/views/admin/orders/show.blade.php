@extends('admin.layouts.app')
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
                <a href="{{ route('admin.orders') }}" class="epic-button epic-button-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                    Back to order
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
    /* Enhanced Epic Games Inspired Admin Theme - Order Details Page */
:root {
  --epic-black: #121212;
  --epic-dark: #202020;
  --epic-darker: #0a0a0a;
  --epic-gray: #2a2a2a;
  --epic-light-gray: #3a3a3a;
  --epic-blue: #037bfc;
  --epic-blue-hover: #0366d6;
  --epic-blue-glow: rgba(3, 123, 252, 0.4);
  --epic-red: #e63946;
  --epic-red-hover: #d32f2f;
  --epic-red-glow: rgba(230, 57, 70, 0.4);
  --epic-white: #f5f5f5;
  --epic-text-secondary: #a0a0a0;
  --epic-border: #333333;
  --epic-yellow: #ffb703;
  --epic-purple: #7209b7;
  --epic-green: #2ecc71;
  --epic-orange: #f39c12;
  --epic-gradient: linear-gradient(135deg, #037bfc 0%, #7209b7 100%);
}

/* Base Styles */
body {
  background-color: var(--epic-black);
  background-image: radial-gradient(circle at 25% 25%, rgba(3, 123, 252, 0.05) 0%, transparent 50%),
    radial-gradient(circle at 75% 75%, rgba(114, 9, 183, 0.05) 0%, transparent 50%);
  color: var(--epic-white);
  font-family: "Segoe UI", Roboto, -apple-system, BlinkMacSystemFont, sans-serif;
  margin: 0;
  padding: 0;
  line-height: 1.6;
}

/* Container */
.epic-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem 1rem;
}

/* Alert Styling */
.epic-alert {
  display: flex;
  align-items: flex-start;
  padding: 1.25rem;
  border-radius: 10px;
  margin-bottom: 1.5rem;
  position: relative;
  overflow: hidden;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
  animation: slideInDown 0.4s ease-out;
}

@keyframes slideInDown {
  from {
    transform: translateY(-20px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

.epic-alert::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 4px;
  height: 100%;
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

.epic-alert-content h4 {
  margin-top: 0;
  margin-bottom: 0.5rem;
  font-weight: 600;
  font-size: 1.1rem;
}

.epic-alert-content p {
  margin: 0;
  color: var(--epic-text-secondary);
}

.epic-alert-success {
  background-color: rgba(46, 204, 113, 0.1);
  border: 1px solid rgba(46, 204, 113, 0.2);
}

.epic-alert-success::before {
  background-color: var(--epic-green);
}

.epic-alert-success .epic-alert-icon {
  color: var(--epic-green);
}

.epic-alert-danger {
  background-color: rgba(230, 57, 70, 0.1);
  border: 1px solid rgba(230, 57, 70, 0.2);
}

.epic-alert-danger::before {
  background-color: var(--epic-red);
}

.epic-alert-danger .epic-alert-icon {
  color: var(--epic-red);
}

.epic-alert-info {
  background-color: rgba(3, 123, 252, 0.1);
  border: 1px solid rgba(3, 123, 252, 0.2);
}

.epic-alert-info::before {
  background-color: var(--epic-blue);
}

.epic-alert-info .epic-alert-icon {
  color: var(--epic-blue);
}

.epic-alert-warning {
  background-color: rgba(255, 183, 3, 0.1);
  border: 1px solid rgba(255, 183, 3, 0.2);
}

.epic-alert-warning::before {
  background-color: var(--epic-yellow);
}

.epic-alert-warning .epic-alert-icon {
  color: var(--epic-yellow);
}

.mt-3 {
  margin-top: 1rem;
}

/* Card Styling */
.epic-card {
  background-color: var(--epic-dark);
  border-radius: 12px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
  overflow: hidden;
  border: 1px solid var(--epic-border);
  margin-bottom: 2rem;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  position: relative;
}

.epic-card::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 3px;
  background: var(--epic-gradient);
}

.payment-details-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
}

.epic-card-header {
  padding: 1.5rem 2rem;
  border-bottom: 1px solid var(--epic-border);
  display: flex;
  align-items: center;
  justify-content: space-between;
  background-color: rgba(10, 10, 10, 0.3);
}

.epic-card-header h2 {
  margin: 0;
  font-size: 1.75rem;
  font-weight: 700;
  color: var(--epic-white);
  position: relative;
}

.epic-card-body {
  padding: 2rem;
}

.epic-card-footer {
  padding: 1.5rem 2rem;
  border-top: 1px solid var(--epic-border);
  background-color: rgba(10, 10, 10, 0.3);
}

/* Badge Styling */
.epic-badge {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 0.5rem 1.25rem;
  border-radius: 50px;
  font-size: 0.8rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  transition: all 0.3s ease;
}

.epic-badge-success {
  background: linear-gradient(135deg, #2ecc71, #27ae60);
  color: white;
}

.epic-badge-warning {
  background: linear-gradient(135deg, #f39c12, #e67e22);
  color: white;
}

.epic-badge-danger {
  background: linear-gradient(135deg, #e74c3c, #c0392b);
  color: white;
}

/* Payment Method Info */
.payment-method-info {
  display: flex;
  align-items: center;
  background-color: var(--epic-gray);
  padding: 1.5rem;
  border-radius: 10px;
  margin-bottom: 1.5rem;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.payment-method-icon {
  width: 60px;
  height: 60px;
  background: var(--epic-gradient);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 1.5rem;
  flex-shrink: 0;
  box-shadow: 0 6px 15px rgba(3, 123, 252, 0.3);
}

.payment-method-icon svg {
  width: 30px;
  height: 30px;
  color: white;
}

.payment-method-details {
  flex: 1;
}

.payment-method-details h4 {
  margin-top: 0;
  margin-bottom: 1rem;
  font-size: 1.25rem;
  font-weight: 600;
  color: var(--epic-white);
}

.payment-info-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1.5rem;
}

.payment-info-item {
  display: flex;
  flex-direction: column;
}

.info-label {
  font-size: 0.85rem;
  color: var(--epic-text-secondary);
  margin-bottom: 0.5rem;
}

.info-value {
  font-size: 1.1rem;
  font-weight: 600;
  color: var(--epic-white);
}

.countdown {
  position: relative;
  transition: all 0.3s ease;
}

.countdown.expired {
  color: var(--epic-red);
  font-weight: 700;
}

/* Divider */
.epic-divider {
  height: 1px;
  background: linear-gradient(90deg, transparent, var(--epic-border), transparent);
  margin: 2rem 0;
}

/* Payment Instructions */
.payment-instructions h4,
.order-items h4 {
  margin-top: 0;
  margin-bottom: 1.25rem;
  font-size: 1.25rem;
  font-weight: 600;
  color: var(--epic-white);
  position: relative;
  padding-left: 1.5rem;
}

.payment-instructions h4::before {
  content: "";
  position: absolute;
  left: 0;
  top: 50%;
  transform: translateY(-50%);
  width: 8px;
  height: 8px;
  background: var(--epic-blue);
  border-radius: 50%;
  box-shadow: 0 0 10px var(--epic-blue-glow);
}

.order-items h4::before {
  content: "";
  position: absolute;
  left: 0;
  top: 50%;
  transform: translateY(-50%);
  width: 8px;
  height: 8px;
  background: var(--epic-purple);
  border-radius: 50%;
  box-shadow: 0 0 10px rgba(114, 9, 183, 0.4);
}

.instruction-card {
  background-color: var(--epic-gray);
  box-shadow: none;
  margin-bottom: 0;
}

.instruction-card::before {
  display: none;
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
  font-size: 0.85rem;
  color: var(--epic-text-secondary);
  margin-bottom: 0.5rem;
}

.instruction-value {
  font-size: 1.1rem;
  font-weight: 600;
  color: var(--epic-white);
  word-break: break-all;
}

/* Copy Field */
.copy-field {
  display: flex;
  align-items: center;
  background-color: rgba(10, 10, 10, 0.3);
  border-radius: 6px;
  padding: 0.75rem 1rem;
  position: relative;
  overflow: hidden;
}

.copy-field .instruction-value {
  flex: 1;
  margin: 0;
}

.copy-btn {
  background: none;
  border: none;
  color: var(--epic-text-secondary);
  cursor: pointer;
  padding: 0.25rem;
  margin-left: 0.5rem;
  border-radius: 4px;
  transition: all 0.2s ease;
}

.copy-btn:hover {
  color: var(--epic-blue);
  background-color: rgba(3, 123, 252, 0.1);
}

.copy-btn.copied {
  color: var(--epic-green);
  background-color: rgba(46, 204, 113, 0.1);
}

.copy-btn.copied::after {
  content: "Copied!";
  position: absolute;
  top: -30px;
  right: 0;
  background-color: var(--epic-green);
  color: white;
  padding: 0.25rem 0.5rem;
  border-radius: 4px;
  font-size: 0.75rem;
  animation: fadeOut 2s forwards;
}

@keyframes fadeOut {
  0% {
    opacity: 1;
  }
  70% {
    opacity: 1;
  }
  100% {
    opacity: 0;
  }
}

/* Table Styling */
.epic-table-responsive {
  overflow-x: auto;
  border-radius: 8px;
  background: rgba(10, 10, 10, 0.3);
  padding: 0.5rem;
}

.epic-table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  color: var(--epic-white);
}

.epic-table thead {
  background-color: var(--epic-darker);
}

.epic-table th {
  padding: 1.25rem 1rem;
  text-align: left;
  font-weight: 600;
  text-transform: uppercase;
  font-size: 0.8rem;
  letter-spacing: 1px;
  color: var(--epic-blue);
  border-bottom: 2px solid var(--epic-blue);
  position: relative;
}

.epic-table th::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 2px;
  background: var(--epic-gradient);
  transform: scaleX(0);
  transition: transform 0.3s ease;
}

.epic-table thead:hover th::after {
  transform: scaleX(1);
}

.epic-table td {
  padding: 1.25rem 1rem;
  border-bottom: 1px solid rgba(42, 42, 42, 0.7);
  vertical-align: middle;
  transition: all 0.2s ease;
}

.epic-table tbody tr {
  transition: all 0.3s ease;
  position: relative;
}

.epic-table tbody tr:hover {
  background-color: var(--epic-gray);
}

.epic-table tbody tr:hover td {
  color: white;
}

.epic-table tbody tr:last-child td {
  border-bottom: none;
}

.epic-table tbody tr:nth-child(odd) {
  background-color: rgba(10, 10, 10, 0.2);
}

.epic-table tfoot tr {
  background-color: var(--epic-darker);
}

.epic-table tfoot th,
.epic-table tfoot td {
  padding: 1rem;
  font-weight: 600;
}

.epic-table tfoot .total-row {
  background: linear-gradient(90deg, rgba(3, 123, 252, 0.1), rgba(114, 9, 183, 0.1));
}

.epic-table tfoot .total-row th,
.epic-table tfoot .total-row td {
  padding: 1.25rem 1rem;
  font-size: 1.1rem;
}

.epic-table tfoot .total-row td strong {
  color: var(--epic-blue);
  font-size: 1.2rem;
}

.text-end {
  text-align: right;
}

/* Button Styling */
.epic-button-group {
  display: flex;
  gap: 1rem;
  justify-content: flex-end;
}

.epic-button {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-weight: 600;
  text-align: center;
  white-space: nowrap;
  vertical-align: middle;
  user-select: none;
  border: 1px solid transparent;
  padding: 0.75rem 1.5rem;
  font-size: 0.95rem;
  line-height: 1.5;
  border-radius: 6px;
  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
  cursor: pointer;
  position: relative;
  overflow: hidden;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  text-decoration: none;
}

.epic-button svg {
  margin-right: 0.5rem;
}

.epic-button::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.1);
  transform: translateX(-100%);
  transition: transform 0.3s ease;
}

.epic-button:hover::before {
  transform: translateX(0);
}

.epic-button-primary {
  background: var(--epic-gradient);
  color: white;
  box-shadow: 0 4px 10px var(--epic-blue-glow);
}

.epic-button-primary:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 15px var(--epic-blue-glow);
}

.epic-button-secondary {
  background-color: var(--epic-gray);
  color: var(--epic-white);
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.epic-button-secondary:hover {
  background-color: var(--epic-light-gray);
  transform: translateY(-3px);
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
}

/* Modal Styling */
.epic-modal {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.7);
  z-index: 1000;
  overflow: auto;
  backdrop-filter: blur(5px);
  animation: fadeIn 0.3s ease-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

.epic-modal-content {
  background-color: var(--epic-dark);
  margin: 5% auto;
  width: 90%;
  max-width: 600px;
  border-radius: 12px;
  box-shadow: 0 15px 50px rgba(0, 0, 0, 0.4);
  border: 1px solid var(--epic-border);
  position: relative;
  overflow: hidden;
  animation: slideUp 0.4s ease-out;
}

@keyframes slideUp {
  from {
    transform: translateY(50px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

.epic-modal-content::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 3px;
  background: var(--epic-gradient);
}

.epic-modal-header {
  padding: 1.5rem 2rem;
  border-bottom: 1px solid var(--epic-border);
  display: flex;
  align-items: center;
  justify-content: space-between;
  background-color: rgba(10, 10, 10, 0.3);
}

.epic-modal-header h3 {
  margin: 0;
  font-size: 1.5rem;
  font-weight: 600;
  color: var(--epic-white);
}

.epic-modal-close {
  background: none;
  border: none;
  color: var(--epic-text-secondary);
  font-size: 1.5rem;
  cursor: pointer;
  transition: all 0.2s ease;
}

.epic-modal-close:hover {
  color: var(--epic-white);
}

.epic-modal-body {
  padding: 2rem;
}

/* Form Styling */
.epic-form-group {
  margin-bottom: 1.5rem;
}

.epic-form-group label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 500;
  color: var(--epic-white);
}

.epic-input {
  width: 100%;
  padding: 0.75rem 1rem;
  font-size: 1rem;
  background-color: var(--epic-gray);
  border: 1px solid var(--epic-border);
  border-radius: 6px;
  color: var(--epic-white);
  transition: all 0.2s ease;
}

.epic-input:focus {
  outline: none;
  border-color: var(--epic-blue);
  box-shadow: 0 0 0 3px var(--epic-blue-glow);
}

.epic-input[readonly] {
  background-color: rgba(10, 10, 10, 0.3);
  cursor: not-allowed;
}

.epic-form-actions {
  display: flex;
  justify-content: flex-end;
  gap: 1rem;
  margin-top: 2rem;
}

/* Custom scrollbar */
::-webkit-scrollbar {
  width: 10px;
  height: 10px;
}

::-webkit-scrollbar-track {
  background: var(--epic-darker);
  border-radius: 5px;
}

::-webkit-scrollbar-thumb {
  background: var(--epic-blue);
  border-radius: 5px;
  background-image: var(--epic-gradient);
}

::-webkit-scrollbar-thumb:hover {
  background: var(--epic-blue-hover);
}

/* Responsive adjustments */
@media (max-width: 992px) {
  .epic-card-body {
    padding: 1.5rem;
  }

  .epic-table th,
  .epic-table td {
    padding: 1rem 0.75rem;
  }

  .payment-method-info {
    padding: 1.25rem;
  }

  .payment-method-icon {
    width: 50px;
    height: 50px;
  }

  .payment-method-icon svg {
    width: 25px;
    height: 25px;
  }
}

@media (max-width: 768px) {
  .epic-container {
    padding: 1.5rem 1rem;
  }

  .epic-card-header {
    padding: 1.25rem 1.5rem;
    flex-direction: column;
    align-items: flex-start;
    gap: 1rem;
  }

  .epic-card-body {
    padding: 1.25rem;
  }

  .epic-card-footer {
    padding: 1.25rem 1.5rem;
  }

  .epic-table th,
  .epic-table td {
    padding: 0.75rem 0.5rem;
    font-size: 0.9rem;
  }

  .payment-method-info {
    flex-direction: column;
    align-items: flex-start;
    gap: 1rem;
  }

  .payment-method-icon {
    margin-right: 0;
  }

  .payment-info-grid,
  .instruction-grid {
    grid-template-columns: 1fr;
    gap: 1rem;
  }

  .epic-button-group {
    flex-direction: column;
    width: 100%;
  }

  .epic-button {
    width: 100%;
  }
}

@media (max-width: 576px) {
  .epic-card-body {
    padding: 1rem;
  }

  .epic-table th {
    font-size: 0.7rem;
  }

  .epic-table td {
    font-size: 0.8rem;
  }

  .epic-modal-content {
    width: 95%;
    margin: 10% auto;
  }

  .epic-modal-header {
    padding: 1rem 1.5rem;
  }

  .epic-modal-body {
    padding: 1.5rem;
  }
}

/* Animation for the payment method icon */
@keyframes pulse {
  0% {
    transform: scale(1);
    box-shadow: 0 6px 15px rgba(3, 123, 252, 0.3);
  }
  50% {
    transform: scale(1.05);
    box-shadow: 0 8px 20px rgba(3, 123, 252, 0.4);
  }
  100% {
    transform: scale(1);
    box-shadow: 0 6px 15px rgba(3, 123, 252, 0.3);
  }
}

.payment-method-info:hover .payment-method-icon {
  animation: pulse 1.5s infinite;
}

/* Epic Games inspired focus styles */
*:focus {
  outline: none;
  box-shadow: 0 0 0 3px var(--epic-blue-glow);
}

/* Add a subtle glow effect to the copy fields */
.copy-field {
  transition: all 0.3s ease;
}

.copy-field:hover {
  background-color: rgba(42, 42, 42, 0.7);
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
}

/* Add a cool hover effect for the "Mark as Paid" button */
#mark-as-paid-btn {
  position: relative;
  overflow: hidden;
  z-index: 1;
}

#mark-as-paid-btn::after {
  content: "";
  position: absolute;
  top: -50%;
  left: -50%;
  width: 200%;
  height: 200%;
  background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 50%);
  opacity: 0;
  transform: scale(0.5);
  transition: transform 0.5s ease, opacity 0.5s ease;
  z-index: -1;
}

#mark-as-paid-btn:hover::after {
  opacity: 1;
  transform: scale(1);
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
