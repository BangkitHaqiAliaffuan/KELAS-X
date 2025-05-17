<?php 
    $email = $_SESSION['pelanggan'];
    
    // Count total orders without using vorder view
    $jumlahdata = $db->rowCOUNT("SELECT o.idorder 
                                FROM `order` o 
                                JOIN pelanggan p ON o.idpelanggan = p.idpelanggan 
                                WHERE p.email = '$email'");
    
    $banyak = 3;
    
    $halaman = ceil($jumlahdata / $banyak);

    if(isset($_GET['p'])){
        $p = $_GET['p'];
        $mulai = ($p * $banyak) - $banyak;
    } else{
        $mulai = 0;
    };
    
    // Get orders using direct table query instead of view
    $sql = "SELECT o.idorder, o.tglorder, o.total, o.status 
            FROM `order` o 
            JOIN pelanggan p ON o.idpelanggan = p.idpelanggan
            WHERE p.email = '$email' 
            ORDER BY o.tglorder DESC 
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
                        <i class="fas fa-history me-2"></i>Riwayat Pesanan
                    </h5>
                    <a href="?f=home&m=produk" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i>Pesan Lagi
                    </a>
                </div>
                <div class="card-body">
                    <?php if(empty($row)): ?>
                        <div class="text-center py-5">
                            <div class="empty-state-icon mb-3">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                            <h5 class="mb-2">Belum Ada Pesanan</h5>
                            <p class="text-muted mb-4">Anda belum melakukan pemesanan apapun</p>
                            <a href="?f=home&m=produk" class="btn btn-primary">
                                <i class="fas fa-utensils me-2"></i>Mulai Pesan
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" width="60">No</th>
                                        <th>Tanggal</th>
                                        <th class="text-end">Total</th>
                                        <th>Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($row as $r): ?>
                                    <tr class="order-row">
                                        <td class="text-center"><?php echo $no++ ?></td>    
                                        <td>
                                            <div class="fw-medium"><?php echo date('d M Y', strtotime($r['tglorder'])); ?></div>
                                            <div class="text-muted small"><?php echo date('H:i', strtotime($r['tglorder'])); ?> WIB</div>
                                        </td>    
                                        <td class="text-end fw-medium">Rp <?php echo number_format($r['total'], 0, ',', '.'); ?></td>
                                        <td>
                                            <?php 
                                            $statusText = "Selesai";
                                            $statusClass = "bg-success";
                                            
                                            if($r['status'] == 0) {
                                                $statusText = "Pending";
                                                $statusClass = "bg-warning";
                                            } else if($r['status'] == 1) {
                                                $statusText = "Diproses";
                                                $statusClass = "bg-info";
                                            }
                                            ?>
                                            <span class="badge <?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                                        </td>
                                        <td class="text-center">
                                            <a href="?f=home&m=detail&id=<?php echo $r['idorder']; ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye me-1"></i>Detail
                                            </a>
                                        </td>    
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if($halaman > 1): ?>
                <div class="card-footer bg-white py-3">
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm justify-content-center mb-0">
                            <?php if(isset($_GET['p']) && $_GET['p'] > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?f=home&m=histori&p=<?php echo $_GET['p']-1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php endif; ?>
                            
                            <?php for ($i = 1; $i <= $halaman; $i++): ?>
                            <li class="page-item <?php echo (isset($_GET['p']) && $_GET['p'] == $i) || (!isset($_GET['p']) && $i == 1) ? 'active' : ''; ?>">
                                <a class="page-link" href="?f=home&m=histori&p=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                            <?php endfor; ?>
                            
                            <?php if(!isset($_GET['p']) || (isset($_GET['p']) && $_GET['p'] < $halaman)): ?>
                            <li class="page-item">
                                <a class="page-link" href="?f=home&m=histori&p=<?php echo (isset($_GET['p']) ? $_GET['p']+1 : 2); ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
    .empty-state-icon {
        width: 80px;
        height: 80px;
        background: #f1f5f9;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        color: #94a3b8;
        font-size: 30px;
    }
    
    .order-row {
        transition: all 0.2s ease;
    }
    
    .order-row:hover {
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
        padding: 0.5em 0.8em;
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
    }
    
    .page-link:hover {
        color: #0284c7;
        background-color: #e0f2fe;
    }
</style>
