<?php

declare(strict_types=1);

$dataDir = __DIR__ . '/data';
$fileLog = $dataDir . '/log.txt';

function e(string $teks): string
{
    return htmlspecialchars($teks, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$pesan = '';
$logs = [];

if (!is_dir($dataDir)) {
    if (!mkdir($dataDir, 0775, true) && !is_dir($dataDir)) {
        $pesan = 'Gagal membuat folder data/.';
    }
}

if ($pesan === '') {
    if (!file_exists($fileLog)) {
        $pesan = 'File log belum tersedia. Buka cari.php terlebih dahulu.';
    } elseif (!is_readable($fileLog)) {
        $pesan = 'File log tidak dapat dibaca.';
    } else {
        $baris = file($fileLog, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if ($baris === false) {
            $pesan = 'Gagal membaca file log.';
        } else {
            $logs = array_slice(array_reverse($baris), 0, 20);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Log Pengunjung</title>
</head>

<body>
    <h1>20 Log Pengunjung Terakhir</h1>

    <?php if ($pesan !== ''): ?>
        <p><?= e($pesan) ?></p>
    <?php elseif ($logs === []): ?>
        <p>Belum ada log pengunjung.</p>
    <?php else: ?>
        <ol>
            <?php foreach ($logs as $log): ?>
                <li><?= e($log) ?></li>
            <?php endforeach; ?>
        </ol>
    <?php endif; ?>

    <p><a href="cari.php">Kembali ke pencarian</a></p>
</body>

</html>