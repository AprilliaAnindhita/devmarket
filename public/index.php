<?php
// DevMarket front controller

error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

require __DIR__ . '/../config/database.php';
require __DIR__ . '/../app/Core/helpers.php';

// PSR-style autoloader across Core, Models, Controllers
spl_autoload_register(function ($class) {
    foreach (['Core', 'Models', 'Controllers'] as $dir) {
        $path = __DIR__ . "/../app/{$dir}/{$class}.php";
        if (is_file($path)) { require $path; return; }
    }
});

// Ensure database schema + seed data exist
try {
    Installer::ensure();
} catch (\Throwable $e) {
    http_response_code(500);
    echo '<pre style="font-family:monospace;padding:2rem">DevMarket setup error: '
        . htmlspecialchars($e->getMessage()) . '</pre>';
    exit;
}

$routes = [
    ['GET',  '/',                     'ProductController@index'],
    ['GET',  '/product/{slug}',       'ProductController@show'],
    ['POST', '/cart/add',             'CartController@add'],
    ['GET',  '/cart',                 'CartController@view'],
    ['POST', '/cart/remove',          'CartController@remove'],
    ['GET',  '/checkout',             'OrderController@checkout'],
    ['POST', '/checkout',             'OrderController@placeOrder'],
    ['GET',  '/login',                'AuthController@showLogin'],
    ['POST', '/login',                'AuthController@login'],
    ['GET',  '/register',             'AuthController@showRegister'],
    ['POST', '/register',             'AuthController@register'],
    ['GET',  '/logout',               'AuthController@logout'],
    ['GET',  '/dashboard',            'OrderController@dashboard'],
    ['GET',  '/download/{id}',        'DownloadController@download'],
    ['GET',  '/admin',                'AdminController@dashboard'],
    ['GET',  '/admin/products',       'AdminController@products'],
    ['GET',  '/admin/products/new',   'AdminController@productForm'],
    ['POST', '/admin/products',       'AdminController@storeProduct'],
    ['POST', '/admin/products/delete','AdminController@deleteProduct'],
    ['GET',  '/admin/orders',         'AdminController@orders'],
    ['POST', '/admin/orders/pay',     'AdminController@markPaid'],
];

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri, '/');
if ($uri === '') $uri = '/';

foreach ($routes as [$rMethod, $pattern, $handler]) {
    if ($rMethod !== $method) continue;
    $regex = '#^' . preg_replace('#\{[^/]+\}#', '([^/]+)', $pattern) . '$#';
    if (preg_match($regex, $uri, $m)) {
        array_shift($m);
        [$ctrl, $action] = explode('@', $handler);
        $instance = new $ctrl();
        call_user_func_array([$instance, $action], array_map('urldecode', $m));
        exit;
    }
}

http_response_code(404);
view('errors/404', ['title' => 'Not Found']);
