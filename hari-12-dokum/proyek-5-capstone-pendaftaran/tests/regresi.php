<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/pendaftar.php';
require_once __DIR__ . '/../src/dashboard.php';

$pdo = new PDO('sqlite::memory:');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$pdo->exec(
    'CREATE TABLE kelas (id INTEGER PRIMARY KEY, nama_kelas TEXT NOT NULL, kuota INTEGER NOT NULL);
     CREATE TABLE pendaftar (
        id INTEGER PRIMARY KEY,
        nama TEXT NOT NULL,
        email TEXT NOT NULL UNIQUE,
        no_hp TEXT NOT NULL,
        alamat TEXT,
        kelas_id INTEGER NOT NULL,
        tgl_daftar TEXT DEFAULT CURRENT_TIMESTAMP
     );
     INSERT INTO kelas (id, nama_kelas, kuota) VALUES (1, "Web", 30), (2, "Desain", 1);
     INSERT INTO pendaftar (nama, email, no_hp, alamat, kelas_id)
        VALUES ("Sari Wijaya", "sari@example.test", "0812345678", "", 1),
               ("Andi Pratama", "andi@example.test", "0812345678", "", 1),
               ("Budi Santoso", "budi@example.test", "0812345678", "", 1),
               ("Dewi Lestari", "dewi@example.test", "0812345678", "", 1),
               ("Fajar Nugraha", "fajar@example.test", "0812345678", "", 1),
               ("Gita Permata", "gita@example.test", "0812345678", "", 1);'
);

$hasil = [];
$uji = static function (string $nama, bool $lolos) use (&$hasil): void {
    $hasil[] = [$nama, $lolos];
};
$inputValid = [
    'nama' => 'Citra Ayu',
    'email' => 'citra@example.test',
    'no_hp' => '0812345678',
    'alamat' => '',
    'kelas_id' => '1',
];

