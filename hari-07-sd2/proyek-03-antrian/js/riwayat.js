import { Stack } from './struktur.js';

export const MAKS_RIWAYAT = 50;

export class EditorRiwayat {
  #undoStack = new Stack();
  #redoStack = new Stack();
  #catatan = '';

  constructor(catatanAwal = '') {
    this.#catatan = catatanAwal;
  }

  /** Mengubah catatan dan menyimpan versi sebelumnya untuk undo. */
  ubahCatatan(catatanBaru) {
    if (typeof catatanBaru !== 'string') throw new TypeError('Catatan harus berupa teks.');
    if (catatanBaru === this.#catatan) return false;
    this.#undoStack.push(this.#catatan);
    this.#batasiStack(this.#undoStack);
    this.#catatan = catatanBaru;
    this.#redoStack.clear();
    return true;
  }

  /** Membatalkan perubahan terakhir. */
  undo() {
    if (this.#undoStack.isEmpty()) return undefined;
    this.#redoStack.push(this.#catatan);
    this.#batasiStack(this.#redoStack);
    this.#catatan = this.#undoStack.pop();
    return this.#catatan;
  }

  /** Mengulang perubahan yang sebelumnya dibatalkan. */
  redo() {
    if (this.#redoStack.isEmpty()) return undefined;
    this.#undoStack.push(this.#catatan);
    this.#batasiStack(this.#undoStack);
    this.#catatan = this.#redoStack.pop();
    return this.#catatan;
  }

  #batasiStack(stack) {
    while (stack.size() > MAKS_RIWAYAT) {
      const isi = [];
      while (!stack.isEmpty()) isi.unshift(stack.pop());
      isi.shift();
      for (const item of isi) stack.push(item);
    }
  }

  /** Mengambil isi catatan saat ini. */
  getCatatan() {
    return this.#catatan;
  }

  /** Jumlah langkah undo yang tersedia. */
  jumlahUndo() {
    return this.#undoStack.size();
  }

  /** Jumlah langkah redo yang tersedia. */
  jumlahRedo() {
    return this.#redoStack.size();
  }

  /** Menentukan apakah undo dapat dilakukan. */
  bisaUndo() {
    return !this.#undoStack.isEmpty();
  }

  /** Menentukan apakah redo dapat dilakukan. */
  bisaRedo() {
    return !this.#redoStack.isEmpty();
  }
}
