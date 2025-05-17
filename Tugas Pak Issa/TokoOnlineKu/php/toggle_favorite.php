<?php
session_start();
include 'config.php';

if (isset($_POST['game_id']) && isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("UPDATE owned_games SET is_favorite = NOT is_favorite WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $_SESSION['user_id'], $_POST['game_id']);
    $stmt->execute();
    $stmt->close();
}

header('Location: ?menu=library');