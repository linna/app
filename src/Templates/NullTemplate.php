<?php

/**
 * Linna App.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2018, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

namespace App\Templates;

use Linna\Mvc\TemplateInterface;

/**
 * Null Template.
 */
class NullTemplate implements TemplateInterface
{
    /**
     * Set the output data.
     *
     * @param array $data
     */
    public function setData(array $data): void
    {
        unset($data);
    }

    /**
     * Return void string.
     */
    public function getOutput(): string
    {
        return '';
    }
}
