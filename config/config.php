<?php

/**
 * Linna App.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@tim.it>
 * @copyright (c) 2020, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

return [

    'app' => [
        //protocol utilized [http://, https://]
        //default value set automatically
        'protocol'     => REQUEST_SCHEME.'://',
        //folder of the app, if app isn't in the web server root add a
        //directory (/app, /other/app) else insert a / (slash) as value
        //default value [/app]
        'subFolder'    => '/',
        //public folder of the app, starting from web server root
        //default value [/app/public]
        'publicFolder' => '/public',
        //.env file position, remember to add ../ if don't use an absolute path
        'envFile'      => '../.env',
        //name of the fallback route, indicate the path when router return a NullRoute
        //default /error/404
        'onNullRoute'  => '/error/404'
    ],

    'modules' => [
        //'10-storage-mysql',
        //'10-storage-pgsql',
        //'20-session-mysql',
        //'20-session-pgsql',
        '20-session',
        '30-router'
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
        'cookiePath'     => '/',
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
        'basePath'             => '/',
        //url rewriting
        //default [true]
        'rewriteMode'          => true,
        //part of the url that the router ignore when url rewriting is off
        'rewriteModeFalseEntryPoint' => '/index.php?',
    ],

    'pdo_pgsql' => [
        'dsn'      => 'pgsql:dbname=linna_db;host=localhost',
        'user'     => 'postgres',
        'password' => '',
        'options'  => [
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_PERSISTENT         => false,
        ],
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

    'password_algo' => PASSWORD_DEFAULT,

    'password_options' => [
        'cost' => 11
    ],
];
