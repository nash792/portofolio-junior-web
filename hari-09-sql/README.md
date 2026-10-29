# Hari 09 — SQL dan Basis Data

Folder ini berisi materi latihan SQL dan proyek capstone pendaftaran pelatihan menggunakan PHP dan MySQL/MariaDB.

## Tujuan belajar

- Membuat database dan tabel dengan relasi primary key dan foreign key.
- Menambahkan indeks dan aturan unik untuk menjaga konsistensi data.
- Menulis query `SELECT`, `WHERE`, `ORDER BY`, `LIKE`, dan `LIMIT`.
- Menggabungkan tabel dengan `JOIN` dan menghitung data dengan `GROUP BY`.
- Mengubah dan menghapus data menggunakan `UPDATE` dan `DELETE`.
- Menghubungkan PHP ke MySQL menggunakan PDO dan prepared statement.

## Isi folder

- [proyek-5-capstone-pendaftaran/](./proyek-5-capstone-pendaftaran/) — aplikasi pendaftaran pelatihan dan materi capstone.
- [proyek-5-capstone-pendaftaran/database/skema.sql](./proyek-5-capstone-pendaftaran/database/skema.sql) — membuat database `db_pelatihan` beserta tabel `kelas`, `pendaftar`, dan `admin`.
- [proyek-5-capstone-pendaftaran/database/latihan.sql](./proyek-5-capstone-pendaftaran/database/latihan.sql) — mengisi data latihan dan contoh query SQL.
- [proyek-5-capstone-pendaftaran/docs/](./proyek-5-capstone-pendaftaran/docs/) — analisis kebutuhan, backlog, ERD, wireframe, dan catatan Bug Hunt.

## Menjalankan latihan SQL

1. Jalankan Apache dan MySQL/MariaDB, misalnya melalui XAMPP.
2. Buka phpMyAdmin, lalu impor `proyek-5-capstone-pendaftaran/database/skema.sql`.
3. Setelah skema berhasil dibuat, jalankan `proyek-5-capstone-pendaftaran/database/latihan.sql` untuk memasukkan data dan mencoba query.
4. Di dalam file latihan, query nomor 9 dan 10 memang dirancang untuk menghasilkan error constraint. Jalankan masing-masing secara terpisah setelah mencoba query sebelumnya.

> Gunakan database latihan yang boleh diubah. Query `UPDATE` dan `DELETE` mengubah data, dan menjalankan bagian pengisian data berulang kali dapat menimbulkan email duplikat.

## Menjalankan aplikasi capstone

Persyaratan: PHP 8.1 atau lebih baru dengan ekstensi `pdo_mysql` dan `mbstring`, serta MySQL/MariaDB.

1. Ikuti langkah impor skema di atas.
2. Salin `proyek-5-capstone-pendaftaran/config/config.contoh.php` menjadi `config/config.php`, lalu sesuaikan kredensial database lokal.
3. Letakkan repository di dalam document root Apache, lalu buka:
   `http://localhost/portofolio-junior-web/hari-09-sql/proyek-5-capstone-pendaftaran/public/`
4. Jika folder proyek dipindahkan langsung ke `htdocs`, gunakan URL yang sesuai dengan nama folder tersebut.

File `config/config.php` berisi konfigurasi lokal dan tidak boleh dimasukkan ke Git. Untuk petunjuk lebih lengkap mengenai fitur dan pengujian aplikasi, baca [README capstone](./proyek-5-capstone-pendaftaran/README.md).
