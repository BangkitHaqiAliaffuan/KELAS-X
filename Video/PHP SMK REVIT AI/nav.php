<nav>
    <ul>
        <li>
            <a href="">Home</a>
        </li>
        <li>
            <a href="?menu=about">About</a>
        </li>
        <li>
            <a href="?menu=sejarah">Sejarah</a>
        </li>
        <li>
            <a href="?menu=kontak">Kontak</a>
        </li>
    </ul>
    <h1>Sgima</h1>
</nav>

<?php 


    if ( isset($_GET['menu'])) {
        
        $menu = $_GET['menu'];

        require_once  $menu.'.php';
        
    }


?>