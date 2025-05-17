<div class="data-table-container">
    <div class="data-table-header">
        <h2 class="data-table-title"><i class="fas fa-users"></i> Daftar Pelanggan</h2>
        <div class="data-table-actions">
            <a href="?f=pelanggan&m=insert" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Pelanggan
            </a>
        </div>
    </div>

    <?php 
        $jumlahdata = $db->rowCOUNT("SELECT idpelanggan FROM tablepelanggan");
        $banyak = 5;
        $halaman = ceil($jumlahdata / $banyak);

        if(isset($_GET['p'])){
            $p = $_GET['p'];
            $mulai = ($p * $banyak) - $banyak;
        } else{
            $mulai = 0;
        }
        
        $sql = "SELECT * FROM tablepelanggan ORDER BY pelanggan ASC LIMIT $mulai, $banyak";
        $row = $db->getALL($sql);
        $no = 1 + $mulai;
        
        // Search functionality
        if(isset($_POST['search'])) {
            $keyword = $_POST['keyword'];
            $sql = "SELECT * FROM tablepelanggan 
                    WHERE pelanggan LIKE '%$keyword%' 
                    OR alamat LIKE '%$keyword%' 
                    OR telp LIKE '%$keyword%' 
                    OR email LIKE '%$keyword%'
                    ORDER BY pelanggan ASC";
            $row = $db->getALL($sql);
            $no = 1;
        }
    ?>

    <div class="filter-container p-3 border-bottom">
        <form action="" method="post" class="d-flex">
            <div class="input-group">
                <input type="text" name="keyword" class="form-control" placeholder="Cari pelanggan..." value="<?php echo isset($_POST['keyword']) ? $_POST['keyword'] : ''; ?>">
                <button type="submit" name="search" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <?php if(isset($_POST['search'])): ?>
                <a href="?f=pelanggan&m=select" class="btn btn-secondary ms-2">Reset</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Pelanggan</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>Email</th>
                    <th width="150">Status</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($row)): ?>
                    <?php foreach($row as $r): ?>
                        <?php 
                            if($r['aktif'] == 1) {
                                $status = '<span class="status-badge completed">Aktif</span>';
                            } else {
                                $status = '<span class="status-badge pending">Non-Aktif</span>';
                            }
                        ?>
                        <tr>
                            <td><?php echo $no++ ?></td>    
                            <td><?php echo $r['pelanggan']; ?></td>    
                            <td><?php echo $r['alamat']; ?></td>    
                            <td><?php echo $r['telp']; ?></td>         
                            <td><?php echo $r['email']; ?></td>         
                            <td><?php echo $status; ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="?f=pelanggan&m=update&id=<?php echo $r['idpelanggan']?>" class="btn-icon btn-icon-edit" data-bs-toggle="tooltip" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php if($r['aktif'] == 1): ?>
                                        <a href="?f=pelanggan&m=delete&id=<?php echo $r['idpelanggan']?>" class="btn-icon btn-icon-delete delete-btn" data-bs-toggle="tooltip" title="Non-Aktifkan">
                                            <i class="fas fa-user-slash"></i>
                                        </a>
                                    <?php else: ?>
                                        <a href="?f=pelanggan&m=aktif&id=<?php echo $r['idpelanggan']?>" class="btn-icon btn-icon-view" data-bs-toggle="tooltip" title="Aktifkan">
                                            <i class="fas fa-user-check"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-4">Tidak ada data pelanggan</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php if($halaman > 1 && !isset($_POST['search'])): ?>
    <div class="pagination-container p-3">
        <div class="pagination">
            <?php for ($i = 1; $i <= $halaman; $i++): ?>
                <a href="?f=pelanggan&m=select&p=<?php echo $i; ?>" class="pagination-link <?php echo (isset($_GET['p']) && $_GET['p'] == $i) || (!isset($_GET['p']) && $i == 1) ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if(!empty($row)): ?>
    <div class="card mt-4">
        <div class="card-header bg-light">
            <h5 class="card-title mb-0"><i class="fas fa-chart-pie me-2"></i>Statistik Pelanggan</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <?php 
                        $totalPelanggan = $db->rowCOUNT("SELECT idpelanggan FROM tablepelanggan");
                        $pelangganAktif = $db->rowCOUNT("SELECT idpelanggan FROM tablepelanggan WHERE aktif = 1");
                        $pelangganNonAktif = $totalPelanggan - $pelangganAktif;
                        $persenAktif = ($totalPelanggan > 0) ? round(($pelangganAktif / $totalPelanggan) * 100) : 0;
                    ?>
                    <div class="d-flex justify-content-between mb-2">
                        <div>Total Pelanggan:</div>
                        <div class="fw-bold"><?php echo $totalPelanggan; ?></div>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <div>Pelanggan Aktif:</div>
                        <div class="fw-bold text-success"><?php echo $pelangganAktif; ?></div>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <div>Pelanggan Non-Aktif:</div>
                        <div class="fw-bold text-danger"><?php echo $pelangganNonAktif; ?></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="progress-container">
                        <label>Persentase Pelanggan Aktif</label>
                        <div class="progress" style="height: 25px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $persenAktif; ?>%;" aria-valuenow="<?php echo $persenAktif; ?>" aria-valuemin="0" aria-valuemax="100">
                                <?php echo $persenAktif; ?>%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
    .progress-container {
        margin-top: 0.5rem;
    }
    
    .progress {
        margin-top: 0.5rem;
        border-radius: 0.25rem;
        background-color: #e9ecef;
    }
    
    .progress-bar {
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: white;
        transition: width 0.6s ease;
    }
</style>