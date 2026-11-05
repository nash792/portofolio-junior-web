var keranjang = [
    {id: 1, barang: 'T-shirt', harga: 80000, banyak: 2},
    {id: 2, barang: 'Jeans', harga: 90000, banyak: 1}
];

function hitungTotal(keranjang) {
    var total = 0;

    for (var i = 0; i < keranjang.length; i++) {
        total += keranjang[i].harga * keranjang[i].banyak;
    }

    return total;
}

// Menampilkan total harga
console.log("Total harga belanja: Rp" + hitungTotal(keranjang));