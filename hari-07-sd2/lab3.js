// Pencarian linear: O(n), tidak perlu terurut
function cariLinear(daftar, target) {
for (let i = 0; i < daftar.length; i++) {
if (daftar[i] === target) return i;
}
return -1;
}
// Pencarian biner: O(log n), WAJIB terurut
function cariBiner(daftarUrut, target) {
let kiri = 0;
let kanan = daftarUrut.length - 1;
while (kiri <= kanan) {
const tengah = Math.floor((kiri + kanan) / 2);
if (daftarUrut[tengah] === target) return tengah;
if (daftarUrut[tengah] < target) kiri = tengah + 1;
else kanan = tengah - 1;
}
return -1;
}
// Bubble sort: O(n^2), sederhana untuk belajar
function bubbleSort(daftar) {
const hasil = [...daftar];
for (let i = 0; i < hasil.length - 1; i++) {
let adaTukar = false;
for (let j = 0; j < hasil.length - 1 - i; j++) {
if (hasil[j] > hasil[j + 1]) {
[hasil[j], hasil[j + 1]] = [hasil[j + 1], hasil[j]];
adaTukar = true;
}
}
if (!adaTukar) break;
}
return hasil;
}
// Merge sort: O(n log n), membagi lalu menggabungkan
function mergeSort(daftar) {
if (daftar.length <= 1) return daftar;
const tengah = Math.floor(daftar.length / 2);
return gabung(mergeSort(daftar.slice(0, tengah)), mergeSort(daftar.slice(tengah)));
}
function gabung(kiri, kanan) {
const hasil = [];
let i = 0;
let j = 0;
while (i < kiri.length && j < kanan.length) {
hasil.push(kiri[i] <= kanan[j] ? kiri[i++] : kanan[j++]);
}
return hasil.concat(kiri.slice(i), kanan.slice(j));
}

//implementasi
const arrayKosong = [];
const arraySatuElemen = [5];
const arrayTerurut = [1,2,3,4,5];
const arrayTerbalik = [5,4,3,2,1];
const arrayDuplikat = [3,1,2,3,4,1];
console.log("CariLinear:", cariLinear(arrayTerurut, 3)); //2
console.log("cariBiner", cariBiner(arrayTerurut, 3)); //2
console.log("bubbleSort", bubbleSort(arrayTerbalik)); // [1,2,3,4,5]
console.log("bubbleSort", bubbleSort(arrayDuplikat)); // [1,2,3,3,4,]
console.log("mergeSort", mergeSort(arrayTerbalik)); // [1,2,3,4,5]
console.log("mergeSort", mergeSort(arrayDuplikat)); // [1,2,2,3,3,4]


//Ukur bubbleSort vs mergeSort vs Array.sort untuk 10.000 dan 100.000 data; isi tabel waktu dan jelaskan hasilnya dengan Big-O.
const data10000 = Array.from({ length: 10000 }, () => Math.floor(Math.random() * 10000));
const data100000 = Array.from({ length: 100000 }, () => Math.floor(Math.random() * 100000));
console.time("Bubble Sort 10k");
bubbleSort(data10000);
console.timeEnd("Bubble Sort 10k");
console.time("Merge Sort 10k");
mergeSort(data10000);
console.timeEnd("Merge Sort 10k");
console.time("Array.sort 10k");
data10000.slice().sort((a, b) => a - b);
console.timeEnd("Array.sort 10k");
console.time("Bubble Sort 100k");
bubbleSort(data100000);
console.timeEnd("Bubble Sort 100k");
console.time("Merge Sort 100k");
mergeSort(data100000);
console.timeEnd("Merge Sort 100k");
console.time("Array.sort 100k");
data100000.slice().sort((a, b) => a - b);
console.timeEnd("Array.sort 100k"); 
