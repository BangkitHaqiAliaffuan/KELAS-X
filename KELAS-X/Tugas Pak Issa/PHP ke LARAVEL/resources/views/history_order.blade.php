@extends('layouts.app')

@section('content')
<div class="epic-container">
    <div class="epic-header">
        <h1>Order History</h1>
        <p class="epic-subtitle">View and manage your previous purchases</p>
    </div>

    @if(session('success'))
        <div class="epic-alert epic-alert-success">
            <div class="epic-alert-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            </div>
            <div class="epic-alert-content">
                {{ session('success') }}
            </div>
        </div>
    @endif

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

    <div class="epic-card">
        <div class="epic-card-header">
            <h2>Your Orders</h2>
            <div class="epic-filter">
                <select id="order-filter" class="epic-select">
                    <option value="all">All Orders</option>
                    <option value="completed">Completed</option>
                    <option value="pending">Pending</option>
                </select>
            </div>
        </div>
        <div class="epic-card-body">
            @if(isset($orders) && count($orders) > 0)
                <div class="epic-orders-list">
                    @foreach($orders as $order)
                        <div class="epic-order-item" data-status="{{ $order->payment && $order->payment->is_paid ? 'completed' : 'pending' }}">
                            <div class="epic-order-header">
                                <div class="epic-order-info">
                                    <div class="epic-order-id">
                                        <span class="epic-label">Order ID:</span>
                                        <span class="epic-value">{{ $order->cart_id}}</span>
                                    </div>
                                    <div class="epic-order-date">
                                        <span class="epic-label">Date:</span>
                                        <span class="epic-value">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, H:i') }}</span>
                                    </div>
                                </div>
                                <div class="epic-order-status">
                                    <div class="epic-badge epic-badge-{{ $order->payment && $order->payment->is_paid ? 'success' : 'warning' }}">
                                        {{ $order->payment && $order->payment->is_paid ? 'Completed' : 'Pending' }}
                                    </div>
                                </div>
                            </div>

                            <div class="epic-order-details">
                                @if(isset($order->items) && $order->items->count() > 0)
                                <div class="epic-order-items">
                                    @foreach($order->items as $item)
                                        <div class="epic-game-item">
                                            <div class="epic-game-thumbnail">
                                                <div class="game-thumbnail" style="background-color: #2a2a2a;">
                                                    <span>{{ $item->product ? substr($item->product->name, 0, 1) : 'G' }}</span>
                                                </div>
                                            </div>
                                            <div class="epic-game-info">
                                                <h4>{{ $item->product ? $item->product->name : 'Product #'.$item->product_id }}</h4>
                                                <span class="epic-game-platform">PC Digital Download</span>
                                            </div>
                                            <div class="epic-game-price">
                                                IDR {{ number_format($item->price, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="epic-order-summary">
                                    <div class="epic-summary-row">
                                        <span>Total Items:</span>
                                        <span>{{ $order->items->count() }}</span>
                                    </div>
                                    <div class="epic-summary-row">
                                        <span>Payment Method:</span>
                                        <span>{{ $order->payment ? ucfirst(str_replace('_', ' ', $order->payment_method ?? 'N/A')) : 'N/A' }}</span>
                                    </div>
                                    <div class="epic-summary-row epic-total">
                                        <span>Total:</span>
                                        <span>IDR {{ number_format($order->payment ? ($order->payment->amount ?? $order->items->sum('price')) : $order->items->sum('price'), 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                @else
                                <div class="epic-empty-state">
                                    <p>No items found for this order.</p>
                                </div>
                                @endif
                            </div>

                            <div class="epic-order-actions">
                                <a href="{{ route('payment.show', $order->cart_id) }}" class="epic-button epic-button-secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    View Details
                                </a>
                                @if(!$order->payment || !$order->payment->is_paid)
                                    <a href="{{ route('payment.show', $order->cart_id) }}" class="epic-button epic-button-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"></rect><line x1="2" y1="10" x2="22" y2="10"></line></svg>
                                        Complete Payment
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="epic-empty-state">
                    <div class="epic-empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                    </div>
                    <h3>No Orders Found</h3>
                    <p>You haven't made any purchases yet.</p>
                    <a href="{{ route('home') }}" class="epic-button epic-button-primary">
                        Browse Games
                    </a>
                </div>
            @endif
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
        margin-bottom: 0.5rem;
        color: var(--epic-text);
    }

    .epic-subtitle {
        color: var(--epic-text-secondary);
        font-size: 1.1rem;
        margin-top: 0;
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

    /* Select Styles */
    .epic-select {
        background-color: var(--epic-secondary);
        color: var(--epic-text);
        border: 1px solid var(--epic-border);
        border-radius: 0.25rem;
        padding: 0.5rem 2rem 0.5rem 0.75rem;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23ffffff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.5rem center;
        background-size: 1rem;
        cursor: pointer;
    }

    .epic-select:focus {
        outline: none;
        border-color: var(--epic-primary);
    }

    /* Order List Styles */
    .epic-orders-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .epic-order-item {
        background-color: rgba(255, 255, 255, 0.03);
        border-radius: 0.5rem;
        border: 1px solid var(--epic-border);
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .epic-order-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .epic-order-header {
        padding: 1rem 1.5rem;
        background-color: rgba(0, 0, 0, 0.2);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .epic-order-info {
        display: flex;
        gap: 1.5rem;
    }

    .epic-order-id, .epic-order-date {
        display: flex;
        flex-direction: column;
    }

    .epic-label {
        font-size: 0.75rem;
        color: var(--epic-text-secondary);
    }

    .epic-value {
        font-weight: 600;
    }

    .epic-order-details {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .epic-order-items {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .epic-game-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--epic-border);
    }

    .epic-game-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .epic-game-thumbnail {
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

    .epic-game-info {
        flex: 1;
    }

    .epic-game-info h4 {
        margin: 0 0 0.25rem 0;
        font-size: 1rem;
    }

    .epic-game-platform {
        font-size: 0.875rem;
        color: var(--epic-text-secondary);
    }

    .epic-game-price {
        font-weight: 600;
    }

    .epic-order-summary {
        background-color: rgba(0, 0, 0, 0.2);
        padding: 1rem;
        border-radius: 0.5rem;
    }

    .epic-summary-row {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
    }

    .epic-total {
        font-weight: 700;
        font-size: 1.125rem;
        margin-top: 0.5rem;
        padding-top: 0.5rem;
        border-top: 1px solid var(--epic-border);
    }

    .epic-order-actions {
        padding: 1rem 1.5rem;
        background-color: rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
    }

    /* Empty State */
    .epic-empty-state {
        text-align: center;
        padding: 3rem 1rem;
    }

    .epic-empty-icon {
        margin-bottom: 1.5rem;
        color: var(--epic-text-secondary);
    }

    .epic-empty-state h3 {
        margin-top: 0;
        margin-bottom: 0.5rem;
    }

    .epic-empty-state p {
        color: var(--epic-text-secondary);
        margin-bottom: 1.5rem;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .epic-container {
            padding: 1rem;
        }

        .epic-header h1 {
            font-size: 2rem;
        }

        .epic-order-info {
            flex-direction: column;
            gap: 0.5rem;
        }

        .epic-order-actions {
            flex-direction: column;
        }

        .epic-button {
            width: 100%;
        }
    }
</style>

<script>
    // Filter functionality
    document.getElementById('order-filter').addEventListener('change', function() {
        const filterValue = this.value;
        const orderItems = document.querySelectorAll('.epic-order-item');

        orderItems.forEach(item => {
            if (filterValue === 'all' || item.dataset.status === filterValue) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });
</script>
@endsection
