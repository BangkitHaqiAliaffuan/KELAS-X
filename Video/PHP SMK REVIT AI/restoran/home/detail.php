<?php 
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
    
    // Count total order details without using vorderdetail view
    $jumlahdata = $db->rowCOUNT("SELECT od.idorderdetail 
                                FROM orderdetail od 
                                WHERE od.idorder = $id");
    
    $banyak = 3;
    
    $halaman = ceil($jumlahdata / $banyak);

    if(isset($_GET['p'])){
        $p = $_GET['p'];
        $mulai = ($p * $banyak) - $banyak;
    } else{
        $mulai = 0;
    };
    
    // Get order details with menu information using JOIN instead of view
    $sql = "SELECT od.idorderdetail, od.idorder, od.idmenu, od.jumlah, od.hargajual, 
                   o.tglorder, m.menu 
            FROM orderdetail od
            JOIN `order` o ON od.idorder = o.idorder
            JOIN menu m ON od.idmenu = m.idmenu
            WHERE od.idorder = $id 
            ORDER BY od.idorderdetail ASC 
            LIMIT $mulai, $banyak";
    
    $row = $db->getALL($sql);
    
    $no = 1 + $mulai;
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-lg mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-receipt me-2"></i>Detail Pesanan
                    </h5>
                    <a href="?f=home&m=histori" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-arrow-left me-1"></i>Kembali
                    </a>
                </div>
                <div class="card-body">
                    <?php if(empty($row)): ?>
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle me-2"></i>Tidak ada detail pesanan yang tersedia
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" width="60">No</th>
                                        <th>Tanggal</th>
                                        <th>Menu</th>
                                        <th class="text-end">Harga</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $total = 0;
                                    foreach($row as $r): 
                                        $subtotal = $r['hargajual'] * $r['jumlah'];
                                        $total += $subtotal;
                                    ?>
                                    <tr class="order-item">
                                        <td class="text-center"><?php echo $no++ ?></td>    
                                        <td><?php echo date('d M Y', strtotime($r['tglorder'])); ?></td>    
                                        <td>
                                            <span class="fw-medium"><?php echo $r['menu']; ?></span>
                                        </td>    
                                        <td class="text-end">Rp <?php echo number_format($r['hargajual'], 0, ',', '.'); ?></td>     
                                        <td class="text-center">
                                            <span class="badge bg-primary rounded-pill px-3"><?php echo $r['jumlah']; ?></span>
                                        </td>
                                        <td class="text-end fw-medium">
                                            Rp <?php echo number_format($subtotal, 0, ',', '.'); ?>
                                        </td>    
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="5" class="text-end fw-bold">Total</td>
                                        <td class="text-end fw-bold text-primary">
                                            Rp <?php echo number_format($total, 0, ',', '.'); ?>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if($halaman > 1): ?>
                <div class="card-footer bg-white py-3">
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm justify-content-center mb-0">
                            <?php for ($i = 1; $i <= $halaman; $i++): ?>
                                <li class="page-item <?php echo (isset($_GET['p']) && $_GET['p'] == $i) ? 'active' : ''; ?>">
                                    <a class="page-link" href="?f=home&m=detail&id=<?php echo $id; ?>&p=<?php echo $i; ?>">
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
    .order-item {
        transition: all 0.2s ease;
    }
    .order-item:hover {
        background-color: rgba(var(--bs-primary-rgb), 0.05);
    }
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }
    .badge {
        font-weight: 500;
    }
</style>
