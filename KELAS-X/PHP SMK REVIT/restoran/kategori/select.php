<?php 
    $jumlahdata = $db->rowCOUNT("SELECT idkategori FROM tablekategori");
    
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
    
    
    $sql = "SELECT * FROM tablekategori ORDER BY kategori ASC LIMIT $mulai, $banyak";
    
    $row = $db->getALL($sql);
    
    $no = 1 + $mulai ;
    
    
?>
<div class="float-start me-5 mb-3">
    <a class="btn btn-primary" href="?f=kategori&m=insert" role="button">Tambah Data</a>  
</div>

<h3>Kategori</h3>
<table class="table table-bordered w-5">
    <thead>
        <tr>
            <th>No</th>
            <th>Kategori</th>
            <th>Update</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($row as $r): ?>
        <tr>
            <td><?php echo $no++ ?></td>    
            <td><?php echo $r['kategori']; ?></td>    
            <td><a href="?f=kategori&m=update&id=<?php echo $r['idkategori']?>">Update</a></td>      
            <td><a href="?f=kategori&m=delete&id=<?php echo $r['idkategori']?>">Delete</a></td>    
        </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?php 

    for ($i = 1; $i <= $halaman; $i++){
        echo '<a href="?f=kategori&m=select&p='.$i.'">'.$i.'</a>';
        echo '&nbsp &nbsp &nbsp';
    }; 

?>
