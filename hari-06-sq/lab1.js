const peserta = [
  { id: 1, nama: 'Sari', kelas: 'Web', nilai: 90, aktif: true },
  { id: 2, nama: 'Budi', kelas: 'Web', nilai: 68, aktif: true },
  { id: 3, nama: 'Citra', kelas: 'Data', nilai: 82, aktif: false },
  { id: 4, nama: 'Suti', kelas: 'Web', nilai: 80, aktif: true },
  { id: 5, nama: 'Buddha', kelas: 'Web', nilai: 78, aktif: true },
  { id: 6, nama: 'Cindy', kelas: 'Data', nilai: 92, aktif: false },
  { id: 7, nama: 'Dian', kelas: 'Data', nilai: 87, aktif: false },
  { id: 8, nama: 'Sanji', kelas: 'Web', nilai: 70, aktif: true },
  { id: 9, nama: 'Bana', kelas: 'Web', nilai: 78, aktif: true },
  { id: 10, nama: 'Kiko', kelas: 'Data', nilai: 72, aktif: false }
];
function pesertaAktif(data) {
  return data.filter(p => p.aktif === true);
}

// Pengujian
console.log(pesertaAktif(peserta));

function urutkanNama(data) {
  return data.slice().sort((a, b) =>
    a.nama.localeCompare(b.nama)
  );
}

// Pengujian
const hasilUrut = urutkanNama(peserta);

console.log(hasilUrut.map(p => p.nama));
console.log(peserta.map(p => p.nama)); // Array asli

function cariPeserta(data, id) {
  const hasil = data.find(p => p.id === id);

  if (!hasil) {
    return `Peserta dengan ID ${id} tidak ditemukan`;
  }

  return hasil;
}

// Pengujian: ID ditemukan
console.log(cariPeserta(peserta, 3));

// Pengujian: ID tidak ditemukan
console.log(cariPeserta(peserta, 99));

function hitungPerKelas(data) {
  const jumlah = {};

  data.forEach(p => {
    if (jumlah[p.kelas] === undefined) {
      jumlah[p.kelas] = 0;
    }

    jumlah[p.kelas]++;
  });

  return jumlah;
}

// Pengujian
console.log(hitungPerKelas(peserta));


function kelolaPeserta(data) {
  // Salin array agar data awal tidak berubah
  let hasil = data.slice();

  // A. Tambah peserta
  hasil.push({
    id: 11,
    nama: 'Tina',
    kelas: 'Data',
    nilai: 89,
    aktif: true
  });

  console.log('Setelah tambah:', hasil);

  // B. Ubah nilai peserta dengan ID 2
  const pesertaUbah = hasil.find(p => p.id === 2);

  if (pesertaUbah) {
    pesertaUbah.nilai = 75;
    pesertaUbah.aktif = false;
  }

  console.log('Setelah ubah:', hasil);

  // C. Hapus peserta dengan ID 3
  hasil = hasil.filter(p => p.id !== 3);

  console.log('Setelah hapus:', hasil);

  return hasil;
}

// Pengujian
const hasilAkhir = kelolaPeserta(peserta);

console.log('Hasil akhir:', hasilAkhir);


function indeksPeserta(data) {
  return data.reduce((indeks, p) => {
    indeks[p.id] = p;
    return indeks;
  }, {});
}

// Pengujian
const pesertaById = indeksPeserta(peserta);

// Pencarian langsung berdasarkan ID
console.log(pesertaById[3]);
console.log(pesertaById[10]);
console.log(pesertaById[99]); // undefined


