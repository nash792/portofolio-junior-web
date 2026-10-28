<?php

declare(strict_types=1);

$dataDir = __DIR__ . '/data';

if (!is_dir($dataDir) && !mkdir($dataDir, 0775, true) && !is_dir($dataDir)) {
    exit('Gagal membuat folder data/.');
}

$fileJson = $dataDir . '/peserta.json';

$pesertaAwal = [
    ['nama' => 'Sari', 'kelas' => 'Web', 'nilai' => 90],
    ['nama' => 'Tedy', 'kelas' => 'Web', 'nilai' => 70],
    ['nama' => 'Citra', 'kelas' => 'Data', 'nilai' => 72],
    ['nama' => 'Wildan', 'kelas' => 'Web', 'nilai' => 72],
    ['nama' => 'Budi', 'kelas' => 'Web', 'nilai' => 90],
    ['nama' => 'Cindy', 'kelas' => 'Data', 'nilai' => 86],
];

$pesertaBaru = ['nama' => 'Dewi', 'kelas' => 'Data', 'nilai' => 88];
$pesan = '';
$peserta = [];

if (!file_exists($fileJson)) {
    $jsonAwal = json_encode(
        $pesertaAwal,
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
    );

    if (
        $jsonAwal === false ||
        file_put_contents($fileJson, $jsonAwal . PHP_EOL, LOCK_EX) === false
    ) {
        exit('Gagal membuat file JSON.');
    }
}

if (!is_readable($fileJson)) {
    exit('File JSON tidak dapat dibaca.');
}

$isi = file_get_contents($fileJson);

if ($isi === false) {
    exit('Gagal membaca file JSON.');
}

$decoded = json_decode($isi, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    exit('JSON rusak: ' . htmlspecialchars(
        json_last_error_msg(),
        ENT_QUOTES | ENT_SUBSTITUTE,
        'UTF-8'
    ));
}

if (!is_array($decoded)) {
    exit('Format JSON harus berupa array peserta.');
}

// Validasi struktur data sebelum diproses.
foreach ($decoded as $item) {
    if (
        !is_array($item) ||
        !isset($item['nama'], $item['kelas'], $item['nilai']) ||
        !is_string($item['nama']) ||
        !is_string($item['kelas']) ||
        !is_numeric($item['nilai'])
    ) {
        exit('Struktur data JSON tidak valid.');
    }
}

$peserta = $decoded;

$adaDewi = false;
foreach ($peserta as $item) {
    if ($item['nama'] === $pesertaBaru['nama']) {
        $adaDewi = true;
        break;
    }
}

if (!$adaDewi) {
    $peserta[] = $pesertaBaru;

    $jsonBaru = json_encode(
        $peserta,
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
    );

    if (
        $jsonBaru === false ||
        file_put_contents($fileJson, $jsonBaru . PHP_EOL, LOCK_EX) === false
    ) {
        exit('Gagal menyimpan perubahan JSON.');
    }

    $pesan = 'Peserta Dewi berhasil ditambahkan ke JSON.';
} else {
    $pesan = 'Peserta Dewi sudah tersedia. Tidak ada duplikasi.';
}

function e(string $teks): string
{
    return htmlspecialchars($teks, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Peserta JSON</title>
</head>

<body>
    <h1>Data Peserta JSON</h1>
    <p><?= e($pesan) ?></p>

    <table border="1" cellpadding="8">
        <tr>
            <th>No.</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Nilai</th>
        </tr>
        <?php foreach ($peserta as $i => $item): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= e($item['nama']) ?></td>
                <td><?= e($item['kelas']) ?></td>
                <td><?= e((string) $item['nilai']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>