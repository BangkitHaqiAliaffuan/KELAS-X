@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Pesanan #{{ $order->id }} - Ayam Goreng Lezat</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f8f8f8;
            color: #333;
        }

        .order-detail-section {
            position: relative;
            padding: 80px 5% 100px;
            background: linear-gradient(135deg, #ffebee 0%, #fff8e1 100%);
            overflow: hidden;
            min-height: 100vh;
        }

        .order-detail-section::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: url('/api/placeholder/200/200') no-repeat;
            opacity: 0.1;
            transform: rotate(15deg);
            z-index: 0;
        }

        .order-detail-section::after {
            content: '';
            position: absolute;
            bottom: -50px;
            left: -50px;
            width: 200px;
            height: 200px;
            background: url('/api/placeholder/200/200') no-repeat;
            opacity: 0.1;
            transform: rotate(-15deg);
            z-index: 0;
        }

        .order-header {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
            z-index: 2;
            opacity: 0;
            transform: translateY(50px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }

        .order-header.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .section-title {
            font-size: 2.5rem;
            color: #e65100;
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(to right, #e65100, #ff9800);
            border-radius: 2px;
        }

        .order-subtitle {
            font-size: 1.1rem;
            color: #666;
            max-width: 600px;
            margin: 20px auto 0;
        }

        .order-container {
            background-color: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.07);
            position: relative;
            z-index: 2;
            opacity: 0;
            transform: translateY(50px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }

        .order-container.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .order-container:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease;
        }

        .order-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .info-card {
            background-color: #fff3e0;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .info-card h3 {
            color: #e65100;
            margin-bottom: 15px;
            font-size: 1.2rem;
            position: relative;
            padding-bottom: 10px;
        }

        .info-card h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background: linear-gradient(to right, #e65100, #ff9800);
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
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
            margin-top: 5px;
        }

        .status-pending {
            background-color: #fff3e0;
            color: #e65100;
        }

        .status-processing {
            background-color: #e3f2fd;
            color: #1976d2;
        }

        .status-shipped {
            background-color: #e8f5e9;
            color: #388e3c;
        }

        .status-delivered {
            background-color: #e8f5e9;
            color: #388e3c;
        }

        .status-cancelled {
            background-color: #ffebee;
            color: #d32f2f;
        }

        .payment-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
            margin-top: 5px;
        }

        .payment-paid {
            background-color: #e8f5e9;
            color: #388e3c;
        }

        .payment-unpaid {
            background-color: #ffebee;
            color: #d32f2f;
        }

        .order-items-container {
            margin-top: 40px;
        }

        .order-items-title {
            font-size: 1.5rem;
            color: #e65100;
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }

        .order-items-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 60px;
            height: 3px;
            background: linear-gradient(to right, #e65100, #ff9800);
            border-radius: 2px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .items-table th {
            background-color: #fff3e0;
            color: #e65100;
            font-weight: 600;
            text-align: left;
            padding: 15px;
            border-bottom: 2px solid #ffccbc;
        }

        .items-table td {
            padding: 15px;
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
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 10px;
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
            border-radius: 12px;
            padding: 25px;
            margin-top: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .summary-title {
            font-size: 1.3rem;
            color: #e65100;
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }

        .summary-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(to right, #e65100, #ff9800);
            border-radius: 2px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            padding-bottom: 12px;
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
            font-size: 1.2rem;
        }

        .summary-total .summary-value {
            color: #e65100;
            font-size: 1.3rem;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 40px;
            flex-wrap: wrap;
        }

        .action-button {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(to right, #e65100, #ff9800);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .action-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(230, 81, 0, 0.2);
        }

        .action-button.secondary {
            background: white;
            color: #e65100;
            border: 2px solid #e65100;
        }

        .action-button.secondary:hover {
            background: #fff3e0;
        }

        .action-button i {
            margin-right: 8px;
        }

        .floating-chicken {
            position: absolute;
            width: 120px;
            height: 120px;
            background: url('/api/placeholder/120/120') no-repeat;
            z-index: 1;
            animation: float 6s ease-in-out infinite;
        }

        .chicken1 {
            top: 10%;
            left: 5%;
            animation-delay: 0s;
        }

        .chicken2 {
            top: 20%;
            right: 5%;
            animation-delay: 2s;
        }

        .chicken3 {
            bottom: 15%;
            left: 8%;
            animation-delay: 4s;
        }

        @keyframes float {
            0% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(5deg);
            }
            100% {
                transform: translateY(0px) rotate(0deg);
            }
        }

        .timeline {
            position: relative;
            max-width: 1200px;
            margin: 40px auto 0;
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
            border: 4px solid #ff9800;
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
            padding: 20px;
            background-color: #fff3e0;
            position: relative;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .timeline-date {
            color: #e65100;
            font-weight: 600;
        }

        .timeline-text {
            margin-top: 5px;
            color: #555;
        }

        @media screen and (max-width: 992px) {
            .order-detail-section {
                padding: 60px 4% 80px;
            }
        }

        @media screen and (max-width: 768px) {
            .section-title {
                font-size: 2rem;
            }

            .order-container {
                padding: 30px 20px;
            }

            .items-table {
                display: block;
                overflow-x: auto;
            }

            .floating-chicken {
                display: none;
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
                font-size: 1.8rem;
            }

            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <section class="order-detail-section">
        <div class="floating-chicken chicken1"></div>
        <div class="floating-chicken chicken2"></div>
        <div class="floating-chicken chicken3"></div>

        <div class="order-header">
            <h1 class="section-title">Detail Pesanan #{{ $order->id }}</h1>
            <p class="order-subtitle">Berikut adalah detail lengkap pesanan Ayam Goreng Lezat Anda.</p>
        </div>

        <div class="order-container">
            <div class="order-info-grid">
                <div class="info-card">
                    <h3><i class="fas fa-info-circle"></i> Informasi Pesanan</h3>
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



               <!-- Di dalam file show.blade.php -->
<div class="info-card">
    <h3><i class="fas fa-map-marker-alt"></i> Informasi Pengiriman</h3>
    @php
        // Parsing alamat langsung di template
        $alamatString = $order->alamat;
        $alamatParts = explode(", ", $alamatString);
        $alamatData = [];

        foreach ($alamatParts as $part) {
            $keyValue = explode(": ", $part, 2);
            if (count($keyValue) == 2) {
                $alamatData[$keyValue[0]] = $keyValue[1];
            }
        }
    @endphp

    <p><span class="highlight">Nama:</span> {{ $alamatData['Nama'] ?? '-' }}</p>
    <p><span class="highlight">Penerima:</span> {{ $alamatData['Penerima'] ?? '-' }}</p>
    <p><span class="highlight">Telepon:</span> {{ $alamatData['Telepon'] ?? '-' }}</p>
    <p><span class="highlight">Alamat:</span> {{ $alamatData['Alamat'] ?? '-' }}</p>
    <p><span class="highlight">Kota:</span> {{ $alamatData['Kota'] ?? '-' }}</p>
    <p><span class="highlight">Kode Pos:</span> {{ $alamatData['Kode Pos'] ?? '-' }}</p>
    @if(isset($alamatData['Catatan']))
        <p><span class="highlight">Catatan:</span> {{ $alamatData['Catatan'] }}</p>
    @endif
</div>
            </div>

            <div class="order-items-container">
                <h3 class="order-items-title"><i class="fas fa-utensils"></i> Item Pesanan</h3>

                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Menu</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $item)
                            <tr class="item-row" data-item-id="{{ $item->id }}">
                                <td>
                                    <div class="item-info">
                                        <span class="item-name">{{ $item->menu->name }}</span>
                                        <div class="item-description">Ayam Goreng Lezat dengan bumbu spesial</div>
                                    </div>
                                </td>
                                <td>{{ $item->quantity }}</td>
                                <td class="price-column">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
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

            <div class="timeline">
                <div class="timeline-container left">
                    <div class="timeline-content">
                        <h2 class="timeline-date">{{ $order->created_at->format('d M Y H:i') }}</h2>
                        <p class="timeline-text">Pesanan dibuat</p>
                    </div>
                </div>
                <div class="timeline-container right">
                    <div class="timeline-content">
                        <h2 class="timeline-date">{{ $order->created_at->addMinutes(30)->format('d M Y H:i') }}</h2>
                        <p class="timeline-text">Pesanan dikonfirmasi</p>
                    </div>
                </div>
                <div class="timeline-container left">
                    <div class="timeline-content">
                        <h2 class="timeline-date">{{ $order->created_at->addHours(1)->format('d M Y H:i') }}</h2>
                        <p class="timeline-text">Pesanan sedang diproses</p>
                    </div>
                </div>
                @if($order->status == 'Shipped' || $order->status == 'Delivered')
                <div class="timeline-container right">
                    <div class="timeline-content">
                        <h2 class="timeline-date">{{ $order->created_at->addHours(2)->format('d M Y H:i') }}</h2>
                        <p class="timeline-text">Pesanan dikirim</p>
                    </div>
                </div>
                @endif
                @if($order->status == 'Delivered')
                <div class="timeline-container left">
                    <div class="timeline-content">
                        <h2 class="timeline-date">{{ $order->created_at->addHours(3)->format('d M Y H:i') }}</h2>
                        <p class="timeline-text">Pesanan diterima</p>
                    </div>
                </div>
                @endif
            </div>

            <div class="action-buttons">
                <a href="{{ route('orders.index') }}" class="action-button secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pesanan
                </a>
                @if(!$order->ispaid)
                <a href="{{ $order->id }}/pay" class="action-button">
                    <i class="fas fa-credit-card"></i> Bayar Sekarang
                </a>
                @endif
                <a href="{{ route('menu') }}" class="action-button">
                    <i class="fas fa-utensils"></i> Pesan Lagi
                </a>
            </div>
        </div>
    </section>

    <script>
        // Animasi saat scroll menggunakan Intersection Observer
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        // Berhenti mengamati elemen setelah terlihat untuk efisiensi
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1, // Elemen mulai terlihat saat 10% masuk viewport
                rootMargin: '0px 0px -50px 0px' // Margin bawah untuk memicu lebih awal
            });

            // Pilih elemen yang akan dianimasikan
            const elementsToAnimate = document.querySelectorAll('.order-header, .order-container');
            elementsToAnimate.forEach(element => {
                observer.observe(element);
            });

            // Add hover effect to table rows
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

