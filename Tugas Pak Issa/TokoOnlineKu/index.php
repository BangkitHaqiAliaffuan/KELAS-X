<!DOCTYPE html>
<html>
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

    .login-button, .register-button {
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
    }

    .main-content {
      display: flex;
      height: calc(100vh - 65px);
    }

    .sidebar {
      width: 250px;
      background: #18181b;
      padding: 20px;
      flex-shrink: 0;
    }

    .right-sidebar {
      width: 280px;
      background: #18181b;
      padding: 20px;
      flex-shrink: 0;
      border-left: 1px solid #2a2a2a;
    }

    .game-content {
      flex: 1;
      position: relative;
      overflow: hidden;
    }

    .slider {
      height: 100%;
      display: flex;
      transition: transform 0.5s ease-in-out;
    }

    .slide {
      min-width: 100%;
      height: 100%;
      background-size: cover;
      background-position: center;
      position: relative;
    }

    .game-info {
      position: absolute;
      bottom: 50px;
      left: 50px;
      z-index: 2;
    }

    .game-title {
      font-size: 24px;
      margin-bottom: 10px;
    }

    .game-description {
      font-size: 16px;
      margin-bottom: 20px;
      max-width: 500px;
    }

    .price {
      font-size: 18px;
      margin-bottom: 20px;
    }

    .button-group {
      display: flex;
      gap: 10px;
    }

    .buy-button {
      background: white;
      color: black;
      border: none;
      padding: 10px 30px;
      border-radius: 4px;
      cursor: pointer;
      font-weight: bold;
    }

    /* Enhanced button animations */
.buy-button {
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}

.buy-button:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(255, 255, 255, 0.2);
}

.buy-button:active {
  transform: translateY(0);
}

.sidebar {
  position: sticky;
  top: 0;
  height: 80vh;
  overflow-y: auto;
}

/* Game grid section */
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

.grid-title::after {
  content: '›';
  font-size: 28px;
}

.grid-nav {
  display: flex;
  gap: 10px;
}

.nav-button {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.1);
  border: none;
  color: white;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
}

