<?php 
    $jumlahdata = $db->rowCOUNT("SELECT idpelanggan FROM tablepelanggan");
    
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
    
    
    $sql = "SELECT * FROM tablepelanggan ORDER BY pelanggan ASC LIMIT $mulai, $banyak";
    
    $row = $db->getALL($sql);
    
    $no = 1 + $mulai ;
    
    
?>


<h3>Pelanggan</h3>
<table class="table table-bordered w-70 mt-4">
    <thead>
        <tr>
            <th>No</th>
            <th>Pelanggan</th>
            <th>Alamat</th>
            <th>Telpon</th>
            <th>Email</th>
            <th>Update</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($row as $r): ?>
        <tr>
            <?php 
            
            if($r['aktif'] == 1 ){
                $status = 'Aktif';
            } else {
                $status = 'Tidak Aktif';
            }
            
            ?>
            <td><?php echo $no++ ?></td>    
            <td><?php echo $r['pelanggan']; ?></td>    
            <td><?php echo $r['alamat']; ?></td>    
            <td><?php echo $r['telp']; ?></td>    
            <td><?php echo $r['email']; ?></td>    
            <td><a href="?f=pelanggan&m=update&id=<?php echo $r['idpelanggan']?>"><?php echo $status ?></a></td>      
            <td><a href="?f=pelanggan&m=delete&id=<?php echo $r['idpelanggan']?>">Delete</a></td>    
        </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?php 

    for ($i = 1; $i <= $halaman; $i++){
        echo '<a href="?f=pelanggan&m=select&p='.$i.'">'.$i.'</a>';
        echo '&nbsp &nbsp &nbsp';
    }; 

?>
