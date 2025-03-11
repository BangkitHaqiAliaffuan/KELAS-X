<?php
ob_start();
session_start();
include 'php/config.php';
function getContent()
{
  // Get the menu parameter from URL, default to 'home' if not set
  $menu = isset($_GET['menu']) ? $_GET['menu'] : 'home';


  switch ($menu) {
    case 'profile':
      require_once 'php/profile.php';
      break;
    case 'login':
      require_once 'php/login.php';
      break;
    case 'history':
      require_once 'php/history.php';
      break;
    case 'logout':
      require_once 'php/logout.php';
      break;
    case 'payment_cart':
      require_once 'php/payment_cart.php';
      break;
    case 'cart':
      require_once 'php/cart.php';
      break;
    case 'order':
      require_once 'php/orders.php';
      break;
    case 'payment_instruction':
      require_once 'php/payment-instruction.php';
      break;
    case 'register':
      require_once 'php/register.php';
      break;
    case 'produk':
      require_once 'php/products.php';
      break;
    case 'news':
      require_once 'php/news.php';
      break;
    case 'news1':
      require_once 'php/news-detail1.php';
      break;
    case 'news2':
      require_once 'php/news-detail2.php';
      break;
    case 'library':
      require_once 'php/library.php';
      break;
    case 'produk_detail':
      require_once 'php/produk-detail.php';
      break;
    case 'home':
      require_once 'home.php';
      break;
    case 'order_detail':
      require_once 'php/order_detail.php';
      break;
    case 'cart_order_detail':
      require_once 'php/cart_order_detail.php';
      break;
    case 'friends':
      require_once 'php/friends.php';
      break;
  }

  // Whitelist of allowed pages/menus
}
?>
<!DOCTYPE html>
<html>

