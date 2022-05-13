<?php

/**
 * Linna App.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@tim.it>
 * @copyright (c) 2020, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

use Linna\Container\Container;

return [
    Container::RULE_ARGUMENT => [
        Linna\Authentication\Password::class => [
            0 => $config['password_algo'],
            1 => $config['password_options']
        ],
        Linna\App\Templates\HtmlTemplate::class => [
            0 => APP_DIR.'/src/Linna/App/Templates/_pages/',
            1 => URL_PUBLIC.'/css/',
            2 => URL_PUBLIC.'/js/'
        ]
    ]
];
