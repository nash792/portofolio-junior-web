<?php

declare(strict_types=1);
/**
 * Mengambil daftar kelas dari database.
 * @param PDO $pdo Koneksi database aktif.
 * @return array Array of kelas.
 */
function daftarKelas(PDO $pdo): array
{
    return $pdo->query('SELECT id, nama_kelas FROM kelas ORDER BY nama_kelas')->fetchAll();
}

function tambahKelas(PDO $pdo, string $namaKelas, int $kuota): bool
{
    $stmt = $pdo->prepare(
        'INSERT INTO kelas (nama_kelas, kuota) VALUES (:nama_kelas, :kuota)'
    );

    return $stmt->execute(['nama_kelas' => $namaKelas, 'kuota' => $kuota]);
}

function validasiKelas(PDO $pdo, array $input, ?int $id = null): array
{
    $namaInput = $input['nama_kelas'] ?? '';
    $kuotaInput = $input['kuota'] ?? '';
    $data = [
        'nama_kelas' => is_scalar($namaInput) ? trim((string) $namaInput) : '',
        'kuota' => is_scalar($kuotaInput) ? trim((string) $kuotaInput) : '',
    ];
    $galat = [];
    $kuota = filter_var(
        $data['kuota'],
        FILTER_VALIDATE_INT,
        ['options' => ['min_range' => 1, 'max_range' => 2147483647]]
    );

    if ($data['nama_kelas'] === '') {
        $galat['nama_kelas'] = 'Nama kelas wajib diisi.';
    } elseif (mb_strlen($data['nama_kelas']) > 100) {
        $galat['nama_kelas'] = 'Nama kelas maksimal 100 karakter.';
    } else {
        $stmt = $pdo->prepare(
            'SELECT COUNT(*) FROM kelas
            WHERE LOWER(nama_kelas) = LOWER(:nama) AND id <> :id'
        );
        $stmt->execute(['nama' => $data['nama_kelas'], 'id' => $id ?? 0]);
        if ((int) $stmt->fetchColumn() > 0) {
            $galat['nama_kelas'] = 'Nama kelas sudah tersedia.';
        }
    }

    if ($kuota === false) {
        $galat['kuota'] = 'Kuota harus berupa bilangan bulat minimal 1.';
    } elseif ($id !== null) {
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM pendaftar WHERE kelas_id = :id');
        $stmt->execute(['id' => $id]);
        $jumlahPendaftar = (int) $stmt->fetchColumn();
        if ($kuota < $jumlahPendaftar) {
            $galat['kuota'] = 'Kuota tidak boleh kurang dari jumlah pendaftar saat ini ('
                . $jumlahPendaftar . ').';
        }
    }

    return [
        'data' => ['nama_kelas' => $data['nama_kelas'], 'kuota' => $kuota],
        'nilai' => $data,
        'galat' => $galat,
    ];
}

function ubahKelas(PDO $pdo, int $id, string $namaKelas, int $kuota): bool
{
    $stmt = $pdo->prepare(
        'UPDATE kelas SET nama_kelas = :nama_kelas, kuota = :kuota WHERE id = :id'
    );

    return $stmt->execute([
        'nama_kelas' => $namaKelas,
        'kuota' => $kuota,
        'id' => $id,
    ]);
}

function hapusKelas(PDO $pdo, int $id): bool
{
    $stmt = $pdo->prepare(
        'DELETE FROM kelas
        WHERE id = :id
            AND NOT EXISTS (
                SELECT 1 FROM pendaftar WHERE pendaftar.kelas_id = kelas.id
            )'
    );
    $stmt->execute(['id' => $id]);

    return $stmt->rowCount() > 0;
}

function hitungPendaftar(PDO $pdo, string $kata): int
{
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM pendaftar WHERE nama LIKE :kata');
    $stmt->execute(['kata' => '%' . $kata . '%']);

    return (int) $stmt->fetchColumn();
}

