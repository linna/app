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
use App\Helper\AppDotEnv;
use App\Models\NullModel;
use App\Templates\NullTemplate;
use App\Views\NullView;

use Linna\Authentication\Exception\AuthenticationException;
use Linna\Container\Container;
use Linna\Mvc\FrontController;
use Linna\Session\Session;
use Linna\Router\Exception\RedirectException;
use Linna\Router\NullRoute;
use Linna\Router\Router;

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
} catch (RedirectException $redirection) {

    //hope a valid route
    $where = $redirection->getPath();
    //validate
    $router->validate($where, 'GET');
    //and get
    $route = $router->getRoute();
    //start a new front controller
    $frontController = new FrontController(
        $container->resolve($route->model),
        $container->resolve($route->view),
        $container->resolve($route->controller),
        $route
    );
} catch (AuthenticationException $e) {

    //create instances off null objects
    $model = new NullModel();

    $frontController = new FrontController(
        $model,
        new NullView($model, new NullTemplate()),
        new NullController($model),
        new NullRoute()
    );
} finally {

    //run
    $frontController->run();
    //output
    echo $frontController->response();
}
