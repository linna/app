<?php

/**
 * Linna App.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2018, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

use App\Helper\AppDotEnv;

use Linna\Authentication\Exception\AuthenticationException;
use Linna\Authorization\Exception\AuthorizationException;
use Linna\Container\Container;
use Linna\Mvc\FrontController;
use Linna\Session\Session;
use Linna\Router\Exception\RedirectException;
use Linna\Router\NullRoute;
use Linna\Router\Router;

//use Linna\Storage\StorageFactory;
//use Linna\Storage\ExtendedPDO;

/*
 * Bootstrap and config.
 */

//set a constant that hold the full path to app directory
\define('APP_DIR', \dirname(__DIR__));

//The domain, autodetected
\define('URL_DOMAIN', $_SERVER['HTTP_HOST']);

//composer autoload
require APP_DIR.'/vendor/autoload.php';

//load configuration from config file
$config = include APP_DIR.'/config/config.php';

//rewrite mode check for provide proper url.
$rewriteRouterPoint = ($config['router']['rewriteMode']) ? '' : $config['router']['rewriteModeOffRouter'];

//The final, auto-detected URL (build via the segments above). If you don't want to use auto-detection,
//then replace this line with full URL (and sub-folder) and a trailing slash.
\define('URL', $config['app']['protocol'].URL_DOMAIN.$config['app']['subFolder'].$rewriteRouterPoint);
\define('URL_PUBLIC', $config['app']['protocol'].URL_DOMAIN.$config['app']['publicFolder']);

/**
 * Dotenv Section
 */

//create .env instance
$env = new AppDotEnv();
//load .env file and override config values
$env->override($config['app']['envFile'], $config);

/**
 * Dependency Injection Section.
 */

//get injections rules
$injectionsRules = include APP_DIR.'/config/injections.php';

//create dipendency injection container
$container = new Container($injectionsRules);

/**
 * Persistent storage section.
 */

//pdo with PostgreSQL
//$storage = (new StorageFactory('pdo', $config['pdo_pgsql']))->get();
//store for dependency injection
//$container->set(ExtendedPDO::class, $storage);

//pdo with Mysql
//$storage = (new StorageFactory('pdo', $config['pdo_mysql']))->get();
//store for dependency injection
//$container->set(ExtendedPDO::class, $storage);

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

//get routes from source
$routes = include APP_DIR.'/config/routes.php';

//start router
$router = new Router($routes, $config['router']);

//evaluate request uri and method
$router->validate($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

//get route
$route = $router->getRoute();

//on NullRoute take action from config
if ($route instanceof NullRoute) {
    $router->validate($config['app']['onNullRoute'], 'GET');
    $route = $router->getRoute();
}

$container->set(Linna\Router\Route::class, $route);

/**
 * Model View Controller Section.
 */

//try to resolve mvc components, if AuthenticationException is throwed
//complete script with null objects
try {

    //start front controller
    $frontController = new FrontController(
        $container->resolve($route->model),
        $container->resolve($route->view),
        $container->resolve($route->controller),
        $route
    );
} catch (AuthorizationException | AuthenticationException | RedirectException $redirection) {

    //hope a valid route
    $where = $redirection->getPath();
    //validate
    $router->validate($where, 'GET');
    //and get
    $route = $router->getRoute();

    //overwrite previous store route
    $container->set(Linna\Router\Route::class, $route);

    //start a new front controller
    $frontController = new FrontController(
        $container->resolve($route->model),
        $container->resolve($route->view),
        $container->resolve($route->controller),
        $route
    );
} finally {

    //run
    $frontController->run();
    //output
    echo $frontController->response();
}
