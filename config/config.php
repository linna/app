<?php

/**
 * Linna App.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2017, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

return [

    'app' => [
        //protocol utilized [http://, https://]
        'protocol'       => 'http://',
        //folder of the app, if app isn't in the web server root
        'subFolder'      => '/app',
        //public folder of the app
        'publicFolder'   => '/app/public',
        //define if app use routes exported in static array [true, false]
        'compiledRoutes' => false
    ],

    'session' => [
        'name'           => env('SESSION_NAME', 'linna_session'),
        'expire'         => 1800,
        'cookieDomain'   => URL_DOMAIN, //do not change here
        'cookiePath'     => '/app', //equal to urlSubFolder
        'cookieSecure'   => false,
        'cookieHttpOnly' => true,
    ],

    'router' => [
        'basePath'             => '/app', //equal to urlSubFolder
        'badRoute'             => 'E404',
        'rewriteMode'          => true,
        'rewriteModeOffRouter' => '/index.php?',
    ],

    'pdo_mysql' => [
        'dsn'      => 'mysql:host=' . env('DB_HOST', 'localhost') . ';dbname=' . env('DB_NAME', 'linna_db') . ';charset=utf8mb4',
        'user'     => env('DB_USER', 'root'),
        'password' => env('DB_PASSWORD', 'cagiva'),
        'options'  => [
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_PERSISTENT         => false,
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci',
        ],
    ],

    'mysqli' => [
        'host'     => env('DB_HOST', 'localhost'),
        'user'     => env('DB_USER', 'root'),
        'password' => env('DB_PASSWORD', 'cagiva'),
        'database' => env('DB_NAME', 'linna_db'),
        'port'     => 3306,
    ],

    'mongo_db' => [
        'uri'           => 'mongodb://localhost:27017',
        'uriOptions'    => [],
        'driverOptions' => [],
    ],

    'memcached' => [
        'host' => env('MEMCACHED_HOST', 'localhost'),
        'port' => env('MEMCACHED_PORT', '11211'),
    ],

    'password' => [
        'cost' => 11,
        'algo' => PASSWORD_DEFAULT,
    ],
];
