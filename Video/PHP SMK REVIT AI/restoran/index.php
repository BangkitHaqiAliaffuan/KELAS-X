<?php
    session_start();
    require_once "dbcontroller.php";
    $db = new DB();
    
    $sql = "SELECT * FROM tablekategori ORDER BY kategori";
    $row = $db->getAll($sql);
    
    if(isset($_GET['log'])){
        session_destroy();
        header("Location: index.php");
    }

    function cart(){
        global $db;
        $cart = 0;

        foreach ($_SESSION as $key => $value){
            if($key<>'pelanggan' && $key<> 'idpelanggan' && $key<> 'user' && $key<> 'level' && $key<> 'iduser'){
                $id = substr($key,1);
                $sql = "SELECT * FROM tablemenu WHERE idmenu=$id";
                $row = $db -> getAll($sql);
                foreach($row as $r){
                    $cart++;
                }
            }
        }
        return $cart;
    }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restoran SMK | Kuliner Terbaik</title>
    <meta name="description" content="Restoran SMK menyajikan berbagai menu makanan dan minuman berkualitas dengan harga terjangkau">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/custom.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        :root {
            --primary-color: #0ea5e9;
            --primary-dark: #0284c7;
            --primary-light: #e0f2fe;
            --secondary-color: #14b8a6;
            --accent-color: #8b5cf6;
            --dark-color: #1e293b;
            --light-color: #f8fafc;
            --gray-color: #e2e8f0;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            margin: 0;
            padding: 0;
        }
        
        /* Layout Structure */
        .app-container {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            background: white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 100;
            transition: all 0.3s ease;
        }
        
        .sidebar-header {
            padding: 25px 20px;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .sidebar-header h2 {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
        }
        
        .sidebar-header a {
            color: #1e293b;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: color 0.2s ease;
        }
        
        .sidebar-header a:hover {
            color: #0ea5e9;
        }
        
        .sidebar-header i {
            color: #0ea5e9;
            font-size: 24px;
        }
        
        .sidebar-content {
            flex: 1;
            overflow-y: auto;
            padding: 20px 0;
        }
        
        .category-nav {
            padding: 0 20px;
            margin-bottom: 20px;
        }
        
        .category-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            cursor: pointer;
            color: #1e293b;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.2s ease;
        }
        
        .category-header:hover {
            color: #0ea5e9;
        }
        
        .category-header i.toggle-icon {
            transition: transform 0.3s ease;
            font-size: 14px;
            color: #94a3b8;
        }
        
        .category-header.collapsed i.toggle-icon {
            transform: rotate(-90deg);
        }
        
        .category-menu {
            list-style: none;
            padding: 0;
            margin: 10px 0;
            max-height: 500px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .category-menu.collapsed {
            max-height: 0;
            margin: 0;
        }
        
        .category-menu li {
            margin-bottom: 2px;
        }
        
        .category-menu a {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            color: #64748b;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s ease;
            font-size: 15px;
        }
        
        .category-menu a:hover {
            background-color: #f1f5f9;
            color: #0ea5e9;
        }
        
        .category-menu a i {
            margin-right: 10px;
            font-size: 12px;
            color: #94a3b8;
        }
        
        .category-menu a:hover i {
            color: #0ea5e9;
        }
        
        .user-nav {
            padding: 20px;
            border-top: 1px solid #f1f5f9;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .user-nav a, .user-nav span {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: #64748b;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s ease;
            font-size: 15px;
            font-weight: 500;
        }
        
        .user-nav a:hover {
            background-color: #f1f5f9;
            color: #0ea5e9;
        }
        
        .user-nav i {
            margin-right: 12px;
            font-size: 16px;
            width: 20px;
            text-align: center;
        }
        
        .user-nav a.btn-login {
            background: linear-gradient(135deg, #0ea5e9, #14b8a6);
            color: white;
            margin-top: 5px;
        }
        
        .user-nav a.btn-login:hover {
            background: linear-gradient(135deg, #0284c7, #0f766e);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .user-nav a.btn-register {
            border: 1px solid #e2e8f0;
        }
        
        .user-nav a.btn-register:hover {
            border-color: #0ea5e9;
        }
        
        .user-nav .cart-count {
            background: #0ea5e9;
            color: white;
            border-radius: 20px;
            padding: 2px 8px;
            font-size: 12px;
            margin-left: auto;
        }
        
        .user-nav span {
            background-color: #f8fafc;
            font-weight: 600;
            color: #1e293b;
        }
        
        /* Main Content Area */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 30px;
            transition: all 0.3s ease;
        }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
            background: linear-gradient(135deg, #0ea5e9, #14b8a6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-fill-color: transparent;
        }
        
        .mobile-toggle {
            display: none;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #0ea5e9;
            font-size: 18px;
            transition: all 0.2s ease;
        }
        
        .mobile-toggle:hover {
            background: #f1f5f9;
        }
        
        .content-wrapper {
            animation: fadeIn 0.5s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Responsive Styles */
        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                padding: 20px;
            }
            
            .mobile-toggle {
                display: flex;
            }
            
            .page-header {
                margin-bottom: 20px;
            }
            
            .page-title {
                font-size: 24px;
            }
        }
        
        @media (max-width: 576px) {
            .main-content {
                padding: 15px;
            }
            
            .page-title {
                font-size: 22px;
            }
        }
        
        /* Overlay for mobile when sidebar is open */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 99;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }
    </style>
