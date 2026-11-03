<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';

cekLoginAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Metode tidak diizinkan.');
}

cekCsrf();

$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);

if ($id !== false && $id !== null) {
    $pdo = getConnection();
    $pendaftar = ambilPendaftarById($pdo, $id);
    $berhasil = hapusPendaftar($pdo, $id);
    if ($pendaftar !== null && $berhasil) {
        catatAktivitasAdmin('Menghapus pendaftar: ' . $pendaftar['nama']);
    }
    setFlash('Data berhasil dihapus.');
}

redirect('index.php');
