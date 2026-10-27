import { LinkedQueue } from './struktur.js';

export const AWALAN_NOMOR = 'A';
const PANJANG_NOMOR = 3;
const MAKS_RIWAYAT_PANGGILAN = 5;

export class PengelolaAntrian {
  #antrean = new LinkedQueue();
  #nomorBerikutnya = 1;
  #riwayatPanggilan = [];

  /** Membuat nomor baru dan memasukkannya ke antrean. */
  ambilNomor() {
    const nomor = `${AWALAN_NOMOR}${String(this.#nomorBerikutnya).padStart(PANJANG_NOMOR, '0')}`;
    this.#nomorBerikutnya += 1;
    this.#antrean.enqueue(nomor);
    return nomor;
  }

  /** Memanggil nomor terdepan sesuai urutan FIFO. */
  panggilBerikutnya() {
    const nomor = this.#antrean.dequeue();
    if (nomor === undefined) return undefined;
    this.#riwayatPanggilan.unshift(nomor);
    this.#riwayatPanggilan = this.#riwayatPanggilan.slice(0, MAKS_RIWAYAT_PANGGILAN);
    return nomor;
  }

  /** Mengambil salinan daftar antrean. */
  daftarMenunggu() {
    return this.#antrean.toArray();
  }

  /** Mengambil salinan riwayat panggilan terbaru. */
  riwayatPanggilan() {
    return [...this.#riwayatPanggilan];
  }

  /** Jumlah pasien yang masih menunggu. */
  jumlahMenunggu() {
    return this.#antrean.size();
  }

  /** Jumlah nomor yang telah dibuat sejak reset terakhir. */
  totalNomor() {
    return this.#nomorBerikutnya - 1;
  }

  /** Mengatur ulang antrean dan nomor. */
  reset() {
    this.#antrean.clear();
    this.#nomorBerikutnya = 1;
    this.#riwayatPanggilan = [];
  }
}
