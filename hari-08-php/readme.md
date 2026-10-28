# Hari 08 — PHP

Folder ini berisi latihan dasar PHP, pengolahan data peserta, serta Proyek 4 berupa aplikasi buku tamu yang menyimpan data ke file JSON.

## Tujuan Pembelajaran

- Mengenal sintaks PHP, variabel, tipe data, dan penyisipan nilai PHP ke HTML.
- Menggunakan percabangan, perulangan, array, dan fungsi.
- Mengolah serta menampilkan data peserta.
- Memproses formulir dan memvalidasi input di sisi server.
- Membaca dan menulis data dengan format CSV, JSON, dan file teks.
- Mencari data dan mencatat aktivitas ke file log.

## Materi dan Berkas

| Berkas/folder | Isi |
|---|---|
| `dasar.php` | Contoh output PHP dan penggunaan tanggal/waktu server. |
| `lab1.php` | Variabel, `var_dump()`, tabel perkalian, bilangan ganjil/genap, FizzBuzz, konversi nilai ke grade, dan kalender sederhana. |
| `lab2.php` | Praktik fungsi, termasuk menghitung rata-rata, mencari nilai tertinggi, memfilter dan mengurutkan peserta, mengelompokkan berdasarkan kelas, serta menampilkan tabel. |
| `lab3.php` | Kalkulator BMI dengan validasi berat dan tinggi serta kategori hasil. |
| `cari.php` | Pencarian peserta berdasarkan nama dan pencatatan kata kunci ke `data/log.txt`. |
| `lihat-log.php` | Menampilkan hingga 20 aktivitas pencarian terbaru. |
| `peserta-csv.php` | Mengekspor data peserta ke CSV, membaca kembali file tersebut, dan menampilkan hasilnya. |
| `peserta-json.php` | Membaca data peserta JSON, memvalidasi strukturnya, dan menambahkan peserta contoh jika belum ada. |
| `data/` | File data latihan: `peserta.csv`, `peserta.json`, dan `log.txt`. Beberapa file dibuat atau diperbarui saat latihan dijalankan. |
| `proyek-4-bukutamu/` | Aplikasi buku tamu dengan validasi formulir, pencarian nama, dan penyimpanan JSON. Lihat [README Proyek 4](./proyek-4-bukutamu/README.md) untuk petunjuk khusus. |

## Persyaratan

- PHP 8.0 atau lebih baru.
- XAMPP (Apache dan PHP) atau server lokal lain yang mendukung PHP.
- Ekstensi `mbstring` aktif untuk Proyek 4.
- Izin tulis pada folder `data/` agar PHP dapat menyimpan file log dan data.

## Cara Menjalankan di XAMPP

1. Letakkan folder `hari-08-php` di dalam direktori `htdocs`.
2. Jalankan Apache dari XAMPP.
3. Buka halaman yang ingin dicoba melalui browser, misalnya:

   - `http://localhost/hari-08-php/dasar.php`
   - `http://localhost/hari-08-php/lab1.php`
   - `http://localhost/hari-08-php/lab2.php`
   - `http://localhost/hari-08-php/lab3.php`
   - `http://localhost/hari-08-php/cari.php`
   - `http://localhost/hari-08-php/peserta-csv.php`
   - `http://localhost/hari-08-php/peserta-json.php`
   - `http://localhost/hari-08-php/proyek-4-bukutamu/`

Jalankan setiap latihan secara terpisah melalui URL-nya. PHP harus diproses oleh server; jangan membuka file `.php` langsung dengan URL `file://`.

## Alur Latihan Data

- Buka `cari.php` dan masukkan nama peserta untuk mencoba pencarian. Setiap permintaan pencarian dicatat di `data/log.txt`; halaman `lihat-log.php` menampilkan catatan terbaru.
- Buka `peserta-csv.php` untuk mencoba ekspor dan impor. File `data/peserta.csv` akan ditulis ulang berdasarkan data contoh pada program.
- Buka `peserta-json.php` untuk membaca `data/peserta.json`. Jika peserta contoh belum ada, program akan menambahkannya ke file tersebut.
- Pada Proyek 4, isi formulir buku tamu. Pesan yang valid disimpan di `proyek-4-bukutamu/data/tamu.json` dan daftar tamu dapat dicari berdasarkan nama.

> **Catatan:** File di dalam `data/` dapat berubah ketika latihan dijalankan. Buat salinan terlebih dahulu jika ingin mempertahankan isi data sendiri. Proyek buku tamu juga menggunakan `data/tamu.json` yang terpisah dari data latihan utama.

## Catatan

- Kode menggunakan fitur PHP 8 seperti `match` dan tipe union.
- File latihan ditujukan untuk belajar dan demonstrasi; belum semuanya dirancang sebagai aplikasi produksi.
- Proyek 4 memiliki validasi dan pengamanan output HTML. Untuk rincian fitur, batasan, serta langkah pengujiannya, lihat README di dalam folder proyek.
