function compareArrays(array1, array2) {
    if (!Array.isArray(array1) || !Array.isArray(array2)) {
        return false;
    }

    if (array1.length !== array2.length) {
        return false;
    }

    return array1.every((value, index) => value === array2[index]);
}

// Contoh penggunaan
console.log(compareArrays([1, 2, 3], [1, 2, 3])); // true
console.log(compareArrays([4, 5, 6], [4, 5, 6])); // false
console.log(compareArrays([1, 2], [1, 2, 3]));   // false