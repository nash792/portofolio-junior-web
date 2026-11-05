function displayEvenNumbers(numbers) {
    var evenNumbers = [];

    for (var i = 0; i < numbers.length; i++) {
        if (numbers[i] % 2 === 0) {
            evenNumbers.push(numbers[i]);
        }
    }

    return evenNumbers;
}

displayEvenNumbers([1, 2, 3, 4, 5, 6, 7, 8]);
//Kesalahan pada kurang titik dua setelah if, tanda titik koma setelah if, dan kondisi perulangan < numbers.length. 