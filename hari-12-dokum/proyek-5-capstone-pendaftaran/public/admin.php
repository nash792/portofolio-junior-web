<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';
wajibLogin();
$pdo = getConnection();
$kata = trim((string) ($_GET['q'] ?? ''));
$perHalaman = 10;
$total = hitungPendaftar($pdo, $kata);
$totalSemuaPendaftar = hitungPendaftar($pdo, '');
$pendaftarTerbaru = ambilPendaftarTerbaru($pdo);
$riwayatAktivitas = ambilRiwayatAktivitasAdmin();
$peringkatKelas = ambilPeringkatKelas($pdo);
$jumlahHalaman = max(1, (int) ceil($total / $perHalaman));
$halamanInput = $_GET['hal'] ?? 1;
$halamanValid = filter_var(
    is_scalar($halamanInput) ? $halamanInput : 1,
    FILTER_VALIDATE_INT,
    ['options' => ['min_range' => 1]]
);
$halaman = min($jumlahHalaman, $halamanValid === false ? 1 : $halamanValid);
$daftar = ambilPendaftar($pdo, $kata, $perHalaman, ($halaman - 1) * $perHalaman);
$judul = 'Dashboard Admin';

require __DIR__ . '/../templates/header.php';
?>
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <div>
        <h1 class="h2 mb-1">Dashboard Admin</h1>
        <p class="text-muted mb-0">Ringkasan pendaftaran dan aktivitas terbaru.</p>
    </div>
    <a class="btn btn-primary" href="kelas.php">Kelola Kelas</a>
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-6">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h6 text-muted">Total pendaftar</h2>
                <p class="display-6 mb-0"><?= $totalSemuaPendaftar ?></p>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h6 text-muted">Kelas tersedia</h2>
                <p class="display-6 mb-0"><?= count($peringkatKelas) ?></p>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <section class="col-lg-6" aria-labelledby="pendaftar-terbaru">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5" id="pendaftar-terbaru">5 Pendaftar Terakhir</h2>
                <?php if ($pendaftarTerbaru->isEmpty()): ?>
                    <p class="text-muted mb-0">Belum ada pendaftar.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Waktu daftar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pendaftarTerbaru as $pendaftar): ?>
                                    <tr>
                                        <td><?= e($pendaftar['nama']) ?></td>
                                        <td><?= e($pendaftar['nama_kelas']) ?></td>
                                        <td><?= e(date('d/m/Y H:i', strtotime($pendaftar['tgl_daftar']))) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="col-lg-6" aria-labelledby="aktivitas-admin">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5" id="aktivitas-admin">10 Aktivitas Admin Terakhir</h2>
                <?php if ($riwayatAktivitas->isEmpty()): ?>
                    <p class="text-muted mb-0">Belum ada aktivitas pada sesi ini.</p>
                <?php else: ?>
                    <ol class="list-group list-group-numbered list-group-flush">
                        <?php foreach ($riwayatAktivitas as $aktivitas): ?>
                            <li class="list-group-item px-0">
                                <span><?= e($aktivitas['aksi']) ?></span>
                                <small class="d-block text-muted">
                                    <?= e(date('d/m/Y H:i', strtotime($aktivitas['waktu']))) ?>
                                </small>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>

<section class="card mb-4" aria-labelledby="peringkat-kelas">
    <div class="card-body">
        <h2 class="h5" id="peringkat-kelas">Peringkat Kelas Berdasarkan Pendaftar</h2>
        <?php if ($peringkatKelas === []): ?>
            <p class="text-muted mb-0">Belum ada kelas.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Peringkat</th>
                            <th scope="col">Kelas</th>
                            <th scope="col">Jumlah pendaftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($peringkatKelas as $indeks => $kelas): ?>
                            <tr>
                                <td><?= $indeks + 1 ?></td>
                                <td><?= e($kelas['nama_kelas']) ?></td>
                                <td><?= $kelas['jumlah_pendaftar'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</section>

<h2 class="h4">Daftar Pendaftar</h2>
<form method="get">
    <label for="q">Cari nama</label>
    <input id="q" name="q" value="<?= e($kata) ?>">
    <button type="submit">Cari</button>
</form>
<?php if ($daftar === []): ?>
    <p>Tidak ada data.</p>
<?php else: ?>
    <div class='table-responsive'>
        <table class='table table-striped align-middle'>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No. HP</th>
                    <th>Kelas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($daftar as $p): ?>
                    <tr>
                        <td><?= e($p['nama']) ?></td>
                        <td><?= e($p['email']) ?></td>
                        <td><?= e($p['no_hp']) ?></td>
                        <td><?= e($p['nama_kelas']) ?></td>
                        <td>
                            <a class='btn btn-sm btn-outline-secondary' href='ubah.php?id=<?= (int)
                                                                                            $p['id'] ?>'>Ubah</a>
                            <a class='btn btn-sm btn-outline-primary' href='cetak.php?id=<?= (int)
                                                                                            $p['id'] ?>' target='_blank' rel='noopener'>Cetak</a>
                            <form method='post' action='hapus.php' class='form-hapus d-inline'
                                data-nama='<?= e($p['nama']) ?>'>
                                <input type='hidden' name='csrf' value='<?= e(tokenCsrf()) ?>'>
                                <input type='hidden' name='id' value='<?= (int) $p['id'] ?>'>
                                <button class='btn btn-sm btn-outline-danger'
                                    type='submit'>Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
<nav aria-label="Navigasi halaman pendaftar">
    <ul class="pagination">
        <li class="page-item <?= $halaman === 1 ? 'disabled' : '' ?>">
            <?php if ($halaman > 1): ?>
                <a class="page-link" href="?hal=<?= $halaman - 1 ?>&amp;q=<?= urlencode($kata) ?>">Sebelumnya</a>
            <?php else: ?>
                <span class="page-link">Sebelumnya</span>
            <?php endif; ?>
        </li>
        <?php for ($i = 1; $i <= $jumlahHalaman; $i++): ?>
            <li class="page-item <?= $i === $halaman ? 'active' : '' ?>">
                <a class="page-link" href="?hal=<?= $i ?>&amp;q=<?= urlencode($kata) ?>"
                    <?= $i === $halaman ? 'aria-current="page"' : '' ?>><?= $i ?></a>
            </li>
        <?php endfor; ?>
        <li class="page-item <?= $halaman === $jumlahHalaman ? 'disabled' : '' ?>">
            <?php if ($halaman < $jumlahHalaman): ?>
                <a class="page-link" href="?hal=<?= $halaman + 1 ?>&amp;q=<?= urlencode($kata) ?>">Selanjutnya</a>
            <?php else: ?>
                <span class="page-link">Selanjutnya</span>
            <?php endif; ?>
        </li>
    </ul>
</nav>
<?php require __DIR__ . '/../templates/footer.php'; ?>