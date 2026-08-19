<?php
// Load environment variables from /app/.env
(function () {
    $envPath = __DIR__ . '/../.env';
    if (!file_exists($envPath)) return;
    foreach (file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) continue;
        [$k, $v] = explode('=', $line, 2);
        $k = trim($k);
        $v = trim($v);
        if (getenv($k) === false) putenv("$k=$v");
        $_ENV[$k] = $v;
    }
})();

function env(string $key, $default = null) {
    $v = getenv($key);
    if ($v === false) $v = $_ENV[$key] ?? null;
    return ($v === null || $v === false) ? $default : $v;
}

/**
 * Returns a shared PDO connection using prepared statements.
 */
function db(): PDO {
    static $pdo = null;
    if ($pdo instanceof PDO) return $pdo;

    $host = env('DB_HOST', '127.0.0.1');
    $port = env('DB_PORT', '3306');
    $name = env('DB_NAME', 'devmarket');
    $user = env('DB_USER', 'devuser');
    $pass = env('DB_PASS', 'devpass');

    $dsn = "mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
    return $pdo;
}
