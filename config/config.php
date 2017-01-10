<?php

/**
 * Linna App
 *
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2017, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 *
 */

$options = [
    
    'app' => [
        'urlProtocol' => 'http://',
        'urlSubFolder' => '/app/', // es /var/www/html/app/
        'urlPublicFolder' => 'public' // es /var/www/html/app/public
    ],
    
    'session' => [
        'expire' => 1800,
        'cookieDomain' => URL_DOMAIN, //do not change here
        'cookiePath' => '/app/', //equal to urlSubFolder
        'cookieSecure' => false,
        'cookieHttpOnly' => true
    ],
    
    'router' => [
        'basePath' => '/app/', //equal to urlSubFolder
        'badRoute' => 'E404',
        'rewriteMode' => true
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