<?php /* public/_form.php - dipakai bersama oleh tambah.php dan ubah.php */ ?>
<?php
$kelas = $kelas ?? [];
$lama = $lama ?? [];
$galat = $galat ?? [];
$lama += ['nama' => '', 'email' => '', 'no_hp' => '', 'kelas_id' => 0, 'alamat' => ''];
?>

<style>
    .form-label {
        font-weight: bold;
    }

    .form-control,
    .form-select {
        border-radius: 8px;
    }

    .form-card {
        background: #f0f4ff;
        padding: 20px;
        border-radius: 12px;
    }
</style>

<div class="form-card">
    <h4 class="text-primary text-center mb-3">📝 Form Pendaftaran Kelas</h4>

    <form method="post">
        <input type="hidden" name="csrf" value="<?= e(tokenCsrf()) ?>">

        <div class='mb-3'>
            <label for='nama' class='form-label'>👤 Nama</label>
            <input id='nama' name='nama' class='form-control <?= isset($galat['nama']) ? 'is-invalid' : '' ?>'
                value='<?= e($lama['nama']) ?>'>
            <?php if (isset($galat['nama'])): ?>
                <div class='invalid-feedback'><?= e($galat['nama']) ?></div>
            <?php endif; ?>
        </div>

        <div class='mb-3'>
            <label for='email' class='form-label'>📧 Email</label>
            <input id='email' name='email' class='form-control <?= isset($galat['email']) ? 'is-invalid' : '' ?>'
                value='<?= e($lama['email']) ?>'>
            <?php if (isset($galat['email'])): ?>
                <div class='invalid-feedback'><?= e($galat['email']) ?></div>
            <?php endif; ?>
        </div>

        <div class='mb-3'>
            <label for='no_hp' class='form-label'>📱 Nomor Handphone</label>
            <input id='no_hp' name='no_hp' class='form-control <?= isset($galat['no_hp']) ? 'is-invalid' : '' ?>'
                value='<?= e($lama['no_hp']) ?>'>
            <?php if (isset($galat['no_hp'])): ?>
                <div class='invalid-feedback'><?= e($galat['no_hp']) ?></div>
            <?php endif; ?>
        </div>

        <div class='mb-3'>
            <label for='kelas_id' class='form-label'>📚 Kelas</label>
            <select id='kelas_id' name='kelas_id' class='form-select <?= isset($galat['kelas_id']) ? 'is-invalid' : '' ?>'>
                <option value=''>-- Pilih Kelas --</option>
                <?php foreach ($kelas as $item): ?>
                    <option value='<?= (int) $item['id'] ?>'
                        <?= (int) $lama['kelas_id'] === (int) $item['id'] ? 'selected' : '' ?>>
                        <?= e($item['nama_kelas']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($galat['kelas_id'])): ?>
                <div class='invalid-feedback'><?= e($galat['kelas_id']) ?></div>
            <?php endif; ?>
        </div>

        <div class='mb-3'>
            <label for='alamat' class='form-label'>🏠 Alamat</label>
            <input id='alamat' name='alamat' class='form-control <?= isset($galat['alamat']) ? 'is-invalid' : '' ?>'
                value='<?= e($lama['alamat']) ?>'>
            <?php if (isset($galat['alamat'])): ?>
                <div class='invalid-feedback'><?= e($galat['alamat']) ?></div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">💾 Simpan</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>