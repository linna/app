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

$appRoutes = array();

$appRoutes[] = [
    'name' => 'Home',
    'method' => 'GET',
    'url' => '/',
    'model' => 'HomeModel',
    'view' => 'HomeView',
    'controller' => 'HomeController',
    'action' => '',
];

$appRoutes[] = [
    'name' => 'E404',
    'method' => 'GET',
    'url' => '/error',
    'model' => 'E404Model',
    'view' => 'E404View',
    'controller' => 'E404Controller',
    'action' => '',
];

$appRoutes[] = [
    'name' => 'User',
    'method' => 'GET',
    'url' => '/user',
    'model' => 'UserModel',
    'view' => 'UserView',
    'controller' => 'UserController',
    'action' => '',
];

$appRoutes[] = [
    'name' => '',
    'method' => 'GET|POST',
    'url' => '/user/[id]/(disable|enable|delete|changePassword|modify)',
    'model' => 'UserModel',
    'view' => 'UserActionView',
    'controller' => 'UserController',
    'action' => '',
];

$appRoutes[] = [
    'name' => '',
    'method' => 'GET',
    'url' => '/login',
    'model' => 'LoginModel',
    'view' => 'LoginView',
    'controller' => 'LoginController',
    'action' => '',
];

$appRoutes[] = [
    'name' => '',
    'method' => 'GET|POST',
    'url' => '/(dologin|logout)',
    'model' => 'LoginModel',
    'view' => 'LoginView',
    'controller' => 'LoginController',
    'action' => '',
];
