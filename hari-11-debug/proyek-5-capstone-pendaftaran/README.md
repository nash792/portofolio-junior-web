# Proyek 5 — Sistem Pendaftaran Pelatihan
**Hari 9: PHP, MySQL (CRUD), dan Best Practices Backend**

Aplikasi sederhana untuk mengelola pendaftaran pelatihan menggunakan PHP 8+, MySQL/MariaDB, PDO, prepared statement, validasi server-side, pencarian, paginasi, pola Post/Redirect/Get (PRG), dan token CSRF.

## 1. Kebutuhan
- PHP 8.1+ dengan ekstensi `pdo_mysql` dan `mbstring`
- MySQL/MariaDB
- Apache (misalnya melalui XAMPP)
- Browser dan phpMyAdmin (opsional)

## 2. Instalasi
1. Salin folder proyek ke direktori web server, misalnya `htdocs/proyek-5-capstone-pendaftaran`.
2. Jalankan Apache dan MySQL.
3. Buka phpMyAdmin, lalu impor `database/skema.sql`. Skrip membuat database `db_pelatihan`, tabel, indeks, data contoh, dan 8 pendaftar.
4. Salin `config/config.contoh.php` menjadi `config/config.php`, lalu sesuaikan host, nama database, username, dan sandi MySQL.
5. Buka `http://localhost/proyek-5-capstone-pendaftaran/public/`.

> Untuk lingkungan lokal XAMPP standar, username biasanya `root` dan sandi kosong. Sesuaikan dengan konfigurasi lokal Anda.

## 3. Fitur
- Melihat daftar pendaftar dan nama kelas
- Menambah, mengubah, dan menghapus pendaftar
- Validasi nama, email, nomor HP, dan kelas
- Pencegahan email duplikat
- Pencarian nama dan paginasi 10 data per halaman
- PDO prepared statements
- Escape output dengan `htmlspecialchars`
- Token CSRF untuk operasi POST
- Flash message dan pola PRG
- Penanganan error umum dan pencatatan detail ke error log

## 4. Struktur
```text
config/
  config.contoh.php
  config.php              # lokal saja; jangan commit
  database.php
src/
  bootstrap.php
  helpers.php
  pendaftar.php
public/
  index.php
  tambah.php
  ubah.php
  hapus.php
  _form.php
database/
  skema.sql
  latihan.sql
  seed.sql
docs/
  analisis-kebutuhan.md
  backlog.md
  erd.md
  wireframe.md
  bug-hunt.md
.gitignore
README.md
```

## 5. Catatan keamanan
- `config/config.php` dikecualikan dari Git.
- Gunakan akun database dengan hak minimum untuk lingkungan produksi; jangan gunakan `root`.
- Jangan tampilkan detail exception kepada pengguna.
- Berkas `injeksi.php` sengaja tidak disediakan sebagai halaman publik. Demonstrasi query rentan sebaiknya dilakukan hanya di lingkungan lokal terisolasi, bukan pada sistem berisi data nyata.
- Pada proyek produksi, arahkan document root web server langsung ke folder `public/`.

## 6. Pengujian manual
1. Tambahkan data valid: data tersimpan dan muncul di daftar.
2. Kirim form dengan nama kurang dari 3 karakter.
3. Masukkan format email tidak valid.
4. Gunakan email yang sudah terdaftar.
5. Masukkan nomor HP yang tidak diawali `08` atau panjangnya tidak sesuai.
6. Jangan memilih kelas.
7. Ubah data yang sudah ada.
8. Hapus data melalui tombol Hapus.
9. Cari bagian nama, misalnya `an`.
10. Buka `ubah.php?id=abc` dan `ubah.php?id=9999`; keduanya harus menghasilkan 404.
11. Kirim POST tanpa token CSRF; harus menghasilkan 403.
12. Masukkan teks `<script>alert(1)</script>` sebagai nama; teks harus ditampilkan sebagai teks, bukan dijalankan.
13. Tambahkan data hingga lebih dari 10 baris untuk memeriksa paginasi.
14. Coba email duplikat langsung melalui SQL; MySQL harus menolak karena indeks UNIQUE.

## 7. Capstone Sprint 0
Dokumen analisis, backlog, ERD, wireframe, dan Bug Hunt ada di folder `docs/`. Jalankan query latihan dari `database/latihan.sql`.

## 8. Git
```bash
git init
git add .
git commit -m "Hari 9: skema database dan dokumentasi Sprint 0"
git add config/config.contoh.php config/database.php src public database docs README.md .gitignore
git commit -m "Hari 9: implementasi CRUD pendaftar dengan validasi dan CSRF"
```
