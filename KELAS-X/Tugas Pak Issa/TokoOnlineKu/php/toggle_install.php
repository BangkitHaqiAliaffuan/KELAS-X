<?php
session_start();
include 'config.php';

if (isset($_POST['game_id']) && isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("UPDATE owned_games SET install_status = CASE WHEN install_status = 'installed' THEN 'not_installed' ELSE 'installed' END WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $_SESSION['user_id'], $_POST['game_id']);
    $stmt->execute();
    $stmt->close();
}

header('Location: ' . $_SERVER['HTTP_REFERER']);