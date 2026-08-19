# DevMarket — Menjalankan di Lokal (VSCode)

Aplikasi ini **Native PHP 8 (PDO) + MySQL/MariaDB + Tailwind (CDN)**. Tidak perlu Composer/Node.

## 1. Prasyarat
- PHP 8.1+ dengan ekstensi: `pdo_mysql`, `mbstring`, `gd`, `zip`
- MySQL atau MariaDB
- (Windows: pakai XAMPP/Laragon; macOS: `brew install php mysql`; Linux: `apt install php php-mysql mariadb-server`)

## 2. Buat database
```sql
CREATE DATABASE devmarket CHARACTER SET utf8mb4;
CREATE USER 'devuser'@'localhost' IDENTIFIED BY 'devpass';
GRANT ALL ON devmarket.* TO 'devuser'@'localhost';
FLUSH PRIVILEGES;
```
> Skema tabel dibuat OTOMATIS saat pertama kali app dibuka (lihat `app/Core/Installer.php`), termasuk seed 12 produk, akun admin/buyer, dan file dummy download.

## 3. Sesuaikan `.env`
File `.env` di root:
```
APP_NAME=DevMarket
DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=devmarket
DB_USER=devuser
DB_PASS=devpass
```

## 4. Jalankan
Dari folder root project:
```bash
php -S localhost:8000 -t public public/router.php
```
Buka http://localhost:8000

Kalau pakai Apache/XAMPP: arahkan DocumentRoot ke folder `public/` dan pastikan mod_rewrite/routing ke `index.php`. Cara `php -S` di atas paling gampang.

## 5. Login
- Admin: `admin@devmarket.com` / `admin123`
- Buyer: `buyer@devmarket.com` / `buyer123`

## Struktur
- `config/database.php` — koneksi PDO + loader .env
- `app/Core` — Auth (RBAC), Installer (migrate+seed), helpers
- `app/Models` — User, Category, Product, Order
- `app/Controllers` — Auth, Product, Cart, Order, Download, Admin
- `views/` — layouts, shop, auth, user, admin
- `public/` — front controller (`index.php`) + `router.php`, folder `uploads/thumbnails/`
- `storage/downloads/` — file digital terproteksi (di luar web root)
- `database/schema.sql` — skema referensi

## Reset seed
Hapus file penanda `storage/.installed` lalu refresh untuk migrate+seed ulang (tabel harus kosong agar seed berjalan).
