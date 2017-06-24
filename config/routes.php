<?php

/**
 * Linna App.
 *
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2017, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
$routes = [
    [
        'name'       => 'Home',
        'method'     => 'GET',
        'url'        => '/',
        'model'      => App\Models\HomeModel::class,
        'view'       => App\Views\HomeView::class,
        'controller' => App\Controllers\HomeController::class,
        'action'     => '',
    ],
    [
        'name'       => 'E404',
        'method'     => 'GET',
        'url'        => '/error',
        'model'      => App\Models\E404Model::class,
        'view'       => App\Views\E404View::class,
        'controller' => App\Controllers\E404Controller::class,
        'action'     => '',
    ],
];
