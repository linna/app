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

//set a constant that hold the full path to app directory
define('APP_DIR', dirname(__DIR__));

//The domain, autodetected
define('URL_DOMAIN', $_SERVER['HTTP_HOST']);

//composer autoload
require APP_DIR.'/vendor/autoload.php';

//Load environment variables from .env file
(new Dotenv\Dotenv(APP_DIR))->load();

//load configuration from config file
$config = include APP_DIR.'/config/config.php';

//rewrite mode check for provide proper url.
$rewriteRouterPoint = ($config['router']['rewriteMode']) ? '' : $config['router']['rewriteModeOffRouter'];

//The final, auto-detected URL (build via the segments above). If you don't want to use auto-detection,
//then replace this line with full URL (and sub-folder) and a trailing slash.
define('URL', $config['app']['protocol'].URL_DOMAIN.$config['app']['subFolder'].$rewriteRouterPoint);
define('URL_STYLE', $config['app']['protocol'].URL_DOMAIN.$config['app']['publicFolder'].'/');

/**
 * Autoloader Section.
 */

//linna autoloader, load application class
//for more information see http://www.php-fig.org/psr/psr-4/
$loader = new Autoloader();
$loader->register();

$loader->addNamespaces([
    ['App\Models', APP_DIR.'/src/Models'],
    ['App\Views', APP_DIR.'/src/Views'],
    ['App\Controllers', APP_DIR.'/src/Controllers'],
    ['App\Templates', APP_DIR.'/src/Templates'],
    ['App\Mappers', APP_DIR.'/src/Mappers'],
    ['App\DomainObjects', APP_DIR.'/src/DomainObjects'],
]);

/**
 * Dependency Injection Section.
 */

//get injections rules
$injectionsRules = include APP_DIR.'/config/injections.php';

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
$routeSource = ($config['app']['compiledRoutes']) ? 'routes.php' : 'routes.compiled.php';

//get routes from source
$routes = include APP_DIR."/config/{$routeSource}";

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
