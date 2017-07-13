<?php

/**
 * Linna App.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2017, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

$injectionsRules = [
    Linna\Storage\PdoStorage::class => [
        0 => $options['pdo_mysql'],
    ],
    Linna\Auth\Password::class => [
        0 => $options['password'],
    ],
];
