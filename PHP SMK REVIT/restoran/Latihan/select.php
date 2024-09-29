
<div style="margin-left:50vh;">
<h3>
    <a href="http://localhost/php-smk-revit/restoran/kategori/insert.php">Tambah Data</a>
</h3>
<?php 

    require_once "../function.php";

    if(isset($_GET['update'])){
        $id = $_GET['update'];
        require_once "update.php";
    }

    if (isset($_GET['hapus'])){
        $id = $_GET['hapus'];
        require_once "delete.php";
    };

    echo '<br>';
    
    $sql = "SELECT idkategori FROM tablekategori";
    $result = mysqli_query($koneksi, $sql);

    $jumlahdata = mysqli_num_rows($result);

    // echo $jumlahdata;

    

    $mulai = 3;
    $banyak = 3;

    $halaman = ceil($jumlahdata / $banyak);

    for ($i = 1; $i <= $halaman; $i++){
        echo '<a href="?p='.$i.'">'.$i.'</a>';
        echo '&nbsp &nbsp &nbsp';
    };

    echo '<br> <br>';

    if(isset($_GET['p'])){
        $p = $_GET['p'];
        // echo $p;
        $mulai = ($p * $banyak) - $banyak;
        // 3 = 2 (2 * 3) - 3
    } else{
        $mulai = 0;
    };

    $sql = "SELECT * FROM tablekategori LIMIT $mulai,$banyak";

    // echo $sql;

    $result  = mysqli_query($koneksi, $sql);

    // var_dump($result);

    $jumlah = mysqli_num_rows($result);

    echo '
       
        <table border="1">
            <tr>
                <th>No</th>
                <th>Kategori</th>
                <th>Hapus</th>
                <th>Update</th>
            </tr>
    ';

    $no=$mulai+1;

    if ($jumlah > 0){
        while ($row = mysqli_fetch_assoc($result)){
            echo '<tr>';
            echo '<td>'.$no++.'</td>';
            echo '<td>'.$row['kategori'].'</td>';
            echo '<td> <a href="?hapus='.$row['idkategori'].'">'.'hapus'.'</a></td>';
            echo '<td> <a href="?update='.$row['idkategori'].'">'.'update'.'</a></td>';
            echo '</tr>';
        }
    }

    echo '</table>';

    // echo '<br>';
    // echo "Jumlah data: ".$jumlah;

?>
</div>