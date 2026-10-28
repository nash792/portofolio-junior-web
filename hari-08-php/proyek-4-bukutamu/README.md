# Proyek 4 — Buku Tamu Berbasis File

Aplikasi buku tamu sederhana menggunakan PHP dan JSON tanpa basis data. Pengunjung dapat mengisi nama, email, dan pesan, melihat pesan terbaru, serta mencari tamu berdasarkan nama.

## Fitur

- Formulir dengan validasi sisi server untuk nama, email, dan pesan.
- Data formulir tetap tampil ketika validasi gagal.
- Penyimpanan dan pembacaan data melalui `data/tamu.json`.
- Folder `data/` dibuat otomatis jika belum tersedia.
- Pesan terbaru ditampilkan paling atas.
- Pencarian nama menggunakan parameter GET dan tidak membedakan huruf besar/kecil.
- Output di-escape menggunakan `htmlspecialchars()` untuk mengurangi risiko XSS.
- Pola Post/Redirect/Get (PRG) setelah penyimpanan berhasil.
- Penulisan file menggunakan `LOCK_EX`.
- Perlindungan folder data melalui `.htaccess`.
- Logika dipisahkan dari tampilan melalui `functions.php`.

## Struktur folder

```text
proyek-4-buku-tamu/
├── index.php
├── functions.php
├── README.md
└── data/
    ├── .htaccess
    └── tamu.json
```

## Persyaratan

- PHP 8.0 atau lebih baru.
- Ekstensi `mbstring` aktif.
- Apache dengan dukungan `.htaccess`, atau server PHP lokal untuk pengembangan.

## Cara menjalankan

### Opsi 1 — XAMPP

1. Salin folder `proyek-4-buku-tamu` ke dalam `htdocs`.
2. Pastikan folder `data` dapat ditulis oleh PHP.
3. Jalankan Apache melalui XAMPP.
4. Buka `http://localhost/proyek-4-buku-tamu/`.

### Opsi 2 — Server bawaan PHP

Jalankan terminal dari folder proyek, lalu ketik:

```bash
php -S localhost:8000
```

Buka `http://localhost:8000/`.

> Catatan: server bawaan PHP tidak menerapkan aturan `.htaccess`. Gunakan Apache untuk menguji perlindungan direktori seperti yang diminta modul.

## Cara kerja

1. Pengunjung mengirim formulir dengan metode POST.
2. `validasiTamu()` memeriksa nama minimal 3 karakter, format email, dan pesan wajib dengan panjang maksimal 500 karakter.
3. Jika valid, `simpanTamu()` membaca JSON, menentukan ID berikutnya, menambahkan waktu, lalu menyimpan data.
4. Setelah sukses, aplikasi mengarahkan pengguna ke `index.php?status=sukses` agar refresh tidak mengirim ulang formulir.
5. `ambilSemuaTamu()` membaca JSON dan `cariTamu()` menyaring nama berdasarkan kata kunci GET.
6. Data ditampilkan dengan `e()` agar karakter khusus tidak diperlakukan sebagai HTML.

## Pengujian

- [ ] Kirim nama kurang dari 3 karakter: tampilkan pesan validasi nama.
- [ ] Kirim email tidak valid: tampilkan pesan validasi email.
- [ ] Kirim pesan kosong: tampilkan pesan validasi pesan.
- [ ] Kirim data valid: data tersimpan di `data/tamu.json`.
- [ ] Refresh setelah sukses: pesan tidak tersimpan dua kali.
- [ ] Tambahkan beberapa pesan: pesan terbaru tampil paling atas.
- [ ] Cari nama lengkap atau sebagian nama, termasuk dengan kapitalisasi berbeda.
- [ ] Cari nama yang tidak ada: tampilkan pesan bahwa hasil tidak ditemukan.
- [ ] Masukkan `<script>alert(1)</script>` pada nama atau pesan: teks harus tampil aman dan tidak dieksekusi.
- [ ] Hapus sementara `data/tamu.json`: aplikasi tetap dapat dibuka dan membuat data saat pesan baru disimpan.
- [ ] Pastikan `data/tamu.json` tidak dapat diakses langsung melalui Apache.

## Catatan keamanan dan batasan

Penyimpanan JSON cocok untuk latihan sederhana, bukan aplikasi dengan banyak penulisan bersamaan. `LOCK_EX` membantu mengunci proses penulisan file, tetapi pola baca-ubah-tulis tetap memiliki keterbatasan ketika beberapa permintaan berjalan bersamaan. Untuk aplikasi produksi, pertimbangkan basis data, pembatasan laju pengiriman, dan pengelolaan akses admin.

## Teknologi

- PHP
- HTML5
- CSS
- JSON sebagai penyimpanan file
