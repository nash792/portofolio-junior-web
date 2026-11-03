# Peta Modul

Dokumen ini mencatat berkas di `src/` dan `public/`, tanggung jawabnya, serta fungsi publik yang dideklarasikan. Fungsi publik berarti fungsi yang dapat dipanggil dari berkas PHP lain setelah berkasnya dimuat. Endpoint dan aset di `public/` umumnya menjalankan alur langsung, bukan mendeklarasikan fungsi.

## `src/`

| Berkas | Tanggung jawab | Fungsi publik |
|---|---|---|
| `src/bootstrap.php` | Memulai sesi, memuat konfigurasi dan modul aplikasi, mengatur pelaporan error serta penanganan exception umum. | Tidak ada. |
| `src/helpers.php` | Menyediakan helper output aman, redirect, token CSRF, flash message, dan pemeriksaan autentikasi admin. | `e()`, `redirect()`, `tokenCsrf()`, `cekCsrf()`, `setFlash()`, `ambilFlash()`, `cekLoginAdmin()` |
| `src/pendaftar.php` | Mengakses data kelas dan pendaftar, memvalidasi input, menjalankan CRUD, memeriksa kuota dalam transaksi, mengambil data bukti pendaftaran, dan mendefinisikan exception untuk kondisi kuota penuh. | `daftarKelas()`, `hitungPendaftar()`, `ambilPendaftar()`, `ambilPendaftarById()`, `emailSudahAda()`, `validasiPendaftar()`, `tambahPendaftar()`, `ubahPendaftar()`, `ubahPendaftarDenganKuota()`, `hapusPendaftar()`, `ambilBuktiPendaftar()`, `ambilSemuaPendaftar()`, `daftarkanDenganKuota()`; kelas `KuotaPenuhException` (bukan fungsi). |
| `src/auth.php` | Mencari akun admin, memverifikasi kata sandi, mengelola sesi login, dan mengakhiri sesi. | `cariAdmin()`, `prosesLogin()`, `wajibLogin()`, `logout()` |

## `public/`

| Berkas | Tanggung jawab | Fungsi publik |
|---|---|---|
| `public/index.php` | Menampilkan halaman sambutan pengguna dan memuat layout halaman. | Tidak ada; endpoint halaman. |
| `public/admin.php` | Memeriksa login admin, mengambil kata kunci dan halaman, lalu menampilkan daftar pendaftar beserta aksi ubah, cetak, dan hapus. | Tidak ada; endpoint halaman. |
| `public/tambah.php` | Memproses pendaftaran baru: validasi CSRF dan data, pemeriksaan kuota, flash message, dan redirect. | Tidak ada; endpoint aksi/formulir. |
| `public/ubah.php` | Memeriksa login admin, memuat data berdasarkan ID, lalu menangani validasi dan perubahan data dengan pemeriksaan kuota. | Tidak ada; endpoint aksi/formulir. |
| `public/hapus.php` | Memeriksa login, metode POST, dan token CSRF sebelum menghapus pendaftar. | Tidak ada; endpoint aksi. |
| `public/_form.php` | Partial formulir bersama untuk tambah dan ubah pendaftar; menampilkan pilihan kelas, nilai lama, serta pesan validasi. | Tidak ada; partial tampilan. |
| `public/cetak.php` | Memeriksa login admin, mengambil data bukti, menyusun nomor registrasi, lalu menghasilkan PDF dengan Dompdf. | Tidak ada; endpoint unduh/tampilan PDF. |
| `public/login.php` | Menampilkan formulir login admin, memproses kredensial, dan membatasi percobaan login berdasarkan penghitung sesi. | Tidak ada; endpoint halaman/aksi. |
| `public/logout.php` | Menerima POST dengan token CSRF, mengakhiri sesi, lalu mengarahkan ke halaman login. | Tidak ada; endpoint aksi. |
| `public/injeksi.php` | Halaman demonstrasi lokal yang membandingkan query SQL rentan dengan prepared statement. Gunakan hanya untuk latihan lokal. | Tidak ada; endpoint demonstrasi. |
| `public/asset/js/app.js` | Menampilkan toast flash, meminta konfirmasi sebelum penghapusan, dan menginisialisasi DataTables pada tabel pendaftar. | Tidak ada fungsi bernama yang diekspor; memasang handler saat `DOMContentLoaded`. |
| `public/asset/favicon.ico` | Ikon situs yang digunakan browser. | Tidak berlaku (aset statis). |

> Berkas tampilan yang dimuat oleh endpoint, seperti template header, footer, dan bukti, berada di luar cakupan peta ini karena permintaan hanya mencakup `src/` dan `public/`.

## Dokumentasi API

Rincian parameter, nilai balik, dan perilaku fungsi pendaftar ada di [dokumentasi modul pendaftar](modul/pendaftar.md). API autentikasi dijelaskan di [dokumentasi modul autentikasi](modul/auth.md).
