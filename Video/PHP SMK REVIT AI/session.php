

<nav>
    <ul>
        <li>
            <a href="?menu=isi">Isi</a>
        </li>
        <li>
            <a href="?menu=hapus">Hapus</a>
        </li>
        <li>
            <a href="?menu=destroy">Destroy</a>
        </li>
    </ul>
</nav>



<?php 

        session_start();

        
        function isiSession(){

    
        $_SESSION['name'] = 'Rolo Kurang Sigma';
    
        $_SESSION['user'] = 'Korengan';
    
        $_SESSION['password'] = 'sigmaBangetBang';
    
    
        }
    

    if (isset($_GET['menu'])) {
        $menu = $_GET['menu'];

        switch ($menu){
        case 'isi':
        isiSession();
        break;
        case 'hapus':
        unset($_SESSION['user']);
        break;
        case 'destroy':
        session_destroy();
        break;
        }
    }


?>