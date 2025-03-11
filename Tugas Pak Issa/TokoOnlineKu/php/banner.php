<?php
include 'config.php';

$sql = "SELECT * FROM banners ORDER BY RAND() LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<img src='{$row['image']}' alt='Banner'>";
} else {
    echo "No banner available.";
}
?>