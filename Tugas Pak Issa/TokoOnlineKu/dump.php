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
    }

    .game-recommendation-info {
      flex: 1;
    }

    .game-recommendation-title {
      font-size: 14px;
      margin-bottom: 4px;
    }

    .game-recommendation-subtitle {
      font-size: 12px;
      color: #999;
    }

    .sidebar-item {
      display: flex;
      align-items: center;
      padding: 10px;
      color: white;
      text-decoration: none;
      margin-bottom: 10px;
    }

    .sidebar-item.active {
      background: #0078f2;
      border-radius: 4px;
    }

    .game-content {
      flex: 1;
      padding: 30px;
      background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.8)), url('./images/bmw.webp');
      background-size: cover;
      position: relative;
    }

    .game-info {
      position: absolute;
      bottom: 50px;
      left: 50px;
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
  </style>
</head>
<body>
  <div class="header">
    <div class="logo">
    </div>
    <input type="text" class="search-bar" placeholder="Search store">
    <div class="nav-items">
      <a href="#" class="nav-item">Discover</a>
      <a href="#" class="nav-item">Browse</a>
      <a href="#" class="nav-item">News</a>
    </div>
  </div>
  
  <div class="main-content">
    <div class="sidebar">
      <a href="#" class="sidebar-item ">Store</a>
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

    <div class="right-sidebar">
      <a href="#" class="game-recommendation">
        <img src="./images/ss.png" width="52" alt="Fortnite">
        <div class="game-recommendation-info">
          <div class="game-recommendation-title">Fortnite Festival</div>
        </div>
      </a>

      <a href="#" class="game-recommendation">
        <img src="./images/ssky.png" width="52" alt="Marvel Rivals">
        <div class="game-recommendation-info">
          <div class="game-recommendation-title">Marvel Rivals</div>
        </div>
      </a>

      <a href="#" class="game-recommendation">
        <img src="./images/pac.png" width="52" alt="FF7">
        <div class="game-recommendation-info">
          <div class="game-recommendation-title">FINAL FANTASY VII REBIRTH</div>
        </div>
      </a>

      <a href="#" class="game-recommendation">
        <img src="./images/mine.png" width="52" alt="Smite 2">
        <div class="game-recommendation-info">
          <div class="game-recommendation-title">SMITE 2</div>
        </div>
      </a>

      <a href="#" class="game-recommendation">
        <img src="./images/gta.png" width="52" alt="Black Myth: Wukong">
        <div class="game-recommendation-info">
          <div class="game-recommendation-title">Black Myth: Wukong</div>
        </div>
      </a>

      <a href="#" class="game-recommendation">
        <img src="./images/nin.png" width="52" alt="Honkai">
        <div class="game-recommendation-info">
          <div class="game-recommendation-title">Honkai Star Rail</div>
        </div>
      </a>
    </div>
  </div>
</body>
</html>