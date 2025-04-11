function coba(){
    let belajar = "Saya Belajar JavaScript";
    console.log(belajar);
    console.log("javascript itu mudah");
}

function persegi(panjang, lebar){
    luas = panjang * lebar;
    console.log("Luas Persegi Panjang adalah : " + luas);
}

function out(){
    return console.log("Out Function");
}

function lingkaran(r){
    luas = 3.14 * r * r;
    return luas;
}

const tinggi = 2;
let tabung = lingkaran(10) * tinggi;

function lewat(a){
    return a;
}

console.log(lewat(3));

console.log(tabung);