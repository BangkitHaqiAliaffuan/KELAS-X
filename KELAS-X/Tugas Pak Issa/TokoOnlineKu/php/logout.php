// logout.php
<?php
session_start();
session_destroy();

// Remove remember me cookie if exists
if (isset($_COOKIE['user_email'])) {
    setcookie('user_email', '', time() - 3600, '/');
}

header("Location: index.php?menu=home");
exit();
?>