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

/**
 * Set a constant that holds the project's folder path, like "/var/www/".
 * DIRECTORY_SEPARATOR adds a slash to the end of the path
 */
define('ROOT', dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR);

/**
 * Set a constant that holds the project's core "application" folder, like "/var/www/html/app/".
 */
define('APP', ROOT . 'app' . DIRECTORY_SEPARATOR);

/**
 * The folder that is visible to public, users will only have access to that folder so nobody can have a look into
 * "/src" or other folder inside your application or call any other .php file than index.php inside "/public".
 */
define('URL_PUBLIC_FOLDER', 'public');

/**
 * The protocol. Don't change unless you know exactly what you do.
 */
define('URL_PROTOCOL', 'https://');

/**
 * The domain. Don't change unless you know exactly what you do.
 */
define('URL_DOMAIN', $_SERVER['HTTP_HOST']);

/**
 * The sub-folder. Leave it like it is, even if you don't use a sub-folder (then this will be just "/").
 */
define('URL_SUB_FOLDER', str_replace(URL_PUBLIC_FOLDER, '', dirname($_SERVER['SCRIPT_NAME'])));

//set this to false if is not possible to utilize rewrite engine of web server
define('REWRITE_ENGINE', true);

/**
 * The final, auto-detected URL (build via the segments above). If you don't want to use auto-detection,
 * then replace this line with full URL (and sub-folder) and a trailing slash.
 */
if (REWRITE_ENGINE === false) {
    define('URL', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER . '/index.php?/');
    define('URL_STYLE', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER . DIRECTORY_SEPARATOR . URL_PUBLIC_FOLDER . DIRECTORY_SEPARATOR);
} else {
    define('URL', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER);
    define('URL_STYLE', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER);
}


/**
 * Configuration options for linna-framework classes
 */

$options = [
    
    'session' => [
        'expire' => 1800,
        'cookieDomain' => URL_DOMAIN, //do not change here
        'cookiePath' => URL_SUB_FOLDER, //do not change here
        'cookieSecure' => false,
        'cookieHttpOnly' => true
    ],
    
    'router' => [
        'basePath' => URL_SUB_FOLDER, //do not change here
        'badRoute' => 'E404',
        'rewriteMode' => REWRITE_ENGINE //do not change here
    ],
    
    'pdo_mysql' => [
        'db_type' => 'mysql',
        'host' => 'localhost',
        'db_name' => 'test',
        'user' => 'root',
        'password' => 'cagiva',
        'charset' => 'utf8mb4'
    ],
    
    'memcached' =>[
        'host' => 'localhost',
        'port' => 11211
    ]
];
