<?php

declare(strict_types=1);

use FortniteHub\Core\Config;
use FortniteHub\Core\Router;

require BASE_PATH . '/public/autoload.php';

Config::bootstrap(BASE_PATH);

error_reporting(E_ALL);
ini_set('display_errors', Config::isDebug() ? '1' : '0');

header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('Permissions-Policy: geolocation=(), microphone=(), camera=()');

$router = new Router();
$router->setBasePath(Config::baseUrl());

$routes = require BASE_PATH . '/config/routes.php';
$routes($router);

try {
    $router->dispatch();
} catch (Throwable $exception) {
    http_response_code(500);
    error_log('[Fortnite Hub] ' . $exception->getMessage() . PHP_EOL . $exception->getTraceAsString());

    $baseUrl = Config::baseUrl();

    if (Config::isDebug()) {
        echo '<pre>';
        echo htmlspecialchars($exception->getMessage(), ENT_QUOTES, 'UTF-8') . PHP_EOL . PHP_EOL;
        echo htmlspecialchars($exception->getTraceAsString(), ENT_QUOTES, 'UTF-8');
        echo '</pre>';
        return;
    }

    include BASE_PATH . '/app/Views/errors/500.php';
}
