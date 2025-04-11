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
  </style>
</head>
<body>
<div class="header">
    <div class="logo"></div>
    <input type="text" class="search-bar" placeholder="Search store">
    <div class="nav-items">
      <a href="#" class="nav-item">Discover</a>
      <a href="#" class="nav-item">Browse</a>
      <a href="cart.php" class="nav-item">Cart</a>
      <a href="#" class="nav-item">News</a>
    </div>
  </div>

  <div class="filters">
    <button class="filter-button active">All Games</button>
    <button class="filter-button">New Releases</button>
    <button class="filter-button">Coming Soon</button>
    <button class="filter-button">Free to Play</button>
  </div>

  <div class="game-cards">
    <div class="game-card">
      <span class="release-date">Available 01/21/25</span>
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
      <span class="release-date">Available 01/21/25</span>
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

    <div class="game-card">
      <span class="release-date">Free to Play</span>
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
      <span class="release-date">Pre-Purchase Available</span>
      <img src="./images/final.webp" alt="Final Fantasy VII Rebirth">
      <div class="card-info">
        <div class="card-category">Coming Soon</div>
        <div class="card-title">FINAL FANTASY VII REBIRTH</div>
        <div class="card-price">
          <span class="final-price">IDR 899,999</span>
        </div>
      </div>
    </div>

    <div class="game-card">
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
    </div>
    <div class="game-card">
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
    </div>
    <div class="game-card">
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
    </div>
    <div class="game-card">
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
    </div>
  </div>
</body>
</html>