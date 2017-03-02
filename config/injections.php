<?php

/**
 * Linna App.
 *
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2017, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
$injectionsRules = [
    '\Linna\Storage\MysqlPdoAdapter' => [
        0 => $options['pdo_mysql']['dsn'],
        1 => $options['pdo_mysql']['user'],
        2 => $options['pdo_mysql']['password'],
        3 => $options['pdo_mysql']['options'],
    ],
    '\Linna\Auth\Password' => [
        0 => $options['password'],
    ],
];
