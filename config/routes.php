<?php

/**
 * Linna App.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2018, Sebastian Rapetti
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
        'name'       => 'E404',
        'method'     => 'GET',
        'url'        => '/error',
        'model'      => App\Models\NullModel::class,
        'view'       => App\Views\E404View::class,
        'controller' => App\Controllers\E404Controller::class
    ])
]));
