@extends('admin.layouts.app')

@section('title', 'Admin Dashboard - Epic Games Store')

@section('additional_styles')
<style>
    .stats-card {
        background-color: var(--epic-darker);
        border-radius: 10px;
        padding: 1.5rem;
        height: 100%;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border-left: 4px solid var(--epic-blue);
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .stats-card.purple {
        border-left-color: #9c5fff;
    }

    .stats-card.green {
        border-left-color: #00b894;
    }

    .stats-card.orange {
        border-left-color: #fd9644;
    }

    .stats-card .stats-icon {
        width: 48px;
        height: 48px;
        background-color: rgba(3, 123, 239, 0.1);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .stats-card.purple .stats-icon {
        background-color: rgba(156, 95, 255, 0.1);
    }

    .stats-card.green .stats-icon {
        background-color: rgba(0, 184, 148, 0.1);
    }

    .stats-card.orange .stats-icon {
        background-color: rgba(253, 150, 68, 0.1);
    }

    .stats-card .stats-value {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .stats-card .stats-label {
        color: #9a9a9a;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .chart-container {
        background-color: var(--epic-darker);
        border-radius: 10px;
        padding: 1.5rem;
        margin-top: 1.5rem;
    }

    .chart-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }

    .recent-activity {
        background-color: var(--epic-darker);
        border-radius: 10px;
        padding: 1.5rem;
        margin-top: 1.5rem;
    }

    .activity-item {
        padding: 1rem 0;
        border-bottom: 1px solid var(--epic-gray);
        display: flex;
        align-items: center;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
    }

    .activity-icon.blue {
        background-color: rgba(3, 123, 239, 0.1);
        color: var(--epic-blue);
    }

    .activity-icon.purple {
        background-color: rgba(156, 95, 255, 0.1);
        color: #9c5fff;
    }

    .activity-icon.green {
        background-color: rgba(0, 184, 148, 0.1);
        color: #00b894;
    }

    .activity-icon.orange {
        background-color: rgba(253, 150, 68, 0.1);
        color: #fd9644;
    }

    .activity-content {
        flex: 1;
    }

    .activity-title {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .activity-time {
        font-size: 0.8rem;
        color: #9a9a9a;
    }

    .quick-actions {
        background-color: var(--epic-darker);
        border-radius: 10px;
        padding: 1.5rem;
        margin-top: 1.5rem;
    }

    .action-btn {
        display: block;
        background-color: var(--epic-gray);
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
        color: var(--epic-text);
        text-decoration: none;
        transition: all 0.2s ease;
        border: none;
        text-align: left;
        width: 100%;
    }

    .action-btn:hover {
        background-color: var(--epic-blue);
        color: white;
        transform: translateY(-2px);
    }

    .action-btn i {
        margin-right: 0.5rem;
    }

    .welcome-banner {
        background: linear-gradient(135deg, #0078f2 0%, #004a93 100%);
        border-radius: 10px;
        padding: 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .welcome-banner::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 150px;
        height: 100%;
        background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath fill-rule='evenodd' clip-rule='evenodd' d='M50 100C77.6142 100 100 77.6142 100 50C100 22.3858 77.6142 0 50 0C22.3858 0 0 22.3858 0 50C0 77.6142 22.3858 100 50 100ZM50 80C66.5685 80 80 66.5685 80 50C80 33.4315 66.5685 20 50 20C33.4315 20 20 33.4315 20 50C20 66.5685 33.4315 80 50 80Z' fill='rgba(255, 255, 255, 0.1)'/%3E%3C/svg%3E") no-repeat;
        background-position: right center;
        opacity: 0.5;
    }

    .welcome-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: white;
    }

    .welcome-subtitle {
        font-size: 1rem;
        color: rgba(255, 255, 255, 0.8);
        max-width: 80%;
    }

    .top-products {
        background-color: var(--epic-darker);
        border-radius: 10px;
        padding: 1.5rem;
        margin-top: 1.5rem;
    }

    .product-item {
        display: flex;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid var(--epic-gray);
    }

    .product-item:last-child {
        border-bottom: none;
    }

    .product-image {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        object-fit: cover;
        margin-right: 1rem;
    }

    .product-details {
        flex: 1;
    }

    .product-name {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .product-price {
        font-size: 0.9rem;
        color: var(--epic-blue);
    }

    .product-sales {
        background-color: rgba(3, 123, 239, 0.1);
        color: var(--epic-blue);
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }
</style>
@endsection

@section('content')
<div class="welcome-banner">
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <h1 class="welcome-title">Welcome back, {{ Auth::guard('admin')->user()->username }}</h1>
    <p class="welcome-subtitle">Here's what's happening with your store today.</p>
</div>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="stats-card">
            <div class="stats-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            </div>
            <div class="stats-value">{{ $totalUsers }}</div>
            <div class="stats-label">Total Users</div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="stats-card purple">
            <div class="stats-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-purple"><path d="M20.91 8.84 8.56 2.23a1.93 1.93 0 0 0-1.81 0L3.1 4.13a2.12 2.12 0 0 0-.05 3.69l12.22 6.93a2 2 0 0 0 1.94 0L21 12.51a2.12 2.12 0 0 0-.09-3.67Z"></path><path d="m3.09 8.84 12.35-6.61a1.93 1.93 0 0 1 1.81 0l3.65 1.9a2.12 2.12 0 0 1 .1 3.69L8.73 14.75a2 2 0 0 1-1.94 0L3 12.51a2.12 2.12 0 0 1 .09-3.67Z"></path><line x1="12" y1="22" x2="12" y2="13"></line><path d="M20 13.5v3.37a2.06 2.06 0 0 1-1.11 1.83l-6 3.08a1.93 1.93 0 0 1-1.78 0l-6-3.08A2.06 2.06 0 0 1 4 16.87V13.5"></path></svg>
            </div>
            <div class="stats-value">{{ $totalProducts }}</div>
            <div class="stats-label">Total Games</div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="stats-card green">
            <div class="stats-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-success"><rect width="20" height="14" x="2" y="5" rx="2"></rect><line x1="2" x2="22" y1="10" y2="10"></line></svg>
            </div>
            <div class="stats-value">{{ $totalOrders }}</div>
            <div class="stats-label">Total Orders</div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="stats-card orange">
            <div class="stats-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-warning"><circle cx="12" cy="12" r="10"></circle><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path><path d="M2 12h20"></path></svg>
            </div>
            <div class="stats-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            <div class="stats-label">Total Revenue</div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="chart-container">
            <h2 class="chart-title">Monthly Revenue</h2>
            <div style="height: 300px; position: relative;">
                <!-- The canvas will be created dynamically by JavaScript -->
                <div id="chartContainer"></div>
            </div>
        </div>

        <div class="recent-activity">
            <h2 class="chart-title">Recent Activity</h2>
            <div id="activity-container">
                @if(empty($recentActivity))
                    <div class="text-center py-4">No recent activity found</div>
                @else
                    @foreach($recentActivity as $activity)
                        <div class="activity-item">
                            <div class="activity-icon {{ $activity['type'] == 'user' ? 'purple' : ($activity['type'] == 'product' ? 'green' : 'blue') }}">
                                @if($activity['type'] == 'user')
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                @elseif($activity['type'] == 'product')
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.91 8.84 8.56 2.23a1.93 1.93 0 0 0-1.81 0L3.1 4.13a2.12 2.12 0 0 0-.05 3.69l12.22 6.93a2 2 0 0 0 1.94 0L21 12.51a2.12 2.12 0 0 0-.09-3.67Z"></path><path d="m3.09 8.84 12.35-6.61a1.93 1.93 0 0 1 1.81 0l3.65 1.9a2.12 2.12 0 0 1 .1 3.69L8.73 14.75a2 2 0 0 1-1.94 0L3 12.51a2.12 2.12 0 0 1 .09-3.67Z"></path><line x1="12" y1="22" x2="12" y2="13"></line><path d="M20 13.5v3.37a2.06 2.06 0 0 1-1.11 1.83l-6 3.08a1.93 1.93 0 0 1-1.78 0l-6-3.08A2.06 2.06 0 0 1 4 16.87V13.5"></path></svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path><path d="M3 6h18"></path><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                                @endif
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">{{ $activity['message'] }}</div>
                                <div class="activity-time">{{ $activity['time'] }}</div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="quick-actions">
            <h2 class="chart-title">Quick Actions</h2>
            <a href="{{ route('admin.products.add') }}" class="action-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2"><path d="M5 12h14"></path><path d="M12 5v14"></path></svg>
                Add New Game
            </a>
            <a href="{{ route('admin.products') }}" class="action-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2"><path d="M20.91 8.84 8.56 2.23a1.93 1.93 0 0 0-1.81 0L3.1 4.13a2.12 2.12 0 0 0-.05 3.69l12.22 6.93a2 2 0 0 0 1.94 0L21 12.51a2.12 2.12 0 0 0-.09-3.67Z"></path><path d="m3.09 8.84 12.35-6.61a1.93 1.93 0 0 1 1.81 0l3.65 1.9a2.12 2.12 0 0 1 .1 3.69L8.73 14.75a2 2 0 0 1-1.94 0L3 12.51a2.12 2.12 0 0 1 .09-3.67Z"></path><line x1="12" y1="22" x2="12" y2="13"></line><path d="M20 13.5v3.37a2.06 2.06 0 0 1-1.11 1.83l-6 3.08a1.93 1.93 0 0 1-1.78 0l-6-3.08A2.06 2.06 0 0 1 4 16.87V13.5"></path></svg>
                Manage Games
            </a>
            <a href="{{ route('admin.users') }}" class="action-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                Manage Users
            </a>
            <a href="{{ route('admin.orders') }}" class="action-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path><path d="M3 6h18"></path><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                View Orders
            </a>
            <a href="{{ route('admin.revenue') }}" class="action-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2"><path d="M3 3v18h18"></path><path d="m19 9-5 5-4-4-3 3"></path></svg>
                Revenue Reports
            </a>
        </div>

        <div class="top-products">
            <h2 class="chart-title">Top Selling Games</h2>
            <div id="top-products-container">
                @if($topProducts->isEmpty())
                    <div class="text-center py-4">No products found</div>
                @else
                    @foreach($topProducts as $product)
                        <div class="product-item">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="product-image">
                            <div class="product-details">
                                <div class="product-name">{{ $product->name }}</div>
                                <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                            </div>
                            <div class="product-sales">{{ $product->sales }} sold</div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Data monthlyRevenue dari view
    const monthlyRevenue = @json($monthlyRevenue);

    // Complete reset and recreate of chart
    recreateRevenueChart(monthlyRevenue);

    function recreateRevenueChart(monthlyRevenue) {
        // First, completely remove any existing chart and canvas
        const chartContainer = document.getElementById('chartContainer');
        chartContainer.innerHTML = '';

        // Create a new canvas element with explicit dimensions
        const newCanvas = document.createElement('canvas');
        newCanvas.id = 'revenueChart';
        newCanvas.style.display = 'block';
        newCanvas.style.width = '100%';
        newCanvas.style.height = '300px';

        // Add the new canvas to the container
        chartContainer.appendChild(newCanvas);

        // Now create chart on the fresh canvas
        const ctx = newCanvas.getContext('2d');

        // Buat gradient untuk chart
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(3, 123, 239, 0.6)');
        gradient.addColorStop(1, 'rgba(3, 123, 239, 0)');

        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const values = Array(12).fill(0);

        // Isi nilai dari data monthlyRevenue
        monthlyRevenue.forEach(item => {
            values[item.month - 1] = parseFloat(item.revenue) || 0;
        });

        // Create chart with Chart.js
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Revenue',
                    data: values,
                    backgroundColor: gradient,
                    borderColor: '#037BEE',
                    borderWidth: 2,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#037BEE',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#202020',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: '#2a2a2a',
                        borderWidth: 1,
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + numberWithCommas(context.raw);
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            color: '#9a9a9a'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(255, 255, 255, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#9a9a9a',
                            callback: function(value) {
                                if (value >= 1000000) {
                                    return 'Rp ' + (value / 1000000).toFixed(1) + 'M';
                                } else if (value >= 1000) {
                                    return 'Rp ' + (value / 1000).toFixed(1) + 'K';
                                }
                                return 'Rp ' + value;
                            }
                        }
                    }
                }
            }
        });
    }

    // Fungsi bantu untuk format angka dengan pemisah ribuan
    function numberWithCommas(x) {
        if (x === undefined || x === null) return '0';
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
});
</script>
@endsection

