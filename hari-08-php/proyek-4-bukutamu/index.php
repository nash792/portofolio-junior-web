<?php
declare(strict_types=1);

require_once __DIR__ . '/functions.php';

$galat = [];
$lama = ['nama' => '', 'email' => '', 'pesan' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hasil = validasiTamu($_POST);
    $lama = $hasil['data'];
    $galat = $hasil['galat'];

    if ($galat === []) {
        if (simpanTamu($hasil['data'])) {
            header('Location: index.php?status=sukses');
            exit;
        }

        $galat['umum'] = 'Gagal menyimpan data. Periksa izin folder data, lalu coba lagi.';
    }
}

$kata = trim((string) ($_GET['q'] ?? ''));
$daftarTamu = array_reverse(cariTamu(ambilSemuaTamu(), $kata));
$statusSukses = ($_GET['status'] ?? '') === 'sukses';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buku Tamu Sekolah</title>
    <style>
        :root {
            color-scheme: light;
            --utama: #174a7e;
            --latar: #f3f6fa;
            --teks: #17212f;
            --muted: #617084;
            --garis: #dce3ec;
            --bahaya: #a32323;
            --sukses: #17633a;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            background: var(--latar);
            color: var(--teks);
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            line-height: 1.6;
        }
        header { background: var(--utama); color: #fff; padding: 28px 18px; }
        .bungkus { width: min(900px, calc(100% - 32px)); margin: 0 auto; }
        header h1 { margin: 0; font-size: clamp(1.7rem, 4vw, 2.3rem); }
        header p { margin: 5px 0 0; opacity: .9; }
        main { padding: 26px 0 48px; }
        .panel {
            background: #fff;
            border: 1px solid var(--garis);
            border-radius: 14px;
            padding: 22px;
            margin-bottom: 22px;
            box-shadow: 0 5px 18px rgb(20 40 70 / 4%);
        }
        h2 { margin: 0 0 14px; font-size: 1.3rem; }
        label { display: block; font-weight: 650; margin-bottom: 6px; }
        input, textarea {
            width: 100%;
            border: 1px solid #b9c5d3;
            border-radius: 8px;
            padding: 11px 12px;
            font: inherit;
            background: #fff;
        }
        input:focus, textarea:focus {
            outline: 3px solid rgb(23 74 126 / 15%);
            border-color: var(--utama);
        }
        .field { margin-bottom: 16px; }
        .hint { color: var(--muted); font-size: .9rem; }
        .error { display: block; color: var(--bahaya); font-size: .92rem; margin-top: 4px; }
        .notice { padding: 12px 14px; border-radius: 8px; margin-bottom: 16px; }
        .notice.success { background: #e8f6ed; color: var(--sukses); }
        .notice.error-box { background: #fff0f0; color: var(--bahaya); }
        button, .button {
            display: inline-block;
            border: 0;
            border-radius: 8px;
            padding: 10px 16px;
            font: inherit;
            font-weight: 650;
            background: var(--utama);
            color: #fff;
            text-decoration: none;
            cursor: pointer;
        }
        button:hover, .button:hover { filter: brightness(1.1); }
        .search { display: flex; gap: 10px; align-items: end; }
        .search .field { flex: 1; margin: 0; }
        .search .reset { background: #e8edf3; color: var(--teks); }
        .entry { border-top: 1px solid var(--garis); padding: 17px 0 5px; }
        .entry:first-of-type { margin-top: 12px; }
        .entry h3 { margin: 0; font-size: 1.08rem; }
        .entry .meta { color: var(--muted); font-size: .88rem; margin: 3px 0 10px; }
        .entry .message { margin: 0; overflow-wrap: anywhere; }
        .empty { color: var(--muted); padding: 12px 0 4px; }
        footer { text-align: center; color: var(--muted); padding: 0 16px 24px; font-size: .9rem; }
        @media (max-width: 560px) {
            .panel { padding: 17px; }
            .search { align-items: stretch; flex-direction: column; }
            .search .field { margin-bottom: 2px; }
        }
    </style>
</head>
<body>
<header>
    <div class="bungkus">
        <h1>Buku Tamu Sekolah</h1>
        <p>Sampaikan salam, kesan, atau pesan Anda.</p>
    </div>
</header>

<main class="bungkus">
    <section class="panel" aria-labelledby="judul-form">
        <h2 id="judul-form">Tulis Pesan</h2>

        <?php if ($statusSukses): ?>
            <p class="notice success" role="status">Terima kasih, pesan Anda berhasil disimpan.</p>
        <?php endif; ?>

        <?php if (isset($galat['umum'])): ?>
            <p class="notice error-box" role="alert"><?= e($galat['umum']) ?></p>
        <?php endif; ?>

        <form method="post" action="index.php" novalidate>
            <div class="field">
                <label for="nama">Nama</label>
                <input id="nama" name="nama" type="text" maxlength="100"
                       value="<?= e($lama['nama']) ?>" autocomplete="name" required>
                <?php if (isset($galat['nama'])): ?>
                    <span class="error" role="alert"><?= e($galat['nama']) ?></span>
                <?php endif; ?>
            </div>

            <div class="field">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" maxlength="254"
                       value="<?= e($lama['email']) ?>" autocomplete="email" required>
                <?php if (isset($galat['email'])): ?>
                    <span class="error" role="alert"><?= e($galat['email']) ?></span>
                <?php endif; ?>
            </div>

            <div class="field">
                <label for="pesan">Pesan</label>
                <textarea id="pesan" name="pesan" rows="4" maxlength="<?= MAKS_PESAN ?>"
                          required><?= e($lama['pesan']) ?></textarea>
                <div class="hint">Maksimal <?= MAKS_PESAN ?> karakter.</div>
                <?php if (isset($galat['pesan'])): ?>
                    <span class="error" role="alert"><?= e($galat['pesan']) ?></span>
                <?php endif; ?>
            </div>

            <button type="submit">Kirim Pesan</button>
        </form>
    </section>

    <section class="panel" aria-labelledby="judul-daftar">
        <h2 id="judul-daftar">Daftar Tamu</h2>
        <form class="search" method="get" action="index.php">
            <div class="field">
                <label for="q">Cari berdasarkan nama</label>
                <input id="q" name="q" type="search" value="<?= e($kata) ?>"
                       placeholder="Contoh: Sari">
            </div>
            <button type="submit">Cari</button>
            <?php if ($kata !== ''): ?>
                <a class="button reset" href="index.php">Reset</a>
            <?php endif; ?>
        </form>

        <?php if ($daftarTamu === []): ?>
            <p class="empty">
                <?= $kata !== '' ? 'Tidak ada tamu yang cocok dengan pencarian.' : 'Belum ada pesan. Jadilah yang pertama mengisi buku tamu!' ?>
            </p>
        <?php else: ?>
            <p class="hint"><?= count($daftarTamu) ?> pesan ditemukan.</p>
            <?php foreach ($daftarTamu as $tamu): ?>
                <article class="entry">
                    <h3><?= e((string) ($tamu['nama'] ?? 'Tamu')) ?></h3>
                    <p class="meta">
                        <?= e((string) ($tamu['waktu'] ?? 'Waktu tidak tersedia')) ?>
                    </p>
                    <p class="message"><?= nl2br(e((string) ($tamu['pesan'] ?? ''))) ?></p>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
</main>

<footer>
    Proyek 4 — Buku Tamu Berbasis File · PHP dan JSON
</footer>
</body>
</html>
