<div class="data-table-container">
    <div class="data-table-header">
        <h2 class="data-table-title"><i class="fas fa-shopping-cart"></i> Daftar Pesanan</h2>
        <div class="data-table-actions">
            <a href="?f=order&m=insert" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Pesanan
            </a>
        </div>
    </div>

    <?php 
        $jumlahdata = $db->rowCOUNT("SELECT o.idorder FROM `tableorder` o JOIN tablepelanggan p ON o.idpelanggan = p.idpelanggan");
        $banyak = 5;
        $halaman = ceil($jumlahdata / $banyak);

        if(isset($_GET['p'])){
            $p = $_GET['p'];
            $mulai = ($p * $banyak) - $banyak;
        } else{
            $mulai = 0;
        }
        
        $sql = "SELECT o.idorder, o.tglorder, o.total, o.bayar, o.kembali, o.status, p.pelanggan 
                FROM `tableorder` o 
                JOIN tablepelanggan p ON o.idpelanggan = p.idpelanggan 
                ORDER BY o.status, o.idorder DESC 
                LIMIT $mulai, $banyak";
        
        $row = $db->getALL($sql);
        $no = 1 + $mulai;
    ?>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>ID Order</th>
                    <th>Pelanggan</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Bayar</th>
                    <th>Kembali</th>
                    <th>Status</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($row)): ?>
                    <?php foreach($row as $r): ?>
                        <?php 
                            if($r['status'] == 0){
                                $statusBadge = '<span class="status-badge pending">Belum Bayar</span>';
                                $actionBtn = '<a href="?f=order&m=bayar&id='.$r['idorder'].'" class="btn-icon btn-icon-view" data-bs-toggle="tooltip" title="Proses Pembayaran"><i class="fas fa-money-bill-wave"></i></a>';
                            } else{
                                $statusBadge = '<span class="status-badge completed">Lunas</span>';
                                $actionBtn = '<a href="?f=orderdetail&m=select&id='.$r['idorder'].'" class="btn-icon btn-icon-view" data-bs-toggle="tooltip" title="Lihat Detail"><i class="fas fa-eye"></i></a>';
                            }
                        ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td>#<?php echo $r['idorder'] ?></td>
                            <td><?php echo $r['pelanggan']; ?></td>    
                            <td><?php echo date('d M Y', strtotime($r['tglorder'])); ?></td>    
                            <td>Rp <?php echo number_format($r['total'], 0, ',', '.'); ?></td>         
                            <td>Rp <?php echo number_format($r['bayar'], 0, ',', '.'); ?></td>         
                            <td>Rp <?php echo number_format($r['kembali'], 0, ',', '.'); ?></td>         
                            <td><?php echo $statusBadge; ?></td>
                            <td>
                                <div class="action-buttons">
                                    <?php echo $actionBtn; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center py-4">Tidak ada data pesanan</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php if($halaman > 1): ?>
    <div class="pagination-container p-3">
        <div class="pagination">
            <?php for ($i = 1; $i <= $halaman; $i++): ?>
                <a href="?f=order&m=select&p=<?php echo $i; ?>" class="pagination-link <?php echo (isset($_GET['p']) && $_GET['p'] == $i) || (!isset($_GET['p']) && $i == 1) ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </div>
    </div>
    <?php endif; ?>
</div>