<!DOCTYPE html>
<html lang="en">
<head>
<style>
    body {
      margin: 0;
      padding: 0;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
      background: #121212;
      color: white;
    }

    .header {
      display: flex;
      align-items: center;
      padding: 15px 30px;
      background: #18181b;
      border-bottom: 1px solid #2a2a2a;
    }
    
    .logo {
      background-image: url('./images/pngegg.png');
      background-size: contain;
      background-repeat: no-repeat;
      width: 32px;
      height: 32px;
      margin-right: 20px;
    }

    .search-bar {
      background: #2a2a2a;
      border: none;
      border-radius: 4px;
      padding: 8px 15px;
      color: white;
      width: 300px;
      margin-right: 20px;
    }

    .nav-items {
      display: flex;
      gap: 20px;
    }

    .nav-item {
      color: #fff;
      text-decoration: none;
      font-size: 14px;
    }

    .game-grid {
      padding: 30px;
      background: #121212;
    }

    .grid-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .grid-title {
      font-size: 24px;
      font-weight: bold;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .game-cards {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 25px;
      padding: 10px;
    }

    

    .game-card {
      background: #18181b;
      border-radius: 12px;
      overflow: hidden;
      transition: all 0.3s ease;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      position: relative;
    }

    .game-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 12px 20px rgba(0, 0, 0, 0.2);
    }

    .game-card img {
      width: 100%;
      height: 380px;
      object-fit: cover;
      transition: transform 0.3s ease;
    }

    .game-card:hover img {
      transform: scale(1.05);
    }

    .card-info {
      padding: 20px;
      background: #18181b;
    }

    .card-category {
      font-size: 12px;
      color: #888;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 8px;
    }

    .card-title {
      font-size: 18px;
      font-weight: 600;
      margin-bottom: 12px;
      color: #fff;
      line-height: 1.4;
    }

    .card-price {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .discount {
      background: #0078f2;
      color: white;
      padding: 4px 8px;
      border-radius: 4px;
      font-weight: 600;
      font-size: 14px;
    }

    .original-price {
      text-decoration: line-through;
      color: #888;
      font-size: 14px;
    }

    .final-price {
      font-size: 18px;
      font-weight: 600;
      color: #fff;
    }

    .free-tag {
      background: #2ecc71;
      color: white;
      padding: 4px 8px;
      border-radius: 4px;
      font-weight: 600;
      font-size: 14px;
    }

    .release-date {
      position: absolute;
      top: 15px;
      right: 15px;
      background: rgba(0, 0, 0, 0.85);
      color: white;
      padding: 6px 12px;
      border-radius: 6px;
      font-size: 12px;
      font-weight: 500;
      backdrop-filter: blur(4px);
      z-index: 1;
    }

    .filters {
      display: flex;
      gap: 15px;
      margin-top: 20px;
      margin-bottom: 30px;
      padding: 0 40px;
    }

    .filters a{
      text-decoration: none;
    }

    .filter-button {
      background: #2a2a2a;
      border: none;
      color: white;
      padding: 8px 16px;
      border-radius: 4px;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .filter-button:hover {
      background: #3a3a3a;
    }

    .filter-button.active {
      background: #0078f2;
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        margin: 30px 0;
        padding: 20px;
    }

    .pagination-button {
        background: #2a2a2a;
        border: none;
        color: white;
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s ease;
        min-width: 40px;
        text-align: center;
        text-decoration: none;
    }

    .pagination-button:hover {
        background: #3a3a3a;
    }

    .pagination-button.active {
        background: #0078f2;
        cursor: default;
    }

    .pagination-button.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .pagination-info {
        color: #888;
        font-size: 14px;
        margin: 0 15px;
    }
  </style>
</head>
<body>
  <div class="filters">
    <a href="?menu=produk&filter=all" class="filter-button <?= (!isset($_GET['filter']) || $_GET['filter'] == 'all') ? 'active' : '' ?>">All Games</a>
    <a href="?menu=produk&filter=new" class="filter-button <?= (isset($_GET['filter']) && $_GET['filter'] == 'new') ? 'active' : '' ?>">New Releases</a>
    <a href="?menu=produk&filter=coming" class="filter-button <?= (isset($_GET['filter']) && $_GET['filter'] == 'coming') ? 'active' : '' ?>">Coming Soon</a>
    <a href="?menu=produk&filter=free" class="filter-button <?= (isset($_GET['filter']) && $_GET['filter'] == 'free') ? 'active' : '' ?>">Free to Play</a>
  </div>

  <div class="game-cards">
    <?php
    include 'config.php';

    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $productsPerPage = 8;
    $offset = ($page - 1) * $productsPerPage;

    // Base query
    $baseQuery = "SELECT p.*, c.name as category_name 
                  FROM products p
                  LEFT JOIN categories c ON p.category_id = c.id";

    // Add filter conditions
    $filterCondition = "";
    if (isset($_GET['filter'])) {
        switch($_GET['filter']) {
            case 'new':
                $filterCondition = " WHERE p.release_status = 'New Release'";
                break;
            case 'coming':
                $filterCondition = " WHERE p.release_status = 'Coming Soon'";
                break;
            case 'free':
                $filterCondition = " WHERE p.price = 0";
                break;
            default:
                $filterCondition = "";
        }
    }

    // Combine queries
    $query = $baseQuery . $filterCondition . " LIMIT $productsPerPage OFFSET $offset";
    $result = $conn->query($query);

    // Update total products count based on filter
    $totalProductsQuery = "SELECT COUNT(*) as total FROM products p" . $filterCondition;
    $totalProductsResult = $conn->query($totalProductsQuery);
    $totalProducts = $totalProductsResult->fetch_assoc()['total'];
    $totalPages = ceil($totalProducts / $productsPerPage);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $original_price = $row['price'];
            $discount_percentage = isset($row['discount']) ? $row['discount'] : 0;
            $discounted_price = $original_price * (1 - ($discount_percentage / 100));
    ?>
    <a href="?menu=produk_detail&id=<?= $row['id']?>">
      <div class="game-card">
        <span class="release-date"><?= isset($row['release_status']) ? $row['release_status'] : 'Available Now' ?></span>
        <img src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
        <div class="card-info">
          <div class="card-category"><?= htmlspecialchars($row['category_name']) ?></div>
          <div class="card-title"><?= htmlspecialchars($row['name']) ?></div>
          <div class="card-price">
            <?php if ($original_price == 0): ?>
              <span class="free-tag">Free to Play</span>
              <?php else: ?>
                <?php if ($discount_percentage > 0): ?>
                  <span class="discount">-<?= $discount_percentage ?>%</span>
                  <span class="original-price">IDR <?= number_format($original_price, 0) ?></span>
                  <?php endif; ?>
                  <span class="final-price">IDR <?= number_format($discounted_price, 0) ?></span>
                  <?php endif; ?>
                </div>
              </div>
            </div>
            </a>
            <?php
        }
    } else {
        echo "<div class='no-products'>No products available.</div>";
    }
    ?>
  </div>

  <div class="pagination">
    <?php
    // Calculate total pages and current page
    $totalPages = ceil($totalProducts / $productsPerPage);
    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

    // Calculate the range of page numbers to show
    $range = 2;
    $initial = $currentPage - $range;
    $limit = $currentPage + $range;

    // Get current filter for pagination links
    $filterParam = isset($_GET['filter']) ? '&filter=' . htmlspecialchars($_GET['filter']) : '';

    // Previous button
    if ($currentPage > 1) {
        echo '<a href="?page='.($currentPage-1).$filterParam.'" class="pagination-button">«</a>';
    } else {
        echo '<span class="pagination-button disabled">«</span>';
    }

    // First page
    if ($initial > 1) {
        echo '<a href="?menu=produk&page=1'.$filterParam.'" class="pagination-button">1</a>';
        if ($initial > 2) {
            echo '<span class="pagination-info">...</span>';
        }
    }

    // Page numbers
    for ($i = max(1, $initial); $i <= min($totalPages, $limit); $i++) {
        if ($i == $currentPage) {
            echo '<span class="pagination-button active">'.$i.'</span>';
        } else {
            echo '<a href="?menu=produk&page='.$i.$filterParam.'" class="pagination-button">'.$i.'</a>';
        }
    }

    // Last page
    if ($limit < $totalPages) {
        if ($limit < $totalPages - 1) {
            echo '<span class="pagination-info">...</span>';
        }
        echo '<a href="?menu=produk&page='.$totalPages.$filterParam.'" class="pagination-button">'.$totalPages.'</a>';
    }

    // Next button
    if ($currentPage < $totalPages) {
        echo '<a href="?menu=produk&page='.($currentPage+1).$filterParam.'" class="pagination-button">»</a>';
    } else {
        echo '<span class="pagination-button disabled">»</span>';
    }

    // Show total items and current page info
    echo '<span class="pagination-info">Page '.$currentPage.' of '.$totalPages.' ('.$totalProducts.' items)</span>';
    ?>
  </div>
</body>
</html>