# Panduan Pengguna

## Peserta
1. Buka `public/tambah.php` atau pilih menu **Tambah**.
2. Isi nama, email, nomor HP, alamat, dan pilih kelas.
3. Tekan **Simpan**. Jika data valid dan kuota tersedia, pendaftaran disimpan dan aplikasi menampilkan pesan sukses.
4. Untuk melihat atau mencetak bukti PDF, admin perlu membuka panel admin dan memilih **Cetak** pada data pendaftar.

## Admin
1. Admin dibuat oleh operator melalui perintah CLI di README.
2. Buka `public/login.php`, masukkan username dan password.
3. Buka **Daftar** untuk masuk ke panel `public/admin.php`; gunakan pencarian untuk menemukan nama.
4. Gunakan **Ubah**, **Cetak**, atau **Hapus** pada baris peserta. Penghapusan meminta konfirmasi.
5. Gunakan **Logout** untuk mengakhiri sesi admin.

## Catatan
Jika muncul pesan konfigurasi, pastikan `config/config.php` sudah dibuat. Jika kuota penuh, pilih kelas lain. Jangan membagikan kredensial admin. Lihat [`no4.md`](../../no4.md) untuk tautan repositori, tangkapan layar, dan catatan uji instalasi dari nol.
