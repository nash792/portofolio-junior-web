import { Stack } from './structures.js';

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

// Pengujian
console.log(kurungSeimbang('(a+b)*[c-d]')); // true
console.log(kurungSeimbang('(a+b]'));       // false
console.log(kurungSeimbang('((a)'));        // false
console.log(kurungSeimbang(''));            // true
console.log(kurungSeimbang('{[()]}'));      // true
console.log(kurungSeimbang('([)]'));        // false
