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
    Linna\Storage\PdoStorage::class => [
        0 => $config['pdo_mysql'],
    ],
    Linna\Auth\Password::class => [
        0 => $config['password'],
    ],
    App\Templates\HtmlTemplate::class => [
        0 => APP_DIR.'/src/Templates/_pages',
        1 => URL_STYLE,
    ]
];
