var etalase = [
    {id: 1, barang: 'T-shirt', harga: 80000},
    {id: 2, barang: 'Jeans', harga: 90000},
    {id: 3, barang: 'Tote Bag', harga: 20000},
    {id: 4, barang: 'School Bag', harga: 250000},
    {id: 5, barang: 'Shoes', harga: 120000}
];

function cariBarang(etalase, keyword) {
    return etalase.filter(item => 
        item.barang.toLowerCase().includes(keyword.toLowerCase())
    );
}

console.log(cariBarang(etalase, 'Bag'));