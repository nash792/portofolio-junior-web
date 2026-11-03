# Library yang Digunakan

Dokumen ini mencatat library yang benar-benar dimuat aplikasi serta satu
alternatif PDF yang tidak digunakan. Library antarmuka dimuat dari CDN;
Dompdf dimuat melalui `vendor/autoload.php`.

## Library runtime

| Library | Versi yang dipakai | Area | Pemakaian |
|---|---:|---|---|
| Bootstrap | 5.3.3 | Antarmuka | CSS komponen dan JavaScript bundle dimuat dari jsDelivr di `templates/header.php` dan `templates/footer.php`. |
| SweetAlert2 | 11.x | Antarmuka | Toast flash dan konfirmasi hapus; dimuat dari jsDelivr. URL CDN tidak mengunci patch version. |
| jQuery | 3.7.1 | JavaScript | Dependensi DataTables; dimuat dari `code.jquery.com`. |
| DataTables | 1.13.8 | Tabel data | Pengurutan dan pencarian tabel admin; dimuat dari CDN bersama integrasi Bootstrap 5. |
| Dompdf | 3.1.6 | Backend / PDF | Merender template bukti pendaftaran menjadi PDF A5; dimuat dari `vendor/autoload.php`. |

Versi Dompdf di atas berasal dari paket yang terpasang dalam `hari-12-dokum/vendor/`. Versi library CDN diverifikasi dari URL yang tercantum di template aplikasi.

## Alternatif yang tidak digunakan

| Library | Keputusan | Alasan |
|---|---|---|
| FPDF | Tidak digunakan | Pembuatan bukti saat ini menggunakan Dompdf untuk merender template HTML. |

Periksa versi dan sumber CDN sebelum deployment; versi library yang dimuat dari URL tanpa patch version dapat berubah tanpa perubahan kode aplikasi.
