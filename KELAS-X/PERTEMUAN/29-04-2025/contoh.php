<?php
/**
 * CONTOH KODE PHP
 * File ini berisi contoh-contoh kode PHP
 */

echo "<h1>CONTOH KODE PHP</h1>";

// ===== CONTOH VARIABEL =====
echo "<h2>Contoh Variabel</h2>";

$nama = "John Doe";
$umur = 25;
$tinggi = 175.5;
$aktif = true;

echo "Nama: " . $nama . "<br>";
echo "Umur: " . $umur . " tahun<br>";
echo "Tinggi: " . $tinggi . " cm<br>";
echo "Status: " . ($aktif ? "Aktif" : "Tidak Aktif") . "<br>";

// Variabel dalam string
echo "Halo, nama saya $nama dan saya berumur $umur tahun.<br><br>";

// ===== CONTOH TIPE DATA =====
echo "<h2>Contoh Tipe Data</h2>";

// String
$teks = "Ini adalah string";
echo "String: $teks<br>";

// Integer
$angka = 42;
echo "Integer: $angka<br>";

// Float
$desimal = 3.14;
echo "Float: $desimal<br>";

// Boolean
$benar = true;
$salah = false;
echo "Boolean: " . ($benar ? "true" : "false") . "<br>";

// Array
$buah = array("Apel", "Jeruk", "Mangga");
echo "Array: ";
print_r($buah);
echo "<br>";

// Null
$kosong = null;
echo "Null: " . var_export($kosong, true) . "<br>";

// Memeriksa tipe data
echo "Tipe data dari \$teks: " . gettype($teks) . "<br>";
echo "Tipe data dari \$angka: " . gettype($angka) . "<br>";
echo "Tipe data dari \$buah: " . gettype($buah) . "<br><br>";

// ===== CONTOH OPERATOR =====
echo "<h2>Contoh Operator</h2>";

// Operator Aritmatika
$a = 10;
$b = 3;

echo "a = $a, b = $b<br>";
echo "a + b = " . ($a + $b) . "<br>"; // Penjumlahan
echo "a - b = " . ($a - $b) . "<br>"; // Pengurangan
echo "a * b = " . ($a * $b) . "<br>"; // Perkalian
echo "a / b = " . ($a / $b) . "<br>"; // Pembagian
echo "a % b = " . ($a % $b) . "<br>"; // Modulus (sisa bagi)
echo "a ** b = " . ($a ** $b) . "<br><br>"; // Pangkat

// Operator Perbandingan
echo "a == b: " . var_export($a == $b, true) . "<br>"; // Sama dengan
echo "a != b: " . var_export($a != $b, true) . "<br>"; // Tidak sama dengan
echo "a > b: " . var_export($a > $b, true) . "<br>"; // Lebih besar dari
echo "a < b: " . var_export($a < $b, true) . "<br>"; // Lebih kecil dari
echo "a >= b: " . var_export($a >= $b, true) . "<br>"; // Lebih besar atau sama dengan
echo "a <= b: " . var_export($a <= $b, true) . "<br>"; // Lebih kecil atau sama dengan
echo "a === b: " . var_export($a === $b, true) . "<br><br>"; // Identik (nilai dan tipe data sama)

// Operator Logika
echo "a > 5 && b < 5: " . var_export($a > 5 && $b < 5, true) . "<br>"; // AND
echo "a > 5 || b > 5: " . var_export($a > 5 || $b > 5, true) . "<br>"; // OR
echo "!(a > 5): " . var_export(!($a > 5), true) . "<br><br>"; // NOT

// ===== CONTOH PERCABANGAN =====
echo "<h2>Contoh Percabangan</h2>";

// If-Else
$nilai = 75;
echo "Nilai: $nilai<br>";

if ($nilai >= 80) {
    echo "Nilai Anda A<br>";
} elseif ($nilai >= 70) {
    echo "Nilai Anda B<br>";
} elseif ($nilai >= 60) {
    echo "Nilai Anda C<br>";
} else {
    echo "Nilai Anda D<br>";
}

// Switch Case
$hari = "Senin";
echo "Hari: $hari<br>";

