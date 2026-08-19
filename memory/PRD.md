# DevMarket — Product Requirements Document

## Original Problem Statement
Build a complete, fully functional digital-product e-commerce app "DevMarket" using Native PHP (PDO), MySQL, and Tailwind CSS (via CDN), in a clean MVC structure with auth/RBAC, shop catalog, session cart, checkout, a secure file-download engine, buyer dashboard, and admin dashboard (analytics + product CRUD + order management with simulated payments).

## Architecture (as built)
- **Stack**: Native PHP 8.2 (PDO, prepared statements) + MariaDB/MySQL + Tailwind CSS (CDN). No framework.
- **Serving**: PHP built-in server on port 3000 via supervisor program `php` (`public/router.php` front-router). MySQL via supervisor program `mysql`. Routes are clean paths (NO `/api` prefix).
- **MVC layout**:
  - `config/database.php` — .env loader + shared PDO connection.
  - `app/Core/` — `helpers.php` (view/flash/format), `Auth.php` (session RBAC), `Installer.php` (auto-migrate + seed).
  - `app/Models/` — `User`, `Category`, `Product`, `Order`.
  - `app/Controllers/` — `Auth`, `Product`, `Cart`, `Order`, `Download`, `Admin`.
  - `views/` — `layouts/`, `shop/`, `auth/`, `user/`, `admin/`, `errors/`.
  - `public/` — `index.php` (front controller + router table), `router.php`, `uploads/thumbnails/`.
  - `storage/downloads/` — protected digital files (outside web root).
  - `database/schema.sql` — full schema.
- **DB schema**: users, categories, products, orders, order_items (FKs, enums for role & payment_status).

## User Personas
1. **Guest** — browses/searches catalog, views products, builds a cart; must log in to checkout/download.
2. **Buyer** — registers/logs in, checks out (creates pending order), views order history + "My Downloads", downloads paid assets.
3. **Admin** — views analytics, manages products (CRUD w/ uploads), manages orders (simulate mark-as-paid).

## Core Requirements (static)
- Secure register/login with `password_hash()`/`password_verify()`, session-based RBAC.
- Catalog with search + category filter + price/name sort; product detail; session cart w/ removal & total recalc.
- Checkout generates order with `pending` status.
- Secure download engine: serves file via `readfile()` + `Content-Disposition: attachment` ONLY when the logged-in buyer owns a `paid` order for that product; real file path never exposed.
- Buyer dashboard: order history + My Downloads. Admin dashboard: analytics cards + product CRUD (thumbnail → public/uploads, digital file → storage/downloads) + order management (Simulate Mark as Paid).
- Flash messages; responsive Tailwind UI (dark indigo/slate nav, white cards, green/amber status badges).

## Implemented (2026-06)
- [x] Full MVC scaffold, PDO connection, auto-migrate + seed (idempotent via storage/.installed flag).
- [x] Seed: admin + buyer accounts, 4 categories, 12 products (remote thumbnails), dummy downloadable ZIP/PDF assets, 1 pending demo order for buyer.
- [x] Auth + RBAC (role-based redirects & route guards).
- [x] Shop home (hero, search/category/sort filters, product grid), product detail (+ related), session cart, checkout.
- [x] Secure DownloadController (paid-order gate, attachment headers, path hidden).
- [x] Buyer dashboard (order history table + My Downloads).
- [x] Admin dashboard (analytics cards, recent orders), product list + add form (image + file upload), delete, order list + Simulate Mark as Paid.
- [x] Responsive layout, mobile nav, flash messages, 404 page.
- [x] Verified: full guest→buyer→admin→download flow (curl) + 11/11 UI flows via testing agent (100%).

## Payments
SIMULATED per user's choice — admin marks orders paid; no real gateway.

## Backlog (P1/P2 — optional, not requested)
- P1: Soft-delete products (current delete CASCADEs order_items, affecting historical paid orders/download rights); snapshot title/price/qty on order_items.
- P1: CSRF tokens on POST forms; env-driven display_errors.
- P2: Digital-file extension allowlist + explicit "file too large" error (PHP upload_max_filesize=2M).
- P2: Post-login return-to-intended-URL (e.g., back to /checkout).
- P2: data-testid on individual stat cards / status badges.

## Next Tasks
- Await user review; prioritize backlog if requested.
