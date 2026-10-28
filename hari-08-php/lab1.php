<?php
// ==========================================
// LAB 1 - PHP DASAR
// ==========================================

// 1. Variabel dan var_dump()
$nama = "Budi";
$umur = 25;
$status = true;

echo "<h2>1. Variabel PHP</h2>";

echo "Nama: " . $nama . "<br>";
echo "Umur: " . $umur . " tahun<br>";
echo "Status: " . ($status ? "Aktif" : "Tidak aktif") . "<br>";

echo "<h3>Hasil var_dump()</h3>";

echo "Variabel nama: ";
var_dump($nama);

echo "<br>Variabel umur: ";
var_dump($umur);

echo "<br>Variabel status: ";
var_dump($status);


// 2. Tabel perkalian 1 sampai 10
echo "<h2>2. Tabel Perkalian 1-10</h2>";

echo "<table border='1' cellpadding='8' cellspacing='0'>";

for ($i = 1; $i <= 10; $i++) {
    echo "<tr>";

    for ($j = 1; $j <= 10; $j++) {
        echo "<td>" . ($i * $j) . "</td>";
    }

    echo "</tr>";
}

echo "</table>";


// 3. Bilangan ganjil dan genap 1-20
echo "<h2>3. Bilangan Ganjil dan Genap 1-20</h2>";

for ($i = 1; $i <= 20; $i++) {
    if ($i % 2 == 0) {
        echo "$i adalah bilangan genap<br>";
    } else {
        echo "$i adalah bilangan ganjil<br>";
    }
}


// 4. FizzBuzz 1-30
echo "<h2>4. FizzBuzz 1-30</h2>";

for ($i = 1; $i <= 30; $i++) {
    if ($i % 3 == 0 && $i % 5 == 0) {
        echo "FizzBuzz";
    } elseif ($i % 3 == 0) {
        echo "Fizz";
    } elseif ($i % 5 == 0) {
        echo "Buzz";
    } else {
        echo $i;
    }

    echo "<br>";
}


// 5. Konversi nilai ke grade menggunakan match
echo "<h2>5. Konversi Nilai ke Grade</h2>";

$nilai = 85;

$grade = match (true) {
    $nilai >= 90 => "A",
    $nilai >= 80 => "B",
    $nilai >= 70 => "C",
    $nilai >= 60 => "D",
    default => "E",
};

echo "Nilai: $nilai<br>";
echo "Grade: $grade<br>";


// 6. Kalender sederhana: hari dalam bahasa Indonesia
echo "<h2>6. Kalender Sederhana</h2>";

$hari = [
    'Minggu',
    'Senin',
    'Selasa',
    'Rabu',
    'Kamis',
    'Jumat',
    'Sabtu'
];

date_default_timezone_set('Asia/Jakarta');

$nomorHari = date('w');
$tanggal = date('d-m-Y H:i:s');

echo "Hari ini: " . $hari[$nomorHari] . "<br>";
echo "Tanggal: " . $tanggal;
