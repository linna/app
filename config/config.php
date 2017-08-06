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
        'name'           => 'linna_session',
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
        'dsn'      => 'mysql:host=localhost;dbname=linna_db;charset=utf8mb4',
        'user'     => 'root',
        'password' => 'cagiva',
        'options'  => [
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_PERSISTENT         => false,
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci',
        ],
    ],

    'mysqli' => [
        'host'     => '127.0.0.1',
        'user'     => '',
        'password' => '',
        'database' => 'linna_db',
        'port'     => 3306,
    ],

    'mongo_db' => [
        'uri'           => 'mongodb://localhost:27017',
        'uriOptions'    => [],
        'driverOptions' => [],
    ],

    'memcached' => [
        'host' => 'localhost',
        'port' => 11211,
    ],

    'password' => [
        'cost' => 11,
        'algo' => PASSWORD_DEFAULT,
    ],
];