function ambilPendaftar(PDO $pdo, string $kata, int $batas, int $offset): array
{
    $sql = 'SELECT p.id, p.nama, p.email, p.no_hp, k.nama_kelas
        FROM pendaftar p
        JOIN kelas k ON k.id = p.kelas_id
        WHERE p.nama LIKE :kata
        ORDER BY p.id DESC
        LIMIT :batas OFFSET :offset';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':kata', '%' . $kata . '%');
    $stmt->bindValue(':batas', $batas, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll();
}
/**
* Mengambil satu pendaftar berdasarkan ID.
*
* @param PDO $pdo Koneksi database aktif.
* @param int $id ID pendaftar (minimal 1).
*
* @return array<string, mixed>|null Baris pendaftar, atau null bila tidak ditemukan.
*/
function ambilPendaftarById(PDO $pdo, int $id): ?array
{
    $stmt = $pdo->prepare('SELECT * FROM pendaftar WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $baris = $stmt->fetch();

    return $baris === false ? null : $baris;
}

function emailSudahAda(PDO $pdo, string $email, ?int $kecualiId): bool
{
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM pendaftar WHERE email = :email AND id <> :id');
    $stmt->execute(['email' => $email, 'id' => $kecualiId ?? 0]);

    return (int) $stmt->fetchColumn() > 0;
}
/**
* Memvalidasi masukan form pendaftar dan mengembalikan data bersih serta galat.
*
* @param array<string, mixed> $input Data mentah (biasanya $_POST).
* @param PDO $pdo Koneksi untuk memeriksa email ganda dan
kelas.
* @param int|null $idUbah ID pendaftar yang sedang diubah, null saat
menambah.
*
* @return array{data: array<string, mixed>, galat: array<string, string>}
* `galat` kosong bila seluruh masukan valid.
*/
function validasiPendaftar(array $input, PDO $pdo, ?int $idUbah): array
{
    $data = [
        'nama' => trim((string) ($input['nama'] ?? '')),
        'email' => strtolower(trim((string) ($input['email'] ?? ''))),
        'no_hp' => trim((string) ($input['no_hp'] ?? '')),
        'alamat' => trim((string) ($input['alamat'] ?? '')),
        'kelas_id' => (int) ($input['kelas_id'] ?? 0),
    ];

    $galat = [];

    if (mb_strlen($data['nama']) < 3) {
        $galat['nama'] = 'Nama minimal 3 karakter.';
    } elseif (mb_strlen($data['nama']) > 100) {
        $galat['nama'] = 'Nama maksimal 100 karakter.';
    }

    if (mb_strlen($data['email']) > 120) {
        $galat['email'] = 'Email maksimal 120 karakter.';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $galat['email'] = 'Format email tidak valid.';
    } elseif (emailSudahAda($pdo, $data['email'], $idUbah)) {
        $galat['email'] = 'Email sudah terdaftar.';
    }

    if (!preg_match('/^08[0-9]{8,11}$/', $data['no_hp'])) {
        $galat['no_hp'] = 'Nomor HP diawali 08 dan 10-13 digit.';
    }

    // ID dari PDO bisa berupa string, jadi samakan dulu ke int
    // sebelum perbandingan strict, supaya kelas yang valid tidak ditolak.
    $idKelas = array_map('intval', array_column(daftarKelas($pdo), 'id'));
    if (!in_array($data['kelas_id'], $idKelas, true)) {
        $galat['kelas_id'] = 'Pilih kelas yang tersedia.';
    }

    return ['data' => $data, 'galat' => $galat];
}

function tambahPendaftar(PDO $pdo, array $d): bool
{
    $sql = 'INSERT INTO pendaftar (nama, email, no_hp, alamat, kelas_id)
        VALUES (:nama, :email, :no_hp, :alamat, :kelas_id)';

    return $pdo->prepare($sql)->execute($d);
}

function ubahPendaftar(PDO $pdo, int $id, array $d): bool
{
    $sql = 'UPDATE pendaftar
        SET nama = :nama, email = :email, no_hp = :no_hp,
            alamat = :alamat, kelas_id = :kelas_id
        WHERE id = :id';

    return $pdo->prepare($sql)->execute($d + ['id' => $id]);
}

function ubahPendaftarDenganKuota(PDO $pdo, int $id, array $data): void
{
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare('SELECT kuota FROM kelas WHERE id = :id FOR UPDATE');
        $stmt->execute(['id' => $data['kelas_id']]);
        $kuota = (int) $stmt->fetchColumn();

        $stmt = $pdo->prepare(
            'SELECT COUNT(*) FROM pendaftar WHERE kelas_id = :kelas_id AND id <> :id'
        );
        $stmt->execute(['kelas_id' => $data['kelas_id'], 'id' => $id]);
        if ((int) $stmt->fetchColumn() >= $kuota) {
            throw new KuotaPenuhException('Kuota kelas sudah penuh.');
        }

        ubahPendaftar($pdo, $id, $data);
        $pdo->commit();
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        throw $e;
    }
}

function hapusPendaftar(PDO $pdo, int $id): bool
{
    return $pdo->prepare('DELETE FROM pendaftar WHERE id = :id')->execute(['id' => $id]);
}

function ambilBuktiPendaftar(PDO $pdo, int $id): ?array
{
    $sql = 'SELECT p.id, p.nama, p.email, p.no_hp, p.tgl_daftar, k.nama_kelas
FROM pendaftar p JOIN kelas k ON k.id = p.kelas_id
WHERE p.id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $baris = $stmt->fetch();
    return $baris === false ? null : $baris;
}
function ambilSemuaPendaftar(PDO $pdo): array
{
    $sql = 'SELECT p.id, p.nama, p.email, p.no_hp, p.tgl_daftar, k.nama_kelas
FROM pendaftar p JOIN kelas k ON k.id = p.kelas_id
ORDER BY p.id DESC';
    return $pdo->query($sql)->fetchAll();
}

final class KuotaPenuhException extends RuntimeException {}
/**
 * mendaftarkan pendaftar baru ke database
 * @param PDO $pdo Koneksi database aktif.
 * @param array $d Data Pendaftar
 * @throws KuotaPenuhException Jika kuota kelas sudah penuh.
 * @return void
 */
function daftarkanDenganKuota(PDO $pdo, array $data): void
{
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare('SELECT kuota FROM kelas WHERE id = :id FOR UPDATE');
        $stmt->execute(['id' => $data['kelas_id']]);
        $kuota = (int) $stmt->fetchColumn();
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM pendaftar WHERE kelas_id = :id');
        $stmt->execute(['id' => $data['kelas_id']]);
        if ((int) $stmt->fetchColumn() >= $kuota) {
            throw new KuotaPenuhException('Kuota kelas sudah penuh.');
        }
        tambahPendaftar($pdo, $data);
        $pdo->commit();
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        throw $e;
    }
}
