<?php
include 'config.php';

$category = isset($_GET['category']) ? $_GET['category'] : 'all';

$sql = $category == 'all' ? "SELECT * FROM products" : "SELECT * FROM products WHERE category = '$category'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='product'>";
        echo "<img src='{$row['image']}' alt='{$row['name']}'>";
        echo "<h3>{$row['name']}</h3>";
        echo "<p>{$row['description']}</p>";
        echo "<p>Rp " . number_format($row['price'], 2) . "</p>";
        echo "<button onclick='addToCart({$row['id']})'>Add to Cart</button>";
        echo "</div>";
    }
} else {
    echo "No products available in this category.";
}
?>