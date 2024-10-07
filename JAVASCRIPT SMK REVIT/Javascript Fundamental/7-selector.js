const hari = 7;
let hasil;

switch (hari) {
    case 1:
        hasil = "Senin";
        break;
    case 2:
        hasil = "Selasa";
        break;
    case 3:
        hasil = "Rabu";
        break;
    case 4:
        hasil = "Kamis";
        break;
    case 5:
        hasil = "Jumat";
        break;
    case 6:
        hasil = "Sabtu";
        break;
    case 7:
        hasil = "Minggu";
        break;
    default:
        hasil = "Hari ini adalah hari yang salah!";
        break;
}

console.log(hasil);

const bln = "januari";
let bulan;

switch(bln){
    case "januari":
        bulan = 1;
        break;
    case "februari":
        bulan = 2;
        break;
    case "maret":
        bulan = 3;
        break;
    case "april":
        bulan = 4;
        break;
    case "mei":
        bulan = 5;
        break;
    case "juni":
        bulan = 6;
        break;
    case "juli":
        bulan = 7;
        break;
    case "agustus":
        bulan = 8;
        break;
    case "september":
        bulan = 9;
        break;
    case "oktober":
        bulan = 10;
        break;
    case "november":
        bulan = 11;
        break;
    case "desember":
        bulan = 12;
        break;

    default:
        bulan = "Bulan ini salah!";
        break;
}

console.log(bulan);