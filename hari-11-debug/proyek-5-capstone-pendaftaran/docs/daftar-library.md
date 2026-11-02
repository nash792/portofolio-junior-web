# Daftar dan Evaluasi Library

Dokumen ini mencatat library yang dipertimbangkan untuk mendukung pengembangan
aplikasi pendaftaran pelatihan. Daftar ini merupakan bahan evaluasi, bukan
pernyataan bahwa semua library sudah digunakan di dalam aplikasi.

## Kandidat Library

| Library     | Versi yang dicatat | Area          | Tujuan penggunaan                                                      |
| ----------- | -----------------: | ------------- | ---------------------------------------------------------------------- |
| Bootstrap   |                5.3 | Antarmuka     | Menyusun tampilan responsif dan komponen antarmuka.                    |
| SweetAlert2 |                 11 | Antarmuka     | Menampilkan dialog, konfirmasi, dan notifikasi yang lebih informatif.  |
| jQuery      |                3.7 | JavaScript    | Membantu manipulasi DOM dan penggunaan plugin yang memerlukannya.      |
| DataTables  |   Belum ditentukan | Tabel data    | Menambahkan fitur pengelolaan tabel, seperti pencarian dan pengurutan. |
| Dompdf      |   Belum ditentukan | Backend / PDF | Membuat dokumen PDF dari HTML.                                         |
| FPDF        |   Belum ditentukan | Backend / PDF | Membuat dokumen PDF melalui API PHP.                                   |

> Versi pada tabel adalah catatan awal. Sebelum instalasi, verifikasi versi
> terbaru yang stabil, kebutuhan runtime, dan kompatibilitasnya dengan proyek.

## Kriteria Evaluasi

Gunakan pertanyaan berikut untuk menilai setiap kandidat sebelum dipilih.

| Kriteria                  | Pertanyaan evaluasi                                                                                               |
| ------------------------- | ----------------------------------------------------------------------------------------------------------------- |
| Kesesuaian kebutuhan      | Apakah library menyelesaikan kebutuhan proyek tanpa menambahkan fitur yang tidak diperlukan?                      |
| Lisensi                   | Apakah ketentuan lisensinya sesuai dengan tujuan dan distribusi proyek?                                           |
| Pemeliharaan              | Kapan rilis atau perbaikan terakhir? Apakah proyek masih aktif dan bagaimana kondisi isu terbukanya?              |
| Popularitas dan komunitas | Apakah tersedia dokumentasi, contoh penggunaan, dan dukungan komunitas yang memadai?                              |
| Kompatibilitas            | Apakah versi yang dipilih mendukung versi PHP dan browser yang digunakan? Apakah ada konflik dengan library lain? |
| Keamanan                  | Apakah ada kerentanan yang diketahui? Apakah praktik pemeliharaan dan keamanan proyek dapat dipercaya?            |
| Ukuran dan performa       | Berapa dampak ukuran unduhan dan waktu muat? Apakah library membutuhkan dependensi tambahan?                      |
| Kemudahan migrasi         | Jika library tidak lagi dipelihara, seberapa sulit menggantinya dengan alternatif lain?                           |

## Catatan Pemilihan

- Pilih library hanya jika manfaatnya sepadan dengan biaya pemeliharaan dan
  dependensi yang ditambahkan.
- Hindari memasang dua library untuk kebutuhan yang sama tanpa alasan yang jelas.
- Catat versi yang benar-benar digunakan beserta alasan pemilihannya setelah
  evaluasi selesai.
- Periksa dokumentasi dan informasi keamanan resmi sebelum memperbarui versi.

## Hasil Evaluasi

Lengkapi bagian ini saat keputusan penggunaan dibuat.

| Library     | Keputusan        | Alasan / catatan |
| ----------- | ---------------- | ---------------- |
| Bootstrap   | Belum dievaluasi | —                |
| SweetAlert2 | Belum dievaluasi | —                |
| jQuery      | Belum dievaluasi | —                |
| DataTables  | Belum dievaluasi | —                |
| Dompdf      | Belum dievaluasi | —                |
| FPDF        | Belum dievaluasi | —                |
