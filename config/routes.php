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
    new Route(
        name:       'Home',
        method:     'GET',
        path:       '/',
        model:      Linna\App\Models\HomeModel::class,
        view:       Linna\App\Views\HomeView::class,
        controller: Linna\App\Controllers\HomeController::class
    ),
    new Route(
        name:       'Error',
        method:     'GET',
        path:       '/error/[code]',
        model:      Linna\App\Models\ErrorModel::class,
        view:       Linna\App\Views\ErrorView::class,
        controller: Linna\App\Controllers\ErrorController::class
    )
]));