$uji('Pendaftaran valid diterima', validasiPendaftar($inputValid, $pdo, null)['galat'] === []);
$uji(
    'Email duplikat ditolak',
    isset(validasiPendaftar(
        array_replace($inputValid, ['email' => 'sari@example.test']),
        $pdo,
        null
    )['galat']['email'])
);
$uji(
    'Nama kosong ditolak',
    isset(validasiPendaftar(array_replace($inputValid, ['nama' => '']), $pdo, null)['galat']['nama'])
);
$uji(
    'Nama di bawah batas ditolak',
    isset(validasiPendaftar(array_replace($inputValid, ['nama' => 'Ab']), $pdo, null)['galat']['nama'])
);
$uji(
    'Nama lebih dari 100 karakter ditolak',
    isset(validasiPendaftar(
        array_replace($inputValid, ['nama' => str_repeat('A', 101)]),
        $pdo,
        null
    )['galat']['nama'])
);
$uji(
    'Email tidak valid ditolak',
    isset(validasiPendaftar(
        array_replace($inputValid, ['email' => 'bukan-email']),
        $pdo,
        null
    )['galat']['email'])
);
$uji(
    'Email lebih dari 120 karakter ditolak',
    isset(validasiPendaftar(
        array_replace($inputValid, ['email' => str_repeat('a', 111) . '@test.test']),
        $pdo,
        null
    )['galat']['email'])
);
$uji('Nomor HP 9 digit ditolak', !preg_match('/^08[0-9]{8,11}$/', '081234567'));
$uji('Nomor HP 10 digit diterima', preg_match('/^08[0-9]{8,11}$/', '0812345678') === 1);
$uji('Nomor HP 13 digit diterima', preg_match('/^08[0-9]{8,11}$/', '0812345678901') === 1);
$uji('Nomor HP 14 digit ditolak', !preg_match('/^08[0-9]{8,11}$/', '08123456789012'));
$uji('Nomor HP dengan huruf ditolak', !preg_match('/^08[0-9]{8,11}$/', '0812345abc'));
$uji(
    'Kelas tidak tersedia ditolak',
    isset(validasiPendaftar(
        array_replace($inputValid, ['kelas_id' => '999']),
        $pdo,
        null
    )['galat']['kelas_id'])
);
$uji('Pencarian nama membatasi jumlah hasil', hitungPendaftar($pdo, 'Sari') === 1);
$uji(
    'Pencarian aman dari injeksi SQL',
    hitungPendaftar($pdo, "' OR 1=1 --") === 0
);
$uji(
    'Paginasi mengambil tepat satu baris',
    count(ambilPendaftar($pdo, '', 1, 1)) === 1
);
$uji(
    'Nama kelas duplikat ditolak',
    isset(validasiKelas($pdo, ['nama_kelas' => 'web', 'kuota' => '30'])['galat']['nama_kelas'])
);
$uji(
    'Kuota kelas tidak boleh di bawah jumlah pendaftar',
    isset(validasiKelas($pdo, ['nama_kelas' => 'Web', 'kuota' => '5'], 1)['galat']['kuota'])
);
$uji(
    'Kelas dapat diperbarui tanpa mengubah nama',
    validasiKelas($pdo, ['nama_kelas' => 'Web', 'kuota' => '30'], 1)['galat'] === []
);
$uji('Admin dapat menambahkan kelas dengan kuota', tambahKelas($pdo, 'PHP Dasar', 20));
$uji(
    'Kelas baru tersedia untuk form pendaftaran',
    in_array('PHP Dasar', array_column(daftarKelas($pdo), 'nama_kelas'), true)
);
$uji('Admin dapat mengubah nama dan kuota kelas', ubahKelas($pdo, 3, 'PHP Lanjutan', 25));
$uji(
    'Perubahan kelas tersimpan',
    $pdo->query('SELECT nama_kelas FROM kelas WHERE id = 3')->fetchColumn() === 'PHP Lanjutan'
);
$uji('Kelas yang sudah memiliki pendaftar tidak dapat dihapus', !hapusKelas($pdo, 1));
$uji('Admin dapat menghapus kelas tanpa pendaftar', hapusKelas($pdo, 3));
$uji(
    'Kelas yang dihapus tidak lagi tersedia',
    !in_array('PHP Lanjutan', array_column(daftarKelas($pdo), 'nama_kelas'), true)
);
$pendaftarTerbaru = ambilPendaftarTerbaru($pdo);
$uji('Antrean dashboard membatasi lima pendaftar terbaru', $pendaftarTerbaru->count() === 5);
$uji('Antrean dashboard mengurutkan pendaftar terbaru lebih dulu', $pendaftarTerbaru->dequeue()['nama'] === 'Gita Permata');
$peringkatKelas = ambilPeringkatKelas($pdo);
$uji(
    'Peringkat kelas mengurutkan jumlah terbanyak lebih dulu',
    $peringkatKelas[0]['nama_kelas'] === 'Web'
        && $peringkatKelas[0]['jumlah_pendaftar'] === 6
        && $peringkatKelas[1]['jumlah_pendaftar'] === 0
);
$_SESSION = [];
for ($i = 1; $i <= 12; $i++) {
    catatAktivitasAdmin('Aktivitas ' . $i);
}
$riwayatAktivitas = ambilRiwayatAktivitasAdmin();
$aktivitasTerbaru = iterator_to_array($riwayatAktivitas, false);
$uji('Riwayat admin membatasi sepuluh aktivitas', count($aktivitasTerbaru) === 10);
$uji(
    'Riwayat admin memakai urutan stack terbaru ke terlama',
    $aktivitasTerbaru[0]['aksi'] === 'Aktivitas 12'
        && $aktivitasTerbaru[9]['aksi'] === 'Aktivitas 3'
);
$uji(
    'Output nama berbahaya di-escape saat dirender',
    htmlspecialchars('<script>alert(1)</script>', ENT_QUOTES, 'UTF-8')
        === '&lt;script&gt;alert(1)&lt;/script&gt;'
);

$gagal = 0;
foreach ($hasil as [$nama, $lolos]) {
    echo ($lolos ? '[LOLOS] ' : '[GAGAL] ') . $nama . PHP_EOL;
    $gagal += $lolos ? 0 : 1;
}

echo PHP_EOL . ($gagal === 0 ? 'Semua uji regresi lolos.' : "$gagal uji gagal.") . PHP_EOL;
exit($gagal === 0 ? 0 : 1);
