<?php

/**
 * Linna App.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@tim.it>
 * @copyright (c) 2020, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

namespace Linna\App\Templates;

use Linna\Mvc\TemplateInterface;

/**
 * Raw Template.
 * Print raw strings to output buffer.
 */
class RawTemplate implements TemplateInterface
{
    /**
     * @var array Data for view
     */
    public $data = [];

    /**
     * Set the output data.
     *
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * Return void string.
     */
    public function getOutput(): string
    {
        \ob_start();

        echo \implode('', $this->data);

        return \ob_get_clean();
    }
}
