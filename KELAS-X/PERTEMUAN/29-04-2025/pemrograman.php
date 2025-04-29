<?php
/**
 * DASAR PEMROGRAMAN PHP
 * File ini berisi materi dasar pemrograman PHP
 */

// ===== PENGENALAN PHP =====
echo "<h1>DASAR PEMROGRAMAN PHP</h1>";

echo "<h2>Pengenalan PHP</h2>";
echo "<p>PHP (PHP: Hypertext Preprocessor) adalah bahasa pemrograman server-side yang dirancang khusus untuk pengembangan web. PHP dapat digunakan untuk membuat halaman web dinamis dan aplikasi web.</p>";

echo "<h3>Mengapa Menggunakan PHP?</h3>";
echo "<ul>
    <li>Gratis dan open source</li>
    <li>Mudah dipelajari</li>
    <li>Kompatibel dengan hampir semua server web</li>
    <li>Mendukung berbagai database</li>
    <li>Memiliki komunitas besar</li>
</ul>";

// ===== SINTAKS DASAR PHP =====
echo "<h2>Sintaks Dasar PHP</h2>";
echo "<p>Kode PHP dimulai dengan &lt;?php dan diakhiri dengan ?&gt;. Setiap pernyataan PHP harus diakhiri dengan titik koma (;).</p>";
echo "<pre>
&lt;?php
    // Ini adalah komentar satu baris
    
    /* 
       Ini adalah komentar
       multi baris
    */
    
    echo \"Hello World!\"; // Menampilkan teks ke layar
    print \"Hello World!\"; // Alternatif untuk echo
?&gt;
</pre>";

// ===== VARIABEL DALAM PHP =====
echo "<h2>Variabel dalam PHP</h2>";
echo "<p>Variabel dalam PHP dimulai dengan tanda $ diikuti dengan nama variabel.</p>";
echo "<pre>
&lt;?php
    // Deklarasi variabel
    \$nama = \"John Doe\";
    \$umur = 25;
    \$tinggi = 175.5;
    \$aktif = true;
    
    // Menampilkan variabel
    echo \"Nama: \" . \$nama . \"&lt;br&gt;\";
    echo \"Umur: \" . \$umur . \" tahun&lt;br&gt;\";
    echo \"Tinggi: \" . \$tinggi . \" cm&lt;br&gt;\";
    echo \"Status: \" . (\$aktif ? \"Aktif\" : \"Tidak Aktif\") . \"&lt;br&gt;\";
    
    // Variabel dalam string
    echo \"Halo, nama saya \$nama dan saya berumur \$umur tahun.\";
?&gt;
</pre>";

// ===== TIPE DATA DALAM PHP =====
echo "<h2>Tipe Data dalam PHP</h2>";
echo "<p>PHP mendukung beberapa tipe data dasar:</p>";
echo "<ul>
    <li>String - rangkaian karakter</li>
    <li>Integer - bilangan bulat</li>
    <li>Float - bilangan desimal</li>
    <li>Boolean - true atau false</li>
    <li>Array - kumpulan nilai</li>
    <li>Object - instance dari class</li>
    <li>NULL - variabel tanpa nilai</li>
    <li>Resource - referensi ke resource eksternal</li>
</ul>";

// ===== OPERATOR DALAM PHP =====
echo "<h2>Operator dalam PHP</h2>";
echo "<h3>Operator Aritmatika</h3>";
echo "<ul>
    <li>+ (Penjumlahan)</li>
    <li>- (Pengurangan)</li>
    <li>* (Perkalian)</li>
    <li>/ (Pembagian)</li>
    <li>% (Modulus - sisa bagi)</li>
    <li>** (Pangkat)</li>
</ul>";

echo "<h3>Operator Perbandingan</h3>";
echo "<ul>
    <li>== (Sama dengan)</li>
    <li>!= (Tidak sama dengan)</li>
    <li>=== (Identik - nilai dan tipe data sama)</li>
    <li>!== (Tidak identik)</li>
    <li>> (Lebih besar dari)</li>
    <li>< (Lebih kecil dari)</li>
    <li>>= (Lebih besar atau sama dengan)</li>
    <li><= (Lebih kecil atau sama dengan)</li>
</ul>";

echo "<h3>Operator Logika</h3>";
echo "<ul>
    <li>&& / AND (Dan)</li>
    <li>|| / OR (Atau)</li>
    <li>! (Tidak)</li>
    <li>XOR (Atau eksklusif)</li>
</ul>";

// ===== STRUKTUR KONTROL =====
echo "<h2>Struktur Kontrol</h2>";

echo "<h3>Percabangan (Conditional)</h3>";
echo "<pre>
&lt;?php
    // If-Else
    if (\$nilai >= 80) {
        echo \"Nilai Anda A\";
    } elseif (\$nilai >= 70) {
        echo \"Nilai Anda B\";
    } elseif (\$nilai >= 60) {
        echo \"Nilai Anda C\";
    } else {
        echo \"Nilai Anda D\";
    }
    
    // Switch Case
    switch (\$hari) {
        case \"Senin\":
            echo \"Hari ini adalah Senin\";
            break;
        case \"Selasa\":
            echo \"Hari ini adalah Selasa\";
            break;
        default:
            echo \"Hari lainnya\";
    }
    
    // Operator Ternary
    \$status = (\$umur >= 18) ? \"Dewasa\" : \"Anak-anak\";
?&gt;
</pre>";

