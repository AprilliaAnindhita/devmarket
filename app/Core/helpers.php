<?php
// Global view + utility helpers

function e($value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): void {
    header('Location: ' . $path);
    exit;
}

function base_url(): string {
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    return $scheme . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost');
}

function old(string $key, $default = '') {
    return $_SESSION['_old'][$key] ?? $default;
}

function set_old(array $data): void {
    $_SESSION['_old'] = $data;
}

function clear_old(): void {
    unset($_SESSION['_old']);
}

function flash(string $type, string $msg): void {
    $_SESSION['_flash'][] = ['type' => $type, 'msg' => $msg];
}

function get_flashes(): array {
    $f = $_SESSION['_flash'] ?? [];
    unset($_SESSION['_flash']);
    return $f;
}

function money($n): string {
    return 'Rp ' . number_format((float)$n, 0, ',', '.');
}

function thumb_url(?string $t): string {
    if (!$t) return 'https://placehold.co/600x400/1e1b4b/ffffff?text=DevMarket';
    return str_starts_with($t, 'http') ? $t : '/uploads/thumbnails/' . $t;
}

function cart(): array {
    return $_SESSION['cart'] ?? [];
}

function cart_count(): int {
    return array_sum(array_map(fn($i) => (int)$i['qty'], cart()));
}

function status_badge(string $status): string {
    $map = [
        'paid'      => ['class' => 'bg-emerald-100 text-emerald-700 ring-emerald-600/20', 'label' => 'Lunas'],
        'pending'   => ['class' => 'bg-amber-100 text-amber-700 ring-amber-600/20', 'label' => 'Tertunda'],
        'cancelled' => ['class' => 'bg-rose-100 text-rose-700 ring-rose-600/20', 'label' => 'Dibatalkan'],
    ];
    $item = $map[$status] ?? ['class' => 'bg-slate-100 text-slate-700 ring-slate-600/20', 'label' => ucfirst($status)];
    return '<span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold ring-1 ring-inset ' . $item['class'] . '">'
        . '<span class="h-1.5 w-1.5 rounded-full bg-current"></span>' . $item['label'] . '</span>';
}

/**
 * Render a view template wrapped in the main layout.
 */
function view(string $template, array $data = [], bool $layout = true): void {
    extract($data);
    ob_start();
    include __DIR__ . '/../../views/' . $template . '.php';
    $content = ob_get_clean();
    if ($layout) {
        $title = $data['title'] ?? 'DevMarket';
        include __DIR__ . '/../../views/layouts/header.php';
        echo $content;
        include __DIR__ . '/../../views/layouts/footer.php';
    } else {
        echo $content;
    }
}
