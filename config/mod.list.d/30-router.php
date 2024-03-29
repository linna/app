<?php

/**
 * Linna App.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@tim.it>
 * @copyright (c) 2020, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

use Linna\Router\NullRoute;
use Linna\Router\Router;
use Linna\Router\Route;

//get routes from source
$routes = include APP_DIR.'/config/routes.php';

//start router
$router = new Router(
    $routes,
    basePath:                   $config['router']['basePath'],
    rewriteMode:                $config['router']['rewriteMode'],
    rewriteModeFalseEntryPoint: $config['router']['rewriteModeFalseEntryPoint']
);

//evaluate request uri and method
$router->validate($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

//get route
$route = $router->getRoute();

//on NullRoute take action from config
if ($route instanceof NullRoute) {
    $router->validate($config['app']['onNullRoute'], 'GET');
    $route = $router->getRoute();
}

$container->set(Route::class, $route);
