const http = require('http');
const fs = require('fs');
const path = require('path');

const PORT = 8000;
const HOST = 'localhost';

const PUBLIC_DIR = path.join(__dirname, 'public');

const mimeTypes = {
    '.html': 'text/html',
    '.css': 'text/css',
    '.js': 'application/javascript',
    '.json': 'application/json',
    '.png': 'image/png',
    '.jpg': 'image/jpeg',
    '.jpeg': 'image/jpeg',
    '.gif': 'image/gif',
    '.svg': 'image/svg+xml',
    '.ico': 'image/x-icon',
    '.txt': 'text/plain'
};

const server = http.createServer((req, res) => {
    try {
        // Hanya menerima GET
        if (req.method !== 'GET') {
            res.writeHead(405, {
                'Content-Type': 'text/plain',
                'Allow': 'GET'
            });
            return res.end('405 - Method Not Allowed');
        }

        // Endpoint utama
        if (req.url === '/') {
            res.writeHead(200, {
                'Content-Type': 'text/plain'
            });
            return res.end('Hello World');
        }

        // Mengambil pathname
        let pathname;

        try {
            pathname = new URL(
                req.url,
                `http://${HOST}`
            ).pathname;
        } catch {
            res.writeHead(400);
            return res.end('400 - Bad Request');
        }

        // Decode URL
        let decodedPath;

        try {
            decodedPath = decodeURIComponent(pathname);
        } catch {
            res.writeHead(400);
            return res.end('400 - Invalid URL Encoding');
        }

        // Menentukan lokasi file
        const filePath = path.resolve(
            PUBLIC_DIR,
            '.' + decodedPath
        );

        // Mencegah akses di luar folder public
        if (
            filePath !== PUBLIC_DIR &&
            !filePath.startsWith(PUBLIC_DIR + path.sep)
        ) {
            res.writeHead(403);
            return res.end('403 - Forbidden');
        }

        // Memeriksa file
        fs.stat(filePath, (error, stats) => {
            if (error) {
                if (error.code === 'ENOENT') {
                    res.writeHead(404);
                    return res.end('404 - File Not Found');
                }

                console.error(error);
                res.writeHead(500);
                return res.end('500 - Internal Server Error');
            }

            if (!stats.isFile()) {
                res.writeHead(404);
                return res.end('404 - File Not Found');
            }

            // Menentukan MIME type
            const ext = path.extname(filePath).toLowerCase();

            const contentType =
                mimeTypes[ext] || 'application/octet-stream';

            res.writeHead(200, {
                'Content-Type': contentType
            });

            // Membaca dan mengirim file
            const stream = fs.createReadStream(filePath);

            stream.on('error', (error) => {
                console.error(error);

                if (!res.headersSent) {
                    res.writeHead(500);
                }

                if (!res.destroyed) {
                    res.end('500 - Internal Server Error');
                }
            });

            stream.pipe(res);
        });

    } catch (error) {
        console.error(error);

        if (!res.headersSent) {
            res.writeHead(500);
        }

        if (!res.destroyed) {
            res.end('500 - Internal Server Error');
        }
    }
});

// Menangani error server
server.on('error', (error) => {
    console.error('Server error:', error.message);
});

// Menjalankan server
server.listen(PORT, HOST, () => {
    console.log(`Server berjalan di http://${HOST}:${PORT}`);
});