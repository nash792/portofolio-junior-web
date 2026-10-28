<?php

declare(strict_types=1);

$peserta = [
    ['nama' => 'Sari', 'kelas' => 'Web', 'nilai' => 90],
    ['nama' => 'Tedy', 'kelas' => 'Web', 'nilai' => 70],
    ['nama' => 'Citra', 'kelas' => 'Data', 'nilai' => 72],
    ['nama' => 'Wildan', 'kelas' => 'Web', 'nilai' => 72],
    ['nama' => 'Budi', 'kelas' => 'Web', 'nilai' => 90],
    ['nama' => 'Cindy', 'kelas' => 'Data', 'nilai' => 86],
];

// Fungsi untuk mengamankan output HTML
function e(string|int|float|null $nilai): string
{
    return htmlspecialchars(
        (string) $nilai,
        ENT_QUOTES | ENT_SUBSTITUTE,
        'UTF-8'
    );
}

// 1. Menghitung rata-rata nilai
function hitungRataRata(array $daftar): float
{
    if (count($daftar) === 0) {
        return 0.0;
    }

    $total = 0;

    foreach ($daftar as $item) {
        $total += $item['nilai'];
    }

    return $total / count($daftar);
}

// Mencari peserta dengan nilai tertinggi
function cariTertinggi(array $daftar): ?array
{
    if (count($daftar) === 0) {
        return null;
    }

    $tertinggi = $daftar[0];

    foreach ($daftar as $item) {
        if ($item['nilai'] > $tertinggi['nilai']) {
            $tertinggi = $item;
        }
    }

    return $tertinggi;
}

// 2. Memfilter peserta yang lulus
function filterLulus(array $peserta, int $batas = 70): array
{
    return array_values(array_filter(
        $peserta,
        fn(array $item): bool => $item['nilai'] >= $batas
    ));
}

// 3. Mengurutkan nilai dari tertinggi ke terendah
// Menggunakan salinan agar array asli tidak berubah
function urutkanNilai(array $peserta): array
{
    $hasil = $peserta;

    usort(
        $hasil,
        fn(array $a, array $b): int =>
        $b['nilai'] <=> $a['nilai']
    );

    return $hasil;
}

// 4. Mengelompokkan peserta berdasarkan kelas
function kelompokkanPerKelas(array $peserta): array
{
    $hasil = [];

    foreach ($peserta as $item) {
        $kelas = $item['kelas'];
        $hasil[$kelas][] = $item;
    }

    return $hasil;
}

// Fungsi untuk menentukan grade
function tentukanGrade(int $nilai): string
{
    return match (true) {
        $nilai >= 90 => 'A',
        $nilai >= 80 => 'B',
        $nilai >= 70 => 'C',
        $nilai >= 60 => 'D',
        default => 'E',
    };
}

// Fungsi untuk menampilkan tabel HTML
function tampilkanTabel(array $daftar): void
{
    echo '<table>';
    echo '<thead><tr>';
    echo '<th>No.</th>';
    echo '<th>Nama</th>';
    echo '<th>Kelas</th>';
    echo '<th>Nilai</th>';
    echo '<th>Grade</th>';
    echo '</tr></thead><tbody>';

    if (count($daftar) === 0) {
        echo '<tr><td colspan="5">Tidak ada data</td></tr>';
    }

    foreach ($daftar as $index => $item) {
        echo '<tr>';
        echo '<td>' . e($index + 1) . '</td>';
        echo '<td>' . e($item['nama']) . '</td>';
        echo '<td>' . e($item['kelas']) . '</td>';
        echo '<td>' . e($item['nilai']) . '</td>';
        echo '<td>' . e(tentukanGrade($item['nilai'])) . '</td>';
        echo '</tr>';
    }

    echo '</tbody></table>';
}

// Menguji seluruh fungsi
$rataRata = hitungRataRata($peserta);
$tertinggi = cariTertinggi($peserta);
$pesertaLulus = filterLulus($peserta);
$pesertaUrut = urutkanNilai($peserta);
$kelompok = kelompokkanPerKelas($peserta);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Praktikum Fungsi PHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background: #f4f6f9;
            color: #222;
        }

        h1,
        h2 {
            color: #174a7e;
        }

        .hasil {
            background: white;
            padding: 16px;
            margin-bottom: 24px;
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #174a7e;
            color: white;
        }

        tbody tr:nth-child(even) {
            background: #eef3f8;
        }
    </style>
</head>

<body>

    <h1>Praktikum Fungsi PHP</h1>

    <section class="hasil">
        <h2>1. Rata-rata dan Nilai Tertinggi</h2>

        <p>Rata-rata nilai:
            <strong><?= e(number_format($rataRata, 2, ',', '.')) ?></strong>
        </p>

        <?php if ($tertinggi !== null): ?>
            <p>Peserta dengan nilai tertinggi:
                <strong><?= e($tertinggi['nama']) ?></strong>
                dengan nilai <?= e($tertinggi['nilai']) ?>.
            </p>
        <?php else: ?>
            <p>Belum ada data peserta.</p>
        <?php endif; ?>
    </section>

    <section class="hasil">
        <h2>2. Daftar Semua Peserta</h2>
        <?php tampilkanTabel($peserta); ?>
    </section>

    <section class="hasil">
        <h2>3. Peserta Lulus (Nilai minimal 70)</h2>
        <?php tampilkanTabel($pesertaLulus); ?>
    </section>

    <section class="hasil">
        <h2>4. Peserta Berdasarkan Nilai Tertinggi</h2>
        <?php tampilkanTabel($pesertaUrut); ?>
    </section>

    <section class="hasil">
        <h2>5. Pengelompokan Per Kelas</h2>

        <?php foreach ($kelompok as $namaKelas => $daftarKelas): ?>
            <h3>Kelas <?= e($namaKelas) ?></h3>
            <?php tampilkanTabel($daftarKelas); ?>
        <?php endforeach; ?>
    </section>

</body>

</html>