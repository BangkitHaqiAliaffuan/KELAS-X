<?php 
    $jumlahdata = $db->rowCOUNT("SELECT iduser FROM tableuser");
    
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
    
    
    $sql = "SELECT * FROM tableuser ORDER BY user ASC LIMIT $mulai, $banyak";
    
    $row = $db->getALL($sql);
    
    $no = 1 + $mulai ;
    
    
?>
<div class="float-start me-5 mb-3 mt-5">
    <a class="btn btn-primary" href="?f=user&m=insert" role="button">Tambah Data</a>  
</div>

<h3 class="mt-5">User</h3>
<table class="table table-bordered w-5">
    <thead>
        <tr>
            <th>No</th>
            <th>User</th>
            <th>Email</th>
            <th>Level</th>
            <th>Update</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($row as $r): ?>
            <?php 
            
            if($r['aktif']==1){
                $status = "Aktif";
            } else{
                $status = "Banned";
            }
                
            ?>
        <tr>
            <td><?php echo $no++ ?></td>    
            <td><?php echo $r['user']; ?></td>    
            <td><?php echo $r['email']; ?></td>    
            <td><?php echo $r['level']; ?></td>    
            <td><a href="?f=user&m=update&id=<?php echo $r['iduser']?>"><?php echo $status; ?></a></td>      
            <td><a href="?f=user&m=delete&id=<?php echo $r['iduser']?>">Delete</a></td>    
        </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?php 

    for ($i = 1; $i <= $halaman; $i++){
        echo '<a href="?f=user&m=select&p='.$i.'">'.$i.'</a>';
        echo '&nbsp &nbsp &nbsp';
    }; 

?>
