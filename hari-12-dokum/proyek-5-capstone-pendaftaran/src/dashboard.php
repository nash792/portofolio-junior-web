<?php

declare(strict_types=1);

function ambilPendaftarTerbaru(PDO $pdo): SplQueue
{
    $sql = 'SELECT p.id, p.nama, p.tgl_daftar, k.nama_kelas
        FROM pendaftar p
        JOIN kelas k ON k.id = p.kelas_id
        ORDER BY p.tgl_daftar DESC, p.id DESC
        LIMIT 5';
    $antrean = new SplQueue();

    foreach ($pdo->query($sql)->fetchAll() as $pendaftar) {
        $antrean->enqueue($pendaftar);
    }

    return $antrean;
}

function ambilPeringkatKelas(PDO $pdo): array
{
    $sql = 'SELECT k.id, k.nama_kelas, COUNT(p.id) AS jumlah_pendaftar
        FROM kelas k
        LEFT JOIN pendaftar p ON p.kelas_id = k.id
        GROUP BY k.id, k.nama_kelas';
    $kelas = [];

    foreach ($pdo->query($sql)->fetchAll() as $baris) {
        $kelas[(int) $baris['id']] = [
            'nama_kelas' => (string) $baris['nama_kelas'],
            'jumlah_pendaftar' => (int) $baris['jumlah_pendaftar'],
        ];
    }

    usort($kelas, static function (array $a, array $b): int {
        return ($b['jumlah_pendaftar'] <=> $a['jumlah_pendaftar'])
            ?: strcmp($a['nama_kelas'], $b['nama_kelas']);
    });

    return $kelas;
}

function ambilRiwayatAktivitasAdmin(): SplStack
{
    $riwayat = $_SESSION['aktivitas_admin'] ?? [];
    if (!is_array($riwayat)) {
        $riwayat = [];
    }

    $tumpukan = new SplStack();
    foreach (array_reverse(array_slice($riwayat, 0, 10)) as $aktivitas) {
        if (is_array($aktivitas)
            && isset($aktivitas['aksi'], $aktivitas['waktu'])
            && is_string($aktivitas['aksi'])
            && is_string($aktivitas['waktu'])
        ) {
            $tumpukan->push($aktivitas);
        }
    }

    return $tumpukan;
}

function catatAktivitasAdmin(string $aksi): void
{
    $riwayat = ambilRiwayatAktivitasAdmin();
    $riwayat->push([
        'aksi' => $aksi,
        'waktu' => date(DATE_ATOM),
    ]);

    $_SESSION['aktivitas_admin'] = array_slice(iterator_to_array($riwayat, false), 0, 10);
}
