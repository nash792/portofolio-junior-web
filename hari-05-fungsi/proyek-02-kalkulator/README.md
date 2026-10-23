# Proyek 02: Kalkulator dan Validasi Form

Folder ini berisi dua contoh aplikasi web sederhana yang menggunakan fungsi dan modul JavaScript:

- **Kalkulator** — melakukan operasi aritmetika dasar.
- **Validator** — memeriksa data pada formulir pendaftaran.

## Teknologi

- HTML
- CSS
- JavaScript dengan ES Modules

## Menjalankan Aplikasi

Karena JavaScript menggunakan ES Modules, jalankan halaman melalui server web lokal, bukan dengan membuka file HTML langsung.

1. Buka terminal di folder `proyek-02-kalkulator`.
2. Jalankan server lokal, misalnya dengan Python:

   ```bash
   py -m http.server 8000
   ```

3. Buka salah satu alamat berikut di browser:
   - Kalkulator: <http://localhost:8000/kalkulator/>
   - Validator: <http://localhost:8000/validator/>
4. Hentikan server dengan menekan `Ctrl+C` di terminal.

## Kalkulator

Kalkulator menerima angka desimal dan menyediakan operasi penjumlahan (`+`), pengurangan (`-`), perkalian (`x`), serta pembagian (`/`). Tombol `C` menghapus perhitungan, sedangkan `=` menampilkan hasil. Pembagian dengan nol menampilkan pesan kesalahan.

Logika operasi berada di `kalkulator/js/operasi.js` dan interaksi tombol serta layar berada di `kalkulator/js/app.js`.

## Validator Form

Formulir pendaftaran memeriksa lima isian:

| Isian | Aturan |
| --- | --- |
| Nama | Minimal 3 karakter setelah spasi di awal dan akhir diabaikan |
| Email | Mengikuti pola alamat email sederhana |
| Nomor HP | Diawali `08` dan terdiri dari 10–13 digit |
| Sandi | Minimal 8 karakter serta mengandung huruf dan angka |
| Konfirmasi sandi | Harus sama dengan sandi |

Pesan validasi ditampilkan di dekat isian terkait. Setelah formulir valid dikirim, halaman menampilkan ringkasan pendaftaran.

Aturan validasi berada di `validator/js/aturan.js`, sedangkan pemeriksaan form dan penanganan pengiriman berada di `validator/js/app.js`.

## Struktur Folder

```text
proyek-02-kalkulator/
├── kalkulator/
│   ├── index.html
│   ├── css/
│   │   └── style.css
│   └── js/
│       ├── app.js
│       └── operasi.js
├── validator/
│   ├── index.html
│   ├── css/
│   │   └── style.css
│   └── js/
│       ├── app.js
│       └── aturan.js
└── README.md
```
