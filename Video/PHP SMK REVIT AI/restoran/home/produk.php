<?php 
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $where = "WHERE idkategori = $id ";
        $id="&id".$id;
    } else{
        $where = "";
        $id= "";
    }
    
    $jumlahdata = $db->rowCOUNT("SELECT idmenu FROM tablemenu ");
    
    $banyak = 3;
    
    $halaman = ceil($jumlahdata / $banyak);

    if(isset($_GET['p'])){
        $p = $_GET['p'];
        $mulai = ($p * $banyak) - $banyak;
    } else{
        $mulai = 0;
    };
    
    $sql = "SELECT * FROM tablemenu $where ORDER BY menu ASC LIMIT $mulai, $banyak";
    
    $row = $db->getALL($sql);
    
    $no = 1 + $mulai;
?>

<div class="menu-container">
    <div class="menu-header">
        <h3 class="menu-title"><i class="fas fa-utensils me-2"></i>Menu Restoran</h3>
        <div class="menu-filters">
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="categoryDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-filter me-1"></i>Kategori
                </button>
                <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                    <li><a class="dropdown-item" href="?f=home&m=produk">Semua Menu</a></li>
                    <li><a class="dropdown-item" href="?f=home&m=produk&id=1">Makanan</a></li>
                    <li><a class="dropdown-item" href="?f=home&m=produk&id=2">Minuman</a></li>
                    <li><a class="dropdown-item" href="?f=home&m=produk&id=3">Dessert</a></li>
                </ul>
            </div>
            <div class="dropdown ms-2">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-sort me-1"></i>Urutkan
                </button>
                <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                    <li><a class="dropdown-item" href="#">Nama (A-Z)</a></li>
                    <li><a class="dropdown-item" href="#">Harga (Terendah)</a></li>
                    <li><a class="dropdown-item" href="#">Harga (Tertinggi)</a></li>
                    <li><a class="dropdown-item" href="#">Terbaru</a></li>
                </ul>
            </div>
        </div>
    </div>

    <?php if(!empty($row)): ?>
        <div class="menu-grid">
            <?php foreach($row as $r): ?>
            <div class="menu-card">
                <div class="menu-badge">
                    <span>Populer</span>
                </div>
                <div class="menu-image">
                    <img src="upload/<?php echo $r['gambar']; ?>" alt="<?php echo $r['menu']; ?>">
                    <div class="menu-overlay">
                        <a href="?f=home&m=beli&id=<?php echo $r['idmenu']?>" class="btn-add-cart">
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                    </div>
                </div>
                <div class="menu-content">
                    <h5 class="menu-name"><?php echo $r['menu']; ?></h5>
                    <div class="menu-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                        <span>(4.5)</span>
                    </div>
                    <div class="menu-price">Rp <?php echo number_format($r['harga'], 0, ',', '.'); ?></div>
                    <div class="menu-actions">
                        <a href="?f=home&m=beli&id=<?php echo $r['idmenu']?>" class="btn btn-primary btn-order">
                            <i class="fas fa-shopping-cart me-1"></i>Pesan
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach ?>
        </div>
        
        <?php if($halaman > 1): ?>
        <div class="menu-pagination">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php if(isset($_GET['p']) && $_GET['p'] > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?f=home&m=produk&p=<?php echo $_GET['p']-1 . $id; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $halaman; $i++): ?>
                    <li class="page-item <?php echo (isset($_GET['p']) && $_GET['p'] == $i) || (!isset($_GET['p']) && $i == 1) ? 'active' : ''; ?>">
                        <a class="page-link" href="?f=home&m=produk&p=<?php echo $i . $id; ?>"><?php echo $i; ?></a>
                    </li>
                    <?php endfor; ?>
                    
                    <?php if(!isset($_GET['p']) || (isset($_GET['p']) && $_GET['p'] < $halaman)): ?>
                    <li class="page-item">
                        <a class="page-link" href="?f=home&m=produk&p=<?php echo (isset($_GET['p']) ? $_GET['p']+1 : 2) . $id; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
        <?php endif; ?>
        
    <?php else: ?>
        <div class="menu-empty">
            <div class="menu-empty-icon">
                <i class="fas fa-utensils"></i>
            </div>
            <h4>Tidak Ada Menu</h4>
            <p>Maaf, tidak ada menu yang tersedia saat ini.</p>
        </div>
    <?php endif; ?>
</div>

<style>
    .menu-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        animation: fadeIn 0.5s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .menu-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .menu-title {
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }
    
    .menu-filters {
        display: flex;
        gap: 10px;
    }
    
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }
    
    .menu-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        position: relative;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .menu-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }
    
    .menu-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        z-index: 2;
    }
    
    .menu-badge span {
        background: linear-gradient(135deg, #0ea5e9, #14b8a6);
        color: white;
        font-size: 12px;
        font-weight: 500;
        padding: 5px 10px;
        border-radius: 20px;
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3);
    }
    
    .menu-image {
        position: relative;
        height: 200px;
        overflow: hidden;
    }
    
    .menu-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .menu-card:hover .menu-image img {
        transform: scale(1.05);
    }
    
    .menu-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .menu-card:hover .menu-overlay {
        opacity: 1;
    }
    
    .btn-add-cart {
        width: 50px;
        height: 50px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0ea5e9;
        font-size: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transform: translateY(20px);
        opacity: 0;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .menu-card:hover .btn-add-cart {
        transform: translateY(0);
        opacity: 1;
    }
    
    .btn-add-cart:hover {
        background: #0ea5e9;
        color: white;
    }
    
    .menu-content {
        padding: 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    
    .menu-name {
        font-size: 18px;
        font-weight: 600;
        color: #1e293b;
        margin: 0 0 10px;
        line-height: 1.4;
    }
    
    .menu-rating {
        margin-bottom: 15px;
        color: #f59e0b;
        display: flex;
        align-items: center;
        gap: 2px;
    }
    
    .menu-rating span {
        color: #64748b;
        font-size: 14px;
        margin-left: 5px;
    }
    
    .menu-price {
        font-size: 20px;
        font-weight: 700;
        color: #0ea5e9;
        margin-bottom: 20px;
    }
    
    .menu-actions {
        margin-top: auto;
    }
    
    .btn-order {
        width: 100%;
        padding: 12px;
        background: linear-gradient(135deg, #0ea5e9, #14b8a6);
        border: none;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .btn-order:hover {
        background: linear-gradient(135deg, #0284c7, #0f766e);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .menu-pagination {
        margin-top: 40px;
    }
    
    .pagination {
        gap: 5px;
    }
    
    .page-item.active .page-link {
        background: linear-gradient(135deg, #0ea5e9, #14b8a6);
        border-color: #0ea5e9;
    }
    
    .page-link {
        color: #0ea5e9;
        border-radius: 6px;
        padding: 8px 14px;
    }
    
    .page-link:hover {
        color: #0284c7;
        background-color: #e0f2fe;
    }
    
    .menu-empty {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
    }
    
    .menu-empty-icon {
        width: 80px;
        height: 80px;
        background: #f1f5f9;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        color: #94a3b8;
        font-size: 30px;
    }
    
    .menu-empty h4 {
        font-size: 18px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 10px;
    }
    
    .menu-empty p {
        color: #64748b;
        margin-bottom: 25px;
    }
    
    @media (max-width: 768px) {
        .menu-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .menu-filters {
            width: 100%;
            justify-content: space-between;
        }
        
        .menu-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        }
    }
</style>