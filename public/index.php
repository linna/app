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
define('APP', ROOT.$options['app']['urlSubFolder'].'/');

//rewrite mode check for provide proper url.
$rewriteRouterPoint = '/';

if ($options['router']['rewriteMode'] === false) {
    $rewriteRouterPoint = '/index.php/';
}

//The final, auto-detected URL (build via the segments above). If you don't want to use auto-detection,
//then replace this line with full URL (and sub-folder) and a trailing slash.
define('URL', $options['app']['urlProtocol'].URL_DOMAIN.$options['app']['urlSubFolder'].$rewriteRouterPoint);
define('URL_STYLE', $options['app']['urlProtocol'].URL_DOMAIN.$options['app']['urlPublicFolder'].'/');

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

//create dipendency injection container
$container = new Container();
$container->setRules($injectionsRules);

/**
 * Session section.
 */

//create session object
$session = new Session($options['session']);

//start session
$session->start();

//store session instance
$container->set(Linna\Session\Session::class, $session);

/**
 * Router Section.
 */

//start router
$router = new Router($routes, $options['router']);

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
