<?php
// pages/dashboard.php
ob_start();

function getDashboardStats($conn) {
    $stats = [];
    
    // Get total products
    $result = $conn->query("SELECT COUNT(*) as total FROM products");
    $stats['total_products'] = $result->fetch_assoc()['total'];
    
    // Get total users
    $result = $conn->query("SELECT COUNT(*) as total FROM users");
    $stats['total_users'] = $result->fetch_assoc()['total'];
    
    // Get pending orders
    $result = $conn->query("SELECT COUNT(*) as total FROM orders WHERE status = 'pending'");
    $stats['pending_orders'] = $result->fetch_assoc()['total'];
    
    // Get total revenue
    $result = $conn->query("SELECT SUM(amount) as total FROM orders WHERE status = 'done'");
    $stats['total_revenue'] = $result->fetch_assoc()['total'] ?? 0;
    
    return $stats;
}

$stats = getDashboardStats($conn);
?>
<style>
    .hidden{
        opacity: 0;
    }
</style>
<h2 class="mb-4">Admin Dashboard</h2>
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Games</h5>
                <p class="card-text display-6"><?= number_format($stats['total_products']) ?></p>
                <a href="?page=products" class="btn btn-epic">View Games</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Active Users</h5>
                <p class="card-text display-6"><?= number_format($stats['total_users']) ?></p>
                <a href="?page=users" class="btn btn-epic">View Users</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Pending Orders</h5>
                <p class="card-text display-6"><?= number_format($stats['pending_orders']) ?></p>
                <a href="?page=orders" class="btn btn-epic">View Orders</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Revenue</h5>
                <p class="card-text display-6">Rp. <?= number_format($stats['total_revenue']) ?></p>
                <a href="?page=revenue" class="btn btn-epic hidden">View Details</a>
            </div>
        </div>
    </div>
</div>

<!-- Chart section -->
<div class="row mt-4">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Games Over Time</h5>
                <div id="gamesChartContainer">
                    <canvas id="gamesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Active Users Over Time</h5>
                <div id="usersChartContainer">
                    <canvas id="usersChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Pending Orders Over Time</h5>
                <div id="ordersChartContainer">
                    <canvas id="ordersChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Revenue Over Time</h5>
                <div id="revenueChartContainer">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add JavaScript for live charts -->
<script>
    // Chart configuration
const chartConfig = {
    games: {
        color: 'rgba(54, 162, 235, 0.8)',
        borderColor: 'rgba(54, 162, 235, 1)',
        label: 'Total Games'
    },
    users: {
        color: 'rgba(75, 192, 192, 0.8)',
        borderColor: 'rgba(75, 192, 192, 1)',
        label: 'Active Users'
    },
    orders: {
        color: 'rgba(255, 159, 64, 0.8)',
        borderColor: 'rgba(255, 159, 64, 1)',
        label: 'Pending Orders'
    },
    revenue: {
        color: 'rgba(153, 102, 255, 0.8)',
        borderColor: 'rgba(153, 102, 255, 1)',
        label: 'Revenue (Rp)'
    }
};

// Chart instances
let charts = {};

// Generate dummy data for charts
function generateDummyData() {
    // Get last 6 months for labels
    const months = [];
    const currentDate = new Date();
    
    for (let i = 5; i >= 0; i--) {
        const date = new Date(currentDate);
        date.setMonth(currentDate.getMonth() - i);
        months.push(date.toLocaleDateString('id-ID', { month: 'short', year: 'numeric' }));
    }
    
    // Games data - steady growth
    const gamesData = months.map((_, index) => {
        return {
            date: months[index],
            count: Math.round(150 + (index * 25) + (Math.random() * 20 - 10))
        };
    });
    
    // Users data - faster growth
    const usersData = months.map((_, index) => {
        return {
            date: months[index],
            count: Math.round(500 + (index * 80) + (Math.random() * 40 - 20))
        };
    });
    
    // Orders data - fluctuating
    const ordersData = months.map((_, index) => {
        const baseValue = 40 + (index * 10);
        // Add seasonality with higher values in the middle months
        const seasonality = index === 2 || index === 3 ? 25 : 0;
        return {
            date: months[index],
            count: Math.round(baseValue + seasonality + (Math.random() * 15 - 7.5))
        };
    });
    
    // Revenue data - growth with seasonal spikes
    const revenueData = months.map((_, index) => {
        const baseValue = 5000000 + (index * 1000000);
        // Add seasonality with higher values in month 3
        const seasonality = index === 3 ? 3000000 : 0;
        return {
            date: months[index],
            total: Math.round(baseValue + seasonality + (Math.random() * 1000000 - 500000))
        };
    });
    
    return {
        games: gamesData,
        users: usersData,
        orders: ordersData,
        revenue: revenueData
    };
}

