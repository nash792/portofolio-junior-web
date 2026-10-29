# Bug Hunt Hari 9 — Temuan dan Perbaikan

| No. | Gejala | Penyebab | Perbaikan |
|---:|---|---|---|
| 1 | `SQLSTATE[HY000] [1045] Access denied` | Kredensial salah di `config.php` | Periksa username dan sandi database |
| 2 | `SQLSTATE[HY000] [1049] Unknown database` | Database belum dibuat atau nama tidak cocok | Impor `database/skema.sql` dan samakan nama database |
| 3 | `SQLSTATE[23000] 1062 Duplicate entry` | Email sudah dipakai | Validasi email di PHP dan pertahankan constraint `UNIQUE` |
| 4 | `Unknown column 'nama_kelas'` | Kolom kelas diambil tanpa relasi tabel kelas | Tambahkan `JOIN kelas` |
| 5 | Query menyambung input dari `$_GET` | Rentan SQL Injection | Gunakan prepared statement |
| 6 | `LIMIT`/`OFFSET` error | Parameter terikat sebagai string | Gunakan `bindValue` dengan `PDO::PARAM_INT` |
| 7 | Seluruh data terhapus | `DELETE` tanpa `WHERE` | Gunakan `WHERE id = :id`; uji pada data salinan |

## Checklist review
- [x] `declare(strict_types=1)` dan tipe pada fungsi.
- [x] Query memakai parameter untuk input pengguna.
- [x] Ubah/hapus menggunakan POST dan token CSRF untuk perubahan.
- [x] Kredensial lokal di luar commit Git.
- [x] Error detail dicatat ke log; pengguna menerima pesan umum.
- [x] Logika akses data terpisah dari template.
- [x] Fungsi camelCase dan kolom snake_case.
