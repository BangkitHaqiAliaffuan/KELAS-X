<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - Epic Games Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Previous styles remain the same */
        body {
            background-color: #121212;
            color: #ffffff;
        }

        .navbar {
            background-color: #2a2a2a !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .navbar-brand,
        .nav-link {
            color: #ffffff !important;
        }

        .nav-link.active {
            background-color: #0074e4 !important;
            border-radius: 5px;
        }

        .container {
            margin-top: 20px;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            background-color: #1a1a1a;
            padding: 20px;
            margin-bottom: 20px;
            border: none;
        }

        .btn-custom {
            background-color: #0074e4;
            /* Set your desired color */
            color: white;
            /* Set text color */
            border: none;
            /* Remove border */
            border-radius: 5px;
            /* Keep rounded corners */
            padding: 6px 16px;
            /* Padding */
            margin: 0 2px;
            /* Margin */
            transition: all 0.3s ease;
            /* Transition for hover effect */
        }

        .btn-custom:hover {
            background-color: #0088ff;
            /* Change color on hover */
            transform: translateY(-1px);
            /* Slight lift effect on hover */
        }


        /* Updated table styles for darker theme */
        .table {
            background-color: #000000;
            /* Set table background to black */
            border-radius: 8px;
            overflow: hidden;
            color: #ffffff;
            /* Set text color to white */
            margin-bottom: 0;
        }

        .table thead {
            background-color: #0074e4;
            color: white;
        }

        .table thead th {
            border-bottom: none;
            font-weight: 600;
        }

        .status-pending {
            background-color: #1d1d1d !important;
        }

        .status-processed {
            background-color: #1d1d1d !important;
        }

        .status-shipped {
            background-color: #1d1d1d !important;
        }

        .table-bordered {
            border: 1px solid #333;
        }

        .table td,
        .table th {
            border-color: #333;
            padding: 12px;
        }

        .table tbody tr {
            transition: background-color 0.3s ease;
        }

        .table tbody tr:hover {
            background-color: #252525 !important;
        }

        /* Button styles remain the same */
        .btn {
            border-radius: 5px;
            padding: 6px 16px;
            margin: 0 2px;
            transition: all 0.3s ease;
            border: none;
            font-weight: 500;
        }

        .btn-process {
            background-color: #0074e4;
            color: white;
        }

        .btn-process:hover {
            background-color: #0088ff;
            transform: translateY(-1px);
        }

        .btn-danger {
            background-color: #2d2d2d;
            color: #ff4757;
            border: 1px solid #ff4757;
        }

        .btn-danger:hover {
            background-color: #ff4757;
            color: white;
            transform: translateY(-1px);
        }

        .btn-info {
            background-color: #2d2d2d;
            color: #00b3ff;
            border: 1px solid #00b3ff;
        }

        .btn-info:hover {
            background-color: #00b3ff;
            color: white;
            transform: translateY(-1px);
        }

        .btn-success {
            background-color: #2d2d2d;
            color: #2ecc71;
            border: 1px solid #2ecc71;
        }

        .btn-success:hover {
            background-color: #2ecc71;
            color: white;
            transform: translateY(-1px);
        }

        .page-title {
            color: #ffffff;
            font-weight: bold;
            margin-bottom: 30px;
            border-bottom: 3px solid #0074e4;
            padding-bottom: 10px;
            display: inline-block;
        }

        .navbar-toggler {
            background-color: #0074e4;
        }

        footer {
            background-color: #2a2a2a !important;
            color: white;
        }

        .badge {
            padding: 8px 12px;
        }
    </style>
</head>

<body>

    <header class="sticky-top">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand fw-bold" href="#">Epic Games Admin</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link px-3" href="admin.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3" href="products.php">Games</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3" href="users.php">Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3" href="#">Orders</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container">
        <div class="card">
            <h2 class="page-title text-center">Order List</h2>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Game Title</th>
                            <th>Customer</th>
                            <th>Region</th>
                            <th>Purchase Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="status-pending">
                            <td>Fortnite - V-Bucks Pack</td>
                            <td>John Walker</td>
                            <td>North America</td>
                            <td>21 Jan 2025 10:30</td>
                            <td><span class="badge bg-warning">Pending</span></td>
                            <td>
                                <button class="btn btn-sm btn-custom">Deliver</button>
                            </td>

                        </tr>
                        <tr class="status-processed">
                            <td>Red Dead Redemption 2</td>
                            <td>Emma Thompson</td>
                            <td>Europe</td>
                            <td>20 Jan 2025 15:45</td>
                            <td><span class="badge bg-success">Processed</span></td>
                            <td>
                                <button class="btn btn-sm btn-custom">Cancel</button>
                            </td>
                        </tr>
                        <tr class="status-shipped">
                            <td>GTA VI - Pre-order</td>
                            <td>Michael Chen</td>
                            <td>Asia Pacific</td>
                            <td>19 Jan 2025 09:15</td>
                            <td><span class="badge bg-primary">Delivered</span></td>
                            <td>
                                <button class="btn btn-sm btn-success">Complete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <footer class="text-center p-4 mt-4">
        <p class="mb-0">&copy; 2025 Epic Games. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

</body>

</html>