switch ($hari) {
    case "Senin":
        echo "Hari ini adalah Senin<br>";
        break;
    case "Selasa":
        echo "Hari ini adalah Selasa<br>";
        break;
    default:
        echo "Hari lainnya<br>";
}

// Operator Ternary
$umur = 20;
$status = ($umur >= 18) ? "Dewasa" : "Anak-anak";
echo "Umur: $umur, Status: $status<br><br>";

// ===== CONTOH PERULANGAN =====
echo "<h2>Contoh Perulangan</h2>";

// For Loop
echo "For Loop:<br>";
for ($i = 1; $i <= 5; $i++) {
    echo "Iterasi ke-$i<br>";
}
echo "<br>";

// While Loop
echo "While Loop:<br>";
$j = 1;
while ($j <= 5) {
    echo "Iterasi ke-$j<br>";
    $j++;
}
echo "<br>";

// Do-While Loop
echo "Do-While Loop:<br>";
$k = 1;
do {
    echo "Iterasi ke-$k<br>";
    $k++;
} while ($k <= 5);
echo "<br>";

// Foreach Loop (untuk array)
echo "Foreach Loop:<br>";
$buah = ["Apel", "Jeruk", "Mangga", "Pisang"];
foreach ($buah as $item) {
    echo "$item<br>";
}
echo "<br>";

// Foreach dengan key dan value
echo "Foreach dengan key dan value:<br>";
$siswa = [
    "nama" => "John",
    "umur" => 20,
    "jurusan" => "Informatika"
];

foreach ($siswa as $key => $value) {
    echo "$key: $value<br>";
}
echo "<br>";

// ===== CONTOH FUNGSI =====
echo "<h2>Contoh Fungsi</h2>";

// Fungsi tanpa parameter
function sapa() {
    echo "Halo, selamat datang!<br>";
}

// Memanggil fungsi
sapa();

// Fungsi dengan parameter
function sapaNama($nama) {
    echo "Halo, $nama!<br>";
}

sapaNama("John");

// Fungsi dengan parameter default
function sapaFormal($nama, $gelar = "Bapak/Ibu") {
    echo "Halo, $gelar $nama!<br>";
}

sapaFormal("John");
sapaFormal("Jane", "Dr.");

// Fungsi dengan return value
function tambah($a, $b) {
    return $a + $b;
}

$hasil = tambah(5, 3);
echo "Hasil: $hasil<br>";

// Fungsi dengan parameter variabel
function jumlahkan(...$angka) {
    $total = 0;
    foreach ($angka as $nilai) {
        $total += $nilai;
    }
    return $total;
}

echo "Jumlah: " . jumlahkan(1, 2, 3, 4, 5) . "<br><br>";

// ===== CONTOH ARRAY =====
echo "<h2>Contoh Array</h2>";

// Array Terindeks
$buah = ["Apel", "Jeruk", "Mangga", "Pisang"];

// Mengakses elemen array
echo "Buah pertama: " . $buah[0] . "<br>";
echo "Buah ketiga: " . $buah[2] . "<br>";

// Menghitung jumlah elemen array
echo "Jumlah buah: " . count($buah) . "<br>";

// Menambah elemen ke array
$buah[] = "Anggur";
array_push($buah, "Stroberi");

echo "Daftar buah setelah ditambah: ";
print_r($buah);
echo "<br><br>";

// Array Asosiatif (key-value)
$mahasiswa = [
    "nim" => "12345",
    "nama" => "John Doe",
    "jurusan" => "Informatika",
    "ipk" => 3.75
];

// Mengakses elemen array asosiatif
echo "Nama: " . $mahasiswa["nama"] . "<br>";
echo "IPK: " . $mahasiswa["ipk"] . "<br><br>";

// Array Multidimensi
$siswa = [
    ["John", "Laki-laki", 85],
    ["Jane", "Perempuan", 90],
    ["Bob", "Laki-laki", 78]
];

// Mengakses array multidimensi
echo $siswa[1][0] . " mendapat nilai " . $siswa[1][2] . "<br>";

