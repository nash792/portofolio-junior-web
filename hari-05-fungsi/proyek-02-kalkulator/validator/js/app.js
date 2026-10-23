import {
 validasiNama,
 validasiEmail,
 validasiHp,
 validasiSandi,
 validasiKonfirmasi,
} from './aturan.js';

const form = document.getElementById('form-daftar');
const tombolKirim = document.getElementById('kirim');
const ringkasan = document.getElementById('ringkasan');
const namaField = ['nama', 'email', 'hp', 'sandi', 'konfirmasi'];

const aturan = {
 nama: (nilai) => validasiNama(nilai),
 email: (nilai) => validasiEmail(nilai),
 hp: (nilai) => validasiHp(nilai),
 sandi: (nilai) => validasiSandi(nilai),
 konfirmasi: (nilai) =>
   validasiKonfirmasi(nilai, form.elements.namedItem('sandi').value),
};

function tampilkanGalat(nama, pesan) {
 document.getElementById(`galat-${nama}`).textContent = pesan;
 form.elements.namedItem(nama).setAttribute(
   'aria-invalid',
   pesan ? 'true' : 'false',
 );
}

function periksaField(nama) {
 const pesan = aturan[nama](form.elements.namedItem(nama).value);
 tampilkanGalat(nama, pesan);
 return pesan === '';
}

function semuaValid() {
 return namaField.every((nama) =>
   periksaField(nama),
 );
}

form.addEventListener('input', (event) => {
 const nama = event.target.name;
 if (nama in aturan) periksaField(nama);
 if (nama === 'sandi' && form.elements.namedItem('konfirmasi').value !== '') {
   periksaField('konfirmasi');
 }
 tombolKirim.disabled = !namaField.every((field) =>
   aturan[field](form.elements.namedItem(field).value),
 );
});

form.addEventListener('submit', (event) => {
 event.preventDefault();
 const valid = namaField.map((nama) => periksaField(nama));
 if (!valid.every(Boolean)) return;

 const nama = form.elements.namedItem('nama').value;
 const email = form.elements.namedItem('email').value;
 ringkasan.hidden = false;
 ringkasan.textContent = `Pendaftaran berhasil: ${nama} (${email})`;
 form.reset();
 namaField.forEach((field) => tampilkanGalat(field, ''));
 tombolKirim.disabled = true;
});

tombolKirim.disabled = !namaField.every((nama) =>
 aturan[nama](form.elements.namedItem(nama).value),
);