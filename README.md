# DevMarket

DevMarket adalah aplikasi marketplace aset digital untuk developer dan designer. Pengguna dapat melihat produk, memasukkan produk ke keranjang, membuat pesanan, dan mengunduh aset setelah pesanan dibayar oleh admin.

Aplikasi ini menggunakan PHP native tanpa framework, dengan database MySQL/MariaDB dan Tailwind CSS melalui CDN.

## Fitur

- Katalog aset digital dengan pencarian, kategori, dan pengurutan.
- Keranjang belanja berbasis session.
- Registrasi dan login pengguna.
- Checkout dan pembuatan pesanan.
- Dashboard buyer untuk melihat riwayat pesanan dan unduhan.
- Dashboard admin dengan ringkasan penjualan.
- Admin dapat menambah, menghapus, dan mengelola produk.
- Download file dilindungi dan hanya tersedia untuk pesanan yang sudah dibayar.
- Antarmuka Bahasa Indonesia dengan format harga Rupiah, misalnya `Rp 750.000`.

## Teknologi

- PHP 8.1 atau lebih baru
- MySQL atau MariaDB
- PDO MySQL
- Tailwind CSS CDN
- Apache/XAMPP atau PHP Development Server

## Persyaratan

Pastikan tersedia:

- PHP 8.1+
- Ekstensi PHP: `pdo_mysql`, `mbstring`, `gd`, dan `zip`
- MySQL/MariaDB
- XAMPP, Laragon, atau PHP CLI

## Instalasi dengan XAMPP

### 1. Jalankan MySQL

Buka XAMPP Control Panel, lalu klik **Start** pada MySQL. Apache hanya diperlukan jika ingin membuka phpMyAdmin atau menjalankan aplikasi melalui Apache.

### 2. Buat database

Jika phpMyAdmin tidak tersedia, gunakan Command Prompt atau PowerShell:

```powershell
& "C:\xampp\mysql\bin\mysql.exe" -u root
```

Kemudian jalankan SQL berikut:

```sql
CREATE DATABASE IF NOT EXISTS devmarket
		CHARACTER SET utf8mb4
		COLLATE utf8mb4_unicode_ci;

CREATE USER IF NOT EXISTS 'devuser'@'localhost' IDENTIFIED BY 'devpass';
CREATE USER IF NOT EXISTS 'devuser'@'127.0.0.1' IDENTIFIED BY 'devpass';

ALTER USER 'devuser'@'localhost' IDENTIFIED BY 'devpass';
ALTER USER 'devuser'@'127.0.0.1' IDENTIFIED BY 'devpass';

GRANT ALL PRIVILEGES ON devmarket.* TO 'devuser'@'localhost';
GRANT ALL PRIVILEGES ON devmarket.* TO 'devuser'@'127.0.0.1';
FLUSH PRIVILEGES;
```

### 3. Periksa file `.env`

File `.env` di root proyek harus berisi:

```env
APP_NAME=DevMarket
DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=devmarket
DB_USER=devuser
DB_PASS=devpass
```

Jangan commit file `.env` ke repository publik jika berisi kredensial asli.

### 4. Jalankan aplikasi

Buka PowerShell di folder proyek:

```powershell
cd "C:\MY STORAGE\Downloads\devmarket"
php -S localhost:8000 -t public
```

Buka aplikasi di:

```text
http://localhost:8000
```

## Inisialisasi otomatis

Saat pertama kali dibuka, aplikasi akan menjalankan migrasi dan seed melalui `app/Core/Installer.php`. Proses ini membuat:

- Tabel database dari `database/schema.sql`.
- Akun admin dan buyer demo.
- Empat kategori produk.
- Dua belas produk aset digital berbahasa Indonesia.
- File dummy download di `storage/downloads/`.

File `storage/.installed` digunakan sebagai penanda bahwa instalasi sudah selesai.

## Akun demo

### Admin

```text
Email: admin@devmarket.com
Password: admin123
```

### Buyer

```text
Email: buyer@devmarket.com
Password: buyer123
```

Ganti password demo sebelum aplikasi digunakan di lingkungan nyata.

## Halaman utama

| Halaman | URL |
|---|---|
| Toko | `/` |
| Keranjang | `/cart` |
| Login | `/login` |
| Registrasi | `/register` |
| Checkout | `/checkout` |
| Dashboard buyer | `/dashboard` |
| Dashboard admin | `/admin` |
| Kelola produk | `/admin/products` |
| Kelola pesanan | `/admin/orders` |

## Struktur folder

```text
app/
	Controllers/     Controller untuk setiap fitur aplikasi
	Core/             Auth, helper, dan installer database
	Models/           Model User, Product, Category, dan Order
config/
	database.php     Koneksi PDO dan pembacaan environment
database/
	schema.sql       Struktur tabel database
public/
	index.php        Front controller aplikasi
	router.php       Router request
	assets/          Asset publik
	uploads/         Thumbnail produk
storage/
	downloads/       File digital yang dilindungi
views/
	admin/            Halaman admin
	auth/             Login dan registrasi
	layouts/          Header dan footer bersama
	shop/             Toko, produk, keranjang, dan checkout
	user/             Dashboard buyer
```

## Troubleshooting

### Error `SQLSTATE[HY000] [2002]`

Pastikan MySQL/MariaDB sedang berjalan dan port pada `.env` benar. Cek port dengan:

```powershell
Test-NetConnection 127.0.0.1 -Port 3306
```

Nilai `TcpTestSucceeded` harus `True`.

### phpMyAdmin tidak bisa dibuka

phpMyAdmin membutuhkan Apache. Jalankan Apache di XAMPP, lalu buka:

```text
http://localhost/phpmyadmin
```

phpMyAdmin tidak wajib digunakan. Database dapat dibuat melalui MySQL Command Line seperti pada panduan instalasi di atas.

### Seed tidak berubah setelah data diperbarui

Installer hanya melakukan seed ketika database masih kosong. Untuk instalasi baru, hapus database lalu buat ulang. Jangan menghapus database produksi tanpa backup.

## Catatan keamanan

- Gunakan password database dan akun admin yang kuat di lingkungan produksi.
- Jangan menyimpan file download di folder publik.
- Nonaktifkan atau ganti akun demo sebelum deployment.
- Tailwind CDN cocok untuk development; gunakan proses build Tailwind untuk production.
