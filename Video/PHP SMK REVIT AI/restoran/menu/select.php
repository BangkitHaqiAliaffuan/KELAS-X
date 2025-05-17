<div class="data-table-container">
    <div class="data-table-header">
        <h2 class="data-table-title"><i class="fas fa-hamburger"></i> Daftar Menu</h2>
        <div class="data-table-actions">
            <a href="?f=menu&m=insert" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Menu
            </a>
        </div>
    </div>
    
    <?php 
        if(isset($_POST['opsi'])){
            $opsi = $_POST['opsi'];
            $where = "WHERE idkategori = $opsi";
        } else{
            $opsi = 0;
            $where = "";
        }
    ?>

    <div class="filter-container p-3 border-bottom">
        <form action="" method="post" class="d-flex align-items-center">
            <label for="kategori-filter" class="me-2 fw-medium">Filter Kategori:</label>
            <select name="opsi" id="kategori-filter" class="form-select w-auto" onchange="this.form.submit()">
                <option value="0">Semua Kategori</option>
                <?php 
                    $row = $db->getALL("SELECT * FROM tablekategori ORDER BY kategori ASC");
                    foreach($row as $r): 
                ?>
                <option <?php if($r['idkategori']==$opsi) echo "selected"; ?> value="<?php echo $r['idkategori'] ?>">
                    <?php echo $r['kategori'] ?>
                </option>
                <?php endforeach ?>
            </select>
        </form>
    </div>

    <?php 
        $jumlahdata = $db->rowCOUNT("SELECT idmenu FROM tablemenu $where");
        $banyak = 5;
        $halaman = ceil($jumlahdata / $banyak);

        if(isset($_GET['p'])){
            $p = $_GET['p'];
            $mulai = ($p * $banyak) - $banyak;
        } else{
            $mulai = 0;
        }
        
        $sql = "SELECT m.*, k.kategori FROM tablemenu m 
                JOIN tablekategori k ON m.idkategori = k.idkategori 
                $where ORDER BY menu ASC LIMIT $mulai, $banyak";
        
        $row = $db->getALL($sql);
        $no = 1 + $mulai;
    ?>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Menu</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th width="100">Gambar</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($row)): ?>
                    <?php foreach($row as $r): ?>
                    <tr>
                        <td><?php echo $no++ ?></td>    
                        <td><?php echo $r['menu']; ?></td>
                        <td><?php echo $r['kategori']; ?></td>
                        <td>Rp <?php echo number_format($r['harga'], 0, ',', '.'); ?></td>
                        <td>
                            <img src="../upload/<?php echo $r['gambar']; ?>" alt="<?php echo $r['menu']; ?>" class="img-thumbnail" style="max-height: 60px">
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="?f=menu&m=update&id=<?php echo $r['idmenu']?>" class="btn-icon btn-icon-edit" data-bs-toggle="tooltip" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="?f=menu&m=delete&id=<?php echo $r['idmenu']?>" class="btn-icon btn-icon-delete delete-btn" data-bs-toggle="tooltip" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-4">Tidak ada data menu</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php if($halaman > 1): ?>
    <div class="pagination-container p-3">
        <div class="pagination">
            <?php for ($i = 1; $i <= $halaman; $i++): ?>
                <a href="?f=menu&m=select&p=<?php echo $i; ?>" class="pagination-link <?php echo (isset($_GET['p']) && $_GET['p'] == $i) || (!isset($_GET['p']) && $i == 1) ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </div>
    </div>
    <?php endif; ?>
</div>