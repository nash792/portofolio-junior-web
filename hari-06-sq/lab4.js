import { Queue } from './struktur.js'
//Uji dengan enqueue tiga elemen dequeue hingga kosong, dan dequeue pada queue kosong
const queue = new Queue ();
queue.enqueue(1);
queue.enqueue(2);
queue.enqueue(3);
//Dequeue hingga kosong
console.log(queue.dequeue()); // 1
console.log(queue.dequeue()); // 2
console.log(queue.dequeue()); // 3
//Dequeue pada queue kosong
console.log(queue.dequeue()); // undefined


