<?php

class Product {
    /**
     * Filtered/sorted catalog query.
     */
    public static function query(string $search = '', string $categorySlug = '', string $sort = ''): array {
        $sql = 'SELECT p.*, c.name AS category_name, c.slug AS category_slug
                FROM products p JOIN categories c ON c.id = p.category_id WHERE 1=1';
        $params = [];

        if ($search !== '') {
            $sql .= ' AND (p.title LIKE ? OR p.description LIKE ?)';
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
        }
        if ($categorySlug !== '') {
            $sql .= ' AND c.slug = ?';
            $params[] = $categorySlug;
        }

        switch ($sort) {
            case 'price_asc':  $sql .= ' ORDER BY p.price ASC'; break;
            case 'price_desc': $sql .= ' ORDER BY p.price DESC'; break;
            case 'title_asc':  $sql .= ' ORDER BY p.title ASC'; break;
            default:           $sql .= ' ORDER BY p.created_at DESC';
        }

        $s = db()->prepare($sql);
        $s->execute($params);
        return $s->fetchAll();
    }

    public static function find(int $id): ?array {
        $s = db()->prepare('SELECT p.*, c.name AS category_name, c.slug AS category_slug
                            FROM products p JOIN categories c ON c.id = p.category_id WHERE p.id = ?');
        $s->execute([$id]);
        return $s->fetch() ?: null;
    }

    public static function findBySlug(string $slug): ?array {
        $s = db()->prepare('SELECT p.*, c.name AS category_name, c.slug AS category_slug
                            FROM products p JOIN categories c ON c.id = p.category_id WHERE p.slug = ?');
        $s->execute([$slug]);
        return $s->fetch() ?: null;
    }

    public static function all(): array {
        return db()->query('SELECT p.*, c.name AS category_name FROM products p
                            JOIN categories c ON c.id = p.category_id ORDER BY p.created_at DESC')->fetchAll();
    }

    public static function related(int $categoryId, int $excludeId, int $limit = 3): array {
        $s = db()->prepare('SELECT * FROM products WHERE category_id = ? AND id <> ? ORDER BY RAND() LIMIT ' . (int)$limit);
        $s->execute([$categoryId, $excludeId]);
        return $s->fetchAll();
    }

    public static function create(array $data): int {
        $s = db()->prepare('INSERT INTO products(category_id,title,slug,description,price,thumbnail,file_path)
                            VALUES(?,?,?,?,?,?,?)');
        $s->execute([
            $data['category_id'], $data['title'], $data['slug'], $data['description'],
            $data['price'], $data['thumbnail'], $data['file_path'],
        ]);
        return (int)db()->lastInsertId();
    }

    public static function delete(int $id): void {
        $s = db()->prepare('DELETE FROM products WHERE id = ?');
        $s->execute([$id]);
    }

    public static function count(): int {
        return (int)db()->query('SELECT COUNT(*) FROM products')->fetchColumn();
    }
}
