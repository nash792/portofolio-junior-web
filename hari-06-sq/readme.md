# Hari 06 - Struktur Data (Stack & Queue)

Folder ini berisi latihan dan eksperimen JavaScript tentang struktur data dasar, terutama `Stack`, `Queue`, serta penggunaan `Map` dan `Set`. Materi ini ditujukan untuk memahami cara kerja struktur data dalam pemrograman web dan logika algoritma.

## Tujuan Pembelajaran

- Memahami konsep stack dan queue
- Menggunakan struktur data untuk memecahkan masalah sederhana
- Menerapkan `Map` dan `Set` pada data
- Membuat demo interaktif berbasis browser
- Menyelesaikan soal latihan validasi dan manipulasi data

## Materi yang Dipelajari

### 1. Stack
Stack adalah struktur data yang mengikuti prinsip LIFO (Last In, First Out). Data yang terakhir masuk akan diproses terlebih dahulu.

Contoh implementasi terdapat pada file:

- `struktur.js`
- `lab3.js`
- `validasi.js`

### 2. Queue
Queue adalah struktur data yang mengikuti prinsip FIFO (First In, First Out). Data yang pertama masuk akan diproses terlebih dahulu.

Contoh implementasi terdapat pada file:

- `struktur.js`
- `lab4.js`
- `js/antrian.js`
- `antrian.html`

### 3. Map dan Set
Map dan Set digunakan untuk mengelola data dengan cara yang lebih efisien, seperti menghitung frekuensi kata, menghilangkan duplikasi, dan mencari irisan data.

Contoh implementasi terdapat pada file:

- `lab2.js`
- `lab5.js`

### 4. Aplikasi Interaktif
Folder ini juga berisi dua demo sederhana berbasis browser:

- `antrian.html` dan `js/antrian.js`: simulasi antrean loket
- `editor.html` dan `js/editor.js`: simulator editor undo/redo

## Struktur Folder

```text
hari-06-sq/
├── antrian.html
├── editor.html
├── index.html
├── lab1.js
├── lab2.js
├── lab3.js
├── lab3.mjs
├── lab4.js
├── lab5.js
├── struktur.js
├── validasi.js
├── js/
│   ├── antrian.js
│   └── editor.js
├── package.json
└── readme.md
```

## Penjelasan File Utama

- `struktur.js` : berisi implementasi kelas `Stack` dan `Queue`
- `lab1.js` : latihan dasar array dan manipulasi data
- `lab2.js` : latihan menggunakan `Map` dan `Set`
- `lab3.js` : latihan stack dan aplikasi pada pemrosesan teks
- `lab4.js` : latihan queue dan pengujian dasar queue
- `lab5.js` : latihan optimasi performa dan struktur data
- `validasi.js` : latihan validasi logika dengan stack
- `antrian.html` : halaman simulasi antrean
- `editor.html` : halaman editor dengan fitur undo/redo
- `js/antrian.js` : logika antrean di browser
- `js/editor.js` : logika undo/redo di browser

## Cara Menjalankan

### Menjalankan file JavaScript di Node.js

Buka terminal di folder ini lalu jalankan salah satu file latihan, misalnya:

```bash
node lab1.js
```

atau

```bash
node lab2.js
```

### Menjalankan demo interaktif di browser

1. Buka file `antrian.html` di browser untuk melihat simulasi antrean.
2. Buka file `editor.html` di browser untuk melihat simulasi editor undo/redo.
3. Pastikan file JavaScript di folder `js/` terhubung dengan benar melalui tag `<script type="module">`.

## Catatan

- Beberapa file berisi latihan eksperimen dan belum sepenuhnya dibuat sebagai aplikasi siap pakai.
- Kode ini bertujuan sebagai pembelajaran dasar struktur data di JavaScript.
- Untuk pengerjaan full project, file-file di folder ini dapat dikembangkan menjadi aplikasi yang lebih kompleks.

## Contoh Konsep yang Dipelajari

- Membalik string dengan stack
- Menentukan tanda kurung seimbang
- Mengecek palindrome
- Menangani antrean pelayanan
- Mengelola riwayat perubahan pada editor
- Menghapus data duplikat dengan `Set`

## Kesimpulan

Folder `hari-06-sq` merupakan latihan penting dalam memahami konsep struktur data di JavaScript. Dengan pendekatan yang sederhana, siswa dapat melihat bagaimana data dikelola secara efisien untuk menyelesaikan beragam masalah logika dan aplikasi web.
