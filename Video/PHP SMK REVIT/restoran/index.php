
<?php

    session_start();
    require_once "dbcontroller.php";
    $db = new DB();
    
    $sql = "SELECT * FROM tablekategori ORDER BY kategori";
    $row = $db->getAll($sql);
    
    if(isset($_GET['log'])){
        session_destroy();
        header("Location: index.php");
        
    }

    function cart(){
        global $db;

        $cart = 0;



        foreach ($_SESSION as $key => $value){
            if($key<>'pelanggan' && $key<> 'idpelanggan' && $key<> 'user' && $key<> 'level' && $key<> 'iduser'){
                $id = substr($key,1);

            $sql = "SELECT * FROM tablemenu WHERE idmenu=$id";
            $row = $db -> getAll($sql);

                foreach($row as $r){
                    $cart++;
                }
            }
        }

        return $cart;
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restoran SMK</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 class="mt-3"><a href="index.php">Restoran SMK</a></h2>
            </div>

            <div class="col-md-9">
                <?php 
                
                if(isset($_SESSION['pelanggan'])){
                    echo'
                    <div class="float-end mt-3 mx-2">
                       <a href="?log=logout">Logout</a> 
                    </div>
                    <div class="float-end mt-3 mx-2">
                       Pelanggan : 
                    </div>
                    <div class="float-end mt-3 mx-2">
                       Cart : (
                       <a href="?f=home&m=beli">'.cart().'</a> )
                    </div>
                    <div class="float-end mt-3 mx-2">
                      <a href="?f=home&m=histori">  Histori : </a>
                    </div>';
                } else{
                    echo '
                
                    <div class="float-end mt-3 mx-2">
                     <a href="?f=home&m=login">Login</a> 
                    </div>
                    <div class="float-end mt-3 mx-2">
                     <a href="?f=home&m=daftar">Daftar</a>
                    </div>

                    ';
                }

                ?>
                
                
                
                
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <h3>Kategori</h3>
                <br>
            <ul class="nav flex-column">
                <?php if(!empty($row)) { ?>
                    <?php foreach($row as $r): ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="?f=home&m=produk&id=<?php echo $r['idkategori'] ?>"><?php echo $r['kategori'] ?></a>
                    </li>
                    <?php endforeach ?>
                <?php } ?>
            </ul>
            </div>
            <div class="col-md-9">
                <?php
                    if(isset($_GET['f']) && isset($_GET['m'])){
                        $f=$_GET['f'];
                        $m=$_GET['m']; 
                        
                        $file = $f.'/'.$m.'.php';

                        require_once($file);
                        
                    } else{
                        require_once "home/produk.php";
                    }
                ?>
            </div>

        </div>
        <div class="row">
            <div class="col mt-5">
                <p class="text-center">2019 - copyright@uwawuwuz.com</p>
            </div>
        </div>
    </div>
</body>
</html>