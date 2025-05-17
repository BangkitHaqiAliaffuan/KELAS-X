<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users - Epic Games Store Clone</title>
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

        /* Override Bootstrap's default white background */
        .table {
            --bs-table-bg: var(--epic-darker);
            --bs-table-color: var(--epic-text);
            --bs-table-hover-bg: var(--epic-gray);
            --bs-table-hover-color: var(--epic-text);
            border-color: var(--epic-gray);
        }

        .table th,
        .table td {
            background-color: var(--epic-darker) !important;
            color: var(--epic-text) !important;
            border-color: var(--epic-gray) !important;
        }

        .table tr:hover td {
            background-color: var(--epic-gray) !important;
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
            padding: 1.5rem;
        }

        .form-control {
            background-color: var(--epic-dark);
            border: 1px solid var(--epic-gray);
            color: var(--epic-text);
        }

        .form-control:focus {
            background-color: var(--epic-dark);
            border-color: var(--epic-blue);
            color: var(--epic-text);
            box-shadow: 0 0 0 0.25rem rgba(3, 123, 238, 0.25);
        }

        .btn-edit {
            background-color: var(--epic-blue);
            color: white;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-edit:hover {
            background-color: var(--epic-hover);
            color: white;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-delete:hover {
            background-color: #bb2d3b;
            color: white;
        }

        .btn-submit {
            background-color: var(--epic-blue);
            color: white;
            border: none;
            padding: 0.5rem 1.5rem;
            transition: background-color 0.3s ease;
        }

        .btn-submit:hover {
            background-color: var(--epic-hover);
            color: white;
        }

        /* Override any Bootstrap background colors */
        .bg-light {
            background-color: var(--epic-darker) !important;
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
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
                        <a class="nav-link active" href="#">Users</a>
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
    <div class="card">
        <h2 class="mb-4 text-capitalize text-white">User List</h2>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>EpicGamer123</td>
                        <td>epicgamer@email.com</td>
                        <td>Jl. Merdeka No. 123, Jakarta Selatan</td>
                        <td>
                            <button class="btn btn-edit btn-sm">Edit</button>
                            <button class="btn btn-delete btn-sm">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>FortnitePro</td>
                        <td>fortnite.pro@email.com</td>
                        <td>Jl. Sudirman No. 45, Jakarta Pusat</td>
                        <td>
                            <button class="btn btn-edit btn-sm">Edit</button>
                            <button class="btn btn-delete btn-sm">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>RocketLeague_ID</td>
                        <td>rocket.league@email.com</td>
                        <td>Jl. Gatot Subroto No. 87, Bandung</td>
                        <td>
                            <button class="btn btn-edit btn-sm">Edit</button>
                            <button class="btn btn-delete btn-sm">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>UnrealDev</td>
                        <td>unreal.dev@email.com</td>
                        <td>Jl. Diponegoro No. 155, Surabaya</td>
                        <td>
                            <button class="btn btn-edit btn-sm">Edit</button>
                            <button class="btn btn-delete btn-sm">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>GamerGirl_ID</td>
                        <td>gamergirl@email.com</td>
                        <td>Jl. Ahmad Yani No. 22, Yogyakarta</td>
                        <td>
                            <button class="btn btn-edit btn-sm">Edit</button>
                            <button class="btn btn-delete btn-sm">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card text-white">
        <h3>Add New User</h3>
        <form>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-submit">Add User</button>
        </form>
    </div>
</div>

<footer class="text-center p-4">
    <p>&copy; 2025 Epic Games Store Clone. All rights reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

</body>
</html>