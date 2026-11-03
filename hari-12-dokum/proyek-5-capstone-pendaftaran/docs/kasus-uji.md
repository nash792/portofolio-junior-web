# T6 — Kasus Uji, Pengujian Ulang, dan Regresi

## Lingkup dan prasyarat

Pengujian mencakup pendaftaran, validasi, kuota kelas, autentikasi admin, pencarian, paginasi, dan perlindungan output. Kasus yang berstatus **Belum diuji** memerlukan server PHP 8.1+ serta MySQL/MariaDB dengan `database/skema.sql` dan admin uji. Catatan hasil regresi di bawah ini berasal dari PHP 8.0.30 dan SQLite in-memory. Pengujian HTTP dan transaksi MySQL belum dijalankan sebagai bagian dari catatan regresi ini; status tersebut tidak menyatakan apakah layanan database tersedia di lingkungan lain.

Kasus unit yang dapat berjalan tanpa server aplikasi diuji memakai SQLite in-memory:

```powershell
php tests\regresi.php
```

Hasil terakhir: **17 LOLOS, 0 GAGAL**. Pengujian ini memeriksa fungsi validasi, pencarian/paginasi SQL, dan escaping; hasil tersebut bukan pengganti pengujian integrasi MySQL.

| ID | Skenario | Masukan / langkah | Hasil yang diharapkan | Hasil aktual | Status |
|---|---|---|---|---|---|
| TC-01 | Pendaftaran valid | Nama `Citra Ayu`, email baru, HP `0812345678`, kelas tersedia dan masih berkuota | Data tersimpan satu kali dan mendapat pesan sukses | Validasi unit menerima data. Penyimpanan MySQL belum dijalankan | Lolos unit; integrasi belum diuji |
| TC-02 | Email ganda | Gunakan `sari@example.test` yang telah ada di data uji | Ditolak dengan pesan email sudah terdaftar | Ditolak oleh validasi unit | Lolos |
| TC-03 | Nama kosong | Kosongkan nama | Ditolak; data tidak tersimpan | Ditolak oleh validasi unit | Lolos |
| TC-04 | Nama di bawah batas | Nama `Ab` | Ditolak karena kurang dari 3 karakter | Ditolak oleh validasi unit | Lolos |
| TC-05 | Nama melebihi kolom | Nama 101 karakter | Ditolak sebelum query penyimpanan | Ditolak dengan validasi batas 100 karakter | Lolos |
| TC-06 | Email tidak valid | `bukan-email` | Ditolak dengan pesan format email | Ditolak oleh validasi unit | Lolos |
| TC-07 | Email melebihi kolom | Email valid berukuran 121 karakter | Ditolak sebelum query penyimpanan | Ditolak dengan validasi batas 120 karakter | Lolos |
| TC-08 | HP di bawah batas | `081234567` (9 digit) | Ditolak | Ditolak oleh pemeriksaan pola unit | Lolos |
| TC-09 | HP batas minimum | `0812345678` (10 digit) | Diterima bila data lain valid | Diterima oleh pemeriksaan pola unit | Lolos |
| TC-10 | HP batas maksimum | `0812345678901` (13 digit) | Diterima bila data lain valid | Diterima oleh pemeriksaan pola unit | Lolos |
| TC-11 | HP di atas batas | `08123456789012` (14 digit) | Ditolak | Ditolak oleh pemeriksaan pola unit | Lolos |
| TC-12 | HP berisi huruf | `0812345abc` | Ditolak | Ditolak oleh pemeriksaan pola unit | Lolos |
| TC-13 | Kelas tidak tersedia | Kirim `kelas_id=999` | Ditolak dengan pesan kelas tidak tersedia | Ditolak oleh validasi unit | Lolos |
| TC-14 | Pencarian injeksi SQL | Cari nama dengan `' OR 1=1 --` | Diproses sebagai teks; tidak membocorkan seluruh baris | Query parameterized mengembalikan 0 kecocokan pada pengujian SQLite | Lolos |
| TC-15 | XSS pada nama | Masukkan `<script>alert(1)</script>` lalu tampilkan hasil | Ditampilkan sebagai teks, bukan dieksekusi | Escaping HTML menghasilkan teks ter-escape pada uji unit; render browser belum diuji | Lolos unit; browser belum diuji |
| TC-16 | Pencarian nama | Cari `Sari` pada data uji | Hanya baris yang cocok ditampilkan | Fungsi hitung hasil mengembalikan 1 baris | Lolos |
| TC-17 | Paginasi | Ambil halaman dengan batas 1 dan offset 1 | Maksimal satu baris pada halaman tersebut | Fungsi query mengembalikan tepat 1 baris | Lolos |
| TC-18 | Kuota tepat penuh | Daftarkan ke kelas yang jumlah pesertanya sama dengan kuota | Ditolak; jumlah peserta tidak bertambah | Belum dijalankan: memerlukan MySQL/InnoDB | Belum diuji |
| TC-19 | Dua pendaftaran bersamaan pada slot terakhir | Kirim dua POST valid secara bersamaan ke kelas dengan satu slot tersisa | Tepat satu berhasil; satu ditolak penuh | Belum dijalankan: memerlukan MySQL/InnoDB dan HTTP server | Belum diuji |
| TC-20 | Edit data pada kelas yang sama dan penuh | Admin menyimpan perubahan nama tanpa mengganti kelas | Perubahan diizinkan; pendaftar yang sedang diedit tidak dihitung sebagai peserta tambahan | Logika pengecualian ID tersedia; transaksi MySQL belum dijalankan | Belum diuji |
| TC-21 | Pindah ke kelas penuh | Admin mengubah kelas pendaftar ke kelas yang kuotanya sudah terpenuhi | Ditolak; data lama tidak berubah | Pemeriksaan kuota edit memakai transaksi; integrasi MySQL belum dijalankan | Belum diuji |
| TC-22 | Halaman admin tanpa login | Buka `admin.php` pada sesi baru | Dialihkan ke `login.php`; data tidak ditampilkan | Guard memakai `wajibLogin()`; HTTP server belum dijalankan | Belum diuji |
| TC-23 | Kredensial login salah | Username/kata sandi salah | Login ditolak dan pesan generik tampil | Database admin tidak tersedia untuk pengujian | Belum diuji |
| TC-24 | Kredensial login benar | Login menggunakan admin uji yang dibuat dengan `database/buat-admin.php` | Sesi diregenerasi dan halaman admin dapat dibuka | Database admin tidak tersedia untuk pengujian | Belum diuji |
| TC-25 | Logout melalui GET | Buka langsung `logout.php` dengan GET | Ditolak dengan HTTP 405; sesi tetap memerlukan logout POST | Pemeriksaan metode POST sudah ada; HTTP server belum dijalankan | Belum diuji |
| TC-26 | Logout tanpa token CSRF | Kirim POST ke `logout.php` tanpa token valid | Ditolak HTTP 403; sesi admin tidak dihapus oleh permintaan tersebut | Validasi CSRF sudah ada; HTTP server belum dijalankan | Belum diuji |
| TC-27 | Logout valid | Kirim POST dengan token CSRF dari sesi admin | Sesi dan cookie autentikasi dihapus; halaman admin meminta login kembali | `logout()` menghapus sesi; alur browser belum dijalankan | Belum diuji |
| TC-28 | ID pendaftar tidak valid | Buka `ubah.php?id=abc` | HTTP 404 dan tidak ada query perubahan | Filter ID sudah menolak format invalid; HTTP server belum dijalankan | Belum diuji |
| TC-29 | Hapus tanpa token | Kirim POST ke `hapus.php` tanpa token CSRF | HTTP 403 dan data tetap ada | Pemeriksaan token tersedia; database/HTTP belum dijalankan | Belum diuji |
| TC-30 | Pencarian dan paginasi admin | Isi pencarian, lalu buka halaman berikutnya | Hasil sesuai pencarian dan maksimal 10 baris per halaman | Handler memakai fungsi pencarian/paginasi; MySQL/HTTP belum dijalankan | Belum diuji |

## Cara menyelesaikan pengujian integrasi

1. Jalankan Apache dan MySQL/MariaDB dengan PHP 8.1 atau lebih baru.
2. Impor `database/skema.sql`, lalu `database/latihan.sql` jika membutuhkan data awal.
3. Siapkan kredensial lokal di `config/config.php` dan buat admin uji dengan `php database/buat-admin.php <username> <sandi>`.
4. Jalankan TC-01–TC-30 melalui browser/form dan isi hasil aktual serta statusnya berdasarkan respons HTTP dan isi database.
5. Untuk kuota, atur kuota kelas sama dengan jumlah pendaftar sebelum menjalankan TC-18–TC-21.

Sebelum uji akhir, pastikan konfigurasi menggunakan `'debug' => false`. Tidak ditemukan `var_dump` atau `console.log` di kode capstone.