// Function to initialize charts
function initCharts() {
    const data = generateDummyData();
    
    // Games chart
    const gamesCtx = document.getElementById('gamesChart').getContext('2d');
    charts.games = new Chart(gamesCtx, {
        type: 'line',
        data: {
            labels: data.games.map(item => item.date),
            datasets: [{
                label: chartConfig.games.label,
                data: data.games.map(item => item.count),
                backgroundColor: chartConfig.games.color,
                borderColor: chartConfig.games.borderColor,
                borderWidth: 2,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    
    // Users chart
    const usersCtx = document.getElementById('usersChart').getContext('2d');
    charts.users = new Chart(usersCtx, {
        type: 'line',
        data: {
            labels: data.users.map(item => item.date),
            datasets: [{
                label: chartConfig.users.label,
                data: data.users.map(item => item.count),
                backgroundColor: chartConfig.users.color,
                borderColor: chartConfig.users.borderColor,
                borderWidth: 2,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    
    // Orders chart
    const ordersCtx = document.getElementById('ordersChart').getContext('2d');
    charts.orders = new Chart(ordersCtx, {
        type: 'line',
        data: {
            labels: data.orders.map(item => item.date),
            datasets: [{
                label: chartConfig.orders.label,
                data: data.orders.map(item => item.count),
                backgroundColor: chartConfig.orders.color,
                borderColor: chartConfig.orders.borderColor,
                borderWidth: 2,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    
    // Revenue chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    charts.revenue = new Chart(revenueCtx, {
        type: 'bar',
        data: {
            labels: data.revenue.map(item => item.date),
            datasets: [{
                label: chartConfig.revenue.label,
                data: data.revenue.map(item => item.total),
                backgroundColor: chartConfig.revenue.color,
                borderColor: chartConfig.revenue.borderColor,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function(context) {
                            let value = context.raw;
                            return 'Rp. ' + value.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp. ' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
}

// Function to update charts with new slightly different data
function updateCharts() {
    const data = generateDummyData();
    
    // Update Games chart with slight variations
    charts.games.data.datasets[0].data = data.games.map(item => item.count);
    charts.games.update();
    
    // Update Users chart
    charts.users.data.datasets[0].data = data.users.map(item => item.count);
    charts.users.update();
    
    // Update Orders chart
    charts.orders.data.datasets[0].data = data.orders.map(item => item.count);
    charts.orders.update();
    
    // Update Revenue chart
    charts.revenue.data.datasets[0].data = data.revenue.map(item => item.total);
    charts.revenue.update();
}

// Initial load of charts
document.addEventListener('DOMContentLoaded', function() {
    // Make sure Chart.js is loaded
    if (typeof Chart === 'undefined') {
        console.error('Chart.js is not loaded. Please uncomment the Chart.js script in admin.php');
        document.querySelectorAll('[id$="ChartContainer"]').forEach(container => {
            container.innerHTML = '<div class="alert alert-danger">Chart.js is not loaded. Please uncomment the Chart.js script in admin.php</div>';
        });
        return;
    }
    
    try {
        // Initialize charts with dummy data
        initCharts();
        
        // Set up auto-refresh every 10 seconds for more dynamic appearance
        setInterval(updateCharts, 10000);
    } catch (error) {
        console.error('Error initializing charts:', error);
        // Display error message in chart containers
        document.querySelectorAll('[id$="ChartContainer"]').forEach(container => {
            container.innerHTML = '<div class="alert alert-danger">Could not initialize charts</div>';
        });
    }
});
</script>