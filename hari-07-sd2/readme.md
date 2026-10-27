# Hari 07 - Struktur Data II

Folder ini berisi latihan lanjutan JavaScript tentang struktur data, algoritma pencarian dan pengurutan, serta penerapan clean code. Materi utamanya meliputi linked list, queue, tree, graph, dan binary search tree. Folder ini juga memuat Proyek 3 berupa simulator antrean dan editor catatan dengan Undo/Redo.

## Tujuan Pembelajaran

- Memahami operasi dasar linked list dan queue berbasis linked list.
- Memahami struktur tree, binary search tree, dan graph.
- Menerapkan pencarian linear dan biner serta algoritma pengurutan.
- Membandingkan kompleksitas dan waktu eksekusi algoritma.
- Mengenali perbedaan kode yang sulit dirawat dan kode yang lebih bersih.
- Menggunakan stack dan queue dalam aplikasi sederhana.

## Materi dan Berkas

| Berkas | Isi |
|---|---|
| `struktur.js` | Implementasi `LinkedList`, `LinkedQueue`, `Stack`, `Queue`, dan `BinarySearchTree`. |
| `lab1.js` | Latihan linked list dan linked queue, termasuk perbandingan queue berbasis array dengan linked queue. |
| `lab2.js` | Latihan tree, binary search tree, graph, BFS, DFS, dan pencarian jarak terpendek. |
| `lab3.js` | Pencarian linear dan biner, bubble sort, merge sort, serta pengukuran waktu sorting. |
| `lab4.js` | Contoh kode yang perlu diperbaiki dan latihan menulis ulang kode agar lebih mudah dibaca. |
| `kode-buruk.js` | Contoh kode awal dengan penamaan dan pola yang sengaja kurang baik untuk ditinjau. |
| `kode-bersih.js` | Contoh versi lebih rapi dengan nama yang jelas, konstanta, fungsi terpisah, dan penanganan array kosong. |
| `lab5.js` | Contoh konfigurasi ESLint untuk aturan dasar kualitas kode. |
| `.prettierrc` | Pengaturan format kode Prettier. |
| `package.json` | Konfigurasi proyek Node.js bertipe ES module beserta dependensi pengembangan. |
| `proyek-03-antrian/` | Simulator antrean pasien dan editor catatan dengan Undo/Redo. |

## Menjalankan Latihan

Pastikan Node.js sudah terpasang, lalu buka terminal di folder `hari-07-sd2`. Jalankan latihan yang diinginkan, misalnya:

```bash
node lab1.js
node lab2.js
node lab3.js
node kode-bersih.js
```

Setiap berkas latihan dapat dijalankan secara terpisah. `lab1.js` dan `lab2.js` mengimpor struktur data dari `struktur.js`; keduanya harus tetap berada dalam folder yang sama. Folder ini menggunakan ES modules melalui pengaturan `"type": "module"` di `package.json`.

> Catatan: `lab3.js` juga menjalankan benchmark bubble sort pada 100.000 data. Karena kompleksitas bubble sort adalah O(n²), bagian ini dapat memerlukan waktu lama. Hasil pengukuran bergantung pada perangkat dan tidak selalu sama.

## Menjalankan Proyek 3

Proyek berada di [proyek-03-antrian/](./proyek-03-antrian/). Buka `index.html` melalui ekstensi Live Server di Visual Studio Code, atau jalankan server lokal dari folder proyek:

```bash
python -m http.server 8000
```

Kemudian buka `http://localhost:8000` di browser. Proyek menggunakan JavaScript ES modules, jadi jalankan melalui server lokal, bukan dengan membuka berkas menggunakan URL `file://`.

Fitur proyek:

- Membuat nomor antrean berurutan dan memanggilnya dengan prinsip FIFO.
- Menampilkan antrean yang menunggu dan lima nomor terakhir yang dipanggil.
- Mengelola catatan dengan dua stack untuk Undo dan Redo.
- Menyimpan catatan secara otomatis di `localStorage`.

## Konsep Kompleksitas

| Operasi/algoritma | Kompleksitas umum | Catatan |
|---|---:|---|
| `LinkedQueue` enqueue/dequeue | O(1) | Menambah di tail dan menghapus dari head. |
| Array `shift()` | O(n) | Elemen yang tersisa perlu digeser. |
| Pencarian linear | O(n) | Dapat digunakan pada data yang belum terurut. |
| Pencarian biner | O(log n) | Data harus sudah terurut. |
| Bubble sort | O(n²) | Sederhana untuk dipelajari, kurang sesuai untuk data besar. |
| Merge sort | O(n log n) | Membagi data lalu menggabungkan hasil yang terurut. |
| BFS/DFS | O(V + E) | `V` adalah jumlah simpul dan `E` jumlah sisi pada graph. |

## Catatan

- File latihan berisi kode demonstrasi dan output melalui terminal; sebagian bukan aplikasi siap produksi.
- `kode-buruk.js` sengaja menampilkan pola yang perlu diperbaiki. Gunakan sebagai bahan belajar, bukan sebagai contoh gaya penulisan.
- Waktu benchmark dapat berbeda-beda tergantung lingkungan eksekusi.
- Perintah `npm test` belum dikonfigurasi sebagai pengujian dan saat ini hanya menampilkan pesan bahwa test belum tersedia.
