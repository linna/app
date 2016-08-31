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

$testroutes = array();

$testroutes[] = [
    'name' => 'Home',
    'method' => 'GET',
    'url' => '/',
    'model' => 'HomeModel',
    'view' => 'HomeView',
    'controller' => 'HomeController',
    'action' => null,
];

$testroutes[] = [
    'name' => 'E404',
    'method' => 'GET',
    'url' => '/error',
    'model' => 'E404Model',
    'view' => 'E404View',
    'controller' => 'E404Controller',
    'action' => null,
];

$testroutes[] = [
    'name' => 'User',
    'method' => 'GET',
    'url' => '/user',
    'model' => 'UserModel',
    'view' => 'UserView',
    'controller' => 'UserController',
    'action' => null,
];

$testroutes[] = [
    'name' => null,
    'method' => 'GET',
    'url' => '/user/[id]/(disable|enable|delete|changePassword|modify)',
    'model' => 'UserModel',
    'view' => 'UserView',
    'controller' => 'UserController',
    'action' => null,
];

$testroutes[] = [
    'name' => null,
    'method' => 'GET',
    'url' => '/login',
    'model' => 'LoginModel',
    'view' => 'LoginView',
    'controller' => 'LoginController',
    'action' => null,
];

$testroutes[] = [
    'name' => null,
    'method' => 'GET',
    'url' => '/(dologin|logout)',
    'model' => 'LoginModel',
    'view' => 'LoginView',
    'controller' => 'LoginController',
    'action' => null,
];