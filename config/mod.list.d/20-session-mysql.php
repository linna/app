<?php

/**
 * Linna App.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@tim.it>
 * @copyright (c) 2020, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

use Linna\Session\Session;
use Linna\Session\MysqlPdoSessionHandler;

//create session object
$session = new Session(
    name:           $config['session']['name'],
    expire:         $config['session']['expire'],
    cookieDomain:   $config['session']['cookieDomain'],
    cookiePath:     $config['session']['cookiePath'],
    cookieSecure:   $config['session']['cookieSecure'],
    cookieHttpOnly: $config['session']['cookieHttpOnly']
);

//switch to required session handler
//remind to uncomment proper section in Persistent storage section
$handler = $container->resolve(MysqlPdoSessionHandler::class);
$session->setSessionHandler($handler);

//start session
$session->start();

//store session instance
$container->set(Session::class, $session);
