<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';
wajibLogin();

$pdo = getConnection();
$editId = $editId ?? null;
$nilaiForm = $nilaiForm ?? ['nama_kelas' => '', 'kuota' => '30'];
$galat = $galat ?? [];

if (isset($_GET['edit']) && $editId === null) {
    $idEdit = filter_var(
        $_GET['edit'],
        FILTER_VALIDATE_INT,
        ['options' => ['min_range' => 1]]
    );
    if ($idEdit === false || $idEdit === null) {
        http_response_code(400);
        exit('ID kelas tidak valid.');
    }

    $stmt = $pdo->prepare('SELECT id, nama_kelas, kuota FROM kelas WHERE id = :id');
    $stmt->execute(['id' => $idEdit]);
    $kelasEdit = $stmt->fetch();
    if ($kelasEdit === false) {
        http_response_code(404);
        exit('Kelas tidak ditemukan.');
    }

    $editId = (int) $kelasEdit['id'];
    $nilaiForm = [
        'nama_kelas' => (string) $kelasEdit['nama_kelas'],
        'kuota' => (string) $kelasEdit['kuota'],
    ];
}

$kelas = $pdo->query(
    'SELECT k.id, k.nama_kelas, k.kuota, COUNT(p.id) AS jumlah_pendaftar
    FROM kelas k
    LEFT JOIN pendaftar p ON p.kelas_id = k.id
    GROUP BY k.id, k.nama_kelas, k.kuota
    ORDER BY k.nama_kelas'
)->fetchAll();
$judul = 'Kelola Kelas';

require __DIR__ . '/../templates/header.php';
?>
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <div>
        <h1 class="h2 mb-1">Kelola Kelas</h1>
        <p class="text-muted mb-0">Tambah, ubah, dan kelola kelas yang tersedia untuk pendaftaran.</p>
    </div>
    <a class="btn btn-outline-primary" href="admin.php">Kembali ke dashboard</a>
</div>

<div class="row g-4">
    <section class="col-lg-5" aria-labelledby="form-kelas">
        <div class="card">
            <div class="card-body">
                <h2 class="h5" id="form-kelas"><?= $editId === null ? 'Tambah Kelas' : 'Edit Kelas' ?></h2>
                <?php require __DIR__ . '/_form_kelas.php'; ?>
            </div>
        </div>
    </section>

    <section class="col-lg-7" aria-labelledby="daftar-kelas">
        <div class="card">
            <div class="card-body">
                <h2 class="h5" id="daftar-kelas">Kelas Tersedia</h2>
                <?php if ($kelas === []): ?>
                    <p class="text-muted mb-0">Belum ada kelas.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-striped align-middle mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Nama kelas</th>
                                    <th scope="col">Kuota</th>
                                    <th scope="col">Pendaftar</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($kelas as $item): ?>
                                    <tr>
                                        <td><?= e($item['nama_kelas']) ?></td>
                                        <td><?= (int) $item['kuota'] ?></td>
                                        <td><?= (int) $item['jumlah_pendaftar'] ?></td>
                                        <td class="text-nowrap">
                                            <a
                                                class="btn btn-sm btn-outline-primary"
                                                href="kelas.php?edit=<?= (int) $item['id'] ?>">Edit</a>
                                            <form
                                                method="post"
                                                action="hapus_kelas.php"
                                                class="form-hapus d-inline"
                                                data-nama="<?= e($item['nama_kelas']) ?>"
                                                data-konfirmasi="Hapus kelas?">
                                                <input
                                                    type="hidden"
                                                    name="csrf"
                                                    value="<?= e(tokenCsrf()) ?>">
                                                <input
                                                    type="hidden"
                                                    name="id"
                                                    value="<?= (int) $item['id'] ?>">
                                                <button
                                                    class="btn btn-sm btn-outline-danger"
                                                    type="submit"
                                                    <?= (int) $item['jumlah_pendaftar'] > 0
                                                        ? 'disabled title="Kelas masih memiliki pendaftar"'
                                                        : '' ?>>
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>
<?php require __DIR__ . '/../templates/footer.php'; ?>
