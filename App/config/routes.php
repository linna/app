<?php

/**
 * App_mk0
 *
 * This work would be a little PHP framework, a learn exercice. 
 * Work started from php MINI https://github.com/panique/mini good for understand how a MVC framework run :) 
 * I rewrote Router, Dispatcher, Controller and I added some new class like Model, View... etc for more flexibility  
 * 
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2015, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.1.0
 */
/**
 * @var array Contain declared routes
 * $routes[] = [
 *          'name' => null,
 *          'method'=> 'GET|POST|PATCH|PUT|DELETE',
 *          'url'=> '/',
 *          'controller'=> 'home',
 *          'action' => null,
 *      ];
 */
$routes = array();


//x-debug
$routes[] = [
    'name' => null,
    'method' => 'GET',
    'url' => '/public/index.php?XDEBUG_SESSION_START=netbeans-xdebug',
    'controller' => 'Home',
    'action' => null,
];
$routes[] = [
    'name' => null,
    'method' => 'GET',
    'url' => '/public/index.php?XDEBUG_SESSION_STOP_NO_EXEC=netbeans-xdebug',
    'controller' => 'Home',
    'action' => null,
];
//end x-debug

/*$testRoute = array();

$testRoute[] = ['/user/[int:id]/enable', ['controller' => 'user', 'action' => 'enable']];
$testRoute[] = ['/user/[int:id]/disable', ['controller' => 'user', 'action' => 'disable']];
$testRoute[] = ['/user/[int:id]/:action', ['controller' => 'user']];*/

$routes[] = [
    'name' => null,
    'method' => 'GET',
    'url' => '/',
    'controller' => 'Home',
    'action' => null,
];
$routes[] = [
    'name' => null,
    'method' => 'GET',
    'url' => '/error',
    'controller' => 'Error404',
    'action' => null,
];

$routes[] = [
    'name' => null,
    'method' => 'GET',
    'url' => '/login',
    'controller' => 'Login',
    'action' => null,
];

$routes[] = [
    'name' => null,
    'method' => 'GET',
    'url' => '/dologin',
    'controller' => 'Login',
    'action' => 'doLogin',
];

$routes[] = [
    'name' => null,
    'method' => 'GET',
    'url' => '/loginError',
    'controller' => 'Login',
    'action' => 'loginError',
];

$routes[] = [
    'name' => null,
    'method' => 'GET',
    'url' => '/logout',
    'controller' => 'Login',
    'action' => 'logout',
];

$routes[] = [
    'name' => null,
    'method' => 'GET',
    'url' => '/unauthorized',
    'controller' => 'Login',
    'action' => 'unauthorized',
];






$routes[] = [
    'name' => null,
    'method' => 'GET',
    'url' => '/user',
    'controller' => 'User',
    'action' => null,
];

$routes[] = [
    'name' => null,
    'method' => 'GET',
    'url' => '/user/[int:id]/enable',
    'controller' => 'User',
    'action' => 'enable',
];

$routes[] = [
    'name' => null,
    'method' => 'GET',
    'url' => '/user/[int:id]/disable',
    'controller' => 'User',
    'action' => 'disable',
];


$routes[] = [
    'name' => null,
    'method' => 'GET',
    'url' => '/user/[int:id]/delete',
    'controller' => 'User',
    'action' => 'delete',
];

$routes[] = [
    'name' => null,
    'method' => 'GET',
    'url' => '/user/[int:id]/changePassword',
    'controller' => 'User',
    'action' => 'changePassword',
];

$routes[] = [
    'name' => null,
    'method' => 'GET',
    'url' => '/user/[int:id]/modify',
    'controller' => 'User',
    'action' => 'modify',
];

/*$routes[] = [
    'name' => null,
    'method' => 'GET',
    'url' => '/prova/[int:id]/filter/[int:year]/[string:month]/[int:day]',
    'controller' => 'prova',
    'action' => 'filter',
];*/

$routes[] = [
    'name' => null,
    'method' => 'GET',
    'url' => '/protectedPage',
    'controller' => 'ProtectedPage',
    'action' => null,
];
