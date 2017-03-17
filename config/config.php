<?php

/**
 * Linna App.
 *
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2017, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
$options = [

    'app' => [
        'urlProtocol'     => 'http://',
        'urlSubFolder'    => '/app/', // es /var/www/html/app/
        'urlPublicFolder' => 'public', // es /var/www/html/app/public
    ],

    'session' => [
        'expire'         => 1800,
        'cookieDomain'   => URL_DOMAIN, //do not change here
        'cookiePath'     => '/app/', //equal to urlSubFolder
        'cookieSecure'   => false,
        'cookieHttpOnly' => true,
    ],

    'router' => [
        'basePath'    => '/app/', //equal to urlSubFolder
        'badRoute'    => 'E404',
        'rewriteMode' => true,
    ],

    'pdo_mysql' => [
        'dsn'      => 'mysql:host=localhost;dbname=linna_db;charset=utf8mb4',
        'user'     => 'root',
        'password' => 'cagiva',
        'options'  => [\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ, \PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING],
    ],

    'mysqli' => [
        'host'     => '127.0.0.1',
        'user'     => 'root',
        'password' => 'cagiva',
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