.nav-button:hover {
  background: rgba(255, 255, 255, 0.2);
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
/* Wishlist button animation */
.wishlist-button {
  transition: all 0.3s ease;
}

.wishlist-button:hover {
  background: rgba(255, 255, 255, 0.1);
  transform: translateY(-2px);
}

/* Game recommendation hover effect */
.game-recommendation {
  transition: all 0.3s ease;
}

.game-recommendation:hover {
  transform: translateX(10px);
  background: #2a2a2a;
  box-shadow: -5px 0 15px rgba(0, 0, 0, 0.2);
}

.game-recommendation img {
  transition: all 0.3s ease;
}

.game-recommendation:hover img {
  transform: scale(1.1);
}

/* Nav items hover animation */
.nav-item {
  position: relative;
  transition: color 0.3s ease;
}

.nav-item::after {
  content: '';
  position: absolute;
  width: 0;
  height: 2px;
  bottom: -5px;
  left: 0;
  background-color: #0078f2;
  transition: width 0.3s ease;
}

.nav-item:hover::after {
  width: 100%;
}

/* Search bar focus animation */
.search-bar {
  transition: all 0.3s ease;
}

.search-bar:focus {
  outline: none;
  background: #3a3a3a;
  box-shadow: 0 0 0 2px rgba(0, 120, 242, 0.5);
}

/* Sidebar item hover animation */
.sidebar-item {
  transition: all 0.3s ease;
}

.sidebar-item:hover {
  background: rgba(255, 255, 255, 0.1);
  padding-left: 20px;
}

/* Game slide content hover effect */
.game-info {
  transition: all 0.3s ease;
}

.slide:hover .game-info {
  transform: translateY(-10px);
}

/* Price hover animation */
.price {
  transition: all 0.3s ease;
}

.slide:hover .price {
  transform: scale(1.1);
  color: #0078f2;
}
    .wishlist-button {
      background: transparent;
      color: white;
      border: 1px solid white;
      padding: 10px 20px;
      border-radius: 4px;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .quick-launch {
      margin-top: 50px;
    }

    .quick-launch-title {
      font-size: 12px;
      color: #666;
      margin-bottom: 10px;
    }

    .slider-nav {
      position: absolute;
      bottom: 20px;
      right: 50px;
      display: flex;
      gap: 8px;
      z-index: 2;
    }

    .slider-dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.5);
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .slider-dot.active {
      background: white;
      transform: scale(1.2);
    }

    .game-recommendation {
      display: flex;
      align-items: center;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 4px;
      transition: background-color 0.2s;
      text-decoration: none;
      color: white;
    }

    .game-recommendation:hover {
      background: #2a2a2a;
    }

    .game-recommendation img {
      width: 42px;
      height: 42px;
      border-radius: 4px;
      margin-right: 12px;
      object-fit: cover;
    }

    .game-recommendation-info {
      flex: 1;
    }

    .game-recommendation-title {
      font-size: 14px;
      margin-bottom: 4px;
    }

    .sidebar-item {
      display: flex;
      align-items: center;
      padding: 10px;
      color: white;
      text-decoration: none;
      margin-bottom: 10px;
      border-radius: 4px;
      transition: background-color 0.2s;
    }

    .sidebar-item:hover {
      background: rgba(255, 255, 255, 0.1);
    }

    .sidebar-item.active {
      background: #0078f2;
    }
  </style>
</head>
<body>
<div class="header">
    <div class="header-left">
      <div class="logo"></div>
      <input type="text" class="search-bar" placeholder="Search store">
      <div class="nav-items">
        <a href="#" class="nav-item">Discover</a>
        <a href="produk.php" class="nav-item">Browse</a>
        <a href="cart.php" class="nav-item">Cart</a>
        <a href="#" class="nav-item">News</a>
      </div>
    </div>
    <div class="auth-buttons">
      <a href="login.php" class="login-button">Sign In</a>
      <a href="register.php" class="register-button">Register</a>
    </div>
  </div>


  
  <div class="main-content">
    <div class="sidebar">
      <a href="#" class="sidebar-item">Store</a>
      <a href="#" class="sidebar-item">Library</a>
      <a href="#" class="sidebar-item">Unreal Engine</a>
      
      <div class="quick-launch">
        <div class="quick-launch-title">QUICK LAUNCH</div>
        <a href="#" class="sidebar-item">
          <img src="./images/Half-Life-Logo-500x281.png" width="32" alt="Game icon" style="margin-right: 10px">
          Fortnite
        </a>
      </div>
    </div>
    
    <div class="game-content">
      <div class="slider">
        <div class="slide" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.8)), url('./images/bmw.webp')">
          <div class="game-info">
            <h1 class="game-title">BLACK MYTH: WUKONG</h1>
            <p class="game-description">Set out as the Destined One in this action RPG rooted in Chinese mythology.</p>
            <div class="price">IDR 699,999</div>
            <div class="button-group">
              <button class="buy-button">Buy Now</button>
              <button class="wishlist-button">Add to Wishlist</button>
            </div>
          </div>
        </div>
        <div class="slide" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.8)), url('./images/fortnitebg.jpg')">
          <div class="game-info">
            <h1 class="game-title">Fortnite Festival</h1>
            <p class="game-description">The ultimate battle royale experience evolves with music.</p>
            <div class="price">Free to Play</div>
            <div class="button-group">
              <button class="buy-button">Download Now</button>
              <button class="wishlist-button">Add to Wishlist</button>
            </div>
          </div>
        </div>
        <div class="slide" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.8)), url('./images/final.webp')">
          <div class="game-info">
            <h1 class="game-title">FINAL FANTASY VII REBIRTH</h1>
            <p class="game-description">Continue the story in this stunning reimagining of the classic RPG.</p>
            <div class="price">IDR 899,999</div>
            <div class="button-group">
              <button class="buy-button">Pre-Purchase</button>
              <button class="wishlist-button">Add to Wishlist</button>
            </div>
          </div>
        </div>
      </div>
      <div class="slider-nav"></div>
    </div>

    <div class="right-sidebar">
      <a href="#" class="game-recommendation">
        <img src="./images/ss.png" alt="Fortnite">
        <div class="game-recommendation-info">
          <div class="game-recommendation-title">Fortnite Festival</div>
        </div>
      </a>

      <a href="#" class="game-recommendation">
        <img src="./images/ssky.png" alt="Marvel Rivals">
        <div class="game-recommendation-info">
          <div class="game-recommendation-title">Marvel Rivals</div>
        </div>
      </a>

      <a href="#" class="game-recommendation">
        <img src="./images/pac.png" alt="FF7">
        <div class="game-recommendation-info">
          <div class="game-recommendation-title">FINAL FANTASY VII REBIRTH</div>
        </div>
      </a>

      <a href="#" class="game-recommendation">
        <img src="./images/mine.png" alt="Smite 2">
        <div class="game-recommendation-info">
          <div class="game-recommendation-title">SMITE 2</div>
        </div>
      </a>

      <a href="#" class="game-recommendation">
        <img src="./images/gta.png" alt="Black Myth: Wukong">
        <div class="game-recommendation-info">
          <div class="game-recommendation-title">Black Myth: Wukong</div>
        </div>
      </a>

      <a href="#" class="game-recommendation">
        <img src="./images/nin.png" alt="Honkai">
        <div class="game-recommendation-info">
          <div class="game-recommendation-title">Honkai Star Rail</div>
        </div>
      </a>
    </div>
  </div>
  <div class="game-cards">
    <!-- Original Cards -->
    <div class="game-card">
        <img src="./images/tekno.webp" alt="Technotopia">
        <div class="card-info">
            <div class="card-category">Base Game</div>
            <div class="card-title">Technotopia</div>
            <div class="card-price">
                <span class="discount">-20%</span>
                <span class="original-price">IDR 59,999</span>
                <span class="final-price">IDR 47,499</span>
            </div>
        </div>
    </div>

    <div class="game-card">
        <img src="./images/jotun.jpeg" alt="Jotunnslayer">
        <div class="card-info">
            <div class="card-category">Base Game</div>
            <div class="card-title">Jotunnslayer: Hordes of Hel</div>
            <div class="card-price">
                <span class="discount">-20%</span>
                <span class="original-price">IDR 59,999</span>
                <span class="final-price">IDR 47,499</span>
            </div>
        </div>
    </div>

    <!-- Added Dummy Cards -->
    <!-- <div class="game-card">
        <span class="release-date">Coming Soon</span>
        <img src="./images/bmw.webp" alt="Black Myth: Wukong">
        <div class="card-info">
            <div class="card-category">Pre-Purchase</div>
            <div class="card-title">Black Myth: Wukong</div>
            <div class="card-price">
                <span class="final-price">IDR 699,999</span>
            </div>
        </div>
    </div> -->

    <div class="game-card">
        <img src="./images/fortnitebg.jpg" alt="Fortnite">
        <div class="card-info">
            <div class="card-category">Base Game</div>
            <div class="card-title">Fortnite Festival</div>
            <div class="card-price">
                <span class="final-price">Free</span>
            </div>
        </div>
    </div>

    <div class="game-card">
        <img src="./images/final.webp" alt="Final Fantasy VII Rebirth">
        <div class="card-info">
            <div class="card-category">Coming Soon</div>
            <div class="card-title">FINAL FANTASY VII REBIRTH</div>
            <div class="card-price">
                <span class="final-price">IDR 899,999</span>
            </div>
        </div>
    </div>

    <!-- <div class="game-card">
        <span class="release-date">Early Access</span>
        <img src="./images/marvel.webp" alt="Marvel Rivals">
        <div class="card-info">
            <div class="card-category">Beta Access</div>
            <div class="card-title">Marvel Rivals</div>
            <div class="card-price">
                <span class="discount">-15%</span>
                <span class="original-price">IDR 299,999</span>
                <span class="final-price">IDR 254,999</span>
            </div>
        </div>
    </div> -->
</div>
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