# Catatan Keamanan

## Ruang lingkup

Pemeriksaan mencakup kode dan pengujian pada `hari-11-debug/`, terutama aplikasi `proyek-5-capstone-pendaftaran/`. Catatan ini membedakan hasil uji yang dijalankan dari pemeriksaan kode; hasil ini bukan jaminan bahwa aplikasi bebas kerentanan.

## Ringkasan hasil

| Area | Hasil | Bukti dan batasan |
|---|---|---|
| SQL Injection | Tidak ditemukan kerentanan terkonfirmasi. Uji regresi lulus. | `php hari-11-debug\proyek-5-capstone-pendaftaran\tests\regresi.php` menghasilkan **17 lolos, 0 gagal**. Uji pencarian dengan input `' OR 1=1 --` menghasilkan 0 kecocokan (`proyek-5-capstone-pendaftaran/tests/regresi.php`, baris 95–98). Kueri pencarian menggunakan prepared statement dan parameter terikat (`proyek-5-capstone-pendaftaran/src/pendaftar.php`, baris 12–13 dan 26–30). Uji SQL langsung terbatas pada pencarian; kueri lain ditinjau melalui kode, bukan uji integrasi. |
| XSS | Tidak ditemukan kerentanan terkonfirmasi. Uji escaping unit lulus. | Uji regresi memeriksa escaping (`proyek-5-capstone-pendaftaran/tests/regresi.php`, baris 103–107). Helper `e()` menggunakan `htmlspecialchars(..., ENT_QUOTES, 'UTF-8')` (`proyek-5-capstone-pendaftaran/src/helpers.php`, baris 5–8). Nilai nama pada tabel dan atribut konfirmasi di-escape (`proyek-5-capstone-pendaftaran/public/admin.php`, baris 40–43 dan 49–51); JavaScript menampilkan nama sebagai teks (`proyek-5-capstone-pendaftaran/public/asset/js/app.js`, baris 18–20). Pengujian halaman di browser tidak dilakukan. |
| CSRF | Mekanisme perlindungan ditemukan pada kode, tetapi belum diuji melalui HTTP. | Token dibuat dengan `random_bytes(32)` dan diverifikasi dengan `hash_equals()` (`proyek-5-capstone-pendaftaran/src/helpers.php`, baris 16–31). Pemeriksaan token digunakan pada POST pendaftaran, edit, hapus, dan logout (`proyek-5-capstone-pendaftaran/public/tambah.php`, baris 12–14; `public/ubah.php`, baris 22–24; `public/hapus.php`, baris 9–14; `public/logout.php`, baris 6–12). Tes regresi tidak mencakup CSRF; logout tanpa token dan hapus tanpa token juga tercatat belum diuji (`proyek-5-capstone-pendaftaran/docs/kasus-uji.md`, baris 42 dan 45). |

## Validasi dan keterbatasan

- Tes regresi lokal dijalankan dengan PHP 8.0.30 dan selesai dengan **17 lolos, 0 gagal**.
- Pengujian HTTP/browser dan MySQL tidak dijalankan.
- Dokumentasi proyek mensyaratkan PHP 8.1 atau lebih baru untuk pengujian integrasi (`proyek-5-capstone-pendaftaran/docs/kasus-uji.md`, baris 5–13).
- Hasil pemeriksaan ini terbatas pada bukti di atas dan tidak menggantikan pengujian keamanan menyeluruh.
