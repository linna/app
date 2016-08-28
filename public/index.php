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

use \Leviu\Database\Database;
use \Leviu\Session\DatabaseSessionHandler;
use \Leviu\Session\Session;
use \Leviu\Http\Router;
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
    ['App\Models', __DIR__.'/../App/Models'],
    ['App\Views', __DIR__.'/../App/Views'],
    ['App\Controllers', __DIR__.'/../App/Controllers'],
    ['App\Templates', __DIR__.'/../App/Templates'],
    ['App\Mappers', __DIR__.'/../App/Mappers'],
    ['App\DomainObjects', __DIR__.'/../App/DomainObjects'],
]);


$dbase = Database::connect();

/*
$options = (object)[];
$options->expire = 1800;
$options->name = 'APP_SESSION';
$options->cookieDomain = URL_DOMAIN;
$options->cookiePath = URL_SUB_FOLDER;
*/

Session::setSessionHandler(new DatabaseSessionHandler($dbase));

Session::withOptions(array(
        'expire' => 1800,
        'cookieDomain' => URL_DOMAIN,
        'cookiePath' => URL_SUB_FOLDER,
        'cookieSecure' => false,
        'cookieHttpOnly' => true
    ));

$session = Session::getInstance();

    
$options = (object)[];
$options->base_path = URL_SUB_FOLDER;
$options->bad_route = 'E404';

$router = new Router($_SERVER['REQUEST_URI'], $testroutes, $options);
$route = $router->getRoute();



$frontController = new FrontController($route, array(
        'modelNamespace' => 'App\Models\\',
        'viewNamespace' => 'App\Views\\',
        'controllerNamespace' => 'App\Controllers\\',
    ));

$frontController->response();
