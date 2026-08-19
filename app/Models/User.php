<?php

class User {
    public static function findByEmail(string $email): ?array {
        $s = db()->prepare('SELECT * FROM users WHERE email = ?');
        $s->execute([$email]);
        return $s->fetch() ?: null;
    }

    public static function find(int $id): ?array {
        $s = db()->prepare('SELECT * FROM users WHERE id = ?');
        $s->execute([$id]);
        return $s->fetch() ?: null;
    }

    public static function create(string $name, string $email, string $password, string $role = 'buyer'): int {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $s = db()->prepare('INSERT INTO users(name,email,password_hash,role) VALUES(?,?,?,?)');
        $s->execute([$name, $email, $hash, $role]);
        return (int)db()->lastInsertId();
    }
}
