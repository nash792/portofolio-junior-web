<?php
declare(strict_types=1);
/**
 * mengambil data admin dari database berdasarkan username.
 * @param PDO $pdo Koneksi database aktif.
 * @param string $username Username admin.
 * @return array<string, mixed>|null Baris admin, atau null bila tidak ditemukan.
 */
function cariAdmin(PDO $pdo, string $username): ?array
{
$stmt = $pdo->prepare('SELECT id, username, password_hash FROM admin WHERE
username = :u');
$stmt->execute(['u' => $username]);
$baris = $stmt->fetch();
return $baris === false ? null : $baris;
}
/**
 * memproses login admin dengan memverifikasi username dan kata sandi.
 * @param PDO $pdo Koneksi database aktif.
 * @param string $username Username admin.
 * @param string $sandi Kata sandi admin.
 * @return bool true jika login berhasil, false jika gagal.
 */
function prosesLogin(PDO $pdo, string $username, string $sandi): bool
{
$admin = cariAdmin($pdo, $username);
if ($admin === null || !password_verify($sandi, $admin['password_hash'])) {
return false;
}
session_regenerate_id(true);
$_SESSION['admin_id'] = (int) $admin['id'];
return true;
}
function wajibLogin(): void
{
if (empty($_SESSION['admin_id'])) {
redirect('login.php');
}
}
function logout(): void
{
$_SESSION = [];
if (ini_get('session.use_cookies')) {
$p = session_get_cookie_params();
setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'],
$p['secure'], $p['httponly']);
}
session_destroy();
}
