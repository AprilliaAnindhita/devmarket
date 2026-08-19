<?php
// Router for PHP built-in server: serve real static files, else hand off to front controller.
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . $uri;

if ($uri !== '/' && is_file($file)) {
    return false; // let the built-in server serve the static asset
}

require __DIR__ . '/index.php';
