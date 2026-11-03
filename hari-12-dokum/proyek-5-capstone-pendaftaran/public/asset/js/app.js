/**
 * script utama untuk UI klien
 * dijalankan setelah seluruh html selesai dimuat
 */
document.addEventListener('DOMContentLoaded', () => {
/**  Notifikasi flash (toast)
 * @type {HTMLElement | null} flash Elemen HTML yang menampilkan pesan flash
*/
const flash = document.getElementById('flash');
if (flash) {
/**
 * @type {import(sweetalert2).SweetAlertOptions}
 * konfigurasi notifikasi toast sweetalert2
 */
Swal.fire({
toast: true,
position: 'top-end',
icon: 'success',
title: flash.dataset.pesan,
showConfirmButton: false,
timer: 3000
});
}
// Konfirmasi hapus
document.querySelectorAll('.form-hapus').forEach((form) => {
/**
 * menghentikan submit form untuk menampilkan konfirmasi hapus
 * @param {SubmitEvent} event Event submit form
 */
form.addEventListener('submit', (event) => {
event.preventDefault();
Swal.fire({
title: form.dataset.konfirmasi || 'Hapus data?',
text: `Data ${form.dataset.nama || ''} akan dihapus permanen.`,
icon: 'warning',
showCancelButton: true,
confirmButtonText: 'Ya, hapus',
cancelButtonText: 'Batal'
}).then((hasil) => {
if (hasil.isConfirmed) form.submit();
});
});
});
// DataTables (Lab 4)
const tabel = document.getElementById('tabelPendaftar');
if (tabel && window.jQuery) {
/**
 * @type {import(datatables.net).DataTables.Settings}
 * konfigurasi DataTables
 */
window.jQuery(tabel).DataTable({
pageLength: 10,
language: { url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/id.json' },
columnDefs: [{ orderable: false, targets: -1 }]
});
}
});