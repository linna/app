<?php

/**
 * Linna App.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@tim.it>
 * @copyright (c) 2020, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

namespace App\Templates;

use Linna\Mvc\TemplateInterface;

/**
 * Json Template.
 */
class JsonTemplate implements TemplateInterface
{
    /**
     * @var object Data for view
     */
    public $data;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->data = (object) null;
    }

    /**
     * Set the output data.
     *
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = (object) $data;
    }

    /**
     * Return data in json format.
     */
    public function getOutput(): string
    {
        return \json_encode($this->data);
    }
}
