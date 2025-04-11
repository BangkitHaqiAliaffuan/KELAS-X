<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "kacamata";

$koneksi = mysqli_connect($host, $user, $password, $database);

if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch categories for filtering
$categoryQuery = "SELECT * FROM kategori";
$categoryResult = mysqli_query($koneksi, $categoryQuery);

// Pagination variables
$limit = 6; // Number of products per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; 
$offset = ($page - 1) * $limit;

// Fetch products based on selected category
$selectedCategoryId = isset($_GET['kategori_id']) ? intval($_GET['kategori_id']) : 0;
$productQuery = "SELECT * FROM produk" . ($selectedCategoryId ? " WHERE kategori_id = $selectedCategoryId" : "") . " LIMIT $limit OFFSET $offset";
$productResult = mysqli_query($koneksi, $productQuery);

// Count total products for pagination
$countQuery = "SELECT COUNT(*) as total FROM produk" . ($selectedCategoryId ? " WHERE kategori_id = $selectedCategoryId" : "");
$countResult = mysqli_query($koneksi, $countQuery);
$totalProducts = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalProducts / $limit);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Kacamata Store</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <style>
        :root {
            --primary-color: #3b82f6;
            --primary-dark: #2563eb;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --bg-primary: #f8fafc;
            --bg-secondary: #ffffff;
            --border-color: #e2e8f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
        }

        .container {
            max-width: 1400px;
            margin: 1.5rem auto;
            padding: 0 1.5rem;
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 2rem;
        }

        /* Filter Styles */
        .filter {
            background: var(--bg-secondary);
            padding: 1.25rem;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            height: fit-content;
            position: sticky;
            top: 1.5rem;
        }

        .filter h3 {
            font-size: 1.1rem;
            color: var(--text-primary);
            margin-bottom: 1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter h3::before {
            content: '⚡';
            font-size: 1.2rem;
        }

        .filter label {
            display: block;
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .filter select {
            width: 100%;
            padding: 0.625rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            font-size: 0.9rem;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .filter select:hover {
            border-color: var(--primary-color);
        }

        /* Products Grid */
        .products {
            width: 100%;
        }

        .products h2 {
            font-size: 1.5rem;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .products h2::before {
            content: '🛍️';
            font-size: 1.5rem;
        }

        .product-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2rem;
        }

        /* Product Card */
        .product-item {
            background: var(--bg-secondary);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
        }

        .product-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .product-item a {
            text-decoration: none;
            color: inherit;
        }

        .product-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-item:hover img {
            transform: scale(1.05);
        }

        .product-info {
            padding: 1rem;
        }

        .product-item h4 {
            color: var(--text-primary);
            font-size: 0.95rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .product-item .price {
            color: var(--primary-color);
            font-size: 1rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 2rem;
        }

        .pagination a {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            background: var(--bg-secondary);
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .pagination a:hover {
            background: var(--primary-color);
            color: white;
        }

        .pagination a.active {
            background: var(--primary-color);
            color: white;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .container {
                grid-template-columns: 200px 1fr;
            }
        }

        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
            }

            .filter {
                position: static;
                margin-bottom: 1rem;
            }

            .product-list {
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            }

            .product-item img {
                height: 180px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="filter">
            <h3>Filter Products</h3>
            <label for="category">Select Category:</label>
            <select id="category" onchange="location = this.value;">
                <option value="?menu=produk">All Categories</option>
                <?php while ($category = mysqli_fetch_assoc($categoryResult)): ?>
                    <option value="?menu=produk&kategori_id=<?php echo $category['id']; ?>" 
                            <?php echo ($selectedCategoryId == $category['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($category['nama']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="products">
            <h2>Available Products</h2>
            <div class="product-list">
                <?php while ($row = mysqli_fetch_assoc($productResult)): ?>
                    <div class="product-item">
                        <a href="?menu=produkdetail&id=<?php echo $row['id']; ?>">
                            <img src="uploads/<?php echo htmlspecialchars($row['gambar']); ?>" 
                                 alt="<?php echo htmlspecialchars($row['produk']); ?>" />
                            <div class="product-info">
                                <h4><?php echo htmlspecialchars($row['produk']); ?></h4>
                                <div class="price">
                                    <span>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></span>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>

            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?menu=produk&kategori_id=<?php echo $selectedCategoryId; ?>&page=<?php echo ($page - 1); ?>">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?menu=produk&kategori_id=<?php echo $selectedCategoryId; ?>&page=<?php echo $i; ?>" 
                       class="<?php if ($i == $page) echo 'active'; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <a href="?menu=produk&kategori_id=<?php echo $selectedCategoryId; ?>&page=<?php echo ($page + 1); ?>">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>