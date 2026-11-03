# Changelog

Perubahan penting pada proyek dicatat di sini.

## [Unreleased] - 2026-11-03

### Ditambahkan

- Dokumentasi penggunaan Capstone dan tautan ke tangkapan layar form pendaftaran, panel admin, serta bukti PDF.
- Dokumentasi arsitektur yang menjelaskan struktur folder, alur request, dan ERD.
- Catatan temuan dan perbaikan pada Doc Hunt.
- Catatan rilis, tangkapan layar, dan uji instalasi bersih pada [`../no4.md`](../no4.md).

### Diperbaiki

- Pencarian dan paginasi pada panel admin menggunakan query yang sesuai.
- Perubahan kelas pendaftar memeriksa kuota dalam transaksi.
- Login, guard admin, dan logout menggunakan status sesi yang konsisten; logout memerlukan POST dengan token CSRF.
- Validasi panjang nama dan email mengikuti batas kolom database.
- Konfigurasi contoh menonaktifkan tampilan detail error.
- Teks lokasi endpoint tidak lagi ikut tercetak pada bukti PDF.
- Dokumentasi API, alur autentikasi, dependensi runtime, dan status pengujian diselaraskan dengan implementasi aktual.
- Panduan pengguna diperbarui agar menunjuk ke endpoint pendaftaran dan alur cetak PDF yang benar.
- Halaman sambutan menampilkan sapaan aman untuk pengunjung tanpa sesi admin setelah pendaftaran.
