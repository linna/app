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

use Linna\Database\MysqlPDOAdapter;
use Linna\Database\Database;
use Linna\Session\Session;
//use Linna\Session\MemcachedSessionHandler;
use Linna\Http\Router;
use Linna\Http\FrontController;
use Linna\DI\DIResolver;
use Linna\Autoloader;

/**
 * Bootstrap and config
 * 
 */


//Set a constant that holds the project's folder path, like "/var/www/"
define('ROOT', dirname(dirname(__DIR__)));

//The domain, autodetected
define('URL_DOMAIN', $_SERVER['HTTP_HOST']);

//load configuration from config file
require dirname(__DIR__) . '/config/config.php';

//load routes.
require dirname(__DIR__) . '/config/routes.php';

//composer autoload
require dirname(__DIR__) . '/vendor/autoload.php';

//app 
define('APP', ROOT . $options['app']['urlSubFolder']);

//The final, auto-detected URL (build via the segments above). If you don't want to use auto-detection,
//then replace this line with full URL (and sub-folder) and a trailing slash.
if ($options['router']['rewriteMode'] === false) {
    define('URL', $options['app']['urlProtocol'] . URL_DOMAIN . $options['app']['urlSubFolder'] . 'index.php?/');
    define('URL_STYLE', $options['app']['urlProtocol'] . URL_DOMAIN . $options['app']['urlSubFolder'] . '/' . $options['app']['urlPublicFolder'] . '/');
} else {
    define('URL', $options['app']['urlProtocol'] . URL_DOMAIN . $options['app']['urlSubFolder']);
    define('URL_STYLE', $options['app']['urlProtocol'] . URL_DOMAIN . $options['app']['urlSubFolder']);
}


/**
 * Autoloader Section
 *
 */

//linna autoloader, load application class
//for more information see http://www.php-fig.org/psr/psr-4/
$loader = new Autoloader();
$loader->register();

$loader->addNamespaces([
    ['App\Models', APP . 'src/Models'],
    ['App\Views', APP . 'src/Views'],
    ['App\Controllers', APP . 'src/Controllers'],
    ['App\Templates', APP . 'src/Templates'],
    ['App\Mappers', APP . 'src/Mappers'],
    ['App\DomainObjects', APP . 'src/DomainObjects'],
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
