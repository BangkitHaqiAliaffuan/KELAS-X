
<h3>Detail Pembelian</h3>
<div class="form-group">
    <form action="" method="post">
        <div class="form-group float-start">
            <label for="">Tanggal Awal</label>
            <input type="date" name="tawal" required  class="form-control w-50 mt-2 ">            
        </div>
        <div class="">
        <div class="form-group float-start">
            <label for="">Tanggal Akhir</label>
            <input type="date" name="takhir" required  class="form-control w-50 mt-2 ">            
        </div>
        <div class="">
            <input class="btn btn-primary mt-5" type="submit" name="simpan" value="cari">
        </div>
    </form>
</div>

<?php 


    
    $jumlahdata = $db->rowCOUNT("SELECT idorderdetail FROM vorderdetail ");
    
    $banyak = 3;
    
    $halaman = ceil($jumlahdata / $banyak);

    if(isset($_GET['p'])){
        $p = $_GET['p'];
        // echo $p;
        $mulai = ($p * $banyak) - $banyak;
        // 3 = 2 (2 * 3) - 3
    } else{
        $mulai = 0;
    };
    
    
    $sql = "SELECT * FROM vorderdetail  ORDER BY idorderdetail ASC LIMIT $mulai, $banyak";

    
    if(isset($_POST['simpan'])){
        $tawal = $_POST['tawal'];
        $tawal = $_POST['takhir'];
        $sql = "SELECT * FROM vordertail WHERE tglorder BETWEEN '$tawal' AND '$takhir'";
    }
    
    $row = $db->getALL($sql);
    
    $no = 1 + $mulai ;

    $total = 0;
    
    
?>
<div class="float-start me-5 mb-3">
    <a class="btn btn-primary" href="?f=kategori&m=insert" role="button">Tambah Data</a>  
</div>

<h3>Detail Pembelian</h3>
<table class="table table-bordered w-5">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Menu</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Total</th>
            <th>Pelanggan</th>
            <th>Alamat</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($row)){ ?>
        <?php foreach($row as $r): ?>
           
        <tr>
            <td><?php echo $no++ ?></td>    
            <td><?php echo $r['pelanggan']; ?></td>    
            <td><?php echo $r['tglorder']; ?></td>    
            <td><?php echo $r['menu']; ?></td>         
            <td><?php echo $r['harga']; ?></td>         
            <td><?php echo $r['jumlah']; ?></td>         
            <td><?php echo $r['jumlah'] * $r['harga']; ?></td>         
            <td><?php echo $r['alamat']; ?></td>    
            <?php 
            $total = $total + ($r['jumlah'] * $r['harga']);
            ?>
        </tr>
        <?php endforeach ?>
        <?php } ?>

        <tr>
            <td colspan="6">
                <h3 >Grand Total :</h3>
            </td>
            <td>
                <h4><?php echo $total ?></h4>
            </td>
        </tr>
    </tbody>
</table>

<?php 

    for ($i = 1; $i <= $halaman; $i++){
        echo '<a href="?f=order&m=detail&p='.$i.'">'.$i.'</a>';
        echo '&nbsp &nbsp &nbsp';
    }; 

?>
