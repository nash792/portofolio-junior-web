class Sepeda {
    constructor(jariJari) {
        this.jariJari = jariJari;
    }

    diameter() {
        return 2 * this.jariJari;
    }
}

// Membuat object sepeda
const sepeda1 = new Sepeda(30);

// Menampilkan diameter
console.log("Diameter roda sepeda: " + sepeda1.diameter() + " cm");