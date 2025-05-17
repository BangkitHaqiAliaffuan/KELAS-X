<div class="data-table-container">
    <div class="data-table-header">
        <h2 class="data-table-title"><i class="fas fa-tags"></i> Daftar Kategori</h2>
        <div class="data-table-actions">
            <a href="?f=kategori&m=insert" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Kategori
            </a>
        </div>
    </div>

    <?php 
        $jumlahdata = $db->rowCOUNT("SELECT idkategori FROM tablekategori");
        $banyak = 5;
        $halaman = ceil($jumlahdata / $banyak);

        if(isset($_GET['p'])){
            $p = $_GET['p'];
            $mulai = ($p * $banyak) - $banyak;
        } else{
            $mulai = 0;
        }
        
        $sql = "SELECT * FROM tablekategori ORDER BY kategori ASC LIMIT $mulai, $banyak";
        $row = $db->getALL($sql);
        $no = 1 + $mulai;
        
        // Get menu count for each category
        $categories = [];
        foreach($row as $r) {
            $idkategori = $r['idkategori'];
            $menuCount = $db->rowCOUNT("SELECT idmenu FROM tablemenu WHERE idkategori = $idkategori");
            $categories[$idkategori] = $menuCount;
        }
    ?>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Kategori</th>
                    <th width="120">Jumlah Menu</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($row)): ?>
                    <?php foreach($row as $r): ?>
                        <tr>
                            <td><?php echo $no++ ?></td>    
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="category-icon me-2">
                                        <i class="fas fa-folder"></i>
                                    </span>
                                    <?php echo $r['kategori']; ?>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-primary rounded-pill">
                                    <?php echo $categories[$r['idkategori']]; ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="?f=kategori&m=update&id=<?php echo $r['idkategori']?>" class="btn-icon btn-icon-edit" data-bs-toggle="tooltip" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="?f=kategori&m=delete&id=<?php echo $r['idkategori']?>" class="btn-icon btn-icon-delete delete-btn" data-bs-toggle="tooltip" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <a href="?f=menu&m=select&opsi=<?php echo $r['idkategori']?>" class="btn-icon btn-icon-view" data-bs-toggle="tooltip" title="Lihat Menu">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center py-4">Tidak ada data kategori</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php if($halaman > 1): ?>
    <div class="pagination-container p-3">
        <div class="pagination">
            <?php for ($i = 1; $i <= $halaman; $i++): ?>
                <a href="?f=kategori&m=select&p=<?php echo $i; ?>" class="pagination-link <?php echo (isset($_GET['p']) && $_GET['p'] == $i) || (!isset($_GET['p']) && $i == 1) ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if(!empty($row)): ?>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0"><i class="fas fa-chart-bar me-2"></i>Distribusi Menu</h5>
                </div>
                <div class="card-body">
                    <div class="category-chart">
                        <?php foreach($row as $r): ?>
                            <?php 
                                $menuCount = $categories[$r['idkategori']];
                                $totalMenus = array_sum($categories);
                                $percentage = ($totalMenus > 0) ? round(($menuCount / $totalMenus) * 100) : 0;
                            ?>
                            <div class="category-stat mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <div class="category-name"><?php echo $r['kategori']; ?></div>
                                    <div class="category-count"><?php echo $menuCount; ?> menu (<?php echo $percentage; ?>%)</div>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar" role="progressbar" style="width: <?php echo $percentage; ?>%;" aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Kategori</h5>
                </div>
                <div class="card-body">
                    <div class="info-item mb-3">
                        <div class="info-label">Total Kategori</div>
                        <div class="info-value"><?php echo $jumlahdata; ?></div>
                    </div>
                    <div class="info-item mb-3">
                        <div class="info-label">Total Menu</div>
                        <div class="info-value"><?php echo array_sum($categories); ?></div>
                    </div>
                    <div class="info-item mb-3">
                        <div class="info-label">Kategori Terbanyak</div>
                        <?php 
                            $maxCategory = '';
                            $maxCount = 0;
                            foreach($row as $r) {
                                if($categories[$r['idkategori']] > $maxCount) {
                                    $maxCount = $categories[$r['idkategori']];
                                    $maxCategory = $r['kategori'];
                                }
                            }
                        ?>
                        <div class="info-value"><?php echo $maxCategory; ?> (<?php echo $maxCount; ?> menu)</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Rata-rata Menu per Kategori</div>
                        <div class="info-value">
                            <?php 
                                $avgMenus = ($jumlahdata > 0) ? round(array_sum($categories) / $jumlahdata, 1) : 0;
                                echo $avgMenus;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
    .category-icon {
        width: 32px;
        height: 32px;
        border-radius: 4px;
        background-color: rgba(78, 115, 223, 0.1);
        color: var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .badge {
        font-size: 0.875rem;
        padding: 0.35em 0.65em;
    }
    
    .category-stat .progress-bar {
        background-color: var(--primary-color);
    }
    
    .info-item {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem;
        border-radius: 0.25rem;
        background-color: rgba(78, 115, 223, 0.05);
    }
    
    .info-label {
        font-weight: 500;
        color: var(--dark-color);
    }
    
    .info-value {
        font-weight: 600;
        color: var(--primary-color);
    }
</style>