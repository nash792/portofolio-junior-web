
const readline = require('node:readline/promises');
const { stdin: input, stdout: output } = require('node:process');

async function main() {
    const rl = readline.createInterface({ input, output });

    try {
        const inputBerat = await rl.question('Masukkan berat badan (kg): ');
        const inputTinggi = await rl.question('Masukkan tinggi badan (cm): ');

        const berat = Number(inputBerat);
        const tinggi = Number(inputTinggi);

        if (
            Number.isNaN(berat) ||
            Number.isNaN(tinggi) ||
            berat <= 0 ||
            tinggi <= 0
        ) {
            console.log('Masukkan berat dan tinggi berupa angka yang valid.');
            return;
        }

        const tinggiMeter = tinggi / 100;
        const bmi = berat / (tinggiMeter * tinggiMeter);

        let kategori = 'Normal';

        if (bmi < 18.5) {
            kategori = 'Kurang';
        } else if (bmi >= 30) {
            kategori = 'Obesitas';
        } else if (bmi >= 25) {
            kategori = 'Lebih';
        }

        console.log(`BMI: ${bmi.toFixed(1)} (${kategori})`);
    } finally {
        rl.close();
    }
}

main();
