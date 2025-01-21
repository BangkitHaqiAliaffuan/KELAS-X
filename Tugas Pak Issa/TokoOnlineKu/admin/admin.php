<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Epic Games Store Clone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --epic-dark: #121212;
            --epic-darker: #202020;
            --epic-blue: #037BEE;
            --epic-hover: #0060bc;
            --epic-text: #ffffff;
            --epic-gray: #2a2a2a;
        }

        body {
            background-color: var(--epic-dark);
            color: var(--epic-text);
        }

        .navbar {
            background-color: var(--epic-darker) !important;
            padding: 1rem;
            border-bottom: 1px solid var(--epic-gray);
        }

        .navbar-brand {
            color: var(--epic-text) !important;
            font-weight: bold;
            font-size: 1.5rem;
        }

        .nav-link {
            color: var(--epic-text) !important;
            margin: 0 10px;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: var(--epic-blue) !important;
        }

        .navbar-toggler {
            border-color: var(--epic-text);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 0.8)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .container {
            margin-top: 2rem;
        }

        h2 {
            color: var(--epic-text);
            font-weight: bold;
            margin-bottom: 1.5rem;
        }

        .card {
            background-color: var(--epic-darker);
            border: 1px solid var(--epic-gray);
            border-radius: 8px;
            margin-bottom: 1rem;
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-body {
            color: var(--epic-text);
        }

        .btn-epic {
            background-color: var(--epic-blue);
            color: white;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .btn-epic:hover {
            background-color: var(--epic-hover);
            color: white;
        }

        footer {
            background-color: var(--epic-darker) !important;
            color: var(--epic-text);
            border-top: 1px solid var(--epic-gray);
            margin-top: 3rem;
        }
    </style>
</head>
<body>

<header class="sticky-top">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">Epic Store Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="products.php">Games</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="users.php">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="orders.php">Orders</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<div class="container">
    <h2 class="text-center">Admin Dashboard</h2>
    
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Games</h5>
                    <p class="card-text display-6">150</p>
                    <a href="products.php" class="btn btn-epic">View Games</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Active Users</h5>
                    <p class="card-text display-6">1,234</p>
                    <a href="users.php" class="btn btn-epic">View Users</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Pending Orders</h5>
                    <p class="card-text display-6">25</p>
                    <a href="orders.php" class="btn btn-epic">View Orders</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Revenue</h5>
                    <p class="card-text display-6">$45K</p>
                    <a href="revenue.php" class="btn btn-epic">View Details</a>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="text-center p-4 mt-4">
    <p>&copy; 2025 Epic Games Store Clone. All rights reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

</body>
</html>