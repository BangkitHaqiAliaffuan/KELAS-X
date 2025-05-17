<?php

$data = "Saya Belajar PHP";
$isi = "Materi Belajar PHP";
$materi = "Materi PHP";
$list1 = "Variabel";
$list2 = "array";
$list3 = "Pengujian";
$list4 = "Pengulangan";
$list5 = "Function";
$list6 = "Class";
$list7 = "Objek";
$list8 = "FrameWork";
$list9 = "PHP dari MYSQL";
$sekolahs =[
    "TK Muhammdadiyah",
    "SD Negeri Sumorame",
    "SMP Negeri 3 Candi",
    "SMK Negeri 2 Buduran",
];

$identitas = [
    "Bangkit Haqi Aliaffuan",
    "JL.Singkarso",
    "bangkit@gmail.com",
    "@haqi",
];

$judul = "Curriculum Vitae";

$hobbies = [
    "Makan Ayam",
    "Gym",
    "Coding",
    "Tidur",
];

$skills = ['',];

$lists = [
    "Variabel",
    "Array",
    "Pengujian",
    "Pengulangan",
    "Function",
    "Class",
    "Objek",
    "FrameWork",
    "PHP dari MMYSQL"
];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP</title>
    <style>
        .kamar {
            text-align: center;
        }

        .list {
            display: flex;
            justify-content: center;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1><?= $judul ?></h1>
    </div>
    <div class="identitas">
        <table>
            <thead>
                <tr>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Nama</td>
                    <td><?= $identitas[0] ?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td><?= $identitas[1] ?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td><?= $identitas[1] ?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td><?= $identitas[1] ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="kamar">
        <h1>
            <?php echo $data; ?>
        </h1>
        <h2>Materi PHP</h2>
        <p><?= $isi ?></p>
    </div>
    <div class="list">
        <ol class="">
            <li>
                <?=
                $lists[0];
                ?></li>
                <p>Data bisa berupa text atau string bisa juga angka dan numerik</p>
                <p>Variabel Adalah Wadah Atau tempat untuk menyimpan data</p>
            <li>
                <?=
                $list[1]
                ?></li>
            <li>
                <?=
                $list[2]
                ?></li>
            <li>
                <?=
                $list[3]
                ?></li>
            <li>
                <?=
                $list[4]
                ?></li>
            <li>
                <?=
                $list[5]
                ?></li>
            <li>
                <?=
                $list[6]
                ?></li>
            <li>
                <?=
                $list[7]
                ?></li>
            <li>
                <?=
                $list[8]
                ?></li>

        </ol>
    </div>
</body>

</html>