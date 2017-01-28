<?php

/**
 * Linna App
 *
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2017, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 *
 */

namespace App\Templates;

use Linna\Mvc\TemplateInterface;

/**
 * Json Template
 *
 */
class JsonTemplate implements TemplateInterface
{
    /**
     * @var object $data Data for view
     */
    public $data;
    
    /**
     * Constructor
     *
     */
    public function __construct()
    {
        $this->data = (object) null;
    }
    
    /**
     * Return data in json format
     *
     */
    public function output()
    {
        echo json_encode($this->data);
    }
}
