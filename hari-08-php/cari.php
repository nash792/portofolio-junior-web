<?php

declare(strict_types=1);

$dataDir = __DIR__ . '/data';

if (!is_dir($dataDir) && !mkdir($dataDir, 0775, true) && !is_dir($dataDir)) {
    exit('Gagal membuat folder data/. Periksa izin folder.');
}

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

$q = $_GET['q'] ?? '';
$q = is_string($q) ? trim($q) : '';

// Hindari baris baru dalam log akibat input pengguna.
$kataKunciLog = str_replace(["\r", "\n", '|'], ' ', $q);
$ip = str_replace(["\r", "\n", '|'], ' ', $_SERVER['REMOTE_ADDR'] ?? 'Tidak diketahui');

$barisLog = date('Y-m-d H:i:s') . ' | ' . $ip . ' | ' . $kataKunciLog . PHP_EOL;
$logBerhasil = file_put_contents(
    $dataDir . '/log.txt',
    $barisLog,
    FILE_APPEND | LOCK_EX
) !== false;

$hasil = [];

if ($q !== '') {
    foreach ($peserta as $item) {
        if (stripos($item['nama'], $q) !== false) {
            $hasil[] = $item;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pencarian Peserta</title>
</head>

<body>
    <h1>Pencarian Peserta</h1>

    <form method="get" action="cari.php">
        <label for="q">Nama peserta:</label>
        <input id="q" name="q" value="<?= e($q) ?>">
        <button type="submit">Cari</button>
    </form>

    <?php if (!$logBerhasil): ?>
        <p>Gagal menyimpan log. Periksa izin folder data/.</p>
    <?php endif; ?>

    <?php if ($q === ''): ?>
        <p>Masukkan kata kunci nama untuk mencari peserta.</p>
    <?php elseif ($hasil === []): ?>
        <p>Tidak ada peserta yang cocok dengan kata kunci "<?= e($q) ?>".</p>
    <?php else: ?>
        <h2>Hasil pencarian</h2>
        <table border="1" cellpadding="8">
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Nilai</th>
            </tr>
            <?php foreach ($hasil as $i => $item): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= e($item['nama']) ?></td>
                    <td><?= e($item['kelas']) ?></td>
                    <td><?= e((string) $item['nilai']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <p><a href="lihat-log.php">Lihat log pengunjung</a></p>
</body>

</html>