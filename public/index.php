<?php

/**
 * App
 *
 * 
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2016, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 *
 */

use \Linna\Database\Database;
use \Linna\Session\DatabaseSessionHandler;
use \Linna\Session\Session;
use \Linna\Http\Router;
use \Linna\Http\FrontController;
use \Linna\Autoloader;

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
    ['App\Models', __DIR__.'/../App/Models'],
    ['App\Views', __DIR__.'/../App/Views'],
    ['App\Controllers', __DIR__.'/../App/Controllers'],
    ['App\Templates', __DIR__.'/../App/Templates'],
    ['App\Mappers', __DIR__.'/../App/Mappers'],
    ['App\DomainObjects', __DIR__.'/../App/DomainObjects'],
]);


$dbase = Database::connect();

Session::setSessionHandler(new DatabaseSessionHandler($dbase));

Session::withOptions(array(
        'expire' => 1800,
        'cookieDomain' => URL_DOMAIN,
        'cookiePath' => URL_SUB_FOLDER,
        'cookieSecure' => false,
        'cookieHttpOnly' => true
    ));

$session = Session::getInstance();


$router = new Router($_SERVER['REQUEST_URI'], $testroutes, array(
        'basePath' => URL_SUB_FOLDER,
        'badRoute' => 'E404'
    ));

$frontController = new FrontController($router->getRoute(), array(
        'modelNamespace' => 'App\Models\\',
        'viewNamespace' => 'App\Views\\',
        'controllerNamespace' => 'App\Controllers\\',
    ));

$frontController->response();
