/**
 * Struktur data dasar untuk proyek simulator antrean dan riwayat.
 * Modul ini tidak bergantung pada DOM.
 */

class Node {
  constructor(data) {
    this.data = data;
    this.next = null;
  }
}

export class LinkedList {
  #head = null;
  #tail = null;
  #size = 0;

  /** Menambahkan data ke awal linked list. */
  addFirst(data) {
    const node = new Node(data);
    node.next = this.#head;
    this.#head = node;
    if (this.#tail === null) this.#tail = node;
    this.#size += 1;
  }

  /** Menambahkan data ke akhir linked list dalam O(1). */
  addLast(data) {
    const node = new Node(data);
    if (this.#tail === null) {
      this.#head = node;
    } else {
      this.#tail.next = node;
    }
    this.#tail = node;
    this.#size += 1;
  }

  /** Menghapus dan mengembalikan data pertama, atau undefined jika kosong. */
  removeFirst() {
    if (this.#head === null) return undefined;
    const data = this.#head.data;
    this.#head = this.#head.next;
    this.#size -= 1;
    if (this.#head === null) this.#tail = null;
    return data;
  }

  /** Mengembalikan data pertama tanpa menghapusnya. */
  peekFirst() {
    return this.#head === null ? undefined : this.#head.data;
  }

  /** Menghapus kemunculan pertama data yang sama. */
  remove(data) {
    if (this.#head === null) return false;
    if (this.#head.data === data) {
      this.removeFirst();
      return true;
    }

    let previous = this.#head;
    let current = this.#head.next;
    while (current !== null) {
      if (current.data === data) {
        previous.next = current.next;
        if (current === this.#tail) this.#tail = previous;
        this.#size -= 1;
        return true;
      }
      previous = current;
      current = current.next;
    }
    return false;
  }

  /** Mencari data pertama yang memenuhi predikat. */
  find(predicate) {
    let current = this.#head;
    while (current !== null) {
      if (predicate(current.data)) return current.data;
      current = current.next;
    }
    return undefined;
  }

  /** Mengembalikan jumlah elemen. */
  size() {
    return this.#size;
  }

  /** Memeriksa apakah linked list kosong. */
  isEmpty() {
    return this.#size === 0;
  }

  /** Menyalin isi linked list ke array. */
  toArray() {
    const result = [];
    let current = this.#head;
    while (current !== null) {
      result.push(current.data);
      current = current.next;
    }
    return result;
  }
}

export class LinkedQueue {
  #list = new LinkedList();

  /** Menambahkan item ke belakang antrean. */
  enqueue(item) {
    this.#list.addLast(item);
  }

  /** Mengambil item terdepan, atau undefined jika kosong. */
  dequeue() {
    return this.#list.removeFirst();
  }

  /** Melihat item terdepan tanpa mengambilnya. */
  front() {
    return this.#list.peekFirst();
  }

  /** Memeriksa apakah antrean kosong. */
  isEmpty() {
    return this.#list.isEmpty();
  }

  /** Mengembalikan jumlah item antrean. */
  size() {
    return this.#list.size();
  }

  /** Mengembalikan salinan antrean dalam urutan FIFO. */
  toArray() {
    return this.#list.toArray();
  }

  /** Mengosongkan antrean. */
  clear() {
    while (!this.#list.isEmpty()) this.#list.removeFirst();
  }
}

export class Stack {
  #items = [];

  /** Menambahkan item ke puncak stack. */
  push(item) {
    this.#items.push(item);
  }

  /** Mengambil item teratas, atau undefined jika kosong. */
  pop() {
    return this.#items.pop();
  }

  /** Melihat item teratas tanpa mengambilnya. */
  peek() {
    return this.#items[this.#items.length - 1];
  }

  /** Memeriksa apakah stack kosong. */
  isEmpty() {
    return this.#items.length === 0;
  }

  /** Mengembalikan jumlah item stack. */
  size() {
    return this.#items.length;
  }

  /** Menghapus seluruh isi stack. */
  clear() {
    this.#items.length = 0;
  }
}
