<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk - Admin Toko Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1c1c1e; /* Dark background for Epic Games theme */
            color: #ffffff; /* White text for contrast */
        }
        .container {
            margin-top: 20px;
        }
        .card {
            background-color: #2c2c2e; /* Card background */
            border: none; /* No border */
            border-radius: 10px; /* Rounded corners */
        }
        .card-title {
            color: #00ff00; /* Green title for emphasis */
        }
        .btn-custom {
            background-color: #0074e4; /* Button color */
            color: white; /* Button text color */
            border: none; /* No border */
        }
        .btn-custom:hover {
            background-color: #0088ff; /* Hover effect */
        }
        .card-img-top {
            height: 300px; /* Fixed height */
            object-fit: cover; /* Maintain aspect ratio and cover the area */
        }
    </style>
</head>
<body>

<header class="bg-dark sticky-top p-3">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Admin Toko Online</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="users.php">Pengguna</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="orders.php">Pesanan</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<div class="container">
    <h1 class="text-center my-4">Daftar Produk</h1>

    <div class="row">
        <!-- Product 1 -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="../images/jotun.jpeg" class="card-img-top" alt="Game 1">
                <div class="card-body">
                    <h5 class="card-title">Jotun</h5>
                    <p class="card-text">Deskripsi singkat tentang Game 1.</p>
                    <button class="btn btn-custom">Edit</button>
                    <button class="btn btn-custom">Hapus</button>
                </div>
            </div>
        </div>

        <!-- Product 2 -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="../images/tekno.webp" class="card-img-top" alt="Game 2">
                <div class="card-body">
                    <h5 class="card-title">Teknotopia</h5>
                    <p class="card-text">Deskripsi singkat tentang Game 2.</p>
                    <button class="btn btn-custom">Edit</button>
                    <button class="btn btn-custom">Hapus</button>
                </div>
            </div>
        </div>

        <!-- Product 3 -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="https://via.placeholder.com/300x200.png?text=Game+3" class="card-img-top" alt="Game 3">
                <div class="card-body">
                    <h5 class="card-title">Game 3</h5>
                    <p class="card-text">Deskripsi singkat tentang Game 3.</p>
                    <button class="btn btn-custom">Edit</button>
                    <button class="btn btn-custom">Hapus</button>
                </div>
            </div>
        </div>

    </div> <!-- End of row -->
</div> <!-- End of container -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>