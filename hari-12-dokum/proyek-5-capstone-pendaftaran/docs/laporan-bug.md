# T7 — Laporan Bug

Laporan berikut mencatat cacat yang ditemukan pada capstone pendaftaran dengan login admin dan kuota kelas. Perbaikan sudah diterapkan; status uji membedakan pengujian unit dari integrasi yang memerlukan MySQL.

## B-01 — Pencarian dan paginasi admin tidak diterapkan

| Kolom | Isi |
|---|---|
| Jenis | Logic |
| Tingkat keparahan | Sedang |
| Lokasi | `public/admin.php`, pemanggilan daftar pendaftar |
| Langkah reproduksi | Login admin, isi pencarian nama yang hanya cocok dengan satu data, lalu buka halaman kedua. |
| Hasil diharapkan vs aktual | Diharapkan hasil difilter dan dibatasi 10 data per halaman. Sebelum perbaikan, halaman menggunakan `ambilSemuaPendaftar()` yang mengabaikan parameter pencarian dan paginasi; semua data dikembalikan. |
| Pesan/kode error | Tidak ada; hasil keliru tanpa pesan error. |
| Penyebab | Fungsi yang dipanggil mengambil semua baris dan tidak menerima kata kunci, batas, atau offset. |
| Perbaikan | Ganti pemanggilan dengan `ambilPendaftar($pdo, $kata, $perHalaman, $offset)`. |
| Hasil uji | Fungsi hitung pencarian dan query paginasi lolos dalam `tests/regresi.php`. Uji halaman admin dengan MySQL belum dijalankan. |

## B-02 — Edit pendaftar dapat melampaui kuota kelas

| Kolom | Isi |
|---|---|
| Jenis | Logic |
| Tingkat keparahan | Tinggi |
| Lokasi | `public/ubah.php`, proses POST; `src/pendaftar.php`, fungsi kuota |
| Langkah reproduksi | Login admin, pastikan suatu kelas penuh, lalu ubah data pendaftar dari kelas lain agar masuk ke kelas penuh. |
| Hasil diharapkan vs aktual | Diharapkan perpindahan ditolak dan jumlah peserta tidak melebihi kuota. Sebelum perbaikan, UPDATE langsung dijalankan tanpa pemeriksaan kapasitas sehingga kelas dapat kelebihan peserta. |
| Pesan/kode error | Tidak ada; perubahan berhasil tanpa validasi kuota. |
| Penyebab | Pemeriksaan kuota hanya dilakukan pada alur tambah, bukan alur edit. |
| Perbaikan | Tambahkan `ubahPendaftarDenganKuota()` yang mengunci baris kelas, menghitung peserta selain ID yang sedang diedit, lalu memperbarui data dalam transaksi. |
| Hasil uji | Jalur edit kini memakai pemeriksaan kuota transaksional. Uji transaksi MySQL/InnoDB belum dijalankan saat laporan ini disusun. |

## B-03 — Logout hanya menghapus satu penanda autentikasi

| Kolom | Isi |
|---|---|
| Jenis | Logic |
| Tingkat keparahan | Tinggi |
| Lokasi | `public/logout.php`, `src/auth.php` |
| Langkah reproduksi | Login admin, logout, lalu buka `admin.php` pada sesi/cookie yang sama. |
| Hasil diharapkan vs aktual | Diharapkan sesi admin berakhir dan halaman admin meminta login lagi. Sebelum perbaikan, logout hanya menghapus `admin_login`; `admin_id` tetap ada sehingga guard halaman admin masih menganggap sesi valid. |
| Pesan/kode error | Tidak ada; akses admin masih terbuka pada sesi yang belum dihancurkan. |
| Penyebab | Logout tidak menggunakan fungsi `logout()` yang menghapus seluruh data sesi dan cookie sesi. |
| Perbaikan | Ubah logout menjadi POST dengan token CSRF, lalu panggil `logout()` untuk menghapus seluruh sesi dan cookie. |
| Hasil uji | Implementasi kini memakai POST, validasi CSRF, dan penghancuran sesi. Uji ulang HTTP/browser belum dapat dilakukan tanpa server aplikasi. |

## B-04 — Guard halaman admin memakai dua kunci sesi berbeda

