<?php 

    session_start();

    echo $_SESSION['Nama'];

    echo '<br>';

    echo $_SESSION['User'];

    echo '<br>';

    echo $_SESSION['Password'];

    echo '<br>';

    foreach($_SESSION as $key => $value){
        echo $key.' => '.$value.'<br>';
    }

?>