
<h3>Menu</h3>



<div class="mt-5 mb-5">
    <?php 
    
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $where = "WHERE idkategori = $id ";
            $id="&id".$id;
            
        } else{
            $where = "";
            $id= "";
        }

          
    ?>
    
</div>

<?php 
    $jumlahdata = $db->rowCOUNT("SELECT idmenu FROM tablemenu ");
    
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
    
    
    $sql = "SELECT * FROM tablemenu $where ORDER BY menu ASC LIMIT $mulai, $banyak";
    
    $row = $db->getALL($sql);
    
    $no = 1 + $mulai ;
    
    
?>




        <?php if(!empty($row)){; ?>
        <?php foreach($row as $r): ?>

        <div class="card" style="width: 15rem; float:left; margin:10px;">
                <img style="height: 150px;" src="upload/<?php echo $r['gambar']; ?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?php echo $r['menu']; ?>  </h5>
                <p class="card-text"><?php echo $r['harga']; ?></p>
                <a class="btn btn-primary" href="?f=home&m=beli&id=<?php echo $r['idmenu']?>" role="button">Beli</a>  
            </div>
        </div>
        <?php endforeach ?>
     <?php } ?>

    <div style="clear: both;">

      
<?php 

    for ($i = 1; $i <= $halaman; $i++){
        echo '<a href="?f=home&m=produk&p='.$i.$id.'">'.$i.'</a>';
        echo '&nbsp &nbsp &nbsp';
    }; 

?>
    </div>