| Kolom | Isi |
|---|---|
| Jenis | Logic |
| Tingkat keparahan | Sedang |
| Lokasi | `src/helpers.php` (`cekLoginAdmin()`), `src/auth.php` (`wajibLogin()`) |
| Langkah reproduksi | Pada sesi uji, pertahankan `admin_id` tetapi hapus `admin_login`, lalu buka `admin.php` dan `ubah.php`. |
| Hasil diharapkan vs aktual | Diharapkan semua halaman admin memberi keputusan akses yang sama. Sebelum perbaikan, `admin.php` memeriksa `admin_id` sedangkan `ubah.php` memeriksa `admin_login`, sehingga akses berbeda untuk sesi yang sama. |
| Pesan/kode error | Tidak ada; perilaku akses tidak konsisten. |
| Penyebab | Dua pemeriksaan autentikasi menggunakan kunci sesi terpisah. |
| Perbaikan | Jadikan `cekLoginAdmin()` mendelegasikan pemeriksaan ke `wajibLogin()` dan gunakan `admin_id` sebagai satu-satunya penanda autentikasi. |
| Hasil uji | Pemeriksaan sumber menunjukkan guard memakai helper yang sama. Pengujian alur HTTP belum dijalankan. |

## B-05 — Batas panjang nama dan email tidak divalidasi

| Kolom | Isi |
|---|---|
| Jenis | Validasi |
| Tingkat keparahan | Sedang |
| Lokasi | `src/pendaftar.php`, `validasiPendaftar()` |
| Langkah reproduksi | Kirim nama lebih dari 100 karakter atau email lebih dari 120 karakter. |
| Hasil diharapkan vs aktual | Diharapkan input ditolak dengan pesan validasi sebelum query. Sebelum perbaikan, validasi melewatkan panjang kolom; penyimpanan dapat gagal atau terpotong sesuai konfigurasi SQL. |
| Pesan/kode error | Bergantung mode SQL, misalnya error panjang data atau data terpotong. |
| Penyebab | Skema membatasi nama ke 100 dan email ke 120 karakter, tetapi validasi server tidak menyamakan batas tersebut. |
| Perbaikan | Tambahkan validasi panjang nama dan email sesuai batas kolom database. |
| Hasil uji | Nama 101 karakter dan email 121 karakter ditolak dalam pengujian regresi SQLite. |

## B-06 — Konfigurasi contoh menampilkan error PHP

| Kolom | Isi |
|---|---|
| Jenis | Konfigurasi |
| Tingkat keparahan | Sedang |
| Lokasi | `config/config-contoh.php`, `config/config.contoh.php`, `config/config.php` lokal |
| Langkah reproduksi | Jalankan aplikasi dengan konfigurasi contoh yang masih memakai `'debug' => true`, lalu picu exception PHP. |
| Hasil diharapkan vs aktual | Diharapkan detail exception tidak ditampilkan kepada pengunjung. Sebelum perbaikan, `bootstrap.php` mengaktifkan `display_errors` saat nilai debug true. |
| Pesan/kode error | Detail runtime PHP berpotensi terlihat pada respons. |
| Penyebab | Nilai debug bawaan aktif. |
| Perbaikan | Matikan debug pada konfigurasi contoh dan konfigurasi lokal yang digunakan untuk uji akhir. |
| Hasil uji | Konfigurasi yang diperiksa memakai `'debug' => false`. Uji respons error HTTP belum dijalankan saat laporan ini disusun. |

## B-07 — Endpoint logout menerima GET tanpa perlindungan CSRF

| Kolom | Isi |
|---|---|
| Jenis | Logic |
| Tingkat keparahan | Rendah |
| Lokasi | `public/logout.php`, `templates/header.php` |
| Langkah reproduksi | Saat admin login, kunjungi tautan `logout.php` melalui GET atau sematkan permintaan GET dari halaman lain. |
| Hasil diharapkan vs aktual | Diharapkan perubahan status sesi hanya dilakukan lewat POST dengan token CSRF. Sebelum perbaikan, permintaan GET dapat memicu logout tanpa token. |
| Pesan/kode error | Tidak ada; sesi diubah oleh GET. |
| Penyebab | Logout berupa tautan GET dan endpoint tidak memeriksa token CSRF. |
| Perbaikan | Ganti tautan dengan form POST bertoken CSRF; tolak metode selain POST. |
| Hasil uji | Pemeriksaan metode dan token diterapkan; uji permintaan HTTP belum dijalankan. |
