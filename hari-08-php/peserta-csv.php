<?php

declare(strict_types=1);

$dataDir = __DIR__ . '/data';

if (!is_dir($dataDir) && !mkdir($dataDir, 0775, true) && !is_dir($dataDir)) {
    exit('Gagal membuat folder data/.');
}

$fileCsv = $dataDir . '/peserta.csv';

$peserta = [
    ['nama' => 'Sari', 'kelas' => 'Web', 'nilai' => 90],
    ['nama' => 'Tedy', 'kelas' => 'Web', 'nilai' => 70],
    ['nama' => 'Citra', 'kelas' => 'Data', 'nilai' => 72],
    ['nama' => 'Wildan', 'kelas' => 'Web', 'nilai' => 72],
    ['nama' => 'Budi', 'kelas' => 'Web', 'nilai' => 90],
    ['nama' => 'Cindy', 'kelas' => 'Data', 'nilai' => 86],
];

function e(string $teks): string
{
    return htmlspecialchars($teks, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$pesan = '';
$dataCsv = [];

// EKSPOR: tulis data peserta ke CSV
$handle = fopen($fileCsv, 'w');

if ($handle === false) {
    exit('Gagal membuka file CSV untuk ditulis.');
}

$berhasil = true;

// Header CSV
if (fputcsv($handle, ['nama', 'kelas', 'nilai'], ',', '"', '') === false) {
    $berhasil = false;
}

foreach ($peserta as $item) {
    if (fputcsv(
        $handle,
        [$item['nama'], $item['kelas'], $item['nilai']],
        ',',
        '"',
        ''
    ) === false) {
        $berhasil = false;
        break;
    }
}

if (!fclose($handle)) {
    $berhasil = false;
}

if (!$berhasil) {
    exit('Gagal menulis data CSV.');
}

// IMPOR: baca kembali CSV
$handle = fopen($fileCsv, 'r');

if ($handle === false) {
    exit('Gagal membuka file CSV untuk dibaca.');
}

$header = fgetcsv($handle, 0, ',', '"', '');

if ($header === false || $header !== ['nama', 'kelas', 'nilai']) {
    fclose($handle);
    exit('Header CSV tidak valid atau file kosong.');
}

while (($baris = fgetcsv($handle, 0, ',', '"', '')) !== false) {
    if (count($baris) !== 3) {
        continue;
    }

    if (!is_numeric($baris[2])) {
        continue;
    }

    $dataCsv[] = [
        'nama' => $baris[0],
        'kelas' => $baris[1],
        'nilai' => $baris[2],
    ];
}

fclose($handle);
$pesan = 'Ekspor dan impor CSV berhasil.';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Ekspor dan Impor CSV</title>
</head>

<body>
    <h1>Ekspor dan Impor CSV</h1>

    <p><?= e($pesan) ?></p>
    <p>File tersimpan di: data/peserta.csv</p>

    <h2>Data Hasil Impor</h2>

    <?php if ($dataCsv === []): ?>
        <p>Tidak ada data peserta di dalam CSV.</p>
    <?php else: ?>
        <table border="1" cellpadding="8">
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Nilai</th>
            </tr>

            <?php foreach ($dataCsv as $i => $item): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= e($item['nama']) ?></td>
                    <td><?= e($item['kelas']) ?></td>
                    <td><?= e((string) $item['nilai']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <p>
        <a href="data/peserta.csv" download>Unduh file CSV</a>
    </p>
</body>

</html>