<?php

class Installer {
    private static array $seedProducts = [
        // category_slug, title, price, thumbnail(url), ext, description
        ['ui-kits', 'Kit UI Nova', 750000, 'https://images.unsplash.com/photo-1669023414162-5bb06bbff0ec?crop=entropy&cs=srgb&fm=jpg&q=85&w=800', 'zip', 'Sistem desain komprehensif dengan 240+ komponen yang dirancang dengan cermat, tema gelap & terang, dan file sumber Figma. Sempurna untuk mengirimkan produk yang halus dengan cepat.'],
        ['ui-kits', 'Sistem Desain Aurora', 1200000, 'https://images.unsplash.com/photo-1634084462412-b54873c0a56d?crop=entropy&cs=srgb&fm=jpg&q=85&w=800', 'zip', 'Sistem desain tingkat perusahaan yang mencakup tipografi, token warna, dan komponen yang dapat diakses. Termasuk implementasi React dan Vue.'],
        ['ui-kits', 'Perpustakaan Komponen Pulse', 600000, 'https://images.unsplash.com/photo-1669023414180-4dcf35d943e1?crop=entropy&cs=srgb&fm=jpg&q=85&w=800', 'zip', 'Komponen UI yang ringan dan beranimasi dibangun dengan Tailwind CSS. Snippet siap pakai untuk dasbor SaaS modern dan halaman landing.'],

        ['ebooks', 'Menguasai PHP 8', 350000, 'https://images.unsplash.com/photo-1515879218367-8466d910aaa4?crop=entropy&cs=srgb&fm=jpg&q=85&w=800', 'pdf', 'Pendalaman 320 halaman tentang PHP modern: atribut, enum, serat, JIT, dan pola arsitektur bersih dengan contoh dunia nyata.'],
        ['ebooks', 'Pendalaman JavaScript', 450000, 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?crop=entropy&cs=srgb&fm=jpg&q=85&w=800', 'pdf', 'Pahami mesinnya: closure, event loop, prototipe, pola async, dan kinerja. Ditulis untuk insinyur yang menginginkan penguasaan.'],
        ['ebooks', 'Panduan Clean Code', 300000, 'https://images.unsplash.com/photo-1607799279861-4dd421887fb3?crop=entropy&cs=srgb&fm=jpg&q=85&w=800', 'pdf', 'Prinsip praktis untuk menulis perangkat lunak yang dapat dibaca dan dipelihara. Resep refaktor, penamaan, pengujian, dan daftar periksa tinjauan kode.'],

        ['templates', 'Dashboard Admin Pro', 900000, 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?crop=entropy&cs=srgb&fm=jpg&q=85&w=800', 'zip', 'Template admin siap produksi dengan grafik, tabel, alur auth, dan 30+ halaman. Dibangun di Tailwind dengan dukungan mode gelap.'],
        ['templates', 'Kit Landing SaaS', 500000, 'https://images.unsplash.com/photo-1686061592689-312bbfb5c055?crop=entropy&cs=srgb&fm=jpg&q=85&w=800', 'zip', 'Bagian halaman landing dengan konversi tinggi: hero, penetapan harga, testimonial, dan FAQ. Responsif sepenuhnya dan ramah copy-paste.'],
        ['templates', 'Pemula Portfolio', 400000, 'https://images.unsplash.com/photo-1763718528755-4bca23f82ac3?crop=entropy&cs=srgb&fm=jpg&q=85&w=800', 'zip', 'Template portfolio pengembang yang elegan dengan pameran proyek, blog, dan formulir kontak. Terapkan dalam hitungan menit.'],

        ['icons-fonts', 'Paket 5000 Ikon Garis', 250000, 'https://images.unsplash.com/photo-1506729623306-b5a934d88b53?crop=entropy&cs=srgb&fm=jpg&q=85&w=800', 'zip', 'Koleksi besar 5.000 ikon garis yang sempurna untuk piksel dalam format SVG, PNG, dan font ikon. Grid konsisten 24px.'],
        ['icons-fonts', 'Set Ikon Geometrik', 200000, 'https://images.unsplash.com/photo-1605106325682-3482f7c1c9c4?crop=entropy&cs=srgb&fm=jpg&q=85&w=800', 'zip', 'Set ikon geometrik yang berani dengan 600 merek, dirancang untuk antarmuka yang membutuhkan kepribadian. Termasuk varian duotone.'],
        ['icons-fonts', 'Bundel Font Display', 700000, 'https://images.unsplash.com/photo-1566978862346-73282aa378a4?crop=entropy&cs=srgb&fm=jpg&q=85&w=800', 'zip', 'Enam typeface display premium dengan jangkauan merek lengkap, ligatur, dan kit font web. Lisensi komersial disertakan.'],
    ];

    private static array $seedCategories = [
        ['Kit UI', 'ui-kits'],
        ['E-Book', 'ebooks'],
        ['Template', 'templates'],
        ['Ikon & Font', 'icons-fonts'],
    ];

    public static function ensure(): void {
        $flag = __DIR__ . '/../../storage/.installed';
        if (file_exists($flag)) return;
        self::migrate();
        self::seed();
        @file_put_contents($flag, date('c'));
    }

    public static function migrate(): void {
        $sql = file_get_contents(__DIR__ . '/../../database/schema.sql');
        foreach (array_filter(array_map('trim', explode(';', $sql))) as $stmt) {
            if ($stmt !== '') db()->exec($stmt);
        }
    }

    public static function seed(): void {
        $pdo = db();
        // Only seed once
        $count = (int)$pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
        if ($count > 0) return;

        // Users
        $pdo->prepare('INSERT INTO users(name,email,password_hash,role) VALUES(?,?,?,?)')
            ->execute(['Admin User', 'admin@devmarket.com', password_hash('admin123', PASSWORD_DEFAULT), 'admin']);
        $pdo->prepare('INSERT INTO users(name,email,password_hash,role) VALUES(?,?,?,?)')
            ->execute(['Demo Buyer', 'buyer@devmarket.com', password_hash('buyer123', PASSWORD_DEFAULT), 'buyer']);

        // Categories
        $catIds = [];
        $catStmt = $pdo->prepare('INSERT INTO categories(name,slug) VALUES(?,?)');
        foreach (self::$seedCategories as [$name, $slug]) {
            $catStmt->execute([$name, $slug]);
            $catIds[$slug] = (int)$pdo->lastInsertId();
        }

        // Downloads directory
        $dlDir = __DIR__ . '/../../storage/downloads';
        if (!is_dir($dlDir)) mkdir($dlDir, 0775, true);

        // Products + dummy protected files
        $prodStmt = $pdo->prepare(
            'INSERT INTO products(category_id,title,slug,description,price,thumbnail,file_path) VALUES(?,?,?,?,?,?,?)'
        );
        foreach (self::$seedProducts as [$catSlug, $title, $price, $thumb, $ext, $desc]) {
            $slug = self::slugify($title);
            $file = $slug . '.' . $ext;
            self::writeDummyFile($dlDir . '/' . $file, $title, $ext);
            $prodStmt->execute([$catIds[$catSlug], $title, $slug, $desc, $price, $thumb, $file]);
        }

        // Seed one demo order for the buyer (pending) to showcase dashboard
        $buyer = $pdo->query("SELECT id FROM users WHERE email='buyer@devmarket.com'")->fetch();
        $firstProduct = $pdo->query('SELECT id, price FROM products ORDER BY id ASC LIMIT 1')->fetch();
        if ($buyer && $firstProduct) {
            Order::createForItems((int)$buyer['id'], [
                (int)$firstProduct['id'] => ['qty' => 1, 'price' => (float)$firstProduct['price']],
            ]);
        }
    }

    private static function writeDummyFile(string $path, string $title, string $ext): void {
        if ($ext === 'pdf') {
            // Minimal valid single-page PDF
            $text = "DevMarket - {$title}";
            $content = "%PDF-1.4\n1 0 obj<</Type/Catalog/Pages 2 0 R>>endobj\n"
                . "2 0 obj<</Type/Pages/Kids[3 0 R]/Count 1>>endobj\n"
                . "3 0 obj<</Type/Page/Parent 2 0 R/MediaBox[0 0 612 792]/Contents 4 0 R/Resources<</Font<</F1 5 0 R>>>>>>endobj\n"
                . "4 0 obj<</Length 80>>stream\nBT /F1 24 Tf 72 700 Td (" . $text . ") Tj ET\nendstream endobj\n"
                . "5 0 obj<</Type/Font/Subtype/Type1/BaseFont/Helvetica>>endobj\n"
                . "trailer<</Root 1 0 R>>\n%%EOF";
            file_put_contents($path, $content);
        } else {
            // Placeholder asset archive (text payload with .zip extension for demo)
            file_put_contents($path, "DevMarket digital asset\nProduct: {$title}\nThank you for your purchase!\nThis is a demo download file.\n");
        }
    }

    public static function slugify(string $text): string {
        $text = strtolower(trim($text));
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        return trim($text, '-');
    }
}
