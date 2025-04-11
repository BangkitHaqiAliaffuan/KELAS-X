if (true){
    console.log("Dijalankan Jika Benar")
} else {
    console.log("Dijalankan Jika Salah")
}

let nilai = 100;
let standard = 76;
let berhasil = "Lulus";
let gagal = "Tidak Lulus";
let batasatas = 100;
let batasbawah = 0;
let peringatan = "Nilai Salah";

if (nilai <= batasatas && nilai >= batasbawah){
    if (nilai >= standard){
        console.log("Berhasil");
    } else {
        console.log(gagal);
    }
} else{
    console.log(peringatan);
}