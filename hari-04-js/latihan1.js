//deklarasi variable
let nama = "aaa";
let umur = 20;
let tinggibadan = 1.7;
let statusaktif = true;
console.log(`Halo, ${nama}! umur ${umur} tahun.`)   
console.log(`Tinggi badan: ${tinggibadan} m, Status aktif ${statusaktif}`);  
//cek tipe data
console.log(typeof ('5' + 3));
console.log(typeof (0.1 + 0.2));
console.log(typeof (Number('abc')));
console.log(typeof (10 / 3));
console.log(typeof (10 % 3));
console.log(typeof(2 ** 10));
//mencari luas dan keliling lingkaran
let jari = 10
let luaslingkaran = Math.PI * jari ** 2;
console.log(`Luas lingkaran dengan jari-jari ${jari} adalah ${luaslingkaran}`); 
let kelilinglingkaran = 2 * Math.PI * jari;
console.log(`Keliling lingkaran dengan jari-jari ${jari} adalah ${kelilinglingkaran}`);
//konversi suhu celcius ke fahrenheit
let celcius = 100;
let fahrenheit = (celcius * 9/5) + 32;
console.log(`${celcius} derajat celcius sama dengan ${fahrenheit} derajat fahrenheit`);
//menghitung detik dalam satu hari
let detik = 24 * 60 * 60;
console.log(`Dalam satu hari terdapat ${detik} detik`);
// Program A: konversi nilai ke huruf
const nilai = Number(prompt('Nilai (0-100):'));
let grade;
if (nilai >= 85) grade = 'A';
else if (nilai >= 70) grade = 'B';
else if (nilai >= 55) grade = 'C';
else grade = 'D';
console.log(`Grade: ${grade}`);
// Program B: tahun kabisat
const tahun = Number(prompt('Tahun:'));
const kabisat = (tahun % 4 === 0 && tahun % 100 !== 0) || tahun % 400 === 0;
console.log(kabisat ? 'Kabisat' : 'Bukan kabisat');


