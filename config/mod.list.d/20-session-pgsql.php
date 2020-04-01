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

//create session object
$session = new Session($config['session']);

//switch to required session handler
//remind to uncomment proper section in Persistent storage section
$handler = $container->resolve(Linna\Session\PgsqlPdoSessionHandler::class);
$session->setSessionHandler($handler);

//start session
$session->start();

//store session instance
$container->set(Session::class, $session);
