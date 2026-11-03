<?php
$aksiForm = $editId === null ? 'tambah_kelas.php' : 'ubah_kelas.php';
?>
<form method="post" action="<?= e($aksiForm) ?>">
    <input type="hidden" name="csrf" value="<?= e(tokenCsrf()) ?>">
    <?php if ($editId !== null): ?>
        <input type="hidden" name="id" value="<?= $editId ?>">
    <?php endif; ?>
    <div class="mb-3">
        <label class="form-label" for="nama_kelas">Nama kelas</label>
        <input
            class="form-control <?= isset($galat['nama_kelas']) ? 'is-invalid' : '' ?>"
            id="nama_kelas"
            name="nama_kelas"
            maxlength="100"
            required
            value="<?= e($nilaiForm['nama_kelas']) ?>">
        <?php if (isset($galat['nama_kelas'])): ?>
            <div class="invalid-feedback"><?= e($galat['nama_kelas']) ?></div>
        <?php endif; ?>
    </div>
    <div class="mb-3">
        <label class="form-label" for="kuota">Kuota peserta</label>
        <input
            class="form-control <?= isset($galat['kuota']) ? 'is-invalid' : '' ?>"
            id="kuota"
            name="kuota"
            type="number"
            min="1"
            max="2147483647"
            step="1"
            required
            value="<?= e($nilaiForm['kuota']) ?>">
        <?php if (isset($galat['kuota'])): ?>
            <div class="invalid-feedback"><?= e($galat['kuota']) ?></div>
        <?php endif; ?>
    </div>
    <button class="btn btn-primary" type="submit">
        <?= $editId === null ? 'Simpan Kelas' : 'Simpan Perubahan' ?>
    </button>
    <a class="btn btn-outline-secondary" href="kelas.php">Reset Form</a>
</form>
