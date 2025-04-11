@extends('admin.layouts.app')

@section('title', 'Manage Orders - Admin')

@section('additional_styles')
<style>
    /* Enhanced Epic Games Inspired Admin Theme - Orders Page */
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
  /* background-color: var(--epic-black); */
  background-image: radial-gradient(circle at 25% 25%, rgba(3, 123, 252, 0.05) 0%, transparent 50%),
    radial-gradient(circle at 75% 75%, rgba(114, 9, 183, 0.05) 0%, transparent 50%);
  /* color: var(--epic-white); */
  font-family: "Segoe UI", Roboto, -apple-system, BlinkMacSystemFont, sans-serif;
  margin: 0;
  padding: 0;
  line-height: 1.6;
}

/* Typography */
h2 {
  font-size: 2.25rem;
  font-weight: 700;
  margin-bottom: 1.5rem;
  color: var(--epic-white);
  position: relative;
  padding-bottom: 0.5rem;
  letter-spacing: -0.5px;
  text-transform: uppercase;
}

h2::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 0;
  width: 80px;
  height: 4px;
  background: var(--epic-gradient);
  border-radius: 2px;
}

h2.mb-4 {
  margin-bottom: 1.5rem;
}

/* Orders Summary */
.orders-summary {
  display: flex;
  flex-wrap: wrap;
  gap: 1.5rem;
  margin-bottom: 2rem;
}

.orders-count-box {
  background: var(--epic-dark);
  border-radius: 12px;
  padding: 1.5rem;
  flex: 1;
  min-width: 250px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
  border: 1px solid var(--epic-border);
  position: relative;
  overflow: hidden;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.orders-count-box::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 3px;
  background: var(--epic-gradient);
}

.orders-count-box:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
}

.orders-count-box h3 {
  font-size: 1.25rem;
  font-weight: 600;
  margin-bottom: 1rem;
  color: var(--epic-white);
}

.orders-count-box .count {
  font-size: 3rem;
  font-weight: 700;
  color: var(--epic-blue);
  margin-bottom: 0.5rem;
  background: var(--epic-gradient);
  -webkit-background-clip: text;
  /* -webkit-text-fill-color: transparent; */
}

.orders-count-box .count-label {
  font-size: 0.9rem;
  color: var(--epic-text-secondary);
}

/* Card Styling */
.card {
  background-color: var(--epic-dark);
  border-radius: 12px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
  overflow: hidden;
  border: 1px solid var(--epic-border);
  margin-bottom: 2rem;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  position: relative;
}

.card::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 3px;
  background: var(--epic-gradient);
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
}

.card-body {
  padding: 2rem;
}

/* Order Date Header */
.order-date-header {
  margin-bottom: 1.5rem;
  position: relative;
}

.order-date-header h4 {
  font-size: 1.5rem;
  font-weight: 600;
  color: var(--epic-white);
  padding-bottom: 0.5rem;
  border-bottom: 1px solid var(--epic-border);
  display: inline-block;
}

.order-date-header h4::before {
  content: "📅";
  margin-right: 0.5rem;
}

/* Customer Email Header */
.customer-email-header {
  background-color: var(--epic-gray);
  padding: 1rem 1.5rem;
  border-radius: 8px 8px 0 0;
  margin-bottom: 0;
  border-left: 4px solid var(--epic-blue);
}

.customer-email-header h5 {
  font-size: 1.1rem;
  font-weight: 600;
  color: var(--epic-white);
  margin: 0;
  display: flex;
  align-items: center;
}

.customer-email-header h5::before {
  content: "👤";
  margin-right: 0.5rem;
}

/* Table Container */
.table-container {
  margin-bottom: 2rem;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
  border: 1px solid var(--epic-border);
}

.table-responsive {
  overflow-x: auto;
}

/* Table Styling */
.tables {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  color: var(--epic-white);
}

.tables thead {
  background-color: var(--epic-darker);
}

