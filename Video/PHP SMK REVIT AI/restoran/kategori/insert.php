<h3>Insert Kategori</h3>
<div class="form-group">
    <form action="" method="post">
        <div class="form-group">
            <label for="">Nama Kategori</label>
            <input type="text" name="kategori" required placeholder="Isi Kategori" class="form-control w-50 mt-2">            
        </div>
        <div class="">
            <input class="btn btn-primary mt-5" type="submit" name="simpan" value="simpan">
        </div>
    </form>
</div>
<?php 

    if(isset($_POST['kategori'])){
        $kategori = $_POST['kategori'];
        
        $sql = "INSERT INTO tablekategori VALUES ('', '$kategori')";

        $db->runSQL($sql);
        header("location:?f=kategori&m=select");
    }

?>