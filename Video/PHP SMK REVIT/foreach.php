<?php

    $nama = array("sukdi", "umbayah", "redVelvet", "blackPink", "exo", "bts", 100); 

    var_dump($nama);

    foreach ($nama as $key) {
        echo $key."<br>";
    }

    $nama = array(
        "tejo" => "Aceh",
        "kluang" => "NTT",
        "Sigma" => "Pedang sigma",
    );

    var_dump($nama);
    echo '<br>';
    foreach ($nama as $a => $value) {
        echo $a."-".$b;
        echo '<br>';
    }


?>