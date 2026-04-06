<?php

declare(strict_types=1);

use FortniteHub\Core\Router;

return static function (Router $router): void {
    $router->get('/', 'HomeController', 'index');

    $router->get('/shop', 'ShopController', 'index');

    $router->get('/cosmetics', 'CosmeticsController', 'index');
    $router->get('/cosmetics/api', 'CosmeticsController', 'api');
    $router->get('/cosmetics/{id}', 'CosmeticsController', 'show');

    $router->get('/news', 'NewsController', 'index');
    $router->get('/news/br', 'NewsController', 'br');
    $router->get('/news/stw', 'NewsController', 'stw');

    $router->get('/map', 'MapController', 'index');

    $router->get('/modes', 'ModesController', 'index');

    $router->get('/player', 'PlayerController', 'search');
    $router->get('/player/{name}', 'PlayerController', 'stats');
};
