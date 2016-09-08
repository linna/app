<?php

/**
 * Linna App
 *
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2016, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 *
 */

$appRoutes = array();

$appRoutes[] = [
    'name' => 'Home',
    'method' => 'GET',
    'url' => '/',
    'model' => 'HomeModel',
    'view' => 'HomeView',
    'controller' => 'HomeController',
    'action' => null,
];

$appRoutes[] = [
    'name' => 'E404',
    'method' => 'GET',
    'url' => '/error',
    'model' => 'E404Model',
    'view' => 'E404View',
    'controller' => 'E404Controller',
    'action' => null,
];

$appRoutes[] = [
    'name' => 'User',
    'method' => 'GET',
    'url' => '/user',
    'model' => 'UserModel',
    'view' => 'UserView',
    'controller' => 'UserController',
    'action' => null,
];

$appRoutes[] = [
    'name' => null,
    'method' => 'GET',
    'url' => '/user/[id]/(disable|enable|delete|changePassword|modify)',
    'model' => 'UserModel',
    'view' => 'UserView',
    'controller' => 'UserController',
    'action' => null,
];

$appRoutes[] = [
    'name' => null,
    'method' => 'GET',
    'url' => '/login',
    'model' => 'LoginModel',
    'view' => 'LoginView',
    'controller' => 'LoginController',
    'action' => null,
];

$appRoutes[] = [
    'name' => null,
    'method' => 'GET',
    'url' => '/(dologin|logout)',
    'model' => 'LoginModel',
    'view' => 'LoginView',
    'controller' => 'LoginController',
    'action' => null,
];
