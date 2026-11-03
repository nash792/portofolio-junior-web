<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';

$pdo = getConnection();
$kelas = daftarKelas($pdo);
$lama = ['nama' => '', 'email' => '', 'no_hp' => '', 'alamat' => '', 'kelas_id' => 0];
$galat = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    cekCsrf();
    $hasil = validasiPendaftar($_POST, $pdo, null);
    $lama = $hasil['data'];
    $galat = $hasil['galat'];

    if ($galat === []) {
        try {
//untuk menambahkan pendaftar baru dengan pengecekan kuota
            daftarkanDenganKuota($pdo, $lama);
            setFlash('Pendaftaran berhasil. Simpan bukti Anda.');
            redirect('index.php?status=sukses');
        } catch (KuotaPenuhException $e) {
//jika kuota penuh, maka akan dilempar excepition KuotaPenuhException
            $galat['kelas_id'] = $e->getMessage();
        }
    }
}

$judul = 'Tambah Pendaftar';
require __DIR__ . '/../templates/header.php';
require __DIR__ . '/_form.php';
require __DIR__ . '/../templates/footer.php';
