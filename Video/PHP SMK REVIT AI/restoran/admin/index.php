<?php
    session_start();
    require_once "../dbcontroller.php";
    $db = new DB();
    
    if(!isset($_SESSION['user'])){
        header("location: login.php");
    }

    if (isset($_GET['log'])){
        session_destroy();
        header("location: login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Restoran</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <a href="index.php" class="brand">
                    <i class="fas fa-utensils"></i>
                    <span>RestoPOS</span>
                </a>
                <button class="sidebar-toggle d-md-none" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            
            <div class="user-profile">
                <div class="user-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="user-info">
                    <h6 class="user-name">
                        <a href="?f=user&m=updateuser&id=<?php echo $_SESSION['iduser'] ?>">
                            <?php echo $_SESSION['user'] ?>
                        </a>
                    </h6>
                    <span class="user-role"><?php echo $_SESSION['level'] ?></span>
                </div>
            </div>
            
            <nav class="sidebar-nav">
                <?php 
                    $level = $_SESSION['level'];
                    switch ($level) {
                        case 'admin':
                            echo '
                            <div class="nav-section">
                                <h6 class="nav-section-title">Menu Management</h6>
                                <ul class="nav-items">
                                    <li class="nav-item">
                                        <a href="?f=kategori&m=select" class="nav-link">
                                            <i class="fas fa-tags"></i>
                                            <span>Kategori</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="?f=menu&m=select" class="nav-link">
                                            <i class="fas fa-hamburger"></i>
                                            <span>Menu</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="nav-section">
                                <h6 class="nav-section-title">Customer & Orders</h6>
                                <ul class="nav-items">
                                    <li class="nav-item">
                                        <a href="?f=pelanggan&m=select" class="nav-link">
                                            <i class="fas fa-users"></i>
                                            <span>Pelanggan</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="?f=order&m=select" class="nav-link">
                                            <i class="fas fa-shopping-cart"></i>
                                            <span>Order</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="?f=orderdetail&m=select" class="nav-link">
                                            <i class="fas fa-receipt"></i>
                                            <span>Order Detail</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="nav-section">
                                <h6 class="nav-section-title">Administration</h6>
                                <ul class="nav-items">
                                    <li class="nav-item">
                                        <a href="?f=user&m=select" class="nav-link">
                                            <i class="fas fa-user-cog"></i>
                                            <span>User</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>';
                        break;

                        case 'kasir':
                            echo '
                            <div class="nav-section">
                                <h6 class="nav-section-title">Cashier</h6>
                                <ul class="nav-items">
                                    <li class="nav-item">
                                        <a href="?f=order&m=select" class="nav-link">
                                            <i class="fas fa-shopping-cart"></i>
                                            <span>Order</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="?f=orderdetail&m=select" class="nav-link">
                                            <i class="fas fa-receipt"></i>
                                            <span>Order Detail</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>';
                        break;
                            
                        case 'koki':
                            echo '
                            <div class="nav-section">
                                <h6 class="nav-section-title">Kitchen</h6>
                                <ul class="nav-items">
                                    <li class="nav-item">
                                        <a href="?f=orderdetail&m=select" class="nav-link">
                                            <i class="fas fa-receipt"></i>
                                            <span>Order Detail</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>';
                        break;
                        default:
                            echo '<div class="alert alert-warning">Tidak Ada Menu</div>';
                        break;
                    }
                ?>
            </nav>
            
            <div class="sidebar-footer">
                <a href="?log=logout" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="content-header">
                <div class="header-title">
                    <?php
                        $title = "Dashboard";
                        if (isset($_GET['f'])) {
                            switch ($_GET['f']) {
                                case 'kategori':
                                    $title = "Kategori";
                                    break;
                                case 'menu':
                                    $title = "Menu";
                                    break;
                                case 'pelanggan':
                                    $title = "Pelanggan";
                                    break;
                                case 'order':
                                    $title = "Order";
                                    break;
                                case 'orderdetail':
                                    $title = "Order Detail";
                                    break;
                                case 'user':
                                    $title = "User";
                                    break;
                            }
                        }
                        echo "<h1>$title</h1>";
                    ?>
                </div>
                <div class="header-actions">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search...">
                    </div>
                    <div class="header-user">
                        <span class="user-greeting">Hello, <?php echo $_SESSION['user'] ?></span>
                        <div class="user-avatar">
                            <i class="fas fa-user-circle"></i>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="content-area">
                <?php
                    // Dashboard overview if no specific page is requested
                    if (!isset($_GET['f']) && !isset($_GET['m'])) {
                        include('dashboard.php');
                    } else if (isset($_GET['f']) && (isset($_GET['m']))){
                        $f = $_GET['f'];
                        $m = $_GET['m'];
                        
                        $file = '../'.$f.'/'.$m.'.php';

                        require_once $file;
                    }
                ?>
            </div>

            <!-- Footer -->
            <footer class="content-footer">
                <p>&copy; <?php echo date('Y'); ?> RestoPOS. All rights reserved.</p>
            </footer>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="admin.js"></script>
</body>
</html>