// Fungsi array
$angka = [5, 2, 8, 1, 9];
sort($angka); // Mengurutkan array
echo "Angka setelah diurutkan: ";
print_r($angka);
echo "<br>";

$hasil = array_sum($angka); // Menjumlahkan semua elemen
echo "Jumlah: $hasil<br><br>";

// ===== CONTOH FORM SEDERHANA =====
echo "<h2>Contoh Form Sederhana</h2>";
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div>
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama">
    </div>
    <br>
    <div>
        <label for="email">Email:</label>
        <input type="text" id="email" name="email">
    </div>
    <br>
    <div>
        <input type="submit" name="submit" value="Kirim">
    </div>
</form>

<?php
// Proses form jika sudah disubmit
if (isset($_POST["submit"])) {
    // Mengambil nilai dari form
    $nama = $_POST["nama"];
    $email = $_POST["email"];
    
    // Validasi data
    $errors = [];
    
    if (empty($nama)) {
        $errors[] = "Nama harus diisi";
    }
    
    if (empty($email)) {
        $errors[] = "Email harus diisi";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid";
    }
    
    // Tampilkan hasil
    if (empty($errors)) {
        echo "<div style='color: green; margin-top: 20px;'>";
        echo "Form berhasil disubmit!<br>";
        echo "Nama: $nama<br>";
        echo "Email: $email<br>";
        echo "</div>";
    } else {
        echo "<div style='color: red; margin-top: 20px;'>";
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
        echo "</div>";
    }
}

// ===== CONTOH TANGGAL DAN WAKTU =====
echo "<h2>Contoh Tanggal dan Waktu</h2>";

// Menampilkan tanggal dan waktu saat ini
echo "Tanggal dan waktu saat ini: " . date("Y-m-d H:i:s") . "<br>";

// Format tanggal
echo "Tanggal: " . date("d/m/Y") . "<br>";
echo "Hari: " . date("l") . "<br>";
echo "Bulan: " . date("F") . "<br>";
echo "Tahun: " . date("Y") . "<br>";

// Timestamp
$timestamp = time();
echo "Timestamp saat ini: " . $timestamp . "<br>";
echo "Tanggal dari timestamp: " . date("d/m/Y H:i:s", $timestamp) . "<br>";

// Menambah atau mengurangi waktu
$nextWeek = time() + (7 * 24 * 60 * 60);
echo "Tanggal 1 minggu dari sekarang: " . date("d/m/Y", $nextWeek) . "<br><br>";

// ===== CONTOH STRING MANIPULATION =====
echo "<h2>Contoh String Manipulation</h2>";

$str = "Hello World!";

// Panjang string
echo "String: $str<br>";
echo "Panjang string: " . strlen($str) . "<br>";

// Mengubah case
echo "Uppercase: " . strtoupper($str) . "<br>";
echo "Lowercase: " . strtolower($str) . "<br>";

// Mengganti substring
$newStr = str_replace("World", "PHP", $str);
echo "Setelah replace: $newStr<br>";

// Substring
echo "Substring (6, 5): " . substr($str, 6, 5) . "<br>";

// Posisi substring
echo "Posisi 'World': " . strpos($str, "World") . "<br>";

// Membalik string
echo "String terbalik: " . strrev($str) . "<br><br>";

// ===== CONTOH FILE HANDLING =====
echo "<h2>Contoh File Handling</h2>";

// Menulis ke file
$file = fopen("test.txt", "w");
fwrite($file, "Ini adalah contoh teks yang ditulis ke file.\n");
fwrite($file, "Ini adalah baris kedua.\n");
fclose($file);

echo "File test.txt telah dibuat dan ditulis.<br>";

// Membaca dari file
$file = fopen("test.txt", "r");
echo "Isi file test.txt:<br>";
echo "<pre>";
while(!feof($file)) {
    echo fgets($file);
}
echo "</pre>";
fclose($file);

// Menghapus file
// unlink("test.txt");
// echo "File test.txt telah dihapus.<br>";

echo "<p>Ini adalah contoh-contoh dasar PHP. Silakan eksplorasi lebih lanjut untuk memperdalam pemahaman Anda!</p>";
?>