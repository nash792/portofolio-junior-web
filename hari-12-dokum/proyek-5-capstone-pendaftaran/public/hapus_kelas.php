<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';
wajibLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Metode tidak diizinkan.');
}

cekCsrf();
$id = filter_var(
    $_POST['id'] ?? null,
    FILTER_VALIDATE_INT,
    ['options' => ['min_range' => 1]]
);
if ($id === false || $id === null) {
    http_response_code(400);
    exit('ID kelas tidak valid.');
}

if (hapusKelas(getConnection(), $id)) {
    catatAktivitasAdmin('Menghapus kelas ID ' . $id);
    setFlash('Kelas berhasil dihapus.');
} else {
    setFlash('Kelas tidak dapat dihapus karena sudah memiliki pendaftar atau tidak ditemukan.');
}

redirect('kelas.php');
