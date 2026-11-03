# Doc Hunt — Temuan dan Perbaikan Dokumentasi

Audit membandingkan dokumentasi Capstone dengan signature fungsi, endpoint,
template, dan dependensi yang benar-benar digunakan aplikasi.

| Temuan | Dampak | Perbaikan |
|---|---|---|
| Peta modul mendokumentasikan `hitungPendaftar()` dan `ambilPendaftar()` sebagai fungsi pencarian berdasarkan ID kelas, padahal keduanya menerima kata pencarian nama; fungsi kedua juga menerima batas dan offset. | Pembaca dapat memanggil fungsi dengan argumen yang salah dan mendapat pemahaman keliru tentang pencarian/paginasi admin. | Hapus tabel API yang usang dan tautkan ke dokumentasi modul pendaftar dengan signature yang mengikuti kode. |
| Panduan autentikasi menyebut login mengarahkan admin ke halaman terlindungi. | Alur dokumentasi berbeda dari `public/login.php`, yang mengarahkan login berhasil ke `public/index.php`; panel admin tetap memiliki guard terpisah. | Jelaskan tujuan redirect dan guard panel admin secara eksplisit. |
| Evaluasi library menyebut semua dependensi belum dievaluasi, padahal Bootstrap, SweetAlert2, jQuery, DataTables, dan Dompdf digunakan aplikasi. | Daftar kandidat tidak menunjukkan dependensi runtime maupun versi yang dipakai. | Catat library aktual, versi yang terverifikasi, sumber pemuatan, dan alternatif FPDF yang tidak dipakai. |
| Catatan kasus uji menyatakan MySQL tidak aktif, sehingga pengujian integrasi belum dapat dijalankan. | Pernyataan ketersediaan layanan bersifat sementara dan tidak menjelaskan apakah pengujian memang dijalankan. | Ubah catatan menjadi status eksekusi pengujian: regresi SQLite dijalankan, sedangkan pengujian HTTP/transaksi MySQL belum dijalankan dalam catatan tersebut. |
| Hasil uji di laporan bug mengaitkan kasus yang belum diuji dengan server MySQL yang tidak aktif. | Pembaca dapat mengira ketersediaan server masih menjadi penyebab saat ini, bukan status historis pengujian. | Tandai uji integrasi sebagai belum dijalankan ketika laporan dibuat tanpa mengklaim keadaan layanan saat ini. |

## Pemeriksaan

- Tautan lokal pada dokumentasi Capstone diperiksa terhadap berkas di workspace.
- Versi Dompdf dicocokkan dengan paket terpasang; versi CDN dicocokkan dengan URL di template.
- Suite regresi `php tests/regresi.php` tetap lulus: **17 LOLOS, 0 GAGAL**.
