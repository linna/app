<?php

/**
 * Linna App.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2017, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

use Linna\Autoloader;
use Linna\DI\Container;
use Linna\Http\Router;
use Linna\Mvc\FrontController;
use Linna\Session\Session;

/*
 * Bootstrap and config.
 */

//composer autoload
require dirname(__DIR__).'/vendor/autoload.php';

//Set a constant that holds the project's folder path, like "/var/www/"
define('ROOT', dirname(dirname(__DIR__)));

//The domain, autodetected
define('URL_DOMAIN', $_SERVER['HTTP_HOST']);

//load configuration from config file
$config = include dirname(__DIR__).'/config/config.php';

//app
define('APP', ROOT.$config['app']['urlSubFolder'].'/');

//rewrite mode check for provide proper url.
$rewriteRouterPoint = '/';

if ($config['router']['rewriteMode'] === false) {
    $rewriteRouterPoint = '/index.php/';
}

//The final, auto-detected URL (build via the segments above). If you don't want to use auto-detection,
//then replace this line with full URL (and sub-folder) and a trailing slash.
define('URL', $config['app']['urlProtocol'].URL_DOMAIN.$config['app']['urlSubFolder'].$rewriteRouterPoint);
define('URL_STYLE', $config['app']['urlProtocol'].URL_DOMAIN.$config['app']['urlPublicFolder'].'/');

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

//get injections rules
$injectionsRules = include dirname(__DIR__).'/config/injections.php';

//create dipendency injection container
$container = new Container();
$container->setRules($injectionsRules);

/**
 * Session section.
 */

//create session object
$session = new Session($config['session']);

//start session
$session->start();

//store session instance
$container->set(Linna\Session\Session::class, $session);

/**
 * Router Section.
 */

//get route source
$routeSource = ($config['app']['useCompiledRoutes']) ? 'routes.php' : 'routes.compiled.php';

//get routes from source
$routes = include dirname(__DIR__)."/config/{$routeSource}";

//start router
$router = new Router($routes, $config['router']);

//evaluate request uri and method
$router->validate($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

//get route
$route = $router->getRoute()->toArray();

//resolve model
$model = $container->resolve($route['model']);

//resolve view
$view = $container->resolve($route['view']);

//resolve controller
$controller = $container->resolve($route['controller']);

/**
 * Front Controller section.
 */

//start front controller
$frontController = new FrontController($model, $view, $controller, $route['action'], $route['param']);

//run
$frontController->run();

//get front controller response
echo $frontController->response();
