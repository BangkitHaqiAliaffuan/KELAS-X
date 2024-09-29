<?php 

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        
        $sql = "SELECT * FROM tableorder WHERE idorder=$id";
        
        $row = $db->getITEM($sql);

    }

?>

<h3>Pembayaran Order</h3>
<div class="form-group">
    <form action="" method="post">
        <div class="form-group">
            <label for="">Total</label>
            <input type="number" name="total" required value="<?php echo $row['total'] ?>" class="form-control w-50 mt-2">            
        </div>
        <div class="form-group">
            <label for="">Bayar</label>
            <input type="number" name="bayar" required class="form-control w-50 mt-2">            
        </div>
        <div class="">
            <input class="btn btn-primary mt-5" type="submit" name="simpan" value="bayar">
        </div>
    </form>
</div>
<?php 

    if(isset($_POST['simpan'])){
        $bayar = $_POST['bayar'];
        $kembali = $bayar - $row['total'];
        $sql = "UPDATE tableorder SET bayar='$bayar', kembali = $kembali, status=1 WHERE idorder=$id";

        if($kembali<0){
            echo "<h3>Uang Anda Tidak Cukup!</h3>";
        } else{
            $db->runSQL($sql);
            header("location:?f=order&m=select");
        }


    }

?>