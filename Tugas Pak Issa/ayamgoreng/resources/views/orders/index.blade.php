@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Pesanan - Ayam Goreng Lezat</title>
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

        .orders-section {
            position: relative;
            padding: 80px 5% 100px;
            background: linear-gradient(135deg, #ffebee 0%, #fff8e1 100%);
            overflow: hidden;
            min-height: 100vh;
        }

        .orders-section::before {
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

        .orders-section::after {
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

        .orders-header {
            text-align: center;
            margin-bottom: 60px;
            position: relative;
            z-index: 2;
            opacity: 0;
            transform: translateY(50px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }

        .orders-header.visible {
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

        .orders-subtitle {
            font-size: 1.1rem;
            color: #666;
            max-width: 600px;
            margin: 20px auto 0;
        }

        .orders-container {
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

        .orders-container.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .orders-container:hover {
            transform: translateY(-5px);
        }

        .empty-orders {
            text-align: center;
            padding: 40px 20px;
            background-color: #fff3e0;
            border-radius: 12px;
            margin-bottom: 30px;
        }

        .empty-orders i {
            font-size: 4rem;
            color: #e65100;
            margin-bottom: 20px;
            display: block;
        }

        .empty-orders p {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 20px;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .orders-table th {
            background-color: #fff3e0;
            color: #e65100;
            font-weight: 600;
            text-align: left;
            padding: 15px;
            border-bottom: 2px solid #ffccbc;
        }

        .orders-table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            color: #333;
            vertical-align: middle;
        }

        .orders-table tr:hover {
            background-color: #f9f9f9;
        }

        .orders-table tr:last-child td {
            border-bottom: none;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
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
        }

        .payment-paid {
            background-color: #e8f5e9;
            color: #388e3c;
        }

        .payment-unpaid {
            background-color: #ffebee;
            color: #d32f2f;
        }

        .action-button {
            display: inline-block;
            padding: 8px 16px;
            background: linear-gradient(to right, #e65100, #ff9800);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .action-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(230, 81, 0, 0.2);
        }

        .action-button i {
            margin-right: 5px;
        }

        .cta-banner {
            background: linear-gradient(135deg, #e65100, #ff9800);
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            margin-top: 80px;
            box-shadow: 0 15px 30px rgba(230, 81, 0, 0.2);
            position: relative;
            overflow: hidden;
            opacity: 0;
            transform: translateY(50px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }

        .cta-banner.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .cta-banner::before {
            content: '';
            position: absolute;
            top: -50px;
            left: -50px;
            width: 150px;
            height: 150px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .cta-banner::after {
            content: '';
            position: absolute;
            bottom: -50px;
            right: -50px;
            width: 150px;
            height: 150px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .cta-title {
            color: white;
            font-size: 2rem;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .cta-text {
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 30px;
            font-size: 1.1rem;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-button {
            display: inline-block;
            padding: 15px 35px;
            background-color: white;
            color: #e65100;
            font-weight: 600;
            font-size: 1.1rem;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .cta-button:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
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

        .order-details-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            border-radius: 15px;
            padding: 30px;
            width: 90%;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            transform: translateY(50px);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .modal-content.active {
            transform: translateY(0);
            opacity: 1;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #eee;
        }

        .modal-title {
            font-size: 1.5rem;
            color: #e65100;
            font-weight: 600;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #666;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .close-modal:hover {
            color: #e65100;
            transform: rotate(90deg);
        }

        .modal-body {
            margin-bottom: 20px;
        }

        .order-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .info-card {
            background-color: #f9f9f9;
            border-radius: 10px;
            padding: 15px;
        }

        .info-card h4 {
            color: #e65100;
            margin-bottom: 10px;
            font-size: 1rem;
        }

        .info-card p {
            color: #333;
            margin-bottom: 5px;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding-top: 15px;
            border-top: 2px solid #eee;
        }

        @media screen and (max-width: 992px) {
            .orders-section {
                padding: 60px 4% 80px;
            }
        }

        @media screen and (max-width: 768px) {
            .section-title {
                font-size: 2rem;
            }

            .orders-container {
                padding: 30px 20px;
            }

            .orders-table {
                display: block;
                overflow-x: auto;
            }

            .floating-chicken {
                display: none;
            }
        }

        @media screen and (max-width: 480px) {
            .section-title {
                font-size: 1.8rem;
            }

            .cta-title {
                font-size: 1.5rem;
            }

            .cta-banner {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <section class="orders-section">
        <div class="floating-chicken chicken1"></div>
        <div class="floating-chicken chicken2"></div>
        <div class="floating-chicken chicken3"></div>

        <div class="orders-header">
            <h1 class="section-title">Daftar Pesanan Anda</h1>
            <p class="orders-subtitle">Lihat dan kelola semua pesanan Ayam Goreng Lezat Anda di satu tempat.</p>
        </div>

        <div class="orders-container">
            @if ($orders->isEmpty())
                <div class="empty-orders">
                    <i class="fas fa-shopping-cart"></i>
                    <p>Anda belum memiliki pesanan.</p>
                    <a href="{{ route('menu') }}" class="action-button">
                        <i class="fas fa-utensils"></i> Lihat Menu
                    </a>
                </div>
            @else
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Status Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr data-order-id="{{ $order->id }}">
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td>
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
                                </td>
                                <td>
                                    @if($order->ispaid)
                                        <span class="payment-badge payment-paid">Lunas</span>
                                    @else
                                        <span class="payment-badge payment-unpaid">Belum Dibayar</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('orders.show', $order->id) }}" class="action-button view-order-btn">
                                        <i class="fas fa-eye"></i> Lihat Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <div class="cta-banner">
            <h2 class="cta-title">Ingin Memesan Lagi?</h2>
            <p class="cta-text">Nikmati kelezatan Ayam Goreng kami dengan berbagai pilihan menu yang menggugah selera. Pesan sekarang dan dapatkan promo spesial!</p>
            <a href="{{ route('menu') }}" class="cta-button">Pesan Sekarang <i class="fas fa-arrow-right"></i></a>
        </div>

        <!-- Order Details Modal -->
        <div class="order-details-modal" id="orderDetailsModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Detail Pesanan #<span id="orderIdPlaceholder"></span></h3>
                    <button class="close-modal" id="closeModal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="order-info">
                        <div class="info-card">
                            <h4>Informasi Pesanan</h4>
                            <p><strong>Tanggal:</strong> <span id="orderDatePlaceholder"></span></p>
                            <p><strong>Status:</strong> <span id="orderStatusPlaceholder"></span></p>
                            <p><strong>Pembayaran:</strong> <span id="orderPaymentPlaceholder"></span></p>
                        </div>
                        <div class="info-card">
                            <h4>Informasi Pengiriman</h4>
                            <p><strong>Alamat:</strong> <span id="orderAddressPlaceholder">Jl. Contoh No. 123</span></p>
                            <p><strong>Kota:</strong> <span id="orderCityPlaceholder">Kota Lezat</span></p>
                            <p><strong>Kode Pos:</strong> <span id="orderPostalPlaceholder">12345</span></p>
                        </div>
                    </div>
                    <div id="orderItemsPlaceholder">
                        <!-- Order items will be loaded here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="action-button" id="closeModalBtn">Tutup</button>
                </div>
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
            const elementsToAnimate = document.querySelectorAll('.orders-header, .orders-container, .cta-banner');
            elementsToAnimate.forEach(element => {
                observer.observe(element);
            });

            // Modal functionality
            const modal = document.getElementById('orderDetailsModal');
            const closeModal = document.getElementById('closeModal');
            const closeModalBtn = document.getElementById('closeModalBtn');
            // const viewOrderBtns = document.querySelectorAll('.view-order-btn');

            // Function to open modal with order details
            const openOrderModal = (orderId) => {
                // Here you would typically fetch order details from the server
                // For demo purposes, we'll just set some placeholder values
                document.getElementById('orderIdPlaceholder').textContent = orderId;
                document.getElementById('orderDatePlaceholder').textContent = '15 Jun 2023';
                document.getElementById('orderStatusPlaceholder').textContent = 'Shipped';
                document.getElementById('orderPaymentPlaceholder').textContent = 'Lunas';

                // Show modal
                modal.style.display = 'flex';
                setTimeout(() => {
                    document.querySelector('.modal-content').classList.add('active');
                }, 10);
            };

            // Close modal when clicking the close button
            closeModal.addEventListener('click', () => {
                document.querySelector('.modal-content').classList.remove('active');
                setTimeout(() => {
                    modal.style.display = 'none';
                }, 300);
            });

            closeModalBtn.addEventListener('click', () => {
                document.querySelector('.modal-content').classList.remove('active');
                setTimeout(() => {
                    modal.style.display = 'none';
                }, 300);
            });

            // Close modal when clicking outside the modal content
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    document.querySelector('.modal-content').classList.remove('active');
                    setTimeout(() => {
                        modal.style.display = 'none';
                    }, 300);
                }
            });

            // Add click event to view order buttons
            // viewOrderBtns.forEach(btn => {
            //     btn.addEventListener('click', (e) => {
            //         e.preventDefault();
            //         const orderId = e.target.closest('tr').dataset.orderId;
            //         openOrderModal(orderId);
            //     });
            // });

            // Add hover effect to table rows
            const tableRows = document.querySelectorAll('.orders-table tbody tr');
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

