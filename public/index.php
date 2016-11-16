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

use Linna\Database\MysqlPDOAdapter;
use Linna\Database\Database;
use Linna\Session\Session;
//use Linna\Session\MemcachedSessionHandler;
use Linna\Http\Router;
use Linna\Http\FrontController;
use Linna\DI\DIResolver;
use Linna\Autoloader;

/**
 * Config File Section
 *
 */

//load configuration from config file
require dirname(__DIR__) . '/App/config/config.php';

//load routes.
require APP . '/config/routes.php';

//composer autoload
require ROOT . '/vendor/autoload.php';

/**
 * Autoloader Section
 *
 */

//linna autoloader, load application class
//for more information see http://www.php-fig.org/psr/psr-4/
$loader = new Autoloader();
$loader->register();

$loader->addNamespaces([
    ['App\Models', __DIR__ . '/../App/Models'],
    ['App\Views', __DIR__ . '/../App/Views'],
    ['App\Controllers', __DIR__ . '/../App/Controllers'],
    ['App\Templates', __DIR__ . '/../App/Templates'],
    ['App\Mappers', __DIR__ . '/../App/Mappers'],
    ['App\DomainObjects', __DIR__ . '/../App/DomainObjects'],
]);

/**
 * Memcached Section
 *
 */

//create memcached instance
//$memcached = new Memcached();
//connect to memcached server
//$memcached->addServer($options['memcached']['host'], $options['memcached']['port']);


/**
 * Database Section
 *
 */

//create adapter
$MysqlAdapter = new MysqlPDOAdapter(
    $options['pdo_mysql']['db_type'].':host='.$options['pdo_mysql']['host'].
    ';dbname='.$options['pdo_mysql']['db_name'].';charset='.$options['pdo_mysql']['charset'],
    $options['pdo_mysql']['user'],
    $options['pdo_mysql']['password'],
    array(\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ, \PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING)
);

//create data base object
$dataBase = new Database($MysqlAdapter);


/**
 * Dependency Injection Section
 *
 */

//create dipendency injection resolver
$DIResolver = new DIResolver();

//add unresolvable class to DIResolver
$DIResolver->cacheUnResolvable('\Linna\Database\Database', $dataBase);
//$DIResolver->cacheUnResolvable('\Memcached', $memcached);
//$DIResolver->cacheUnResolvable('\Linna\Session\MemcachedSessionHandler', new MemcachedSessionHandler($memcached, $options['session']['expire']));


/**
 * Session section
 *
 */

//resolve Session Handler
$sessionHandler = $DIResolver->resolve('\Linna\Session\DatabaseSessionHandler');
//$sessionHandler = $DIResolver->resolve('\Linna\Session\MemcachedSessionHandler');

//create session object
$session = new Session($options['session']);

//set session handler
//optional if not set, app will use php session standard storage
$session->setSessionHandler($sessionHandler);

//start session
$session->start();

//store session instance
$DIResolver->cacheUnResolvable('\Linna\Session\Session', $session);


/**
 * Router Section
 *
 */

//start router
$router = new Router($appRoutes, $options['router']);

//evaluate request uri and method
$router->validate($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

//get route
$route = $router->getRoute();

//get model linked to route
$routeModel = '\App\Models\\'.$route->getModel();
//get view linked to route
$routeView = '\App\Views\\'.$route->getView();
//get controller linked to route
$routeController = '\App\Controllers\\'.$route->getController();
    
//resolve model
$model = $DIResolver->resolve($routeModel);

//resolve view
$view = $DIResolver->resolve($routeView);

//resolve controller
$controller = $DIResolver->resolve($routeController);


/**
 * Front Controller section
 *
 */

//start front controller
$frontController = new FrontController($route, $model, $view, $controller);

//run
$frontController->run();

//get front controller response
$frontController->response();
