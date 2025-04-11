@extends('layouts.admin')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Ayam Goreng JOSS</title>
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
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
        }

        /* Sidebar */
        .admin-sidebar {
            width: 280px;
            background-color: white;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 100;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 20px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--text-dark);
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background-color: var(--primary-color);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .logo-text {
            font-weight: 700;
            font-size: 1.2rem;
        }

        .logo-text span {
            color: var(--primary-color);
        }

        .sidebar-menu {
            padding: 20px 0;
            overflow-y: auto;
            height: calc(100vh - 80px);
        }

        .menu-category {
            padding: 0 20px;
            margin-bottom: 10px;
            color: #888;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .menu-items {
            list-style: none;
        }

        .menu-item {
            margin-bottom: 5px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            text-decoration: none;
            color: var(--text-dark);
            transition: var(--hover-transition);
            border-left: 3px solid transparent;
            gap: 10px;
        }

        .menu-link:hover {
            background-color: rgba(255, 107, 0, 0.05);
            color: var(--primary-color);
        }

        .menu-link.active {
            background-color: rgba(255, 107, 0, 0.1);
            color: var(--primary-color);
            border-left-color: var(--primary-color);
            font-weight: 600;
        }

        .menu-icon {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        .menu-text {
            flex: 1;
        }

        .menu-badge {
            background-color: var(--primary-color);
            color: white;
            border-radius: 50px;
            padding: 2px 8px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        /* Main Content */
        .admin-main {
            flex: 1;
            margin-left: 180px;
            transition: all 0.3s ease;
        }

        .admin-header {
            background-color: white;
            padding: 15px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 99;
        }

        .toggle-sidebar {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-dark);
            cursor: pointer;
            display: none;
        }

        .header-search {
            flex: 1;
            max-width: 400px;
            margin: 0 20px;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 10px 15px 10px 40px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.9rem;
            transition: var(--hover-transition);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(255, 107, 0, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .action-button {
            background: none;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: var(--text-dark);
            cursor: pointer;
            transition: var(--hover-transition);
            position: relative;
        }

        .action-button:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .notification-badge {
            position: absolute;
            top: 0;
            right: 0;
            background-color: var(--danger-color);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 5px;
            border-radius: 8px;
            transition: var(--hover-transition);
        }

        .user-profile:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.2rem;
        }

        .user-info {
            display: none;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .user-role {
            font-size: 0.8rem;
            color: #888;
        }

        /* Dashboard Content */
        .admin-content {
            padding: 30px;
        }

        .page-title {
            margin-bottom: 30px;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: var(--card-shadow);
            display: flex;
            align-items: center;
            transition: var(--hover-transition);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-right: 15px;
        }

        .stat-icon.orders {
            background-color: rgba(255, 107, 0, 0.1);
            color: var(--primary-color);
        }

        .stat-icon.revenue {
            background-color: rgba(76, 175, 80, 0.1);
            color: var(--success-color);
        }

        .stat-icon.users {
            background-color: rgba(33, 150, 243, 0.1);
            color: var(--info-color);
        }

        .stat-icon.products {
            background-color: rgba(255, 152, 0, 0.1);
            color: var(--warning-color);
        }

        .stat-info {
            flex: 1;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #888;
            font-size: 0.9rem;
        }

        .stat-change {
            display: flex;
            align-items: center;
            font-size: 0.8rem;
            margin-top: 5px;
        }

        .stat-change.positive {
            color: var(--success-color);
        }

        .stat-change.negative {
            color: var(--danger-color);
        }

        .dashboard-sections {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .section-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }

        .section-header {
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
        }

        .section-action {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: var(--hover-transition);
        }

        .section-action:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .section-body {
            overflow-x: scroll;
            padding: 20px;
        }

        /* Recent Orders Table */
        .orders-table {
            width: 100%;
            border-collapse: collapse;
        }

        .orders-table th,
        .orders-table td {
            padding: 12px 15px;
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

        /* Activity Timeline */
        .activity-timeline {
            list-style: none;
        }

        .timeline-item {
            position: relative;
            padding-left: 30px;
            padding-bottom: 20px;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: var(--primary-color);
            z-index: 1;
        }

        .timeline-item::after {
            content: '';
            position: absolute;
            left: 5px;
            top: 12px;
            width: 2px;
            height: calc(100% - 12px);
            background-color: #e0e0e0;
        }

        .timeline-item:last-child::after {
            display: none;
        }

        .timeline-content {
            margin-bottom: 5px;
        }

        .timeline-time {
            font-size: 0.8rem;
            color: #888;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .dashboard-sections {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 992px) {
            .user-info {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .admin-sidebar {
                width: 70px;
                transform: translateX(0);
            }

            .admin-sidebar.expanded {
                width: 280px;
            }

            .logo-text, .menu-text, .menu-category {
                display: none;
            }

            .admin-sidebar.expanded .logo-text,
            .admin-sidebar.expanded .menu-text,
            .admin-sidebar.expanded .menu-category {
                display: block;
            }

            .menu-link {
                justify-content: center;
                padding: 12px;
            }

            .admin-sidebar.expanded .menu-link {
                justify-content: flex-start;
                padding: 12px 20px;
            }

            .admin-main {
                margin-left: 70px;
            }

            .toggle-sidebar {
                display: block;
            }

            .header-search {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .dashboard-stats {
                grid-template-columns: 1fr;
            }

            .admin-content {
                padding: 20px 15px;
            }

            .stat-card {
                padding: 15px;
            }

            .stat-icon {
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
            }

            .stat-value {
                font-size: 1.5rem;
            }
        }
    </style>

</head>
<body>
    <!-- Sidebar (Tetap seperti asli, tidak ditampilkan di sini untuk ringkas) -->

    <!-- Main Content -->
    <main class="admin-main">
        <div class="admin-content">
            <h1 class="page-title">Dashboard</h1>

            <!-- Statistics Cards -->
            <div class="dashboard-stats">
                <div class="stat-card">
                    <div class="stat-icon orders">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">{{ $totalOrders }}</div>
                        <div class="stat-label">Total Orders</div>
                        <div class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> 0% from last month
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon revenue">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                        <div class="stat-label">Total Revenue</div>
                        <div class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> 0% from last month
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon users">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">{{ $totalUsers }}</div>
                        <div class="stat-label">Total Users</div>
                        <div class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> 0% from last month
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon products">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">{{ $totalMenus }}</div>
                        <div class="stat-label">Total Products</div>
                        <div class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> 0% from last month
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Sections -->
            <div class="dashboard-sections">
                <!-- Recent Orders -->
                <div class="section-card">
                    <div class="section-header">
                        <h2 class="section-title">Recent Orders</h2>
                        <a href="{{ url('admin.orders') }}" class="section-action">View All</a>
                    </div>
                    <div class="section-body">
                        <table class="orders-table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($recentOrders->isEmpty())
                                    <tr>
                                        <td colspan="6">Tidak ada pesanan terbaru.</td>
                                    </tr>
                                @else
                                    @foreach($recentOrders as $order)
                                        <tr>
                                            <td class="order-id">#ORD-{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</td>
                                            <td>
                                                <div class="order-customer">
                                                    <div class="customer-avatar">{{ substr($order->user->name, 0, 2) }}</div>
                                                    <div>{{ $order->user->name }}</div>
                                                </div>
                                            </td>
                                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                            <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                            <td><span class="order-status status-{{ strtolower($order->status) }}">{{ $order->status }}</span></td>
                                            <td>
                                                <div class="order-actions">
                                                    <div class="action-icon"><i class="fas fa-eye"></i></div>
                                                    <div class="action-icon"><i class="fas fa-edit"></i></div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="section-card">
                    <div class="section-header">
                        <h2 class="section-title">Recent Activity</h2>
                        <a href="#" class="section-action">View All</a>
                    </div>
                    <div class="section-body">
                        <ul class="activity-timeline">
                            @if($recentUsers->isEmpty())
                                <li>Tidak ada aktivitas terbaru.</li>
                            @else
                                @foreach($recentUsers as $user)
                                    <li class="timeline-item">
                                        <div class="timeline-content">Pengguna baru <strong>{{ $user->name }}</strong> terdaftar</div>
                                        <div class="timeline-time">{{ $user->created_at->diffForHumans() }}</div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleSidebar = document.querySelector('.toggle-sidebar');
            const sidebar = document.querySelector('.admin-sidebar');
            const mainContent = document.querySelector('.admin-main');

            toggleSidebar.addEventListener('click', function() {
                sidebar.classList.toggle('expanded');
            });

            function checkWidth() {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('expanded');
                }
            }

            window.addEventListener('resize', checkWidth);
            checkWidth();
        });
    </script>
</body>
</html>
@endsection
