# Modul Autentikasi

## Informasi Umum

- **Berkas sumber:** `src/auth.php`
- **Tujuan:** Mencari akun admin, memverifikasi kata sandi, menjaga sesi autentikasi, dan mengakhiri sesi.
- **Ketergantungan utama:** Koneksi `PDO`, tabel `admin`, sesi PHP, serta helper `redirect()` dari `src/helpers.php`.
- **Pemakaian:** Fungsi modul dipanggil oleh endpoint login, logout, dan halaman yang memerlukan autentikasi admin.

## Ketergantungan dan pola penggunaan

- Fungsi menggunakan `PDO` yang diberikan oleh pemanggil; kueri akun mencari kolom `id`, `username`, dan `password_hash` pada tabel `admin`.
- `prosesLogin()` memakai `password_verify()`. Kolom `password_hash` harus berisi hash kata sandi yang dibuat dengan API hashing PHP, bukan kata sandi teks biasa.
- Modul mengakses `$_SESSION`; sesi harus sudah dimulai sebelum fungsi autentikasi dipakai. Dalam aplikasi ini `src/bootstrap.php` memulai sesi dan memuat modul.
- `wajibLogin()` bergantung pada helper `redirect()` dari `src/helpers.php`, yang mengirim browser ke `login.php` bila belum ada `admin_id` di sesi.
- Pembatasan jumlah percobaan login berada di endpoint `public/login.php`, bukan di modul ini.

## API publik

| Fungsi | Parameter | Hasil dan perilaku |
|---|---|---|
| `cariAdmin(PDO $pdo, string $username)` | Koneksi database dan username yang dicari. | Array berisi `id`, `username`, dan `password_hash`, atau `null` bila akun tidak ditemukan. Username dikirim sebagai parameter prepared statement. |
| `prosesLogin(PDO $pdo, string $username, string $sandi)` | Koneksi database, username, dan kata sandi yang dikirim pengguna. | `true` jika akun ditemukan dan kata sandi cocok; `false` jika tidak. Saat berhasil, ID sesi diregenerasi dan `$_SESSION['admin_id']` diisi dengan ID admin. |
| `wajibLogin()` | Tidak ada. | Tidak mengembalikan nilai. Jika `$_SESSION['admin_id']` kosong, mengarahkan ke `login.php` dan menghentikan alur melalui helper `redirect()`. |
| `logout()` | Tidak ada. | Mengosongkan data sesi, menghapus cookie sesi jika cookie digunakan, lalu menghancurkan sesi. Pemanggil menentukan respons/redirect setelahnya. |

## Alur umum

1. Pada POST login, endpoint memeriksa token CSRF sebelum memanggil `prosesLogin()`.
2. Jika hasilnya `true`, endpoint login menyimpan username di sesi dan mengarahkan browser ke `public/index.php`. Akses ke panel admin tetap memerlukan `wajibLogin()` pada endpoint admin.
3. Panggil `wajibLogin()` di endpoint admin sebelum menampilkan atau mengubah data yang memerlukan autentikasi.
4. Untuk logout, validasi metode POST dan token CSRF, panggil `logout()`, lalu arahkan ke halaman login.

Modul ini hanya mengelola autentikasi sesi admin; pemeriksaan otorisasi untuk setiap aksi dan perlindungan CSRF tetap menjadi tanggung jawab endpoint pemanggil.