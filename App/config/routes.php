<?php

/**
 * App_mk0.
 *
 * This work would be a little PHP framework, a learn exercice. 
 * Work started from php MINI https://github.com/panique/mini good for understand how a MVC framework run :) 
 * I rewrote Router, Dispatcher, Controller and I added some new class like Model, View... etc for more flexibility  
 * 
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2015, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @version 0.1.0
 */
/**
 * @var array Contain declared routes
 *            $routes[] = [
 *            'name' => null,
 *            'method'=> 'GET|POST|PATCH|PUT|DELETE',
 *            'url'=> '/',
 *            'controller'=> 'home',
 *            'action' => null,
 *            ];
 */
$routes = array();

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
    'url' => '/(login|dologin|loginError|logout|unauthorized)',
    'controller' => 'Login',
    'action' => null,
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
    'url' => '/user/[id]/(disable|enable|delete|changePassword|modify)',
    'controller' => 'User',
    'action' => null,
];

$routes[] = [
    'name' => null,
    'method' => 'GET',
    'url' => '/protectedPage',
    'controller' => 'ProtectedPage',
    'action' => null,
];
