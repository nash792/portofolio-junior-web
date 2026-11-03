<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';
wajibLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Metode tidak diizinkan.');
}

cekCsrf();
$hasil = validasiKelas(getConnection(), $_POST);

if ($hasil['galat'] !== []) {
    $nilaiForm = $hasil['nilai'];
    $galat = $hasil['galat'];
    $editId = null;
    require __DIR__ . '/kelas.php';
    exit;
}

tambahKelas(getConnection(), $hasil['data']['nama_kelas'], $hasil['data']['kuota']);
catatAktivitasAdmin('Menambahkan kelas: ' . $hasil['data']['nama_kelas']);
setFlash('Kelas berhasil ditambahkan.');
redirect('kelas.php');
