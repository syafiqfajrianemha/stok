# Sistem Informasi Monitoring Stok

Aplikasi berbasis web yang dirancang khusus untuk membantu pemilik toko UMKM seperti toko sembako, jajanan, minuman, dan kebutuhan rumah tangga dalam mengelola stok barang, transaksi penjualan, serta laporan keuangan. Dengan fitur input barang masuk, pencatatan penjualan otomatis mengurangi stok, laporan pendapatan & pengeluaran, serta notifikasi stok minimum, aplikasi ini memberikan kemudahan dan efisiensi dalam pengelolaan toko secara real-time dan akurat.

## Specification
- Node >= 22
- PHP >= 8.2
- Laravel 12.x
- Laravel Breeze
- Database MySQL or MariaDB

## Installation Steps

Follow this instructions to install the project:

1. Clone this repo `$ git clone https://github.com/syafiqfajrianemha/stok.git`
2. `$ cd stok`
3. `$ composer install`
4. `$ cp .env.example .env`
5. `$ php artisan key:generate`
6. `$ php artisan storage:link`
7. Set **database config** on `.env` file
8. `$ php artisan migrate --seed`
9. `$ npm install`
10. `$ npm run dev`
11. `$ php artisan serve`
12. Open `http://localhost:8000` with browser.

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).