</head>
<body>
    <div class="app-container">
        <!-- Sidebar Overlay (Mobile) -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
        
        <!-- Sidebar Navigation -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h2><a href="index.php"><i class="fas fa-utensils"></i>Restoran SMK</a></h2>
            </div>
            
            <div class="sidebar-content">
                <div class="category-nav">
                    <div class="category-header" id="categoryToggle">
                        <div><i class="fas fa-list me-2"></i>Kategori Menu</div>
                        <i class="fas fa-chevron-down toggle-icon"></i>
                    </div>
                    
                    <ul class="category-menu" id="categoryMenu">
                        <?php if(!empty($row)) { ?>
                            <?php foreach($row as $r): ?>
                            <li>
                                <a href="?f=home&m=produk&id=<?php echo $r['idkategori'] ?>">
                                    <i class="fas fa-angle-right"></i><?php echo $r['kategori'] ?>
                                </a>
                            </li>
                            <?php endforeach ?>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            
            <div class="user-nav">
                <?php 
                if(isset($_SESSION['pelanggan'])){
                    echo'
                    <a href="?f=home&m=histori">
                        <i class="fas fa-history"></i>Riwayat Pesanan
                    </a>
                    <a href="?f=home&m=beli">
                        <i class="fas fa-shopping-cart"></i>Keranjang
                        <span class="cart-count">'.cart().'</span>
                    </a>
                    <span>
                        <i class="fas fa-user"></i>'.$_SESSION['pelanggan'].'
                    </span>
                    <a href="?log=logout">
                        <i class="fas fa-sign-out-alt"></i>Logout
                    </a>
                    ';
                } else{
                    echo '
                    <a href="?f=home&m=login" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i>Login
                    </a>
                    <a href="?f=home&m=daftar" class="btn-register">
                        <i class="fas fa-user-plus"></i>Daftar Akun
                    </a>
                    ';
                }
                ?>
            </div>
        </aside>
        
        <!-- Main Content Area -->
        <main class="main-content">
            <div class="page-header">
                <h1 class="page-title">Selamat Datang di Restoran SMK</h1>
                <div class="mobile-toggle" id="mobileToggle">
                    <i class="fas fa-bars"></i>
                </div>
            </div>
            
            <div class="content-wrapper">
                <?php
                    if(isset($_GET['f']) && isset($_GET['m'])){
                        $f = $_GET['f'];
                        $m = $_GET['m'];

                        $file = "$f/$m.php";

                        require_once $file;
                    } else{
                        require_once "home/produk.php";
                    }
                ?>
            </div>
        </main>
    </div>

    <script src="bootstrap/js/bootstrap.bundle.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile Toggle
            const mobileToggle = document.getElementById('mobileToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            
            // Toggle sidebar on mobile
            mobileToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                sidebarOverlay.classList.toggle('active');
                document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
            });
            
            // Close sidebar when clicking overlay
            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
                document.body.style.overflow = '';
            });
            
            // Category Menu Toggle
            const categoryToggle = document.getElementById('categoryToggle');
            const categoryMenu = document.getElementById('categoryMenu');
            
            // Check if there's a saved state in localStorage
            const menuState = localStorage.getItem('categoryMenuState');
            if (menuState === 'collapsed') {
                categoryToggle.classList.add('collapsed');
                categoryMenu.classList.add('collapsed');
            }
            
            categoryToggle.addEventListener('click', function() {
                this.classList.toggle('collapsed');
                categoryMenu.classList.toggle('collapsed');
                
                // Save state to localStorage
                const state = categoryMenu.classList.contains('collapsed') ? 'collapsed' : 'expanded';
                localStorage.setItem('categoryMenuState', state);
            });
            
            // Add smooth hover effect for category items
            const categoryItems = document.querySelectorAll('.category-menu a');
            categoryItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.paddingLeft = '20px';
                });
                
                item.addEventListener('mouseleave', function() {
                    this.style.paddingLeft = '15px';
                });
            });
            
            // Close sidebar on window resize if in mobile view
            window.addEventListener('resize', function() {
                if (window.innerWidth > 991 && sidebar.classList.contains('active')) {
                    sidebar.classList.remove('active');
                    sidebarOverlay.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        });
    </script>
</body>
</html>