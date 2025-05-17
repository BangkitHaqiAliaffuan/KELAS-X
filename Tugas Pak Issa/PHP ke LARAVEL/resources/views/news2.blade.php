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
            <h1 class="article-title">Seven ways Assassin's Creed Shadows shakes up the series' formula</h1>
            <div class="article-meta">
                <span>14d AGO</span>
                <span>By Epic Games</span>
            </div>
            <img src="./assets/gamenews2.avif" alt="Assassin's Creed Shadows" class="article-image">
            <div class="article-content">
                <p>Ubisoft's latest historical murder holiday makes the most significant changes to the series since 2017's Assassin's Creed Origins.</p>
                <!-- Add more paragraphs as needed -->
                <p>Assassin's Creed Shadows realizes a dream fans have had for years, finally bringing the historical action-adventure series to feudal Japan. Set smack in the middle of the Sengoku period, Shadows lets players experience its story through the eyes of two very different characters: the burly, combat-focused samurai Yasuke and the more stealth-oriented shinobi Naoe.

                    Since its announcement last year, I've been intrigued by the implications this has for the series. Would Ubisoft seize the opportunity to overhaul the series for a new era? Or would Shadows merely be Assassin's Creed wearing a kimono?

                    Earlier this week, I got the chance to find out, playing through the game's prologue and several hours of its open world. And while Shadows is recognisably Assassin's Creed in its structure, it also makes major changes to many of the series' underlying systems. Here are seven ways Ubisoft's latest revitalizes its open world formula.</p>
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
                    <img src="{{ asset('assets/gamenews2.avif') }}" alt="Related Article 1">
                    <div class="related-card-content">
                        <h3 class="related-card-title">Discover the future of gaming: Epic Games Store's 2025 release preview</h3>
                        <p class="related-card-excerpt">From brand-new games to sequels to your existing favorites, 2025 showcases the future of gaming</p>
                        <a href="?menu=news1" class="read-more">Read more</a>
                    </div>
                </div>
                <!-- Add more related article cards as needed -->
            </div>
        </section>
    </main>
</body>

</html>
