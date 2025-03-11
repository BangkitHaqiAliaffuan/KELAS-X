<?php
session_start();
ob_start();
require_once '../php/config.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: index.php');
    exit();
}

function getAdminContent()
{
    global $conn;
    $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

    // Whitelist of allowed admin pages
    $allowed_pages = [
        'dashboard' => 'pages/dashboard.php',
        'products' => 'pages/products.php',
        'users' => 'pages/users.php',
        'orders' => 'pages/orders.php',
        'delete_order' => 'pages/delete_order.php',
        'revenue' => 'pages/revenue.php',
        'add_product' => 'pages/add_product.php',
        'delete_product' => 'pages/delete_product.php',
        'edit_product' => 'pages/edit_product.php',
        'manage_users' => 'pages/manage_users.php',
        'order_detail' => 'pages/order_detail.php',
        'cart_order_detail' => 'pages/cart_order_detail.php',
    ];

    if (array_key_exists($page, $allowed_pages)) {
        require_once $allowed_pages[$page];
    } else {
        require_once 'pages/dashboard.php';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Epic Games Store Clone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet">
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

        .card {
            background-color: var(--epic-darker);
            border: 1px solid var(--epic-gray);
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .card-body {
            color: var(--epic-text);
        }

        .table {
            color: var(--epic-text);
        }

        .btn-epic {
            background-color: var(--epic-blue);
            color: white;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-epic:hover {
            background-color: var(--epic-hover);
            color: white;
        }
    </style>
</head>

<body>
    <header class="sticky-top">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="admin.php">Epic Store Admin</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="admin.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?page=products">Games</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?page=users">Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?page=orders">Orders</a>
                        </li>
                    </ul>
                    <div class="d-flex">
                        <a href="logout.php" class="btn btn-danger">Logout</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="container mt-4">
        <?php getAdminContent(); ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    
</body>
</html>