<head>
  <style>
    ::-webkit-scrollbar {
  display: none;
}
    .search-container {
      position: relative;
    }

    .search-results {
      position: absolute;
      top: 100%;
      left: 0;
      width: 100%;
      max-height: 400px;
      overflow-y: auto;
      background: #18181b;
      border-radius: 4px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      z-index: 1000;
      display: none;
    }

    .search-result-item {
      display: flex;
      align-items: center;
      padding: 10px;
      border-bottom: 1px solid #2a2a2a;
      cursor: pointer;
      transition: background-color 0.3s ease;
      text-decoration: none;
    }

    .search-result-item:hover {
      background-color: #2a2a2a;
    }

    .search-result-image {
      width: 50px;
      height: 50px;
      object-fit: cover;
      border-radius: 4px;
      margin-right: 10px;
    }

    .search-result-info {
      flex-grow: 1;
    }

    .search-result-name {
      color: white;
      font-size: 14px;
      margin-bottom: 4px;
    }

    .search-result-price {
      color: #0078f2;
      font-size: 12px;
    }

    .no-results {
      padding: 15px;
      text-align: center;
      color: #888;
    }

    /* Keep all your existing styles here */
    body a {
      text-decoration: none;
    }

    body a {
      text-decoration: none;
    }

    .loading-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: #121212;
      z-index: 9999;
      display: flex;
      justify-content: center;
      align-items: center;
      opacity: 1;
      transition: opacity 0.5s ease;
    }

    .loading-overlay.hidden {
      opacity: 0;
      pointer-events: none;
    }

    .loading-character {
      width: 200px;
      height: 181.3px;
      background: url('./images/dog.png') left center;
      overflow: hidden;
    }

    .pagination {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 10px;
      margin-top: 20px;
      padding: 15px;
    }

    .pagination-button {
      padding: 8px 15px;
      background: #18181b;
      color: white;
      text-decoration: none;
      border-radius: 4px;
      transition: all 0.3s ease;
    }

    .pagination-button:hover {
      background: #0078f2;
    }

    .pagination-button.active {
      background: #0078f2;
      font-weight: bold;
    }

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
      justify-content: space-between;
    }

    .header-left {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .logo {
      background-image: url('./images/pngegg.png');
      background-size: contain;
      background-repeat: no-repeat;
      width: 32px;
      height: 32px;
      margin-right: 20px;
    }

    .auth-buttons {
      display: flex;
      gap: 12px;
      align-items: center;
    }

    .login-button,
    .register-button {
      text-decoration: none;
      padding: 8px 20px;
      border-radius: 4px;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .login-button {
      background: transparent;
      color: white;
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .login-button:hover {
      border-color: white;
      background: rgba(255, 255, 255, 0.1);
    }

    .register-button {
      background: #0078f2;
      color: white;
      border: none;
    }

    .register-button:hover {
      background: #0066cc;
      transform: translateY(-2px);
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
      position: relative;
      transition: color 0.3s ease;
      overflow: hidden;
      display: inline-block;
      padding-bottom: 5px;
    }

    .nav-item::after {
      content: '';
      position: absolute;
      width: 100%;
      height: 2px;
      bottom: 0;
      left: -100%;
      background-color: #0078f2;
      transition: all 0.3s ease;
    }

    .nav-item:hover {
      color: #0078f2;
    }

    .nav-item:hover::after {
      left: 0;
    }

    .nav-item::before {
      content: '';
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: -100%;
      background-color: rgba(0, 120, 242, 0.1);
      z-index: -1;
      transition: all 0.3s ease;
    }

    .nav-item:hover::before {
      left: 0;
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

    /* Hide release date by default */
    .game-card .release-date {
      display: none;
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

    /* Show release date on hover */
    .game-card:hover .release-date {
      display: block;
    }

    .main-content {
      height: calc(100vh - 65px);
    }

    .best-games-section {
      padding: 40px 30px;
      background: #121212;
    }

    .best-games-header {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 32px;
    }

    .best-games-title {
      font-size: 28px;
      font-weight: bold;
      color: white;
    }

    .trophy-icon {
      color: #FFD700;
      width: 32px;
      height: 32px;
    }

    .best-games-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 24px;
    }

    .card-description {
      color: #888;
      font-size: 14px;
      margin: 8px 0;
      line-height: 1.4;
    }

    @media (max-width: 1200px) {
      .best-games-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 768px) {
      .best-games-grid {
        grid-template-columns: 1fr;
      }
    }

    .status-badge {
      display: block !important;
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

    .user-email {
      color: #0078f2;
      /* Warna teks biru yang sesuai dengan tema */
      font-size: 14px;
      font-weight: 500;
      text-decoration: none;
      padding: 8px 20px;
      border-radius: 4px;
      background: rgba(255, 255, 255, 0.1);
      /* Latar belakang transparan */
      border: 1px solid rgba(255, 255, 255, 0.2);
      /* Border transparan */
      transition: all 0.3s ease;
      cursor: pointer;
    }

    .user-email:hover {
      background: rgba(255, 255, 255, 0.2);
      /* Latar belakang lebih terang saat hover */
      border-color: white;
      /* Border menjadi putih saat hover */
      color: white;
      /* Warna teks menjadi putih saat hover */
      transform: translateY(-2px);
      /* Efek hover sedikit naik */
    }

    .logout-button {
      text-decoration: none;
      padding: 8px 20px;
      border-radius: 4px;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s ease;
      background: #ff4d4d;
      /* Warna merah untuk tombol logout */
      color: white;
      border: none;
      margin-left: 12px;
      /* Jarak antara user-email dan tombol logout */
    }

    .logout-button:hover {
      background: #cc0000;
      /* Warna merah lebih gelap saat hover */
      transform: translateY(-2px);
      /* Efek hover sedikit naik */
    }
  </style>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const loadingOverlay = document.getElementById('loading-overlay');
      const loadingCharacter = document.getElementById('loading-character');

      const searchInput = document.getElementById('searchInput');
      const searchResults = document.getElementById('searchResults');
      let debounceTimer;

      if (searchInput && searchResults) {
        searchInput.addEventListener('input', function() {
          clearTimeout(debounceTimer);
          debounceTimer = setTimeout(() => {
            const query = this.value.trim();
            if (query.length >= 2) {
              fetchSearchResults(query);
            } else {
              searchResults.style.display = 'none';
            }
          }, 300);
        });

        // Close search results when clicking outside
        document.addEventListener('click', function(e) {
          if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.style.display = 'none';
          }
        });
      }

      function fetchSearchResults(query) {
        fetch(`php/search.php?query=${encodeURIComponent(query)}`)
          .then(response => {
            if (!response.ok) {
              throw new Error('Network response was not ok');
            }
            return response.json();
          })
          .then(data => {
            searchResults.innerHTML = '';

            if (data.length === 0) {
              searchResults.innerHTML = '<div class="no-results">No products found</div>';
            } else {
              data.forEach(product => {
                const resultItem = document.createElement('a');
                resultItem.href = `?menu=produk_detail&id=${product.id}`;
                resultItem.className = 'search-result-item';
                resultItem.innerHTML = `
                            <img src="uploads/${product.image}" alt="${product.name}" class="search-result-image">
                            <div class="search-result-info">
                                <div class="search-result-name">${product.name}</div>
                                <div class="search-result-price">IDR ${product.price}</div>
                            </div>
                        `;
                searchResults.appendChild(resultItem);
              });
            }

            searchResults.style.display = 'block';
          })
          .catch(error => {
            console.error('Error:', error);
            searchResults.innerHTML = '<div class="no-results">Error fetching results</div>';
            searchResults.style.display = 'block';
          });
      }

      // Sprite animation configuration
      const spriteWidth = 200;
      const spriteHeight = 181.3;
      const totalFrames = 9; // Assuming 9 frames in the sprite sheet
      const animationSpeed = 100; // milliseconds between frames
      const frameY = 6; // Zero-indexed Y position (7th row)

      let currentFrame = 0;

      function animateSprite() {
        // Calculate the background position based on current frame
        const xPosition = -(currentFrame * spriteWidth);
        const yPosition = -(frameY * spriteHeight);

        loadingCharacter.style.backgroundPosition = `${xPosition}px ${yPosition}px`;

        // Move to next frame
        currentFrame = (currentFrame + 1) % totalFrames;
      }

      // Start sprite animation
      const spriteInterval = setInterval(animateSprite, animationSpeed);

      // Hide loading overlay after 1.5 seconds
      setTimeout(function() {
        clearInterval(spriteInterval); // Stop sprite animation
        loadingOverlay.classList.add('hidden');

        // Completely remove the overlay after the fade-out transition
        setTimeout(function() {
          loadingOverlay.style.display = 'none';
        }, 500);
      }, 1500);
    });
  </script>
</head>

<body>

  <div id="loading-overlay" class="loading-overlay">
    <div id="loading-character" class="loading-character"></div>
  </div>

  <div class="header">
    <div class="header-left">
      <a href="index.php">
        <div class="logo"></div>
      </a>
      <div class="search-container">
        <input type="text" class="search-bar" id="searchInput" placeholder="Search store">
        <div class="search-results" id="searchResults"></div>
      </div>
      <div class="nav-items">
        <a href="?menu=home" class="nav-item">Discover</a>
        <a href="?menu=produk" class="nav-item">Browse</a>
        <a href="?menu=cart" class="nav-item">Cart</a>
        <a href="?menu=news" class="nav-item">News</a>
        <a href="?menu=history" class="nav-item">History</a>
        <a href="?menu=friends" class="nav-item">Friends</a>
      </div>
    </div>
    <div class="auth-buttons">
      <?php if (!isset($_SESSION['user_email'])) { ?>
        <a href="?menu=login" class="login-button">Sign In</a>
        <a href="?menu=register" class="register-button">Register</a>
      <?php } else { ?>
        <a href="?menu=logout" class="logout-button">Logout</a>
        <a href="?menu=profile" class="user-email"><?= $_SESSION['user_email'] ?></a>
      <?php } ?>
    </div>
  </div>

  <div class="main-content">
    <?php getContent(); ?>
  </div>
  <?php

  if (!isset($_GET['menu']) || $_GET['menu'] === 'home') {
  ?>
    <!-- Add this right after your main-content div but before the regular game cards -->
    <div class="best-games-section">
      <div class="best-games-header">
        <svg class="trophy-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M8.21 13.89L7 23l5-3 5 3-1.21-9.11" />
          <path d="M6 4h12v7a6 6 0 01-12 0V4z" />
          <path d="M6 4h12" />
        </svg>
        <h2 class="best-games-title">Best Games</h2>
      </div>

      <div class="best-games-grid">
        <?php
        // Query to get the 4 best games based on available columns
        $bestGamesQuery = "SELECT p.*, c.name as category_name 
                      FROM products p
                      LEFT JOIN categories c ON p.category_id = c.id 
                      ORDER BY p.price DESC  
                      LIMIT 4";

        $bestGamesResult = $conn->query($bestGamesQuery);

        if ($bestGamesResult->num_rows > 0) {
          while ($row = $bestGamesResult->fetch_assoc()) {
            // Calculate discount if applicable
            $original_price = $row['price'];
            $discount_percentage = isset($row['discount']) ? $row['discount'] : 0;
            $discounted_price = $original_price * (1 - ($discount_percentage / 100));

            // Set status based on release_status
            $status = 'Available Now';
            if ($row['release_status'] === 'coming_soon') {
              $status = 'Coming Soon';
            } elseif ($row['release_status'] === 'pre_order') {
              $status = 'Pre-Order';
            }
        ?>
            <a href="?menu=produk_detail&id=<?= $row['id'] ?>">
              <div class="game-card">
                <span class="status-badge"><?= htmlspecialchars($status) ?></span>
                <img src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
                <div class="card-info">
                  <div class="card-category"><?= htmlspecialchars($row['category_name']) ?></div>
                  <div class="card-title"><?= htmlspecialchars($row['name']) ?></div>
                  <div class="card-description"><?= htmlspecialchars(substr($row['description'], 0, 100)) ?>...</div>
                  <div class="card-price">
                    <?php if ($discount_percentage > 0): ?>
                      <span class="discount">-<?= $discount_percentage ?>%</span>
                      <span class="original-price">IDR <?= number_format($original_price, 0) ?></span>
                    <?php endif; ?>
                    <span class="final-price">IDR <?= number_format($discounted_price, 0) ?></span>
                  </div>
                </div>
              </div>
            </a>
        <?php
          }
        } else {
          echo "<div class='no-products'>No featured games available.</div>";
        }
        ?>
      </div>
    </div>

    <style>

    </style>
  <?php
  }
  ?>
  <script>
    const slider = document.querySelector('.slider');
    const slides = document.querySelectorAll('.slide');
    const sliderNav = document.querySelector('.slider-nav');
    let currentSlide = 0;

    // Create navigation dots
    slides.forEach((_, index) => {
      const dot = document.createElement('div');
      dot.className = `slider-dot ${index === 0 ? 'active' : ''}`;
      dot.addEventListener('click', () => goToSlide(index));
      sliderNav.appendChild(dot);
    });

    function updateSliderPosition() {
      slider.style.transform = `translateX(-${currentSlide * 100}%)`;

      // Update dots
      document.querySelectorAll('.slider-dot').forEach((dot, index) => {
        dot.classList.toggle('active', index === currentSlide);
      });
    }

    function goToSlide(index) {
      currentSlide = index;
      updateSliderPosition();
    }

    // Auto-slide every 5 seconds
    setInterval(() => {
      currentSlide = (currentSlide + 1) % slides.length;
      updateSliderPosition();
    }, 2500);
  </script>
</body>

</html>