var etalase = [
    {id: 1, barang: 'T-shirt', harga: 80000},
    {id: 2, barang: 'Jeans', harga: 90000},
    {id: 3, barang: 'Tote Bag', harga: 20000},
    {id: 4, barang: 'School Bag', harga: 250000},
    {id: 5, barang: 'Shoes', harga: 120000}
];
function urutkanHarga(etalase) {
    return etalase.sort(function(a, b) {
        return a.harga - b.harga;
    });
}

console.log(urutkanHarga(etalase));
