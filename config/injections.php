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
    '\Linna\Storage\PdoStorage' => [
        0 => $options['pdo_mysql'],
    ],
    '\Linna\Auth\Password' => [
        0 => $options['password'],
    ],
];
