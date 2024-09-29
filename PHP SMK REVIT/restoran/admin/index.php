
<?php

    session_start();
    require_once "../dbcontroller.php";
    $db = new DB();
    
    if(!isset($_SESSION['user'])){
        header("location: login.php");
    }

    if (isset($_GET['log'])){
        session_destroy();
        header("location: login.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restoran</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
</head>
<body>
    <div class="container">
        <div class="row mt-2">
            <div class="col-md-3">
                <a href="index.php">
                    <h2 class="">Admin Page</h2>
                </a>
            </div>

            <div class="col-md-9">
                <div class="float-end mt-2">
                    <a href="?l=logout" class="ms-5">
                        Log Out
                    </a>
                </div>
                <div class="float-end mt-2 mr-4">
                    User : 
                    <a href="?f=user&m=updateuser&id=<?php echo $_SESSION['iduser'] ?>">
                        <?php echo $_SESSION['user'] ?>
                    </a>
                </div>
                <div class="float-end mt-2 mx-2"> Level : 
                    <?php echo $_SESSION['level'] ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
            <ul class="nav flex-column">
                <?php 
                    $level = $_SESSION['level'];
                    switch ($level) {
                        case 'admin';
                        echo '
                        <li class="nav-item">
                    <a class="nav-link active"  href="?f=kategori&m=select">
                        Kategori
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?f=menu&m=select">
                        Menu
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?f=pelanggan&m=select">
                        Pelanggan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?f=order&m=select">
                        Order
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?f=orderdetail&m=select">
                        Order Detail
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?f=user&m=select">
                        User
                    </a>
                </li>';
                break;

                case 'kasir';
                    echo '
                <li class="nav-item">
                    <a class="nav-link" href="?f=order&m=select">
                        Order
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?f=orderdetail&m=select">
                        Order Detail
                    </a>
                </li>
                    ';
                break;
                    
                case 'koki';
                    echo '
                    <li class="nav-item">
                        <a class="nav-link" href="?f=orderdetail&m=select">
                            Order Detail
                        </a>
                    </li> 
                    ';
                break;
                default:
                  echo 'Tidak Ada Menu';
                break;
                    }
                ?>

                <li class="nav-item">
                    <a class="nav-link active"  href="?f=kategori&m=select">
                        Kategori
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?f=menu&m=select">
                        Menu
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?f=pelanggan&m=select">
                        Pelanggan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?f=order&m=select">
                        Order
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?f=orderdetail&m=select">
                        Order Detail
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?f=user&m=select">
                        User
                    </a>
                </li>
            </ul>
            </div>
            <div class="col-md-9">
                <?php
                    if (isset($_GET['f']) && (isset($_GET['m']))){
                        $f=$_GET['f'];
                        $m=$_GET['m'];
                        
                        $file = '../'.$f.'/'.$m.'.php';

                        require_once $file;
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