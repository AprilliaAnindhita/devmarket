<?php

class Installer {
    private static array $seedProducts = [
        // category_slug, title, price, thumbnail(url), ext, description
        ['ui-kits', 'Nova UI Kit', 750000, 'https://images.unsplash.com/photo-1669023414162-5bb06bbff0ec?crop=entropy&cs=srgb&fm=jpg&q=85&w=800', 'zip', 'A comprehensive design system with 240+ crafted components, dark & light themes, and Figma source files. Perfect for shipping polished products fast.'],
        ['ui-kits', 'Aurora Design System', 1200000, 'https://images.unsplash.com/photo-1634084462412-b54873c0a56d?crop=entropy&cs=srgb&fm=jpg&q=85&w=800', 'zip', 'An enterprise-grade design system covering typography, color tokens, and accessible components. Includes React and Vue implementations.'],
        ['ui-kits', 'Pulse Component Library', 600000, 'https://images.unsplash.com/photo-1669023414180-4dcf35d943e1?crop=entropy&cs=srgb&fm=jpg&q=85&w=800', 'zip', 'Lightweight, animated UI components built with Tailwind CSS. Drop-in ready snippets for modern SaaS dashboards and landing pages.'],

        ['ebooks', 'Mastering PHP 8', 350000, 'https://images.unsplash.com/photo-1515879218367-8466d910aaa4?crop=entropy&cs=srgb&fm=jpg&q=85&w=800', 'pdf', 'A 320-page deep dive into modern PHP: attributes, enums, fibers, JIT, and clean architecture patterns with real-world examples.'],
        ['ebooks', 'JavaScript Deep Dive', 450000, 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?crop=entropy&cs=srgb&fm=jpg&q=85&w=800', 'pdf', 'Understand the engine: closures, the event loop, prototypes, async patterns, and performance. Written for engineers who want mastery.'],
        ['ebooks', 'Clean Code Handbook', 300000, 'https://images.unsplash.com/photo-1607799279861-4dd421887fb3?crop=entropy&cs=srgb&fm=jpg&q=85&w=800', 'pdf', 'Practical principles for writing readable, maintainable software. Refactoring recipes, naming, testing, and code review checklists.'],

        ['templates', 'Admin Dashboard Pro', 900000, 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?crop=entropy&cs=srgb&fm=jpg&q=85&w=800', 'zip', 'A production-ready admin template with charts, tables, auth flows, and 30+ pages. Built on Tailwind with dark mode support.'],
        ['templates', 'SaaS Landing Kit', 500000, 'https://images.unsplash.com/photo-1686061592689-312bbfb5c055?crop=entropy&cs=srgb&fm=jpg&q=85&w=800', 'zip', 'High-converting landing page sections: hero, pricing, testimonials, and FAQ. Fully responsive and copy-paste friendly.'],
        ['templates', 'Portfolio Starter', 400000, 'https://images.unsplash.com/photo-1763718528755-4bca23f82ac3?crop=entropy&cs=srgb&fm=jpg&q=85&w=800', 'zip', 'An elegant developer portfolio template with project showcase, blog, and contact form. Deploy in minutes.'],

        ['icons-fonts', '5000 Line Icons Pack', 250000, 'https://images.unsplash.com/photo-1506729623306-b5a934d88b53?crop=entropy&cs=srgb&fm=jpg&q=85&w=800', 'zip', 'A massive collection of 5,000 pixel-perfect line icons in SVG, PNG, and icon font formats. Consistent 24px grid.'],
        ['icons-fonts', 'Geometric Icon Set', 200000, 'https://images.unsplash.com/photo-1605106325682-3482f7c1c9c4?crop=entropy&cs=srgb&fm=jpg&q=85&w=800', 'zip', 'A bold geometric icon set with 600 glyphs, designed for interfaces that need personality. Includes duotone variants.'],
        ['icons-fonts', 'Display Font Bundle', 700000, 'https://images.unsplash.com/photo-1566978862346-73282aa378a4?crop=entropy&cs=srgb&fm=jpg&q=85&w=800', 'zip', 'Six premium display typefaces with full glyph coverage, ligatures, and web font kits. Commercial license included.'],
    ];

    private static array $seedCategories = [
        ['UI Kits', 'ui-kits'],
        ['E-Books', 'ebooks'],
        ['Templates', 'templates'],
        ['Icons & Fonts', 'icons-fonts'],
    ];

    public static function ensure(): void {
        $flag = __DIR__ . '/../../storage/.installed';
        if (file_exists($flag)) {
            self::syncSeedContent();
            return;
        }
        self::migrate();
        self::seed();
        self::syncSeedContent();
        @file_put_contents($flag, date('c'));
    }

    private static function syncSeedContent(): void {
        $pdo = db();
        $products = [
            'Kit UI Nova' => ['Nova UI Kit', 'A comprehensive design system with 240+ crafted components, dark & light themes, and Figma source files. Perfect for shipping polished products fast.'],
            'Sistem Desain Aurora' => ['Aurora Design System', 'An enterprise-grade design system covering typography, color tokens, and accessible components. Includes React and Vue implementations.'],
            'Perpustakaan Komponen Pulse' => ['Pulse Component Library', 'Lightweight, animated UI components built with Tailwind CSS. Drop-in ready snippets for modern SaaS dashboards and landing pages.'],
            'Menguasai PHP 8' => ['Mastering PHP 8', 'A 320-page deep dive into modern PHP: attributes, enums, fibers, JIT, and clean architecture patterns with real-world examples.'],
            'Pendalaman JavaScript' => ['JavaScript Deep Dive', 'Understand the engine: closures, the event loop, prototypes, async patterns, and performance. Written for engineers who want mastery.'],
            'Panduan Clean Code' => ['Clean Code Handbook', 'Practical principles for writing readable, maintainable software. Refactoring recipes, naming, testing, and code review checklists.'],
            'Dashboard Admin Pro' => ['Admin Dashboard Pro', 'A production-ready admin template with charts, tables, auth flows, and 30+ pages. Built on Tailwind with dark mode support.'],
            'Kit Landing SaaS' => ['SaaS Landing Kit', 'High-converting landing page sections: hero, pricing, testimonials, and FAQ. Fully responsive and copy-paste friendly.'],
            'Pemula Portfolio' => ['Portfolio Starter', 'An elegant developer portfolio template with project showcase, blog, and contact form. Deploy in minutes.'],
            'Paket 5000 Ikon Garis' => ['5000 Line Icons Pack', 'A massive collection of 5,000 pixel-perfect line icons in SVG, PNG, and icon font formats. Consistent 24px grid.'],
            'Set Ikon Geometrik' => ['Geometric Icon Set', 'A bold geometric icon set with 600 glyphs, designed for interfaces that need personality. Includes duotone variants.'],
            'Bundel Font Display' => ['Display Font Bundle', 'Six premium display typefaces with full glyph coverage, ligatures, and web font kits. Commercial license included.'],
        ];
        $update = $pdo->prepare('UPDATE products SET title = ?, slug = ?, description = ? WHERE title = ?');
        foreach ($products as $legacyTitle => [$title, $description]) {
            $update->execute([$title, self::slugify($title), $description, $legacyTitle]);
        }

        $categories = [
            'Kit UI' => 'UI Kits',
            'E-Book' => 'E-Books',
            'Template' => 'Templates',
            'Ikon & Font' => 'Icons & Fonts',
        ];
        $categoryUpdate = $pdo->prepare('UPDATE categories SET name = ? WHERE name = ?');
        foreach ($categories as $legacyName => $name) {
            $categoryUpdate->execute([$name, $legacyName]);
        }
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
