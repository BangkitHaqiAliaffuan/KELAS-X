@extends('layouts.admin')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan #{{ $order->id }} - Ayam Goreng JOSS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
        }

        .order-detail-section {
            margin-left: 280px;
            position: relative;
            padding: 30px 20px;
            background-color: var(--background-light);
            min-height: 100vh;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
        }

        .section-title {
            font-size: 1.8rem;
            color: var(--accent-color);
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 60px;
            height: 3px;
            background: linear-gradient(to right, var(--primary-dark), var(--primary-light));
            border-radius: 2px;
        }

        .order-container {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: var(--card-shadow);
            position: relative;
            z-index: 2;
            margin-bottom: 20px;
        }

        .order-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .info-card {
            background-color: #fff3e0;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            transition: var(--hover-transition);
        }

        .info-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .info-card h3 {
            color: var(--accent-color);
            margin-bottom: 12px;
            font-size: 1.1rem;
            position: relative;
            padding-bottom: 8px;
        }

        .info-card h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background: linear-gradient(to right, var(--primary-dark), var(--primary-light));
            border-radius: 2px;
        }

        .info-card p {
            margin-bottom: 8px;
            color: #555;
        }

        .info-card .highlight {
            font-weight: 600;
            color: #333;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
            margin-top: 5px;
        }

        .status-pending {
            background-color: rgba(255, 152, 0, 0.1);
            color: var(--warning-color);
        }

        .status-processing {
            background-color: rgba(33, 150, 243, 0.1);
            color: var(--info-color);
        }

        .status-shipped {
            background-color: rgba(76, 175, 80, 0.1);
            color: var(--success-color);
        }

        .status-delivered {
            background-color: rgba(76, 175, 80, 0.1);
            color: var(--success-color);
        }

        .status-cancelled {
            background-color: rgba(244, 67, 54, 0.1);
            color: var(--danger-color);
        }

        .payment-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
            margin-top: 5px;
        }

        .payment-paid {
            background-color: rgba(76, 175, 80, 0.1);
            color: var(--success-color);
        }

        .payment-unpaid {
            background-color: rgba(244, 67, 54, 0.1);
            color: var(--danger-color);
        }

        .order-items-container {
            margin-top: 30px;
        }

        .order-items-title {
            font-size: 1.3rem;
            color: var(--accent-color);
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }

        .order-items-title::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(to right, var(--primary-dark), var(--primary-light));
            border-radius: 2px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .items-table th {
            background-color: #fff3e0;
            color: var(--accent-color);
            font-weight: 600;
            text-align: left;
            padding: 15px;
            border-bottom: 2px solid #ffccbc;
        }

        .items-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            color: #333;
            vertical-align: middle;
        }

        .items-table tr:hover {
            background-color: #f9f9f9;
        }

        .items-table tr:last-child td {
            border-bottom: none;
        }

        .item-image {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 10px;
        }

        .item-info {
            display: flex;
            align-items: center;
        }

        .item-name {
            font-weight: 500;
            color: #333;
        }

        .item-description {
            font-size: 0.85rem;
            color: #666;
            margin-top: 5px;
        }

        .price-column {
            text-align: right;
            font-weight: 500;
        }

        .order-summary {
            background-color: #fff3e0;
            border-radius: 10px;
            padding: 20px;
            margin-top: 25px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .summary-title {
            font-size: 1.2rem;
            color: var(--accent-color);
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }

        .summary-title::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 40px;
            height: 3px;
            background: linear-gradient(to right, var(--primary-dark), var(--primary-light));
            border-radius: 2px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #ffccbc;
        }

        .summary-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .summary-label {
            color: #666;
        }

        .summary-value {
            font-weight: 600;
            color: #333;
        }

        .summary-total {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid #ffccbc;
            font-size: 1.1rem;
        }

        .summary-total .summary-value {
            color: var(--accent-color);
            font-size: 1.2rem;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .action-button {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            width: 150px;
            height: 50px;
            background: linear-gradient(to right, var(--primary-dark), var(--primary-color));
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.95rem;
            cursor: pointer;
            transition: var(--hover-transition);
            text-decoration: none;
        }

        .action-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(230, 81, 0, 0.2);
        }

        .action-button.secondary {
            background: white;
            color: var(--accent-color);
            border: 2px solid var(--accent-color);
        }

        .action-button.secondary:hover {
            background: #fff3e0;
        }

        .action-button.danger {
            background: linear-gradient(to right, #d32f2f, #f44336);
        }

        .action-button i {
            margin-right: 8px;
        }

        .timeline {
            position: relative;
            max-width: 1200px;
            margin: 30px auto 0;
        }

        .timeline::after {
            content: '';
            position: absolute;
            width: 6px;
            background-color: #ffccbc;
            top: 0;
            bottom: 0;
            left: 50%;
            margin-left: -3px;
            border-radius: 3px;
        }

        .timeline-container {
            padding: 10px 40px;
            position: relative;
            background-color: inherit;
            width: 50%;
        }

        .timeline-container::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            right: -10px;
            background-color: white;
            border: 4px solid var(--primary-color);
            top: 15px;
            border-radius: 50%;
            z-index: 1;
        }

        .left {
            left: 0;
        }

        .right {
            left: 50%;
        }

        .left::before {
            content: " ";
            height: 0;
            position: absolute;
            top: 22px;
            width: 0;
            z-index: 1;
            right: 30px;
            border: medium solid #fff3e0;
            border-width: 10px 0 10px 10px;
            border-color: transparent transparent transparent #fff3e0;
        }

        .right::before {
            content: " ";
            height: 0;
            position: absolute;
            top: 22px;
            width: 0;
            z-index: 1;
            left: 30px;
            border: medium solid #fff3e0;
            border-width: 10px 10px 10px 0;
            border-color: transparent #fff3e0 transparent transparent;
        }

        .right::after {
            left: -10px;
        }

        .timeline-content {
            padding: 15px;
            background-color: #fff3e0;
            position: relative;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .timeline-date {
            color: var(--accent-color);
            font-weight: 600;
        }

        .timeline-text {
            margin-top: 5px;
            color: #555;
        }

        .customer-info {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: var(--card-shadow);
            margin-bottom: 20px;
        }

        .customer-info-title {
            font-size: 1.2rem;
            color: var(--accent-color);
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }

        .customer-info-title::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 40px;
            height: 3px;
            background: linear-gradient(to right, var(--primary-dark), var(--primary-light));
            border-radius: 2px;
        }

        .customer-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .customer-detail-group {
            margin-bottom: 15px;
        }

        .customer-detail-label {
            font-size: 0.9rem;
            color: #888;
            margin-bottom: 5px;
        }

        .customer-detail-value {
            font-weight: 500;
            color: #333;
        }

        .status-update-form {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: var(--card-shadow);
            margin-bottom: 20px;
        }

        .status-update-title {
            font-size: 1.2rem;
            color: var(--accent-color);
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }

        .status-update-title::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 40px;
            height: 3px;
            background: linear-gradient(to right, var(--primary-dark), var(--primary-light));
            border-radius: 2px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-select {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
        }

        .form-select:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .form-textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            min-height: 100px;
            resize: vertical;
        }

        .admin-content{
            margin-left: 280px;
        }

        .form-textarea:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .form-submit {
            padding: 10px 20px;
            background: linear-gradient(to right, var(--primary-dark), var(--primary-color));
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--hover-transition);
        }

        .form-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(230, 81, 0, 0.2);
        }

        @media screen and (max-width: 992px) {
            .order-detail-section {
                padding: 20px 15px;
            }
        }

        @media screen and (max-width: 768px) {
            .section-title {
                font-size: 1.5rem;
            }

            .order-container {
                padding: 20px 15px;
            }

            .items-table {
                display: block;
                overflow-x: auto;
            }

            .timeline::after {
                left: 31px;
            }

            .timeline-container {
                width: 100%;
                padding-left: 70px;
                padding-right: 25px;
            }

            .timeline-container::before {
                left: 60px;
                border: medium solid #fff3e0;
                border-width: 10px 10px 10px 0;
                border-color: transparent #fff3e0 transparent transparent;
            }

            .left::after, .right::after {
                left: 15px;
            }

            .right {
                left: 0%;
            }
        }

        @media screen and (max-width: 480px) {
            .section-title {
                font-size: 1.3rem;
            }

            .order-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <section class="order-detail-section">
        <div class="order-header">
            <h1 class="section-title">Detail Pesanan #ORD-{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</h1>
            <div class="action-buttons">
                <a href="{{ route('admin.orders') }}" class="action-button secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <a href="#" class="action-button" onclick="window.print()">
                    <i class="fas fa-print"></i> Cetak Invoice
                </a>
            </div>
        </div>

        <div class="order-container">
            <div class="order-info-grid">
                <div class="info-card">
                    <h3><i class="fas fa-info-circle"></i> Informasi Pesanan</h3>
                    <p><span class="highlight">ID Pesanan:</span> #ORD-{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</p>
                    <p><span class="highlight">Tanggal:</span> {{ $order->created_at->format('d M Y H:i') }}</p>
                    <p><span class="highlight">Status:</span>
                        @php
                            $statusClass = '';
                            switch($order->status) {
                                case 'Pending':
                                    $statusClass = 'status-pending';
                                    break;
                                case 'Processing':
                                    $statusClass = 'status-processing';
                                    break;
                                case 'Shipped':
                                    $statusClass = 'status-shipped';
                                    break;
                                case 'Delivered':
                                    $statusClass = 'status-delivered';
                                    break;
                                case 'Cancelled':
                                    $statusClass = 'status-cancelled';
                                    break;
                                default:
                                    $statusClass = 'status-pending';
                            }
                        @endphp
                        <span class="status-badge {{ $statusClass }}">{{ $order->status }}</span>
                    </p>
                </div>

                <div class="info-card">
                    <h3><i class="fas fa-credit-card"></i> Informasi Pembayaran</h3>
                    <p><span class="highlight">Status Pembayaran:</span>
                        @if($order->ispaid)
                            <span class="payment-badge payment-paid">Lunas</span>
                        @else
                            <span class="payment-badge payment-unpaid">Belum Dibayar</span>
                        @endif
                    </p>
                    <p><span class="highlight">Metode Pembayaran:</span> Transfer Bank</p>
                    <p><span class="highlight">Total:</span> <span class="highlight">Rp {{ number_format($order->total, 0, ',', '.') }}</span></p>
                </div>

                <div class="info-card">
                    <h3><i class="fas fa-user"></i> Informasi Pelanggan</h3>
                    <p><span class="highlight">Nama:</span> {{ $order->user->name }}</p>
                    <p><span class="highlight">Email:</span> {{ $order->user->email }}</p>
                    <p><span class="highlight">Telepon:</span> {{ $order->user->phone ?? 'Tidak tersedia' }}</p>
                </div>

                <div class="info-card">
                    <h3><i class="fas fa-map-marker-alt"></i> Informasi Pengiriman</h3>
                    <p><span class="highlight">Alamat:</span> {{ $order->alamat ?? 'Tidak tersedia' }}</p>
                </div>
            </div>

            <div class="order-items-container">
                <h3 class="order-items-title"><i class="fas fa-utensils"></i> Item Pesanan</h3>

                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Menu</th>
                            <th>Harga Satuan</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $item)
                            <tr class="item-row" data-item-id="{{ $item->id }}">
                                <td>
                                    <div class="item-info">
                                        <img src="{{ asset($item->menu->image) }}" alt="{{ $item->menu->name }}" class="item-image">
                                        <div>
                                            <div class="item-name">{{ $item->menu->name }}</div>
                                            <div class="item-description">{{ $item->menu->description ?? 'Ayam Goreng Lezat dengan bumbu spesial' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="price-column">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="order-summary">
                    <h3 class="summary-title"><i class="fas fa-receipt"></i> Ringkasan Pembayaran</h3>

                    <div class="summary-row">
                        <span class="summary-label">Subtotal</span>
                        <span class="summary-value">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>

                    <div class="summary-row">
                        <span class="summary-label">Biaya Pengiriman</span>
                        <span class="summary-value">Rp 0</span>
                    </div>

                    <div class="summary-row">
                        <span class="summary-label">Diskon</span>
                        <span class="summary-value">Rp 0</span>
                    </div>

                    <div class="summary-row summary-total">
                        <span class="summary-label">Total</span>
                        <span class="summary-value">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- <div class="status-update-form">
                <h3 class="status-update-title"><i class="fas fa-edit"></i> Update Status Pesanan</h3>
                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="status" class="form-label">Status Pesanan</label>
                        <select name="status" id="status" class="form-select">
                            <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Processing" {{ $order->status == 'Processing' ? 'selected' : '' }}>Processing</option>
                            <option value="Shipped" {{ $order->status == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="Delivered" {{ $order->status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="payment_status" class="form-label">Status Pembayaran</label>
                        <select name="ispaid" id="payment_status" class="form-select">
                            <option value="0" {{ !$order->ispaid ? 'selected' : '' }}>Belum Dibayar</option>
                            <option value="1" {{ $order->ispaid ? 'selected' : '' }}>Lunas</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="admin_notes" class="form-label">Catatan Admin</label>
                        <textarea name="admin_notes" id="admin_notes" class="form-textarea" placeholder="Tambahkan catatan untuk pesanan ini...">{{ $order->admin_notes ?? '' }}</textarea>
                    </div>
                    <button type="submit" class="form-submit">Update Pesanan</button>
                </form>
            </div> --}}

            <div class="timeline">
                <div class="timeline-container left">
                    <div class="timeline-content">
                        <h2 class="timeline-date">{{ $order->created_at->format('d M Y H:i') }}</h2>
                        <p class="timeline-text">Pesanan dibuat</p>
                    </div>
                </div>
                @if($order->status != 'Pending' && $order->status != 'Cancelled')
                <div class="timeline-container right">
                    <div class="timeline-content">
                        <h2 class="timeline-date">{{ $order->updated_at->format('d M Y H:i') }}</h2>
                        <p class="timeline-text">Pesanan dikonfirmasi</p>
                    </div>
                </div>
                @endif
                @if($order->status == 'Processing' || $order->status == 'Shipped' || $order->status == 'Delivered')
                <div class="timeline-container left">
                    <div class="timeline-content">
                        <h2 class="timeline-date">{{ $order->updated_at->format('d M Y H:i') }}</h2>
                        <p class="timeline-text">Pesanan sedang diproses</p>
                    </div>
                </div>
                @endif
                @if($order->status == 'Shipped' || $order->status == 'Delivered')
                <div class="timeline-container right">
                    <div class="timeline-content">
                        <h2 class="timeline-date">{{ $order->updated_at->format('d M Y H:i') }}</h2>
                        <p class="timeline-text">Pesanan dikirim</p>
                    </div>
                </div>
                @endif
                @if($order->status == 'Delivered')
                <div class="timeline-container left">
                    <div class="timeline-content">
                        <h2 class="timeline-date">{{ $order->updated_at->format('d M Y H:i') }}</h2>
                        <p class="timeline-text">Pesanan diterima</p>
                    </div>
                </div>
                @endif
                @if($order->status == 'Cancelled')
                <div class="timeline-container left">
                    <div class="timeline-content">
                        <h2 class="timeline-date">{{ $order->updated_at->format('d M Y H:i') }}</h2>
                        <p class="timeline-text">Pesanan dibatalkan</p>
                    </div>
                </div>
                @endif
            </div>

            <div class="action-buttons">
                <a style="width: 200px" href="{{ route('admin.orders') }}" class="action-button secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pesanan
                </a>
                <a href="#" class="action-button" onclick="window.print()">
                    <i class="fas fa-print"></i> Cetak Invoice
                </a>
                @if(!$order->ispaid)
                <a href="{{ url('admin/orders/'.$order->id.'/pay') }}" class="action-button">
                    <i class="fas fa-check-circle"></i> Tandai Sebagai Dibayar
                </a>
                @endif

                <button  type="button" class="action-button danger" onclick="confirmDelete()">
                    <i class="fas fa-trash"></i> Hapus Pesanan
                </button>
            </div>
        </div>
    </section>

    <script>
        // Fungsi untuk konfirmasi penghapusan pesanan
        function confirmDelete() {
            // if (confirm('Apakah Anda yakin ingin menghapus pesanan ini? Tindakan ini tidak dapat dibatalkan.')) {
            //     // Jika konfirmasi diterima, kirim form untuk menghapus
            //     const form = document.createElement('form');
            //     form.method = 'POST';
                // form.action = '{{ route("admin.orders", $order->id) }}';
            //     form.style.display = 'none';

            //     const csrfToken = document.createElement('input');
            //     csrfToken.type = 'hidden';
            //     csrfToken.name = '_token';
            //     csrfToken.value = '{{ csrf_token() }}';

            //     const method = document.createElement('input');
            //     method.type = 'hidden';
            //     method.name = '_method';
            //     method.value = 'DELETE';

            //     form.appendChild(csrfToken);
            //     form.appendChild(method);
            //     document.body.appendChild(form);
            //     form.submit();
            // }
        }

        // Animasi saat scroll menggunakan Intersect    ion Observer
        document.addEventListener('DOMContentLoaded', () => {
            // Tambahkan efek hover pada baris tabel
            const tableRows = document.querySelectorAll('.items-table tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', () => {
                    row.style.transform = 'translateY(-3px)';
                    row.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.05)';
                    row.style.transition = 'all 0.3s ease';
                });

                row.addEventListener('mouseleave', () => {
                    row.style.transform = 'translateY(0)';
                    row.style.boxShadow = 'none';
                });
            });
        });
    </script>
</body>
</html>
@endsection
