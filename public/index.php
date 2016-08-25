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
use \Leviu\Session\DatabaseSessionHandler;
use \Leviu\Session\Session;
use \Leviu\Http\Router;
//use \Leviu\Http\Dispatcher;
use \Leviu\Http\FrontController;
use \Leviu\Autoloader;

/*
 * Set a constant that holds the project's folder path, like "/var/www/".
 * DIRECTORY_SEPARATOR adds a slash to the end of the path
 */
define('ROOT', dirname(__DIR__).DIRECTORY_SEPARATOR);
/*
 * Set a constant that holds the project's "application" folder, like "/var/www/application".
 */
define('APP', ROOT.'App'.DIRECTORY_SEPARATOR);

//load configuration from config file
require APP.'/config/config.php';

//load routes. 
require APP.'/config/routes.php';

//load application class
//for more information see http://www.php-fig.org/psr/psr-4/
//require SRC . '/autoload.php';

require '../vendor/autoload.php';

$loader = new Autoloader();
$loader->register();

$loader->addNamespaces([
    //['App\Lib', __DIR__.'/../App/Library'],
    ['App\Models', __DIR__.'/../App/Models'],
    ['App\Views', __DIR__.'/../App/Views'],
    ['App\Controllers', __DIR__.'/../App/Controllers'],
    ['App\Templates', __DIR__.'/../App/Templates'],
    ['App\Mappers', __DIR__.'/../App/Mappers'],
    ['App\DomainObjects', __DIR__.'/../App/DomainObjects'],
]);

//initialize session
Session::$expire = 1800;
Session::$name = 'APP_SESSION';
//session handler, archive session in mysql :)
Session::$handler = new DatabaseSessionHandler();
//setting cookie parameter
Session::$cookieDomain = URL_DOMAIN;
Session::$cookiePath = URL_SUB_FOLDER;

$session = Session::getInstance();

$options = (object)[];
$options->base_path = URL_SUB_FOLDER;
$options->bad_route = 'E404';
//router
$router = new Router($testroutes, $options);
//get route
$route = $router->getRoute();


$options = (object)[];
$options->model = 'App\Models\\';
$options->view = 'App\Views\\';
$options->controller = 'App\Controllers\\';

$frontController = new FrontController($route, $options);
$frontController->response();



//config dispatcher
//Dispatcher::$controller404 = 'Error404';
//Dispatcher::$appNamespace = '\App\Controllers\\';

//dispatch route
//$dispatcher = new Dispatcher($route);

//$dispatcher->dispatch();
