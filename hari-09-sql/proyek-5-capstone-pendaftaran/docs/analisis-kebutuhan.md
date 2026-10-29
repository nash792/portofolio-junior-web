# Analisis Kebutuhan — Sistem Pendaftaran Pelatihan

## 1. Latar belakang
Lembaga pelatihan membutuhkan sistem pendaftaran daring agar calon peserta dapat mengisi data dan memilih kelas. Admin membutuhkan daftar pendaftar yang mudah dicari dan dikelola. Sistem juga direncanakan menghasilkan bukti pendaftaran PDF pada sprint berikutnya.

## 2. Pengguna
- **Peserta:** mengisi data pendaftaran, memilih kelas, dan memperoleh bukti pendaftaran.
- **Admin:** melihat, mencari, mengubah, dan menghapus data pendaftar. Fitur login dan pengaturan kuota dikembangkan pada Hari 11.

## 3. Fitur wajib Sprint 0
1. Menyimpan kelas dan pendaftar dalam basis data relasional.
2. Menampilkan daftar pendaftar beserta nama kelas.
3. Menambah pendaftar melalui form.
4. Memvalidasi nama, email, nomor HP, dan pilihan kelas di server.
5. Menolak email duplikat.
6. Mengubah dan menghapus data.
7. Pencarian nama dan paginasi.
8. Menggunakan PDO prepared statement, escape output, token CSRF, dan PRG.
9. Memisahkan konfigurasi, logika, tampilan, dan berkas skema.

## 4. Fitur tambahan / sprint berikutnya
- Bukti pendaftaran PDF (Hari 10).
- Login admin dan pembatasan akses (Hari 11).
- Validasi kuota kelas agar tidak melebihi kapasitas (Hari 11).
- Antarmuka Bootstrap, DataTables, dan SweetAlert2 (Hari 10).
- Pengujian lebih lengkap dan laporan bug (Hari 11–12).

## 5. Batasan
- Sprint 0 berfokus pada fondasi CRUD; autentikasi admin dan PDF belum diterapkan.
- Aplikasi ini merupakan proyek latihan lokal, belum siap dipublikasikan tanpa penguatan konfigurasi, autentikasi, HTTPS, dan pengaturan hak akses database.
- Validasi nomor HP mengikuti aturan modul: diawali `08` dan terdiri dari 10–13 digit.
- Kuota tersimpan di tabel kelas, tetapi belum dibatasi saat pendaftaran pada sprint ini.

## 6. Asumsi
- Satu pendaftar memilih satu kelas.
- Satu kelas dapat memiliki banyak pendaftar.
- Email harus unik pada seluruh sistem.
- Alamat bersifat opsional.
