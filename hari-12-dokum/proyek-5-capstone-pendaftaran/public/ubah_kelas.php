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

$pdo = getConnection();
$stmt = $pdo->prepare('SELECT id FROM kelas WHERE id = :id');
$stmt->execute(['id' => $id]);
if ($stmt->fetchColumn() === false) {
    http_response_code(404);
    exit('Kelas tidak ditemukan.');
}

$hasil = validasiKelas($pdo, $_POST, $id);
if ($hasil['galat'] !== []) {
    $nilaiForm = $hasil['nilai'];
    $galat = $hasil['galat'];
    $editId = $id;
    require __DIR__ . '/kelas.php';
    exit;
}

ubahKelas($pdo, $id, $hasil['data']['nama_kelas'], $hasil['data']['kuota']);
catatAktivitasAdmin('Mengubah kelas: ' . $hasil['data']['nama_kelas']);
setFlash('Kelas berhasil diperbarui.');
redirect('kelas.php');
