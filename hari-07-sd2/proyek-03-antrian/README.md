# Proyek 3 — Simulator Antrean dan Riwayat

Implementasi PBL Hari 7: simulator antrean pasien klinik dan editor catatan dengan Undo/Redo.

## Fitur

### A. Antrean loket
- **Ambil Nomor** menghasilkan nomor berurutan (`A001`, `A002`, dan seterusnya).
- **Panggil Berikutnya** menggunakan prinsip FIFO (First In, First Out).
- Menampilkan jumlah antrean dan daftar pasien yang menunggu.
- Menampilkan lima nomor terakhir yang dipanggil.
- Tombol **Reset** meminta konfirmasi terlebih dahulu.
- Jika antrean kosong, aplikasi menampilkan pesan yang jelas.

### B. Editor catatan
- Menggunakan dua stack: undo dan redo.
- Tombol Undo/Redo otomatis nonaktif ketika tidak tersedia.
- Maksimal 50 langkah riwayat untuk masing-masing stack.
- Mengetik setelah Undo menghapus riwayat Redo.
- Catatan terakhir disimpan menggunakan `localStorage`.

## Cara menjalankan

1. Ekstrak folder proyek.
2. Buka folder `proyek-3-antrian` di Visual Studio Code.
3. Jalankan `index.html` melalui ekstensi **Live Server**.
4. Alternatif: jalankan server lokal dari folder proyek dengan Python:
   ```bash
   python -m http.server 8000
   ```
   Kemudian buka `http://localhost:8000` di browser.

> Karena proyek memakai JavaScript ES Modules, jangan membuka `index.html` langsung melalui URL `file://`. Gunakan Live Server atau server lokal.

## Struktur berkas

```text
proyek-3-antrian/
├── index.html
├── css/
│   └── style.css
├── js/
│   ├── structures.js
│   ├── antrian.js
│   ├── riwayat.js
│   └── app.js
└── README.md
```

## Alasan pemilihan struktur data

| Kebutuhan | Struktur dipilih | Alasan | Alternatif dan mengapa tidak dipilih |
|---|---|---|---|
| Antrean pasien | `LinkedQueue` berbasis `LinkedList` | `enqueue` dan `dequeue` O(1), sesuai urutan FIFO. | Array dengan `shift()` dapat memerlukan O(n) karena elemen harus digeser. |
| Riwayat Undo/Redo | Dua `Stack` | Perubahan terbaru dibatalkan atau diterapkan kembali lebih dahulu (LIFO). | Queue tidak sesuai karena mengeluarkan item paling lama lebih dahulu. |
| Lima panggilan terakhir | Array dengan panjang dibatasi | Sederhana, mudah diurutkan dari panggilan terbaru, dan hanya menyimpan lima item. | Linked list bisa digunakan, tetapi berlebihan untuk riwayat kecil yang dibatasi. |

## Kasus uji manual sesuai modul

1. Klik **Ambil Nomor** tiga kali. Daftar seharusnya berisi `A001`, `A002`, `A003`.
2. Klik **Panggil Berikutnya** empat kali. Nomor dipanggil berurutan; panggilan keempat menampilkan pesan antrean kosong.
3. Ketik teks catatan, lalu tekan Undo tiga kali dan Redo dua kali. Isi catatan berubah mengikuti riwayat.
4. Setelah Undo, ketik teks baru. Tombol Redo harus kembali nonaktif karena cabang riwayat lama dibuang.
5. Tambahkan beberapa nomor lalu klik Reset. Dialog konfirmasi muncul; setelah disetujui antrean dan riwayat panggilan kosong kembali.
6. Muat ulang halaman. Catatan terakhir tetap ada karena disimpan di `localStorage`.

## Catatan implementasi dan clean code

- `structures.js` tidak mengakses DOM dan menggunakan private field (`#`) untuk enkapsulasi.
- `LinkedQueue` memakai linked list sehingga penambahan dan pengambilan dari ujung antrean berjalan O(1).
- Nama kelas, fungsi, konstanta, dan variabel dibuat deskriptif.
- Konstanta `MAKS_RIWAYAT`, `AWALAN_NOMOR`, dan batas riwayat panggilan diberi nama.
- Fungsi UI dipisah dari logika antrean dan struktur data.
- Elemen daftar dibuat dengan `textContent`, bukan memasukkan input pengguna sebagai HTML.
- Penanganan kondisi kosong diberikan pada antrean, Undo, dan Redo.

## ESLint dan Prettier (opsional)

Jalankan perintah berikut dari folder proyek:

```bash
npm init -y
npm install --save-dev eslint @eslint/js prettier
```

Tambahkan `"type": "module"` pada `package.json`, lalu buat `eslint.config.js`:

```js
import js from '@eslint/js';

export default [
  js.configs.recommended,
  {
    languageOptions: {
      ecmaVersion: 2022,
      sourceType: 'module',
      globals: {
        document: 'readonly',
        window: 'readonly',
        localStorage: 'readonly',
        console: 'readonly',
      },
    },
    rules: {
      eqeqeq: 'error',
      'no-var': 'error',
      'prefer-const': 'warn',
      'no-unused-vars': 'warn',
    },
  },
];
```

Buat `.prettierrc`:

```json
{
  "singleQuote": true,
  "semi": true,
  "tabWidth": 2
}
```

Periksa dan format kode:

```bash
npx eslint js
npx prettier --write index.html css js README.md eslint.config.js
```

## Bukti portofolio yang perlu dilengkapi

Modul meminta tangkapan layar aplikasi dan bukti pengujian. Setelah menjalankan proyek, ambil tangkapan layar tampilan antrean dan editor catatan, lalu tambahkan ke laporan/README jika diminta instruktur. Hasil ESLint/Prettier juga perlu dijalankan pada komputer peserta dan dicatat berdasarkan hasil sebenarnya.
