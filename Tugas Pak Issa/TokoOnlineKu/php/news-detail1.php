<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Detail - Epic Games Store</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        body {
            background-color: #121212;
            color: #ffffff;
        }

        .navbar {
            background-color: #202020;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .logo {
            width: 32px;
            height: 32px;
        }

        .search-bar {
            background-color: #303030;
            border: none;
            padding: 0.5rem 1rem;
            color: #ffffff;
            border-radius: 4px;
            width: 250px;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
        }

        .nav-links a {
            color: #ffffff;
            text-decoration: none;
        }

        .navbar-right {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .logout-btn {
            background-color: #ff4757;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
        }

        .user-email {
            color: #3498db;
        }

        .content {
            max-width: 1200px;
            margin: 100px auto 0;
            padding: 0 2rem;
        }

        .article-header {
            margin-bottom: 2rem;
        }

        .article-title {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #ffffff;
        }

        .article-meta {
            display: flex;
            gap: 1rem;
            color: #808080;
            margin-bottom: 2rem;
        }

        .article-image {
            width: 100%;
            height: 500px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 2rem;
        }

        .article-content {
            line-height: 1.6;
            color: #cccccc;
            font-size: 1.1rem;
        }

        .article-content p {
            margin-bottom: 1.5rem;
        }

        .tags {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .tag {
            background-color: #303030;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            color: #808080;
        }

        .related-articles {
            margin-top: 4rem;
        }

        .related-title {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .related-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        .related-card {
            background-color: #202020;
            border-radius: 8px;
            overflow: hidden;
        }

        .related-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .related-card-content {
            padding: 1rem;
        }

        .related-card-title {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }

        .related-card-excerpt {
            color: #808080;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .read-more {
            color: #3498db;
            text-decoration: none;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>

    <main class="content">
        <article class="article-header">
            <h1 class="article-title">Discover the future of gaming: Epic Games Store's 2025 release preview</h1>
            <div class="article-meta">
                <span>19d AGO</span>
                <span>By Craig Pearson, Contributor</span>
            </div>
            <img src="./assets/gamenews.webp" alt="Assassin's Creed Shadows" class="article-image">
            <div class="article-content">
                <p>The Coming Soon section of the Epic Games Store brims with potential. 2025 looks set to be a great year for both brand-new games and AAA sequels, and you can wishlist every one in our store. We’re just leaving January behind—a January that delivered Final Fantasy VII Rebirth, Eternal Strands, and Marvel’s Spider-Man 2—and February (and beyond) will only give us more incredible games to play.</p>
                <!-- Add more paragraphs as needed -->
                <p>A surprising number of AAA titles below have taken bold steps to shake up their core experiences. From a new Football Manager to an adventurous Assassin’s Creed, there’s some real change in the air this year. And there are welcome newcomers on the horizon. Where Dante-inspired dungeon raids lead the way, a cyberpunk slice of life sim follows.

                    Let’s take a look into gaming’s future.</p>
            </div>
            <div class="tags">
                <span class="tag">Gaming News</span>
                <span class="tag">Assassin's Creed</span>
                <span class="tag">Ubisoft</span>
            </div>
        </article>

        <section class="related-articles">
            <h2 class="related-title">Related Articles</h2>
            <div class="related-grid">
                <div class="related-card">
                    <img src="./assets/gamenews2.avif" alt="Related Article 1">
                    <div class="related-card-content">
                        <h3 class="related-card-title">Seven ways Assassin's Creed Shadows shakes up the series' formula</h3>
                        <p class="related-card-excerpt">Ubisoft's latest historical murder holiday makes the most significant changes to the series since 2017's Assassin's Creed Origins.</p>
                        <a href="?menu=news2" class="read-more">Read more</a>
                    </div>
                </div>
                <!-- Add more related article cards as needed -->
            </div>
        </section>
    </main>
</body>

</html>