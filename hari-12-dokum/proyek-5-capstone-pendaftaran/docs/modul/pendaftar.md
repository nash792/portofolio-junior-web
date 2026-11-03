# Modul Pendaftar

## Informasi Umum

- **Berkas sumber:** `src/pendaftar.php`
- **Tujuan:** Mengelola pembacaan dan perubahan data kelas/pendaftar, validasi formulir, serta pendaftaran dan perubahan kelas yang mematuhi kuota.
- **Ketergantungan utama:** Koneksi `PDO` dan tabel `kelas` serta `pendaftar`.
- **Pemakaian:** Fungsi-fungsi modul dipanggil oleh endpoint, bukan dijalankan langsung sebagai halaman.

## Ketergantungan dan pola penggunaan

- Fungsi menerima koneksi `PDO` dari pemanggil; koneksi tidak dibuat di dalam modul.
- Query yang menerima nilai menggunakan prepared statement.
- `validasiPendaftar()` mengembalikan data yang telah dinormalisasi dan daftar galat. Endpoint sebaiknya hanya menyimpan data jika `galat` kosong.
- Operasi dengan kuota memakai transaksi dan `SELECT ... FOR UPDATE`, sehingga memerlukan database yang mendukung penguncian baris, seperti MySQL/MariaDB.
- `KuotaPenuhException` dilempar jika kelas penuh. Exception database atau exception lain diteruskan ke pemanggil setelah transaksi dibatalkan bila masih aktif.

## API publik

| Fungsi/kelas | Parameter | Hasil dan perilaku |
|---|---|---|
| `daftarKelas(PDO $pdo)` | Koneksi database. | Array kelas berisi `id` dan `nama_kelas`, diurutkan berdasarkan nama kelas. |
| `hitungPendaftar(PDO $pdo, string $kata)` | Koneksi database dan potongan nama untuk pencarian. | Jumlah pendaftar dengan nama yang cocok dengan pola `%kata%`. |
| `ambilPendaftar(PDO $pdo, string $kata, int $batas, int $offset)` | Koneksi, kata pencarian nama, jumlah maksimum baris, dan offset. | Array pendaftar yang cocok, termasuk `nama_kelas`, diurutkan dari ID terbaru. Batas dan offset dikirim sebagai integer. |
| `ambilPendaftarById(PDO $pdo, int $id)` | Koneksi dan ID pendaftar. | Satu baris pendaftar sebagai array, atau `null` jika tidak ditemukan. |
| `emailSudahAda(PDO $pdo, string $email, ?int $kecualiId)` | Koneksi, alamat email, dan ID pendaftar yang dikecualikan saat mengubah data (atau `null`). | `true` jika email digunakan oleh pendaftar lain; selain itu `false`. |
| `validasiPendaftar(array $input, PDO $pdo, ?int $idUbah)` | Data formulir, koneksi untuk pemeriksaan email/kelas, dan ID yang sedang diubah (atau `null` saat menambah). | Array berbentuk `['data' => ..., 'galat' => ...]`. Data dinormalisasi: teks dipangkas, email dijadikan huruf kecil, dan `kelas_id` dijadikan integer. Validasi nama 3–100 karakter, email valid dan maksimal 120 karakter, nomor HP berpola `08` diikuti 8–11 digit, serta kelas harus tersedia. |
| `tambahPendaftar(PDO $pdo, array $d)` | Koneksi dan data pendaftar siap simpan (`nama`, `email`, `no_hp`, `alamat`, `kelas_id`). | `bool` hasil eksekusi INSERT. Tidak memeriksa kuota atau memulai transaksi. |
| `ubahPendaftar(PDO $pdo, int $id, array $d)` | Koneksi, ID pendaftar, dan data yang akan disimpan. | `bool` hasil eksekusi UPDATE. Tidak memeriksa kuota atau memulai transaksi. |
| `ubahPendaftarDenganKuota(PDO $pdo, int $id, array $data)` | Koneksi, ID pendaftar, dan data termasuk `kelas_id` tujuan. | `void`. Mengunci baris kelas, menghitung pendaftar lain di kelas tujuan, lalu mengubah data dalam transaksi. Melempar `KuotaPenuhException` bila kuota terisi; membatalkan transaksi jika terjadi exception. |
| `hapusPendaftar(PDO $pdo, int $id)` | Koneksi dan ID pendaftar. | `bool` hasil eksekusi DELETE. |
| `ambilBuktiPendaftar(PDO $pdo, int $id)` | Koneksi dan ID pendaftar. | Data untuk bukti berisi ID, nama, email, nomor HP, tanggal daftar, dan nama kelas; `null` jika tidak ditemukan. |
| `ambilSemuaPendaftar(PDO $pdo)` | Koneksi database. | Semua pendaftar beserta nama kelas dan tanggal daftar, diurutkan dari ID terbaru. |
| `daftarkanDenganKuota(PDO $pdo, array $data)` | Koneksi dan data pendaftar siap simpan, termasuk `kelas_id`. | `void`. Mengunci kelas dan memeriksa jumlah pendaftar sebelum INSERT di dalam transaksi. Melempar `KuotaPenuhException` bila penuh; membatalkan transaksi bila terjadi exception. |
| `KuotaPenuhException` | Pesan exception opsional. | Exception khusus untuk kondisi kuota kelas penuh; ditangkap endpoint agar dapat ditampilkan sebagai galat formulir. |

## Alur umum

1. Ambil kelas dengan `daftarKelas()` untuk pilihan pada formulir.
2. Kirim data formulir ke `validasiPendaftar()`.
3. Jika tidak ada galat, gunakan `daftarkanDenganKuota()` untuk pendaftaran baru atau `ubahPendaftarDenganKuota()` untuk perubahan kelas/data.
4. Tangani `KuotaPenuhException` sebagai galat pada pilihan kelas. Exception lain dibiarkan diteruskan ke penanganan error aplikasi.

> `tambahPendaftar()` dan `ubahPendaftar()` merupakan operasi CRUD dasar. Untuk alur aplikasi yang harus menghormati kuota, gunakan fungsi transaksional yang sesuai.