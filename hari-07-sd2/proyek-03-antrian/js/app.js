import { PengelolaAntrian } from './antrian.js';
import { EditorRiwayat } from './riwayat.js';

const KUNCI_CATATAN = 'simulator-antrean-catatan';
const antrian = new PengelolaAntrian();
const catatanTersimpan = localStorage.getItem(KUNCI_CATATAN) ?? '';
const editor = new EditorRiwayat(catatanTersimpan);

const elemen = {
  nomorDipanggil: document.querySelector('#nomorDipanggil'),
  pesanAntrean: document.querySelector('#pesanAntrean'),
  jumlahAntrean: document.querySelector('#jumlahAntrean'),
  totalNomor: document.querySelector('#totalNomor'),
  daftarAntrean: document.querySelector('#daftarAntrean'),
  riwayatPanggilan: document.querySelector('#riwayatPanggilan'),
  catatan: document.querySelector('#catatan'),
  undo: document.querySelector('#undo'),
  redo: document.querySelector('#redo'),
  jumlahUndo: document.querySelector('#jumlahUndo'),
  jumlahRedo: document.querySelector('#jumlahRedo'),
  pesanCatatan: document.querySelector('#pesanCatatan'),
};

elemen.catatan.value = editor.getCatatan();
renderAntrean();
renderEditor();

document.querySelector('#ambilNomor').addEventListener('click', () => {
  const nomor = antrian.ambilNomor();
  elemen.pesanAntrean.textContent = `Nomor ${nomor} berhasil ditambahkan ke antrean.`;
  renderAntrean();
});

document.querySelector('#panggilNomor').addEventListener('click', () => {
  const nomor = antrian.panggilBerikutnya();
  if (nomor === undefined) {
    elemen.nomorDipanggil.textContent = '—';
    elemen.pesanAntrean.textContent = 'Antrean kosong. Ambil nomor terlebih dahulu.';
  } else {
    elemen.nomorDipanggil.textContent = nomor;
    elemen.pesanAntrean.textContent = `Silakan menuju loket, ${nomor}.`;
  }
  renderAntrean();
});

document.querySelector('#resetAntrean').addEventListener('click', () => {
  if (!window.confirm('Yakin ingin mereset antrean dan seluruh riwayat panggilan?')) return;
  antrian.reset();
  elemen.nomorDipanggil.textContent = '—';
  elemen.pesanAntrean.textContent = 'Antrean berhasil direset.';
  renderAntrean();
});

elemen.catatan.addEventListener('input', () => {
  try {
    editor.ubahCatatan(elemen.catatan.value);
    localStorage.setItem(KUNCI_CATATAN, editor.getCatatan());
    elemen.pesanCatatan.textContent = 'Perubahan catatan tersimpan.';
  } catch (error) {
    elemen.pesanCatatan.textContent = `Catatan gagal disimpan: ${error.message}`;
  }
  renderEditor();
});

elemen.undo.addEventListener('click', () => {
  const catatan = editor.undo();
  if (catatan === undefined) return;
  perbaruiTampilanCatatan(catatan, 'Perubahan terakhir dibatalkan.');
});

elemen.redo.addEventListener('click', () => {
  const catatan = editor.redo();
  if (catatan === undefined) return;
  perbaruiTampilanCatatan(catatan, 'Perubahan yang dibatalkan diterapkan kembali.');
});

document.querySelector('#hapusCatatan').addEventListener('click', () => {
  if (elemen.catatan.value === '') {
    elemen.pesanCatatan.textContent = 'Catatan sudah kosong.';
    return;
  }
  editor.ubahCatatan('');
  elemen.catatan.value = '';
  localStorage.setItem(KUNCI_CATATAN, '');
  elemen.pesanCatatan.textContent = 'Catatan dibersihkan. Gunakan Undo untuk membatalkan.';
  renderEditor();
});

function renderAntrean() {
  elemen.jumlahAntrean.textContent = antrian.jumlahMenunggu();
  elemen.totalNomor.textContent = antrian.totalNomor();
  renderDaftarAntrean();
  renderRiwayatPanggilan();
}

function renderDaftarAntrean() {
  const daftar = antrian.daftarMenunggu();
  elemen.daftarAntrean.replaceChildren();
  if (daftar.length === 0) {
    elemen.daftarAntrean.append(buatPesanKosong('Belum ada pasien dalam antrean.'));
    return;
  }

  daftar.forEach((nomor, index) => {
    const item = document.createElement('li');
    const nomorTeks = document.createElement('span');
    const posisiTeks = document.createElement('span');
    nomorTeks.className = 'ticket-id';
    nomorTeks.textContent = nomor;
    posisiTeks.className = 'ticket-position';
    posisiTeks.textContent = `Urutan ${index + 1}`;
    item.append(nomorTeks, posisiTeks);
    elemen.daftarAntrean.append(item);
  });
}

function renderRiwayatPanggilan() {
  const riwayat = antrian.riwayatPanggilan();
  elemen.riwayatPanggilan.replaceChildren();
  if (riwayat.length === 0) {
    elemen.riwayatPanggilan.append(buatPesanKosong('Belum ada riwayat panggilan.'));
    return;
  }

  riwayat.forEach((nomor) => {
    const item = document.createElement('li');
    item.textContent = nomor;
    elemen.riwayatPanggilan.append(item);
  });
}

function buatPesanKosong(pesan) {
  const item = document.createElement('li');
  item.className = 'empty-state';
  item.textContent = pesan;
  return item;
}

function perbaruiTampilanCatatan(catatan, pesan) {
  elemen.catatan.value = catatan;
  localStorage.setItem(KUNCI_CATATAN, catatan);
  elemen.pesanCatatan.textContent = pesan;
  renderEditor();
}

function renderEditor() {
  elemen.undo.disabled = !editor.bisaUndo();
  elemen.redo.disabled = !editor.bisaRedo();
  elemen.jumlahUndo.textContent = editor.jumlahUndo();
  elemen.jumlahRedo.textContent = editor.jumlahRedo();
}
