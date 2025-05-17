<div class="data-table-container">
    <div class="data-table-header">
        <h2 class="data-table-title"><i class="fas fa-receipt"></i> Detail Pembelian</h2>
        <div class="data-table-actions">
            <a href="?f=orderdetail&m=insert" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Data
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-light">
            <h5 class="card-title mb-0"><i class="fas fa-filter me-2"></i>Filter Tanggal</h5>
        </div>
        <div class="card-body">
            <form action="" method="post" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="tawal" class="form-label">Tanggal Awal</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        <input type="date" id="tawal" name="tawal" required class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="takhir" class="form-label">Tanggal Akhir</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        <input type="date" id="takhir" name="takhir" required class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" name="simpan" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Cari Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php 
        $jumlahdata = $db->rowCOUNT("SELECT od.idorderdetail FROM tableorderdetail od INNER JOIN `tableorder` o ON od.idorder = o.idorder");
        $banyak = 5;
        $halaman = ceil($jumlahdata / $banyak);

        if(isset($_GET['p'])){
            $p = $_GET['p'];
            $mulai = ($p * $banyak) - $banyak;
        } else{
            $mulai = 0;
        }
        
        $sql = "SELECT od.idorderdetail, o.tglorder, m.menu, m.harga, od.jumlah, p.pelanggan, p.alamat 
                FROM tableorderdetail od 
                INNER JOIN `tableorder` o ON od.idorder = o.idorder 
                INNER JOIN tablemenu m ON od.idmenu = m.idmenu 
                INNER JOIN tablepelanggan p ON o.idpelanggan = p.idpelanggan 
                ORDER BY o.tglorder DESC, od.idorderdetail ASC LIMIT $mulai, $banyak";

        if(isset($_POST['simpan'])){
            $tawal = $_POST['tawal'];
            $takhir = $_POST['takhir'];
            $sql = "SELECT od.idorderdetail, o.tglorder, m.menu, m.harga, od.jumlah, p.pelanggan, p.alamat 
                    FROM tableorderdetail od 
                    INNER JOIN `tableorder` o ON od.idorder = o.idorder 
                    INNER JOIN tablemenu m ON od.idmenu = m.idmenu 
                    INNER JOIN tablepelanggan p ON o.idpelanggan = p.idpelanggan 
                    WHERE o.tglorder BETWEEN '$tawal' AND '$takhir'
                    ORDER BY o.tglorder DESC, od.idorderdetail ASC";
        }
        
        $row = $db->getALL($sql);
        $no = 1 + $mulai;
        $total = 0;
    ?>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Menu</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Alamat</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($row)): ?>
                    <?php foreach($row as $r): ?>
                        <?php $itemTotal = $r['jumlah'] * $r['harga']; ?>
                        <?php $total += $itemTotal; ?>
                        <tr>
                            <td><?php echo $no++ ?></td>    
                            <td><?php echo date('d M Y', strtotime($r['tglorder'])); ?></td>    
                            <td><?php echo $r['pelanggan']; ?></td>    
                            <td><?php echo $r['menu']; ?></td>         
                            <td>Rp <?php echo number_format($r['harga'], 0, ',', '.'); ?></td>         
                            <td class="text-center"><?php echo $r['jumlah']; ?></td>         
                            <td>Rp <?php echo number_format($itemTotal, 0, ',', '.'); ?></td>         
                            <td><?php echo $r['alamat']; ?></td>    
                        </tr>
                    <?php endforeach ?>
                    <tr class="table-summary">
                        <td colspan="6" class="text-end fw-bold">Grand Total:</td>
                        <td class="fw-bold">Rp <?php echo number_format($total, 0, ',', '.'); ?></td>
                        <td></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center py-4">Tidak ada data detail pembelian</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php if($halaman > 1 && !isset($_POST['simpan'])): ?>
    <div class="pagination-container p-3">
        <div class="pagination">
            <?php for ($i = 1; $i <= $halaman; $i++): ?>
                <a href="?f=orderdetail&m=select&p=<?php echo $i; ?>" class="pagination-link <?php echo (isset($_GET['p']) && $_GET['p'] == $i) || (!isset($_GET['p']) && $i == 1) ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if(isset($_POST['simpan']) && !empty($row)): ?>
    <div class="card mt-4">
        <div class="card-header bg-light">
            <h5 class="card-title mb-0"><i class="fas fa-print me-2"></i>Opsi Cetak</h5>
        </div>
        <div class="card-body">
            <div class="d-flex gap-2">
                <a href="?f=orderdetail&m=print&tawal=<?php echo $tawal; ?>&takhir=<?php echo $takhir; ?>" class="btn btn-primary" target="_blank">
                    <i class="fas fa-print me-2"></i>Cetak Laporan
                </a>
                <a href="?f=orderdetail&m=export&tawal=<?php echo $tawal; ?>&takhir=<?php echo $takhir; ?>" class="btn btn-success">
                    <i class="fas fa-file-excel me-2"></i>Export Excel
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
    .table-summary td {
        border-top: 2px solid var(--primary-color);
        background-color: rgba(78, 115, 223, 0.05);
    }
</style>