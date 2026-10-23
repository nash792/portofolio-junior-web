# Pengolah Nilai Siswa

## Deskripsi

**Pengolah Nilai Siswa** adalah program berbasis terminal yang dibuat menggunakan JavaScript (Node.js) untuk mengelola nilai siswa. Program ini memungkinkan pengguna memasukkan data siswa, melihat statistik nilai kelas, serta menampilkan grade dan status kelulusan setiap siswa.

## Fitur

- **Input Nilai Siswa** — Memasukkan nama dan nilai siswa.
- **Statistik Nilai** — Menampilkan rata-rata kelas, nilai tertinggi, nilai terendah, jumlah siswa lulus, dan jumlah siswa tidak lulus.
- **Predikat Siswa** — Menampilkan nama, nilai, grade, dan status kelulusan setiap siswa.
- **Validasi Input** — Memastikan nama tidak kosong dan nilai berupa angka dalam rentang 0–100.
- **Menu Interaktif** — Menyediakan pilihan menu melalui terminal hingga pengguna memilih keluar.

## Teknologi

- JavaScript
- Node.js
- Modul bawaan `readline/promises`

## Persyaratan

Pastikan Node.js sudah terinstal di komputer.

Periksa instalasi dengan perintah:

```bash
node --version
```

## Cara Menjalankan

1. Simpan file program dengan nama `nilai.js`.
2. Buka terminal pada direktori tempat file disimpan.
3. Jalankan perintah berikut:

```bash
node nilai.js
```

4. Pilih menu sesuai kebutuhan.

## Menu Program

| Pilihan | Fungsi                       |
| ------- | ---------------------------- |
| 1       | Input nilai siswa            |
| 2       | Tampilkan statistik          |
| 3       | Tampilkan predikat per siswa |
| 4       | Keluar dari program          |

## Aturan Penilaian

### Grade

| Rentang Nilai | Grade |
| ------------- | ----- |
| 85–100        | A     |
| 70–84,99      | B     |
| 55–69,99      | C     |
| 0–54,99       | D     |

### Status Kelulusan

| Rentang Nilai | Status      |
| ------------- | ----------- |
| 70–100        | Lulus       |
| 0–69,99       | Tidak Lulus |

**Catatan:** Nilai minimal untuk dinyatakan lulus adalah 70. Nilai harus berupa angka antara 0 dan 100, sedangkan nama siswa tidak boleh kosong.

## Statistik yang Ditampilkan

Program menghitung dan menampilkan:

- Rata-rata nilai seluruh siswa, dengan dua angka di belakang koma.
- Nilai tertinggi.
- Nilai terendah.
- Jumlah siswa yang lulus.
- Jumlah siswa yang tidak lulus.

Statistik hanya dapat ditampilkan jika sudah ada data siswa yang dimasukkan.

## Contoh Penggunaan

```text
===== PENGOLAH NILAI =====
1. Input nilai siswa
2. Tampilkan statistik
3. Tampilkan predikat per siswa
4. Keluar

Pilih menu (1-4): 1
Nama siswa: Andi
Nilai (0-100): 90
Data siswa Andi berhasil ditambahkan.
```

Contoh hasil predikat siswa:

```text
--- DAFTAR PREDIKAT SISWA ---
1. Andi | Nilai: 90 | Grade: A | Status: Lulus
```

## Struktur Program

- `NILAI_MIN` dan `NILAI_MAKS`: Menentukan batas nilai yang diperbolehkan.
- `BATAS_LULUS`: Menentukan nilai minimal kelulusan.
- `BATAS_GRADE_A`, `BATAS_GRADE_B`, dan `BATAS_GRADE_C`: Menentukan batas setiap grade.
- `
