<?php

class Category {
    public static function all(): array {
        return db()->query('SELECT * FROM categories ORDER BY name ASC')->fetchAll();
    }

    public static function findBySlug(string $slug): ?array {
        $s = db()->prepare('SELECT * FROM categories WHERE slug = ?');
        $s->execute([$slug]);
        return $s->fetch() ?: null;
    }
}
