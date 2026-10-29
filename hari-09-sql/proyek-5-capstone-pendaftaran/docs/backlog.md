# User Story dan Backlog Sprint 0

| ID | Sebagai | Saya ingin | Agar | Prioritas | Status |
|---|---|---|---|---|---|
| US-01 | Peserta | Mengisi form pendaftaran dan memilih kelas | Terdaftar pada kelas pilihan | Wajib | Selesai |
| US-02 | Admin | Melihat daftar pendaftar dengan pencarian dan paginasi | Mengelola data dengan cepat | Wajib | Selesai |
| US-03 | Admin | Mengubah data pendaftar | Memperbaiki kesalahan data | Wajib | Selesai |
| US-04 | Admin | Menghapus data melalui POST dengan token CSRF | Menghapus data dengan lebih aman | Wajib | Selesai |
| US-05 | Sistem | Memvalidasi nama, email, nomor HP, dan kelas | Data yang tersimpan konsisten | Wajib | Selesai |
| US-06 | Sistem | Menolak email duplikat | Setiap pendaftar memiliki email unik | Wajib | Selesai |
| US-07 | Sistem | Menyimpan data kelas dan pendaftar dengan relasi FK | Relasi data tetap valid | Wajib | Selesai |
| US-08 | Pengelola | Mengimpor skema dari awal | Proyek mudah dibangun ulang | Wajib | Selesai |
| US-09 | Peserta | Mencetak bukti pendaftaran PDF | Memiliki bukti resmi | Wajib Hari 10 | Backlog |
| US-10 | Admin | Login menggunakan akun | Data tidak diubah pihak yang tidak berwenang | Wajib Hari 11 | Backlog |
| US-11 | Admin | Membatasi kuota kelas | Kapasitas kelas tidak terlampaui | Wajib Hari 11 | Backlog |
| US-12 | Admin | Mendapat tampilan tabel responsif dan konfirmasi aksi | Pengelolaan lebih nyaman | Tambahan/Hari 10 | Backlog |

## Urutan prioritas
1. Skema database dan data contoh.
2. CRUD beserta validasi.
3. Keamanan query, output, CSRF, dan konfigurasi.
4. Pencarian dan paginasi.
5. Dokumen desain dan pengujian.
6. PDF, autentikasi, dan kuota pada sprint berikutnya.