.tables th {
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

.tables th::after {
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

.tables thead:hover th::after {
  transform: scaleX(1);
}

.tables td {
  padding: 1.25rem 1rem;
  border-bottom: 1px solid rgba(42, 42, 42, 0.7);
  vertical-align: middle;
  transition: all 0.2s ease;
}

.tables tbody tr {
  transition: all 0.3s ease;
  position: relative;
  background-color: var(--epic-dark);
}

.tables tbody tr:hover {
  background-color: var(--epic-gray);
  transform: translateX(5px);
}

.tables tbody tr:hover td {
  color: white;
}

.tables tbody tr:last-child td {
  border-bottom: none;
}

.tables tbody tr:nth-child(odd) {
  background-color: rgba(10, 10, 10, 0.2);
}

/* Cart ID Column Styling */
.tables td:first-child {
  font-weight: 600;
  color: var(--epic-blue);
  font-family: monospace;
  font-size: 1.1rem;
}

/* Amount Column Styling */
.tables td:nth-child(2) {
  font-family: monospace;
  font-weight: 600;
  color: var(--epic-green);
}

/* Status Badges */
.badge {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 0.5rem 1rem;
  border-radius: 50px;
  font-size: 0.75rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  transition: all 0.3s ease;
}

.tables tr:hover .badge {
  transform: translateY(-3px);
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
}

.bg-success {
  background: linear-gradient(135deg, #2ecc71, #27ae60);
  color: white;
}

.bg-warning {
  background: linear-gradient(135deg, #f39c12, #e67e22);
  color: white;
}

.bg-danger {
  background: linear-gradient(135deg, #e74c3c, #c0392b);
  color: white;
}

/* Button Styling */
.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-weight: 600;
  text-align: center;
  white-space: nowrap;
  vertical-align: middle;
  user-select: none;
  border: 1px solid transparent;
  padding: 0.625rem 1.25rem;
  font-size: 0.9rem;
  line-height: 1.5;
  border-radius: 6px;
  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
  cursor: pointer;
  position: relative;
  overflow: hidden;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  text-decoration: none;
  margin-right: 0.5rem;
}

.btn::before {
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

.btn:hover::before {
  transform: translateX(0);
}

.btn-sm {
  padding: 0.375rem 0.75rem;
  font-size: 0.8rem;
  border-radius: 4px;
}

.btn-primary {
  background-color: var(--epic-blue);
  color: white;
  box-shadow: 0 4px 10px rgba(3, 123, 252, 0.2);
}

.btn-primary:hover {
  background-color: var(--epic-blue-hover);
  box-shadow: 0 6px 15px var(--epic-blue-glow);
  transform: translateY(-2px);
}

.btn-danger {
  background-color: var(--epic-red);
  color: white;
  box-shadow: 0 4px 10px rgba(230, 57, 70, 0.2);
}

.btn-danger:hover {
  background-color: var(--epic-red-hover);
  box-shadow: 0 6px 15px var(--epic-red-glow);
  transform: translateY(-2px);
}

/* Alert Styling */
.alert {
  padding: 1.5rem;
  border-radius: 8px;
  margin-bottom: 1.5rem;
  position: relative;
  overflow: hidden;
}

.alert-info {
  background-color: rgba(3, 123, 252, 0.1);
  border-left: 4px solid var(--epic-blue);
  color: var(--epic-white);
}

.alert-info::before {
  content: "ℹ️";
  margin-right: 0.5rem;
  font-size: 1.2rem;
}

/* Horizontal Rule */
hr {
  border: 0;
  height: 1px;
  background: linear-gradient(90deg, transparent, var(--epic-border), transparent);
  margin: 2rem 0;
}

hr.mt-4 {
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

/* Epic Games Logo-inspired element */
.card::after {
  content: "";
  position: absolute;
  top: 1rem;
  right: 1rem;
  width: 40px;
  height: 40px;
  background-image: linear-gradient(135deg, var(--epic-blue) 0%, var(--epic-purple) 100%);
  clip-path: polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%, 0% 80%, 80% 80%, 80% 20%, 0% 20%);
  opacity: 0.1;
}

/* Add a subtle hover effect to the entire row */
.tables tbody tr::after {
  content: "";
  position: absolute;
  left: 0;
  top: 0;
  height: 100%;
  width: 3px;
  background: var(--epic-gradient);
  opacity: 0;
  transition: opacity 0.3s ease;
}

.tables tbody tr:hover::after {
  opacity: 1;
}

/* SweetAlert Customization */
.swal2-popup {
  background-color: var(--epic-dark) !important;
  color: var(--epic-white) !important;
  border-radius: 12px !important;
  box-shadow: 0 15px 50px rgba(0, 0, 0, 0.4) !important;
  border: 1px solid var(--epic-border) !important;
  padding: 2rem !important;
}

.swal2-title {
  color: var(--epic-white) !important;
  font-weight: 700 !important;
  font-size: 1.75rem !important;
}

.swal2-content {
  color: var(--epic-text-secondary) !important;
  font-size: 1.1rem !important;
}

.swal2-confirm {
  background: var(--epic-red) !important;
  box-shadow: 0 4px 15px var(--epic-red-glow) !important;
  border-radius: 6px !important;
  padding: 0.75rem 1.5rem !important;
  font-weight: 600 !important;
  text-transform: uppercase !important;
  letter-spacing: 0.5px !important;
  transition: all 0.2s ease !important;
}

.swal2-confirm:hover {
  transform: translateY(-2px) !important;
  box-shadow: 0 6px 20px var(--epic-red-glow) !important;
}

.swal2-cancel {
  background: var(--epic-blue) !important;
  box-shadow: 0 4px 15px var(--epic-blue-glow) !important;
  border-radius: 6px !important;
  padding: 0.75rem 1.5rem !important;
  font-weight: 600 !important;
  text-transform: uppercase !important;
  letter-spacing: 0.5px !important;
  transition: all 0.2s ease !important;
}

.swal2-cancel:hover {
  transform: translateY(-2px) !important;
  box-shadow: 0 6px 20px var(--epic-blue-glow) !important;
}

.swal2-icon {
  border-color: var(--epic-yellow) !important;
  color: var(--epic-yellow) !important;
}

/* Responsive adjustments */
@media (max-width: 992px) {
  .card-body {
    padding: 1.5rem;
  }

  .table th,
  .table td {
    padding: 1rem 0.75rem;
  }

  h2 {
    font-size: 2rem;
  }

  .orders-count-box .count {
    font-size: 2.5rem;
  }
}

@media (max-width: 768px) {
  .tables th,
  .tables td {
    padding: 0.75rem 0.5rem;
    font-size: 0.9rem;
  }

  h2 {
    font-size: 1.75rem;
  }

  .card::after {
    display: none;
  }

  .tables tbody tr:hover {
    transform: none;
  }

  .order-date-header h4 {
    font-size: 1.25rem;
  }

  .customer-email-header h5 {
    font-size: 1rem;
  }

  .orders-count-box {
    padding: 1.25rem;
  }

  .orders-count-box .count {
    font-size: 2.25rem;
  }
}

@media (max-width: 576px) {
  .card-body {
    padding: 1rem;
  }

  .tables th {
    font-size: 0.7rem;
  }

  .tables td {
    font-size: 0.8rem;
  }

  .btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
    margin-bottom: 0.5rem;
    display: block;
    width: 100%;
    margin-right: 0;
  }

  .badge {
    padding: 0.35rem 0.7rem;
    font-size: 0.7rem;
  }

  .orders-count-box .count {
    font-size: 2rem;
  }
}

/* Order-specific animations */
@keyframes pulse {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.05);
  }
  100% {
    transform: scale(1);
  }
}

.orders-count-box:hover .count {
  animation: pulse 1.5s infinite;
}

/* Epic Games inspired focus styles */
*:focus {
  outline: none;
  box-shadow: 0 0 0 3px var(--epic-blue-glow);
}

/* Add a cool hover effect for the date headers */
.order-date-header h4 {
  position: relative;
  transition: all 0.3s ease;
}

.order-date-header h4:hover {
  color: var(--epic-blue);
  transform: translateX(5px);
}

/* Add a cool hover effect for the customer headers */
.customer-email-header {
  transition: all 0.3s ease;
}

.customer-email-header:hover {
  background-color: var(--epic-light-gray);
  border-left-width: 8px;
}

/* Add a subtle glow effect to the orders count box */
.orders-count-box {
  position: relative;
  overflow: hidden;
}

.orders-count-box::after {
  content: "";
  position: absolute;
  top: -50%;
  left: -50%;
  width: 200%;
  height: 200%;
  background: radial-gradient(circle, rgba(3, 123, 252, 0.1) 0%, transparent 70%);
  opacity: 0;
  transition: opacity 0.5s ease;
}

.orders-count-box:hover::after {
  opacity: 1;
}

</style>
@endsection

@section('content')
<h2 class="mb-4">Manage Orders</h2>

<div class="orders-summary">
    <div class="orders-count-box">
        <h3>Total Orders</h3>
        <div class="count">{{ $cartOrdersCount }}</div>
        <div class="count-label">Total orders in system</div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if(empty($allGroupedOrders))
            <div class="alert alert-info">No orders found.</div>
        @else
            @foreach($allGroupedOrders as $date => $users)
                <div class="order-date-header">
                    <h4>Orders for {{ date('d F Y', strtotime($date)) }}</h4>
                </div>

                @foreach($users as $email => $orders)
                    <div class="table-container">
                        <div class="customer-email-header">
                            <h5>Customer: {{ $email }}</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="tables">
                                <thead>
                                    <tr>
                                        <th>Cart ID</th>
                                        {{-- <th>Product ID</th> --}}
                                        <th>Total Amount</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td> <!-- Now displays cart_id -->
                                            {{-- <td>{{ $order->product_id }}</td> --}}
                                            <td>IDR {{ number_format($order->amount, 0) }}</td>
                                            <td>
                                                <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.orders.cart-detail', $order->id) }}" class="btn btn-sm btn-primary">
                                                    View Details
                                                </a>
                                                <button onclick="deleteOrder('{{ $order->id }}')" class="btn btn-sm btn-danger">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
                <hr class="mt-4">
            @endforeach
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
function deleteOrder(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('admin.orders.delete') }}';
            form.style.display = 'none';

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';

            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';

            const idField = document.createElement('input');
            idField.type = 'hidden';
            idField.name = 'cart_id'; // Changed to cart_id
            idField.value = id;

            form.appendChild(csrfToken);
            form.appendChild(methodField);
            form.appendChild(idField);
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endsection
