# DevMarket — Test Credentials

## App
- Stack: Native PHP 8.2 (PDO) + MariaDB/MySQL + Tailwind (CDN)
- Served on port 3000 (PHP built-in server via supervisor program `php`)
- DB: MySQL on 127.0.0.1:3306, database `devmarket` (user `devuser` / `devpass`) — supervisor program `mysql`
- Preview URL routes all non-`/api` traffic to the PHP app. Routes use clean paths (e.g. `/login`, `/cart`, `/admin`).

## Accounts
| Role  | Email                  | Password |
|-------|------------------------|----------|
| Admin | admin@devmarket.com    | admin123 |
| Buyer | buyer@devmarket.com    | buyer123 |

## Notes
- Payment is SIMULATED. Admin marks orders "paid" via Admin → Orders → "Simulate Mark as Paid".
- Downloads only work for products in a PAID order belonging to the logged-in buyer.
- Seed buyer starts with 1 PENDING order (mark it paid to test downloads).
- 12 seeded products across 4 categories (UI Kits, E-Books, Templates, Icons & Fonts).
- Protected files live in /app/storage/downloads (outside web root).
