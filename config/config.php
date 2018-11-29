<?php

/**
 * Linna App.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2018, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

return [

    'app' => [
        //protocol utilized [http://, https://]
        //default value [http://]
        'protocol'       => 'http://',
        //folder of the app, if app isn't in the web server root add a 
        //directory (/app, /other/app) else insert a / (slash) as value
        //default value [/app]
        'subFolder'      => '/app',
        //public folder of the app, starting from web server root
        //default value [/app/public]
        'publicFolder'   => '/app/public',
        //define if app use routes exported in static array [true, false]
        //default value [false]
        'compiledRoutes' => false,
        //.env file position, remember to add ../ if don't use an absolute path 
        'envFile'           => '../.env'
    ],

    'session' => [
        //session name
        //default [linna_session]
        'name'           => 'linna_session',
        //session expire time in seconds
        //default [1800]
        'expire'         => 1800,
        //cookie scope, domain and path where the cookie will be sent.
        //for cookieDomain the value of constant URL_DOMAIN is obtenined
        //from $_SERVER['HTTP_HOST'], for cookie path the value is equal to
        //app.subFolder value
        'cookieDomain'   => URL_DOMAIN, //do not change here
        'cookiePath'     => '/app',
        //cookie will sent only with https requests
        //default [false]
        'cookieSecure'   => false,
        //when set to true, cookie is inaccessible from Javascript
        //default [true]
        'cookieHttpOnly' => true,
    ],

    'router' => [
        //must be equal to app.subFolder, it represents the part of the path 
        //that the router ignore when check a route. Example '/app/user/delete/5' 
        //become '/user/delete/5' where the router subtract the basePath
        //default [/app]
        'basePath'             => '/app',
        //name of the fallback route
        //default [E404]
        'badRoute'             => 'E404',
        //url rewriting
        //default [true]
        'rewriteMode'          => true,
        //part of the url that the router ignore when url rewriting is off
        'rewriteModeOffRouter' => '/index.php?',
    ],

    'pdo_mysql' => [
        'dsn'      => 'mysql:host=localhost;dbname=linna_db;charset=utf8mb4',
        'user'     => 'root',
        'password' => '',
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
