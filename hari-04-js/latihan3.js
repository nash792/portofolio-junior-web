/*Tabel perkalian 1 sampai 10 (perulangan bersarang)*/
for (let i = 1; i <= 10; i++) {
    let row = '';
    for (let j = 1; j <= 10; j++) {
        row += `${i * j}\t`;
    }
    console.log(row);
}   
/*Pola segitiga bintang dan piramida; bentuk persegi angka*/
for (let i = 1; i <= 5; i++) {
    let row = '';
    for (let j = 1; j <= i; j++) {
        row += '*';
    }
    console.log(row);
}   
/*FizzBuzz 1-50 (kelipatan 3 = Fizz, 5 = Buzz, keduanya = FizzBuzz)*/
for (let i = 1; i <= 50; i++) {
    if (i % 3 === 0 && i % 5 === 0) {
        console.log('FizzBuzz');
    } else if (i % 3 === 0) {
        console.log('Fizz');
    } else if (i % 5 === 0) {
        console.log('Buzz');
    } else {
        console.log(i);
    }
}   
/*Jumlah digit dari sebuah angka (mis. 4821 menjadi 15) memakai while, %, dan Math.floor */
let number = 4821;
let sum = 0;
while (number > 0) {
    sum += number % 10;
    number = Math.floor(number / 10);
}
console.log(sum);   
/*Tebak angka: komputer memilih angka acak Math.floor(Math.random() * 100) + 1;
pengguna menebak hingga benar dengan petunjuk lebih tinggi/rendah (do...while)*/
async function tebakAngka() {
    const readline = require('node:readline/promises');
    const { stdin: input, stdout: output } = require('node:process');
    const rl = readline.createInterface({ input, output });

    const target = Math.floor(Math.random() * 100) + 1;
    let guess;
    do {
        const answer = await rl.question('Tebak angka antara 1 dan 100: ');
        guess = Number(answer);
        if (guess < target) {
            console.log('Lebih tinggi!');
        } else if (guess > target) {
            console.log('Lebih rendah!');
        }
    } while (guess !== target);
    console.log('Selamat! Tebakan Anda benar!');
    rl.close();
}
tebakAngka();
//tabel perkalian 1-10
for let i = 1; i <= 10; i++) {
    let row = '';
    for let j = 1; j <= 10; j++) {
        row += `${i * j}\t`;
    }
    console.log(row);
}

//segitga bintang
for (let i = 1; i <= 5; i++) {
    let row = '';
    for (let j = 1; j <= i; j++) {
        row += '*';
    }
    console.log(row);
}

