<?php 

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        
        $sql = "SELECT * FROM tablekategori WHERE idkategori=$id";
        
        $row = $db->getITEM($sql);
    }

?>

<h3>Update Kategori</h3>
<div class="form-group">
    <form action="" method="post">
        <div class="form-group">
            <label for="">Nama Kategori</label>
            <input type="text" name="kategori" required value="<?php echo $row['kategori'] ?>" class="form-control w-50 mt-2">            
        </div>
        <div class="">
            <input class="btn btn-primary mt-5" type="submit" name="simpan" value="simpan">
        </div>
    </form>
</div>
<?php 

    if(isset($_POST['simpan'])){
        $kategori = $_POST['kategori'];
        
        $sql = "UPDATE tablekategori SET kategori='$kategori' WHERE idkategori=$id";


        $db->runSQL($sql);
        header("location:?f=kategori&m=select");
    }

?>