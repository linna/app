<?php

/**
 * Linna App.
 *
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2017, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */

//use Linna\Storage\MysqlPdoAdapter;
//use Linna\Storage\MysqliAdapter;
//use Linna\Storage\MongoDbAdapter;
use Linna\Autoloader;
//use Linna\Session\MemcachedSessionHandler;
use Linna\DI\Resolver;
use Linna\Http\FrontController;
use Linna\Http\Router;
use Linna\Session\Session;

/*
 * Bootstrap and config
 *
 */

//Set a constant that holds the project's folder path, like "/var/www/"
define('ROOT', dirname(dirname(__DIR__)));

//The domain, autodetected
define('URL_DOMAIN', $_SERVER['HTTP_HOST']);

//load configuration from config file
require dirname(__DIR__).'/config/config.php';

//load routes.
require dirname(__DIR__).'/config/routes.php';

//load injections rules.
require dirname(__DIR__).'/config/injections.php';

//composer autoload
require dirname(__DIR__).'/vendor/autoload.php';

//app
define('APP', ROOT.$options['app']['urlSubFolder']);

//The final, auto-detected URL (build via the segments above). If you don't want to use auto-detection,
//then replace this line with full URL (and sub-folder) and a trailing slash.
if ($options['router']['rewriteMode'] === false) {
    define('URL', $options['app']['urlProtocol'].URL_DOMAIN.$options['app']['urlSubFolder'].'index.php?index=/');
    define('URL_STYLE', $options['app']['urlProtocol'].URL_DOMAIN.$options['app']['urlSubFolder'].'/'.$options['app']['urlPublicFolder'].'/');
} else {
    define('URL', $options['app']['urlProtocol'].URL_DOMAIN.$options['app']['urlSubFolder']);
    define('URL_STYLE', $options['app']['urlProtocol'].URL_DOMAIN.$options['app']['urlSubFolder']);
}

/**
 * Autoloader Section.
 */

//linna autoloader, load application class
//for more information see http://www.php-fig.org/psr/psr-4/
$loader = new Autoloader();
$loader->register();

$loader->addNamespaces([
    ['App\Models', APP.'src/Models'],
    ['App\Views', APP.'src/Views'],
    ['App\Controllers', APP.'src/Controllers'],
    ['App\Templates', APP.'src/Templates'],
    ['App\Mappers', APP.'src/Mappers'],
    ['App\DomainObjects', APP.'src/DomainObjects'],
]);

/**
 * Dependency Injection Section.
 */

//create dipendency injection resolver
$resolver = new Resolver();
$resolver->rules($injectionsRules);

/**
 * Memcached Section.
 */

//create memcached instance
//$memcached = new Memcached();

////connect to memcached server
//$memcached->addServer($options['memcached']['host'], $options['memcached']['port']);

////add unresolvable class to DIResolver
//$resolver->cache('\Memcached', $memcached);
//$resolver->cache('\Linna\Session\MemcachedSessionHandler', new MemcachedSessionHandler($memcached, $options['session']['expire']));

/**
 * Storage Section.
 */

//create Mysql Pdo adapter
//$mysqlPdoAdapter = new MysqlPdoAdapter(
//    $options['pdo_mysql']['dsn'],
//    $options['pdo_mysql']['user'],
//    $options['pdo_mysql']['password'],
//    [\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ, \PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING]
//);

//create Mysql Improved extension adapter
//$mysqliAdapter = new MysqliAdapter(
//    $options['mysqli']['host'],
//    $options['mysqli']['password'],
//    $options['mysqli']['user'],
//    $options['mysqli']['database'],
//    $options['mysqli']['port']
//);

//create Mongodb adapter
//$mongoDbAdapter = new MongoDbAdapter($options['mongo_db']['uri']);

//add unresolvable class to DIResolver
//$DIResolver->cache('\Linna\Storage\MysqlPdoAdapter', $mysqlPdoAdapter);
//$DIResolver->cache('\Linna\Storage\MysqliAdapter', $mysqliAdapter);
//$DIResolver->cache('\Linna\Storage\MongoDbAdapter', $mongoDbAdapter);

/**
 * Session section.
 */

//resolve Session Handler
$sessionHandler = $resolver->resolve('\Linna\Session\MysqlPdoSessionHandler');
//$sessionHandler = $DIResolver->resolve('\Linna\Session\MemcachedSessionHandler');

//create session object
$session = new Session($options['session']);

//set session handler
//optional if not set, app will use php session standard storage
$session->setSessionHandler($sessionHandler);

//start session
$session->start();

//store session instance
$resolver->cache('\Linna\Session\Session', $session);

/**
 * Router Section.
 */

//start router
$router = new Router($routes, $options['router']);

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
$model = $resolver->resolve($routeModel);

//resolve view
$view = $resolver->resolve($routeView);

//resolve controller
$controller = $resolver->resolve($routeController);

/**
 * Front Controller section.
 */

//start front controller
$frontController = new FrontController($route, $model, $view, $controller);

//run
$frontController->run();

//get front controller response
$frontController->response();
