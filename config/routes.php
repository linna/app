<?php

/**
 * Linna App
 *
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2017, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 *
 */

$routes = [
    [
        'name' => 'Home',
        'method' => 'GET',
        'url' => '/',
        'model' => 'HomeModel',
        'view' => 'HomeView',
        'controller' => 'HomeController',
        'action' => ''
    ],
    [
        'name' => 'E404',
        'method' => 'GET',
        'url' => '/error',
        'model' => 'E404Model',
        'view' => 'E404View',
        'controller' => 'E404Controller',
        'action' => '',
    ],
    [
        'name' => 'User',
        'method' => 'GET',
        'url' => '/user',
        'model' => 'UserModel',
        'view' => 'UserView',
        'controller' => 'UserController',
        'action' => '',
    ],
    [
        'name' => '',
        'method' => 'GET|POST',
        'url' => '/user/[id]/(disable|enable|delete|changePassword|modify)',
        'model' => 'UserModel',
        'view' => 'UserActionView',
        'controller' => 'UserController',
        'action' => '',
    ],
    [
        'name' => '',
        'method' => 'GET',
        'url' => '/login',
        'model' => 'LoginModel',
        'view' => 'LoginView',
        'controller' => 'LoginController',
        'action' => '',
    ],
    [
        'name' => '',
        'method' => 'GET|POST',
        'url' => '/(dologin|logout)',
        'model' => 'LoginModel',
        'view' => 'LoginView',
        'controller' => 'LoginController',
        'action' => '',
    ]
];
