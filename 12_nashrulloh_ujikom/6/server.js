
const express = require('express');
const mysql = require('mysql');
const bodyParser = require('body-parser');

const app = express();

// Menggunakan body-parser JSON
app.use(bodyParser.json());

// Koneksi database MySQL
const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'ujian'
});

// Menghubungkan ke database
db.connect((err) => {
    if (err) {
        console.error('Koneksi database gagal:', err);
        return;
    }

    console.log('Berhasil terhubung ke database MySQL');
});

// Endpoint GET /
app.get('/', (req, res) => {
    const sql = 'SELECT * FROM users';

    db.query(sql, (err, results) => {
        if (err) {
            return res.status(500).json({
                error: err.message
            });
        }

        res.json({
            data: results
        });
    });
});

// Menjalankan server pada port 3000
app.listen(3000, () => {
    console.log('Server berjalan di http://localhost:3000');
});
