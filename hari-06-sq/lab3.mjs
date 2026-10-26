
import { Stack } from '../hari-06-SQ/struktur.js';

// ========================================
// 1. Pengujian Stack
// ========================================

const tumpukan = new Stack();

// Push tiga elemen
tumpukan.push(10);
tumpukan.push(20);
tumpukan.push(30);

console.log('Isi stack:', tumpukan.data);
console.log('Peek:', tumpukan.peek());
console.log('Ukuran:', tumpukan.size());

// Pop sampai kosong
console.log('Pop:', tumpukan.pop());
console.log('Pop:', tumpukan.pop());
console.log('Pop:', tumpukan.pop());

console.log('Stack kosong?', tumpukan.isEmpty());

// Pop dan peek pada stack kosong
console.log('Pop kosong:', tumpukan.pop());
console.log('Peek kosong:', tumpukan.peek());


// ========================================
// 2. Pengujian Push, Peek, dan Pop
// ========================================

const stack = new Stack();

stack.push(1);
stack.push(2);
stack.push(3);

console.log('\nPengujian Stack:');
console.log('Peek:', stack.peek()); // 3
console.log('Pop:', stack.pop());   // 3
console.log('Pop:', stack.pop());   // 2
console.log('Pop:', stack.pop());   // 1
console.log('Pop kosong:', stack.pop()); // undefined


// ========================================
// 3. Validasi Tanda Kurung Seimbang
// ========================================

export function kurungSeimbang(teks) {
    const pasangan = {
        ')': '(',
        ']': '[',
        '}': '{'
    };

    const tumpukan = new Stack();

    for (const karakter of teks) {
        if ('([{'.includes(karakter)) {
            tumpukan.push(karakter);
        } else if (karakter in pasangan) {
            if (
                tumpukan.isEmpty() ||
                tumpukan.pop() !== pasangan[karakter]
            ) {
                return false;
            }
        }
    }

    return tumpukan.isEmpty();
}

// Pengujian kurung seimbang
console.log('\nPengujian Kurung Seimbang:');
console.log(kurungSeimbang('(a+b)*[c-d]')); // true
console.log(kurungSeimbang('(a+b]'));       // false
console.log(kurungSeimbang('((a)'));        // false
console.log(kurungSeimbang(''));            // true


// ========================================
// 4. Membalik String dengan Stack
//    dan Memeriksa Palindrome
// ========================================

function balikString(teks) {
    const stack = new Stack();

    // Masukkan setiap karakter ke dalam stack
    for (const karakter of teks) {
        stack.push(karakter);
    }

    let hasil = '';

    // Ambil karakter dengan urutan terbalik
    while (!stack.isEmpty()) {
        hasil += stack.pop();
    }

    return hasil;
}

function isPalindrome(teks) {
    const teksBersih = teks
        .toLowerCase()
        .replace(/[^a-z0-9]/g, '');

    return teksBersih === balikString(teksBersih);
}

// Pengujian palindrome
const str = 'katak';
const reversedStr = balikString(str);

console.log('\nPengujian Palindrome:');
console.log('String:', str);
console.log('String terbalik:', reversedStr);
console.log('Palindrome?', isPalindrome(str)); // true

console.log('Palindrome "malam"?', isPalindrome('malam')); // true
console.log('Palindrome "halo"?', isPalindrome('halo'));  // false
