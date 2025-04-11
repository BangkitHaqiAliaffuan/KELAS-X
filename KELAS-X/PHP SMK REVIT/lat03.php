<?php 


function belajar(){
    echo 'Saya Belajar PHP';
};

function belajar2(){
    return 'Saya Belajar Function Pada PHP';
};

echo belajar2().'<br>';

echo belajar().'<br>';

// belajar operator

function luasPersegi(){
    $p = 5;
    $l = 5;
    $luas = $p * $l;
    return $luas;
}

function luasPersegi2($p = 3, $l = 10) {
    $luas = $p * $l;
    return $luas;
}

function output(){
    return 'Belajar Function PHP';
};

echo 'Hasil Luas Persegi, panjang 5cm dan lebar 5cm  Adalah :'.luasPersegi().'<br>';

echo luasPersegi2() * 5 . '<br>';
echo luasPersegi2(10, 23).'<br>'; 
?>
