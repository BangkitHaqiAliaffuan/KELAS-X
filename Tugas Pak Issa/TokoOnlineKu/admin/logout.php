<?php
// pages/logout.php

// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function performLogout() {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session cookie
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }

    // Destroy the session
    session_destroy();

    // Redirect to login page
    header('Location: index.php');
    exit();
}

// Execute logout
performLogout();
?>