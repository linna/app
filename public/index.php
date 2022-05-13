<?php

/**
 * Linna App.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@tim.it>
 * @copyright (c) 2020, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

use Linna\App\Helper\AppDotEnv;

use Linna\Authentication\Exception\AuthenticationException;
use Linna\Authorization\Exception\AuthorizationException;
use Linna\Container\Container;
use Linna\Mvc\ModelViewController;
use Linna\Router\Exception\RedirectException;
use Linna\Router\NullRoute;

/*
 * Bootstrap and config.
 */

//set a constant that hold the full path to app directory
\define('APP_DIR', \dirname(__DIR__));

//the domain, autodetected
\define('URL_DOMAIN', $_SERVER['HTTP_HOST']);

//the request scheme (http|https)
\define('REQUEST_SCHEME', (isset($_SERVER['HTTPS']) ? 'https' : 'http'));

//the configuration file
\define('CONFIG', APP_DIR.'/config/config.php');

//the local configuration file
//use this for local development purpose
\define('CONFIG_LOCAL', APP_DIR.'/config/config.local.php');

//composer autoload
require APP_DIR.'/vendor/autoload.php';

//load configuration from config file
$config = (\file_exists(CONFIG_LOCAL)) ? include CONFIG_LOCAL : include CONFIG;

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
 * Load modules from config/mod.list.d
 *
 * Default loads
 * - session
 * - router
 *
 * Check config.php for other modules.
 */
\sort($config['modules']);

foreach ($config['modules'] as $module) {
    include APP_DIR."/config/mod.list.d/{$module}.php";
}

/**
 * Model View Controller Section.
 */

//try to resolve mvc components, if AuthenticationException is throwed
//complete script with null objects
try {

    //start front controller
    $frontController = new ModelViewController(
        $container->resolve($route->model),
        $container->resolve($route->view),
        $container->resolve($route->controller),
        $route
    );
} catch (AuthorizationException | AuthenticationException | RedirectException $redirection) {

    //hope a valid route else go to unauthorized page
    $where = $redirection->getPath();
    $where = ($where !== '' ? $where : '/error/401');

    //validate
    $router->validate($where, 'GET');
    //and get
    $route = $router->getRoute();

    //something went very wrong beacause a unknown route passed on code to Authentication or Redirect exception
    if ($route instanceof NullRoute) {
        throw new \LogicException('Wrong route passed to AuthenticationException or RedirectException constructor.');
    }

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
