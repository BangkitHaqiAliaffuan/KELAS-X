<?php 
    
    $row = $db->getALL("SELECT * FROM tablekategori ORDER BY kategori ASC");

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $sql = "SELECT * FROM tablemenu WHERE idmenu=$id";
        $item = $db->getITEM($sql);
        $idkategori = $item['idkategori'];
        

        
    }
 
        
?>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0"><i class="fas fa-edit me-2"></i>Update Menu</h3>
    </div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data" class="fade-in">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="kategori" class="form-label"><i class="fas fa-tags me-1"></i> Kategori</label>
                        <select name="idkategori" id="kategori" class="form-select">
                            <?php foreach($row as $r): ?>
                            <option <?php if ($idkategori == $r['idkategori']) echo "selected"; ?> value="<?php echo $r['idkategori'] ?>"><?php echo $r['kategori'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="menu" class="form-label"><i class="fas fa-hamburger me-1"></i> Nama Menu</label>
                        <input type="text" id="menu" name="menu" value="<?php echo $item['menu'];?>" required class="form-control">
                    </div>
                    
                    <div class="mb-3">
                        <label for="harga" class="form-label"><i class="fas fa-tag me-1"></i> Harga</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" id="harga" name="harga" required value="<?php echo $item['harga'];?>" class="form-control">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="gambar" class="form-label"><i class="fas fa-image me-1"></i> Gambar Menu</label>
                        <?php if(!empty($item['gambar'])): ?>
                        <div class="mb-3">
                            <img src="../upload/<?php echo $item['gambar']; ?>" alt="<?php echo $item['menu']; ?>" class="img-thumbnail mb-2" style="max-height: 150px">
                            <p class="text-muted small">Gambar saat ini: <?php echo $item['gambar']; ?></p>
                        </div>
                        <?php endif; ?>
                        <input type="file" id="gambar" name="gambar" class="form-control">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar</small>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 d-flex justify-content-between">
                <a href="?f=menu&m=select" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
                <button type="submit" name="simpan" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<?php 

    if(isset($_POST['simpan'])){
        $idkategori = $_POST['idkategori']; 
        $menu = $_POST['menu'];
        $harga = $_POST['harga'];
        $gambar = $item['gambar'];
        $temp = $_FILES['gambar']['tmp_name'];

        if(!empty($temp)){
            $gambar = $gambar = $_FILES['gambar']['name'];
            move_uploaded_file($temp, '../upload/'.$gambar);
        }
        
        $sql = "UPDATE tablemenu SET idkategori=$idkategori, menu='$menu', gambar = '$gambar', harga = $harga WHERE idmenu = $id";

        $db->runSQL($sql);
        header("location:?f=menu&m=select");

    }

?>