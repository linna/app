<?php

/**
 * Linna App.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@tim.it>
 * @copyright (c) 2020, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

use Linna\Router\Route;
use Linna\Router\RouteCollection;

return (new RouteCollection([
    new Route([
        'name'       => 'Home',
        'method'     => 'GET',
        'url'        => '/',
        'model'      => App\Models\HomeModel::class,
        'view'       => App\Views\HomeView::class,
        'controller' => App\Controllers\HomeController::class
    ]),
    new Route([
        'name'       => 'Error',
        'method'     => 'GET',
        'url'        => '/error/[code]',
        'model'      => App\Models\ErrorModel::class,
        'view'       => App\Views\ErrorView::class,
        'controller' => App\Controllers\ErrorController::class
    ])
]));
