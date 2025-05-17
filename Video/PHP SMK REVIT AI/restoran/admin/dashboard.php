<?php
    // Get some statistics for the dashboard
    $totalMenu = $db->rowCOUNT("SELECT idmenu FROM tablemenu");
    $totalKategori = $db->rowCOUNT("SELECT idkategori FROM tablekategori");
    $totalPelanggan = $db->rowCOUNT("SELECT idpelanggan FROM tablepelanggan");
    $totalOrder = $db->rowCOUNT("SELECT idorder FROM tableorder");
    
    // Get recent orders
    $recentOrders = $db->getALL("SELECT o.idorder, o.tglorder, o.total, p.pelanggan 
                                FROM `tableorder` o 
                                JOIN tablepelanggan p ON o.idpelanggan = p.idpelanggan 
                                ORDER BY o.tglorder DESC LIMIT 5");
    
    // Get popular menu items
    $popularMenu = $db->getALL("SELECT m.menu, m.gambar, COUNT(od.idmenu) as order_count 
                               FROM tablemenu m 
                               JOIN tableorderdetail od ON m.idmenu = od.idmenu 
                               GROUP BY m.idmenu 
                               ORDER BY order_count DESC LIMIT 4");
?>

<div class="dashboard">
    <!-- Stats Cards -->
    <div class="stats-cards">
        <div class="stat-card">
            <div class="stat-card-content">
                <h3 class="stat-card-title">Total Menu</h3>
                <p class="stat-card-value"><?php echo $totalMenu; ?></p>
            </div>
            <div class="stat-card-icon">
                <i class="fas fa-hamburger"></i>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-content">
                <h3 class="stat-card-title">Kategori</h3>
                <p class="stat-card-value"><?php echo $totalKategori; ?></p>
            </div>
            <div class="stat-card-icon">
                <i class="fas fa-tags"></i>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-content">
                <h3 class="stat-card-title">Pelanggan</h3>
                <p class="stat-card-value"><?php echo $totalPelanggan; ?></p>
            </div>
            <div class="stat-card-icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-content">
                <h3 class="stat-card-title">Total Order</h3>
                <p class="stat-card-value"><?php echo $totalOrder; ?></p>
            </div>
            <div class="stat-card-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
        </div>
    </div>
    
    <!-- Recent Orders -->
    <div class="dashboard-section">
        <div class="section-header">
            <h2><i class="fas fa-clock"></i> Pesanan Terbaru</h2>
            <a href="?f=order&m=select" class="view-all">Lihat Semua</a>
        </div>
        <div class="table-responsive">
            <table class="table table-dashboard">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($recentOrders)): ?>
                        <?php foreach($recentOrders as $order): ?>
                            <tr>
                                <td>#<?php echo $order['idorder']; ?></td>
                                <td><?php echo $order['pelanggan']; ?></td>
                                <td><?php echo date('d M Y', strtotime($order['tglorder'])); ?></td>
                                <td>Rp <?php echo number_format($order['total'], 0, ',', '.'); ?></td>
                                <td>
                                    <?php 
                                        $orderStatus = $db->getITEM("SELECT status FROM tableorder WHERE idorder = " . $order['idorder']);
                                        if($orderStatus['status'] == 0) {
                                            echo '<span class="status-badge pending">Pending</span>';
                                        } else {
                                            echo '<span class="status-badge completed">Completed</span>';
                                        }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada pesanan terbaru</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Popular Menu Items -->
    <div class="dashboard-section">
        <div class="section-header">
            <h2><i class="fas fa-star"></i> Menu Populer</h2>
            <a href="?f=menu&m=select" class="view-all">Lihat Semua</a>
        </div>
        <div class="popular-menu">
            <?php if(!empty($popularMenu)): ?>
                <?php foreach($popularMenu as $menu): ?>
                    <div class="menu-card">
                        <div class="menu-image">
                            <img src="../upload/<?php echo $menu['gambar']; ?>" alt="<?php echo $menu['menu']; ?>">
                        </div>
                        <div class="menu-details">
                            <h3><?php echo $menu['menu']; ?></h3>
                            <p><i class="fas fa-shopping-cart"></i> <?php echo $menu['order_count']; ?> orders</p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-data">Tidak ada data menu populer</div>
            <?php endif; ?>
        </div>
    </div>
</div>