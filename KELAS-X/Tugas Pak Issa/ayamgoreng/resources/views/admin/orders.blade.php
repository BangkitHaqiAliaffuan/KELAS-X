@extends('layouts.admin')

@section('content')
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Orders Management - Ayam Goreng JOSS</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
            rel="stylesheet">
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Poppins', sans-serif;
            }

            :root {
                --primary-color: #ff6b00;
                --primary-dark: #d84315;
                --primary-light: #ffab40;
                --accent-color: #e65100;
                --text-dark: #333333;
                --text-light: #f9f9f9;
                --background-light: #f8f9fa;
                --background-dark: #263238;
                --success-color: #4caf50;
                --warning-color: #ff9800;
                --danger-color: #f44336;
                --info-color: #2196f3;
                --border-color: #e0e0e0;
                --card-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                --hover-transition: all 0.3s ease;
            }

            body {
                background-color: var(--background-light);
                color: var(--text-dark);
                min-height: 100vh;
                display: flex;
                overflow-x: hidden;
            }

            /* Sidebar styles are the same as in dashboard.blade.php */
            /* Main Content styles are the same as in dashboard.blade.php */

            /* Orders Page Specific Styles */
            .orders-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 20px;
            }

            .orders-filters {
                display: flex;
                gap: 15px;
                margin-bottom: 20px;
                flex-wrap: wrap;
            }

            .filter-group {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .filter-label {
                font-weight: 500;
                font-size: 0.9rem;
            }

            .filter-select {
                padding: 8px 12px;
                border: 1px solid var(--border-color);
                border-radius: 6px;
                font-size: 0.9rem;
                background-color: white;
            }

            .filter-select:focus {
                outline: none;
                border-color: var(--primary-color);
            }

            .filter-date {
                padding: 8px 12px;
                border: 1px solid var(--border-color);
                border-radius: 6px;
                font-size: 0.9rem;
            }

            .filter-date:focus {
                outline: none;
                border-color: var(--primary-color);
            }

            .filter-button {
                padding: 8px 15px;
                background-color: var(--primary-color);
                color: white;
                border: none;
                border-radius: 6px;
                font-weight: 500;
                cursor: pointer;
                transition: var(--hover-transition);
                display: flex;
                align-items: center;
                gap: 5px;
            }

            .filter-button:hover {
                background-color: var(--primary-dark);
            }

            .reset-button {
                padding: 8px 15px;
                background-color: #f1f1f1;
                color: var(--text-dark);
                border: none;
                border-radius: 6px;
                font-weight: 500;
                cursor: pointer;
                transition: var(--hover-transition);
            }

            .reset-button:hover {
                background-color: #e0e0e0;
            }

            .orders-table-container {
                background-color: white;
                border-radius: 10px;
                box-shadow: var(--card-shadow);
                overflow: hidden;
                margin-bottom: 20px;
            }

            .orders-table {
                width: 100%;
                border-collapse: collapse;
            }

            .orders-table th,
            .orders-table td {
                padding: 15px;
                text-align: left;
                border-bottom: 1px solid var(--border-color);
            }

            .orders-table th {
                font-weight: 600;
                color: #555;
                background-color: #f9f9f9;
            }

            .orders-table tr:last-child td {
                border-bottom: none;
            }

            .orders-table tr:hover td {
                background-color: #f9f9f9;
            }

            .order-id {
                font-weight: 600;
                color: var(--primary-color);
            }

            .order-customer {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .customer-avatar {
                width: 30px;
                height: 30px;
                border-radius: 50%;
                background-color: var(--primary-light);
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-weight: 600;
                font-size: 0.8rem;
            }

            .order-status {
                display: inline-block;
                padding: 5px 10px;
                border-radius: 50px;
                font-size: 0.8rem;
                font-weight: 500;
            }

            .status-pending {
                background-color: rgba(255, 152, 0, 0.1);
                color: var(--warning-color);
            }

            .status-processing {
                background-color: rgba(33, 150, 243, 0.1);
                color: var(--info-color);
            }

            .status-completed {
                background-color: rgba(76, 175, 80, 0.1);
                color: var(--success-color);
            }

            .status-cancelled {
                background-color: rgba(244, 67, 54, 0.1);
                color: var(--danger-color);
            }

            .order-actions {
                display: flex;
                gap: 10px;
            }

            .action-icon {
                width: 30px;
                height: 30px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #555;
                background-color: #f1f1f1;
                cursor: pointer;
                transition: var(--hover-transition);
            }

            .action-icon:hover {
                background-color: var(--primary-color);
                color: white;
            }

            .action-icon.view:hover {
                background-color: var(--info-color);
            }

            .action-icon.edit:hover {
                background-color: var(--warning-color);
            }

            .action-icon.delete:hover {
                background-color: var(--danger-color);
            }

            .pagination {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 15px;
                background-color: white;
                border-top: 1px solid var(--border-color);
            }

            .pagination-info {
                font-size: 0.9rem;
                color: #666;
            }

            .pagination-controls {
                display: flex;
                gap: 5px;
            }

            .pagination-button {
                width: 35px;
                height: 35px;
                display: flex;
                align-items: center;
                justify-content: center;
                border: 1px solid var(--border-color);
                border-radius: 6px;
                background-color: white;
                color: var(--text-dark);
                font-weight: 500;
                cursor: pointer;
                transition: var(--hover-transition);
            }

            .pagination-button:hover {
                background-color: #f1f1f1;
            }

            .pagination-button.active {
                background-color: var(--primary-color);
                color: white;
                border-color: var(--primary-color);
            }

            .pagination-button.disabled {
                opacity: 0.5;
                cursor: not-allowed;
            }

            /* Order Detail Modal */
            .modal {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 1000;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            }

            .modal.active {
                opacity: 1;
                visibility: visible;
            }

            .modal-content {
                background-color: white;
                border-radius: 10px;
                width: 90%;
                max-width: 800px;
                max-height: 90vh;
                overflow-y: auto;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
                transform: translateY(20px);
                transition: all 0.3s ease;
            }

            .modal.active .modal-content {
                transform: translateY(0);
            }

            .modal-header {
                padding: 20px;
                border-bottom: 1px solid var(--border-color);
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .modal-title {
                font-size: 1.2rem;
                font-weight: 600;
            }

            .modal-close {
                background: none;
                border: none;
                font-size: 1.5rem;
                cursor: pointer;
                color: #888;
                transition: var(--hover-transition);
            }

            .modal-close:hover {
                color: var(--danger-color);
            }

            .modal-body {
                padding: 20px;
            }

            .order-detail-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 20px;
                margin-bottom: 20px;
            }

            .order-detail-card {
                background-color: #f9f9f9;
                border-radius: 8px;
                padding: 15px;
            }

            .detail-label {
                font-size: 0.9rem;
                color: #888;
                margin-bottom: 5px;
            }

            .detail-value {
                font-weight: 600;
            }

            .order-items-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }

            .order-items-table th,
            .order-items-table td {
                padding: 12px 15px;
                text-align: left;
                border-bottom: 1px solid var(--border-color);
            }

            .order-items-table th {
                font-weight: 600;
                color: #555;
                background-color: #f9f9f9;
            }

            .item-image {
                width: 50px;
                height: 50px;
                border-radius: 8px;
                object-fit: cover;
            }

            .item-info {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .item-name {
                font-weight: 500;
            }

            .order-summary {
                background-color: #f9f9f9;
                border-radius: 8px;
                padding: 15px;
                margin-bottom: 20px;
            }

            .summary-row {
                display: flex;
                justify-content: space-between;
                margin-bottom: 10px;
            }

            .summary-row:last-child {
                margin-bottom: 0;
                padding-top: 10px;
                border-top: 1px solid var(--border-color);
                font-weight: 600;
            }

            .modal-footer {
                padding: 20px;
                border-top: 1px solid var(--border-color);
                display: flex;
                justify-content: flex-end;
                gap: 10px;
            }

            .modal-button {
                padding: 10px 20px;
                border-radius: 6px;
                font-weight: 500;
                cursor: pointer;
                transition: var(--hover-transition);
            }

            .modal-button.primary {
                background-color: var(--primary-color);
                color: white;
                border: none;
            }

            .modal-button.primary:hover {
                background-color: var(--primary-dark);
            }

            .modal-button.secondary {
                background-color: #f1f1f1;
                color: var(--text-dark);
                border: none;
            }

            .modal-button.secondary:hover {
                background-color: #e0e0e0;
            }

            /* Responsive */
            @media (max-width: 992px) {
                .order-detail-grid {
                    grid-template-columns: 1fr 1fr;
                }
            }

            @media (max-width: 768px) {
                .orders-filters {
                    flex-direction: column;
                    align-items: flex-start;
                }

                .filter-group {
                    width: 100%;
                }

                .filter-select,
                .filter-date {
                    flex: 1;
                }

                .orders-table {
                    display: block;
                    overflow-x: auto;
                }

                .order-detail-grid {
                    grid-template-columns: 1fr;
                }
            }

            @media (max-width: 576px) {
                .orders-header {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 10px;
                }

                .pagination {
                    flex-direction: column;
                    gap: 10px;
                    align-items: flex-start;
                }
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Poppins', sans-serif;
            }

            :root {
                --primary-color: #ff6b00;
                --primary-dark: #d84315;
                --primary-light: #ffab40;
                --accent-color: #e65100;
                --text-dark: #333333;
                --text-light: #f9f9f9;
                --background-light: #f8f9fa;
                --background-dark: #263238;
                --success-color: #4caf50;
                --warning-color: #ff9800;
                --danger-color: #f44336;
                --info-color: #2196f3;
                --border-color: #e0e0e0;
                --card-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                --hover-transition: all 0.3s ease;
            }
            .admin-content{
        margin-left: 280px;
    }

        </style>

    </head>

    <body>
        <div class="admin-content">
            <div class="orders-header">
                <h1 class="page-title">Orders Management</h1>
                <button class="filter-button">
                    <i class="fas fa-plus"></i> Create Order
                </button>
            </div>

            <div class="orders-filters">
                <div class="filter-group">
                    <label class="filter-label">Status:</label>
                    <select class="filter-select">
                        <option value="">All Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Payment:</label>
                    <select class="filter-select">
                        <option value="">All Payments</option>
                        <option value="paid">Paid</option>
                        <option value="unpaid">Unpaid</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">From:</label>
                    <input type="date" class="filter-date">
                </div>
                <div class="filter-group">
                    <label class="filter-label">To:</label>
                    <input type="date" class="filter-date">
                </div>
                <button class="filter-button">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <button class="reset-button">Reset</button>
            </div>

            <div class="orders-table-container">
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($orders->isEmpty())
                            <tr>
                                <td colspan="8">Tidak ada pesanan ditemukan.</td>
                            </tr>
                        @else
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="order-id">#ORD-{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</td>
                                    <td>
                                        <div class="order-customer">
                                            <div class="customer-avatar">{{ substr($order->user->name, 0, 2) }}</div>
                                            <div>{{ $order->user->name }}</div>
                                        </div>
                                    </td>
                                    <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                    <td>{{ $order->orderItems->count() }} items</td>
                                    <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                    <td><span
                                            class="order-status status-{{ $order->ispaid ? 'completed' : 'cancelled' }}">{{ $order->ispaid ? 'Paid' : 'Unpaid' }}</span>
                                    </td>
                                    <td><span
                                            class="order-status status-{{ strtolower($order->status) }}">{{ $order->status }}</span>
                                    </td>
                                    <td>
                                        <div class="order-actions">
                                            <div onclick="window.location.href = 'orders/{{ $order->id }}/view' " class="action-icon view" data-order="{{ $order->id }}"><i
                                                    class="fas fa-eye"></i></div>
                                            <div class="action-icon edit"><i class="fas fa-edit"></i></div>
                                            <div class="action-icon delete"><i class="fas fa-trash"></i></div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <!-- Alternative Pagination Section -->
                <!-- Alternative Pagination Section -->
                <div class="pagination">
                    <div class="pagination-info">
                        Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} entries
                    </div>
                    <div class="pagination-controls">
                        @if ($orders->currentPage() > 1)
                            <a href="{{ $orders->previousPageUrl() }}" class="pagination-button">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        @else
                            <span class="pagination-button disabled">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        @endif

                        @php
                            $currentPage = $orders->currentPage();
                            $totalPages = $orders->lastPage();
                            $displayPages = 5; // Number of page buttons to show
                            $halfDisplay = floor($displayPages / 2);

                            $startPage = max(1, $currentPage - $halfDisplay);
                            $endPage = min($totalPages, $startPage + $displayPages - 1);

                            if ($endPage - $startPage + 1 < $displayPages) {
                                $startPage = max(1, $endPage - $displayPages + 1);
                            }
                        @endphp

                        @for ($page = $startPage; $page <= $endPage; $page++)
                            @if ($page == $currentPage)
                                <span class="pagination-button active">{{ $page }}</span>
                            @else
                                <a href="{{ $orders->url($page) }}" class="pagination-button">{{ $page }}</a>
                            @endif
                        @endfor

                        @if ($orders->currentPage() < $orders->lastPage())
                            <a href="{{ $orders->nextPageUrl() }}" class="pagination-button">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        @else
                            <span class="pagination-button disabled">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Detail Modal -->
        <div class="modal" id="orderDetailModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Order #<span id="orderId"></span></h2>
                    <button class="modal-close">×</button>
                </div>
                <div class="modal-body">
                    <div class="order-detail-grid">
                        <div class="order-detail-card">
                            <div class="detail-label">Order Date</div>
                            <div class="detail-value" id="orderDate"></div>
                        </div>
                        <div class="order-detail-card">
                            <div class="detail-label">Status</div>
                            <div class="detail-value"><span id="orderStatus" class="order-status"></span></div>
                        </div>
                        <div class="order-detail-card">
                            <div class="detail-label">Payment Status</div>
                            <div class="detail-value"><span id="paymentStatus" class="order-status"></span></div>
                        </div>
                        <div class="order-detail-card">
                            <div class="detail-label">Payment Method</div>
                            <div class="detail-value" id="paymentMethod"></div>
                        </div>
                    </div>

                    <div class="order-detail-grid">
                        <div class="order-detail-card">
                            <div class="detail-label">Customer</div>
                            <div class="detail-value" id="customerName"></div>
                        </div>
                        <div class="order-detail-card">
                            <div class="detail-label">Email</div>
                            <div class="detail-value" id="customerEmail"></div>
                        </div>
                        <div class="order-detail-card">
                            <div class="detail-label">Phone</div>
                            <div class="detail-value" id="customerPhone"></div>
                        </div>
                        <div class="order-detail-card">
                            <div class="detail-label">Address</div>
                            <div class="detail-value" id="customerAddress"></div>
                        </div>
                    </div>

                    <h3 style="margin: 20px 0 10px;">Order Items</h3>
                    <table class="order-items-table" id="orderItemsTable">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="orderItemsBody"></tbody>
                    </table>

                    <div class="order-summary" id="orderSummary">
                        <div class="summary-row">
                            <div>Subtotal</div>
                            <div id="subtotal"></div>
                        </div>
                        <div class="summary-row">
                            <div>Delivery Fee</div>
                            <div id="deliveryFee"></div>
                        </div>
                        <div class="summary-row">
                            <div>Tax (10%)</div>
                            <div id="tax"></div>
                        </div>
                        <div class="summary-row">
                            <div>Discount</div>
                            <div id="discount"></div>
                        </div>
                        <div class="summary-row">
                            <div>Total</div>
                            <div id="total"></div>
                        </div>
                    </div>

                    <h3 style="margin: 20px 0 10px;">Order Notes</h3>
                    <p id="orderNotes"></p>
                </div>
                <div class="modal-footer">
                    <button class="modal-button secondary" id="closeModal">Close</button>
                    <button class="modal-button primary">Print Invoice</button>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const viewButtons = document.querySelectorAll('.action-icon.view');
                const modal = document.getElementById('orderDetailModal');
                const closeModal = document.querySelector('.modal-close');
                const closeModalBtn = document.getElementById('closeModal');

                viewButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const orderId = this.getAttribute('data-order');
                        fetch(`/admin/orders/${orderId}`)
                            .then(response => response.json())
                            .then(data => {
                                document.getElementById('orderId').textContent =
                                    `ORD-${String(data.id).padStart(3, '0')}`;
                                document.getElementById('orderDate').textContent = new Date(data
                                    .created_at).toLocaleString('id-ID', {
                                    dateStyle: 'medium',
                                    timeStyle: 'short'
                                });
                                document.getElementById('orderStatus').textContent = data.status;
                                document.getElementById('orderStatus').className =
                                    `order-status status-${data.status.toLowerCase()}`;
                                document.getElementById('paymentStatus').textContent = data.ispaid ?
                                    'Paid' : 'Unpaid';
                                document.getElementById('paymentStatus').className =
                                    `order-status status-${data.ispaid ? 'completed' : 'cancelled'}`;
                                document.getElementById('paymentMethod').textContent = data
                                    .payment_method || 'Not Specified';
                                document.getElementById('customerName').textContent = data.user
                                    .name;
                                document.getElementById('customerEmail').textContent = data.user
                                    .email;
                                document.getElementById('customerPhone').textContent = data.user
                                    .phone;
                                document.getElementById('customerAddress').textContent = data
                                    .alamat;

                                const itemsBody = document.getElementById('orderItemsBody');
                                itemsBody.innerHTML = data.items.map(item => `
                                <tr>
                                    <td>
                                        <div class="item-info">
                                            <img src="${item.image}" alt="${item.name}" class="item-image">
                                            <div class="item-name">${item.name}</div>
                                        </div>
                                    </td>
                                    <td>Rp ${Number(item.price).toLocaleString('id-ID')}</td>
                                    <td>${item.quantity}</td>
                                    <td>Rp ${(item.price * item.quantity).toLocaleString('id-ID')}</td>
                                </tr>
                            `).join('');

                                document.getElementById('subtotal').textContent =
                                    `Rp ${data.subtotal.toLocaleString('id-ID')}`;
                                document.getElementById('deliveryFee').textContent =
                                    `Rp ${data.delivery_fee.toLocaleString('id-ID')}`;
                                document.getElementById('tax').textContent =
                                    `Rp ${data.tax.toLocaleString('id-ID')}`;
                                document.getElementById('discount').textContent =
                                    `- Rp ${data.discount.toLocaleString('id-ID')}`;
                                document.getElementById('total').textContent =
                                    `Rp ${data.total.toLocaleString('id-ID')}`;
                                document.getElementById('orderNotes').textContent = data.notes;

                                modal.classList.add('active');
                            });
                    });
                });

                closeModal.addEventListener('click', function() {
                    modal.classList.remove('active');
                });

                closeModalBtn.addEventListener('click', function() {
                    modal.classList.remove('active');
                });

                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        modal.classList.remove('active');
                    }
                });
            });
        </script>
    </body>

    </html>
@endsection
