<?php

class Auth {
    public static function user(): ?array {
        return $_SESSION['user'] ?? null;
    }
    public static function check(): bool {
        return isset($_SESSION['user']);
    }
    public static function id() {
        return $_SESSION['user']['id'] ?? null;
    }
    public static function isAdmin(): bool {
        return (($_SESSION['user']['role'] ?? '') === 'admin');
    }
    public static function login(array $u): void {
        $_SESSION['user'] = [
            'id'    => $u['id'],
            'name'  => $u['name'],
            'email' => $u['email'],
            'role'  => $u['role'],
        ];
    }
    public static function logout(): void {
        unset($_SESSION['user']);
    }
    public static function requireLogin(): void {
        if (!self::check()) {
            flash('error', 'Silakan masuk untuk melanjutkan.');
            redirect('/login');
        }
    }
    public static function requireAdmin(): void {
        self::requireLogin();
        if (!self::isAdmin()) {
            flash('error', 'Access denied. Administrators only.');
            redirect('/');
        }
    }
}
