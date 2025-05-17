<?php
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?menu=login");
    exit();
}

include 'config.php';

$user_id = $_SESSION['user_id'];

// Process toggle favorite action if submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'toggle_favorite' && isset($_POST['game_id'])) {
    $game_id = $_POST['game_id'];
    
    // Get current favorite status
    $check_query = "SELECT is_favorite FROM owned_games WHERE user_id = ? AND product_id = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("ii", $user_id, $game_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($row = $check_result->fetch_assoc()) {
        // Toggle the favorite status
        $new_status = $row['is_favorite'] ? 0 : 1;
        $update_query = "UPDATE owned_games SET is_favorite = ? WHERE user_id = ? AND product_id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("iii", $new_status, $user_id, $game_id);
        $update_stmt->execute();
        $update_stmt->close();
    }
    
    $check_stmt->close();
    
    // Redirect back to the same page to avoid form resubmission
    header("Location: " . $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET));
    exit();
}

// Handle search and sorting
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'recent';
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

// Updated base query to include first product image
$query = "SELECT p.*, og.purchase_date, og.install_status, og.is_favorite,
          (SELECT pi.image_url 
           FROM product_images pi 
           WHERE pi.product_id = p.id 
           LIMIT 1) as product_images
          FROM owned_games og
          JOIN products p ON og.product_id = p.id
          WHERE og.user_id = ?";

// Add search condition
if (!empty($search)) {
    $query .= " AND p.name LIKE ?";
}

// Add filter condition
if ($filter === 'favorites') {
    $query .= " AND og.is_favorite = 1";
}

// Add sorting
switch ($sort) {
    case 'recent':
        $query .= " ORDER BY og.purchase_date DESC";
        break;
    case 'name':
        $query .= " ORDER BY p.name ASC";
        break;
}

// Prepare and execute query
$stmt = $conn->prepare($query);

if (!empty($search)) {
    $search_param = "%$search%";
    $stmt->bind_param("is", $user_id, $search_param);
} else {
    $stmt->bind_param("i", $user_id);
}

$stmt->execute();
$result = $stmt->get_result();

// Get total games count
$total_query = "SELECT COUNT(*) as total FROM owned_games WHERE user_id = ?";
$total_stmt = $conn->prepare($total_query);
$total_stmt->bind_param("i", $user_id);
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_games = $total_result->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Library</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'epic-dark': '#121212',
                        'epic-gray': '#2a2a2a',
                    }
                }
            }
        }
    </script>
    <style>
        .game-card {
            transition: transform 0.2s;
        }
        .game-card:hover {
            transform: translateY(-4px);
        }
        .game-image {
            transition: opacity 0.3s;
        }
        .game-card:hover .game-image {
            opacity: 0.7;
        }
    </style>
</head>
<body class="bg-epic-dark text-white font-sans">
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Library</h1>
            
            <!-- Search and Sort Controls -->
            <div class="flex items-center space-x-4">
                <form action="" method="GET" class="flex space-x-2">
                    <select name="sort" onchange="this.form.submit()" 
                            class="bg-epic-gray px-4 py-2 rounded hover:bg-opacity-80 transition">
                        <option value="recent" <?= $sort === 'recent' ? 'selected' : '' ?>>Recently Purchased</option>
                        <option value="name" <?= $sort === 'name' ? 'selected' : '' ?>>Name</option>
                    </select>
                    <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" 
                           placeholder="Search games" 
                           class="bg-epic-gray px-4 py-2 rounded w-48 focus:ring-2 focus:ring-blue-500 transition">
                </form>
            </div>
        </div>

        <!-- Filter Buttons -->
        <div class="flex space-x-4 mb-6">
            <a href="?filter=all" 
               class="<?= $filter === 'all' ? 'bg-blue-600' : 'bg-epic-gray' ?> text-white px-4 py-2 rounded transition hover:opacity-90">
                All
            </a>
            <a href="?filter=favorites" 
               class="<?= $filter === 'favorites' ? 'bg-blue-600' : 'bg-epic-gray' ?> text-white px-4 py-2 rounded transition hover:opacity-90">
                Favorites
            </a>
        </div>

        <!-- Games Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if ($result->num_rows === 0): ?>
                <div class="col-span-full text-center py-8">
                    <p class="text-gray-400">No games found in your library.</p>
                </div>
            <?php else: ?>
                <?php while ($game = $result->fetch_assoc()): ?>
                    <div class="game-card bg-epic-gray rounded-lg overflow-hidden relative shadow-lg">
                        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black opacity-50"></div>
                        <img src="<?= htmlspecialchars($game['product_images']) ?>" 
                             alt="<?= htmlspecialchars($game['name']) ?>" 
                             class="game-image w-full h-64 object-cover">
                        
                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            <div class="flex justify-between items-center">
                                <h2 class="text-xl font-bold truncate"><?= htmlspecialchars($game['name']) ?></h2>
                                <form method="POST" action="" class="inline">
                                    <input type="hidden" name="game_id" value="<?= $game['id'] ?>">
                                    <input type="hidden" name="action" value="toggle_favorite">
                                    <button type="submit" class="text-yellow-400 text-2xl hover:scale-110 transition">
                                        <?= $game['is_favorite'] ? '★' : '☆' ?>
                                    </button>
                                </form>
                            </div>
                            
                            <div class="mt-2 flex justify-between items-center">
                                <form method="POST" action="toggle_install.php" class="inline">
                                    <input type="hidden" name="game_id" value="<?= $game['id'] ?>">
                                    <button type="submit" 
                                            class="<?= $game['install_status'] === 'installed' ? 'bg-green-600' : 'bg-blue-600' ?> 
                                                   text-white px-4 py-2 rounded hover:opacity-90 transition">
                                        <?= $game['install_status'] === 'installed' ? 'Installed' : 'Install' ?>
                                    </button>
                                </form>
                                <span class="text-sm text-gray-400">
                                    <?= date('M d, Y', strtotime($game['purchase_date'])) ?>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>

        <!-- Games Count -->
        <div class="mt-6 text-gray-400">
            Showing <?= $result->num_rows ?> of <?= $total_games ?> games
        </div>
    </div>

    <?php if ($result->num_rows > 0): ?>
        <!-- Shop Games Button -->
        <div class="fixed right-8 bottom-8 bg-epic-gray rounded-lg p-4 shadow-lg hover:transform hover:-translate-y-1 transition">
            <h3 class="text-lg font-semibold mb-2">Shop Games & Mods</h3>
            <a href="index.php" class="bg-blue-600 text-white px-4 py-2 rounded block text-center hover:bg-blue-700 transition">
                Browse
            </a>
        </div>
    <?php endif; ?>
</body>
</html>
<?php 
$stmt->close();
$total_stmt->close();
$conn->close(); 
?>