echo "<h3>Perulangan (Loop)</h3>";
echo "<pre>
&lt;?php
    // For Loop
    for (\$i = 1; \$i <= 5; \$i++) {
        echo \"Iterasi ke-\$i&lt;br&gt;\";
    }
    
    // While Loop
    \$j = 1;
    while (\$j <= 5) {
        echo \"Iterasi ke-\$j&lt;br&gt;\";
        \$j++;
    }
    
    // Do-While Loop
    \$k = 1;
    do {
        echo \"Iterasi ke-\$k&lt;br&gt;\";
        \$k++;
    } while (\$k <= 5);
    
    // Foreach Loop (untuk array)
    \$buah = [\"Apel\", \"Jeruk\", \"Mangga\", \"Pisang\"];
    foreach (\$buah as \$item) {
        echo \"\$item&lt;br&gt;\";
    }
?&gt;
</pre>";

// ===== FUNGSI DALAM PHP =====
echo "<h2>Fungsi dalam PHP</h2>";
echo "<p>Fungsi adalah blok kode yang dapat digunakan kembali.</p>";
echo "<pre>
&lt;?php
    // Fungsi tanpa parameter
    function sapa() {
        echo \"Halo, selamat datang!\";
    }
    
    // Fungsi dengan parameter
    function sapaNama(\$nama) {
        echo \"Halo, \$nama!\";
    }
    
    // Fungsi dengan parameter default
    function sapaFormal(\$nama, \$gelar = \"Bapak/Ibu\") {
        echo \"Halo, \$gelar \$nama!\";
    }
    
    // Fungsi dengan return value
    function tambah(\$a, \$b) {
        return \$a + \$b;
    }
?&gt;
</pre>";

// ===== ARRAY DALAM PHP =====
echo "<h2>Array dalam PHP</h2>";
echo "<p>Array adalah struktur data yang dapat menyimpan beberapa nilai dalam satu variabel.</p>";
echo "<pre>
&lt;?php
    // Array Terindeks
    \$buah = [\"Apel\", \"Jeruk\", \"Mangga\", \"Pisang\"];
    
    // Array Asosiatif (key-value)
    \$mahasiswa = [
        \"nim\" => \"12345\",
        \"nama\" => \"John Doe\",
        \"jurusan\" => \"Informatika\",
        \"ipk\" => 3.75
    ];
    
    // Array Multidimensi
    \$siswa = [
        [\"John\", \"Laki-laki\", 85],
        [\"Jane\", \"Perempuan\", 90],
        [\"Bob\", \"Laki-laki\", 78]
    ];
?&gt;
</pre>";

// ===== FORM HANDLING =====
echo "<h2>Form Handling</h2>";
echo "<p>PHP sering digunakan untuk memproses data formulir HTML.</p>";
echo "<pre>
&lt;?php
    // Cek apakah form sudah disubmit
    if (\$_SERVER[\"REQUEST_METHOD\"] == \"POST\") {
        // Mengambil nilai dari form
        \$nama = \$_POST[\"nama\"];
        \$email = \$_POST[\"email\"];
        
        // Validasi data
        if (empty(\$nama)) {
            echo \"Nama harus diisi\";
        } elseif (empty(\$email)) {
            echo \"Email harus diisi\";
        } else {
            echo \"Form berhasil disubmit\";
        }
    }
?&gt;
</pre>";

// ===== DATABASE DENGAN PHP =====
echo "<h2>Koneksi Database dengan PHP</h2>";
echo "<p>PHP dapat digunakan untuk berinteraksi dengan database seperti MySQL.</p>";
echo "<pre>
&lt;?php
    // Konfigurasi database
    \$servername = \"localhost\";
    \$username = \"root\";
    \$password = \"\";
    \$dbname = \"contoh_db\";
    
    // Membuat koneksi
    \$conn = new mysqli(\$servername, \$username, \$password, \$dbname);
    
    // Memeriksa koneksi
    if (\$conn->connect_error) {
        die(\"Koneksi gagal: \" . \$conn->connect_error);
    }
    
    // Query SQL
    \$sql = \"SELECT id, nama, email FROM users\";
    \$result = \$conn->query(\$sql);
    
    // Menampilkan data
    if (\$result->num_rows > 0) {
        while(\$row = \$result->fetch_assoc()) {
            echo \"ID: \" . \$row[\"id\"] . \" - Nama: \" . \$row[\"nama\"] . \"&lt;br&gt;\";
        }
    }
    
    // Menutup koneksi
    \$conn->close();
?&gt;
</pre>";

// ===== CARA MENJALANKAN PHP =====
echo "<h2>Cara Menjalankan PHP</h2>";
echo "<ol>
    <li>Pastikan XAMPP sudah terinstal dan berjalan (Apache dan MySQL)</li>
    <li>Simpan file PHP di direktori htdocs</li>
    <li>Buka browser dan akses http://localhost/nama_file.php</li>
</ol>";

// ===== TIPS BELAJAR PHP =====
echo "<h2>Tips Belajar PHP</h2>";
echo "<ol>
    <li>Praktikkan kode secara langsung</li>
    <li>Gunakan var_dump() atau print_r() untuk debugging</li>
    <li>Baca dokumentasi resmi PHP di <a href='https://www.php.net/' target='_blank'>php.net</a></li>
    <li>Ikuti tutorial dan kursus online</li>
    <li>Bergabung dengan komunitas PHP</li>
</ol>";

echo "<p>Semoga panduan dasar ini membantu Anda memulai perjalanan belajar PHP!</p>";
?>