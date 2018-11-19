<?php

/**
 * Linna App.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2018, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

use App\Controllers\NullController;
use App\Models\NullModel;
use App\Templates\NullTemplate;
use App\Views\NullView;

use Linna\Autoloader;
use Linna\Authentication\Exception\AuthenticationException;
use Linna\Container\Container;
use Linna\Mvc\FrontController;
use Linna\Session\Session;
use Linna\Router\Router;

/*
 * Bootstrap and config.
 */

//set a constant that hold the full path to app directory
define('APP_DIR', dirname(__DIR__));

//The domain, autodetected
define('URL_DOMAIN', $_SERVER['HTTP_HOST']);

//composer autoload
require APP_DIR.'/vendor/autoload.php';

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
$container = new Container($injectionsRules);

/**
 * Session section.
 */

//create session object
$session = new Session($config['session']);

//start session
$session->start();

//store session instance
$container->set(Session::class, $session);

/**
 * Router Section.
 */

//get route source
$routeSource = ($config['app']['compiledRoutes']) ? 'routes.compiled.php' : 'routes.php';

//get routes from source
$routes = include APP_DIR."/config/{$routeSource}";

//start router
$router = new Router($routes, $config['router']);

//evaluate request uri and method
$router->validate($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

//get route
$route = $router->getRoute()->toArray();

/**
 * Model View Controller Section.
 */

//try to resolve mvc components, if AuthenticationException is throwed
//complete script with null objects
try {
    //get route
    $route = $router->getRoute()->toArray();
    //resolve model
    $model = $container->resolve($route['model']);
    //resolve view
    $view = $container->resolve($route['view']);
    //resolve controller
    $controller = $container->resolve($route['controller']);
    //start front controller
    $frontController = new FrontController($model, $view, $controller, $route['action'], $route['param']);
    //run
    $frontController->run();
} catch (AuthenticationException $e) {
    //create instances off null objects
    $model = new NullModel();
    $view = new NullView($model, new NullTemplate());
    $controller = new NullController($model);
    //void route
    $route = ['action' => '', 'param' => []];
    //start front controller
    $frontController = new FrontController($model, $view, $controller, $route['action'], $route['param']);
    //run
    $frontController->run();
} finally {
    echo $frontController->response();
}
