<?php
declare(strict_types=1);

const FILE_TAMU = __DIR__ . '/data/tamu.json';
const MAKS_PESAN = 500;

/**
 * Mengamankan teks sebelum ditampilkan ke HTML.
 */
function e(string $teks): string
{
    return htmlspecialchars($teks, ENT_QUOTES, 'UTF-8');
}

/**
 * Merapikan spasi berulang dan spasi di awal/akhir.
 */
function bersihkanSpasi(string $teks): string
{
    return trim((string) preg_replace('/\s+/', ' ', $teks));
}

/**
 * Memvalidasi input buku tamu.
 *
 * @param array<string, mixed> $input Data mentah dari formulir.
 * @return array{data: array<string, string>, galat: array<string, string>}
 */
function validasiTamu(array $input): array
{
    $data = [
        'nama' => bersihkanSpasi((string) ($input['nama'] ?? '')),
        'email' => trim((string) ($input['email'] ?? '')),
        'pesan' => trim((string) ($input['pesan'] ?? '')),
    ];

    $galat = [];

    if (mb_strlen($data['nama']) < 3) {
        $galat['nama'] = 'Nama minimal 3 karakter.';
    }

    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $galat['email'] = 'Format email tidak valid.';
    }

    $panjangPesan = mb_strlen($data['pesan']);
    if ($panjangPesan === 0 || $panjangPesan > MAKS_PESAN) {
        $galat['pesan'] = 'Pesan wajib diisi, maksimal ' . MAKS_PESAN . ' karakter.';
    }

    return ['data' => $data, 'galat' => $galat];
}

/**
 * Membaca seluruh tamu dari berkas JSON.
 *
 * @return array<int, array<string, mixed>>
 */
function ambilSemuaTamu(): array
{
    if (!is_file(FILE_TAMU)) {
        return [];
    }

    $isi = file_get_contents(FILE_TAMU);
    if ($isi === false || trim($isi) === '') {
        return [];
    }

    $daftar = json_decode($isi, true);
    if (json_last_error() !== JSON_ERROR_NONE || !is_array($daftar)) {
        error_log('Berkas tamu.json tidak valid: ' . json_last_error_msg());
        return [];
    }

    return array_values(array_filter($daftar, 'is_array'));
}

/**
 * Menyimpan data tamu baru ke berkas JSON.
 *
 * @param array<string, string> $data Data tamu yang telah divalidasi.
 */
function simpanTamu(array $data): bool
{
    $folder = dirname(FILE_TAMU);
    if (!is_dir($folder) && !mkdir($folder, 0755, true) && !is_dir($folder)) {
        return false;
    }

    $daftar = ambilSemuaTamu();
    $idTerbesar = 0;

    foreach ($daftar as $tamu) {
        $idTerbesar = max($idTerbesar, (int) ($tamu['id'] ?? 0));
    }

    $dataBaru = [
        'id' => $idTerbesar + 1,
        'nama' => $data['nama'],
        'email' => $data['email'],
        'pesan' => $data['pesan'],
        'waktu' => date('Y-m-d H:i:s'),
    ];
    $daftar[] = $dataBaru;

    $json = json_encode(
        $daftar,
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE
    );

    return $json !== false
        && file_put_contents(FILE_TAMU, $json, LOCK_EX) !== false;
}

/**
 * Mencari tamu berdasarkan sebagian nama, tanpa membedakan kapitalisasi.
 *
 * @param array<int, array<string, mixed>> $daftar Daftar tamu.
 * @return array<int, array<string, mixed>>
 */
function cariTamu(array $daftar, string $kata): array
{
    if ($kata === '') {
        return $daftar;
    }

    return array_values(array_filter(
        $daftar,
        static fn (array $tamu): bool => stripos((string) ($tamu['nama'] ?? ''), $kata) !== false
    ));
}
