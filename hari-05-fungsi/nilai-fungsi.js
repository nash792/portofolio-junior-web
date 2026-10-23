const BATAS_LULUS = 70;
function hitungRataRata(daftar) {
if (daftar.length === 0) return 0;
return daftar.reduce((jumlah, n) => jumlah + n, 0) / daftar.length;
}
function cariTertinggi(daftar) {
return daftar.length === 0 ? null : Math.max(...daftar);
}
function cariTerendah(daftar) {
return daftar.length === 0 ? null : Math.min(...daftar);
}
function tentukanGrade(nilai) {
if (nilai >= 85) return 'A';
if (nilai >= 70) return 'B';
if (nilai >= 55) return 'C';
return 'D';
}
function tentukanStatus(nilai) {
return nilai >= BATAS_LULUS ? 'Lulus' : 'Tidak lulus';
}
function nilaiValid(nilai) {
return Number.isFinite(nilai) && nilai >= 0 && nilai <= 100;
}
console.assert(hitungRataRata([80, 90,]) === 85, 'Rata-rata harus 85');
console.assert(hitungRataRata([]) === 0, 'Rata-rata dari array kosong harus 0');
console.assert(tentukanGrade(85) === 'A', 'Grade untuk nilai 85 harus A');
console.assert(tentukanGrade(69) === 'B', 'Grade untuk nilai 69 harus B');
console.assert(nilaiValid(101) === false, '101 tidak valid');
console.assert(nilaiValid(-1) === false, '-1 tidak valid');
console.assert(nilaiValid('abc') === false, 'abc tidak valid');

console.log(hitungRataRata([80,90]));
console.log(cariTertinggi([80,90,75]));
console.log(cariTerendah([80,90,75]));
console.log(tentukanGrade(85));
console.log(tentukanStatus(85));
console.log(tentukannilaiValid (85));
